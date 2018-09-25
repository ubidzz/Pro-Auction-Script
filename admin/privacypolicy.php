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
	$system->writesetting("settings", "privacypolicy", $_POST['privacypolicy'], 'bool');
	$system->writesetting("settings", "privacypolicytext", $_POST['privacypolicytext'], 'str');
	$ERROR = $MSG['406'];
}

loadblock($MSG['403'], $MSG['405'], 'yesno', 'privacypolicy', $system->SETTINGS['privacypolicy'], array($MSG['030'], $MSG['029']));
loadblock($MSG['404'], $MSG['5080'], $CKEditor->editor('privacypolicytext', stripslashes($system->SETTINGS['privacypolicytext'])));

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0018'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['402'],
	'PAGETITLE' => $MSG['402']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';