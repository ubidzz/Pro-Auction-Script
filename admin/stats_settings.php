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
	if (isset($_POST['activate']) && $_POST['activate'] == 'y' && (!isset($_POST['accesses']) && !isset($_POST['browsers']) && !isset($_POST['domains'])))
	{
		$ERROR = $ERR['5002'];
	}
	else
	{
		if (!isset($_POST['accesses'])) $_POST['accesses'] = 'n';
		if (!isset($_POST['browsers'])) $_POST['browsers'] = 'n';
		if (!isset($_POST['domains'])) $_POST['domains'] = 'n';
		
		// Update database
		$system->writesetting("statssettings", "activate",  $_POST['activate'], 'str');
		$system->writesetting("statssettings", "accesses",  $_POST['accesses'], 'str');
		$system->writesetting("statssettings", "browsers",  $_POST['browsers'], 'str');
		$ERROR = $MSG['5148'];
	}
}

$statssettings = $system->loadTable('statssettings');
loadblock('', $MSG['5144']);
loadblock($MSG['5149'], '', 'yesno', 'activate', $statssettings['activate'], array($MSG['030'], $MSG['029']));
loadblock('', $MSG['5150']);
loadblock('' , '', 'checkbox', 'accesses', $statssettings['accesses'], array($MSG['5145']));
loadblock('' , '', 'checkbox', 'browsers', $statssettings['browsers'], array($MSG['5146']));

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0023'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['3500_1015768'],
	'PAGETITLE' => $MSG['3500_1015768']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';