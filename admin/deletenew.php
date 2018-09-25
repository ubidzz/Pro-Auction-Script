<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'header.php';

if (isset($_POST['action']) && $_POST['action'] == $MSG['030'])
{
	$query = "DELETE FROM " . $DBPrefix . "news WHERE id = :i";
	$params = array();
	$params[] = array(':i', intval($_POST['id']), 'int');
	$db->query($query, $params);

	header('location: news.php');
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029'])
{
	header('location: news.php');
	exit;
}

$query = "SELECT title FROM " . $DBPrefix . "news WHERE id = :i";
$params = array();
$params[] = array(':i', intval($_GET['id']), 'int');
$db->query($query, $params);
$title = $db->result('title');

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'ID' => $_GET['id'],
	'MESSAGE' => sprintf($MSG['832'], $title),
	'PAGENAME' => $MSG['5276'],
	'TYPE' => 1,
	'PAGETITLE' => $MSG['5276']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'confirm.tpl'
		));
$template->display('body');
include 'adminFooter.php';