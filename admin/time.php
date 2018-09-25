<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include INCLUDE_PATH . 'config/timezones.php';

unset($ERROR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Update database
	$system->writesetting("settings", "timezone", $_POST['timezone'], 'str');
	$system->writesetting("settings", "datesformat", $_POST['datesformating'], 'str');
	$ERROR = $MSG['347'];
}

$selectsetting = $system->SETTINGS['timezone'];
$html = generateSelect('timezone', $timezones, $selectsetting);

//load the template
loadblock($MSG['363'], $MSG['379'], 'datestacked', 'datesformating', $system->SETTINGS['datesformat'], array($MSG['382'], $MSG['383']));
loadblock($MSG['346'], $MSG['345'], 'dropdown', 'timezone', $system->SETTINGS['timezone']);

$template->assign_vars(array(
	'OPTIONHTML' => $html,
	'TYPENAME' => $MSG['25_0008'],
	'DROPDOWN' => $html,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_time_settings" target="_blank">' . $MSG['344'] . '</a>',
	'PAGETITLE' => $MSG['344']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';