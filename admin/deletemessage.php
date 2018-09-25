<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

$msg = intval($_REQUEST['id']);
$board_id = intval($_REQUEST['board_id']);

// Insert new currency
if (isset($_POST['action']) && $_POST['action'] == $MSG['030'])
{
	$query = "DELETE FROM " . $DBPrefix . "comm_messages WHERE id = :i";
	$params = array();
	$params[] = array(':i', $msg, 'int');
	$db->query($query, $params);

	// Update messages counter
	$query = "UPDATE " . $DBPrefix . "community SET messages = messages - :m WHERE id = :b";
	$params = array();
	$params[] = array(':m', 1, 'int');
	$params[] = array(':b', $board_id, 'int');
	$db->query($query, $params);

	header('location: editmessages.php?id=' . $board_id);
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029'])
{
	header('location: editmessages.php?id=' . $board_id);
	exit;
}

$template->assign_vars(array(
		'ERROR' => (isset($ERROR)) ? $ERROR : '',
		'PAGENAME' => isset($current_page) ? $current_page : '',
		'ID' => $msg,
		'MESSAGE' => sprintf($MSG['834'], $msg),
		'TYPE' => 1,
		'PAGETITLE' => isset($current_page) ? $current_page : ''
	));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'confirm.tpl'
		));
$template->display('body');
include 'adminFooter.php';