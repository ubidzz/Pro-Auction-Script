<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');

class DigitalItem
{
	private $system; 
	private $security; 
	private $message; 
	private $db_prefix;
	private $database;
	
	function __construct()
	{
		global $system, $security, $MSG, $DBPrefix, $db;
		
		$this->security = $security;
		$this->system = $system;
		$this->message = $MSG;
		$this->db_prefix = $DBPrefix;
		$this->database = $db;
	}
	// Preparing to send the file and checking the in coming data
	public function downloadItem($hash, $passed)
	{			
		// Making sure that the $passed has data and is set to word 'passed'
		if($passed == 'passed')
		{
			// Making sure that the $hash has data
			if (isset($hash))
			{
				// Getting the correct data using the hash that was sent
				$query = "SELECT seller, auctions, item FROM " . $this->db_prefix . "digital_items WHERE hash = :id";
				$params = array();
				$params[] = array(':id', $this->security->decrypt($hash), 'str');
				$this->database->query($query, $params);
	
				// Making sure there was a file stored in the database
				if ($this->database->numrows() == 1)
				{
					// Getting data from the database that is needed
					$data = $this->database->result();
					$filename = $data['item'];
					$file = UPLOAD_PATH . '/items/' . $data['seller'] . '/' . $data['auctions'] . '/' . $filename;
					// Making sure that the $filename has data
					if (isset($filename))
					{
						// Decrypt a copy of the file from the encrypted file so it can be download
						$this->security->decryptFile(UPLOAD_PATH . '/items/' . $data['seller'] . '/' . $data['auctions'], $filename);
						
						if (!file_exists($file))
						{
							header('location: ' . $system->SETTINGS['siteurl'] . 'home');
							//Delete the decrypted file after it been downloaded 
	            			//so the file cant not be downloaded by a direct URL
	            			unlink($file);
							exit;
						}
						else
	    				{
							if(!is_readable($file)) 
							{
								header('location: ' . $system->SETTINGS['siteurl'] . 'home');
								//Delete the decrypted file after it been downloaded 
	            				//so the file cant not be downloaded by a direct URL
	            				unlink($file);
								exit;
						    }
						    else 
						    {							    	
						    	// braking down the file name to get the file existence	
						    	$file_extension = strtolower(substr(strrchr($filename,"."),1));
						    	
						    	// Control parameters and file existence
								$query = "SELECT mine_type FROM " . $this->db_prefix . "digital_item_mime WHERE file_extension = :extexn AND use_mime = 'y'";
								$params = array();
								$params[] = array(':extexn', $file_extension, 'str');
								$this->database->query($query, $params);
								if($this->database->numrows() == 1)
								{
									$ctype = $this->database->result('mine_type');
								}
								if (!empty($ctype))
								{
									header('Content-Description: File Transfer'); 
									header('Pragma: public');
									header('Expires: 0');
									header('Cache-Control: must-revalidate, no-cache'); 
									header('Content-Type: ' . $ctype);
									header('Content-Disposition: attachment; filename="' . $filename . '"'); 
									header('Content-Transfer-Encoding: binary');
									header("Content-Length: " . filesize($file));  
	            					readfile($file);
	            					//Delete the decrypted file after it been downloaded 
	            					//so the file cant not be downloaded by a direct URL
	            					unlink($file);
									exit;
								}
								else
								{
									// kill the page if the $check did not match the data
									header('location: ' . $system->SETTINGS['siteurl'] . 'home');
									//Delete the decrypted file after it been downloaded 
	            					//so the file cant not be downloaded by a direct URL
	            					unlink($file);
									exit;
								}	    
						    }
	    				}
					}else{
						// kill the page if the $check did not match the data
						header('location: ' . $system->SETTINGS['siteurl'] . 'home');
						exit;
					}
				}else{
					// kill the page if the $check did not match the data
					header('location: ' . $system->SETTINGS['siteurl'] . 'home');
					exit;
				}
			}else{
				// kill the page if the $check did not match the data
				header('location: ' . $system->SETTINGS['siteurl'] . 'home');
				exit;
			}
		}
		else {
			// kill the page if the $check did not match the pre-set data
			header('location: ' . $system->SETTINGS['siteurl'] . 'home');
			exit;
		}
	}
}