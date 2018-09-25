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
	$system->writesetting("settings", "termspolicy", $_POST['termspolicy'], 'bool');
	$system->writesetting("settings", "termspolicytext", stripslashes($_POST['termspolicytext']), 'str');
	$ERROR = $MSG['5084'];
}

loadblock($MSG['5082'], $MSG['5081'], 'yesno', 'termspolicy', $system->SETTINGS['termspolicy'], array($MSG['030'], $MSG['029']));
loadblock($MSG['5083'], $MSG['5080'], $CKEditor->editor('termspolicytext', stripslashes($system->SETTINGS['termspolicytext'])));

$template->assign_vars(array(
	'TYPE' => 'con',
	'TYPENAME' => $MSG['25_0018'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['5075'],
	'PAGETITLE' => $MSG['5075']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';