<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// update durations table
	$rebuilt_durations = array();
	$rebuilt_days = array();

	foreach ($_POST['new_durations'] as $k => $v)
	{
		if ((isset($_POST['delete']) && !in_array($k, $_POST['delete']) || !isset($_POST['delete'])) && !empty($_POST['new_durations'][$k]) && !empty($_POST['new_days'][$k]))
		{
			$rebuilt_durations[] = $_POST['new_durations'][$k];
			$rebuilt_days[] = $_POST['new_days'][$k];
		}
	}

	$query = "DELETE FROM " . $DBPrefix . "durations";
	$db->direct_query($query);


	for ($i = 0; $i < count($rebuilt_durations); $i++)
	{
		$query = "INSERT INTO " . $DBPrefix . "durations VALUES (:dy, :ds)";
		$params = array();
		$params[] = array(':dy', $rebuilt_days[$i], 'int');
		$params[] = array(':ds', $system->cleanvars($rebuilt_durations[$i]), 'str');
		$db->query($query, $params);
	}

	$ERROR = $MSG['123'];
}

$query = "SELECT * FROM " . $DBPrefix . "durations ORDER BY :d";
$params = array();
$params[] = array(':d', 'days', 'str');
$db->query($query, $params);

$i = 0;
while ($row = $db->result())
{
	$template->assign_block_vars('dur', array(
			'ID' => $i,
			'DAYS' => $row['days'],
			'DESC' => $row['description']
			));
	$i++;
}

$template->assign_vars(array(
	'SITEURL' => $system->SETTINGS['siteurl'],
	'PAGENAME' => '<a style="color:lime" href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_auctions_duration" target="_blank">' . $MSG['069'] . '</a>',
	'PAGETITLE' => $MSG['069'],
	'ERROR' => (isset($ERROR)) ? $ERROR : ''
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'durations.tpl'
		));
$template->display('body');
include 'adminFooter.php';