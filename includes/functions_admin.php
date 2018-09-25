<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
if (!defined('InProAuctionScript')) exit('Access denied');

if (!defined('AdminFuncCall'))
{
	function checkAdminLoginSession()
	{
		global $_SESSION, $system, $DBPrefix, $db, $security;

		if (isset($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_NUMBER']) && isset($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_IN']) && isset($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_PASS']))
		{
			$query = "SELECT hash, password FROM " . $DBPrefix . "adminusers WHERE password = :pass_id AND id = :admin_id";
			$params = array();
			$params[] = array(':pass_id', $security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_PASS']), 'str');
			$params[] = array(':admin_id', $security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_IN']), 'int');
			$db->query($query, $params);

			if ($db->numrows() == 1)
			{
				$user_data = $db->result();

				if (strspn($user_data['password'], $user_data['hash']) == $security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_NUMBER']))
				{
					return false;
				}
			}
		}
		return true;
	}
	
	function checkAdminAuth()
	{
		global $security, $_SESSION, $_POST, $_GET;
		$valid_req = false;
		# Token should exist as soon as a user is logged in
		if($_SERVER["REQUEST_METHOD"] == 'POST' || $_SERVER["REQUEST_METHOD"] == 'GET')
		{
			if(1 < count($_POST))		# More than 2 parameters in a POST (csrftoken + 1 more) => check
			{
				if($security->decrypt($_POST['admincsrftoken']) == $security->decrypt($_SESSION['admincsrftoken']))  # Checking if the POST and SESSION Tokens match
				{
					$valid_req = false;   # POST and SESSION Tokens match so pass
				}
				else
				{
					$valid_req = true;  # POST and SESSION Tokens don't match so fail
				}
			}
		}
		if($valid_req) 
		{ 
			global $MSG, $ERR; 
			$_SESSION['msg_title'] = $MSG['936']; 
			$_SESSION['msg_body'] = $ERR['077']; 
			header('location: message.php');
			exit; // kill the page 
		}
	}
	function getAdminNotes()
	{
		global $_SESSION, $system, $DBPrefix, $db, $security;
		if (isset($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_IN']) && isset($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_PASS']))
		{
			$query = "SELECT notes FROM " . $DBPrefix . "adminusers WHERE password = :admin_passw AND id = :admin_ids";
			$params = array();
			$params[] = array(':admin_passw', $security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_PASS']), 'str');
			$params[] = array(':admin_ids', $security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_IN']), 'int');
			$db->query($query, $params);
			$get_notes = $db->result('notes');
			if ($db->numrows() > 0)
			{	
				return $get_notes;
			}
		}
		return '';
	}

	function loadblock($title = '', $description = '', $type = '', $name = '', $default = '', $tagline = array(), $header = false)
	{
		global $template;

		$template->assign_block_vars('block', array(
				'TITLE' => $title,
				'DESCRIPTION' => (!empty($description)) ? $description . '<br>' : '',
				'TYPE' => $type,
				'NAME' => $name,
				'DEFAULT' => $default,
				'TAGLINE1' => (isset($tagline[0])) ? $tagline[0] : '',
				'TAGLINE2' => (isset($tagline[1])) ? $tagline[1] : '',
				'TAGLINE3' => (isset($tagline[2])) ? $tagline[2] : '',
				'TAGLINE4' => (isset($tagline[3])) ? $tagline[3] : '',
				'TAGLINE5' => (isset($tagline[3])) ? $tagline[4] : '',
				'TAGLINE6' => (isset($tagline[3])) ? $tagline[5] : '',
				'TAGLINE7' => (isset($tagline[3])) ? $tagline[6] : '',
				'TAGLINE8' => (isset($tagline[3])) ? $tagline[7] : '',
				'TAGLINE9' => (isset($tagline[3])) ? $tagline[8] : '',
				'TAGLINE10' => (isset($tagline[3])) ? $tagline[9] : '',
				'B_HEADER' => $header
				));
	}
	
	// Display Date/Time
	function last_login($admin_time)
	{
		global $system, $MSG;
	
		$mth = 'MON_0' . date($MSG['ta_m2'], $admin_time);
		if($system->SETTINGS['datesformat'] == 'EUR')
		{
			$date =  date($MSG['ta_j'], $admin_time) . ' ' . $MSG[$mth] . ' ' . date($MSG['ta_Y'], $admin_time);
		}
		else
		{
			$date = $MSG[$mth] . ' ' . date($MSG['ta_j'] . ',' . $MSG['ta_Y'], $admin_time);
		}
		$time = $date . ' <span id="servertime">' . date($MSG['ta_His'], $admin_time) . '</span>';
		
		return $time;
	}
	
	//Change the admin folder name
	function cheange_admin_folder($new_folder, $stored_admin_folder)
	{
		global $system, $MSG, $DBPrefix, $db;
		
		//Changing the admin folder name
		$new_admin_folder = MAIN_PATH . $new_folder; 
		rename($stored_admin_folder, $new_admin_folder);
			
		//Updating the robots.txt file this helps prevent crawling 
		$replacing = str_replace('/' . $system->SETTINGS['admin_folder'] . '/', '/' . $new_folder . '/', file_get_contents('../robots.txt')); 
		file_put_contents('../robots.txt', $replacing); //edit the file
					
		//Updating the admin_folder column in the database
		$system->writesetting("settings", "admin_folder", $new_folder, 'str');
			
		$_SESSION['EROR'] = $MSG['30_0231'];
		$link = $system->SETTINGS['siteurl'] . $new_folder . '/security.php';
		return header('location: ' . $link);
		exit();
	}
	
	//Delete the admin note
	function deleteAdminNote($admin_id)
	{
		global $system, $DBPrefix, $db;
	
		$query = "UPDATE " . $DBPrefix . "adminusers SET notes = NULL WHERE id = :admin_id";
		$params = array();
		$params[] = array(':admin_id', $admin_id, 'int');
		$db->query($query, $params);
	}
	
	//add a admin note
	function addAdminNote($admin_id,$note)
	{
		global $system, $DBPrefix, $db;
		
		$query = "UPDATE " . $DBPrefix . "adminusers SET notes = :setnote WHERE id = :admin_id";
		$params = array();
		$params[] = array(':setnote', stripslashes($system->cleanvars($note)), 'str');
		$params[] = array(':admin_id', $admin_id, 'int');
		$db->query($query, $params);
	}
	
	function clearCache()
	{
		if (is_dir(MAIN_PATH . 'cache'))
		{
			$dir = opendir(MAIN_PATH . 'cache');
			while (($myfile = readdir($dir)) !== false)
			{
				if ($myfile != '.' && $myfile != '..' && $myfile != 'index.php')
				{
					unlink(MAIN_PATH . 'cache/' . $myfile);
				}
			}
			closedir($dir);
		}
		//deleting the images cache files
		if ($imageDIR = opendir(UPLOAD_PATH . 'cache'))
		{
			while (($file = readdir($imageDIR)) !== false)
			{
				if ($file != 'purge' && !is_dir(UPLOAD_PATH . 'cache/' . $file))
				{
					unlink(UPLOAD_PATH . 'cache/' . $file);
				}
			}
			closedir($imageDIR);
		}
		touch(UPLOAD_PATH . 'cache/purge');
	}
	function checkReportedListing()
	{
		global $DBPrefix, $db, $MSG;
		// inform admin there has been a reported listing since last login 
		$query = "SELECT report_date FROM " . $DBPrefix . "report_listing 
		WHERE report_closed = 0 ORDER BY report_date desc limit 1" ; 
		$db->direct_query($query);
		while ($report = $db->result('report_date')) 
		{ 
			$last_report = $report; 
		} 
		if (isset($last_report)) 
		{ 
		    $warning_report = 1; 
		    $warningmsg = $MSG['3500_1015850'];
		}else{ 
			//preventing php error
		     $warning_report = 0;  
			 $warningmsg = '';  
		} 
		return array('warning' => $warningmsg, 'reports' => $warning_report);
	}

	function checkSupportTickets()
	{
		global $DBPrefix, $db, $MSG;
		//check to see if there is any new support tickets
		$query = "SELECT id FROM " . $DBPrefix . "support 
			WHERE ticket_reply_status = :reply_status AND status =:ticket_status";
		$params = array();
		$params[] = array(':reply_status', 'support', 'bool');
		$params[] = array(':ticket_status', 'open', 'bool');
		$db->query($query, $params);
		if ($db->numrows('id') > 0)
		{
			$supports = $MSG['3500_1015439q'];
			$support_report = 1;
		}else{
			//preventing php error
			$supports = '';
			$support_report = 0;
		}
		return array('supports' => $supports, 'reports' => $support_report);
	}
	function updateUpgradeSystemPage($zipFile)
	{
		$tempDir = PLUGIN_PATH . 'ScriptUpdater/pageUpdate'; // temp folder path
		if (is_dir($tempDir) == false) mkdir($tempDir, 0755);
		$dirPermissions = ubstr(sprintf('%o', fileperms($tempDir)), -4); // get the temp folder permissions
		if($dirPermissions !=0755)
		{
			chmod($tempDir, 0755);
		}
		//unzip the file and store it in a temp folder
		$zip = new ZipArchive();
		if ($zip->open(DOWNLOAD_PATH . $filename) === TRUE) //unpack the zip file
		{
			$zip->extractTo(UNPACKED_PATH);
			$zip->close();
			return $this->message['3500_1015708'];
		} 
		else //the zip was not unpacked
		{
			return $this->message['3500_1015707'];
		}

		
	}
	define('AdminFuncCall', 1);
}
?>