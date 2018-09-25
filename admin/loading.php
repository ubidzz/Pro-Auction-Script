<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include PLUGIN_PATH . 'ScriptUpdater/functions_upgrade_page.php';
$updatePage = new upgradePage();

if(isset($_POST['action']) && $_POST['action'] == 'UpdatePage') //update the u-Auction upgrade page
{
	if($_POST['version'] == $system->SETTINGS['version'])
	{
		$_SESSION['ERROR'] = $updatePage->downloadFile($_POST['version']);
		header("location: upgradescript.php");
		exit;
	}else{
		$ERROR = $ERR['082'];
	}
}

$versionList = $updatePage->getVersionList();
$op = '';
if($versionList['check'] == 'passed')
{
	$cleanList = array_filter(explode(',', base64_decode($versionList['versions'])));
	foreach($cleanList as $k => $v)
	{
		$op .= '<option value="' . str_replace(' ', '_', $v) . '">' . $v . '</option>';
	}
}else{
	$ERROR = $MSG['3500_1015995'];
}

$template->assign_vars(array(
	'VERSIONS' => $op,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['3500_1015693'],
	'PAGETITLE' => $MSG['3500_1015693']
));


include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'loading.tpl'
		));
$template->display('body');
include 'adminFooter.php';