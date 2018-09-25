<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

$msg = intval($_REQUEST['msg']);
$board_id = intval($_REQUEST['id']);

// Insert new currency
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (!isset($_POST['message']) || empty($_POST['message']))
	{
		$ERROR = $ERR['047'];
	}
	else
	{
		$query = "UPDATE " . $DBPrefix . "comm_messages SET message = :m WHERE id = :i";
		$params = array();
		$params[] = array(':m', $system->cleanvars($_POST['message']), 'str');
		$params[] = array(':i', $_POST['msg'], 'int');
		$db->query($query, $params);

		header("Location: editmessages.php?id=" . $_POST['id']);
		exit;
	}
}

// Retrieve board name for breadcrumbs
$query = "SELECT name FROM " . $DBPrefix . "community WHERE id = :i";
$params = array();
$params[] = array(':i', $board_id, 'int');
$db->query($query, $params);
$board_name = $db->result('name');

// Retrieve message from the database
$query = "SELECT * FROM " . $DBPrefix . "comm_messages WHERE id = :i";
$params = array();
$params[] = array(':i', $msg, 'int');
$db->query($query, $params);
$data = $db->result();

$template->assign_vars(array(
	'BOARD_NAME' => $board_name,
	'MESSAGE' => nl2br((isset($_POST['message'])) ? $_POST['message'] : $data['message']),
	'USER' => ($data['user'] > 0) ? $data['username'] : $MSG['5061'],
	'POSTED' => $system->dateToTimestamp($data['msgdate']),
	'BOARD_ID' => $board_id,
	'MSG_ID' => $msg,
	'ERROR' => (isset($ERROR)) ? $ERROR : ''
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'editmessage.tpl'
		));
$template->display('body');
include 'adminFooter.php';