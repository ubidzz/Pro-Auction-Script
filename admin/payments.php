<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);

function ToBeDeleted($index)
{
	if (!isset($_POST['delete']))
		return false;

	$i = 0;
	while ($i < count($_POST['delete']))
	{
		if ($_POST['delete'][$i] == $index) return true;
		$i++;
	}
	return false;
}


if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Build new payments array
	$rebuilt_array = array();
	for ($i = 0; $i < count($_POST['new_payments']); $i++)
	{
		if (!ToBeDeleted($i) && strlen($_POST['new_payments'][$i]) != 0)
		{
			$rebuilt_array[] = $_POST['new_payments'][$i];
		}
	}

	$system->writesetting("settings", "payment_options",  $rebuilt_array, 'array');
	$ERROR = $MSG['093'];
}

$payment_options = unserialize($system->SETTINGS['payment_options']);
foreach ($payment_options as $k => $v)
{
	$template->assign_block_vars('payments', array(
			'PAYMENT' => $v,
			'ID' => $k
			));
}
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a style="color:lime" href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_payment_methods" target="_blank">' .  $MSG['075'] . '</a>',
	'PAGETITLE' => $MSG['075']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'payments.tpl'
		));
$template->display('body');
include 'adminFooter.php';