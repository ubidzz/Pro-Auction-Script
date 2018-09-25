<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');

//$_SESSION['mod_folder'] = (isset($_POST['mod'])) ? $_POST['mod'] : isset($_SESSION['mod_folder']) ? $_SESSION['mod_folder'] : '';

$downloaded_mods = (isset($_GET['mods']) && $_GET['mods'] == 'new_mod') ? true : false;
$install_files = (isset($_POST['do']) && isset($_SESSION['mod_folder']) && $_POST['do'] == 'install') ? true : false;
$mod_path = '../includes/plugins/mods/' . $_SESSION['mod_folder'] . '/install_mod.xml';

$new_mods_xml = simplexml_load_file('https://Pro-Auction-Script.com/mods/modlist.xml');
$xml = simplexml_load_file('https://Pro-Auction-Script.com/mods/modlist.xml');
$xml_array = new mod();
$change = new change();
$zip = new ZipArchive;
	
	//download a new mod and unpack it
	function download_mod($filename, $saved_name, $mod_version)
	{	
		global $zip, $system, $DBPrefix, $db;
		
		//dir paths
		$destination_folder = PLUGIN_PATH . 'mods/download/';
		$unpack_folder = PLUGIN_PATH . 'mods/download/' . $saved_name . '.zip';
		$save_unpack = PLUGIN_PATH . 'mods/';
		$newpath = $save_unpack . $saved_name;
		
	    $url = $filename;
	    $newfname = $destination_folder . basename($url);
	
	    $file = fopen ($url, "rb");
	    
	    $query = "SELECT mod_name FROM " . $DBPrefix . "mods WHERE mod_name = :name AND mod_version = :version";
		$params = array();
		$params[] = array(':name', $saved_name, 'str');
		$params[] = array(':version', $mod_version, 'str');
		$db->query($query, $params);
		if($db->numrows() == 0)
		{
		    if ($file) 
		    {
		      $newf = fopen ($newfname, "wb");
		
		      if ($newf)
		      while(!feof($file)) 
		      {
		        fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
		      }
		        if ($zip->open($unpack_folder) === TRUE) {
			   $zip->extractTo($save_unpack);
			   $zip->close();
			   $GLOBALS['ERR'] = 'The Mod was downloaded and Unpacked successfully';
				} else {
			   $GLOBALS['ERR'] = 'failed';
				}
		    }
		
		    if ($file) {
		      fclose($file);
		      header("location:" . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . "/mods.php");
		    }
		
		    if ($newf) {
		    $query = "INSERT INTO `" . $DBPrefix . "mods` VALUES (NULL, :mod_name, :mod_backup, :mod_version, :mod_downloaded, :mod_installed, :timed)";
				$params = array();
				$params[] = array(':mod_name', $saved_name, 'str');
				$params[] = array(':mod_backup', '', 'str');
				$params[] = array(':mod_version', $mod_version, 'str');
				$params[] = array(':mod_downloaded', 'y', 'str');
				$params[] = array(':mod_installed', 'n', 'str');
				$params[] = array(':timed', time(), 'int');
				$db->query($query, $params);
		
		      fclose($newf);
		      header("location:" . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . "/mods.php");
		    }
	    }
	}
	
	/// make a backup file before changing the files
	if (!function_exists('makebackup')) {
		function makebackup($full_page_dir, $page_name, $mod_name, $version, $path)
		{	
			global $db, $DBPrefix, $system;
			
			if (isset($path))
			{
				$dir = PLUGIN_PATH . 'mods/backup/' . $mod_name . '/';
				$backup_dir = PLUGIN_PATH . 'mods/backup/' . $mod_name . '/' . $path;
				if (!is_dir($dir)) mkdir($dir, 0755);
			}
			else
			{
				$backup_dir = PLUGIN_PATH . 'mods/backup/' . $mod_name . '/';
			}
			if (!is_dir($backup_dir)) mkdir($backup_dir, 0755);
			$backup = $backup_dir . $page_name;
			copy($full_page_dir, $backup);
			
			$query = "UPDATE " . $DBPrefix . "mods SET backup = :backup_dir, installed = :install WHERE mod_name = :name AND mod_version = :version";
			$params = array();
			$params[] = array(':backup_dir', $backup_dir, 'str');
			$params[] = array(':install', 'y', 'str');
			$params[] = array(':name', $mod_name, 'str');
			$params[] = array(':version', $version, 'str');
			$db->query($query, $params);
			
			header("location:" . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . "/mods.php");
		}
	}
	
	//change the file coding
	class change
	{
		function changefile($directory, $page, $search, $replace, $mod_name, $mod_version, $mod_path)
		{
			if ($dir = opendir($directory)) 
			{
			    while (($file = readdir($dir)) !== false) 
			    {
			        if ($file == $page) //check to see if the file is in the directory 
			        {
			        	chdir("$directory"); //to make sure you are always in right directory
			        	$page_dri = $directory . $page; //the file directory path
			        	$page_content = load_file_from_url($page_dri); //get the file content 
					    $replacing = str_replace($search, $replace, $page_content); //replace the code
					    makebackup($page_dri, $page, $mod_name, $mod_version, $mod_path); //run the makebackup function to make a backup file before changing it
						file_put_contents($page_dri, $replacing); //edit the file
						$GLOBALS['ERR'] = 'The Mod was added successfully'; //display message
			        }
			    }
		    	closedir($dir);
		 	}
		}
	} 
	//read the xml page
	class mod 
	{
		function simplexml_to_array($data) {
		    $a = array();
		    foreach ($data as $node) 
		    {
		        if (is_array($node))
		            unset($node);
		        else
		            $a[$node->getName()] = (string) $node;
		    }
		    return $a;
		} 
	}
	
	function delete_mod($dir)
	{
		if (is_dir($dir))
		{
     		$objects = scandir($dir);
     		foreach ($objects as $object) 
     		{
       			if ($object != "." && $object != "..") 
       			{
         			if (filetype($dir."/".$object) == "dir") rmdir($dir."/".$object); 
         			else unlink($dir."/".$object);
       			}
     		}
     	reset($objects);
     	rmdir($dir);
   		}
	}
	 
	function run_mod_backup($folder_name, $backup_path, $downloaded, $installed, $mod_version, $mod_name)
	{
		global MAIN_PATH, $system, $DBPrefix, $db;
		
		$mod_folder = PLUGIN_PATH . 'mods/' . $folder_name; 
		$backup_folder = $backup_path;
		
		$query = "SELECT * FROM " . $DBPrefix . "mods";
		$db->direct_query($query);
		$scaned_stored_mods = $db->result();
		$check_array = array();
		foreach ($scaned_stored_mods['install_time'] as $k)
		{
			$check_array[] = $k;
		}
			$check = max($check_array[2]);

		
		$query = "SELECT * FROM " . $DBPrefix . "mods WHERE mod_name = :name AND mod_version = :version";
		$params = array();
		$params[] = array(':name', $mod_name, 'str');
		$params[] = array(':version', $mod_version, 'str');
		$db->query($query, $params);
		$get_stored_mod = $db->result();	
   }
?>