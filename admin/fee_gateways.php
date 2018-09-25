<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);

$links = array(
	'paypal' => 'http://paypal.com/',
	'authnet' => 'http://authorize.net/',
	'worldpay' => 'http://rbsworldpay.com/',
	'skrill' => 'http://skrill.com/',
	'toocheckout' => 'http://2checkout.com/',
);
$varialbes = array(
	'paypal_address' => $MSG['720'],
	'authnet_address' => $MSG['773'],
	'authnet_password' => $MSG['774'],
	'worldpay_address' => $MSG['824'],
	'skrill_address' => $MSG['825'],
	'toocheckout_address' => $MSG['826'],
	'bank_name' => $MSG['30_0216'],
	'bank_account' => $MSG['30_0217'],
	'bank_routing' => $MSG['30_0218']
);

$gateway_data = $system->loadTable('gateways');
$gateways = explode(',', $gateway_data['gateways']);
if (isset($_POST['action']))
{
	// build the sql
	for ($i = 0; $i < count($gateways); $i++)
	{
		$system->writesetting("gateways", $gateways[$i] . '_address', $_POST[$gateways[$i] . '_address'], 'str');
		$system->writesetting("gateways", $gateways[$i] . '_name', $_POST[$gateways[$i] . '_name'], 'str');
		$system->writesetting("gateways", $gateways[$i] . '_account', $_POST[$gateways[$i] . '_account'], 'str');
		$system->writesetting("gateways", $gateways[$i] . '_routing', $_POST[$gateways[$i] . '_routing'], 'str');
		$system->writesetting("gateways", $gateways[$i] . '_password', $_POST[$gateways[$i] . '_password'], 'str');
		$system->writesetting("gateways", $gateways[$i] . '_active', isset($_POST[$gateways[$i] . '_active']) ? 1 : 0, 'int');
		$system->writesetting("gateways", $gateways[$i] . '_required', isset($_POST[$gateways[$i] . '_required']) ? 1 : 0, 'int');
	}
	$ERROR = $MSG['762'];
}

$gateway_data = $system->loadTable('gateways');
$gateways = explode(',', $gateway_data['gateways']);
for ($i = 0; $i < count($gateways); $i++)
{
	$gateway = $gateways[$i];
	$template->assign_block_vars('gateways', array(
			'NAME' => $system->SETTINGS['gateways'][$gateway],
			'PLAIN_NAME' => $gateway,
			'ENABLED' => ($gateway_data[$gateway . '_active'] == 1) ? 'checked' : '',
			'REQUIRED' => ($gateway_data[$gateway . '_required'] == 1) ? 'checked' : '',
			'ADDRESS' => $gateway_data[$gateway . '_address'],
			'PASSWORD' => (isset($gateway_data[$gateway . '_password'])) ? $gateway_data[$gateway . '_password'] : '',
			'WEBSITE' => $links[$gateway],
			'ADDRESS_NAME' => $varialbes[$gateway . '_address'],
			'ADDRESS_PASS' => (isset($varialbes[$gateway . '_password'])) ? $varialbes[$gateway . '_password'] : '',
			
			'BANK_NAME' => (isset($varialbes[$gateway . '_name'])) ? $varialbes[$gateway . '_name'] : '',
			'BANK_NAME2' => $gateway_data[$gateway . '_name'],
			'BANK_ACCOUNT' => (isset($varialbes[$gateway . '_account'])) ? $varialbes[$gateway . '_account'] : '',
			'BANK_ACCOUNT2' => $gateway_data[$gateway . '_account'],
			'BANK_ROUTING' => (isset($varialbes[$gateway . '_routing'])) ? $varialbes[$gateway . '_routing'] : '',
			'BANK_ROUTING2' => $gateway_data[$gateway . '_routing'],

			'B_PASSWORD' => (isset($gateway_data[$gateway . '_password'])),
			'B_BANK_NAME' => (isset($gateway_data[$gateway . '_name'])),
			'B_BANK_ACCOUNT' => (isset($gateway_data[$gateway . '_account'])),
			));
}
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['445'],
	'PAGETITLE' => $MSG['445']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'fee_gateways.tpl'
		));
$template->display('body');
include 'adminFooter.php';