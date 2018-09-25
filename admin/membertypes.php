<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include INCLUDE_PATH . 'functions_rebuild.php';
include INCLUDE_PATH . 'membertypes.inc.php';
unset($ERROR);

if (isset($_POST['action']) && $_POST['action'] = 'update')
{
	$old_membertypes = $_POST['old_membertypes'];
	$new_membertypes = $_POST['new_membertypes'];
	$new_membertype = $_POST['new_membertype'];

	// delete with the deletes
	if (isset($_POST['delete']) && is_array($_POST['delete']))
	{
		$idslist = implode(',', $_POST['delete']);
		$query = "DELETE FROM " . $DBPrefix . "membertypes WHERE id IN (:l)";
		$params = array();
		$params[] = array(':l', $idslist, 'str');
		$db->query($query, $params);
	}

	// now update everything else
	if (is_array($old_membertypes))
	{
		foreach ($old_membertypes as $id => $val)
		{
			if ( $val != $new_membertypes[$id])
			{
				$query = "UPDATE " . $DBPrefix . "membertypes SET feedbacks = :f, icon = :ic WHERE id = :i";
				$params = array();
				$params[] = array(':f', $new_membertypes[$id]['feedbacks'], 'int');
				$params[] = array(':ic', $system->cleanvars($new_membertypes[$id]['icon']), 'str');
				$params[] = array(':i', $id, 'int');
				$db->query($query, $params);
			}
		}
	}

	// If a new membertype was added, insert it into database
	if (!empty($new_membertype['feedbacks']))
	{
		$query = "INSERT INTO " . $DBPrefix . "membertypes VALUES (NULL, :f, :ic);";
		$params = array();
		$params[] = array(':f', $new_membertype['feedbacks'], 'int');
		$params[] = array(':ic', $system->cleanvars($new_membertype['icon']), 'int');
		$db->query($query, $params);
	}
	rebuild_table_file('membertypes');
	$ERROR = $MSG['836'];
}

foreach ($membertypes as $id => $quest)
{
    $template->assign_block_vars('mtype', array(
			'ID' => $id,
			'FEEDBACK' => $quest['feedbacks'],
			'ICON' => $quest['icon']
			));
}
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_membership_levels" target="_blank">' . $MSG['25_0169'] . '</a>',
	'PAGETITLE' => $MSG['25_0169']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'membertypes.tpl'
		));
$template->display('body');
include 'adminFooter.php';