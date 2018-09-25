<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include INCLUDE_PATH . 'functions_mods.php';
$current_page = 'AutoMod tool';

//display the downloaded mods or install mods info
if ($install_files)
{
	$title = 'Install a New Mod';
	$mod_buttons = 'Install Mod';
	foreach($xml->edit as $child)
	{
	    $page = $xml_array->simplexml_to_array($child);
	    if (isset($child) && is_array($page))
	    {
	    	$pages = $page[open];
	    }
	    $find = $xml_array->simplexml_to_array($child->find);
	    if (isset($child->find) && is_array($find))
	    {
	    	$finding = $find[find];
	    }
	    $replace = $xml_array->simplexml_to_array($child->replace);
	    if (isset($child->replace) && is_array($replace))
	    {
	    	$replacing = $replace[replace];
	    	$replaceWith = $replacing;
	    }
	    else
	    {
	    	$replacing = ' ';
	    	$replaceWith = $replacing;
	    }
	    $page_folder = $xml_array->simplexml_to_array($child->directory_path);
	    if (isset($child->directory_path) && is_array($page_folder))
	    {
	    	$path = $page_folder[directory_path];
	    	$get_path = MAIN_PATH . $path;
			$get_both = $get_path . $pages;
		}
		else
		{
			$get_path = MAIN_PATH;
			$get_both = $get_path . $pages;
		}
	   	$get_page = $pages;
	   	$mod_name = (string) $xml->mod;
	   	$mod_version = (string) $xml->version;
		
		$contents = htmlentities(file_get_contents($get_both));
		$template->assign_block_vars('mod', array(
			'MAKER' => $xml->author,
			'MOD' => $xml->mod,
			'VERSION' => $xml->version,
			'PAGE' => $pages,
			'FOLDER' => $path,
			'FIND' => $finding,
			'REPLACE' => $replacing,
			'ADDAFTER' => $add_after,
			'ADDBEFORE' => $add_before,
		));
	if ($_POST['update'] == 'yes')
	{
			$change->changefile($get_path, $get_page, $finding, $replaceWith, $mod_name, $mod_version, $path);
	}
	//unseting all the arrays
	unset($pages);
	unset($finding);
	unset($replacing); 
	unset($path);
	} 
}

$template->assign_vars(array(
	'FORM_2' => 'automod.php',
	'PAGE_TITLE' => $title,
	'BUTTON_TITLE' => $mod_buttons,
	'B_CHANGE' => true,
	'ERROR' => (isset($ERR)) ? $ERR : '',
	'PAGENAME' => isset($current_page) ? $current_page : '',
	'PAGETITLE' => $current_page
));
		
$ERROR = $GLOBALS['ERR'];	
include 'adminHeader.php';	
$template->set_filenames(array(
		'body' => 'automod.tpl'
		));
$template->display('body');
include 'adminFooter.php';