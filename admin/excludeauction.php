<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

if (!isset($_REQUEST['id']))
{
	$URL = $_SESSION['RETURN_LIST'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}

if (isset($_POST['action']) && $_POST['action'] == $MSG['030'])
{
	$catscontrol = new MPTTcategories();
	$id = intval($_POST['id']);

	// get auction data
	$query = "SELECT category, closed, suspended FROM " . $DBPrefix . "auctions WHERE id = :i";
	$params = array();
	$params[] = array(':i', $id, 'int');
	$db->query($query, $params);
	$auc_data = $db->result();

	if ($auc_data['suspended'] > 0)
	{
		// update auction table
		$query = "UPDATE " . $DBPrefix . "auctions SET suspended = :s WHERE id = :i";
		$params = array();
		$params[] = array(':s', 0, 'int');
		$params[] = array(':i', $id, 'int');
		$db->query($query, $params);

		if ($auc_data['closed'] == 1)
		{
			$system->writesetting("counters", "suspendedauctions", $system->COUNTERS['suspendedauctions'] - 1, 'int');
			$system->writesetting("counters", "closedauctions", $system->COUNTERS['closedauctions'] + 1, 'int');
		}
		else
		{
			$system->writesetting("counters", "suspendedauctions", $system->COUNTERS['suspendedauctions'] - 1, 'int');
			$system->writesetting("counters", "auctions", $system->COUNTERS['auctions'] + 1, 'int');

			// update recursive categories
			$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :i";
			$params = array();
			$params[] = array(':i', $auc_data['category'], 'int');
			$db->query($query, $params);
			$parent_node = $db->result();
			$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

			for ($i = 0; $i < count($crumbs); $i++)
			{
				$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + :sc WHERE cat_id = :ci";
				$params = array();
				$params[] = array(':sc', 1, 'int');
				$params[] = array(':ci', $crumbs[$i]['cat_id'], 'int');
				$db->query($query, $params);
			}
		}
	}
	else
	{
		// suspend auction
		$query = "UPDATE " . $DBPrefix . "auctions SET suspended = 1 WHERE id = :i";
		$params = array();
		$params[] = array(':i', $id, 'int');
		$db->query($query, $params);

		if ($auc_data['closed'] == 1)
		{
			$system->writesetting("counters", "suspendedauctions", $system->COUNTERS['suspendedauctions'] + 1, 'int');
			$system->writesetting("counters", "closedauctions", $system->COUNTERS['closedauctions'] - 1, 'int');			
		}
		else
		{
			$system->writesetting("counters", "suspendedauctions", $system->COUNTERS['suspendedauctions'] + 1, 'int');
			$system->writesetting("counters", "auctions", $system->COUNTERS['auctions'] - 1, 'int');
			
			// update recursive categories
			$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :i";
			$params = array();
			$params[] = array(':i', $auc_data['category'], 'int');
			$db->query($query, $params);
			
			$parent_node = $db->result();
			$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

			for ($i = 0; $i < count($crumbs); $i++)
			{
				$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter - :sc WHERE cat_id = :ci";
				$params = array();
				$params[] = array(':sc', 1, 'int');
				$params[] = array(':ci', $crumbs[$i]['cat_id'], 'int');
				$db->query($query, $params);
			}
		}
	}

	$URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029'])
{
	$URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}

$query = "SELECT u.nick, a.title, a.starts, a.description, a.category, d.description as duration,
		a.suspended, a.current_bid, a.quantity, a.reserve_price
		FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
		LEFT JOIN " . $DBPrefix . "durations d ON (d.days = a.duration)
		WHERE a.id = :i";
$params = array();
$params[] = array(':i', $_GET['id'], 'int');
$db->query($query, $params);
$auc_data = $db->result();

if ($system->SETTINGS['datesformat'] == 'USA')
{
	$date = date('m/d/Y', $auc_data['starts']);
}
else
{
	$date = date('d/m/Y', $auc_data['starts']);
}

$template->assign_vars(array(
	'SITEURL' => $system->SETTINGS['siteurl'],
	'PAGE_TITLE' => ($auc_data['suspended'] > 0) ? $MSG['322'] : $MSG['321'],
	'ID' => $_GET['id'],
	'PAGENAME' => $MSG['321'],
	'TITLE' => $auc_data['title'],
	'NICK' => $auc_data['nick'],
	'STARTS' => $date,
	'DURATION' => $auc_data['duration'],
	'CATEGORY' => $category_names[$auc_data['category']],
	'DESCRIPTION' => stripslashes($auc_data['description']),
	'CURRENT_BID' => $system->print_money($auc_data['current_bid']),
	'QTY' => $auc_data['quantity'],
	'RESERVE_PRICE' => $system->print_money($auc_data['reserve_price']),
	'SUSPENDED' => $auc_data['suspended'],
	'OFFSET' => $_REQUEST['offset'],
	'PAGETITLE' => $MSG['321']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'excludeauction.tpl'
		));
$template->display('body');
include 'adminFooter.php';