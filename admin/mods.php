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

$title = 'Downloaded Mods';
$mod_root = PLUGIN_PATH . 'mods/'; //theres no point repeatedly defining this
$mod_buttons = 'Install Mod';
if ($dir = @opendir($mod_root))
{
	while (($amods = readdir($dir)) !== false)
	{
		if ($amods == 'backup')
		{
		}
		elseif ($amods == 'download')
		{
		}
		else{
			if(file_exists($mod_root . $amods . '/install_mod.xml'))
			{
				$xmlpath = $mod_root . $amods . '/install_mod.xml';
				$xml = simplexml_load_file($xmlpath);
				$info = '<b>Details:</b><br> ' . $xml->info;
				$version = '<b>Version:</b> ' . $xml->version;
				$mod = '<b>Mod:</b> ' . $xml->mod;
				$author = '<b>Author:</b> ' . $xml->author;
			}
		}
		
		$mod_path = $mod_root . $amods;
		$list_files = (isset($_GET['do']) && isset($_GET['mod']) && $_GET['do'] == 'listfiles' && $_GET['mod'] == $amods);
		
		$query = "SELECT * FROM " . $DBPrefix . "mods WHERE mod_name = :mod"; 
		$params = array();
		$params[] = array(':mod', $amods, 'int');
		$db->query($query, $params);
		$installed_mod = $db->result();
		
		if ($_POST['delete_mod'] == 'yes' && $_POST['mod'] == $amods)
		{
			run_mod_backup($amods, $installed_mod['backup'], $installed_mod['downloaded'], $installed_mod['installed'], $installed_mod['mod_version'], $installed_mod['mod_name']);
		}
		
		if ($amods != 'CVS' && is_dir($mod_path) && substr($amods, 0, 1) != '.')
		{
			$template->assign_block_vars('mods', array(
					'NAME' => $MSG['3500_1015456'] . $amods,
					'MOD_NAME' => $amods,
					'B_CHECKED' => ($installed_mod['mod_name'] == $amods && $installed_mod['installed'] == 'y'),
					'DESCRIPTION' => $info,
					'VERSION' => $version,
					'MOD' => $mod,
					'AUTHOR' => (isset($author)) ? $author : '',
					'B_INSTALLED' => ($installed_mod['mod_name'] == $amods),
					'B_LISTFILES' => $list_files,
					'B_NOTINSTALLED' => ($amods == $installed_mod['mod_name'] && $installed_mod['installed'] == 'n'),
					'B_NOTBACKUPFOLDER' => ($amods != 'backup'),
					'B_NOTDOWNLOADFOLDER' => ($amods != 'download'),
					));
		}
	}
	@closedir($dir);
	unset($info);
	unset($version);
	unset($mod); 
	unset($author);
}
$ERROR = $GLOBALS['ERR'];
$template->assign_vars(array(
	'PAGE_TITLE' => $title,
	'BUTTON_TITLE' => $mod_buttons,
	'FORM' => 'automod.php',
	'PAGENAME' => $MSG['3500_1015451'],
	'FORM_2' => 'mods.php',
	'FORM_3' => 'mods.php',
	'B_CHANGE' => true,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => isset($current_page) ? $current_page : '',
	'PAGETITLE' => isset($current_page) ? $current_page : ''
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'mods.tpl'
		));
$template->display('body');
include 'adminFooter.php';