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
	$system->writesetting("settings", "aboutus", $_POST['aboutus'], 'bool');
	$system->writesetting("settings", "aboutustext", $_POST['aboutustext'], 'str');
	$ERROR = $MSG['5079'];
}

loadblock($MSG['5077'], $MSG['5076'], 'yesno', 'aboutus', $system->SETTINGS['aboutus'], array($MSG['030'], $MSG['029']));
loadblock($MSG['5078'], $MSG['5080'], $CKEditor->editor('aboutustext', stripslashes($system->SETTINGS['aboutustext'])));

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0018'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['5074'],
	'PAGETITLE' => $MSG['5074']
));
		
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
	));
$template->display('body');
include 'adminFooter.php';