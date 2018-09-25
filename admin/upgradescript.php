<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include PLUGIN_PATH . 'ScriptUpdater/functions_upgrade.php';
$ERROR = isset($_SESSION['ERROR']) ? $_SESSION['ERROR'] : '';

$display_upgrade_message = isset($_SESSION['upgrade_message']) ? $_SESSION['upgrade_message'] : 1;
$upgrade_window = false;
$upgrade = new upgrade();
$upgrading = new upgrading();
//unset($_SESSION['upgrade_message']);

//checking to see if the upgrade button was clicked and now start upgrading the Pro-Auction-Script script
if(isset($_POST['action']) && $_POST['action'] == 'start_upgrading' && is_array($_POST['folders']) && is_array($_POST['pages']))
{			
	//making new sessions or editing them because the page has to be reloaded after the upgrade is finished
	$ERROR = $upgrading->start_upgrading($_POST['folders'],$_POST['pages']);
	$_SESSION['new_version'] = $system->SETTINGS['version'];
	$display_upgrade_message = 1;
	unset($_SESSION['upgrade_message']);
}
//checking to see if the download button was clicked and now download and unzip the upgrade file
elseif(isset($_POST['action']) && $_POST['action'] == 'upgrading' && isset($_POST['path']) && isset($_POST['required_version']) && isset($_POST['new_version']))
{			
	$ERROR = $upgrading->download_upgrade($_POST['path'],$_POST['required_version']);
	$_SESSION['new_version'] = $_POST['new_version'];
	$display_upgrade_message = 2;
}
elseif(isset($_POST['action']) && $_POST['action'] == 'apikey' && $_POST['api_key'] !='')
{
	$system->writesetting("settings", "upgradeAPIkey", $_POST['api_key'], 'str');
}

//in case the admin didn't upgrade but did download the upgrade file. 
//We want this PLUGIN_PATH . 'ScriptUpdater/upgrade/ folder empty if the $display_upgrade_message is set to 1
if($display_upgrade_message == 1 && is_dir(PLUGIN_PATH . 'ScriptUpdater/upgrade/'))
{
	$upgrading->deleteTemp(PLUGIN_PATH . 'ScriptUpdater/upgrade', 0);
}

switch ($display_upgrade_message) 
{
	case 1://display the new version list
		//get the list of the upgrade versions
		$apiUpgrade = $upgrade->upgradeCheck(1);
		if ($apiUpgrade['check'] == 'passed')
		{
			$upgrade_list_xml = simplexml_load_file($apiUpgrade['file']);
			$upgrade = false;
			foreach($upgrade_list_xml->upgrade as $child)
			{
				$old_version = $upgrading->simplexml_to_array($child);
				if (isset($child) && is_array($old_version))
				{
				    $old_versions = $old_version['old_version'];
				}
				
				//only diplaying the versions that are higher then the current version that is installed
				if($old_versions == $system->SETTINGS['version']) 
				{
					$upgrade = true;
				    $new_version = $upgrading->simplexml_to_array($child->new_version);
				    if (isset($child->new_version) && is_array($new_version))
				    {
						$new_versions = $new_version['new_version'];
					}
					$title = $upgrading->simplexml_to_array($child->title);
					if (isset($child->title) && is_array($title))
					{
					    $upgrade_title = $title['title'];
					}
					$path = $upgrading->simplexml_to_array($child->link);
					if (isset($child->link) && is_array($path))
					{
						$upgrade_path = $path['link'];
					}
					$upgrade_window = true;
					$template->assign_block_vars('upgrade_list', array(
						'TITLE' => $upgrade_title,
						'OLD_VERSION' => $old_versions,
						'NEW_VERSION' => $new_versions,
						'PATH' => $upgrade_path,
						'INSTALLED_VERSION' => $system->SETTINGS['version'],
						'HIDE_BUTTON' => true,
						'PAGE_NAME' => sprintf($MSG['3500_1015696'], $new_versions)
					));
				}
			}
			if(!$upgrade)
			{
				$template->assign_block_vars('upgrade_list', array(
					'TITLE' => $MSG['3500_1015695'],
					'OLD_VERSION' => $system->SETTINGS['version'],
					'NEW_VERSION' => $system->SETTINGS['version'],
					'PATH' => '',
					'INSTALLED_VERSION' => $system->SETTINGS['version'],
					'HIDE_BUTTON' => false,
					'PAGE_NAME' => $MSG['3500_1015694']
				));
			}
		}else{
			$ERROR = $MSG['3500_1016030'];
		}
	break;
	//downloaded the new version and now getting the xml page from the
	//Pro-Auction-Script website and display what page will be replaced and in what directories.
	case 2:	//This will also be used to move the pages to their correct directories.
		$apiUpgrade = $upgrade->upgradeCheck(2, $_SESSION['new_version']); 
		if($apiUpgrade['check'] == 'passed')
		{
			$upgrade_xml = simplexml_load_file($apiUpgrade['file']);

			//displaying the upgrade info
			foreach($upgrade_xml->upgrade->upgrade_info as $child)
			{
				$old_version = $upgrading->simplexml_to_array($child->old_version);
				if (isset($child) && is_array($old_version))
				{
				    $old_versions = $old_version['old_version'];
				}
				$new_version = $upgrading->simplexml_to_array($child->new_version);
				if (isset($child->new_version) && is_array($new_version))
				{
					$new_versions = $new_version['new_version'];
				}
				$title = $upgrading->simplexml_to_array($child->title);
				if (isset($child->title) && is_array($title))
				{
				    $upgrade_title = $title['title'];
				}
				$description = $upgrading->simplexml_to_array($child->description);
				if (isset($child->description) && is_array($description))
				{
				    $upgrade_description = $description['description'];
				}
				$script_bitbucket = $upgrading->simplexml_to_array($child->bitbucket->script);
				if (isset($child->bitbucket->script) && is_array($script_bitbucket))
				{
				    $bitbucket_script = $script_bitbucket['script'];
				}
				$language_bitbucket = $upgrading->simplexml_to_array($child->bitbucket->language);
				if (isset($child->bitbucket->language) && is_array($language_bitbucket))
				{
				    $bitbucket_language = $language_bitbucket['language'];
				}
				$help_forums = $upgrading->simplexml_to_array($child->help);
				if (isset($child->help) && is_array($help_forums))
				{
				    $support = $help_forums['help'];
				}
				$extra = $upgrading->simplexml_to_array($child->extra_details);
				if (isset($child->extra_details) && is_array($extra))
				{
				    $extra_details = $extra['extra_details'];
				}
							
				$template->assign_block_vars('upgrade_info', array(
					'TITLE' => $upgrade_title,
					'OLD_VERSION' => $old_versions,
					'NEW_VERSION' => $new_versions,
					'INSTALLED_VERSION' => $system->SETTINGS['version'],
					'DEC' => $upgrade_description,
					'SCRIPT_BITBUCKET' => $bitbucket_script,
					'LANGUAGE_BITBUCKET' => $bitbucket_language,
					'HELP' => $support,
					'EXTRAS' => $extra_details,
				));
			}
			
			//displaying the list of new pages
			foreach ($upgrade_xml->upgrade->upgrade_pages as $child)
			{
				//getting the file path for the pages
				$dir = $upgrading->simplexml_to_array($child->dir);
				if (isset($child) && is_array($dir))
				{
				    $temp_dir = $dir['dir'];
				}
				$template->assign_block_vars('upgrade_dir', array(
					'FOLDER' => $temp_dir
				));
				//loop each page
				foreach($child->page as $page_child)
				{
					$template->assign_block_vars('upgrade_dir.upgrade_pages', array(
						'PAGE' => $page_child
					));
				}
			}
		}else{
			$ERROR = $MSG['3500_1016030'];		
		}					
	break;
}

$template->assign_vars(array(
	'PAGE' => $display_upgrade_message == 2 ? true : false,
	'APIKEY' => $system->SETTINGS['upgradeAPIkey'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['3500_1015859'],
	'PAGETITLE' => $MSG['3500_1015859']
));

if(isset($_SESSION['ERROR']) && $_SESSION['ERROR'] !='') unset($_SESSION['ERROR']);

include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'upgradescript.tpl'
		));
$template->display('body');
include 'adminFooter.php';