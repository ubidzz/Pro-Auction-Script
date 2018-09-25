<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
if (!defined('InProAuctionScript')) exit('Access denied');

function get_messages($user_id) 
{ 
	global $DBPrefix, $system, $db;
	
	$NOW = $system->CTIME;
	$data = array();
	// Count number of new messages
	$query = "SELECT COUNT(*) AS total FROM " . $DBPrefix . "messages 
		WHERE isread = 0 AND sentto = :user_ids";
	$params = array();
	$params[] = array(':user_ids', $user_id, 'int');
	$db->query($query, $params);
	$data0 = $db->result('total');
	if ($data0 > 0)
	{
		$data[] = $data0;
	}
	else
	{
		$data[] = 0;
	}
	// Count auctions sold item
	$query = "SELECT COUNT(a.id) AS total FROM " . $DBPrefix . "winners a
		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
		WHERE (b.closed = 1 OR b.bn_only = :yes) AND b.suspended = 0
		AND ((a.seller = :seller_id AND a.feedback_sel = 0) OR (a.winner = :user_ids AND a.feedback_win = 0))
		AND a.paid = 1";
	$params = array();
	$params[] = array(':yes', 'y', 'bool');
	$params[] = array(':seller_id', $user_id, 'int');
	$params[] = array(':user_ids', $user_id, 'int');
	$db->query($query, $params);	
	$data1 = $db->result('total');
	if ($data1 > 0)
	{
		$data[] = $data1;
	}
	else
	{
		$data[] = 0;
	}
	// Count auctions still requiring payment
	$query = "SELECT COUNT(DISTINCT a.id) AS total FROM " . $DBPrefix . "winners a
		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
		WHERE b.id = a.auction AND (b.closed = 1 OR b.bn_only = 'y') AND a.seller = :sellers AND a.paid = 0";
	$params = array();
	$params[] = array(':sellers', $user_id, 'int');
	$db->query($query, $params);
	$data2 = $db->result('total');
	if ($data2 > 0)
	{
		$data[] = $data2;
	}
	else
	{
		$data[] = 0;
	}

	// Count auctions ending soon
	$query = "SELECT item_watch FROM " . $DBPrefix . "users WHERE id = :user";
	$params = array();
	$params[] = array(':user', $user_id, 'int');
	$db->query($query, $params);
	$watch = $db->result('item_watch');
	$items = trim($system->cleanvars($watch));
	
	$item = preg_split('/ /', $items);
	$total = count($item);
	$itemids = 0;
	for ($j = 0; $j < $total; $j++)
	{
		$itemids .= ',' . $item[$j];
		
	}
	$query = "SELECT COUNT(DISTINCT id) AS total FROM " . $DBPrefix . "auctions 
	WHERE ends <= (:timeing) AND id IN (" . $itemids . ")";
	$params = array();
	$params[] = array(':timeing', $NOW + (3600 * 24), 'int');
	$db->query($query, $params);
	$data3 = $db->result('total');
	if ($data3 > 0)
	{
		$data[] = $data3;
	}
	else
	{
		$data[] = 0;
	}
	// Count outbid auctions
	$query = "SELECT a.current_bid, a.id, a.title, a.ends, b.bid 
			FROM " . $DBPrefix . "auctions a, " . $DBPrefix . "bids b
			WHERE a.id = b.auction AND a.closed = 0 AND b.bidder = :seller
			AND a.bn_only = :no ORDER BY a.ends ASC, b.bidwhen DESC";
	$params = array();
	$params[] = array(':seller', $user_id, 'int');
	$params[] = array(':no', 'n', 'bool');
	$db->query($query, $params);
	$idcheck = array();
	$auctions_count = 0;
	while ($row = $db->result())
	{
		if (!in_array($row['id'], $idcheck))
		{
			// Outbidded or winning bid
			if ($row['current_bid'] != $row['bid']) $auctions_count++;;
			$idcheck[] = $row['id'];
		}
	}
	$data[] = $auctions_count;
	// Count auctions received payment
	$query = "SELECT COUNT(DISTINCT a.id) AS total FROM " . $DBPrefix . "winners a
		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
		WHERE (b.closed = 1 OR b.bn_only = :bnonly) AND a.seller = :sellers AND a.paid = 1";
	$params = array();
	$params[] = array(':bnonly', 'y', 'str');
	$params[] = array(':sellers', $user_id, 'int');
	$db->query($query, $params);
	$data5 = $db->result('total');
	if ($data5 > 0)
	{
		$data[] = $data5;
	}
	else
	{
		$data[] = 0;
	}
	// Count auctions sold item
	$query = "SELECT COUNT(DISTINCT a.id) AS total FROM " . $DBPrefix . "winners a
		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
		WHERE (b.closed = 1 OR b.bn_only = :bnonly) AND a.seller = :sellers";
	$params = array();
	$params[] = array(':bnonly', 'y', 'bool');
	$params[] = array(':sellers', $user_id, 'int');
	$db->query($query, $params);
	$data6 = $db->result('total');
	if ($data6 > 0)
	{
		$data[] = $data6;
	}
	else
	{
		$data[] = 0;
	}
	// count closed auctions
	$query = "SELECT COUNT(id) AS total FROM " . $DBPrefix . "auctions 
		WHERE user = :user_id AND closed = 1 AND suspended = 0
		AND (num_bids = 0 OR (num_bids > 0 AND reserve_price > 0 
		AND current_bid < reserve_price AND sold = :item_sold))";
	$params[] = array(':user_id', $user_id, 'int');
	$params[] = array(':item_sold', 'n', 'bool');
	$db->query($query, $params);
	$data7 = $db->result('total');
	if ($data7 > 0)
	{
		$data[] = $data7;
	}
	else
	{
		$data[] = 0;
	}
	// count active auctions
	$query = "SELECT COUNT(id) AS total FROM " . $DBPrefix . "auctions 
		WHERE user = :user AND closed = 0 AND starts <= :now AND suspended = 0";
	$params = array();
	$params[] = array(':user', $user_id, 'int');
	$params[] = array(':now', $NOW, 'int');
	$db->query($query, $params);
	$data8 = $db->result('total');
	if ($data8 > 0)
	{
		$data[] = $data8;
	}
	else
	{
		$data[] = 0;
	}
	// count suspended auctions
	$query = "SELECT COUNT(id) AS total FROM " . $DBPrefix . "auctions 
		WHERE user = :user_id AND starts < :now AND suspended = 1";
	$params = array();
	$params[] = array(':user_id', $user_id, 'int');
	$params[] = array(':now', $NOW, 'int');
	$db->query($query, $params);
	$data9 = $db->result('total');
	if ($data9 > 0)
	{
		$data[] = $data9;
	}
	else
	{
		$data[] = 0;
	}
	// Count number of new support messages
	$query = "SELECT COUNT(id) AS total FROM " . $DBPrefix . "support 
		WHERE user = :id AND ticket_reply_status = :reply_status AND status =:ticket_status";
	$params = array();
	$params[] = array(':id', $user_id, 'int');
	$params[] = array(':reply_status', 'user', 'bool');
	$params[] = array(':ticket_status', 'open', 'bool');
	$db->query($query, $params);
	$data10 = $db->result('total');
	if ($data10 > 0)
	{
		$data[] = $data10;
	}
	else
	{
		$data[] = 0;
	}
	// count pending auctions
	$query = "SELECT COUNT(id) AS total FROM " . $DBPrefix . "auctions 
		WHERE user = :user AND closed = 0 AND starts <= :now AND suspended = 9";
	$params = array();
	$params[] = array(':user', $user_id, 'int');
	$params[] = array(':now', $NOW, 'int');
	$db->query($query, $params);
	$data11 = $db->result('total');
	if ($data11 > 0)
	{
		$data[] = $data11;
	}
	else
	{
		$data[] = 0;
	}
	// Count number feedbacks
	$query = "SELECT COUNT(a.auction) AS total FROM " . $DBPrefix . "winners a
			LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
			WHERE (b.closed = 1 OR b.bn_only = 'y') AND b.suspended = 0 AND a.paid = 1 
			AND ((a.seller = :user AND a.feedback_sel = 1) OR (a.winner = :user AND a.feedback_win = 1))";
	$params = array();
	$params[] = array(':user', $user_id, 'int');
	$db->query($query, $params);
	$data12 = $db->result('total');
	if ($data12 > 0)
	{
		$data[] = $data12;
	}
	else
	{
		$data[] = 0;
	}
	// Count sold auctions (Outstanding.php)
	$query = "SELECT COUNT(DISTINCT a.id) AS total FROM " . $DBPrefix . "winners a
		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
		WHERE (b.closed = 1 OR b.bn_only = :bnonly) AND a.winner = :winner_id AND a.paid = 0";
	$params = array();
	$params[] = array(':bnonly', 'y', 'bool');
	$params[] = array(':winner_id', $user_id, 'int');
	$db->query($query, $params);
	$data13 = $db->result('total');
	if ($data13 > 0)
	{
		$data[] = $data13;
	}
	else
	{
		$data[] = 0;
	}
	// Count buyer won auctions (buying.php)
	$query = "SELECT COUNT(DISTINCT a.id) AS total FROM " . $DBPrefix . "winners a
		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)
		WHERE (b.closed = 1 OR b.bn_only = :bnonly) AND a.winner = :winner";
	$params = array();
	$params[] = array(':bnonly', 'y', 'bool');
	$params[] = array(':winner', $user_id, 'int');
	$db->query($query, $params);
	$data14 = $db->result('total');
	if ($data14 > 0)
	{
		$data[] = $data14;
	}
	else
	{
		$data[] = 0;
	}
	// Count digital items (my_downloads.php)
	$query = "SELECT COUNT(DISTINCT a.id) AS total FROM " . $DBPrefix . "winners a
		LEFT JOIN " . $DBPrefix . "digital_items d ON (a.auction = d.auctions)
		WHERE a.winner = :winner AND d.auctions = a.auction";
	$params = array();
	$params[] = array(':winner', $user_id, 'int');
	$db->query($query, $params);
	$data15 = $db->result('total');
	if ($data15 > 0)
	{
		$data[] = $data15;
	}
	else
	{
		$data[] = 0;
	}
	// Count keyword items
	$query = "SELECT auc_watch FROM " . $DBPrefix . "users WHERE id = :user";
	$params = array();
	$params[] = array(':user', $user_id, 'int');
	$db->query($query, $params);
	$watch = $db->result('auc_watch');
	$auctions = trim($system->cleanvars($watch));
	$auction = explode(' ', $auctions);
	$counting = !$watch ? 0 : count($auction);
	if ($counting > 0)
	{
		$data[] = $counting;
	}
	else
	{
		$data[] = 0;
	}
	// Count favourite sellers
	$query = "SELECT COUNT(DISTINCT seller_id) AS total FROM " . $DBPrefix . "favesellers WHERE user_id = :user_id";
	$params = array();
	$params[] = array(':user_id', $user_id, 'int');
	$db->query($query, $params);
	$data17 = $db->result('total');
	if ($data17 > 0)
	{
		$data[] = $data17;
	}
	else
	{
		$data[] = 0;
	}
	// Count advertisment
	$query = "SELECT COUNT(DISTINCT id) AS total FROM " . $DBPrefix . "bannersusers WHERE seller = :user_id AND paid = 1";
	$params = array();
	$params[] = array(':user_id', $user_id, 'int');
	$db->query($query, $params);
	$data18 = $db->result('total');
	if ($data18 > 0)
	{
		$data[] = $data18;
	}
	else
	{
		$data[] = 0;
	}


	return $data;
}
if($user->checkAuth())
{
	$new_messages = $user->checkAuth() ? get_messages($user->user_data['id']) : '';
	$template->assign_vars(array(
		'NEW_MESSAGES' => (isset($new_messages) && $new_messages[0] > 0) ? '<div style="float:right">' . $new_messages[0] . ' ' . $MSG['508'] . ' (<a href="' . $system->SETTINGS['siteurl'] . 'mail.php">' . $MSG['5295'] . '</a>)</div>' : '',
		'NEW_MESSAGES2' => (isset($new_messages) && $new_messages[0] > 0) ? '<span class="label label-success pull-right">' . $new_messages[0] . '</span>' : '',		
		'FBTOLEAVE2' => (isset($new_messages) && $new_messages[1] > 0) ? '<span class="label label-success pull-right">' . $new_messages[1] . '</span>' : '',
		
		'SOLD_ITEM2' => (isset($new_messages) && $new_messages[2] > 0) ? '<span class="label label-success pull-right">' . $new_messages[2] . '</span>' : '',
		'SOLD_ITEM4' => (isset($new_messages) && $new_messages[6] > 0) ? '<span class="label label-success pull-right">' . $new_messages[6] . '</span>' : '',

		'CLOSED_AUCTIONS' => (isset($new_messages) && $new_messages[7] > 0) ? '<span class="label label-success pull-right">' . $new_messages[7] . '</span>' : '',
		'ACTIVE_AUCTIONS' => (isset($new_messages) && $new_messages[8] > 0) ? '<span class="label label-success pull-right">' . $new_messages[8] . '</span>' : '',
		'PENDING_AUCTIONS' => (isset($new_messages) && $new_messages[11] > 0) ? '<span class="label label-success pull-right">' . $new_messages[11] . '</span>' : '',
		'SUSPENDED_AUCTIONS' => (isset($new_messages) && $new_messages[9] > 0) ? '<span class="label label-success pull-right">' . $new_messages[9] . '</span>' : '',
		'SUPPORT' => (isset($new_messages) && $new_messages[10] > 0) ? '<span class="label label-success pull-right">' . $new_messages[10] . '</span>' : '',
		'FEEDBACK' => (isset($new_messages) && $new_messages[12] > 0) ? '<span class="label label-success pull-right">' . $new_messages[12] . '</span>' : '',
		'OUTSTANDING' => (isset($new_messages) && $new_messages[13] > 0) ? '<span class="label label-success pull-right">' . $new_messages[13] . '</span>' : '',
		'ITEMS_WON' => (isset($new_messages) && $new_messages[14] > 0) ? '<span class="label label-success pull-right">' . $new_messages[14] . '</span>' : '',
		'MY_DOWNLOADS' => (isset($new_messages) && $new_messages[15] > 0) ? '<span class="label label-success pull-right">' . $new_messages[15] . '</span>' : '',
		'BENDING_SOON' => (isset($new_messages) && $new_messages[3] > 0) ? '<span class="label label-success pull-right">' . $new_messages[3] . '</span>' : '',
		'BOUTBID' => (isset($new_messages) && $new_messages[4] > 0) ? '<span class="label label-success pull-right">' . $new_messages[4] . '</span>' : '',	
		'AUC_KEYWORDS' => (isset($new_messages) && $new_messages[16] > 0) ? '<span class="label label-success pull-right">' . $new_messages[16] . '</span>' : '',
		'FAVSELLER' => (isset($new_messages) && $new_messages[17] > 0) ? '<span class="label label-success pull-right">' . $new_messages[17] . '</span>' : '',
		'BANNER_ACC' => (isset($new_messages) && $new_messages[18] > 0) ? '<span class="label label-success pull-right">' . $new_messages[18] . '</span>' : ''
	));
}
?>