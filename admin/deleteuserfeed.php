<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

$id = intval($_REQUEST['id']);
$user_id = intval($_REQUEST['user']);

if (isset($_POST['action']) && $_POST['action'] == $MSG['030'])
{
	$query = "DELETE FROM " . $DBPrefix . "feedbacks WHERE id = :i";
	$params = array();
	$params[] = array(':i', $id, 'int');
	$db->query($query, $params);

	$query = "SELECT SUM(rate) as FSUM, count(feedback) as FNUM FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = :i";
	$params = array();
	$params[] = array(':i', $user_id, 'int');
	$db->query($query, $params);
	$fb_data = $db->result();
	
	$query = "UPDATE " . $DBPrefix . "users SET rate_sum = :s, rate_num = :n WHERE id = :u";
	$params = array();
	$params[] = array(':s', $fb_data['SUM'], 'int');
	$params[] = array(':n', $fb_data['NUM'], 'int');
	$params[] = array(':u', $user_id, 'int');
	$db->query($query, $params);

	header('location: userfeedback.php?id=' . $user_id);
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029'])
{
	header('location: userfeedback.php?id=' . $user_id);
	exit;
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => isset($current_page) ? $current_page : '',
	'PAGETITLE' => isset($current_page) ? $current_page : '',
	'ID' => $id,
	'USERID' => $user_id,
	'MESSAGE' => sprintf($MSG['848'], $id),
	'TYPE' => 2
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'confirm.tpl'
		));
$template->display('body');
include 'adminFooter.php';