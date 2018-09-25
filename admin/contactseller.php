<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	$system->writesetting("settings", "contactseller", $_POST['contactseller'], 'str');
	$system->writesetting("settings", "users_email", $_POST['users_email'], 'bool');
	$ERROR = $MSG['25_0155'];
}

loadblock($MSG['25_0216'], $MSG['25_0217'], 'select3contact', 'contactseller', $system->SETTINGS['contactseller'], array($MSG['25_0218'], $MSG['25_0219'], $MSG['25_0220']));
loadblock($MSG['30_0085'], $MSG['30_0084'], 'yesno', 'users_email', $system->SETTINGS['users_email'], array($MSG['030'], $MSG['029']));

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0008'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a style="color:lime" href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_contact_the_seller" target="_blank">' . $MSG['25_0216'] . '</a>',
	'PAGETITLE' => $MSG['25_0216']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';