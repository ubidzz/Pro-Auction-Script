<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
if (!defined('InProAuctionScript')) exit('Access denied');
if (!defined('SECURITY_PATH')) exit('Access denied');

if ($system->SETTINGS['encryptionType'] == 'n' && function_exists('mcrypt_encrypt')) 
{
	//Encrypt and Decrypt data useing AES-256
	class security 
	{
		private $salt;
		private $public_key = '';
		private $ivSize;
				
		function __construct()
		{
			global $system;
			        
			$this->salt = base64_decode($system->SETTINGS['encryption_key']); # Private key that was generated from the AdminCP
	        $this->ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC); # Returns the size of the IV belonging to a specific cipher/mode combination
		}
		public function checkKey($key) 
	    {
	        if (strlen($key) < 32) {
	            return false;
	        }else{
	        	return true;
	        }
	    }
		# Check public key
	    private function _getPublicKey($key = '', $mode = '') 
	    {
	    	$failed = false;	
			if($mode === 'encrypt') {
				$this->public_key = self::genRandString(32);
				$failed = true;
				return true;
			}
			elseif($mode === 'decrypt') {
				# The public key was encoded with base64 so we need to decode the public key
				if(base64_decode($key, true) )
				{
					$this->public_key = base64_decode($key);
					$failed = true;
					return true;
				}
			}
								
		    if(!$failed) {
		    	return false;
		    }
	    }
		
	    # Encrypt a value using AES-256.
	    public function encrypt($plain, $images = null) 
	    {	
	    	# incase the public key is empty
	    	if(!self::_getPublicKey(null, 'encrypt')) {
	    		return false;
	    	}else{
		        $key = substr(hash('sha256', $this->public_key . $this->salt), 0, 32); # Generate the encryption and hmac key
		        $iv = mcrypt_create_iv($this->ivSize, MCRYPT_DEV_URANDOM); # Creates an initialization vector (IV) from a random source
		        $ciphertext = $iv . mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plain, MCRYPT_MODE_CBC, $iv); # Encrypts plaintext with given parameters
		        $hmac = hash_hmac('sha256', $ciphertext, $key); # Generate a keyed hash value using the HMAC method
		        $encryption = base64_encode(base64_encode($hmac . $ciphertext) . '::' . base64_encode($this->public_key));
		        
		        # We are replacing the + with ^ because the + some times gives problems in URL like downloading digital item
		        return  str_replace('+','^', str_replace('=', '#', $encryption)); 
			}
	    }
	  
	    # Decrypt a value using AES-256.
	    public function decrypt($encrypted, $images = null)
	    {    	
	   		$fixed = str_replace('^','+', str_replace('#', '=', $encrypted)); # Changing back the + from ^
	   		$decode = base64_decode($fixed); # Using base64_decode to decode the frist part
	   		# Splitting the encrypting data and public key in to a array from the encrypted data so we can use the data
	    	$spliter = explode('::', $decode); 
	    	# Check to see if the public key is found
			if(!self::_getPublicKey($spliter[1], 'decrypt')) {
	    		return false;
	    	}
	    	# Check to see if the cipher is found
	    	elseif(!base64_decode($spliter[0], true)) { 
	    		return false;
	    	}elseif($this->public_key === '') {
	    		return false;
	    	}else{
		       	//// Now do all the decrypting ////	        
		        # Generate the encryption and hmac key.
		        $key = substr(hash('sha256', $this->public_key . $this->salt), 0, 32); 
		        $cipher = base64_decode($spliter[0]);
		 
		        # Split out hmac for comparison
		        $hmac = substr($cipher, 0, 64);
		        $cipher = substr($cipher, 64);
		 
		        $compareHmac = hash_hmac('sha256', $cipher, $key);
		        if ($hmac !== $compareHmac) {
		            return false;
		        }
		 
		        $iv = substr($cipher, 0, $this->ivSize);
		        $cipher = substr($cipher, $this->ivSize);
		        $plain =  mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $cipher, MCRYPT_MODE_CBC, $iv);
		        return rtrim($plain, "\0");
			}
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
			$split = explode('.', $file);
			$fileString = file_get_contents($path . '/' . $file);
			file_put_contents($path . '/' . $split[0] . '.encrypted', self::encrypt($fileString));
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
