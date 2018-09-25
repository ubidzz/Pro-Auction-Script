<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';

if(isset($_SESSION['admincsrftoken']))
{
	checkAdminAuth();
}
else
{
	header("location: login.php");
	exit;
}

if (checkAdminLoginSession())
{
	header("location: login.php");
	exit;
}

include PLUGIN_PATH . '/htmLawed/htmLawed.php';
include PLUGIN_PATH . 'ckeditor/ckeditor.php';
include PLUGIN_PATH . 'api/api.php';
$api = new api();
	
//Deleteing the admin note
if (isset($_POST['act']) && $_POST['act'] == $MSG['008'])
{
	if ((isset($_POST['submitdata'])) && $_POST['submitdata'] == 'data')
	{
		deleteAdminNote($security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_IN']));
	}
}
	
//Add a new admin note
if (isset($_POST['act']) && $_POST['act'] == $MSG['007'])
{
	if ((isset($_POST['submitdata'])) && $_POST['submitdata'] == 'data')
	{
		if (isset($_POST['anotes']) && !empty($_POST['anotes']))
		{
			addAdminNote($security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_IN']), $_POST['anotes']);
		}
	}
}
$CKEditor = new CKEditor();
$CKEditor->basePath = $system->SETTINGS['siteurl'] . 'includes/plugins/ckeditor/';
$CKEditor->returnOutput = true;
$CKEditor->config['width'] = '100%';
$CKEditor->config['height'] = 200;
	