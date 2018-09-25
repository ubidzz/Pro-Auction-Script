<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

$fees = array( //0 = single value, 1 = staged fees
	'signup_fee' => 0,
	'buyer_fee' => 1,
	'setup' => 1,
	'hpfeat_fee' => 0,
	'bolditem_fee' => 0,
	'hlitem_fee' => 0,
	'subtitle_fee' => 0,
	'excat_fee' => 0,
	'rp_fee' => 0,
	'picture_fee' => 0,
	'relist_fee' => 0,
	'buyout_fee' => 0,
	'endauc_fee' => 1,
	'banner_fee' => 0,
	'ex_banner_fee' => 0,
	'geomap_fee' => 0
	);

$feenames = array(
	'signup_fee' => $MSG['430'],
	'buyer_fee' => $MSG['775'],
	'setup' => $MSG['432'],
	'hpfeat_fee' => $MSG['433'],
	'bolditem_fee' => $MSG['439'],
	'hlitem_fee' => $MSG['434'],
	'subtitle_fee' => $MSG['803'],
	'excat_fee' => $MSG['804'],
	'rp_fee' => $MSG['440'],
	'picture_fee' => $MSG['435'],
	'relist_fee' => $MSG['437'],
	'buyout_fee' => $MSG['436'],
	'endauc_fee' => $MSG['791'],
	'banner_fee' => $MSG['350_10132'],
	'ex_banner_fee' => $MSG['350_10134'],
	'geomap_fee' => $MSG['3500_1015816'],
	);

if(isset($_GET['type']) && isset($fees[$_GET['type']]))
{
	if($fees[$_GET['type']] == 0)
	{
		if(isset($_POST['action']) && $_POST['action'] == 'update')
		{
			if(!$system->CheckMoney($_POST['value']))
			{
				$errmsg = $ERR['058'];
			}
			else
			{
				$query = "UPDATE " . $DBPrefix . "fees SET value = :v WHERE type = :t";
				$params = array();
				$params[] = array(':v', $system->input_money($_POST['value']), 'int');
				$params[] = array(':t', $_GET['type'], 'str');
				$db->query($query, $params);

				$errmsg = $feenames[$_GET['type']] . $MSG['359'];
			}
		}
		$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = :t";
		$params = array();
		$params[] = array(':t', $_GET['type'], 'str');
		$db->query($query, $params);
		$value = $db->result('value');

		$template->assign_vars(array(
				'VALUE' => $system->print_money_nosymbol($value),
				'CURRENCY' => $system->SETTINGS['currency']
				));
	}
	elseif($fees[$_GET['type']] == 1)
	{
		if(isset($_POST['action']) && $_POST['action'] == 'update')
		{
			for($i = 0; $i < count($_POST['tier_id']); $i++)
			{
				$value = $_POST['value'][$i];
				if ($_POST['type'][$i] == 'flat')
				{
					$value = $system->input_money($value);
				}
				$query = "UPDATE " . $DBPrefix . "fees SET fee_from = :from, fee_to = :to, value = :v, fee_type = :t
						WHERE id = :i";
				$params = array();
				$params[] = array(':from', $system->input_money($_POST['fee_from'][$i]), 'int');
				$params[] = array(':to', $system->input_money($_POST['fee_to'][$i]), 'int');
				$params[] = array(':v', $value, 'int');
				$params[] = array(':t', $_POST['type'][$i], 'str');
				$params[] = array(':i', $_POST['tier_id'][$i], 'str');
				$db->query($query, $params);

				$errmsg = $feenames[$_GET['type']] . $MSG['359'];
			}
			if (isset($_POST['fee_delete']))
			{
				for($i = 0; $i < count($_POST['fee_delete']); $i++)
				{
					$query = "DELETE FROM " . $DBPrefix . "fees WHERE id = :ids";
					$params = array();
					$params[] = array(':ids', $_POST['fee_delete'][$i], 'int');
					$db->query($query, $params);
				}
			}
			if(!empty($_POST['new_fee_from']) && !empty($_POST['new_fee_to']) && !empty($_POST['new_value']) && !empty($_POST['new_type']))
			{
				if ($_POST['new_fee_from'] <= $_POST['new_fee_to'])
				{
					$value = $_POST['new_value'];
					if ($_POST['new_type'] == 'flat')
					{
						$value = $system->input_money($value);
					}
					$query = "INSERT INTO " . $DBPrefix . "fees VALUES
							(NULL, :nff, :nft, :nt, :v, :t)";
					$params = array();
					$params[] = array(':nff', $system->input_money($_POST['new_fee_from']), 'int');
					$params[] = array(':nft', $system->input_money($_POST['new_fee_to']), 'int');
					$params[] = array(':nt', $_POST['new_type'], 'str');
					$params[] = array(':v', $value, 'int');
					$params[] = array(':t', $_GET['type'], 'str');
					$db->query($query, $params);

				}
				else
				{
					$errmsg = $ERR['713'];
				}
			}
		}
		$query = "SELECT * FROM " . $DBPrefix . "fees WHERE type = :t";
		$params = array();
		$params[] = array(':t', $_GET['type'], 'str');
		$db->query($query, $params);
		while($row = $db->result())
		{
			$template->assign_block_vars('fees', array(
					'ID' => $row['id'],
					'FROM' => $system->print_money_nosymbol($row['fee_from']),
					'TO' => $system->print_money_nosymbol($row['fee_to']),
					'FLATTYPE' => ($row['fee_type'] == 'flat') ? ' selected="selected"' : '',
					'PERCTYPE' => ($row['fee_type'] == 'perc') ? ' selected="selected"' : '',
					'VALUE' => ($row['fee_type'] == 'flat') ? $system->print_money_nosymbol($row['value']) : $row['value']
					));
		}

		$template->assign_vars(array(
				'CURRENCY' => $system->SETTINGS['currency'],
				'FEE_FROM' => isset($_POST['new_fee_from']) ? $_POST['new_fee_from'] : '',
				'FEE_TO' => isset($_POST['new_fee_to']) ? $_POST['new_fee_to'] : '',
				'FEE_VALUE' => isset($_POST['new_value']) ? $_POST['new_value'] : '',
				'FEE_TYPE' => isset($_POST['new_type']) ? $_POST['new_type'] : ''
				));
	}
}
$ERROR = (isset($errmsg)) ? $errmsg : '';
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'B_SINGLE' => (isset($_GET['type']) && isset($fees[$_GET['type']]) && $fees[$_GET['type']] == 0) ? true : false,
	'FEETYPE' => (isset($_GET['type']) && isset($feenames[$_GET['type']])) ? $feenames[$_GET['type']] : '',
	'PAGENAME1' => '<a style="color:lime" href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_fees#general" target="_blank">' . $MSG['417'] . '</a>',
	'PAGENAME2' => '<a style="color:lime" href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_fees#auction_fees" target="_blank">' . $MSG['431'] . '</a>',
	'PAGETITLE' => $MSG['417']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'fees.tpl'
		));
$template->display('body');
include 'adminFooter.php';