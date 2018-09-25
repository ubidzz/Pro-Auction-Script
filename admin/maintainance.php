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
	// Check if the specified user exists
	$superuser = $system->cleanvars($_POST['superuser']);
	$query = "SELECT id FROM " . $DBPrefix . "users WHERE nick = :n";
	$params = array();
	$params[] = array(':n', $superuser, 'int');
	$db->query($query, $params);
	if ($db->numrows() == 0 && $_POST['active'] == 'y')
	{
		$ERROR = $ERR['025'];
	}
	else
	{
		// clean up everything
		$conf = array();
		$conf['safe'] = $system->SETTINGS['htmLawed_safe'];
		$conf['deny_attribute'] = $system->SETTINGS['htmLawed_deny_attribute'];
		$text = htmLawed($_POST['maintainancetext'], $conf);

		// Update database
		$system->writesetting("maintainance", "active", $_POST['active'], 'bool');
		$system->writesetting("maintainance", "superuser", $superuser, 'str');
		$system->writesetting("maintainance", "maintainancetext", $text, 'str');
		$ERROR = $MSG['_0005'];
	}
}
else
{
	$data = $system->loadTable('maintainance');
	$system->SETTINGS['superuser'] = $data['superuser'];
	$system->SETTINGS['maintainancetext'] = $data['maintainancetext'];		
	$system->SETTINGS['active'] = $data['active'];
}

loadblock('', $MSG['_0002']);
loadblock($MSG['_0006'], '', 'yesno', 'active', $system->SETTINGS['active'], array($MSG['030'], $MSG['029']));
loadblock($MSG['003'], '', 'text', 'superuser', $system->SETTINGS['superuser'], array($MSG['030'], $MSG['029']));
loadblock($MSG['_0004'], '', $CKEditor->editor('maintainancetext', stripslashes($system->SETTINGS['maintainancetext'])));

$template->assign_vars(array(
	'TYPENAME' => $MSG['5436'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['_0001'],
	'PAGETITLE' => $MSG['_0001']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';