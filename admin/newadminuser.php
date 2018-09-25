<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: http://www.Pro-Auction-Script.com
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['repeatpassword']))
	{
		$ERROR = $ERR['047'];
	}
	elseif ((!empty($_POST['password']) && empty($_POST['repeatpassword'])) || empty($_POST['password']) && !empty($_POST['repeatpassword']))
	{
		$ERROR = $ERR['054'];
	}
	elseif ($_POST['password'] != $_POST['repeatpassword'])
	{
		$ERROR = $ERR['006'];
	}
	else
	{
		// Check if "username" already exists in the database
		$query = "SELECT id FROM " . $DBPrefix . "adminusers WHERE username = :u";
		$params = array();
		$params[] = array(':u', $_POST['username'], 'str');
		$db->query($query, $params);
		if ($db->result() > 0)
		{
			$ERROR = sprintf($ERR['055'], $_POST['username']);
		}
		else
		{
			$password = $_POST['password'];
			$PASS = $phpass->HashPassword($password);
			$query = "INSERT INTO " . $DBPrefix . "adminusers VALUES
					(NULL, '" . addslashes($_POST['username']) . "', '" . $PASS . "', '" . get_hash() . "', '" . date('Ymd') . "', '0', " . intval($_POST['status']) . ", '')";
			$db->direct_query($query);
			header('location: adminusers.php');
			exit;
		}
	}
}

loadblock($MSG['003'], '', 'text', 'username', '');
loadblock($MSG['004'], '', 'password', 'password', '');
loadblock($MSG['564'], '', 'password', 'repeatpassword', '');
loadblock('', '', 'batch', 'status', 1, array($MSG['566'], $MSG['567']));

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0010'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['367'],
	'PAGETITLE' => $MSG['367']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';