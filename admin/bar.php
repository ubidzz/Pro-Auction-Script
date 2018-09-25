<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

$template->assign_vars(array(
	'B_ADMINLOGIN' => (!checklogin()),
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminbar.tpl'
		));
$template->display('body');
include 'adminFooter.php';