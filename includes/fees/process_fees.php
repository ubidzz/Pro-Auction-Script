<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');
if (!defined('FEES_PATH')) exit('Access denied');

class process_fees
{
	var $ASCII_RANGE;
	var $data;
	var $fee_types;
	private $system;
	private $paypalAddress = 'www.paypal.com';
	private $httpsConnections = false;
	private $customCode;
	private $DBPrefix;
	private $database;
	private $user;
	private $sendEmail;
	private $security;

	function __construct()
	{
		global $system, $DBPrefix, $db, $user, $send_email, $security;
		
		$this->system = $system;
		$this->DBPrefix = $DBPrefix;
		$this->database = $db;
		$this->user = $user;
		$this->sendEmail = $send_email;
		$this->security = $security;

		$this->customCode = $this->system->SETTINGS['customcode'];
		$this->httpsConnections = $this->system->SETTINGS['https'] == 'y' ? true : false;
		$this->paypalAddress = $this->system->SETTINGS['paypal_sandbox'] == 'y' ? 'www.sandbox.paypal.com' : 'www.paypal.com';

		$this->ASCII_RANGE = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$this->fee_types = $this->get_fee_types();
	}

	public function get_fee_types()
	{
		$query = "SELECT type FROM " . $this->DBPrefix . "fees GROUP BY type";
		$this->database->direct_query($query);
		$fee_types = array();
		while ($row = $this->database->result())
		{
			$fee_types[] = $row;
		}
		return $fee_types;
	}

	public function add_to_account($text, $type, $amount)
	{
		$date_values = date('z|W|m|Y', $this->system->CTIME);
		$date_values = explode('|', $date_values);
		$query = "INSERT INTO " . $this->DBPrefix . "accounts VALUES (NULL, :user_nick, :user_name, :user_text, :user_type, :user_time, :user_amount, " . $date_values[0] . ", " . $date_values[1] . ", " . $date_values[2] . ", " . $date_values[3] . ")";
		$params = array(
			array(':user_nick', $this->user->user_data['nick'], 'str'),
			array(':user_name', $this->user->user_data['name'], 'str'),
			array(':user_text', $text, 'str'),
			array(':user_type', $type, 'str'),
			array(':user_time', $this->system->CTIME, 'int'),
			array(':user_amount', $amount, 'int')
		);
		$this->database->query($query, $params);
	}
	
	public function hmac($key, $data)
	{
		// RFC 2104 HMAC implementation for php.
		// Creates an md5 HMAC.
		// Eliminates the need to install mhash to compute a HMAC
		// Hacked by Lance Rushing

		$b = 64; // byte length for md5
		if (strlen($key) > $b)
		{
			$key = pack("H*", md5($key));
		}
		$key  = str_pad($key, $b, chr(0x00));
		$ipad = str_pad('', $b, chr(0x36));
		$opad = str_pad('', $b, chr(0x5c));
		$k_ipad = $key ^ $ipad ;
		$k_opad = $key ^ $opad;

		return md5($k_opad  . pack("H*", md5($k_ipad . $data)));
	}
	
	public function paypal_validate()
	{		
		// we ensure that the txn_id (transaction ID) contains only ASCII chars...
		$pos = strspn($this->data['txn_id'], $this->ASCII_RANGE);
		$len = strlen($this->data['txn_id']);

		if ($pos != $len)
		{
			return;
		}

		//validate payment
		$req = 'cmd=_notify-validate';
		foreach ($this->data as $key => $value)
		{
			// Handle escape characters, which depends on setting of magic quotes  
			$value = urlencode($value);
			$req .= '&' . $key . '=' . $value;
		}

		// Post back to PayPal system to validate
		$header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Host: " . $this->paypalAddress . "\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n";
		$header .= "Connection: close\r\n\r\n";  
		
		if ($this->httpsConnections)
		{
			// connect via SSL
			$fp = fsockopen ('ssl://' . $this->paypalAddress, 443, $errno, $errstr, 30);
		}
		else
		{
			// connect via HTTP
			$fp = fsockopen ($this->paypalAddress, 80, $errno, $errstr, 30);
		}
		if (!$fp)
		{
			$error_output = $errstr . ' (' . $errno . ')';
		}
		else
		{
			// Assign posted variables to local variables
			$payment_status = $this->data['payment_status'];
			$payment_amount = floatval ($this->data['mc_gross']);
			list($custom_id, $fee_type) = explode($this->customCode, $this->data['custom']);
			fputs ($fp, $header . $req);

			while (!feof($fp))
			{
				$resl = trim(fgets ($fp, 1024));

				if (strcmp ($resl, 'VERIFIED') == 0)
				{
					// We can do various checks to make sure nothing is wrong and   
					// that txn_id has not been previously processed
					if ($payment_status == 'Completed')
					{
						// everything seems to be OK
						self::process_callback($custom_id, $fee_type, $payment_amount);
					}
				}
				elseif (strcmp ($resl, 'INVALID') == 0)
				{
					// payment failed
					fclose ($fp);
					exit;
				}
			}
			fclose ($fp);
		}
	}
	 	
	public function authnet_validate()
	{
		$payment_amount = floatval ($this->data['x_amount']);
		list($custom_id, $fee_type) = explode($this->customCode, $this->data['custom']);

		if ($this->data['x_response_code'] == 1)
		{
			self::process_callback($custom_id, $fee_type, $payment_amount);
		}
		else
		{
			$redirect_url = $this->system->SETTINGS['siteurl'] . 'validate.php?fail';
			header('location: '. $redirect_url);
			exit;
		}
	}

	public function worldpay_validate()
	{
		$payment_amount = floatval ($this->data['amount']);
		list($custom_id, $fee_type) = explode($this->customCode,$this->data['cartId']);

		if ($this->data['transStatus'] == 'Y')
		{
			self::process_callback($custom_id, $fee_type, $payment_amount);
		}
		else
		{
			$redirect_url = $this->system->SETTINGS['siteurl'] . 'validate.php?fail';
			header('location: '. $redirect_url);
			exit;
		}
	}

	public function skrill_validate()
	{
		$payment_amount = floatval ($this->data['amount']);
		list($custom_id, $fee_type) = explode($this->customCode,$this->data['trans_id']);

		if ($this->data['status'] == 2)
		{
			self::process_callback($custom_id, $fee_type, $payment_amount);
		}
		else
		{
			$redirect_url = $this->system->SETTINGS['siteurl'] . 'validate.php?fail';
			header('location: '. $redirect_url);
			exit;
		}
	}

	public function toocheckout_validate()
	{
		$payment_amount = floatval ($this->data['total']);
		list($custom_id, $fee_type) = explode($this->customCode,$this->data['cart_order_id']);

		if ($this->data['cart_order_id'] != '' && $this->data['credit_card_processed'] == 'Y')
		{
			self::process_callback($custom_id, $fee_type, $payment_amount);
		}
		else
		{
			$redirect_url = $this->system->SETTINGS['siteurl'] . 'validate.php?fail';
			header('location: '. $redirect_url);
			exit;
		}
	}
	private function process_callback($custom_id, $fee_type, $payment_amount, $currency = NULL)
	{		
		switch ($fee_type)
		{
			case 1: // add to account balance
				$addquery = '';
				if ($this->system->SETTINGS['fee_disable_acc'] == 'y')
				{
					$query = "SELECT suspended, balance FROM " . $this->DBPrefix . "users WHERE id = :get_id";
					$params = array(
						array(':get_id', $custom_id, 'int')
					);
					$this->database->query($query, $params);
					$data = $this->database->result();
					// reable user account if it was disabled
					$params = array();
					if ($data['suspended'] == 7 && ($data['balance'] + $payment_amount) >= 0)
					{
						$addquery = ', suspended = 0, payment_reminder_sent = :payment ';
						$params[] = array(':payment', 'n', 'bool');
					}
				}
				$query = "UPDATE " . $this->DBPrefix . "users SET balance = balance + :payments" . $addquery . " WHERE id = :user_id";
				$params[] = array(':payments', $payment_amount, 'float');
				$params[] = array(':user_id', $custom_id, 'int');
				$this->database->query($query, $params);

				// add invoice
				$query = "INSERT INTO " . $this->DBPrefix . "useraccounts (user_id, date, balance, total, paid) VALUES
						(:user_id, :time_stamp, :payment, :extra_payment, 1)";
				$params = array(
					array(':user_id', $custom_id, 'int'),
					array(':time_stamp', $this->system->CTIME, 'int'),
					array(':payment', $payment_amount, 'float'),
					array(':extra_payment', $payment_amount, 'float')
				);
				$this->database->query($query, $params);
			break;
			case 2: // pay for an item
				$query = "UPDATE " . $this->DBPrefix . "winners SET paid = 1, is_counted = 'y' WHERE id = :get_id";
				$params = array(
					array(':get_id', $custom_id, 'int')
				);
				$this->database->query($query, $params);
				
				//update the sold items counter
				$this->system->writesetting("counters", "itemssold", $this->system->COUNTERS['itemssold'] + 1, 'int');
			break;
			case 3: // pay signup fee (live mode)
				$query = "UPDATE " . $this->DBPrefix . "users SET suspended = 0 WHERE id = :get_id";
				$params = array(
					array(':get_id', $custom_id, 'int')
				);
				$this->database->query($query, $params);

				// add invoice
				$query = "INSERT INTO " . $this->DBPrefix . "useraccounts (user_id, date, signup, total, paid) VALUES
						(:get_id, :time_stamp, :payment, :extra_payment, 1)";
				$params = array(
					array(':get_id', $custom_id, 'int'),
					array(':time_stamp', $this->system->CTIME, 'int'),
					array(':payment', $payment_amount, 'float'),
					array(':extra_payment', $payment_amount, 'float')
				);
				$this->database->query($query, $params);
			break;
			case 4: // pay auction fee (live mode)
				$catscontrol = new MPTTcategories();

				$query = "SELECT auc_id FROM " . $this->DBPrefix . "useraccounts WHERE useracc_id = :useraccounts_id";
				$params = array(
					array(':useraccounts_id', $custom_id, 'int')
				);
				$this->database->query($query, $params);
				$auc_id = $this->database->result('auc_id');
				
				$query = "UPDATE " . $this->DBPrefix . "auctions SET suspended = 0 WHERE id = :auctions_id";
				$params = array(
					array(':auctions_id', $auc_id, 'int')
				);
				$this->database->query($query, $params);

				$query = "UPDATE " . $this->DBPrefix . "useraccounts SET paid = 1 WHERE auc_id = :useraccounts_id AND setup > 0";
				$params = array(
					array(':useraccounts_id', $auc_id, 'int')
				);
				$this->database->query($query, $params);

				$query = "UPDATE " . $this->DBPrefix . "counters SET auctions = auctions + :add_auction";
				$params = array(
					array(':add_auction', 1, 'int')
				);
				$this->database->query($query, $params);

				$query = "UPDATE " . $this->DBPrefix . "useraccounts SET paid = 1 WHERE useracc_id = :useraccounts_id";
				$params = array(
					array(':useraccounts_id', $custom_id, 'int')
				);
				$this->database->query($query, $params);

				$query = "SELECT id, category, title, minimum_bid, pict_url, buy_now, reserve_price, auction_type, ends
					FROM " . $this->DBPrefix . "auctions WHERE id = :auction_id";
				$params = array(
					array(':auction_id', $auc_id, 'int')
				);
				$this->database->query($query, $params);	
				$auc_data = $this->database->result();

				// auction data
				$auction_id = $auc_data['id'];
				$title = $auc_data['title'];
				$atype = $auc_data['auction_type'];
				$pict_url = $auc_data['pict_url'];
				$minimum_bid = $auc_data['minimum_bid'];
				$reserve_price = $auc_data['reserve_price'];
				$buy_now_price = $auc_data['buy_now'];
				$a_ends = $auc_data['ends'];

				if ($this->user->user_data['startemailmode'] == 'yes')
				{
					$this->sendEmail->confirmation($auction_id, $title, $atype, $pict_url, $minimum_bid, $reserve_price, $buy_now_price, $a_ends);
				}

				// update recursive categories
				$query = "SELECT left_id, right_id, level FROM " . $this->DBPrefix . "categories WHERE cat_id = :cats_id";
				$params = array(
					array(':cats_id', $auc_data['category'], 'int')
				);
				$this->database->query($query, $params);	
				$parent_node = $this->database->result();
				$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

				for ($i = 0; $i < count($crumbs); $i++)
				{
					$query = "UPDATE " . $this->DBPrefix . "categories SET sub_counter = sub_counter + 1 WHERE cat_id = :cats_id";
					$params = array(
						array(':cats_id', $crumbs[$i]['cat_id'], 'int')
					);
					$this->database->query($query, $params);
				}
			break;
			case 5: // pay relist fee (live mode)
				$query = "UPDATE " . $this->DBPrefix . "auctions SET suspended = 0 WHERE id = :auction_id";
				$params = array(
					array(':auction_id', $custom_id, 'int')
				);
				$this->database->query($query, $params);
				// add invoice
				$query = "INSERT INTO " . $this->DBPrefix . "useraccounts (user_id, auc_id, date, relist, total, paid) VALUES
						(:get_id, :get_extra_id, :time_stamp, :payment, :extra_payment, 1)";
				$params = array(
					array(':get_id', $custom_id, 'int'),
					array(':get_extra_id', $custom_id, 'int'),
					array(':time_stamp', $this->system->CTIME, 'int'),
					array(':payment', $payment_amount, 'float'),
					array(':extra_payment', $payment_amount, 'float')
				);
				$this->database->query($query, $params);
			break;
			case 6:  // pay buyer fee (live mode)
				$query = "UPDATE " . $this->DBPrefix . "winners SET bf_paid = 1 WHERE bf_paid = 0 AND auction = :auction_id AND winner = :winner_id";
				$params = array(
					array(':auction_id', $custom_id, 'int'),
					array(':winner_id', $this->user->user_data['id'], 'int')
				);
				$this->database->query($query, $params);

				$query = "UPDATE " . $this->DBPrefix . "users SET balance = balance + :payment, suspended = 0 WHERE id = :user_id";
				$params = array(
					array(':payment', $payment_amount, 'float'),
					array(':user_id', $this->user->user_data['id'], 'int')
				);
				$this->database->query($query, $params);

				// add invoice
				$query = "INSERT INTO " . $this->DBPrefix . "useraccounts (user_id, auc_id, date, buyer, total, paid) VALUES
						(:user_id, :get_id, :time_stamp, :payment, :extra_payment, 1)";
				$params = array(
					array(':user_id', $this->user->user_data['id'], 'int'),
					array(':get_id', $custom_id, 'int'),
					array(':time_stamp', $this->system->CTIME, 'int'),
					array(':payment', $payment_amount, 'float'),
					array(':extra_payment', $payment_amount, 'float')
				);
				$this->database->query($query, $params);
			break;
			case 7: // pay final value fee (live mode)
				$query = "UPDATE " . $this->DBPrefix . "winners SET ff_paid = 1 WHERE ff_paid = 0 AND auction = :auction_id AND seller = :user_id";
				$params = array(
					array(':auction_id', $custom_id, 'int'),
					array(':user_id', $this->user->user_data['id'], 'int')
				);
				$this->database->query($query, $params);

				$query = "UPDATE " . $this->DBPrefix . "users SET balance = balance + :payment, suspended = 0 WHERE id = :user_id";
				$params = array(
					array(':payment', $payment_amount, 'float'),
					array(':user_id', $this->user->user_data['id'], 'int')
				);
				$this->database->query($query, $params);

				// add invoice
				$query = "INSERT INTO " . $this->DBPrefix . "useraccounts (user_id, auc_id, date, finalval, total, paid) VALUES
						(:user_id, :get_id, :time_stamp, :payment, :extra_payment, 1)";
				$params = array(
					array(':user_id', $this->user->user_data['id'], 'int'),
					array(':get_id', $custom_id, 'int'),
					array(':time_stamp', $this->system->CTIME, 'int'),
					array(':payment', $payment_amount, 'float'),
					array(':extra_payment', $payment_amount, 'float')
				);
				$this->database->query($query, $params);

			break;
			case 8: //Activate New Banner Account 
                $query = "UPDATE " . $this->DBPrefix . "bannersusers SET paid = 1 WHERE id = :bannersusers_id"; 
                $params = array(
					array(':bannersusers_id', $custom_id, 'int')
				);
				$this->database->query($query, $params);
            break; 
            case 9: //Activate Extra Banner on banner user account 
                $query = "UPDATE " . $this->DBPrefix . "bannersusers SET ex_banner_paid = 'y' WHERE id = :bannersusers_id";
                $params = array(
					array(':bannersusers_id', $custom_id, 'int')
				);
				$this->database->query($query, $params); 
            break; 
			case 10: //Digital item was paid now send email with digital item link
            	//Get auction id, winner id and seller id 
                $query = "SELECT DISTINCT w.bid, w.winner, w.auction, w.bid, b.title, d.item, d.seller, d.hash, u.nick, u.email, u.name
                FROM " . $this->DBPrefix . "winners w
                LEFT JOIN " . $this->DBPrefix . "auctions b ON (b.id = w.auction) 
        		LEFT JOIN " . $this->DBPrefix . "users u ON (u.id = w.winner) 
                LEFT JOIN " . $this->DBPrefix . "digital_items d ON (d.auctions = w.auction)
                WHERE w.id = :digital_id"; 
				$params = array(
					array(':digital_id', $custom_id, 'int')
				);
				$this->database->query($query, $params); 
				while ($data = $this->database->result())
				{
					$this->sendEmail->digital_item_email($data['title'], $data['name'], $data['auction'], $data['bid'], $data['nick'], $data['email'], $this->security->encrypt($data['hash']), $data['pict_url'], $data['id'], $data['email']);
				}
				//update winners db that the item was paid for
				$query = "UPDATE " . $this->DBPrefix . "winners SET paid = 1, is_counted = 'y' WHERE id = :paid_id";
				$params = array(
					array(':paid_id', $custom_id, 'int')
				);
				$this->database->query($query, $params); 
				
				//update the sold items counter
				$this->system->writesetting("counters", "itemssold", $this->system->COUNTERS['itemssold'] + 1, 'int');
            break;	
		}
	}
}