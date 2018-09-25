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
	//checking to see if any posts are N and preset them
	if (empty($_POST['auctions']) && $_POST['auctions'] != 'y') $_POST['auctions'] = 'n';
	if (empty($_POST['online']) && $_POST['online'] != 'y') $_POST['online'] = 'n';
	if (empty($_POST['users_online']) && $_POST['users_online'] != 'y') $_POST['users_online'] = 'n';
	if (empty($_POST['cat_counters']) && $_POST['cat_counters'] != 'y') $_POST['cat_counters'] = 'n';
	
	//set the salts
	$auctions = $_POST['auctions'];
	$guest = $_POST['online'];
	$users_online = $_POST['users_online'];
	$cat = $_POST['cat_counters'];
	$sold = $_POST['counter_sold_items'];
	
	// Update database
	$system->writesetting("settings", "counter_auctions", $auctions, 'bool');
	$system->writesetting("settings", "counter_online", $guest, 'bool');
	$system->writesetting("settings", "counter_users_online", $users_online, 'bool');
	$system->writesetting("settings", "cat_counters", $cat, 'bool');
	$ERROR = $MSG['2__0063'];
}

loadblock($MSG['2__0062'], $MSG['2__0058']);
loadblock($MSG['2__0060'], '', 'checkbox', 'auctions', $system->SETTINGS['counter_auctions']);
loadblock($MSG['2__00642'], '', 'checkbox', 'online', $system->SETTINGS['counter_online']);
loadblock($MSG['2__100591'], '', 'checkbox', 'users_online', $system->SETTINGS['counter_users_online']);
loadblock($MSG['276'], '', 'checkbox', 'cat_counters', $system->SETTINGS['cat_counters']);

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0008'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_show_counters" target="_blank">' . $MSG['2__0057'] . '</a>',
	'PAGETITLE' => $MSG['2__0057']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';