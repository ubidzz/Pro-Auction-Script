<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/



include 'common.php';

include INCLUDE_PATH . 'membertypes.inc.php';

foreach ($membertypes as $idm => $memtypearr)

{

	$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;

}



$id = intval($_REQUEST['id']);



if (!$user->checkAuth())

{

	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'buy_now.php?id=' . $id;

	header('location: user_login.php');

	exit;

}



if (in_array($user->user_data['suspended'], array(5, 6, 7)))

{

	header('location: message.php');

	exit;

}



if (!$user->can_buy)

{

	$_SESSION['TMP_MSG'] = $MSG['819'];

	header('location: user_menu.php');

	exit;

}



unset($ERROR);

ksort($memtypesarr, SORT_NUMERIC);

$NOW = $system->CTIME;

$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE id = :au_id";

$params = array(

	array(':au_id', $id, 'int')

);

$db->query($query, $params);

$Auction = $db->result();



if($Auction['user'] == $user->user_data['id'])

{

	header('location: ' . $system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($Auction['title']) . '-' . $id);

	exit;

}



// such auction does not exist

if ($db->numrows() == 0)

{

	$template->assign_vars(array(

			'TITLE_MESSAGE' => $MSG['415'],

			'BODY_MESSAGE' => $ERR['606']

			));

	include 'header.php';

	$template->set_filenames(array(

			'body' => 'message.tpl'

			));

	$template->display('body');

	include 'footer.php';

	exit; // kill the page

}



// Check to see if this is a digital item auction 

if (is_dir(UPLOAD_FOLDER . 'items' . '/' . $Auction['user'] . '/' . $id))

{

	$query = "SELECT * FROM " . $DBPrefix . "digital_items WHERE auctions = :auction_id AND seller = :seller_id";

	$params = array(

		array(':auction_id', $id, 'int'),

		array(':seller_id', $Auction['user'], 'int')

	);

	$db->query($query, $params);

	$digital = $db->result();

}



if ($Auction['closed'] == 1)

{

	header('location: ' . $system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($Auction['title']) . '-' . $_REQUEST['id']);

	exit;

}

if ($Auction['starts'] > $system->CTIME)

{

	$ERROR = $ERR['073'];

}



// If there are bids for this auction -> error

if ($Auction['bn_only'] == 'n')

{

	if ($Auction['sell_type'] == 'sell' && !($Auction['buy_now'] > 0 && ($Auction['num_bids'] == 0 || ($Auction['reserve_price'] > 0 && $Auction['current_bid'] < $Auction['reserve_price']) || ($Auction['current_bid'] < $Auction['buy_now']))))

	{

		$ERROR = $ERR['712'];

	}

	else

	{

		$query = "SELECT MAX(bid) AS maxbid FROM " . $DBPrefix . "proxybid WHERE itemid = :itemid";

		$params = array(

			array(':itemid', $id, 'int')

		);

		$db->query($query, $params);

		$maxbid = $db->result('maxbid');

		if (($maxbid > 0 && $maxbid >= $Auction['reserve_price']))

		{

			$ERROR = $ERR['712'];

		}

	}

}



// get user's nick

$query = "SELECT id, name, nick, email, rate_sum FROM " . $DBPrefix . "users WHERE id = :user_nick";

$params = array(

	array(':user_nick', $Auction['user'], 'str')

);

$db->query($query, $params);

$Seller = $db->result();



// Get current number of feedbacks

$query = "SELECT rated_user_id FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = :rated_user_id";

$params = array(

	array(':rated_user_id', $Auction['user'], 'str')

);

$db->query($query, $params);

$num_feedbacks = $db->numrows();



// Get current total rate value for user

$total_rate = $Seller['rate_sum'];



$i = 0;

foreach ($memtypesarr as $k => $l)

{

	if ($k >= $total_rate || $i++ == (count($memtypesarr) - 1))

	{

		$TPL_rate_radio = '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';

		break;

	}

}



$qty = (isset($_REQUEST['qty'])) ? intval($_REQUEST['qty']) : 1;

if ($Auction['sell_type'] == 'free' && $Auction['shipping_cost'] == 0) $freeItems = TRUE;

elseif ($Auction['sell_type'] == 'free' && $Auction['shipping_cost'] > 0) $freeItems = FALSE;

elseif ($Auction['sell_type'] == 'sell') $freeItems = FALSE;

$new_winner_id = 0;

$buy_done = 0;

if (isset($_POST['action']) && $_POST['action'] == 'buy')

{

	// check if password is correct

	$check = $phpass->CheckPassword($_POST['password'], $user->user_data['password']); 

    if ($system->SETTINGS['usersauth'] == 'y') 

    { 

        if (strlen($_POST['password']) == 0) 

        { 

            $ERROR = $ERR['610']; 

        } 

        elseif ($check == 0) 

        { 

            $ERROR = $ERR['611']; 

        } 

    } 

    // check if buyer is not the seller

	if ($user->user_data['id'] == $Auction['user'])

	{

		$ERROR = $ERR['711'];

	}

	// check qty

	if (isset($qty) && $qty > $Auction['quantity'])

	{

		$ERROR = $ERR['608'];

	}

	else if (!isset($qty) || $qty < 1) 

	{ 

		$ERROR = $ERR['601'];  

	}

	// perform final actions

	if (!isset($ERROR))

	{

		$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :user_id, :buy_now, :time, :qty)";

 		$params = array(

 			array(':auc_id', $id, 'int'),

 			array(':user_id', $user->user_data['id'], 'int'),

 			array(':buy_now', $Auction['buy_now'], 'float'),

 			array(':time', $system->CTIME, 'int'),

			array(':qty', $qty, 'int')

		);

 		$db->query($query, $params);

 		if (defined('TrackUserIPs'))

		{

			// log auction BIN IP

			$system->log('user', 'BIN on Item', $user->user_data['id'], $id);

		}

		if ($Auction['bn_only'] != 'y')

		{

			$query = "UPDATE " . $DBPrefix . "auctions SET ends = :time, num_bids = num_bids + 1, current_bid = :buy_now, current_bid = :current_bid WHERE id = :auc_id";

			$params = array(

				array(':auc_id', $id, 'int'),

				array(':buy_now', $Auction['buy_now'], 'float'),

				array(':current_bid', $Auction['buy_now'], 'int'),

				array(':time', $system->CTIME, 'int')

			);

			$db->query($query, $params);

			

			$system->writesetting("counters", "bids", $system->COUNTERS['bids'] + 1, 'int');



			// so its not over written by the cron

			$tmpauc = $Auction;

			include(MAIN_PATH . 'cron.php');

			$Auction = $tmpauc;

			unset($tmpauc);

		}

		else

		{

			$query = "UPDATE " . $DBPrefix . "auctions SET quantity = quantity - :quantity WHERE id = :auc_id";

			$params = array(

				array(':quantity', $qty, 'int'),

				array(':auc_id', $id, 'int')

			);

			$db->query($query, $params);

			// force close if all items sold

			if (($Auction['quantity'] - $qty) == 0)

			{

				$query = "UPDATE " . $DBPrefix . "auctions SET ends = :time, current_bid = :current_bid, sold = :sold, num_bids = num_bids + 1, closed = 1 WHERE id = :auc_id";

				$params = array(

					array(':time', $system->CTIME, 'int'),

					array(':sold', 'y', 'bool'),

					array(':auc_id', $id, 'int'),

					array(':current_bid', $Auction['buy_now'], 'float')

				);

				$db->query($query, $params);

			}

			// do stuff that is important

			$query = "SELECT id, name, nick, email, address, city, prov, zip, country FROM " . $DBPrefix . "users WHERE id = :user_id";

			$params = array(

				array(':user_id', $user->user_data['id'], 'int')

			);

			$db->query($query, $params);

			$Winner = $db->result();

			$bf_paid = 1;

			$ff_paid = 1;

			$no_fee_groups = true;//add no fees

			

			if($user->no_fees || $user->no_buyout_fee) // no fees or buyer Fee

			{

				$no_fee_groups = false; //don't add no fees

			}



			// work out & add fee

			if ($system->SETTINGS['fees'] == 'y')

			{

				if($no_fee_groups)

				{



					$query = "SELECT value, fee_type FROM " . $DBPrefix . "fees WHERE type = :buyer_fee";

					$params = array(

						array(':buyer_fee', 'buyer_fee', 'str')

					);

					$db->query($query, $params);

					$row = $db->result();

					$fee_type = $row['fee_type'];

					if ($row['fee_type'] == 'flat')

					{

						$buyer_fee = $row['value'];

					}

					else

					{

						$buyer_fee = ($row['value'] / 100) * floatval($Auction['buy_now']);

					}

					if ($system->SETTINGS['fee_type'] == 1 || $fee_value <= 0)

					{

						// add balance & invoice

						$query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee_value WHERE id = :user_id";

						$params = array(

							array(':fee_value', $buyer_fee, 'float'),

							array(':user_id', $user->user_data['id'], 'int')

						);

						$db->query($query, $params);		

						$query = "INSERT INTO " . $DBPrefix . "useraccounts (NULL, user_id, auc_id, date, buyer, total, paid) VALUES

							('" . $user->user_data['id'] . "', '" . $id . "', '" . $system->CTIME . "', '" . $buyer_fee . "', '" . $buyer_fee . "', '1')";

						$db->direct_query($query);

					}

					else

					{

						$bf_paid = 0;

						$query = "UPDATE " . $DBPrefix . "users SET suspended = 6 WHERE id = :user_id";

						$params = array(

							array(':user_id', $user->user_data['id'], 'int')

						);

						$db->query($query, $params);

					}

				}

				

				// do the final value fees

				if(check_user_groups_fees($Auction['user'], 1, 0, 1))

				{

					$query = "SELECT value, fee_type, fee_from, fee_to FROM " . $DBPrefix . "fees WHERE type = :endauc_fee";

					$params = array(

						array(':endauc_fee', 'endauc_fee', 'str')

					);

					$db->query($query, $params);

					$final_value_fee = 0;

					while ($row = $db->result())

					{

						if (floatval($Auction['buy_now']) >= $row['fee_from'] && floatval($Auction['buy_now']) <= $row['fee_to'])

						{

							if ($row['fee_type'] == 'flat')

							{

								$final_value_fee = $row['value'];

							}

							else

							{

								$final_value_fee = ($row['value'] / 100) * floatval($Auction['buy_now']);

							}

						}

					}

					if($fee_value <= 0)

					{

						if ($system->SETTINGS['fee_type'] == 1)

						{

							// add user balance & invoice

							$query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee_value WHERE id = :user";

							$params = array(

								array(':fee_value', $final_value_fee, 'float'),

								array(':user', $Auction['user'], 'int')

							);

							$db->query($query, $params);

							$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, finalval, total, paid) VALUES

								('" . $Auction['user'] . "', '" . $id . "', '" . $system->CTIME . "', '" . $final_value_fee . "', '" . $final_value_fee . "', '1')";

							$db->direct_query($query);

						}

						else

						{

							$query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee_value, suspended = 5 WHERE id = :user_id";

							$params = array(

								array(':fee_value', $final_value_fee, 'float'),

								array(':user_id', $Auction['user'], 'int')

							);

							$db->query($query, $params);

			

							$send_email->final_value_fee_email($Auction['id'], $Auction['title'], $Seller['name'], $Auction['user'], $Seller['email']);

							$ff_paid = 0;

						}

					}

				}

			}


			if ($Auction['sell_type'] == 'free' && $Auction['shipping_cost'] == 0) $B_freeItem = 1;

			elseif ($Auction['sell_type'] == 'free' && $Auction['shipping_cost'] > 0) $B_freeItem = 0;

			elseif ($Auction['sell_type'] == 'sell') $B_freeItem = 0;

			

			//send sms alert the seller and buyer

			$smsAlerts->alertSettingHandler('itemWonAlert',array('userID' => $Winner['id']));

			$smsAlerts->alertSettingHandler('itemSoldAlert',array('userID' => $Seller['id']));



			$query = "INSERT INTO " . $DBPrefix . "winners (id, auction, seller, winner, bid, closingdate, feedback_win, feedback_sel, qty, paid, bf_paid, ff_paid, shipped, is_read, is_counted, shipper, shipper_url, tracking_number) VALUES 

				(NULL, :auction_id, :seller_id, :winner_id, :price, :time_stamp, 0, 0, :qty, :sold, :bf_paid, :ff_paid, 0, 0, 'n', '', '', '')";

			$params = array(

				array(':auction_id', $id, 'int'),

				array(':seller_id', $Auction['user'], 'int'),

				array(':winner_id', $Winner['id'], 'int'),

				array(':price', $Auction['buy_now'], 'float'),

				array(':time_stamp', $system->CTIME, 'int'),

				array(':qty', $qty, 'int'),

				array(':sold', $B_freeItem, 'int'),

				array(':bf_paid', $bf_paid, 'int'),

				array(':ff_paid', $ff_paid, 'int')

			);

			$db->query($query, $params);



			$new_winner_id = $db->lastInsertId();

	

			// get end string

			$month = date('m', $Auction['ends'] + $system->TDIFF);

			$ends_string = $MSG['MON_0' . $month] . ' ' . date('d, Y H:i', $Auction['ends'] + $system->TDIFF);

			$Auction['current_bid'] = $Auction['buy_now'];

			

			// Send mail to the seller

			$send_email->winner($Auction['title'], $Auction['id'], $Auction['pict_url'], $Auction['current_bid'], $qty, $ends_string, $Auction['user'], $Winner['id'], $new_id);

			

			//send email to winner

			$send_email->youwin_nodutch($Auction['title'], $Auction['pict_url'], $Auction['id'], $Auction['current_bid'], $ends_string, $Auction['user'], $Winner['id']);

	

			if ($system->SETTINGS['fees'] == 'y' && $system->SETTINGS['fee_type'] == 2 && $fee > 0)

			{

				$_SESSION['auction_id'] = $auction_id;

				header('location: pay.php?a=6');

				exit;

			}

		}

		$buy_done = 1;

	}

}



if (empty($digital['item']))

{

	$additional_shipping = $Auction['shipping_cost_additional'] * ($qty - 1);

	$shipping_cost = ($shipping == 1) ? ($Auction['shipping_cost'] + $additional_shipping) : 0;

	$BN_total = ($Auction['bid'] * $qty) + $shipping_cost;

}



$template->assign_vars(array(

	'ERROR' => (isset($ERROR)) ? $ERROR : '',

	'ID' => $_REQUEST['id'],

	'WINID' => $new_winner_id,

	'TITLE' => $Auction['title'],

	'BN_PRICE' => $system->print_money($Auction['buy_now']),

	'BN_TOTAL' => $system->print_money($BN_total),

	'SELLER' => ' <a href="profile.php?user_id=' . $Auction['user'] . '"><b>' . $Seller['nick'] . '</b></a>',

	'SELLERNUMFBS' => '<b>(' . $total_rate . ')</b>',

	'FBICON' => $TPL_rate_radio,

	'LEFT' => $Auction['quantity'],

	'SHIPPING' => $Auction['sgpping_cost'],

	'B_SHIPPING' => $Auction['sgpping_cost'] > 0,

	'DIGITAL_ITEM_TOTAL' => $system->print_money($Auction['buy_now']),

	'B_DIGITAL_ITEM_TOTAL' => $Auction['auction_type'] == 3,

	'B_DIGITAL_ITEM' => (empty($digital['item'])),

	'PAY_LINK' => (!isset($digital['item'])) ? 'pay.php?a=2' : 'pay.php?a=10',

	'B_QTY' => ($Auction['quantity'] > 1 && ($Auction['auction_type'] == 1 || $Auction['auction_type'] == 2)),

	'B_NOTBOUGHT' => ($buy_done != 1),

	'B_FREEITEM' => ($freeItem),

	'B_FREEITEMS' => ($freeItems),

	'B_USERAUTH' => ($system->SETTINGS['usersauth'] == 'y')

));



include 'header.php';

$template->set_filenames(array(

		'body' => 'buy_now.tpl'

		));

$template->display('body');

require('footer.php');