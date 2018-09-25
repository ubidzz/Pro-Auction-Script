<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
if (!defined('InProAuctionScript')) exit('Access denied');

if (!isset($_SERVER['SCRIPT_NAME'])) $_SERVER['SCRIPT_NAME'] = 'cron.php';
if($system->SETTINGS['cronlog'] == 'y')
{
	define('LogCron', true); 
}

include INCLUDE_PATH . 'functions_cron.php';
$cronHandler = new cronHandler();

// initialize cron script
$categories = $cronHandler->constructCategories();

/**
 * ------------------------------------------------------------
 * 1) "close" expired auctions
 * closing auction means:
 * a) update database:
 * + "auctions" table
 * + "categories" table - for counters
 * + "counters" table
 * b) send email to winner (if any) - passing seller's data
 * c) send email to seller (reporting if there was a winner)
 */

$NOWDATE = $system->dateToTimestamp($system->CTIME);
$NOW = $system->CTIME;
$buyer_emails = array();
$seller_emails = array();
$htmlLineBrakes = "<br>";
//used for the cron logging
$corn_log = '';

$buyer_fee = $cronHandler->buyerFeeValue();
$buyer_fee = empty($buyer_fee) ? 0 : $buyer_fee;
$buyer_fee_type = $cronHandler->buyerFeeType();
$endauc_fee = $cronHandler->buildFees();

// get a list of all ended auctions
$query = "SELECT a.*, u.email, u.endemailmode, u.nick, u.payment_details, u.name
	FROM " . $DBPrefix . "auctions a
	LEFT JOIN " . $DBPrefix . "users u ON (a.user = u.id)
	WHERE a.ends <= :ctime AND (a.closed = 0 OR a.closed = 1 AND a.reserve_price > 0 AND a.num_bids > 0 AND a.current_bid < a.reserve_price)";
$params = array(
	array(':ctime', $NOW, 'int')
);
$db->query($query, $params);

$count_auctions = $db->numrows();
//pre-setting some of the data
$closed = 0;
$n = 1;
$sent_winner_emails = 0;
$sent_seller_emails = 0;
$suspend = 0;
$relisted = 0;
$dutch_winners = 0;
$standard_winners = 0;
//looping each auction
while ($Auction = $db->fetch())
{
	$n++;
	$report_text = '';
	$Auction['description'] = strip_tags($Auction['description']);

	// Send notification to all users watching this auction
	$cronHandler->sendWatchEmails($Auction['id'], $Auction['title']);

	// set seller array
	$Seller = array('id' => $Auction['user'],'email' => $Auction['email'],'endemailmode' => $Auction['endemailmode'],'nick' => $Auction['nick'],'payment_details' => $Auction['payment_details'],'name' => $Auction['name']);

	// get an order list of bids of the item (high to low)
	$winner_present = false;
	$query = "SELECT u.* FROM " . $DBPrefix . "bids b
			LEFT JOIN " . $DBPrefix . "users u ON (b.bidder = u.id)
			WHERE auction = :auc_id ORDER BY b.bid DESC, b.quantity DESC, b.id DESC";
	$params = array(
		array(':auc_id', $Auction['id'], 'int')
	);
	$db->query($query, $params);
	$num_bids = $db->numrows('id');

	// send email to seller - to notify him
	// create a "report" to seller depending of what kind auction is
	$atype = intval($Auction['auction_type']);
	$sellType = $Auction['sell_type'];
	
	// Standard Auction
	if ($atype == 1)
	{
		if ($num_bids > 0 && ($Auction['current_bid'] >= $Auction['reserve_price'] || $Auction['sold'] == 's'))
		{
			$Winner = $db->result();
			$Winner['quantity'] = $Auction['quantity'];
			$WINNING_BID = $Auction['current_bid'];
			$winner_present = true;
		}
		if ($winner_present)
		{
			$report_text = $Winner['nick'] . "\n";
			if ($system->SETTINGS['users_email'] == 'n')
			{
				$report_text .= ' (<a href="mailto:' . $Winner['email'] . '">' . $Winner['email'] . '</a>)' . "\n";
			}
			if ($Winner['address'] != '')
			{
				$report_text .= $MSG['30_0086'] . $Winner['address'] . ' ' . $Winner['city'] . ' ' . $Winner['prov'] . ' ' . $Winner['zip'] . ', ' . $Winner['country'];
			}
			$bf_paid = 1; // buyer fee payed?
			$ff_paid = 1; // auction end fee payed?
			// work out & add fee
			if ($system->SETTINGS['fees'] == 'y')
			{
				// insert buyer fees
				if(check_user_groups_fees($Winner['id'], 1, 1, 0))
				{
					if ($system->SETTINGS['fee_type'] == 1 || $buyer_fee <= 0)
					{
						if ($buyer_fee_type == 'flat')
						{
							$fee_value = $buyer_fee;
						}
						else
						{
							$fee_value = ($buyer_fee / 100) * floatval($Auction['current_bid']);
						}
						// add balance & invoice
						$query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee WHERE id = :winner";
						$params = array(
							array(':fee', $buyer_fee, 'float'),
							array(':winner', $Winner['id'], 'int')
						);
						$db->query($query, $params);
				
						$query = "INSERT INTO " . $DBPrefix . "useraccounts (user_id, auc_id, date, buyer, total, paid) VALUES
								(NULL, :auction, :winner, :now, :fee, :total, 1)";
						$params = array(
							array(':auction', $Auction['id'], 'int'),
							array(':winner', $Winner['id'], 'int'),
							array(':now', $NOW, 'int'),
							array(':fee', $buyer_fee, 'float'),
							array(':total', $buyer_fee, 'float')
						);
						$db->query($query, $params);
					}
					else
					{
						$bf_paid = 0;
						$query = "UPDATE " . $DBPrefix . "users SET suspended = 6 WHERE id = :winner";
						$params = array(
							array(':winner', $Winner['id'], 'int')
						);
						$db->query($query, $params);
				
						$buyer_emails[] = array(
							'name' => $Winner['name'],
							'email' => $Winner['email'],
							'uid' => $Winner['id'],
							'id' => $Auction['id'],
							'title' => $Auction['title']
						);
					}
				}
				
				// insert final value fees
				if(check_user_groups_fees($Winner['id'], 1, 0, 1))
				{
					$fee_value = 0;
					for ($i = 0; $i < count($endauc_fee); $i++)
					{
						if ($Auction['current_bid'] >= $endauc_fee[$i]['fee_from'] && $Auction['current_bid'] <= $endauc_fee[$i]['fee_to'])
						{
							if ($endauc_fee[$i]['fee_type'] == 'flat')
							{
								$fee_value = $endauc_fee[$i]['value'];
							}
							else
							{
								$fee_value = ($endauc_fee[$i]['value'] / 100) * $Auction['current_bid'];
							}
						}
					}
					
					if ($system->SETTINGS['fee_type'] == 1)
					{
						// add balance & invoice
						$query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee WHERE id = :user_id";
						$params = array(
							array(':fee', $fee_value, 'float'),
							array(':user_id', $Seller['id'], 'int')
						);
						$db->query($query, $params);
				
						$query = "INSERT INTO " . $DBPrefix . "useraccounts (useracc_id, user_id, auc_id, date, finalval, total, paid) VALUES
								(NULL, :auction, :seller, :now, :fee, :total, 1)";
						$params = array(
							array(':auction', $Auction['id'], 'int'),
							array(':seller', $Seller['id'], 'int'),
							array(':now', $NOW, 'int'),
							array(':fee', $fee_value, 'float'),
							array(':total', $fee_value, 'float')
						);
						$db->query($query, $params);
					}
					else
					{
						$ff_paid = 0;
						$query = "UPDATE " . $DBPrefix . "users SET suspended = 5 WHERE id = :user_id";
						$params = array(
							array(':user_id', $Seller['id'], 'int')
						);
						$db->query($query, $params);
				
						$seller_emails[] = array(
							'name' => $Seller['name'],
							'email' => $Seller['email'],
							'uid' => $Seller['id'],
							'id' => $Auction['id'],
							'title' => $Auction['title']
							);
					}	
				}
			}
			
			if ($Auction['sell_type'] == 'free' && $Auction['shipping_cost'] == 0) $B_freeItem = 1;
			elseif ($Auction['sell_type'] == 'free' && $Auction['shipping_cost'] > 0) $B_freeItem = 0;
			elseif ($Auction['sell_type'] == 'sell') $B_freeItem = 0;
						
			// Add winner's data to "winners" table
			$query = "INSERT INTO " . $DBPrefix . "winners (id, auction, seller, winner, bid, closingdate, feedback_win, feedback_sel, qty, paid, bf_paid, ff_paid, shipped, is_read, is_counted, shipper, shipper_url, tracking_number) VALUES
				(NULL, :auction_id, :seller_id, :winner_id, :price, :time_stamp, 0, 0, 1, :item_type, :bf_paid, :ff_paid, 0, 0, 'n', '', '', '')";
			$params = array(
				array(':auction_id', $Auction['id'], 'int'),
				array(':seller_id', $Seller['id'], 'int'),
				array(':winner_id', $Winner['id'], 'int'),
				array(':price', $Auction['current_bid'], 'float'),
				array(':time_stamp', $NOW, 'int'),
				array(':item_type', $B_freeItem, 'int'),
				array(':bf_paid', $bf_paid, 'int'),
				array(':ff_paid', $ff_paid, 'int')
			);
			$db->query($query, $params);
			$new_winner_id = $db->lastInsertId();
			$standard_winners++;
		}
		else
		{
			$report_text = $MSG['429'];
		}
	}
	// Dutch Auction
	if ($atype == 2 && $sellType == 'sell')
	{
		// find out winners sorted by bid
		$query = "SELECT *, MAX(bid) AS maxbid
				FROM " . $DBPrefix . "bids WHERE auction = :auc_id GROUP BY bidder
				ORDER BY maxbid DESC, quantity DESC, id DESC";
		$params = array(
			array(':auc_id', $Auction['id'], 'int')
		);
		$db->query($query, $params);

		$num_bids = $num_bids + $db->numrows();
		$WINNERS_ID = array();
		$winner_array = array();
		$items_count = $Auction['quantity'];
		$items_sold = 0;
		foreach ($db->fetchall() as $row) // load every bid
		{
			if (!in_array($row['bidder'], $WINNERS_ID))
			{
				$items_wanted = $row['quantity'];
				$items_got = 0;
				if ($items_wanted <= $items_count)
				{
					$items_got = $items_wanted;
				}
				else
				{
					$items_got = $items_count;
				}
				$items_count -= $items_got;
				$items_sold += $items_got;

				// Retrieve winner nick from the database
				$query = "SELECT id, nick, email, name, address, city, zip, prov, country
						FROM " . $DBPrefix . "users WHERE id = :bidder LIMIT 1";
				$params = array(
					array(':bidder', $row['bidder'], 'int')
				);
				$db->query($query, $params);
				$Winner = $db->result();
				// set arrays
				$WINNERS_ID[] = $row['bidder'];
				$Winner['maxbid'] = $row['maxbid'];
				$Winner['quantity'] = $items_got;
				$Winner['wanted'] = $items_wanted;
				$winner_array[] = $Winner; // set array ready for emails
				$report_text .= ' ' . $MSG['159'] . ' ' . $Winner['nick'];
				if ($system->SETTINGS['users_email'] == 'n')
				{
					$report_text .= ' (' . $Winner['email'] . ')';
				}
				$report_text .= ' ' . $items_got . ' ' . $MSG['5492'] . ', ' . $MSG['5493'] . ' ' . $system->print_money($row['bid']) . ' ' . $MSG['5495'] . ' - (' . $MSG['5494'] . ' ' . $items_wanted . ' ' . $MSG['5492'] . ')' . "\n";
				$report_text .= ' ' . $MSG['30_0086'] . $ADDRESS . "\n";

				$bf_paid = 1;
				$ff_paid = 1;
				// work out & add fee
				if ($system->SETTINGS['fees'] == 'y')
				{
					// insert buyer fees
					if(check_user_groups_fees($Winner['id'], 1, 1, 0))
					{
						if ($system->SETTINGS['fee_type'] == 1 || $buyer_fee <= 0)
						{
							if ($buyer_fee_type == 'flat')
							{
								$fee_value = $buyer_fee;
							}
							else
							{
								$fee_value = ($buyer_fee / 100) * floatval($Auction['current_bid']);
							}
							// add balance & invoice
							$query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee WHERE id = :winner";
							$params = array(
								array(':fee', $buyer_fee, 'float'),
								array(':winner', $Winner['id'], 'int')
							);
							$db->query($query, $params);
					
							$query = "INSERT INTO " . $DBPrefix . "useraccounts (useracc_id, user_id, auc_id, date, buyer, total, paid) VALUES
									(NULL, :auction, :winner, :now, :fee, :total, 1)";
							$params = array(
								array(':auction', $Auction['id'], 'int'),
								array(':winner', $Winner['id'], 'int'),
								array(':now', $NOW, 'int'),
								array(':fee', $buyer_fee, 'float'),
								array(':total', $buyer_fee, 'float')
							);
							$db->query($query, $params);
						}
						else
						{
							$bf_paid = 0;
							$query = "UPDATE " . $DBPrefix . "users SET suspended = 6 WHERE id = :winner";
							$params = array(
								array(':winner', $Winner['id'], 'int')
							);
							$db->query($query, $params);
					
							$buyer_emails[] = array(
								'name' => $Winner['name'],
								'email' => $Winner['email'],
								'uid' => $Winner['id'],
								'id' => $Auction['id'],
								'title' => $Auction['title']
							);
						}
					}
					
					// insert final value fees
					if(check_user_groups_fees($Winner['id'], 1, 0, 1))
					{
						$fee_value = 0;
						for ($i = 0; $i < count($endauc_fee); $i++)
						{
							if ($Auction['current_bid'] >= $endauc_fee[$i]['fee_from'] && $Auction['current_bid'] <= $endauc_fee[$i]['fee_to'])
							{
								if ($endauc_fee[$i]['fee_type'] == 'flat')
								{
									$fee_value = $endauc_fee[$i]['value'];
								}
								else
								{
									$fee_value = ($endauc_fee[$i]['value'] / 100) * $Auction['current_bid'];
								}
							}
						}
						
						if ($system->SETTINGS['fee_type'] == 1)
						{
							// add balance & invoice
							$query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee WHERE id = :user_id";
							$params = array(
								array(':fee', $fee_value, 'float'),
								array(':user_id', $Seller['id'], 'int')
							);
							$db->query($query, $params);
					
							$query = "INSERT INTO " . $DBPrefix . "useraccounts (useracc_id, auc_id, user_id, date, finalval, total, paid) VALUES 
								(NULL, :auction, :seller, :now, :fee, :total, 1)";
							$params = array(
								array(':auction', $Auction['id'], 'int'),
								array(':seller', $Seller['id'], 'int'),
								array(':now', $NOW, 'int'),
								array(':fee', $fee_value, 'float'),
								array(':total', $fee_value, 'float')
							);
							$db->query($query, $params);
						}
						else
						{
							$ff_paid = 0;
							$query = "UPDATE " . $DBPrefix . "users SET suspended = 5 WHERE id = :user_id";
							$params = array(
								array(':user_id', $Seller['id'], 'int')
							);
							$db->query($query, $params);
					
							$seller_emails[] = array(
								'name' => $Seller['name'],
								'email' => $Seller['email'],
								'uid' => $Seller['id'],
								'id' => $Auction['id'],
								'title' => $Auction['title']
								);
						}	
					}
				}
				
				if ($Auction['sell_type'] == 'free' && $Auction['shipping_cost'] == 0) $B_freeItem = 1;
				elseif ($Auction['sell_type'] == 'free' && $Auction['shipping_cost'] > 0) $B_freeItem = 0;
				elseif ($Auction['sell_type'] == 'sell') $B_freeItem = 0;
				
				// Add winner's data to "winners" table
				$query = "INSERT INTO " . $DBPrefix . "winners (id, auction, seller, winner, bid, closingdate, feedback_win, feedback_sel, qty, paid, bf_paid, ff_paid, shipped, is_read, is_counted, shipper, shipper_url, tracking_number) VALUES
					(NULL, :auction_id, :seller_id, :winner_id, :price, :time_stamp, 0, 0, 1, :item_type, :bf_paid, :ff_paid, 0, 0, 'n', '', '', '')";
				$params = array(
					array(':auction_id', $Auction['id'], 'int'),
					array(':seller_id', $Seller['id'], 'int'),
					array(':winner_id', $Winner['id'], 'int'),
					array(':price', $Auction['current_bid'], 'float'),
					array(':time_stamp', $NOW, 'int'),
					array(':item_type', $B_freeItem, 'int'),
					array(':bf_paid', $bf_paid, 'int'),
					array(':ff_paid', $ff_paid, 'int')
				);
				$db->query($query, $params);
				$new_winner_id = $db->lastInsertId();
				$dutch_winners++;
			}
			if ($items_count == 0)
			{
				break;
			}
		}
	} 
	// end auction ends
	$ends_string = $system->dateToTimestamp($Auction['ends']);

	$close_auction = true;
	// deal with the automatic relists find which auctions are to be relisted
	if ($Auction['relist'] > 0 && ($Auction['relist'] - $Auction['relisted']) > 0 && $Auction['suspended'] == 0)
	{
		$query = "SELECT id FROM " . $DBPrefix . "bids WHERE auction = :auc_id";
		$params = array(
			array(':auc_id', $Auction['id'], 'int')
		);
		$db->query($query, $params);

		// noone won the auction so remove bids and start it again
		if ($db->numrows('id') == 0 || ($db->numrows('id') > 0 && $Auction['reserve_price'] > 0 && !$winner_present))
		{
			// Calculate end time
			$_ENDS = $system->ConvertedAuctionDateTimeObject($NOW, $Auction['duration']);

			$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :bauc_id";
			$params = array(
				array(':bauc_id', $Auction['id'], 'int')
			);
			$db->query($query, $params);
			
			$query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = :pauc_id";
			$params = array(
				array(':pauc_id', $Auction['id'], 'int')
			);
			$db->query($query, $params);
			
			$query = "UPDATE " . $DBPrefix . "auctions SET starts = :set_time, ends = :new_end, current_bid = 0, num_bids = 0, relisted = :add_one WHERE id = :auc_id";
			$uparams = array(
				array(':set_time', $NOW, 'int'),
				array(':new_end', $_ENDS, 'int'),
				array(':add_one', $Auction['relisted'] + 1, 'int'),
				array(':auc_id', $Auction['id'], 'int')
			);
			$db->query($query, $uparams);
			$close_auction = false;
			$count_auctions--;
			$relisted++;
		}
	}

	if ($Auction['suspended'] != 0)
	{
		$count_auctions--;
		$suspend++;
	}

	if ($close_auction)
	{
		// update category tables
		$cat_id = $Auction['category'];
		$root_cat = $cat_id;
		$second_cat = false;
		while ($cat_id != -1 && isset($categories[$cat_id]))
		{
			// update counter for this category
			$R_counter = intval($categories[$cat_id]['counter']) - 1;
			$R_sub_counter = intval($categories[$cat_id]['sub_counter']) - 1;
			if ($cat_id == $root_cat)
				--$R_counter;
			if ($R_counter < 0)
				$R_counter = 0;
			if ($R_sub_counter < 0)
				$R_sub_counter = 0;
			$categories[$cat_id]['counter'] = $R_counter;
			$categories[$cat_id]['sub_counter'] = $R_sub_counter;
			$categories[$cat_id]['updated'] = true;
			if ($cat_id == $categories[$cat_id]['parent_id']) // incase something messes up
				break;
			$cat_id = $categories[$cat_id]['parent_id'];

			if (!$second_cat && !($cat_id != -1 && isset($categories[$cat_id])) && $system->SETTINGS['extra_cat'] == 'y' && $Auction['secondcat'] != 0)
			{
				$second_cat = true;
				$cat_id = $Auction['secondcat'];
				$root_cat = $cat_id;
			}
		}

		// Close auction
		if ($Auction['sold'] != 's' AND $Auction['num_bids'] > 0 AND $Auction['reserve_price'] > 0 AND $Auction['current_bid'] < $Auction['reserve_price'])
		{
			$cquery = "UPDATE " . $DBPrefix . "auctions SET closed = 1, sold = 'n' WHERE id = :cauc_id";
			
        }
		else
		{
			$cquery = "UPDATE " . $DBPrefix . "auctions SET closed = 1, sold = 'y' WHERE id = :cauc_id";
        }
        $cparams = array(
			array(':cauc_id', $Auction['id'], 'int')
		);
		$db->query($cquery, $cparams);
		$closed++;
	}

	// WINNER PRESENT
	if ($winner_present)
	{
		//send sms alert the seller
		$smsAlerts->alertSettingHandler('itemSoldAlert',array('userID' => $Seller['id']));

		// Send mail to the seller
		$send_email->winner($Auction['title'], $Auction['id'], $Auction['pict_url'], $Auction['current_bid'], $Auction['quantity'], $ends_string, $Seller['id'], $Winner['id'], $new_winner_id);
		$sent_winner_emails++;
		
		if (isset($winner_array) && is_array($winner_array) && count($winner_array) > 0)
		{
			for ($i = 0, $count = count($winner_array); $i < $count; $i++)
			{
				//send sms alert the buyer
				$smsAlerts->alertSettingHandler('itemWonAlert',array('userID' => $Winner['id']));

				// Send mail to the buyer
				$Winner = $winner_array[$i];
				$send_email->youwin($Auction['description'], $Winner['wanted'], $Winner['quantity'], $Auction['title'], $Auction['id'], $Winner['current_bid'], $ends_string, $Seller['id'], $Seller['payment_details'], $Winner['id']);
				$sent_winner_emails++;
			}
		}
		elseif (is_array($Winner))
		{
			//send sms alert the buyer
			$smsAlerts->alertSettingHandler('itemWonAlert',array('userID' => $Winner['id']));

			// Send mail to the buyer
			$send_email->youwin_nodutch($Auction['title'], $Auction['pict_url'], $Auction['id'], $Auction['current_bid'], $ends_string, $Seller['id'], $Winner['id']);
			$sent_winner_emails++;
		}
	}
	else
	{
		// Send mail to the seller if no winner
		if ($Seller['endemailmode'] != 'cum')
		{
			$send_email->nowinner($Auction['title'], $Auction['id'], $ends_string, $Auction['pict_url'], $Seller['id']);
			$sent_seller_emails++; //add to the $sent_seller_emails to count how many seller emails was sent
		}
		else
		{
			// Save in the database to send later
			$query = "INSERT INTO " . $DBPrefix . "pendingnotif VALUES
				(NULL, :auc_id, :seller_id, '', :auction_data, :seller_data, :date)";
			$params = array(
				array(':auc_id', $Auction['id'], 'int'),
				array(':seller_id', $Auction['id'], 'int'),
				array(':auction_data', serialize($Auction), 'str'),
				array(':seller_data', serialize($Seller), 'str'),
				array(':date', $NOWDATE, 'int')
			);
			$db->query($query, $params);
			$sent_seller_emails++;
		}
	}
	// Update bid counter
	$system->writesetting("counters", "bids", $system->COUNTERS['bids'] - $num_bids, 'int');
}

$corn_log .= $htmlLineBrakes . $MSG['3500_1015617'];
$corn_log .= '<strong>' . $standard_winners . '</strong>' . $MSG['3500_1015618'];

$corn_log .= $htmlLineBrakes . $MSG['3500_1015615'];
$corn_log .= '<strong>' . $dutch_winners . '</strong>' . $MSG['3500_1015616'];

$corn_log .= $htmlLineBrakes . $MSG['3500_1015613'];
$corn_log .= '<strong>' . $relisted . '</strong>' . $MSG['3500_1015614'];

$corn_log .= $htmlLineBrakes . $MSG['3500_1015611'];
$corn_log .= '<strong>' . $suspend . '</strong>' . $MSG['3500_1015612'];

$corn_log .= $htmlLineBrakes . $MSG['3500_1015590'];
$corn_log .= '<strong>' . $closed . '</strong>' . $MSG['3500_1015591'];

$corn_log .= $htmlLineBrakes . $MSG['3500_1015607'];
$corn_log .= '<strong>' . $sent_winner_emails . '</strong>' . $MSG['3500_1015608'];

$corn_log .= $htmlLineBrakes . $MSG['3500_1015609'];
$corn_log .= '<strong>' . $sent_seller_emails . '</strong>' . $MSG['3500_1015610'];

$system->writesetting("counters", "auctions", $system->COUNTERS['auctions'] - $count_auctions, 'int');
$system->writesetting("counters", "closedauctions", $system->COUNTERS['closedauctions'] + $count_auctions, 'int');

if (count($categories) > 0)
{
	foreach ($categories as $cat_id => $category)
	{
		if ($category['updated'])
		{
			$query = "UPDATE " . $DBPrefix . "categories SET
					 counter = :counter,
					 sub_counter = :sub_counter
					 WHERE cat_id = :cat_id";
			$params = array(
				array(':counter', $category['counter'], 'int'),
				array(':sub_counter', $category['sub_counter'], 'int'),
				array(':cat_id', $cat_id, 'int')
			);
			$db->query($query, $params);
		}
	}
}


// "remove" old Unpaid auctions (archive them)
$expiredUnpaidTime = $NOW - 60 * 60 * 24 * $system->SETTINGS['expire_unpaid_items'];
$query = "SELECT id FROM " . $DBPrefix . "winners WHERE closingdate <= :expiredTime AND paid = 0";
$params = array(
	array(':expiredTime', $expiredUnpaidTime, 'int')
);
$db->query($query, $params);
$deleted_unpaid = 0;
if ($db->numrows('id') > 0)
{
	foreach ($db->fetchall() as $UnpaidInfo)
	{
		// delete Unpaid auctions
		$query = "DELETE FROM " . $DBPrefix . "winners WHERE id = :winner_id";
		$params = array(
			array(':winner_id', $UnpaidInfo['id'], 'int')
		);
		$db->query($query, $params);
		$deleted_unpaid++;
	}
}
$corn_log .= $htmlLineBrakes . $MSG['3500_1015605'];
$corn_log .= '<strong>' . $deleted_unpaid . '</strong>' . $MSG['3500_1015606'];

// "remove" old auctions (archive them)
$expiredTime = $NOW - 60 * 60 * 24 * $system->SETTINGS['archiveafter'];
$query = "SELECT id FROM " . $DBPrefix . "auctions WHERE ends <= :expiredTime";
$params = array(
	array(':expiredTime', $expiredTime, 'int')
);
$db->query($query, $params);
$archive_auctions = 0;
if ($db->numrows('id') > 0)
{
	foreach ($db->fetchall() as $AuctionInfo)
	{
		// delete auction
		$query = "DELETE FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
		$params = array(
			array(':auc_id', $AuctionInfo['id'], 'int')
		);
		$db->query($query, $params);

		// delete bids for this auction
		$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :auc_id";
		$params = array(
			array(':auc_id', $AuctionInfo['id'], 'int')
		);
		$db->query($query, $params);

		// Delete proxybid entries
		$query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = :auc_id";
		$params = array(
			array(':auc_id', $AuctionInfo['id'], 'int')
		);
		$db->query($query, $params);

		// Delete counter entries
		$query = "DELETE FROM " . $DBPrefix . "auccounter WHERE auction_id = :auc_id";
		$params = array(
			array(':auc_id', $AuctionInfo['id'], 'int')
		);
		$db->query($query, $params);

		// Delete all images
		if (file_exists(UPLOAD_PATH . $AuctionInfo['id']))
		{
			if ($dir = @opendir(UPLOAD_PATH . $AuctionInfo['id']))
			{
				while ($file = readdir($dir))
				{
					if ($file != '.' && $file != '..')
					{
						@unlink(UPLOAD_PATH . $AuctionInfo['id'] . '/' . $file);
					}
				}
				closedir($dir);
				@rmdir(UPLOAD_PATH . $AuctionInfo['id']);
			}
		}
		$archive_auctions++;
	}
}
$corn_log .= $htmlLineBrakes . $MSG['3500_1015594'];
$corn_log .= '<strong>' . $archive_auctions . '</strong>' . $MSG['3500_1015595'];


// send cumulative emails
$query = "SELECT id, name, email FROM " . $DBPrefix . "users WHERE endemailmode = :emailmode";
$params = array(
	array(':emailmode', 'cum', 'str')
);
$db->query($query, $params);
$cumulative_emails = 0;
foreach ($db->fetchall() as $row)
{
	$cum_query = "SELECT * FROM " . $DBPrefix . "pendingnotif WHERE thisdate < :date AND seller_id = :seller_id";
	$cum_params = array(
		array(':date', $NOWDATE, 'int'),
		array(':seller_id', $row['id'], 'int')
	);
	$db->query($cum_query, $cum_params);

	if ($db->numrows() > 0)
	{
		foreach ($db->fetchall() as $pending)
		{
			$Auction = unserialize($pending['auction']);
			$Seller = unserialize($pending['seller']);
			$report .= "-------------------------------------------------------------------------\n" . 
						$Auction['title'] . "\n" . 
						"-------------------------------------------------------------------------\n";
			if(strlen($pending['winners']) > 0)
			{
				$report .= $MSG['453'] . ':' . "\n" . $pending['winners'] . "\n\n";
			}
			else
			{
				$report .= $MSG['1032']."\n\n";
			}
			$query = "DELETE FROM " . $DBPrefix . "pendingnotif WHERE id = :pending_id";
			$params = array(
				array(':pending_id', $pending['id'], 'int')
			);
			$db->query($query, $params);
		}
		$send_email->cumulative($report, $row['name'], $row['email'], $row['id']);
		$cumulative_emails++;
	}
}
$corn_log .= $htmlLineBrakes . $MSG['3500_1015603'];
$corn_log .= '<strong>' . $cumulative_emails . '</strong>' . $MSG['3500_1015604'];

// send buyer fee emails
$fee_emails = 0;
if ($buyer_fee > 0)
{
	for ($i = 0; $i < count($buyer_emails); $i++)
	{
		$send_email->buyer_fee_email($buyer_emails[$i]['id'], $buyer_emails[$i]['title'], $buyer_emails[$i]['name'], $Auction['id'], $buyer_emails[$i]['uid'], $buyer_emails[$i]['email']);
		$fee_emails++;
	}
}
for ($i = 0; $i < count($seller_emails); $i++)
{
	$send_email->final_value_fee_email($seller_emails[$i]['id'], $seller_emails[$i]['title'], $seller_emails[$i]['name'], $Auction['id'], $Auction['id'], $seller_emails[$i]['uid'], $seller_emails[$i]['email']);
	$fee_emails++;
}

$corn_log .= $htmlLineBrakes . $MSG['3500_1015602'];
$corn_log .= '<strong>' . $fee_emails . '</strong>' . $MSG['3500_1015601'];

$cronHandler->updateSiteCounters();
$cronHandler->updateCategories();

$corn_log .= $cronHandler->purgThumbnailsCache();
$corn_log .= $cronHandler->checkCronLogs();

// finish cron script and submit it to db
if($system->SETTINGS['cronlog'] == 'y')
{
	$cronHandler->printLog($corn_log);
}