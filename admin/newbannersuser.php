<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
$current_page = $MSG['3500_1015858'];

unset($ERROR);

if (isset($_POST['action']) && $_POST['action'] == 'insert')
{
	if (empty($_POST['name']) || empty($_POST['company']) || empty($_POST['email']))
	{
		$ERROR = $ERR['047'];
	}
	elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['email']))
	{
		$ERROR = $ERR['008'];
	}
	else
	{
		// Update database
		$query = "INSERT INTO " . $DBPrefix . "bannersusers VALUES
		(NULL, :n, :c, :e)";
		$params = array();
		$params[] = array(':n', $_POST['name']), 'str');
		$params[] = array(':c', $_POST['company'], 'str');
		$params[] = array(':e', $_POST['email'], 'str');
		$db->query($query, $params);

		$ID = $db->lastInsertId();
		header('location: userbanners.php?id=' . $ID);
		exit;
	}
}

$template->assign_vars(array(
	'NAME' => (isset($_POST['name'])) ? $_POST['name'] : '',
	'COMPANY' => (isset($_POST['company'])) ? $_POST['company'] : '',
	'EMAIL' => (isset($_POST['email'])) ? $_POST['email'] : '',
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['3500_1015858'],
	'PAGETITLE' => $MSG['3500_1015858']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'newbanneruser.tpl'
		));
$template->display('body');
include 'adminFooter.php';