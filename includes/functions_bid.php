<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/


include 'datacheck.inc.php';

$NOW = $system->CTIME;
$get_name = $_REQUEST['id'] ;  //NEW get the full product name
$get_array = explode('-',htmlentities($system->uncleanvars($get_name), ENT_COMPAT, $CHARSET)) ;  //NEW split the product name into segments and put into an array (product id must be separated by '-' )
$get_id = end($get_array) ; //NEW extract the last array i.e product id form full product name
$id = (isset($_SESSION['CURRENT_ITEM'])) ? intval($_SESSION['CURRENT_ITEM']) : 0;
$id = (isset($get_id)) ? intval($get_id) : 0; if (!is_numeric($id)) $id = 0;

$bid = isset($_POST['bid']) ? $_POST['bid'] : '';
$qty = (isset($_POST['qty'])) ? intval($_POST['qty']) : 1;
$bid_action = isset($_POST['action']) ? $_POST['action'] : '';
$bidder_id = isset($user->user_data['id']) ? $user->user_data['id'] : '';
$bidding_ended = false;

function get_increment($val, $input_check = true)
{
	global $system, $DBPrefix, $db;

	if ($input_check)
		$val = $system->input_money($val);
	$query = "SELECT increment FROM " . $DBPrefix . "increments 
	WHERE ((low <= :low AND high >= :high) OR (low <= :lower AND high <= :higher)) ORDER BY increment DESC";
	$params = array(
		array(':low', $val, 'float'),
		array(':high', $val, 'float'),
		array(':lower', $val, 'float'),
		array(':higher', $val, 'float')
	);
	$db->query($query, $params);
	$increment = $db->result('increment');
	return $increment;
}

function extend_auction($id, $ends)
{
	global $system, $DBPrefix, $db;

	if ($system->SETTINGS['ae_status'] == 'y' && ($ends - $system->SETTINGS['ae_timebefore']) < $NOW)
	{		
		$extend = $ends + $system->SETTINGS['ae_extend'];
		$query = "UPDATE " . $DBPrefix . "auctions SET ends = :ends WHERE id = :id";
		$params = array(
			array(':id', $id, 'int'),
			array(':ends', $extend, 'int')
		);
		$db->query($query, $params);
	}
}

// first check if valid auction ID passed
$query = "SELECT a.*, u.nick, u.email, u.id AS uId FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (a.user = u.id)
		WHERE a.id = :auc_id";
$params = array(
	array(':auc_id', $id, 'int')
);
$db->query($query, $params);
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
$Data = $db->result();
$item_title = htmlspecialchars($Data['title']);
$item_id = $Data['id'];
$seller_name = $Data['nick'];
$seller_email = $Data['email'];
$atype = $Data['auction_type'];
$aquantity = $Data['quantity'];
$minimum_bid = $Data['minimum_bid'];
$customincrement = $Data['increment'];
$current_bid = $Data['current_bid'];
$pict_url_plain = $Data['pict_url'];
$reserve = $Data['reserve_price'];
$numBids = $Data['num_bids'];
$c = $Data['ends'];
$cbid = ($current_bid == 0) ? $minimum_bid : $current_bid;
if (($Data['ends'] <= $NOW || $Data['closed']) && !isset($errmsg))
{
	$errmsg = $ERR['614'];
}
if (($Data['starts'] > $NOW) && !isset($errmsg))
{
	$errmsg = $ERR['073'];
}
if ($aquantity < $qty)
{
	$errmsg = $ERR['608'];
}
$query = "SELECT bid, bidder FROM " . $DBPrefix . "bids WHERE auction = :auc_id ORDER BY bid DESC, id DESC LIMIT 1";
$params = array(
	array(':auc_id', $id, 'int')
);
$db->query($query, $params);
$last_highest_bid = array();
if ($db->numrows() > 0)
{
	$last_highest_bid = $db->result();
	$high_bid = $last_highest_bid['bid'];
	$WINNING_BIDDER = $last_highest_bid['bidder'];
	$ARETHEREBIDS = ' | <a href="' . $system->SETTINGS['siteurl'] . 'item.php?id=' . $id . '&history=view#history">' . $MSG['105'] . '</a>';
}
else
{
	$high_bid = $current_bid;
	$WINNING_BIDDER = 0;
}
if ($customincrement > 0)
{
	$increment = $customincrement;
}
else
{
	$increment = get_increment($high_bid, false);
}
if (ceil($high_bid) == 0 || $atype == 2)
{
	$next_bid = $minimum_bid;
}
else
{
	$next_bid = $high_bid + $increment;
}
if (isset($_POST['action']) && !isset($errmsg))
{
	// check the bid is valid
	if (!$system->CheckMoney($bid) && !isset($errmsg))
	{
		$errmsg = $ERR['058'];
	}
	else
	{
		// reformat bid to valid number
		$bid = round($system->input_money($bid), 2);
	}

	$tmpmsg = CheckBidData();
	if ($tmpmsg != 0 && !isset($errmsg))
	{
		$errmsg = $ERR[$tmpmsg];
	}
	if ($system->SETTINGS['usersauth'] == 'y')
	{
		if (strlen($_POST['password']) == 0)
		{
			$errmsg = $ERR['004'];
		}
		if (!($phpass->CheckPassword($_POST['password'], $user->user_data['password'])))
		{
			$errmsg = $ERR['611'];
		}
	}
	$sendEmail = false;
	$sendSMS = false;
	// make the bid
	if ($atype == 1 && !isset($errmsg)) // normal auction
	{
		if ($system->SETTINGS['proxy_bidding'] == 'n')
		{
			// is it the highest bid?
			if ($current_bid < $bid)
			{
				// did you outbid someone?
				$query = "SELECT u.id FROM " . $DBPrefix . "bids b, " . $DBPrefix . "users u WHERE b.auction = :auc_id AND b.bidder = u.id and u.suspended = 0 ORDER BY bid DESC";
				$params = array(
					array(':auc_id', $id, 'int')
				);
				$db->query($query, $params);
				// send outbid email if there are previous bidders and they where not you
				if ($db->numrows() > 0 && $db->result('bidder') != $bidder_id)
				{
					$sendEmail = true;
					$sendSMS = true;
				}
				// Also update bids table
				$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
				$params = array(
					array(':bid', $bid, 'float'),
					array(':auc_id', $id, 'int'),
					array(':bidder_id', $bidder_id, 'int'),
					array(':time', $NOW, 'int'),
					array(':qty', $qty, 'int')
				);
				$db->query($query, $params);
				$current_bid_id = $db->lastInsertId();
				$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :bid, num_bids = :bids + 1 WHERE id = :auc_id";
				$params = array(
					array(':bids', $numBids,'int'),
					array(':bid', $bid, 'float'),
					array(':current_bid_id', $current_bid_id, 'int'),
					array(':auc_id', $id, 'int')
				);
				$db->query($query, $params);
				extend_auction($item_id, $c);
				$bidding_ended = true;
			}
		}
		elseif ($WINNING_BIDDER == $bidder_id)
		{
			$query = "SELECT bid FROM " . $DBPrefix . "proxybid p
					LEFT JOIN " . $DBPrefix . "users u ON (p.userid = u.id)
					WHERE userid = :user_id AND itemid = :item_id ORDER BY bid DESC";
			$params = array(
				array(':user_id', $user->user_data['id'], 'int'),
				array(':item_id', $id, 'int')
			);
			$db->query($query, $params);
			if ($db->numrows() > 0)
			{
				$WINNER_PROXYBID = $db->result('bid');
				if ($WINNER_PROXYBID >= $bid)
				{
					$errmsg = $ERR['040'];
				}
				else
				{
					// Just update proxy_bid
					$query = "UPDATE " . $DBPrefix . "proxybid SET bid = :newbid
								WHERE userid = :user_id
								AND itemid = :item_id AND bid = :oldbid";
					$params = array(
						array(':user_id', $user->user_data['id'], 'int'),
						array(':item_id', $id, 'int'),
						array(':oldbid', $WINNER_PROXYBID, 'float'),
						array(':newbid', $bid, 'float')
					);
					$db->query($query, $params);
					if ($reserve > 0 && $reserve > $current_bid && $bid >= $reserve)
					{
						// Also update bids table
						$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :reserve, :time, :qty)";
						$params = array(
							array(':reserve', $reserve, 'float'),
							array(':auc_id', $id, 'int'),
							array(':bidder_id', $bidder_id, 'int'),
							array(':time', $NOW, 'int'),
							array(':qty', $qty, 'int')
						);
						$db->query($query, $params);
						$current_bid_id = $db->lastInsertId();
						$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :reserve, num_bids = :bids + 1 WHERE id = :auc_id";
						$params = array(
							array(':bids', $numBids, 'int'),
							array(':reserve', $reserve, 'float'),
							array(':current_bid_id', $current_bid_id, 'int'),
							array(':auc_id', $id, 'int')
						);
						$db->query($query, $params);
					}
					extend_auction($item_id, $c);
					$bidding_ended = true;
				}
			}
		}
		if (!$bidding_ended && !isset($errmsg) && $system->SETTINGS['proxy_bidding'] == 'y')
		{
			$query = "SELECT p.userid, p.bid FROM " . $DBPrefix . "proxybid p, " . $DBPrefix . "users u WHERE itemid = :item_id AND p.userid = u.id and u.suspended = 0 ORDER by bid DESC LIMIT 1";
			$params = array(
				array(':item_id', $id, 'int')
			);
			$db->query($query, $params);
			if ($db->numrows() == 0) // First bid
			{
				$query = "INSERT INTO " . $DBPrefix . "proxybid VALUES (:auc_id, :bidder_id, :bid)";
				$params = array(
					array(':auc_id', $id, 'int'),
					array(':bidder_id', $bidder_id, 'int'),
					array(':bid', $bid, 'float')
				);
				$db->query($query, $params);
				if ($reserve > 0 && $reserve > $current_bid && $bid >= $reserve)
				{
					$next_bid = $reserve;
				}
				// Also update bids table
				$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
				$params = array(
					array(':auc_id', $id, 'int'),
					array(':bidder_id', $bidder_id, 'int'),
					array(':bid', $next_bid, 'float'),
					array(':time', $NOW, 'int'),
					array(':qty', $qty, 'int')
				);
				$db->query($query, $params);
				$current_bid_id = $db->lastInsertId();
				// Only updates current bid if it is a new bidder, not the current one
				$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :bid, num_bids = :bids + 1 WHERE id = :auc_id";
				$params = array(
					array(':bids', $numBids, 'int'),
					array(':auc_id', $id, 'int'),
					array(':current_bid_id', $current_bid_id, 'int'),
					array(':bid', $next_bid, 'float')
				);
				$db->query($query, $params);
				$system->writesetting("counters", "bids", $system->COUNTERS['bids'] + 1, 'int');
			}
			else // This is not the first bid
			{
				$proxy_bid_data = $db->result();
				$proxy_bidder_id = $proxy_bid_data['userid'];
				$proxy_max_bid = $proxy_bid_data['bid'];
				if ($proxy_max_bid < $bid)
				{
					if ($proxy_bidder_id != $bidder_id)
					{
						$sendEmail = true;
						$sendSMS = true;
					}
					$next_bid = $proxy_max_bid + $increment;
					if (($proxy_max_bid + $increment) > $bid)
					{
						$next_bid = $bid;
					}
					$query = "SELECT userid, itemid FROM " . $DBPrefix . "proxybid WHERE itemid = :item_id AND userid = :bidder_id";
					$params = array(
						array(':item_id', $id, 'int'),
						array(':bidder_id', $bidder_id, 'int')
					);
					$db->query($query, $params);
					if ($db->numrows() == 0)
					{
						$query = "INSERT INTO " . $DBPrefix . "proxybid VALUES (:auc_id, :bidder_id, :bid)";
						$params = array(
							array(':auc_id', $id, 'int'),
							array(':bidder_id', $bidder_id, 'int'),
							array(':bid', $bid, 'float')
						);
						$db->query($query, $params);
					}
					else
					{
						$query = "UPDATE " . $DBPrefix . "proxybid SET bid = :newbid WHERE userid = :bidder_id AND itemid = :item_id";
						$params = array(
							array(':bidder_id', $bidder_id, 'int'),
							array(':item_id', $id, 'int'),
							array(':newbid', $bid, 'float')
						);
						$db->query($query, $params);
					}
					if ($reserve > 0 && $reserve > $current_bid && $bid >= $reserve)
					{
						$next_bid = $reserve;
					}
					// Fake bid to maintain a coherent history
					if ($current_bid < $proxy_max_bid)
					{
						$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
						$params = array(
							array(':auc_id', $id, 'int'),
							array(':bidder_id', $proxy_bidder_id, 'int'),
							array(':bid', $proxy_max_bid, 'float'),
							array(':time', $NOW, 'int'),
							array(':qty', $qty, 'int')
						);
						$db->query($query, $params);
						$fakebids = 1;
					}
					else
					{
						$fakebids = 0;
					}
					// Update bids table
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
					$params = array(
						array(':auc_id', $id, 'int'),
						array(':bidder_id', $bidder_id, 'int'),
						array(':bid', $next_bid, 'float'),
						array(':time', $NOW, 'int'),
						array(':qty', $qty, 'int')
					);
					$db->query($query, $params);
					$current_bid_id = $db->lastInsertId();
					$system->writesetting("counters", "bids", $system->COUNTERS['bids'] + 1 + $fakebids, 'int');
					$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :bid, num_bids = (:bids + 1 + :fakebids) WHERE id = :auc_id";
					$params = array(
						array(':bids', $numBids, 'int'),
						array(':bid', $next_bid, 'float'),
						array(':current_bid_id', $current_bid_id, 'int'),
						array(':fakebids', $fakebids, 'int'),
						array(':auc_id', $id, 'int')
					);
					$db->query($query, $params);
				}
				elseif ($proxy_max_bid == $bid)
				{
					$cbid = $proxy_max_bid;
					$errmsg = $MSG['701'];
					// Update bids table
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
					$params = array(
						array(':auc_id', $id, 'int'),
						array(':bidder_id', $bidder_id, 'int'),
						array(':bid', $bid, 'float'),
						array(':time', $NOW, 'int'),
						array(':qty', $qty, 'int')
					);
					$db->query($query, $params);
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
					$params = array(
						array(':auc_id', $id, 'int'),
						array(':bidder_id', $proxy_bidder_id, 'int'),
						array(':bid', $cbid, 'float'),
						array(':time', $NOW, 'int'),
						array(':qty', $qty, 'int')
					);
					$db->query($query, $params);
					$current_bid_id = $db->lastInsertId();
					$system->writesetting("counters", "bids", $system->COUNTERS['bids'] + 2, 'int');
					$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :bid, num_bids = :bids + 2 WHERE id = :auc_id";
					$params = array(
						array(':bids', $numBids, 'int'),
						array(':auc_id', $id, 'int'),
						array(':current_bid_id', $current_bid_id, 'int'),
						array(':bid', $cbid, 'float')
					);
					$db->query($query, $params);
					if ($customincrement == 0)
					{
						// get new increment
						$increment = get_increment($cbid);
					}
					else
					{
						$increment = $customincrement;
					}
					$next_bid = $cbid + $increment;
				}
				elseif ($proxy_max_bid > $bid)
				{
					// Update bids table
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
					$params = array(
						array(':auc_id', $id, 'int'),
						array(':bidder_id', $bidder_id, 'int'),
						array(':bid', $bid, 'float'),
						array(':time', $NOW, 'int'),
						array(':qty', $qty, 'int')
					);
					$db->query($query, $params);
					if ($customincrement == 0)
					{
						// get new increment
						$increment = get_increment($bid);
					}
					else
					{
						$increment = $customincrement;
					}
					if ($bid + $increment - $proxy_max_bid >= 0)
					{
						$cbid = $proxy_max_bid;
					}
					else
					{
						$cbid = $bid + $increment;
					}
					$errmsg = $MSG['701'];
					// Update bids table
					$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
					$params = array(
						array(':auc_id', $id, 'int'),
						array(':bidder_id', $proxy_bidder_id, 'int'),
						array(':bid', $cbid, 'float'),
						array(':time', $NOW, 'int'),
						array(':qty', $qty, 'int')
					);
					$db->query($query, $params);
					$current_bid_id = $db->lastInsertId();
					$system->writesetting("counters", "bids", $system->COUNTERS['bids'] + 2, 'int');
					$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :bid, num_bids = :bids + 2 WHERE id = :auc_id";
					$params = array(
						array(':bids', $numBids, 'int'),
						array(':auc_id', $id, 'int'),
						array(':current_bid_id', $current_bid_id, 'int'),
						array(':bid', $cbid, 'float')
					);
					$db->query($query, $params);
					if ($customincrement == 0)
					{
						// get new increment
						$increment = get_increment($cbid);
					}
					else
					{
						$increment = $customincrement;
					}
					$next_bid = $cbid + $increment;
				}
			}
			extend_auction($item_id, $c);
		}
	}
	elseif ($atype == 2 && !isset($errmsg)) // dutch auction
	{
		// If the bidder already bid on this auction there new bbid must be higher
		$query = "SELECT bid, quantity FROM " . $DBPrefix . "bids WHERE bidder = :bidder_id AND auction = :auc_id ORDER BY bid DESC LIMIT 1";
		$params = array(
			array(':auc_id', $id, 'int'),
			array(':bidder_id', $bidder_id, 'int')
		);
		$db->query($query, $params);
		if ($db->numrows() > 0)
		{
			$PREVIOUSBID = $db->result();
			if (($bid * $qty) <= ($PREVIOUSBID['bid'] * $PREVIOUSBID['quantity']))
			{
				$errmsg = $ERR['059'];
			}
		}
		if (!isset($errmsg))
		{
			$query = "INSERT INTO " . $DBPrefix . "bids VALUES (NULL, :auc_id, :bidder_id, :bid, :time, :qty)";
			$params = array(
				array(':auc_id', $id, 'int'),
				array(':bidder_id', $bidder_id, 'int'),
				array(':bid', $bid, 'float'),
				array(':time', $NOW, 'int'),
				array(':qty', $qty, 'int')
			);
			$db->query($query, $params);
			$current_bid_id = $db->lastInsertId();
			$system->writesetting("counters", "bids", $system->COUNTERS['bids'] + 1, 'int');
			$query = "UPDATE " . $DBPrefix . "auctions SET current_bid = :bid, num_bids = :bids + 1 WHERE id = :auc_id";
			$params = array(
				array(':bids', $numBids, 'int'),
				array(':auc_id', $id, 'int'),
				array(':current_bid_id', $current_bid_id, 'int'),
				array(':bid', $bid, 'float')
			);
			$db->query($query, $params);
		}
	}
	// if there was a previous bidder tell them they have been outbid
	if (count($last_highest_bid) > 0)
	{
		$OldWinner_id = $last_highest_bid['bidder'];
		$query = "SELECT nick, name, email FROM " . $DBPrefix . "users WHERE id = :user_id";
		$params = array(
			array(':user_id', $OldWinner_id, 'int')
		);
		$db->query($query, $params);
		$OldWinner = $db->result();
		$OldWinner_nick = $OldWinner['nick'];
		$OldWinner_name = $OldWinner['name'];
		$OldWinner_email = $OldWinner['email'];
	}
	// Update counters table with the new bid
	// Send notification if auction id matches (Item Watch)
	$query = "SELECT name, email, item_watch, id FROM " . $DBPrefix . "users WHERE item_watch LIKE :auc_id AND id != :user_id";
	$params = array(
		array(':user_id', $bidder_id, 'int'),
		array(':auc_id', '%' . $id . '%', 'str')
	);
	$db->query($query, $params);
	foreach ($db->fetchall() as $row)
	{
		// double check there is a match
		$watch_values = explode(' ', $row['item_watch']);
		if (in_array(strval($id), $watch_values))
		{
			// Get data about the auction
			$query = "SELECT title, current_bid FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
			$params = array(
				array(':auc_id', $id, 'int')
			);
			$db->query($query, $params);
			$auction_data = $db->result();
			// Send e-mail message	
			$send_email->item_watch_emails($row['name'], $auction_data['title'], $auction_data['current_bid'], $id, $row['id'], $row['email']);
		}
	}
	// End of Item watch
	if($sendEmail)
	{
		$sendSMS = true;
		$month = date('m', $NOW);
		$ends_string = $MSG['MON_0' . $month] . ' ' . date('d, Y H:i', $NOW);
		$new_bid = $system->print_money($next_bid);
		
		// Send SMS Alert
		$smsAlerts->alertSettingHandler('outBiddedAlert', array('userID' => $OldWinner_id));

		// Send e-mail message
		$send_email->outbid($item_title, $OldWinner_name, $high_bid, $new_bid, $ends_string, $item_id, $OldWinner_id, $OldWinner_email, $pict_url_plain);
	}
	if (defined('TrackUserIPs'))
	{
		// log auction bid IP
		$system->log('user', 'Bid $' . $bid . '(previous bid was $' . $current_bid . ') on Item', $bidder_id, $id);
	}
}

// just set the needed template variables
$template->assign_vars(array(
	'PAGE' => 1,
	'ERROR' => (isset($errmsg)) ? '<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> ' . $errmsg . '</div>' : '',
	'BID_HISTORY' => (isset($ARETHEREBIDS)) ? $ARETHEREBIDS : '',
	'ID' => $id,
	'SEO_TITLE' => generate_seo_link($item_title),
	'TITLE' => $item_title,
	'CURRENT_BID' => $system->print_money($cbid),
	'ATYPE' => $atype,
	'BID' => $system->print_money_nosymbol($bid),
	'NEXT_BID' => $system->print_money($next_bid),
	'QTY' => $qty,
	'TQTY' => $aquantity,
	'AGREEMENT' => sprintf($MSG['25_0086'], $system->print_money($qty * $bid)),
	'CURRENCY' => $system->SETTINGS['currency'],
	'B_USERAUTH' => ($system->SETTINGS['usersauth'] == 'y')
));