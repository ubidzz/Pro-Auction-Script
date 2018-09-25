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
	$system->writesetting("settings", "taxuser", $_POST['taxuser'], 'bool');
	$system->writesetting("settings", "tax", $_POST['tax'], 'str');
	$ERROR = $MSG['1089'];
}

loadblock($MSG['1090'], $MSG['1091'], 'yesno', 'tax', $system->SETTINGS['tax'], array($MSG['030'], $MSG['029']));
loadblock($MSG['1092'], $MSG['1093'], 'yesno', 'taxuser', $system->SETTINGS['taxuser'], array($MSG['030'], $MSG['029']));

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0012'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['1088'],
	'PAGETITLE' => $MSG['1088']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';