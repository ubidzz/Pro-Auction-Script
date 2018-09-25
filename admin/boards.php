<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);

// Delete boards
if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	foreach ($_POST['delete'] as $k => $v)
	{
		$v = intval($v);
		$query = "DELETE FROM " . $DBPrefix . "community WHERE id = :i";
		$params = array();
		$params[] = array(':i', $v, 'int');
		$db->query($query, $params);

		$query = "DELETE FROM " . $DBPrefix . "comm_messages WHERE boardid = :i";
		$params = array();
		$params[] = array(':i', $v, 'int');
		$db->query($query, $params);
	}
	$ERROR = $MSG['5044'];
}

// get list of boards
$query = "SELECT * FROM " . $DBPrefix . "community ORDER BY :n";
$params = array();
$params[] = array(':n', 'name', 'str');
$db->query($query, $params);
while ($row = $db->result())
{
	$template->assign_block_vars('boards', array(
		'ID' => $row['id'],
		'NAME' => $row['name'],
		'ACTIVE' => $row['active'],
		'MSGTOSHOW' => $row['msgstoshow'],
		'MSGCOUNT' => $row['messages']
	));
}
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['5032'],
	'PAGETITLE' => $MSG['5032']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'boards.tpl'
		));
$template->display('body');
include 'adminFooter.php';