<?php/******************************************************************************* *   copyright				: (C) 2014 - 2018 Pro-Auction-Script *   site					: https://www.pro-auction-script.com *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license *******************************************************************************/include 'common.php';if ($system->SETTINGS['activationtype'] == 2){	header('location: home');	exit;}$username = isset($_POST['username']) ? $_POST['username'] : '';$email = isset($_POST['email']) ? $_POST['email'] : '';if($username !='' && $email !='' && isset($_POST['action']) && $_POST['action'] == 'ok'){	$query = "SELECT * FROM " . $DBPrefix . "users WHERE nick = :check_nick AND email = :check_email AND suspended = 8";	$params = array(		array(':check_nick', $username, 'str'),		array(':check_email', $email, 'str')	);	$db->query($query, $params);	if($db->numrows() == 1)	{		$user_data = $db->result();		$send_email->user_confirmation($user_data['name'], $user_data['id'], $user_data['email'], $user_data['nick']);		$ERROR = sprintf($MSG['3500_1016005'], $user_data['email']);	}else{		$ERROR = $MSG['3500_1016004'];	}}$template->assign_vars(array(	'ERROR' => (isset($ERROR)) ? $ERROR : '',	'USERNAME' => (isset($username)) ? $username : '',	'EMAIL' => (isset($email)) ? $email : '',	'B_FIRST' => (!isset($_POST['action']) || (isset($_POST['action']) && isset($ERROR)))));include 'header.php';$template->set_filenames(array(		'body' => 'resend_email.tpl'		));$template->display('body');include 'footer.php';