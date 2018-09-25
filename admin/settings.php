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
	$domain = str_replace('http://', '', str_replace('https://', '', $_POST['siteurl']));
	
	// Data check
	if (empty($_POST['sitename']) || empty($_POST['siteurl']) || empty($_POST['adminmail']))
	{
		$ERROR = $ERR['047'];
	}
	elseif (!is_numeric($_POST['archiveafter']))
	{
		$ERROR = $ERR['043'];
	}
	else
	{		
		// Update data
		$system->writesetting("settings", "sitename", $_POST['sitename'], 'str');
		$system->writesetting("settings", "adminmail", $_POST['adminmail'], 'str');
		$system->writesetting("settings", "siteurl", $domain, 'str');
		$system->writesetting("settings", "copyright", $_POST['copyright'], 'str');
		$system->writesetting("settings", "cron", $_POST['cron'], 'bool_int');
		$system->writesetting("settings", "archiveafter", $_POST['archiveafter'], 'int');
		$system->writesetting("settings", "cache_theme", $_POST['cache_theme'], 'bool');
		
		//preventing a error after updating table
		$system->SETTINGS['siteurl'] = $system->SETTINGS['https'] == 'y' ? 'https://' . $domain : 'http://' . $domain;
		$ERROR = $MSG['542'];
	}
}

$myDomain = str_replace('http://', '', str_replace('https://', '', $system->SETTINGS['siteurl']));

// general settings
loadblock($MSG['527'], $MSG['535'], 'text', 'sitename', $system->SETTINGS['sitename']);
loadblock($MSG['528'], $MSG['536'], 'text', 'siteurl', $myDomain);
loadblock($MSG['540'], $MSG['541'], 'text', 'adminmail', $system->SETTINGS['adminmail']);
loadblock($MSG['191'], $MSG['192'], 'text', 'copyright', $system->SETTINGS['copyright']);

// batch settings
loadblock($MSG['348'], '', '', '', '', array(), true);
loadblock($MSG['372'], $MSG['371'], 'batch', 'cron', $system->SETTINGS['cron'], array($MSG['373'], $MSG['374']));
loadblock($MSG['376'], $MSG['375'], 'days', 'archiveafter', $system->SETTINGS['archiveafter'], array($MSG['377']));

// optimisation settings
loadblock($MSG['725'], '', '', '', '', array(), true);
loadblock($MSG['726'], $MSG['727'], 'yesno', 'cache_theme', $system->SETTINGS['cache_theme'], array($MSG['030'], $MSG['029']));

$template->assign_vars(array(
	'TYPENAME' => $MSG['5142'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_gsettings" target="_blank">' . $MSG['526'] . '</a>',
	'PAGETITLE' => $MSG['526']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';