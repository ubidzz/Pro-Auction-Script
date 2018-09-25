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
	// Update database
	$system->writesetting("settings", "cookiespolicy", $_POST['cookiespolicy'], 'bool');
	$system->writesetting("settings", "cookiespolicytext", stripslashes($_POST['cookiespolicytext']), 'str');
	$ERROR = $MSG['30_0237'];
}

loadblock($MSG['30_0234'], $MSG['30_0236'], 'yesno', 'cookiespolicy', $system->SETTINGS['cookiespolicy'], array($MSG['030'], $MSG['029']));
loadblock($MSG['30_0238'], $MSG['5080'], $CKEditor->editor('cookiespolicytext', stripslashes($system->SETTINGS['cookiespolicytext'])));

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0236'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['30_0233'],
	'PAGETITLE' => $MSG['30_0233']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';