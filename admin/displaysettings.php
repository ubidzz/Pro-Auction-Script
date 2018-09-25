<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
$current_page = 'settings';
include 'adminCommon.php';

unset($ERROR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Update database
	$system->writesetting("settings", "perpage", $_POST['perpage'], 'int');
	$system->writesetting("settings", "thumb_list", $_POST['thumb_list'], 'int');
	$system->writesetting("settings", "lastitemsnumber", $_POST['lastitemsnumber'], 'int');
	$system->writesetting("settings", "hotitemsnumber", $_POST['hotitemsnumber'], 'int');
	$system->writesetting("settings", "endingsoonnumber", $_POST['endingsoonnumber'], 'int');
	$system->writesetting("settings", "featurednumber", $_POST['featureditemsnumber'], 'int');
	$system->writesetting("settings", "newstoshow", $_POST['newstoshow'], 'int');
	$system->writesetting("settings", "loginbox", $_POST['loginbox'], 'bool_int');
	$system->writesetting("settings", "helpbox", $_POST['helpbox'], 'bool_int');
	$system->writesetting("settings", "newsbox", $_POST['newsbox'], 'bool_int');
	$ERROR = $MSG['795'];
}

loadblock($MSG['789'], $MSG['790'], 'days', 'perpage', $system->SETTINGS['perpage']);
loadblock($MSG['25_0107'], $MSG['808'], 'decimals', 'thumb_list', $system->SETTINGS['thumb_list'], array($MSG['2__0045']));

loadblock($MSG['807'], '', '', '', '', array(), true);
loadblock($MSG['350_10206'], $MSG['3500_1015797'], 'days', 'featureditemsnumber', $system->SETTINGS['featurednumber']);
loadblock($MSG['5015'], $MSG['5016'], 'days', 'hotitemsnumber', $system->SETTINGS['hotitemsnumber']);
loadblock($MSG['5013'], $MSG['5014'], 'days', 'lastitemsnumber', $system->SETTINGS['lastitemsnumber']);
loadblock($MSG['5017'], $MSG['5018'], 'days', 'endingsoonnumber', $system->SETTINGS['endingsoonnumber']);
loadblock($MSG['3500_1015766'], $MSG['3500_1015767'], 'batch', 'helpbox', $system->SETTINGS['helpbox'], array($MSG['030'], $MSG['029']));
loadblock($MSG['532'], $MSG['537'], 'batch', 'loginbox', $system->SETTINGS['loginbox'], array($MSG['030'], $MSG['029']));
loadblock($MSG['533'], $MSG['538'], 'batch', 'newsbox', $system->SETTINGS['newsbox'], array($MSG['030'], $MSG['029']));
loadblock('', $MSG['554'], 'days', 'newstoshow', $system->SETTINGS['newstoshow']);

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'SITEURL' => $system->SETTINGS['siteurl'],
	'TYPENAME' => $MSG['5142'],
	'PAGENAME' => '<a style="color:lime" href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_dsettings" target="_blank">' . $MSG['788'] . '</a>',
	'PAGETITLE' => $MSG['788']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';