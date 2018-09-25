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
	// update users
	if ($system->SETTINGS['fee_max_debt'] < $_POST['fee_max_debt'])
	{
		$query = "UPDATE " . $DBPrefix . "users SET suspended = :s WHERE suspended = :sp AND balance > :f";
		$params = array();
		$params[] = array(':s', 0, 'int');
		$params[] = array(':sp', 7, 'int');
		$params[] = array(':f', $_POST['fee_max_debt'], 'int');
		$db->query($query, $params);
	}
	// Update database
	$system->writesetting("settings", "fees", $_POST['fees'], 'bool');
	$system->writesetting("settings", "fee_type", $_POST['fee_type'], 'bool_int');
	$system->writesetting("settings", "fee_max_debt", $system->print_money_nosymbol($_POST['fee_max_debt']), 'float');
	$system->writesetting("settings", "fee_signup_bonus", $system->print_money_nosymbol($_POST['fee_signup_bonus']), 'float');
	$system->writesetting("settings", "fee_disable_acc", $_POST['fee_disable_acc'], 'bool');
	$ERROR = $MSG['761'];
}

loadblock($MSG['395'], $MSG['397'], 'yesno', 'fees', $system->SETTINGS['fees'], array($MSG['3500_1015638'], $MSG['3500_1015637']));
loadblock($MSG['729'], $MSG['730'], 'batchstacked', 'fee_type', $system->SETTINGS['fee_type'], array($MSG['731'], $MSG['732']));

loadblock($MSG['733'], '', '', '', '', array(), true);
loadblock($MSG['734'], $MSG['735'], 'decimals', 'fee_max_debt', $system->SETTINGS['fee_max_debt']);
loadblock($MSG['736'], $MSG['737'], 'decimals', 'fee_signup_bonus', $system->SETTINGS['fee_signup_bonus']);
loadblock($MSG['738'], $MSG['739'], 'yesno', 'fee_disable_acc', $system->SETTINGS['fee_disable_acc'], array($MSG['030'], $MSG['029']));

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'SITEURL' => $system->SETTINGS['siteurl'],
	'TYPENAME' => $MSG['25_0012'],
	'PAGENAME' => $MSG['395'],
	'B_TITLES' => true,
	'PAGETITLE' => $MSG['395']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';