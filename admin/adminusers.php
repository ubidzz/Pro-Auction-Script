<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);

if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	if (in_array($security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_IN']), $_POST['delete']))
	{
		$ERROR = $MSG['1100'];
	}
	else
	{
		foreach ($_POST['delete'] as $id)
		{
			$query = "DELETE FROM " . $DBPrefix . "adminusers WHERE id = :delete";
			$params = array();
			$params[] = array(':delete', $id, 'int');
			$db->query($query, $params);
		}
		$ERROR = $MSG['1101'];
	}
}

$query = "SELECT * FROM " . $DBPrefix . "adminusers ORDER BY :u";
$params = array();
$params[] = array(':u', 'username', 'str');
$db->query($query, $params);

$STATUS = array(
	1 => '<span style="color:#00AF33"><b>Active</b></span>',
	2 => '<span style="color:#FF0000"><b>Not active</b></span>'
);

$bg = '';
while ($User = $db->result())
{
    $created = substr($User['created'], 4, 2) . '/' . substr($User['created'], 6, 2) . '/' . substr($User['created'], 0, 4);
    if ($User['lastlogin'] == 0)
    {
		$lastlogin = $MSG['570'];
    }
    else
    {
		$lastlogin = date('d/m/Y H:i:s', $User['lastlogin']);
    }

    $template->assign_block_vars('users', array(
			'ID' => $User['id'],
			'USERNAME' => $User['username'],
			'STATUS' => $STATUS[$User['status']],
			'CREATED' => $created,
			'LASTLOGIN' => $lastlogin,
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['365'],
	'PAGETITLE' => $MSG['365']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminusers.tpl'
		));
$template->display('body');
include 'adminFooter.php';