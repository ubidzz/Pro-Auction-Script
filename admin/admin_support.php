<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: http://www.Pro-Auction-Script.com
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

$ERROR = isset($_SESSION['support_err_message']) ? $_SESSION['support_err_message'] : '';
$link = $system->SETTINGS['siteurl'] . 'support';

if (isset($_POST['deleteid']) && is_array($_POST['deleteid']))
{
	foreach ($_POST['deleteid'] as $k => $v)
	{
		$query = "DELETE FROM " . $DBPrefix . "support_messages WHERE reply_of = :replayof";
		$params = array();
		$params[] = array(':replayof', $v, 'int');
		$db->query($query, $params);
		
		$query = "DELETE FROM " . $DBPrefix . "support WHERE ticket_id = :replayof";
		$params = array();
		$params[] = array(':replayof', $v, 'int');
		$db->query($query, $params);
	}
	$ERROR = $MSG['444'];
}

if (isset($_POST['closeid']) && is_array($_POST['closeid']))
{
	foreach($_POST['closeid'] as $k => $v)
	{
		$query = "UPDATE " . $DBPrefix . "support SET last_reply_time = :update_time, ticket_reply_status = 'user', status = 'close', last_reply_user = 0 WHERE ticket_id = :id";
		$params = array();
		$params[] = array(':update_time', $system->CTIME, 'int');
		$params[] = array(':id', $v, 'int');
		$db->query($query, $params);
	}
	$ERROR = $MSG['3500_1015439k'];
}

$query = "SELECT t.*, u.nick FROM " . $DBPrefix . "support t
	LEFT JOIN " . $DBPrefix . "users u ON (u.id = t.user)
	ORDER BY last_reply_time DESC";
// get users messages
$db->direct_query($query);
$messages = $db->numrows();
while ($array = $db->result())
{
	// formatting the created time
	$created_time = $array['created_time'];
	$mth = 'MON_0' . date('m', $created_time);
	if($system->SETTINGS['datesformat'] == 'EUR')
	{
		$created =  date('j', $created_time) . ' ' . $MSG[$mth] . ' ' . date('Y', $created_time) . ' ' . date('H:i:s', $created_time);
	}
	else
	{
		$created = $MSG[$mth] . ' ' . date('j,Y', $created_time) . ' ' . date('H:i:s', $created_time);;
	}
	
	$last_reply_time = $array['last_reply_time'];
	$mth = 'MON_0' . date('m', $last_reply_time);
	if($system->SETTINGS['datesformat'] == 'EUR')
	{
		$last_reply =  date('j', $last_reply_time) . ' ' . $MSG[$mth] . ' ' . date('Y', $last_reply_time) . ' ' . date('H:i:s', $last_reply_time);
	}
	else
	{
		$last_reply = $MSG[$mth] . ' ' . date('j,Y', $last_reply_time) . ' ' . date('H:i:s', $last_reply_time);
	}

	$template->assign_block_vars('ticket', array(
		'LAST_UPDATED_TIME' => $last_reply, //when the ticket was updated
		'TICKET_ID' => $array['ticket_id'],
		'LAST_UPDATE_USER' => $array['ticket_reply_status'] == 'user' ? $array['nick'] : $MSG['3500_1015436'],
		'TICKET_TITLE' => ($array['ticket_reply_status'] == 'support' && $array['status'] == 'open') ? '<b>' . $array['title'] . '</b>' : $array['title'],
		'CREATED' => $created, //time that the ticket was created
		'TICKET_STATUS' => $array['status'] == 'open' ? true : false, //ticket is open or closed
		'USER_ID' => $array['user'],
		'USER' => $array['nick'],
	));
}


$template->assign_vars(array(
	'B_ISERROR' => isset($ERROR) ? true : false,
	'MSGCOUNT' => $messages,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['3500_1015432'],
	'PAGETITLE' => $MSG['3500_1015432']
));

unset($_SESSION['support_err_message']);
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'my_support.tpl'
		));
$template->display('body');
include 'adminFooter.php';