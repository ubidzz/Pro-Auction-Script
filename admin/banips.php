<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (!empty($_POST['ip']))
	{
		$query = "INSERT INTO " . $DBPrefix . "usersips VALUES (NULL, :no,  :ban, :n, :d)";
		$params = array();
		$params[] = array(':no', 'NOUSER', 'str');
		$params[] = array(':ban', $_POST['ip'], 'int');
		$params[] = array(':n', 'next', 'str');
		$params[] = array(':d', 'deny', 'str');
		$db->query($query, $params);

	}
	if (is_array($_POST['delete']))
	{
		foreach ($_POST['delete'] as $k => $v)
		{
			$query = "DELETE FROM " . $DBPrefix . "usersips WHERE id = :i";
			$params = array();
			$params[] = array(':i', intval($v), 'int');
			$db->query($query, $params);
		}
	}
	if (is_array($_POST['accept']))
	{
		foreach ($_POST['accept'] as $k => $v)
		{
			$query = "UPDATE " . $DBPrefix . "usersips SET action = :a WHERE id = :i";
			$params = array();
			$params[] = array(':a', 'accept', 'str');
			$params[] = array(':i', intval($v), 'int');
			$db->query($query, $params);
		}
	}
	if (is_array($_POST['deny']))
	{
		foreach ($_POST['deny'] as $k => $v)
		{
			$query = "UPDATE " . $DBPrefix . "usersips SET action = :d WHERE id = :i";
			$params = array();
			$params[] = array(':d', 'deny', 'str');
			$params[] = array(':i', intval($v), 'int');
			$db->query($query, $params);
		}
	}
}

$query = "SELECT * FROM " . $DBPrefix . "usersips WHERE action = :d";
$params = array();
$params[] = array(':d', 'deny', 'str');
$db->query($query, $params);
$bg = '';
while ($row = $db->result())
{
	$template->assign_block_vars('ips', array(
			'ID' => $row['id'],
			'IP' => $row['ip'],
			'ACTION' => $row['action'],
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['2_0017'],
	'PAGETITLE' => $MSG['2_0017']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'banips.tpl'
		));
$template->display('body');
include 'adminFooter.php';