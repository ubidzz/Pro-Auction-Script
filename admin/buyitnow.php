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
	$bn_only_percent = ($_POST['bn_only_percent'] > 100) ? 100 : ($_POST['bn_only_percent'] < 0) ? 0 : intval($_POST['bn_only_percent']);
	// reset the bn_only blockers
	if ($bn_only_percent > $system->SETTINGS['bn_only_percent'])
	{
		$query = "UPDATE " . $DBPrefix . "users SET bn_only = :y WHERE id = bn_only = :n";
		$params = array();
		$params[] = array(':y', 'y', 'str');
		$params[] = array(':n', 'n', 'str');
		$db->query($query, $params);
	}
	
	$system->writesetting("settings", "buy_now", $_POST['buy_now'], 'bool_int');
	$system->writesetting("settings", "bn_only", $_POST['bn_only'], 'bool');
	$system->writesetting("settings", "bn_only_disable", $_POST['bn_only_disable'], 'bool');
	$system->writesetting("settings", "bn_only_percent", $bn_only_percent, 'str');
	$ERROR = $MSG['30_0066'];
}

loadblock($MSG['920'], $MSG['921'], 'batch', 'buy_now', $system->SETTINGS['buy_now'], array($MSG['029'], $MSG['030']));
loadblock($MSG['30_0064'], $MSG['30_0065'], 'yesno', 'bn_only', $system->SETTINGS['bn_only'], array($MSG['030'], $MSG['029']));
loadblock($MSG['355'], $MSG['358'], 'yesno', 'bn_only_disable', $system->SETTINGS['bn_only_disable'], array($MSG['030'], $MSG['029']));
loadblock($MSG['356'], '', 'percent', 'bn_only_percent', $system->SETTINGS['bn_only_percent'], array($MSG['357']));

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0008'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_buy_it_now" target="_blank">' . $MSG['3500_1015728'] . '</a>',
	'PAGETITLE' => $MSG['2500_1015728']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';