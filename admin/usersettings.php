<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);

$mail_protocol = array('0' => 'Pro-Auction-Script MAIL', '1' => 'MAIL', '2' => 'SMTP', '4' => 'SENDMAIL', '5'=> 'QMAIL', '3' => 'NEVER SEND EMAILS (may be useful for testing purposes)');
$smtp_secure_options =array('none' => 'None', 'tls' => 'TLS', 'ssl' => 'SSL');

if (isset($_POST['action']) && $_POST['action'] == 'update')
{	
	// Update database
	$system->writesetting("settings", "usersauth", $_POST['usersauth'], 'bool');
	$system->writesetting("settings", "activationtype", $_POST['usersconf'], 'bool_int');
	$ERROR = $MSG['895'];
}

loadblock($MSG['25_0151'], $MSG['25_0152'], 'yesnostacked', 'usersauth', $system->SETTINGS['usersauth'], array($MSG['2__0066'], $MSG['2__0067']));
loadblock($MSG['25_0151_a'], $MSG['25_0152_a'], 'select3num', 'usersconf', $system->SETTINGS['activationtype'], array($MSG['25_0152_b'], $MSG['25_0152_c'], $MSG['25_0152_d']));
 
$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0008'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_usettings" target="_blank">' . $MSG['894'] . '</a>',
	'PAGETITLE' => $MSG['894']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';