<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

// Insert new currency
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (empty($_POST['name']) || empty($_POST['msgstoshow']) || empty($_POST['active']))
	{
		$ERROR = $ERR['047'];
	}
	elseif (!is_numeric($_POST['msgstoshow']))
	{
		$ERROR = $ERR['5000'];
	}
	elseif (intval($_POST['msgstoshow'] == 0))
	{
		$ERROR = $ERR['5001'];
	}
	else
	{
		$query = "UPDATE " . $DBPrefix . "community
				  SET name = :n,
				  msgstoshow = :ms,
				  active = :a
				  WHERE id = :i";
		$params = array();
		$params[] = array(':n', $system->cleanvars($_POST['name']), 'str');
		$params[] = array(':ms', intval($_POST['msgstoshow']), 'int');
		$params[] = array(':a', intval($_POST['active']), 'int');
		$params[] = array(':i', intval($_POST['id']), 'int');
		$db->query($query, $params);

		header('location: boards.php');
		exit;
	}
}

$id = intval($_GET['id']);

// Retrieve board's data from the database
$query = "SELECT * FROM " . $DBPrefix . "community WHERE id = :i";
$params = array();
$params[] = array(':i', $id, 'int');
$db->query($query, $params);
$board_data = $db->result();

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'NAME' => $board_data['name'],
	'MESSAGES' => $board_data['messages'],
	'LAST_POST' => ($board_data['lastmessage'] > 0) ? $system->dateToTimestamp($board_data['lastmessage']) : '--',
	'MSGTOSHOW' => $board_data['msgstoshow'],
	'B_ACTIVE' => ($board_data['active'] == 1),
	'B_DEACTIVE' => ($board_data['active'] == 2),
	'ID' => $id,
	'PAGENAME' => $MSG['5052'],
	'PAGETITLE' => $MSG['5052']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'editboards.tpl'
		));
$template->display('body');
include 'adminFooter.php';