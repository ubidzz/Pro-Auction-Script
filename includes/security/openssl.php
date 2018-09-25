<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
if (!defined('InProAuctionScript')) exit('Access denied');
if (!defined('SECURITY_PATH')) exit('Access denied');

if($system->SETTINGS['encryptionType'] == 'y' && extension_loaded('openssl'))
{
	//Encrypt and Decrypt data useing AES-256
	class security 
	{
		private $masterKey;
		
		function __construct()
		{
			global $system;
						
			$this->masterKey = base64_decode($system->SETTINGS['encryption_key']);
		}
		public function checkKey($key) 
	    {
	        if (strlen($key) < 32) {
	            return false;
	        }else{
	        	return true;
	        }
	    }			
	    # Encrypt a value using AES-256.
	    public function encrypt($data, $isImage = false) 
	    {	
	    	$iv = self::genRandString(16);
		    $encrypt = openssl_encrypt($data, 'AES-256-CBC', $this->masterKey, 0, $iv);		        
		    $encryption = base64_encode($encrypt . '::' . $iv);
		    return $encryption; 
	    }
	  
	    # Decrypt a value using AES-256.
	    public function decrypt($encrypted, $isImage = false)
	    {
	    	$decoded = base64_decode($encrypted);
	    	list($encrypted_data, $iv) = explode('::', $decoded, 2);
    		$decrypted = openssl_decrypt($encrypted_data, 'AES-256-CBC', $this->masterKey, 0, $iv);
    		return $decrypted;
    	}
    	
    	 #Get Random String - Usefull for public key
	    public function genLowerRandString($length = 0) 
	    {
	        $charset = 'abcdefghijklmnopqrstuvwxyz0123456789';
	        $str = '';
	        $count = strlen($charset);
	        while ($length-- > 0) {
	            $str .= $charset[mt_rand(0, $count-1)];
	        }
			return $str;
	    }
	        
	    #Get Random String - Usefull for public key
	    public function genRandString($length = 0) 
	    {
	        $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	        $str = '';
	        $count = strlen($charset);
	        while ($length-- > 0) {
	            $str .= $charset[mt_rand(0, $count-1)];
	        }
			return $str;
	    }
	    
	    public function encryptFile($path, $file)
		{
			$split = explode('.', strtolower($file));
			$type = end($split);
			$fileString = file_get_contents($path . '/' . $file);
			file_put_contents($path . '/' . $type . '.encrypted', self::encrypt($fileString));
			unlink($path . '/' . $file);
			//self::decryptFile($path, $file); // Only used for testing
		}
		public function decryptFile($path, $file)
		{
			$fileArray = explode('.', $file);
			$fileString = file_get_contents($path . '/' . $fileArray[0] . '.encrypted');
			file_put_contents($path . '/' . $fileArray[0]  . '.' . end($fileArray), self::decrypt($fileString));
		}
	}
}
