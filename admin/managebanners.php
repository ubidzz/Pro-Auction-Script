<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
// Delete users and banners if necessary
if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	foreach ($_POST['delete'] as $k => $v)
	{
		$query = "DELETE FROM " . $DBPrefix . "banners WHERE user = :i";
		$params = array();
		$params[] = array(':i', $v, 'int');
		$db->query($query, $params);

		$query = "DELETE FROM " . $DBPrefix . "bannersusers WHERE id = :i";
		$params = array();
		$params[] = array(':i', $v, 'int');
		$db->query($query, $params);
	}
}

// Retrieve users from the database
$query = "SELECT u.*, COUNT(b.user) as count FROM " . $DBPrefix . "bannersusers u
		LEFT JOIN " . $DBPrefix . "banners b ON (b.user = u.id)
		GROUP BY u.id ORDER BY u.name";
$db->direct_query($query);
$bg = '';
while ($row = $db->result())
{
	$template->assign_block_vars('busers', array(
			'ID' => $row['id'],
			'NAME' => $row['name'],
			'COMPANY' => $row['company'],
			'EMAIL' => $row['email'],
			'NUM_BANNERS' => $row['count'],
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_banners_administration" target="_blank">' . $MSG['_0008'] . '</a>',
	'PAGETITLE' => $MSG['_0008']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'managebanners.tpl'
		));
$template->display('body');
include 'adminFooter.php';