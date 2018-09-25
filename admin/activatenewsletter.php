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
	$system->writesetting("settings", "newsletter", $_POST['newsletter'], 'int');
	$ERROR = $MSG['30_0049'];
}

loadblock($MSG['603'], $MSG['604'], 'batch', 'newsletter', $system->SETTINGS['newsletter'], array($MSG['030'], $MSG['029']));

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0010'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['25_0079'],
	'PAGETITLE' => $MSG['25_0079']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';