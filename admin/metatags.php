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
	$system->writesetting("settings", "descriptiontag", $system->cleanvars($_POST['descriptiontag']), 'str');
	$system->writesetting("settings", "keywordstag", $system->cleanvars($_POST['keywordstag']), 'str');
	$ERROR = $MSG['25_0185'];
}

loadblock($MSG['25_0180'], $MSG['25_0182'], 'textarea', 'descriptiontag', $system->SETTINGS['descriptiontag']);
loadblock($MSG['25_0181'], $MSG['25_0184'], 'textarea', 'keywordstag', $system->SETTINGS['keywordstag']);

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0008'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_meta_tags" target="_blank">' . $MSG['25_0178'] . '</a>',
	'PAGETITLE' => $MSG['25_0178']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';