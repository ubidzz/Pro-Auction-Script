<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include CONFIG_PATH . 'class_language_functions.php';
$langClass = new language();

if(isset($_POST['action']) && $_POST['action'] == 'newlanguage')
{
	$ERROR = $langClass->buildFile(1);
}elseif(isset($_POST['action']) && $_POST['action'] == 'uploadFlag')
{
	$ERROR = $langClass->uploadFlag();			
}

if ($dir = opendir(LANGUAGE_PATH . 'flags'))
{
	while (($flag = readdir($dir)) !== false)
	{
		$extension = substr($flag, strrpos($flag, '.') + 1);
		if (in_array($extension, array('gif')))
		{
			$template->assign_block_vars('flags', array(
				'FLAG' => $flag
			));
		}
	}
}
closedir($dir);

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
));

include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'newlanguage.tpl'
		));
$template->display('body');
include 'adminFooter.php';