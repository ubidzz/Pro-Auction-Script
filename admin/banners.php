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
	$system->writesetting("settings", "banners", $_POST['banners'], 'bool_int');
	$system->writesetting("settings", "banner_width", $_POST['banner_width'], 'int');
	$system->writesetting("settings", "banner_height", $_POST['banner_height'], 'int');
	$system->writesetting("settings", "banner_types", $_POST['banner_types'], 'str');
	$ERROR = $MSG['600'];
}

loadblock($MSG['597'], '', 'batch', 'banners', $system->SETTINGS['banners'], array($MSG['030'], $MSG['029']));
loadblock($MSG['3500_1015422'], $MSG['3500_1015424'], 'text', 'banner_width', $system->SETTINGS['banner_width']);
loadblock($MSG['3500_1015423'], $MSG['3500_1015425'], 'text', 'banner_height', $system->SETTINGS['banner_height']);
loadblock($MSG['3500_1015426'], $MSG['3500_1015427'], 'text', 'banner_types', $system->SETTINGS['banner_types']);

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0011'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_enabledisable" target="_blank">' . $MSG['5205'] . '</a>',
	'PAGETITLE' => $MSG['5205']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';