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
	$system->writesetting("settings", "invoice_yellow_line", $_POST['invoice_yellow_line'], 'str');
	$system->writesetting("settings", "invoice_thankyou", $_POST['invoice_thankyou'], 'str');
	$ERROR = $MSG['1095'];
}

loadblock($MSG['1096'], $MSG['1097'], 'text', 'invoice_yellow_line', $system->SETTINGS['invoice_yellow_line']);
loadblock($MSG['1098'], $MSG['1099'], 'text', 'invoice_thankyou', $system->SETTINGS['invoice_thankyou']);

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0012'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['1094'],
	'PAGETITLE' => $MSG['1094']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';