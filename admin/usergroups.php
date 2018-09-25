<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);
$edit = false;

if (isset($_GET['action']) && !isset($_POST['action']))
{
	if ($_GET['action'] == 'edit' && isset($_GET['id']))
	{
		$query = "SELECT * FROM ". $DBPrefix . "groups WHERE id = :groupid";
		$params = array();
		$params[] = array(':groupid', $_GET['id'], 'int');
		$db->query($query, $params);
		$group = $db->result();
		$template->assign_vars(array(
				'GROUP_ID' => $group['id'],
				'EDIT_NAME' => $group['group_name'],
				'CAN_SELL_Y' => ($group['can_sell'] == 1) ? 'selected="true"' : '',
				'CAN_SELL_N' => ($group['can_sell'] == 0) ? 'selected="true"' : '',
				'CAN_BUY_Y' => ($group['can_buy'] == 1) ? 'selected="true"' : '',
				'CAN_BUY_N' => ($group['can_buy'] == 0) ? 'selected="true"' : '',
				'AUTO_JOIN_Y' => ($group['auto_join'] == 1) ? 'selected="true"' : '',
				'AUTO_JOIN_N' => ($group['auto_join'] == 0) ? 'selected="true"' : '',
				'NO_FEES_Y' => ($group['no_fees'] == 1) ? 'selected="true"' : '',
				'NO_FEES_N' => ($group['no_fees'] == 0) ? 'selected="true"' : '',
				'USER_COUNT' => $group['count']
				));
		$edit = true;
	}
	if ($_GET['action'] == 'new' && empty($_GET['id']))
	{
		$template->assign_vars(array(
				'USER_COUNT' => 0
				));
		$edit = true;
	}
	if ($_GET['action'] == 'delete' && isset($_GET['id']))
	{
		if(is_numeric($_GET['id']))
		{
			// Delete group
			$query = "DELETE FROM " . $DBPrefix . "groups WHERE id = :groupid";
			$params = array();
			$params[] = array(':groupid', intval($_GET['id']), 'int');
			$db->query($query, $params);
		}
	}
}

if (isset($_POST['action']))
{
	$auto_join = true;
	if ($_GET['action'] == 'edit' || is_numeric($_GET['id']))
	{
		$query = "UPDATE ". $DBPrefix . "groups SET
				group_name = '" . $system->cleanvars($_POST['group_name']) . "',
				count = " . intval($_POST['user_count']) . ",
				can_sell = " . intval($_POST['can_sell']) . ",
				can_buy = " . intval($_POST['can_buy']) . ",
				auto_join = " . (($auto_join) ? intval($_POST['auto_join']) : 1) . ",
				can_buy = " . intval($_POST['can_buy']) . ",
				no_fees = " . intval($_POST['no_fees']) . ",
			WHERE id = " . intval($_POST['id']);
		$db->direct_query($query);
		$_SESSION['update_message'] = $MSG['3500_1015691'];
		header('location: ' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/usergroups.php');
		exit;
	}
	if ($_GET['action'] == 'new' || empty($_GET['id']))
	{
		$query = "INSERT INTO ". $DBPrefix . "groups (group_name, count, can_sell, can_buy, auto_join, no_fees, no_setup_fee, no_excat_fee, no_subtitle_fee, no_relist_fee, no_picture_fee, no_hpfeat_fee, no_hlitem_fee, no_bolditem_fee, no_rp_fee, no_buyout_fee, no_fp_fee, no_geomap_fee) VALUES
				('" . $system->cleanvars($_POST['group_name']) . "', " . intval($_POST['user_count']) . ", " . intval($_POST['can_sell']) . ", " . intval($_POST['can_buy']) . ", " . intval($_POST['auto_join']) . ", " . intval($_POST['no_fees']) . ", " . intval(0) . ", " . intval(0) . ", " . intval(0) . ", " . intval(0) . ", " . intval(0) . ", " . intval(0) . ", " . intval(0) . ", " . intval(0) . ", " . intval(0) . ", " . intval(0) . ", " . intval(0) . ", " . intval(0) . ")";
		$db->direct_query($query);
		$_SESSION['update_message'] = $MSG['3500_1015690'];
		header('location: ' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/usergroups.php');
		exit;
	}
}

$query = "SELECT * FROM ". $DBPrefix . "groups";
$db->direct_query($query);
while ($row = $db->result())
{
	$template->assign_block_vars('groups', array(
			'ID' => $row['id'],
			'NAME' => $row['group_name'],
			'CAN_SELL' => ($row['can_sell'] == 1) ? $MSG['030'] : $MSG['029'],
			'CAN_BUY' => ($row['can_buy'] == 1) ? $MSG['030'] : $MSG['029'],
			'AUTO_JOIN' => ($row['auto_join'] == 1) ? $MSG['030'] : $MSG['029'],
			'NO_FEES' => ($row['no_fees'] == 1) ? $MSG['030'] : $MSG['029'],
			'USER_COUNT' => $row['count']
			));
}

$ERROR = (isset($ERROR)) ? $ERROR : isset($_SESSION['update_message']) ? $_SESSION['update_message'] : '';

$template->assign_vars(array(
	'PAGENAME' => $edit ? '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_themes" target="_blank">' . $MSG['452'] . '</a>' : '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_themes" target="_blank">' . $MSG['448'] . '</a>',
	'B_EDIT' => $edit,
	'PAGETITLE' => $MSG['452'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
));

unset($_SESSION['update_message']);
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'usergroups.tpl'
		));
$template->display('body');
include 'adminFooter.php';