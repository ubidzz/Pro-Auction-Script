<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include INCLUDE_PATH."countries.inc.php";

unset($ERROR);
$id = intval($_GET['id']);

// Data check
if (empty($id) || $id <= 0)
{
	if(isset($_GET['PAGE'])) {
		header('location: listusers.php?PAGE=' . intval($_GET['offset']));
	}else{
		header('location: listusers.php');
	}
	exit;
}

$has_auctions = false;
$has_bids = false;
if (isset($_POST['action']) && $_POST['action'] == $MSG['030'])
{
	$catscontrol = new MPTTcategories();

	// Check if the users has some auction
	$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "auctions WHERE user = :user_id";
	$params = array(
		array(':user_id', $id, 'int')
	);
	$db->query($query, $params);
	$num_auctions = $db->result('COUNT');

	if ($num_auctions > 0)
	{
		$has_auctions = true;
	}

	// Check if the user is BIDDER in some auction
	$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "bids WHERE bidder = :user_id";
	$params = array(
		array(':user_id', $id, 'int')
	);
	$db->query($query, $params);
	$num_bids = $db->result('COUNT');

	if ($num_bids > 0)
	{
		$has_bids = true;
	}

	// check if user is suspended or not
	$query = "SELECT suspended FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array(
		array(':user_id', $id, 'int')
	);
	$db->query($query, $params);
	$suspended = $db->result('suspended');

	// delete user
	$query = "DELETE FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array(
		array(':user_id', $id, 'int')
	);
	$db->query($query, $params);

	if ($has_auctions)
	{
		// update categories table
		$query = "SELECT c.level, c.left_id, c.right_id FROM " . $DBPrefix . "auctions a
				LEFT JOIN " . $DBPrefix . "categories c ON (a.category = c.cat_id)
				WHERE a.user = :user_id";
		$params = array(
			array(':user_id', $id, 'int')
		);
		$db->query($query, $params);
		$auction_data = $db->fetchall();
		foreach ($auction_data as $row)
		{
			$crumbs = $catscontrol->get_bread_crumbs($row['left_id'], $row['right_id']);
			for ($i = 0; $i < count($crumbs); $i++)
			{
				$query = "UPDATE " . $DBPrefix . "categories SET counter = counter - 1, sub_counter = sub_counter - 1 WHERE cat_id = :cat_id";
				$params = array(
					array(':cat_id', $crumbs[$i]['cat_id'], 'int')
				);
				$db->query($query, $params);
			}
		}

		// delete user's auctions
		$query = "DELETE FROM " . $DBPrefix . "auctions WHERE user = :user_id";
		$params = array(
			array(':user_id', $id, 'int')
		);
		$db->query($query, $params);
	}

	if ($has_bids)
	{
		// update auctions table
		$query = "SELECT a.id, a.current_bid, b.bid FROM " . $DBPrefix . "bids b
				LEFT JOIN " . $DBPrefix . "auctions a ON (b.auction = a.id)
				WHERE b.bidder = :user_id ORDER BY b.bid DESC";
		$params = array(
			array(':user_id', $id, 'int')
		);
		$db->query($query, $params);
		$bid_data = $db->fetchall();
		foreach ($bid_data as $row)
		{
			$extraParams = array();
			// check if user is highest bidder
			if ($row['current_bid'] == $row['bid'])
			{
				$query = "SELECT bid FROM " . $DBPrefix . "bids WHERE auction = :auc_id ORDER BY bid DESC LIMIT 1, 1";
				$params = array(
					array(':auc_id', $row['id'], 'int')
				);
				$db->query($query, $params);
				$next_bid = $db->result('bid');
				// set new highest bid
				$extra = ", current_bid = :next_bid";
				$extraParams[] = array(':next_bid', $next_bid, 'float');
			}
			$query = "UPDATE " . $DBPrefix . "auctions SET num_bids = num_bids - 1" . $extra . " WHERE id = :auc_id";
			$extraParams[] = array(':auc_id', $row['id'], 'int');
			$db->query($query, $extraParams);
		}

		// delete bids
		$query = "DELETE FROM " . $DBPrefix . "bids WHERE bidder = :user_id";
		$params = array(
			array(':user_id', $id, 'int')
		);
		$db->query($query, $params);
	}

	// Update counters
	$countersArray = $system->loadTable("counters");
	if ($suspended == 0)
	{
		$system->writesetting("counters", "auctions", $system->COUNTERS['auctions'] - $num_auctions, 'int');
		$system->writesetting("counters", "bids", $system->COUNTERS['bids'] - $num_bids, 'int');
		$system->writesetting("counters", "users", $system->COUNTERS['users'] - 1, 'int');
	}
	else
	{
		$system->writesetting("counters", "inactiveusers", $system->COUNTERS['inactiveusers'] - 1, 'int');
		$system->writesetting("counters", "bids", $system->COUNTERS['bids'] - $num_bids, 'int');
		$system->writesetting("counters", "auctions", $system->COUNTERS['auctions'] - $num_auctions, 'int');		
	}
	header('location:listusers.php');
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029'])
{
	header('location: listusers.php');
	exit;
}

// Check if the users has some auction
$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "auctions WHERE user = :user_id";
$params = array(
	array(':user_id', $id, 'int')
);
$db->query($query, $params);
$num_auctions = $db->result('COUNT');

if ($num_auctions > 0)
{
	$ERROR = $MSG['420'];
	$i = 0;
	while ($row = $db->fetch())
	{
		if ($i >= 10)
			break;
		$has_auctions = true;
		$ERROR .= $row['id'] . ' - <a href="' . $system->SETTINGS['siteurl'] . 'item.php?id=' . $row['id'] . '" target="_blank">' . $row['title'] . '</a><br>';
		$i++;
	}
	if ($num_auctions != $i)
	{
		$ERROR .= '<p>' . sprintf($MSG['568'], $num_auctions - $i) . '</p>';
	}
}

// Check if the user is BIDDER in some auction
$query = "SELECT COUNT(id) As COUNT FROM " . $DBPrefix . "bids WHERE bidder = :user_id";
$params = array(
	array(':user_id', $id, 'int')
);
$db->query($query, $params);
$num_bids = $db->result('COUNT');
if ($num_bids > 0)
{
	$has_bids = true;
	$ERROR .= sprintf($MSG['421'], $num_bids);
}

$query = "SELECT nick FROM " . $DBPrefix . "users WHERE id = :user_id";
$params = array(
	array(':user_id', $id, 'int')
);
$db->query($query, $params);
$username = $db->result('nick');

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => isset($current_page) ? $current_page : '',
	'PAGETITLE' => isset($current_page) ? $current_page : '',
	'ID' => $id,
	'MESSAGE' => sprintf($MSG['835'], $username),
	'TYPE' => 1
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'confirm.tpl'
		));
$template->display('body');
include 'adminFooter.php';