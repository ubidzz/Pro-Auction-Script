<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['148'],
	'PAGETITLE' => $MSG['148']
));

include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'help.tpl'
		));
$template->display('body');
include 'adminFooter.php';
