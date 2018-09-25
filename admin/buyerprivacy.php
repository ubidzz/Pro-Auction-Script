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
	$system->writesetting("settings", "buyerprivacy", $_POST['buyerprivacy'], 'bool');
	$ERROR = $MSG['247'];
}

loadblock($MSG['237'], $MSG['238'], 'yesno', 'buyerprivacy', $system->SETTINGS['buyerprivacy'], array($MSG['030'], $MSG['029']));

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0008'],
	'B_TITLES' => true,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=u-Pro-Auction-Script_bidder_privacy" target="_blank">' . $MSG['236'] . '</a>',
	'PAGETITLE' => $MSG['236']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';