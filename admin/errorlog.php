<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);

if (isset($_POST['action']) && $_POST['action'] == 'clearlog')
{
	$query = "DELETE FROM " . $DBPrefix . "logs WHERE type = :errors";
	$params = array();
	$params[] = array(':errors', 'error', 'str');
	$db->query($query, $params);
	$ERROR = $MSG['889'];
}
elseif (isset($_POST['action']) && $_POST['action'] == 'debugging')
{
	$system->writesetting("settings", "debugging", $_POST['debug'], 'bool');
	$ERROR = $MSG['3500_1015948'];
}


$data = '';
$query = "SELECT * FROM " . $DBPrefix . "logs WHERE type = :errors";
$params = array();
$params[] = array(':errors', 'error', 'str');
$db->query($query, $params);
while ($row = $db->result())
{
	$data .= '<strong>' . date('d-m-Y, H:i:s', $row['timestamp']) . '</strong>: ' . $row['message'] . '<br>';
}

if ($data == '')
{
	$data = $MSG['888'];
}

$template->assign_vars(array(
	'ERRORLOG' => $data,
	'DEBUG_Y' => $system->SETTINGS['debugging'] == 'y' ?  'checked="checked"' : '',
	'DEBUG_N' => $system->SETTINGS['debugging'] == 'n' ?  'checked="checked"' : '',
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => isset($current_page) ? $current_page : '',
	'PAGETITLE' => isset($current_page) ? $current_page : ''
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'errorlog.tpl'
		));
$template->display('body');
include 'adminFooter.php';