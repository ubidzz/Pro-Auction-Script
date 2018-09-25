<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

$id = intval($_GET['id']);

if (isset($_POST['action']) && $_POST['action'] == 'purge')
{
	if (is_numeric($_POST['days']))
	{
		// Build date
		$DATE = $system->CTIME - $_POST['days'] * 3600 * 24;
		$query = "DELETE FROM " . $DBPrefix . "comm_messages WHERE msgdate <= $DATE AND boardid = :i";
		$params = array();
		$params[] = array(':i', $id, 'int');
		$db->query($query, $params);

		// Update counter
		$query = "SELECT count(id) as COUNTER from " . $DBPrefix . "comm_messages WHERE boardid = :i";
		$params = array();
		$params[] = array(':i', $id, 'int');
		$db->query($query, $params);
		$comm_messages = $db->result('COUNTER');

		$query = "UPDATE " . $DBPrefix . "community SET messages = :cm WHERE id = :i";
		$params = array();
		$params[] = array(':i', $id, 'int');
		$params[] = array(':cm', $comm_messages, 'int');
		$db->query($query, $params);
	}
}

// Retrieve board name for breadcrumbs
$query = "SELECT name FROM " . $DBPrefix . "community WHERE id = :i";
$params = array();
$params[] = array(':i', $id, 'int');
$db->query($query, $params);
$board_name = $db->result('name');

// Retrieve board's messages from the database
$query = "SELECT * FROM " . $DBPrefix . "comm_messages WHERE boardid = :i";
$params = array();
$params[] = array(':i', $id, 'int');
$db->query($query, $params);

$bg = '';
while ($msg_data = $db->result())
{
    $template->assign_block_vars('msgs', array(
			'ID' => $msg_data['id'],
			'MESSAGE' => nl2br($msg_data['message']),
			'POSTED_BY' => $msg_data['username'],
			'POSTED_AT' => $system->dateToTimestamp($msg_data['msgdate']),
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'BOARD_NAME' => $board_name,
	'PAGENAME' => $MSG['5278'],
	'ID' => $id,
	'PAGETITLE' => $MSG['5278']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'editmessages.tpl'
		));
$template->display('body');
include 'adminFooter.php';