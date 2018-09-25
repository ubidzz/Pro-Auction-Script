<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

if(isset($_POST['action']) && $_POST['action'] == 'edit' && is_array($_POST['id']) && is_array($_POST['mine']) && is_array($_POST['extension']) && is_array($_POST['used']))
{
	foreach($_POST['id'] as $id)
	{
		$query = "UPDATE " . $DBPrefix . "digital_item_mime SET name = :name, mine_type = :mine, file_extension = :extension, use_mime = :used WHERE id = :id";
		$params = array();
		$params[] = array(':name', $_POST['name'][$id], 'str');
		$params[] = array(':mine', $_POST['mine'][$id], 'str');
		$params[] = array(':extension', $_POST['extension'][$id], 'str');
		$params[] = array(':used', $_POST['used'][$id], 'bool');
		$params[] = array(':id', $id, 'int');
		$db->query($query, $params);
		$ERROR = $MSG['3500_1015775'];
	}
}
if(isset($_POST['action']) && $_POST['action'] == 'new')
{
	$query = "INSERT INTO " . $DBPrefix . "digital_item_mime VALUES (NULL, :name, :mine, :extension, :used)";
	$params = array();
	$params[] = array(':name', $_POST['name'], 'str');
	$params[] = array(':mine', $_POST['mine'], 'str');
	$params[] = array(':extension', $_POST['extension'], 'str');
	$params[] = array(':used', $_POST['used'], 'bool');
	$db->query($query, $params);
	$ERROR = $MSG['3500_1015774'];

}
if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	foreach ($_POST['delete'] as $v)
	{
		$query = "DELETE FROM " . $DBPrefix . "digital_item_mime WHERE id = :id";
		$params = array();
		$params[] = array(':id', $v, 'int');
		$db->query($query, $params);
		$ERROR = $MSG['3500_1015776'];
	}
}

// Get data from the database
$query = "SELECT * FROM " . $DBPrefix . "digital_item_mime ORDER BY name ASC";
$db->direct_query($query);
while ($row = $db->result())
{
	$template->assign_block_vars('mime_type', array(
		'ID' => $row['id'],
		'NAME' => $row['name'],
		'MINE' => $row['mine_type'],
		'EXTENSION' => $row['file_extension'],
		'USED_Y' => $row['use_mime'] == 'y' ? 'checked' : '',
		'USED_N' => $row['use_mime'] == 'n' ? 'checked' : '',
	));
}

$template->assign_vars(array(
	'TYPENAME' => $MSG['5142'],
	'ERROR' => (isset($ERR)) ? $ERR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_asettings" target="_blank">' . $MSG['3500_1015770'] . '</a>',
	'PAGETITLE' => $MSG['3500_1015770']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'minetype.tpl'
		));
$template->display('body');
include 'adminFooter.php';