<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);

$id = intval($_REQUEST['id']);
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if ((!empty($_POST['password']) && empty($_POST['repeatpassword'])) || (empty($_POST['password']) && !empty($_POST['repeatpassword'])))
	{
		$ERROR = $ERR['054'];
	}
	elseif ($_POST['password'] != $_POST['repeatpassword'])
	{
		$ERROR = $ERR['006'];
	}
	else
	{ 
		// Update
		$password = $_POST['password'];
		$hashed_password = $phpass->HashPassword($password);		
		$query = "UPDATE " . $DBPrefix . "adminusers SET";
		$params = array();
		if (!empty($_POST['password']))
		{
			$query .= " password = :p, ";
			$params[] = array(':p', $hashed_password, 'str');
		}
		$query .= " status = :s	WHERE id = :i";
		$params[] = array(':s', intval($_POST['status']), 'int');
		$params[] = array(':i', $id, 'int');
		$db->query($query, $params);

		header('location: adminusers.php');
		exit;
	}
}

$query = "SELECT * FROM " . $DBPrefix . "adminusers WHERE id = :i";
$params = array();
$params[] = array(':i', $id, 'int');
$db->query($query, $params);
$user_data = $db->result();

if ($system->SETTINGS['datesformat'] == 'USA')
{
	$CREATED = substr($user_data['created'], 4, 2) . '/' . substr($user_data['created'], 6, 2) . '/' . substr($user_data['created'], 0, 4);
}
else
{
	$CREATED = substr($user_data['created'], 6, 2) . '/' . substr($user_data['created'], 4, 2) . '/' . substr($user_data['created'], 0, 4);
}

if ($user_data['lastlogin'] == 0)
{
	$LASTLOGIN = $MSG['570'];
}
else
{
	$LASTLOGIN = $system->dateToTimestamp($user_data['lastlogin']);
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'ID' => $id,
	'USERNAME' => $user_data['username'],
	'CREATED' => $CREATED,
	'LASTLOGIN' => $LASTLOGIN,
	'PAGENAME' => $MSG['511'],
	'PAGETITLE' => $MSG['511'],
	'B_ACTIVE' => ($user_data['status'] == 1),
	'B_INACTIVE' => ($user_data['status'] == 2)
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'editadminuser.tpl'
		));
$template->display('body');
include 'adminFooter.php';