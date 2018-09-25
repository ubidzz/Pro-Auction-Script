<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);

$log = (isset($_POST['cronlog'])) ? 'y' : 'n';

if($system->SETTINGS['cronlog'] !== $log && isset($_POST['action']) && $_POST['action'] == 'changesettngs')
{
	$system->writesetting("settings", "cronlog", $log, 'bool');
	$ERROR = $MSG['3500_1015623'];
}

if (isset($_POST['action']) && $_POST['action'] == 'clearlog' && isset($_POST['id']))
{
	$query = "DELETE FROM " . $DBPrefix . "logs WHERE type = :cron AND id = :log_id";
	$params = array();
	$params[] = array(':cron', 'cron', 'str');
	$params[] = array(':log_id', $_POST['id'], 'int');
	$db->query($query, $params);
	$ERROR = $MSG['3500_1015587'];
}
elseif(isset($_POST['action']) && $_POST['action'] == 'clearalllogs')
{
	$query = "DELETE FROM " . $DBPrefix . "logs WHERE type = :cron";
	$params = array();
	$params[] = array(':cron', 'cron', 'str');
	$db->query($query, $params);
	$ERROR = $MSG['3500_1015622'];
}


$query = "SELECT * FROM " . $DBPrefix . "logs WHERE type = :cron ORDER BY timestamp DESC";
$params = array();
$params[] = array(':cron', 'cron', 'str');
$db->query($query, $params);
while ($row = $db->result())
{
	$template->assign_block_vars('cron_log', array(
	'ERRORLOG' => $row['message'],
	'PAGENAME' => $MSG['3500_1015589'] . date('F d, Y H:i:s', $row['timestamp']),
	'PAGETITLE' => $MSG['3500_1015589'] . date('F d, Y H:i:s', $row['timestamp']),
	'ID' => $row['id']
	));
}

if ($db->numrows() == 0)
{
	$template->assign_block_vars('cron_log', array(
		'ERRORLOG' => $MSG['3500_1015586'],
		'PAGENAME' => $MSG['3500_1015588'],
		'PAGETITLE' => $MSG['3500_1015588']
	));
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'SITEURL' => $system->SETTINGS['siteurl'],
	'SETTINGS' => $system->SETTINGS['cronlog'] == 'y' ? 'checked' : '',
	'STATUS' => $system->SETTINGS['cronlog'] == 'y' ? $MSG['3500_1015583'] : $MSG['3500_1015584']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'cronlog.tpl'
		));
$template->display('body');
include 'adminFooter.php';