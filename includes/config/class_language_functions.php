<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');

class language
{
	private $system;
	private $massage;
	private $error;
	
	public function __construct()
	{
		global $system, $MSG, $ERR;
		$this->system = $system;
		$this->error = $ERR;
		$this->massage = $MSG;
	}
	private function makeDir($dir)
	{
		mkdir(LANGUAGE_PATH . $dir, 0755);
		chmod(LANGUAGE_PATH . $dir, 0755);
	}
	public function getName($lang, $k)
	{	
		include LANGUAGE_PATH . $lang . '/messages.inc.php';
		return $MSG[$k];
	}
	public function getErrName($lang, $k)
	{	
		include LANGUAGE_PATH . $lang . '/messages.inc.php';
		return $ERR[$k];
	}
	public function getCharset($lang)
	{	
		include LANGUAGE_PATH . $lang . '/messages.inc.php';
		return $CHARSET;
	}
	public function getDocdir($lang)
	{	
		include LANGUAGE_PATH . $lang . '/messages.inc.php';
		return $DOCDIR;
	}
	private function copyEmails($newDir)
	{		
		// Creating the new email folders
		self::makeDir($newDir . '/emails');
		self::makeDir($newDir . '/emails/html');
		self::makeDir($newDir . '/emails/text');
				
		// Language email html file paths
		$defaultHTML = LANGUAGE_PATH . $this->system->SETTINGS['defaultlanguage'] . '/emails/html';
		$newHTML = LANGUAGE_PATH . $newDir . '/emails/html';
		
		// Language email text file paths
		$defaultTEXT = LANGUAGE_PATH . $this->system->SETTINGS['defaultlanguage'] . '/emails/text';
		$newTEXT = LANGUAGE_PATH . $newDir . '/emails/text';
		
		//Copying the default html email files to the new language email folder
		if ($HTML_handle = opendir($defaultHTML)) {
		    while (false !== ($file = readdir($HTML_handle))) {
		        if ('.' != $file && '..' != $file) {
		        	copy($defaultHTML . '/' . $file, $newHTML . '/' . $file);
		        }
		    }
		}
		closedir($HTML_handle);
		
		//Copying the default text email files to the new language email folder
		if ($TEXT_handle = opendir($defaultTEXT)) {
		    while (false !== ($file = readdir($TEXT_handle))) {
		        if ('.' != $file && '..' != $file) {
		        	copy($defaultTEXT . '/' . $file, $newTEXT . '/' . $file);
		        }
		    }
		}
		closedir($TEXT_handle);

	}
	private function copycats($newDir)
	{
		self::makeDir($newDir);
		copy(LANGUAGE_PATH . $this->system->SETTINGS['defaultlanguage'] . '/categories.inc.php', LANGUAGE_PATH . $newDir . '/categories.inc.php');
		copy(LANGUAGE_PATH . $this->system->SETTINGS['defaultlanguage'] . '/categories_select_box.inc.php', LANGUAGE_PATH . $newDir . '/categories_select_box.inc.php');
	}
	private function copyFiles($newDir)
	{
		self::copycats($newDir);
		self::copyEmails($newDir);
	}
	public function uploadFlag()
	{
		$target_dir = LANGUAGE_PATH . "flags/";
		$target_file = $target_dir . basename($_FILES["flagFile"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$check = getimagesize($_FILES["flagFile"]["tmp_name"]);
		if($check !== false) {
			if($check[0] <= 29) {
				if($check[1] <= 19) {
					if (!file_exists($target_file)) {
						if ($_FILES["flagFile"]["size"] <= 500000) {
							if($imageFileType == "gif") {
								if (move_uploaded_file($_FILES["flagFile"]["tmp_name"], $target_file)) {
									$ERROR = "The file ". basename($_FILES["flagFile"]["name"]). " has been uploaded.";
								} else {
									$ERROR = "Sorry, there was an error uploading your file.";
								}
							} else {
								$ERROR = "Sorry, only GIF files are allowed.";
							}
						} else {
							$ERROR = "Sorry, your file is too large.";
						}
					} else {
						$ERROR = "Sorry, file already exists.";
					}
				} else {
					$ERROR = "Sorry, the image hight is not 19px.";
				}
			} else {
				$ERROR = "Sorry, the image width is not 29px.";
			}
		} else {
			$ERROR = "Sorry, the file is not an image.";
		}
		return $ERROR;
	}
	public function buildFile($newDir = 0)
	{
		$output = "<?php\n";
		$output .= "/******************************************************************************* \n";
		$output .= "*   copyright				: (C) 2013 - 2017 Pro-Auction-Script \n";
		$output .= "*   site					: https://www.pro-auction-script.com \n";
		$output .= "*   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license \n";
		$output .= "*******************************************************************************/ \n\n";
		$output .= "if (!defined('InProAuctionScript')) exit('Access denied');\n\n";
		$output .= "// CHARSET ENCODING\n";
		$output .= "// Change the charset according to the language used in this file.\n";
		$output .= '$' . 'CHARSET = "' . $_POST['charset'] . '";';
		$output .= "\n\n// DOCUMENT DIRECTION\n";
		$output .= "// Change the $DOCDIR variable below according to the document direction needed\n";
		$output .= "// by the language you are using.\n";
		$output .= "// Possible values are:\n";
		$output .= "// - ltr (default) - means left-to-right document (almost any language)\n";
		$output .= "// - rtl - means right-to-left document (i.e. arabic, hebrew, ect).\n";
		$output .= '$' . 'DOCDIR = "' . $_POST['docdir'] . '";';
		$output .="\n\n";
		
		if($newDir == 0)
		{
			$output .= "// Error messages and user interface messages are below. Translate them taking care of leaving\n";
			$output .= "// The PHP and HTML tags unchanged.\n";
			$output .= "// Error messages =============================================================\n";
			foreach ($_POST['lanERR'] as $k => $v)
			{
				if($k !='charset' && $k !='docdir' && $k !='action' && $k !='new_lang' && $k !='admincsrftoken' && $k !='submit')
				{
					$val = str_replace('"', '\"', $v);
					$output .= '$' . 'ERR[' . $k . '] = "' . $val . '";';
					$output .="\n";
				}
			}
			$output .= "\n// UI Messages =============================================================\n";
			foreach ($_POST['lan'] as $k => $v)
			{
				if($k !='charset' && $k !='docdir' && $k !='action' && $k !='new_lang' && $k !='admincsrftoken' && $k !='submit')
				{
					$val = str_replace('"', '\"', $v);
					$output .= '$' . 'MSG[' . $k . '] = "' . $val . '";';
					$output .="\n";
				}
			}
		}else{
			self::copyFiles($_POST['langcode']);
		}
		$output .= "\n?>";
		
		$handle = fopen (LANGUAGE_PATH . $_POST['langcode'] . '/messages.inc.php', 'w');
		fputs($handle, $this->system->checkEncoding($output));
		fclose($handle);
	}

}
