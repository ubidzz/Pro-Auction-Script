<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);

// add or edit a value
if (isset($_POST['action']) && $_POST['action'] == 'add')
{
	$seller_countries = implode(' ', $_POST['seller_countries']);
	$buyer_countries = implode(' ', $_POST['buyer_countries']);
	if ($_POST['tax_id'] != '')
	{
		$query = "UPDATE " . $DBPrefix . "tax SET
				tax_name = :tn,
				tax_rate = :tr,
				countries_seller = :cs,
				countries_buyer = :cb
				WHERE id = :i";
		$params = array();
		$params[] = array(':tn', $system->cleanvars($_POST['tax_name']), 'str');
		$params[] = array(':tr', $system->cleanvars($_POST['tax_rate']), 'str');
		$params[] = array(':cs', $system->cleanvars($seller_countries), 'str');
		$params[] = array(':cb', $system->cleanvars($buyer_countries), 'str');
		$params[] = array(':i', intval($_POST['tax_id']), 'int');
		$db->query($query, $params);
	}
	else
	{
		$query = "INSERT INTO " . $DBPrefix . "tax (tax_name, tax_rate, countries_seller, countries_buyer) VALUES
				('" . $system->cleanvars($_POST['tax_name']) . "', '" . $system->cleanvars($_POST['tax_rate']) . "', '" . $system->cleanvars($seller_countries) . "', '" . $system->cleanvars($buyer_countries) . "')";
		$db->direct_query($query);
	}
}

// update site fee
if (isset($_POST['action']) && $_POST['action'] == 'sitefee')
{
	$query = "UPDATE " . $DBPrefix . "tax SET fee_tax = :ft";
	$params = array();
	$params[] = array(':ft', 0, 'int');
	$db->query($query, $params);
	$query = "UPDATE " . $DBPrefix . "tax SET fee_tax = :ft WHERE id = :i";
	$params = array();
	$params[] = array(':ft', 1, 'int');
	$params[] = array(':i', $_POST['site_fee'], 'int');
	$db->query($query, $params);
}

$tax_seller_data = array();
$tax_buyer_data = array();
if (isset($_GET['type']) && $_GET['type'] == 'edit')
{
	$query = "SELECT * FROM " . $DBPrefix . "tax WHERE id = :i";
	$params = array();
	$params[] = array(':i', intval($_GET['id']), 'int');
	$db->query($query, $params);
	$data = $db->result();
	$tax_seller_data = explode(' ', $data['countries_seller']);
	$tax_buyer_data = explode(' ', $data['countries_buyer']);
}

if (isset($_GET['type']) && $_GET['type'] == 'delete')
{
	$query = "DELETE FROM " . $DBPrefix . "tax WHERE id = :i";
	$params = array();
	$params[] = array(':i', intval($_GET['id']), 'int');
	$db->query($query, $params);
	header('location: tax_levels.php');
}

// get tax levels
$query = "SELECT * FROM " . $DBPrefix . "tax";
$db->direct_query($query);
while($row = $db->result())
{
	$template->assign_block_vars('tax_rates', array(
			'ID' => $row['id'],
			'TAX_NAME' => $row['tax_name'],
			'TAX_RATE' => floatval($row['tax_rate']),
			'TAX_SELLER' => $row['countries_seller'],
			'TAX_BUYER' => $row['countries_buyer'],
			'TAX_SITE_RATE' => $row['fee_tax']
			));
}

// get countries and make a list
$query = "SELECT * FROM " . $DBPrefix . "countries";
$db->direct_query($query);$tax_seller = '';
$tax_buyer = '';
while($row = $db->result())
{
	if (in_array($row['country'], $tax_seller_data))
		$tax_seller .= '<option value="' . $row['country'] . '" selected="selected">' . $row['country'] . '</option>';
	else
		$tax_seller .= '<option value="' . $row['country'] . '">' . $row['country'] . '</option>';
	if (in_array($row['country'], $tax_buyer_data))
		$tax_buyer .= '<option value="' . $row['country'] . '" selected="selected">' . $row['country'] . '</option>';
	else
		$tax_buyer .= '<option value="' . $row['country'] . '">' . $row['country'] . '</option>';

}

$template->assign_vars(array(
	'TAX_ID' => (isset($data['id'])) ? $data['id'] : '',
	'TAX_NAME' => (isset($data['tax_name'])) ? $data['tax_name'] : '',
	'TAX_RATE' => (isset($data['tax_rate'])) ? $data['tax_rate'] : '',
	'TAX_SELLER' => $tax_seller,
	'TAX_BUYER' => $tax_buyer,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['1088'],
	'PAGETITLE' => $MSG['1088']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'tax_levels.tpl'
		));
$template->display('body');
include 'adminFooter.php';