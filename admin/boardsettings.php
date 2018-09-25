<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Update database
	$system->writesetting("settings", "boards", $_POST['boards'], 'bool');
	$ERROR = $MSG['5051'];
}

loadblock($MSG['5048'], '', 'yesno', 'boards', $system->SETTINGS['boards'], array($MSG['030'], $MSG['029']));

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0018'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['5047'],
	'PAGETITLE' => $MSG['5047']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';