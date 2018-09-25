<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include INCLUDE_PATH . 'functions_mods.php';
$current_page = 'AutoMod Tool';

//display all mods that can be downloaded
	$title = 'Download a New Mod';
	$mod_buttons = 'Download Mod';
	foreach($new_mods_xml->check_mods->mods as $child)
	{
		$mod = $xml_array->simplexml_to_array($child->mod);
	    if (isset($child) && is_array($mod))
	    {
	    	$new_mod = $mod[mod];
	    }
	    $author = $xml_array->simplexml_to_array($child->author);
	    if (isset($child) && is_array($author))
	    {
	    	$mod_author = $author[author];
	    }
	    $version = $xml_array->simplexml_to_array($child->version);
	    if (isset($child) && is_array($version))
	    {
	    	$mod_version = $version[version];
	    }
	    $info = $xml_array->simplexml_to_array($child->info);
	    if (isset($child) && is_array($info))
	    {
	    	$mod_info = $info[info];
	    }
	    $link = $xml_array->simplexml_to_array($child->link);
	    if (isset($child) && is_array($link))
	    {
	    	$mod_folder = $link[link];
	    }
	    $query = "SELECT * FROM " . $DBPrefix . "mods WHERE mod_name = :name AND mod_version = :version";
		$params = array();
		$params[] = array(':name', $new_mod, 'str');
		$params[] = array(':version', $mod_version, 'str');
		$db->query($query, $params);
		$installed_mod = $db->result();
		
		$template->assign_block_vars('new_mods', array(
			'MAKER' => '<b>Author:</b> ' . $mod_author,
			'MOD' => '<b>Mod:</b> ' . $new_mod,
			'VERSION' => '<b>Version:</b> ' . $mod_version,
			'B_CHECKED' => ($installed_mod['mod_name'] == $new_mod && $installed_mod['downloaded'] == 'y'),
			'INFO' => '<b>Details:</b><br> ' . $mod_info,
			'DOWNLOAD' => $new_mod
		));
	}
	if ($_POST['download_mod'] == 'yes' && $_POST['download_this_mod'] == $new_mod)
	{
			download_mod($mod_folder, $new_mod, $mod_version);
	}
	//unseting all the arrays
	unset($new_mod);
	unset($mod_version);
	unset($mod_info); 
	unset($mod_folder);
	unset($mod_author);


$ERROR = $GLOBALS['ERR'];
$template->assign_vars(array(
	'PAGE_TITLE' => $title,
	'BUTTON_TITLE' => $mod_buttons,
	'FORM_2' => 'new_mods.php',
	'B_CHANGE' => true,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => isset($current_page) ? $current_page : ''
	'PAGETITLE' => isset($current_page) ? $current_page : ''
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'new_mods.tpl'
		));
$template->display('body');
include 'adminFooter.php';