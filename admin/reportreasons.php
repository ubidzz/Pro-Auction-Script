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
	// update reasonss table
	$rebuilt_report_class = array();
	$rebuilt_report_reason = array();

	foreach ($_POST['new_report_reason'] as $k => $v)
	{
		if ((isset($_POST['delete']) && !in_array($k, $_POST['delete']) || !isset($_POST['delete'])) && !empty($_POST['new_report_class'][$k]) &&  !empty($_POST['new_report_reason'][$k]))
		{
			$rebuilt_report_class[] = $_POST['new_report_class'][$k];
			$rebuilt_report_reason[] = $_POST['new_report_reason'][$k];
		
		}
	}

	$query = "DELETE FROM " . $DBPrefix . "report_reasons";
	$db->direct_query($query);


	for ($i = 0; $i < count($rebuilt_report_reason); $i++)
	{
		$query = "INSERT INTO " . $DBPrefix . "report_reasons VALUES (:rebuilt, :class)";
		$params = array();
		$params[] = array(':rebuilt', $rebuilt_report_reason[$i], 'str');
		$params[] = array(':class', $system->cleanvars($rebuilt_report_class[$i]), 'str');
		$db->query($query, $params);
	}

	$ERROR = $MSG['1408'];
}

$query = "SELECT * FROM " . $DBPrefix . "report_reasons ORDER BY :reason";
$params = array();
$params[] = array(':reason', 'report_reason', 'str');
$db->query($query, $params);

$i = 0;
while ($row = $db->result())
{
	$template->assign_block_vars('reasons', array(
		'ID' => $i,
		'REPORT_REASON' => $row['report_reason'],
		'REPORT_CLASS' => $row['report_class'],
		'REPORT_CLASS1' => ($row['report_class'] == 1 || empty($increments)) ? 'checked' : '',
		'REPORT_CLASS2' => ($row['report_class'] == 2) ? 'checked' : '',
		'REPORT_CLASS3' => ($row['report_class'] == 3) ? 'checked' : '',
	));
	$i++;
}
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['1406'],
	'PAGETITLE' => $MSG['1406']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'reportreasons.tpl'
		));
$template->display('body');
include 'adminFooter.php';