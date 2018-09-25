<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: http://www.Pro-Auction-Script.com
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);

$messageid = $_GET['x'];

if(isset($_POST['message']) && $_POST['reply'] == 'reply_back' && isset($messageid))
{
	$nowmessage = isset($_POST['message']) ? stripslashes($system->cleanvars($_POST['message'])) : '';

	$_SESSION['support_reply_subject'] = $nowmessage;
	
	$query = "SELECT s.*, u.email, u.nick FROM " . $DBPrefix . "support s 
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = s.user)
		WHERE s.ticket_id = :ticket_id";
	$params = array();
	$params[] = array(':ticket_id', $messageid, 'str');
	$db->query($query, $params);
	$array = $db->result();

	// submit the message to DB and linking the ticket id
	$query = "INSERT INTO " . $DBPrefix . "support_messages VALUES (NULL, :sender_id, 0, :from_email, :times, :nowmessages, :subjects, :replayof)";
	$params = array();
	$params[] = array(':sender_id', $array['user'], 'int');
	$params[] = array(':from_email', $system->SETTINGS['adminmail'], 'str');
	$params[] = array(':times', $system->CTIME, 'int');
	$params[] = array(':nowmessages', $nowmessage, 'str');
	$params[] = array(':subjects', $array['title'], 'str');
	$params[] = array(':replayof', $messageid, 'str');
	$db->query($query, $params);
	if($db->lastInsertId() > 0)
	{
		$query = "UPDATE " . $DBPrefix . "support SET last_reply_time = :update_time, ticket_reply_status = :set_status, last_reply_user = :set_user WHERE ticket_id = :id AND user = :user";
		$params = array();
		$params[] = array(':update_time', $system->CTIME, 'int');
		$params[] = array(':set_status', 'user', 'bool');
		$params[] = array(':set_user', 0, 'int');
		$params[] = array(':user', $array['user'], 'int');
		$params[] = array(':id', $messageid, 'int');
		$db->query($query, $params);

		// send the email
		$ERROR = $send_email->reply_to_ticket($array['title'], $system->uncleanvars($nowmessage), $MSG['3500_1015436'], $array['email']);

		//deteling the sessions
		$_SESSION['support_reply_message'] = '';
		$_SESSION['support_reply_subject'] = '';
	}
}

// check message is to user
$query = "SELECT m.*, u.nick FROM " . $DBPrefix . "support_messages m 
	LEFT JOIN " . $DBPrefix . "users u ON (u.id = m.sentto OR u.id = m.sentfrom) 
	WHERE m.reply_of = :ticket_id ORDER BY m.sentat DESC";
$params = array();
$params[] = array(':ticket_id', $messageid, 'str');
$db->query($query, $params);
$messages = $db->numrows();

if ($messages == 0)
{
	$_SESSION['support_err_message'] = $MSG['3500_1015439m'];
	header('location: ' . $system->SETTINGS['siteurl'] . 'support');
}
	
while ($array = $db->result())
{
	$_SESSION['support_reply_subject'] = $array['subject'];
	$sentat = $array['sentat'];
	$mth = 'MON_0' . date('m', $sentat);
	if($system->SETTINGS['datesformat'] == 'EUR')
	{
		$sent_time =  date('j', $sentat) . ' ' . $MSG[$mth] . ' ' . date('Y', $sentat) . ' ' . date('H:i:s', $sentat);
	}
	else
	{
		$sent_time = $MSG[$mth] . ' ' . date('j,Y', $sentat) . ' ' . date('H:i:s', $sentat);
	}
		
	$check_user = $array['sentfrom'] == 0 ? $MSG['3500_1015436'] :  $array['nick'];
	$template->assign_block_vars('ticket_mess', array(
		'LAST_UPDATED_TIME' => $sent_time, //when the ticket was updated
		'TICKET_ID' => $array['reply_of'],
		'LAST_USER' => $check_user,
		'TICKET_MESSAGE' => $system->uncleanvars($array['message']),
		'CREATED' => $sent_time, //time that the ticket was created
		'TICKET_STATUS' => $array['status'] == 'open' ? true : false, //ticket is open or closed
	));
}	

$query = "SELECT t.*, u.nick FROM " . $DBPrefix . "support t
	LEFT JOIN " . $DBPrefix . "users u ON (u.id = t.user)
	WHERE t.ticket_id = :id";
// get users messages
$params = array();
$params[] = array(':id', $messageid, 'int');
$db->query($query, $params);

if($db->numrows() > 0)
{
	$array = $db->result();
	// formatting the created time
	$created_time = $array['created_time'];
	$mth = 'MON_0' . date('m', $created_time);
	if($system->SETTINGS['datesformat'] == 'EUR')
	{
		$created =  date('j', $created_time) . ' ' . $MSG[$mth] . ' ' . date('Y', $created_time) . ' ' . date('H:i:s', $created_time);
	}
	else
	{
		$created = $MSG[$mth] . ' ' . date('j,Y', $created_time) . ' ' . gmdate('H:i:s', $created_time);;
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
	));
}

$check_mess = (isset($_SESSION['support_reply_message'])) ? $system->uncleanvars($_SESSION['support_reply_message']) : '';
$template->assign_vars(array(
	'B_ISERROR' => isset($ERROR) ? true : false,
	'MSGCOUNT' => $messages,
	'B_OPEN' => ($array['status'] == 'open' && isset($_GET['reply'])) ? true : false,
	'B_OPENED' => ($array['status'] == 'open') ? true : false,
	'ID' => $messageid,
	'USER' => $array['nick'],
	'USER_ID' => $array['user'],
	'SUBJECT' => (isset($_SESSION['support_reply_subject'])) ? $_SESSION['support_reply_subject'] : '',
	'MESSAGE' => $CKEditor->editor('message', $check_mess),
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['3500_1015432'],
	'PAGETITLE' => $MSG['3500_1015432']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'your_support_messages.tpl'
		));
$template->display('body');
include 'adminFooter.php';