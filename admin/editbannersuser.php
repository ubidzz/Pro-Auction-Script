<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);
$id = $_REQUEST['id'];

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (empty($_POST['name']) || empty($_POST['company']) || empty($_POST['email']))
	{
		$ERROR = $ERR['047'];
		$USER = $_POST;
	}
	elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['email']))
	{
		$ERROR = $ERR['008'];
		$USER = $_POST;
	}
	else
	{
		// Update database
		$query = "UPDATE " . $DBPrefix . "bannersusers SET
				  name = :n,
				  company = :c,
				  email = :e
				  WHERE id = :i";
		$params = array();
		$params[] = array(':n', $_POST['name'], 'str');
		$params[] = array(':c', $_POST['company'], 'str');
		$params[] = array(':e', $_POST['email'], 'str');
		$params[] = array(':i', $id, 'int');
		$db->query($query, $params);

		header('location: managebanners.php');
		exit;
	}
}
else
{
	$query = "SELECT * FROM " . $DBPrefix . "bannersusers WHERE id = :i";
	$params = array();
	$params[] = array(':i', $id, 'int');
	$db->query($query, $params);
	if ($db->numrows() > 0)
	{
		$USER = $db->result();
	}
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'ID' => $id,
	'NAME' => (isset($USER['name'])) ? $USER['name'] : '',
	'COMPANY' => (isset($USER['company'])) ? $USER['company'] : '',
	'PAGENAME' => $MSG['511'],
	'PAGETITLE' => $MSG['511']
	'EMAIL' => (isset($USER['email'])) ? $USER['email'] : ''
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'editbanneruser.tpl'
		));
$template->display('body');
include 'adminFooter.php';