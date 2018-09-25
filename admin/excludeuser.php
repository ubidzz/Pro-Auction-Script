<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include INCLUDE_PATH . 'countries.inc.php';
include INCLUDE_PATH . 'membertypes.inc.php';
$URLHeader = false;
if (!isset($_REQUEST['id']))
{
	$link = 'listusers.php?PAGE=' . intval($_REQUEST['offset']);
	$URLHeader = true;
}

if (isset($_POST['action']) && $_POST['action'] == $MSG['030'])
{
	if ($_POST['mode'] == 'activate')
	{
		$query = "UPDATE " . $DBPrefix . "users SET suspended = :s WHERE id = :i";
		$params = array();
		$params[] = array(':s', 0, 'int');
		$params[] = array(':i', $_POST['id'], 'int');
		$db->query($query, $params);
		
		$system->writesetting("counters", "inactiveusers", $system->COUNTERS['inactiveusers'] - 1, 'int');
		$system->writesetting("counters", "users", $system->COUNTERS['users'] + 1, 'int');

		$query = "SELECT name, email FROM " . $DBPrefix . "users WHERE id = :i";
		$params = array();
		$params[] = array(':i', $_POST['id'], 'int');
		$db->query($query, $params);
		$USER = $db->result();
		$send_email->approved($USER['name'], $language, $USER['email']);
	}
	else
	{
		$query = "UPDATE " . $DBPrefix . "users SET suspended = :s WHERE id = :i";
		$params = array();
		$params[] = array(':s', 1, 'int');
		$params[] = array(':i', $_POST['id'], 'int');
		$db->query($query, $params);
		
		$system->writesetting("counters", "inactiveusers", $system->COUNTERS['inactiveusers'] + 1, 'int');
		$system->writesetting("counters", "users", $system->COUNTERS['users'] - 1, 'int');
	}
	$link = 'listusers.php?PAGE=' . intval($_POST['offset']);
	$URLHeader = true;
}
elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029'])
{
	$link = 'listusers.php?PAGE=' . intval($_POST['offset']);
	$URLHeader = true;
}

// load the page
$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :i";
$params = array();
$params[] = array(':i', intval($_GET['id']), 'int');
$db->query($query, $params);
$user_data = $db->result();

// create tidy DOB string
if ($user_data['birthdate'] == 0)
{
	$birthdate = '';
}
else
{
	$birth_day = substr($user_data['birthdate'], 6, 2);
	$birth_month = substr($user_data['birthdate'], 4, 2);
	$birth_year = substr($user_data['birthdate'], 0, 4);

	if ($system->SETTINGS['datesformat'] == 'USA')
	{
		$birthdate = $birth_month . '/' . $birth_day . '/' . $birth_year;
	}
	else
	{
		$birthdate = $birth_day . '/' . $birth_month . '/' . $birth_year;
	}
}

$mode = 'activate';
switch ($user_data['suspended'])
{
	case 0:
		$action = $MSG['305'];
		$question = $MSG['308'];
		$mode = 'suspend';
		break;
	case 8:
		$action = $MSG['515'];
		$question = $MSG['815'];
		break;
	case 10:
		$action = $MSG['299'];
		$question = $MSG['418'];
		break;
	default:
		$action = $MSG['306'];
		$question = $MSG['309'];
		break;
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'ACTION' => $action,
	'REALNAME' => $user_data['name'],
	'USERNAME' => $user_data['nick'],
	'EMAIL' => $user_data['email'],
	'ADDRESS' => $user_data['address'],
	'PROV' => $user_data['prov'],
	'ZIP' => $user_data['zip'],
	'COUNTRY' => $user_data['country'],
	'PHONE' => $user_data['phone'],
	'DOB' => $birthdate,
	'QUESTION' => $question,
	'MODE' => $mode,
	'ID' => $_GET['id'],
	'OFFSET' => $_GET['offset']
));

if($URLHeader)
{
	$system->URLRedirect($link);
}else{
	include 'adminHeader.php';
	$template->set_filenames(array(
			'body' => 'excludeuser.tpl'
			));
	$template->display('body');
	include 'adminFooter.php';
}
