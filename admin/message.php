<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
$current_page = $MSG['415'];

if (isset($_SESSION['msg_title']) && isset($_SESSION['msg_body']))
{
	$title = $_SESSION['msg_title'];
	$body = $_SESSION['msg_body'];
}
$template->assign_vars(array(
	'TITLE_MESSAGE' => $title,
	'BODY_MESSAGE' => $body,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['415'],
	'PAGETITLE' => $MSG['415']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'message.tpl'
		));
$template->display('body');
include 'adminFooter.php';