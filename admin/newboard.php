<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
$current_page = $MSG['5031'];

unset($ERROR);

// Insert new message board
if (isset($_POST['action']) && $_POST['action'] == 'insert')
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
		$query = "INSERT INTO " . $DBPrefix . "community VALUES (NULL, :n, 0, 0, :m, :a)";
		$params = array();
		$params[] = array(':n', $system->cleanvars($_POST['name']), 'str');
		$params[] = array(':m', intval($_POST['msgstoshow']), 'int');
		$params[] = array(':a', intval($_POST['active']), 'int');
		$db->query($query, $params);

		header('location: boards.php');
		exit;
	}
}

$template->assign_vars(array(
	'NAME' => (isset($_POST['name'])) ? $_POST['name'] : '',
	'MSGTOSHOW' => (isset($_POST['msgstoshow'])) ? $_POST['msgstoshow'] : '',
	'B_ACTIVE' => ((isset($_POST['active']) && $_POST['active'] == 1) || !isset($_POST['active'])),
	'B_DEACTIVE' => (isset($_POST['active']) && $_POST['active'] == 2),
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['5031'],
	'PAGETITLE' => $MSG['5031']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'newboard.tpl'
		));
$template->display('body');
include 'adminFooter.php';