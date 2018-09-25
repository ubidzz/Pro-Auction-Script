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
	$system->writesetting("settings", "liveChat", $_POST['liveChat'], 'bool');
	$system->writesetting("settings", "liveChatTitle", $_POST['liveChatTitle'], 'str');
	$system->writesetting("settings", "liveChatLockNick", $_POST['liveChatLockNick'], 'bool');
	$system->writesetting("settings", "liveChatPMLimit", $_POST['liveChatPMLimit'], 'int');
	$system->writesetting("settings", "liveChatTextLen", $_POST['liveChatTextLen'], 'int');
	$system->writesetting("settings", "liveChatMaxMSG", $_POST['liveChatMaxMSG'], 'int');
	$system->writesetting("settings", "liveChatMaxDisplayMSG", $_POST['liveChatMaxDisplayMSG'], 'int');
	$system->writesetting("settings", "liveChatTheme", $_POST['liveChatTheme'], 'bool_int');
	$ERROR = $MSG['3500_1015962a'];
}

loadblock($MSG['3500_1015949'], $MSG['3500_1015950'], 'yesno', 'liveChat', $system->SETTINGS['liveChat'], array($MSG['030'], $MSG['029']));
loadblock($MSG['3500_1015951'], $MSG['3500_1015952'], 'text', 'liveChatTitle', $system->SETTINGS['liveChatTitle']);
loadblock($MSG['3500_1015953'], $MSG['3500_1015954'], 'yesno', 'liveChatLockNick', $system->SETTINGS['liveChatLockNick'], array($MSG['030'], $MSG['029']));
loadblock($MSG['3500_1015955'], $MSG['3500_1015956'], 'decimals', 'liveChatPMLimit', $system->SETTINGS['liveChatPMLimit']);
loadblock($MSG['3500_1015957'], $MSG['3500_1015958'], 'decimals', 'liveChatTextLen', $system->SETTINGS['liveChatTextLen']);
loadblock($MSG['3500_1015959'], $MSG['3500_1015960'], 'decimals', 'liveChatMaxMSG', $system->SETTINGS['liveChatMaxMSG']);
loadblock($MSG['3500_1015961'], $MSG['3500_1015962'], 'decimals', 'liveChatMaxDisplayMSG', $system->SETTINGS['liveChatMaxDisplayMSG']);
loadblock($MSG['3500_1015961'], $MSG['3500_1015965'], 'select4num', 'liveChatTheme', $system->SETTINGS['liveChatTheme'], array($MSG['3500_1015966'], $MSG['3500_1015967'], $MSG['3500_1015968'], $MSG['3500_1015969']));

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['3500_1015949'],
	'PAGETITLE' => $MSG['3500_1015949']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';