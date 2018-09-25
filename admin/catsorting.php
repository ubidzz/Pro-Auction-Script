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
	$system->writesetting("settings", "catsorting", $_POST['catsorting'], 'str');
	$system->writesetting("settings", "catstoshow", $_POST['catstoshow'], 'int');
	$ERROR = $MSG['25_0150'];
}

loadblock('', $MSG['25_0147'], 'sortstacked', 'catsorting', $system->SETTINGS['catsorting'], array($MSG['25_0148'], $MSG['25_0149']));
loadblock($MSG['30_0030'], $MSG['30_0029'], 'percent', 'catstoshow', $system->SETTINGS['catstoshow']);

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0008'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a style="color:lime" href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_categories_sorting" target="_blank">' . $MSG['25_0146'] . '</a>',
	'PAGETITLE' => $MSG['25_0146']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';