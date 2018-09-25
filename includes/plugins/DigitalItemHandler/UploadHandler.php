<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');
define('UPLOAD_TMP_PATH', MAIN_PATH . UPLOAD_FOLDER. 'temps/' . session_id());
define('UPLOAD_TMP_DI_PATH', MAIN_PATH . UPLOAD_FOLDER. 'temps/' . session_id() . '/' . 'items');

class DigitalItem
{
	private $system; 
	private $security; 
	private $max_size; 
	private $message; 
	private $db_prefix;
	private $database;
	private $allowedMINE = array();
	
	function __construct()
	{
		global $system, $MSG, $DBPrefix, $db;
		
		$this->security = new security();
		$this->system = $system;
		$this->max_size = $this->system->SETTINGS['digital_item_size'];
		$this->message = $MSG;
		$this->db_prefix = $DBPrefix;
		$this->database = $db;
		
		// file types allowed
		// Control parameters and file existence
		$query = "SELECT file_extension FROM " . $this->db_prefix . "digital_item_mime WHERE use_mime = 'y'";
		$this->database->direct_query($query);
		while ($row = $this->database->fetch())
		{
			$this->allowedMINE[] = $row['file_extension'];
		}
		
		// If the folder from $updir or $session_dir not exists, attempts to create it (with mkdir or CHMOD 0755)
		if (is_dir(UPLOAD_TMP_PATH) == false) mkdir(UPLOAD_TMP_PATH, 0755);
		if (is_dir(UPLOAD_TMP_PATH) == false) chmod(UPLOAD_TMP_PATH, 0755);
		if (is_dir(UPLOAD_TMP_DI_PATH) == false) mkdir(UPLOAD_TMP_DI_PATH, 0755);
		if (is_dir(UPLOAD_TMP_DI_PATH) == false) chmod(UPLOAD_TMP_DI_PATH, 0755);
	}
	public function UploadItem()
	{		
		global $_SESSION;
		if ($dir = opendir(UPLOAD_TMP_DI_PATH))
		{
			while (($file = readdir($dir)) !== false)
			{
				if (!is_dir(UPLOAD_TMP_DI_PATH . '/' . $file))
				unlink(UPLOAD_TMP_DI_PATH . '/' . $file);
			}
			closedir($dir);
		}
		
		$rezultat = array();
				
		/** Code for. Uploading files to server **/
		// If is received a valid file from the form
		if (isset($_FILES['file_up'])) 
		{
			// Traverse the array elements, with data from the form fields with name="file_up[]"
			// Check the files received for upload
			if(count($_FILES['file_up']['name']) > 0)
			{
				for($f=0; $f<count($_FILES['file_up']['name']); $f++) 
				{
					$nume_f = $_FILES['file_up']['name'][$f];     // get the name of the current file
					// if the name has minimum 4 characters
					if (strlen($nume_f) > 3) 
					{
					  	// get and checks the file type (extension)
					 	//we have to put the explode code like this or
						//we will get an error
					    $split = explode('.', strtolower($nume_f));
					    $type = end($split);
					    if (in_array($type, $this->allowedMINE)) 
					   	{
					        // check the file size
					        if ($_FILES['file_up']['size'][$f] <= $this->max_size * 1024) 
					        {
					          	// if there aren't errors in the copying process
					          	if ($_FILES['file_up']['error'][$f] == 0) 
					          	{
					            	// Set location and name for uploading file on the server
					            	$newName = $this->security->genRandString(16) . '.' . $type;
					            	$thefile = UPLOAD_TMP_DI_PATH . '/'. $newName;
					            	$_SESSION['SELL_upload_file'] = $newName;
					            	// if the file can't be uploaded, returns a message
					            	if (!$this->system->move_file($_FILES['file_up']['tmp_name'][$f], $thefile)) {
					              		$rezultat[$f] = 'The file '. $nume_f. ' could not be copied, try again!';
					              		$di_message = $rezultat[$f];
					            	}else{
					              		// stores the name of the file
					              		$rezultat[$f] = '<b>New File Uploaded:</b>&nbsp;&nbsp;'.$nume_f.'';
					              		$di_message = $rezultat[$f];
					              		$this->security->encryptFile(UPLOAD_TMP_DI_PATH, $newName);
					            	}
					         	}else{ 
					          		$rezultat[$f] = 'There was an Error with <b>'. $nume_f. '.</b><br>Your File was not uploaded please try again.'; 
					          		$di_message = $rezultat[$f];
					         	}
					     	}else{ 
					        	$rezultat[$f] = 'The file <b>'. $nume_f. '</b> exceeds the maximum permitted size, <i>' . formatSizeUnits($max_size) . 'KB</i>'; 
					    		$di_message = $rezultat[$f];
					    	}
					  	}else { 
					      	$rezultat[$f] = 'The file ('. $nume_f. ') is not an allowed file type'; 
					      	$di_message = $rezultat[$f];
					 	}
					}else { 
				   		$rezultat[$f] = 'The file name must have more than 4 characters long'; 
				   		$di_message = $rezultat[$f];
			    	}
			    }
			}else{ 
				$rezultat[$f] = 'No file found'; 
				$di_message = $rezultat[$f];
			}
		}else{ 
			$rezultat[$f] = 'No file found'; 
			$di_message = $rezultat[$f];
		}
		return $di_message;
	}
}