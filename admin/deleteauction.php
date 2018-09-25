<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

// Data check
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
	$auc_id = intval($_POST['id']);

	// get auction data
	$query = "SELECT category, num_bids, suspended, closed FROM " . $DBPrefix . "auctions WHERE id = :i";
	$params = array();
	$params[] = array(':i', $auc_id, 'int');
	$db->query($query, $params);
	$auc_data = $db->result();

	// Delete related values
	$query = "DELETE FROM " . $DBPrefix . "auctions WHERE id = :i";
	$params = array();
	$params[] = array(':i', $auc_id, 'int');
	$db->query($query, $params);

	// delete bids
	$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :i";
	$params = array();
	$params[] = array(':i', $auc_id, 'int');
	$db->query($query, $params);

	// Delete proxybids
	$query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = :i";
	$params = array();
	$params[] = array(':i', $auc_id, 'int');
	$db->query($query, $params);

	// Delete file in counters
	$query = "DELETE FROM " . $DBPrefix . "auccounter WHERE auction_id = :i";
	$params = array();
	$params[] = array(':i', $auc_id, 'int');
	$db->query($query, $params);

	if ($auc_data['suspended'] == 0 && $auc_data['closed'] == 0)
	{
		// update main counters
		$system->writesetting("counters", "auctions",  $system->COUNTERS['auctions'] - 1, 'int');
		$system->writesetting("counters", "bids",  $system->COUNTERS['bids'] - $auc_data['num_bids'], 'int');

		// update recursive categories
		$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :c";
		$params = array();
		$params[] = array(':c', $auc_data['category'], 'int');
		$db->query($query, $params);
		
		$parent_node = $db->result();
		$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

		for ($i = 0; $i < count($crumbs); $i++)
		{
			$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter - :sc WHERE cat_id = :c";
			$params = array();
			$params[] = array(':sc', 1, 'int');
			$params[] = array(':c', $crumbs[$i]['cat_id'], 'int');
			$db->query($query, $params);
		}
	}

	// Delete auctions images
	if ($dir = @opendir(UPLOAD_PATH . $auc_id))
	{
		while ($file = readdir($dir))
		{
			if ($file != '.' && $file != '..')
			{
				@unlink(UPLOAD_PATH . $auc_id . '/' . $file);
			}
		}
		closedir($dir);
		@rmdir(UPLOAD_PATH . $auc_id);
	}

	$URL = $_SESSION['RETURN_LIST'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029'])
{
	$URL = $_SESSION['RETURN_LIST'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}

$query = "SELECT title FROM " . $DBPrefix . "auctions WHERE id = :i";
$params = array();
$params[] = array(':i', $_GET['id'], 'int');
$db->query($query, $params);
$title = $db->result('title');

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['325'],
	'ID' => $_GET['id'],
	'MESSAGE' => sprintf($MSG['833'], $title),
	'TYPE' => 1,
	'PAGETITLE' => $MSG['325']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'confirm.tpl'
		));
$template->display('body');
include 'adminFooter.php';