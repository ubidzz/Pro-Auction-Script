<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');

define('UPLOAD_TMP_FOLDER', MAIN_PATH . UPLOAD_FOLDER. 'temps/');
define('UPLOAD_TMP_PATH', UPLOAD_TMP_FOLDER . session_id());

class UploadHandler
{
	private $system; 
	private $error; 
	private $security; 
	private $allowtype; 
	private $max_size; 
	private $max_pics; 
	private $message; 
	private $session;
	
	function __construct()
	{
		global $system, $security, $MSG, $ERR;
		
		$this->security = $security;
		$this->system = $system;
		$this->allowtype = unserialize($this->system->SETTINGS['allowed_image_mime']);
		$this->max_size = $this->system->SETTINGS['maxuploadsize'] * 1024;
		$this->max_pics = $this->system->SETTINGS['maxpictures'];
		$this->message = $MSG;
		$this->error = $ERR;
		
		// If the folder from $updir or $session_dir not exists, attempts to create it (with mkdir or CHMOD 0777)
		if (is_dir(UPLOAD_TMP_FOLDER) == false) mkdir(UPLOAD_TMP_FOLDER, 0755);
		if (is_dir(UPLOAD_TMP_FOLDER) == false) chmod(UPLOAD_TMP_FOLDER, 0755);

		if (is_dir(UPLOAD_TMP_PATH) == false) mkdir(UPLOAD_TMP_PATH, 0755);
		if (is_dir(UPLOAD_TMP_PATH) == false) chmod(UPLOAD_TMP_PATH, 0755);
		
		self::GetSessions();
	}
	private function SetSessions()
	{
		global $_SESSION;
		$_SESSION['SELL_pict_url'] = $this->session['SELL_pict_url'];
		$_SESSION['UPLOADED_PICTURES'] = $this->session['UPLOADED_PICTURES'];
		
	}
	private function GetSessions()
	{
		global $_SESSION;
	 		$this->session['SELL_pict_url'] = $_SESSION['SELL_pict_url'];
 			$this->session['UPLOADED_PICTURES'] = $_SESSION['UPLOADED_PICTURES'];
		
	}

	private function check_file_uploaded_name($filename)
	{
	    return (bool) ((mb_strlen($filename,"UTF-8") > 225) ? true : false);
	}

	private function set_watermark($file_name, $path)
	{		
		$watermark_logo = !empty($this->system->SETTINGS['watermark']) ? $this->system->SETTINGS['watermark'] : $this->system->SETTINGS['logo'];
		$watermark_dir = file_exists(UPLOAD_PATH . 'logos/watermarks/' . $watermark_logo) ? UPLOAD_PATH . 'logos/watermarks/' : UPLOAD_PATH . 'logos/';
		
		switch (strtolower(substr(strrchr($path . '/' . $file_name, '.'), 1)))
		{
			case 'png':
				$img = @imagecreatefrompng($path . '/' . $file_name);
				$quality = 9;
				$write_image = 'imagepng';
			break;
			case 'jpeg':
				$img = @imagecreatefromjpeg($path . '/' . $file_name);
				$quality = 90;
				$write_image = 'imagejpeg';
			break;
			case 'jpg':
				$img = @imagecreatefromjpeg($path . '/' . $file_name);
				$quality = 90;
				$write_image = 'imagejpeg';
			break;
			case 'jpe':
				$img = @imagecreatefromjpeg($path . '/' . $file_name);
				$quality = 90;
				$write_image = 'imagejpeg';
			break;
			case 'gif':
				$img = @imagecreatefromgif($path . '/' . $file_name);
				$quality = null;
				$write_image = 'imagegif';
			break;
			default:
				$img = false;
			break;
		}
		if($img)
		{
			//image size
			$im_x = imagesx($img);
			$im_y = imagesy($img);
		
			$image = @imagecreatetruecolor($im_x, $im_y);
			@imagecopyresampled($image, $img, 0, 0, 0, 0, $im_x, $im_y, $im_x, $im_y);    
			//allows us to apply a 24-bit watermark over $image
			@imagealphablending($image, true);
			@imagesavealpha($image, true);
					
			//finding out what file type the watermark image is and splitting so we can also use it
			$watermark = UPLOAD_PATH . '/logos/watermarks/' . $watermark_logo;
			switch (strtolower(substr(strrchr($watermark_logo, '.'), 1)))
			{
				case 'png':
					$stamp = @imagecreatefrompng($watermark);
				break;
				case 'jpeg':
					$stamp = @imagecreatefromjpeg($watermark);
				break;
				case 'jpg':
					$stamp = @imagecreatefromjpeg($watermark);
				break;
				case 'jpe':
					$stamp = @imagecreatefromjpeg($watermark);
				break;
				case 'gif':
					$stamp = @imagecreatefromgif($watermark);
				break;
				case 'bmp':
					$stamp = @imagecreatefromwbmp($watermark);
				break;
			}
		
			//watermark size
			$stamp_x = imagesx($stamp);
			$stamp_y = imagesy($stamp);
													
			//checking to see if the picture is smaller than the watermark image
			if($stamp_y > $im_y)
			{
				$percent = $im_x * 0.21;
				//Create the final resized watermark stamp
				$dest_image = @imagecreatetruecolor($percent, $percent);
				//keeps the transparency of the picture
				@imagealphablending($dest_image, true);
				@imagesavealpha($dest_image, true);
				//resizes the stamp
				@imagecopyresampled($dest_image, $stamp, 0, 0, 0, 0, $percent, $percent, $stamp_x, $stamp_y);
				//Apply watermark and save
				@imagecopy($image,$dest_image,round(round($im_x  -10) - round($percent  -5)), round(round($im_y / 1.1) - round($percent / 1.1)), 0, 0, $percent, $percent);
				//destroy the watermark imagecopyresampled images
				@imagedestroy($stamp);
				@imagedestroy($dest_image);
			}
			else //the picture is bigger than the watermark
			{
				//positionnig the stamp to the bottom right corner
				@imagealphablending($stamp, true);
				@imagesavealpha($stamp, true);
				//Apply watermark and save
				@imagecopy($image,$stamp,$im_x - $stamp_x - 10,$im_y - $stamp_y - 10,0,0,$stamp_x,$stamp_y);
				//destroy the watermark imagecopyresampled
				@imagedestroy($stamp);
			}
			//make the new image file					
			$write_image($image, $path . '/' . $file_name,$quality);
			@chmod($path . '/' . $file_name, 0644);
			//destroy all the imagecopyresampled images
			@imagedestroy($img);
			@imagedestroy($image);
		}
	}
	private function checkNumberUploadedImage()
	{
		if(count($this->session['UPLOADED_PICTURES']) >= $this->max_pics)
		{
			return true;
		}else{
			return false;
		}
	}
	public function FileUploader($file)
	{
		// Variable to store the messages that will be returned by the script
		$rezultat = array();
			
		/** Code for. Uploading files to server **/
		// If is received a valid file from the form
		// Traverse the array elements, with data from the form fields with name="file_up[]"
		// Check the files received for upload
		if(count($_FILES['file']['name']) > 0)
		{
			$getNewRandomName = $this->security->genRandString(16);
			$nume_f = $_FILES['file']['name'];     // get the name of the current file
			if(self::checkNumberUploadedImage())
			{
				return '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' . $this->message['3500_1015902'] . '</div>';
			}
			elseif(self::check_file_uploaded_name($nume_f))
			{
				return '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' . $this->message['3500_1015903'] . '</div>';
			}else{
					// if the name has minimum 3 characters
				if (strlen($nume_f) >= 4) 
				{
					// get and checks the file type (extension)
					//we have to put the explode code like this or
					//we will get an error
					$split = explode('.', strtolower($nume_f));
				    $type = end($split);
					if (in_array($type, $this->allowtype)) 
					{
						// check the file size
						if ($_FILES['file']['size'] <= $this->max_size) 
						{
						    // if there aren't errors in the copying process
						    if ($_FILES['file']['error'] == 0)
						  	{
						        // Set location and name for uploading file on the server
						        $image = $getNewRandomName . '.' . $type;
						        $thefile = UPLOAD_TMP_PATH . '/' . $image;
						            	
							    // if the file can't be uploaded, returns a message
								if (!$this->system->move_file($_FILES['file']['tmp_name'], $thefile)) 
								{
								  	return sprintf($this->error['716'], $nume_f, $thefile);
								}
							   	else 
							   	{
							    	// stores the name of the file
							     	if($this->system->SETTINGS['watermark_active'] == 'y')
								  	{
									   		self::set_watermark($image, UPLOAD_TMP_PATH);
								  	}
								  	$this->session['UPLOADED_PICTURES'][] = $image;
								  	self::SetSessions();
								  	if(count($this->session['SELL_pict_url']) == 0 || !$this->session['SELL_pict_url'] || $this->session['SELL_pict_url'] == '')
									{
										self::SetDefaultImage($image);
								  	}
						        }
							}else{
								return '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' . sprintf($this->error['717'], $nume_f) . '</div>';
							}
						}else{
							return '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' . sprintf($this->error['718'], $nume_f, $this->max_size) . '</div>';
						}
					}else{
						return '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' . sprintf($this->error['719'], $nume_f) . '</div>';
					}
				}else{
					return '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' . $this->error['720'] . '</div>';
				}
			}
		}else{
			return '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' . $this->error['721'] . '</div>';
		}
	}
	private function RebuildImageArry($ImageArray)
	{		
		$this->session['UPLOADED_PICTURES'] = '';
		$returnBool = false;
		if(count($ImageArray) !=0)
		{
			foreach($ImageArray as $k => $v)
			{
				if($v != $this->session['SELL_pict_url'])
				{
					$this->session['UPLOADED_PICTURES'][] = $v;
					$returnBool = true;
				}
			}
		}else{
			$this->session['UPLOADED_PICTURES'] = '';
			$this->session['SELL_pict_url'] = '';
		}
		self::SetSessions();
	}
	private function GetRandomPicture()
	{
		if(array_filter($this->session['UPLOADED_PICTURES']) && count($this->session['UPLOADED_PICTURES']) > 0)
		{
			//looping through the uploaded picture to make sure we don't 
			//readd the deleted picture as the default and set a new default picture
			foreach($this->session['UPLOADED_PICTURES'] as $k => $v)
			{
				if($v != $this->session['SELL_pict_url'])
				{
					if(array_key_exists($k, $this->session['UPLOADED_PICTURES']))
					{
						//rebuilding the picture array and deleting the picture from it
						self::RebuildImageArry($this->session['UPLOADED_PICTURES']);
						if(count($this->session['UPLOADED_PICTURES']) !=0 )
						{
							//set the new default picture and return the 
							//string with the new default picture
							return self::SetDefaultImage($v);
						}
					}
				}
			}
		}else{
			return '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' . $this->error['723'] . '</div>';
		}
	}
	public function SetDefaultImage($setDefaultImage)
	{		
		$this->session['SELL_pict_url'] = $setDefaultImage;
		self::SetSessions();
		if($this->session['SELL_pict_url'] !='' && file_exists(UPLOAD_TMP_PATH . '/' . $setDefaultImage))
		{
			return '<div id="defaultPicture" class="well">
				<div class="input-group">
					<b class="form-control">Your Default Picture</b>
				</div>
				<img title="' . $this->session['SELL_pict_url'] . '" height="20%" width="20%" src="' . $this->system->SETTINGS['siteurl'] . 'uploaded/temps/' . session_id() . '/' . $this->session['SELL_pict_url'] . '"> 
			</div>';
		}else{
			return '<div id="defaultPicture"></div>';
		}
	}
	public function GetDefaultImage()
	{		
		if($this->session['SELL_pict_url'] !='' && file_exists(UPLOAD_TMP_PATH . '/' . $this->session['SELL_pict_url']))
		{
			return '<div id="defaultPicture" class="well">
				<div class="input-group">
					<b class="form-control">Your Default Picture</b>
				</div>
				<img title="' . $this->session['SELL_pict_url'] . '" height="20%" width="20%" src="' . $this->system->SETTINGS['siteurl'] . 'uploaded/temps/' . session_id() . '/' . $this->session['SELL_pict_url'] . '"> 
			</div>';
		}
		else{
			return self::GetRandomPicture();
		}
	}
	public function DeletePicture($PictureName = '')
	{		
		if($PictureName !='' && file_exists(UPLOAD_TMP_PATH . '/' . $PictureName) !=false)
		{
			unlink(UPLOAD_TMP_PATH . '/' . $PictureName);
			foreach($this->session['UPLOADED_PICTURES'] as $k => $v)
			{
				if($PictureName == $v)
				{
					unset($this->session['UPLOADED_PICTURES'][$k]);
				}
			}
			if($this->session['SELL_pict_url'] == $PictureName)
			{
				return self::GetRandomPicture();
			}
			if(count($this->session['UPLOADED_PICTURES']) == 0)
			{
				unset($this->session['SELL_pict_url']);
			}
			return self::GetRandomPicture();
		}
	}
}