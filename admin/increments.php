<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
$current_page = '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_bid_increments" target="_blank">' . $MSG['128'] . '</a>';

function ToBeDeleted($index)
{
	global $delete;

	if (in_array($index, $delete))
	{
		return true;
	}
	return false;
}

unset($ERROR);

if (isset($_POST['action']) && $_POST['action'] = 'update')
{
	//edit increments
	$ids = $_POST['id'];
	$increments = $_POST['increments'];
	$lows = $_POST['lows'];
	$highs = $_POST['highs'];
	$delete = (isset($_POST['delete'])) ? $_POST['delete'] : array();
	
	//new increments
	$new_increments = $_POST['new_increments'];
	$new_lows = $_POST['new_lows'];
	$new_highs = $_POST['new_highs'];

	if(!empty($new_increments) && !empty($new_lows) && !empty($new_highs))
	{
		$query = "INSERT INTO " . $DBPrefix . "increments VALUES (NULL, :low, :high, :inc)";
		$params = array();
		$params[] = array(':low', $system->input_money($new_lows), 'float');
		$params[] = array(':high', $system->input_money($new_highs), 'float');
		$params[] = array(':inc', $system->input_money($new_increments), 'float');
		$db->query($query, $params);
		$ERROR = $MSG['160_a'];
	}
	else
	{
		for ($i = 0; $i < count($increments); $i++)
		{
			if (!ToBeDeleted($ids[$i]))
			{
				if ($system->input_money($lows[$i]) + $system->input_money($highs[$i]) + $system->input_money($increments[$i]) > 0)
				{
					$query = "UPDATE " . $DBPrefix . "increments SET low = :low, high = :high, increment = :inc WHERE id = :inc_id";
					$params = array();
					$params[] = array(':low', $system->input_money($lows[$i]), 'float');
					$params[] = array(':high', $system->input_money($highs[$i]), 'float');
					$params[] = array(':inc', $system->input_money($increments[$i]), 'float');
					$params[] = array(':inc_id', $ids[$i], 'int');
					$db->query($query, $params);
					$ERROR = $MSG['160'];
				}
			}
			else
			{
				$query = "DELETE FROM " . $DBPrefix . "increments WHERE id = :inc_id";
				$params = array();
				$params[] = array(':inc_id', $ids[$i], 'int');
				$db->query($query, $params);
				$ERROR = $MSG['160_b'];
			}
		}
	}
}

$query = "SELECT * FROM " . $DBPrefix . "increments ORDER BY low ASC";
$db->direct_query($query);
while ($row = $db->result())
{
	$template->assign_block_vars('increments', array(
		'ID' => $row['id'],
		'HIGH' => $system->print_money_nosymbol($row['high']),
		'LOW' => $system->print_money_nosymbol($row['low']),
		'INCREMENT' => $system->print_money_nosymbol($row['increment'])
	));
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_bid_increments" target="_blank">' . $MSG['128'] . '</a>',
	'PAGETITLE' => $MSG['128']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'increments.tpl'
		));
$template->display('body');
include 'adminFooter.php';