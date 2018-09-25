<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

$id = intval($_REQUEST['id']);
$uloffset = intval($_REQUEST['offset']);
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (is_array($_POST['accept']))
	{
		foreach ($_POST['accept'] as $v)
		{
			$query = "UPDATE " . $DBPrefix . "usersips SET action = 'accept' WHERE id = :i";
			$params = array();
			$params[] = array(':i', $v, 'int');
			$db->query($query, $params);
		}
	}
	if (is_array($_POST['deny']))
	{
		foreach ($_POST['deny'] as $v)
		{
			$query = "UPDATE " . $DBPrefix . "usersips SET action = :d WHERE id = :i";
			$params = array();
			$params[] = array(':i', $v, 'int');
			$params[] = array(':d', 'deny', 'str');
			$db->query($query, $params);
		}
	}
}

$query = "SELECT COUNT(*) As ips FROM " . $DBPrefix . "usersips WHERE user = :i";
$params = array();
$params[] = array(':i', $v, 'int');
$db->query($query, $params);
$num_ips = $db->result('ips');

// Handle pagination
if (!isset($_GET['PAGE']) || $_GET['PAGE'] == '')
{
	$OFFSET = 0;
	$PAGE = 1;
}
else
{
	$PAGE = $_GET['PAGE'];
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
$PAGES = ($num_ips == 0) ? 1 : ceil($num_ips / $system->SETTINGS['perpage']);

$query = "SELECT nick, lastlogin FROM " . $DBPrefix . "users WHERE id = :i";
$params = array();
$params[] = array(':i', $id, 'int');
$db->query($query, $params);

if ($db->numrows() > 0)
{
	$USER = $db->result();
}

$query = "SELECT id, type, ip, action FROM " . $DBPrefix . "usersips WHERE user = :i LIMIT :o, :p";
$params = array();
$params[] = array(':i', $id, 'int');
$params[] = array(':o', $OFFSET, 'int');
$params[] = array(':p', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);

if ($db->numrows() > 0)
{
	$bg = '';
	while ($row = $db->result())
	{
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#EEEEEE' : '#FFFFFF';
		$template->assign_block_vars('ips', array(
				'TYPE' => $row['type'],
				'ID' => $row['id'],
				'IP' => $row['ip'],
				'ACTION' => $row['action'],
				'BG' => $bg
				));
		$bg = ($bg == '') ? 'class="bg"' : '';
	}
}

// get pagenation
$url_id = 'id=' . $id;
$PREV = intval($PAGE - 1);
$NEXT = intval($PAGE + 1);
if ($PAGES > 1)
{
	$LOW = $PAGE - 5;
	if ($LOW <= 0) $LOW = 1;
	$COUNTER = $LOW;
	while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6))
	{
		$template->assign_block_vars('pages', array(
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'admin/viewuserips.php?' . $url_id . '&PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
	'ID' => $id,
	'NICK' => $USER['nick'],
	'LASTLOGIN' => date('Y-m-d H:i:s', strtotime($USER['lastlogin']) + $system->TDIFF),
	'OFFSET' => $uloffset,
	'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/viewuserips.php?' . $url_id . '&PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
	'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/viewuserips.php?' . $url_id . '&PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
	'PAGE' => $PAGE,
	'PAGES' => $PAGES,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['3500_1015860'],
	'PAGETITLE' => $MSG['3500_1015860']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'viewuserips.tpl'
		));
$template->display('body');
include 'adminFooter.php';