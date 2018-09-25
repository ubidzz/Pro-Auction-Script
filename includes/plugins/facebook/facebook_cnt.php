<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

class FacebookConnect
{
	private $system; 
	private $security;
	private $message; 
	private $DBprefix;
	private $database;
	private $user;
	
	public $FBid = '';
	public $FBname = '';
	public $FBemail = '';
	public $FBimage = '';

	function __construct()
	{
		global $system, $security, $db, $MSG, $DBPrefix, $user;
		
		$this->security = $security;
		$this->system = $system;
		$this->message = $MSG;
		$this->DBprefix = $DBPrefix;
		$this->database = $db;
		$this->user = $user;
	}
	public function connectToFacebook()
	{		
		include PLUGIN_PATH . 'facebook/Facebook/autoload.php';  
		$fb = new Facebook\Facebook([
			'app_id' => $this->system->SETTINGS['facebook_app_id'], 
			'app_secret' => $this->system->SETTINGS['facebook_app_secret'],
			'default_graph_version' => 'v2.5',
		]);
		$ERROR = false;
		$jsHelper = $fb->getJavaScriptHelper();
		
		// trying to get the user FB access token
		try {
		  	$accessToken = $jsHelper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
  			// When Graph returns an error
  			$ERR = 'Graph returned an error: ' . $e->getMessage();
  			$this->system->log('error', $ERR);
			$ERROR = true;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
  			// When validation fails or other local issues
  			$ERR = 'Facebook SDK returned an error: ' . $e->getMessage();
  			$this->system->log('error', $ERR);
			$ERROR = true;
		} catch(Exception $e) {
			$this->system->log('error', $e->getMessage());
			$ERROR = true;
		}
		
		// trying to get the user FB information
		try {
		  	$response = $fb->get('/me?fields=id,name,email', $accessToken);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  	// When Graph returns an error
		  	$ERR = 'Graph returned an error: ' . $e->getMessage();
		  	$this->system->log('error', $ERR);
			$ERROR = true;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  	// When validation fails or other local issues
		  	$ERR ='Facebook SDK returned an error: ' . $e->getMessage();
		  	$this->system->log('error', $ERR);
			$ERROR = true;
		}catch(Exception $e) {
			$this->system->log('error', $e->getMessage());
			$ERROR = true;
		}
		
		if(!$ERROR)
		{
			$facebook_profile = $response->getGraphUser();
			//////Get the person facebook info from facebook and set them in to variables
			$this->FBid = isset($facebook_profile["id"]) ? $facebook_profile["id"] : '';
			$this->FBemail = isset($facebook_profile["email"]) ? $facebook_profile["email"] : '';
			$this->FBname = isset($facebook_profile["name"]) ? $facebook_profile["name"] : '';
			$this->FBimage = "https://graph.facebook.com/" . $this->FBid . "/picture?type=large";
			self::processFacebook();
		}
	}
	private function processFacebook()
	{
		/////////This will check to see if the person has a stored FB id in the FB sql table  
		/////////If there is no stored FB id in the FB sql table then it will make a new 
		/////////FB id column in the FB sql table 
		$query = "SELECT fb_id FROM " . $this->DBprefix . "facebookLogin WHERE fb_id = :id"; 
		$params = array(
			array(':id', $this->FBid, 'str')
		);
		$this->database->query($query, $params); 
		if ($this->database->numrows('fb_id') == 0) 
		{ 
			$query = "INSERT INTO " . $this->DBprefix . "facebookLogin VALUES (NULL, :user_id, :user_name, :user_email, :user_avatar, :user_time)";
			$params = array(
				array(':user_id', $this->FBid, 'str'),
				array(':user_name', $this->FBname, 'str'),
				array(':user_email', $this->FBemail, 'str'),
				array(':user_avatar', $this->FBimage, 'str'),
				array(':user_time', $this->system->getUserTimestamp($this->system->CTIME), 'int'),
			);
			$this->database->query($query, $params);
		}
		$REDIRECTURL = true;
		$query = "SELECT id, facebook_id FROM " . $this->DBprefix . "users WHERE facebook_id = :fb_id";
		$params = array(
			array(':fb_id', $this->FBid, 'int')
		);
		$this->database->query($query, $params);
		if($this->database->numrows('id') == 1)
		{		            
			$userData = $this->database->result();
			if ($userData['facebook_id'] === $this->FBid)
			{    
				//// make the session that will be needed to see
				//// if the user has a stored facebook id in there sql column 
				self::loginToWebsite();
				$REDIRECTURL = false;
			}
		}
		if($this->user->checkAuth())
		{
			$query = "UPDATE " . $this->DBprefix . "users SET facebook_id = :fbID WHERE id = :user_id";
			$params = array(
				array(':fbID', $this->FBid, 'str'),
				array(':user_id', $this->user->user_data['id'], 'int')
			);
			$this->database->query($query, $params);
		}
		if($_SESSION['REDIRECT_AFTER_LOGIN'] !='new_account' && $REDIRECTURL) {
			if(isset($_SESSION['REDIRECT_AFTER_LOGIN']) && $this->user->checkAuth()) {
				header('location: ' . $this->system->SETTINGS['siteurl'] . $_SESSION['REDIRECT_AFTER_LOGIN']);
				exit();			
			}else{
				header('location: ' . $this->system->SETTINGS['siteurl'] . 'new_account');
				exit();
			}
		}
	}
	private function loginToWebsite()
	{		
		////Check the users sql table to see if a user has the same FB id
		////and if there is a user with the same FB id it will log them in
		$query = "SELECT id, hash, suspended, password FROM " . $this->DBprefix . "users WHERE facebook_id = :check_id LIMIT 1";
		$params = array(
			array(':check_id', $this->FBid, 'int')
		);
		$this->database->query($query, $params);
				        
		/// From here down is what turns the facebook 
		/// login in to ProAuctionScript login.
		if ($this->database->numrows() == 1)
		{   
			$user_data = $this->database->result(); 
			$user_key = $this->security->genRandString(32);
			$_SESSION['csrftoken'] = $this->security->encrypt($user_key);
			if ($user_data['suspended'] == 9)
			{
				$_SESSION['signup_id'] = $user_data['id'];
			 	header('location: pay.php?a=3');
			  	exit;
			}
			/// Here we are checking the user account
			/// to see if the account is suspended
			if ($user_data['suspended'] == 1)
			{
				$ERROR = $ERR['618'];
			}
			elseif ($user_data['suspended'] == 8)
			{
				$ERROR = $ERR['620'];
			}
			elseif ($user_data['suspended'] == 10)
			{
				$ERROR = $ERR['621'];
			}
			if(isset($ERROR))
			{
				$_SESSION['msg_title'] = $this->message['753']; 
	            $_SESSION['msg_body'] = $ERROR;
				header('location: message.php');
				exit;
			}
			else
			{
				/// Here we are making the ProAuctionScript session's to tell
				/// ProAuctionScript that we are loged in
				$_SESSION[$this->system->SETTINGS['sessionsname'] . '_LOGGED_IN']         = $this->security->encrypt($user_data['id']);
				$_SESSION[$this->system->SETTINGS['sessionsname'] . '_LOGGED_NUMBER']     = $this->security->encrypt(strspn($user_data['password'], $user_data['hash']));
				$_SESSION[$this->system->SETTINGS['sessionsname'] . '_LOGGED_PASS']       = $this->security->encrypt($user_data['password']);
				// Update "last login" fields in users table
				$query = "UPDATE " . $this->DBprefix . "users SET lastlogin = :date WHERE id = :user_id";
				$params = array(
					array(':date', date("Y-m-d H:i:s"), 'str'),
					array(':user_id', $user_data['id'], 'int')
				);
				$this->database->query($query, $params);
			  	////check ip
			  	$query = "SELECT id FROM " . $this->DBprefix . "usersips WHERE USER = :user_id AND ip = :user_ip";
				$params = array(
					array(':user_ip', $_SERVER['REMOTE_ADDR'], 'str'),
					array(':user_id', $user_data['id'], 'int')
				);
				$this->database->query($query, $params);
				if ($this->database->numrows() == 0)
				{
			      	$query = "INSERT INTO " . $this->DBprefix . "usersips VALUES (NULL, :user_id, :user_ip, 'after','accept')";
					$params = array(
						array(':user_ip', $_SERVER['REMOTE_ADDR'], 'str'),
						array(':user_id', $user_data['id'], 'int')
					);
					$this->database->query($query, $params);
				}
				// delete your old session
				if (isset($_COOKIE[$this->system->SETTINGS['cookiesname'] . '-ONLINE']))
				{
					$query = "DELETE from " . $this->DBprefix . "online WHERE SESSION = :SESSION";
					$params = array(
						array(':SESSION', alphanumeric($_COOKIE[$this->system->SETTINGS['cookiesname'] . '-ONLINE']), 'str')
					);
					$this->database->query($query, $params);			                
				}
				$query = "UPDATE " . $this->DBprefix . "users SET hideOnline = :hide WHERE id = :user_id";
				$params = array(
					array(':user_id', $user_data['id'], 'int'),
					array(':hide', 'n', 'bool')
				);
				$this->database->query($query, $params);
				header('location: ' . $this->system->SETTINGS['siteurl'] . $_SESSION['REDIRECT_AFTER_LOGIN']);
				exit();
			}	
		}
	}
	public function FacebookUnlink()
	{
		$query = "SELECT facebook_id FROM " . $this->DBprefix . "users WHERE id = :user_id";
		$params = array(
			array(':user_id', $this->user->user_data['id'], 'int')
		);
		$this->database->query($query, $params);			    
		$unlink_fb = $this->database->result('facebook_id');
		if ($unlink_fb !='' || $unlink_fb !=0)
		{
		    /// Delete the user facebook column that is stored in the facebook table in ProAuctionScript sql
		    $query = "DELETE from " . $this->DBprefix . "facebookLogin WHERE fb_id = :user_fb_id";
		    $params = array(
				array(':user_fb_id', $unlink_fb, 'int')
			);
			$this->database->query($query, $params);
				        
		    //// Delete the facebook id from the user column that will be turned to 0
		    $query = "UPDATE " . $this->DBprefix . "users SET facebook_id = :set_id WHERE id = :user_id";
		    $params = array(
		    	array(':set_id', '', 'str'),
				array(':user_id', $this->user->user_data['id'], 'int')
			);
			$this->database->query($query, $params);
			header('location: edit_data.php');
			exit();
		}
	}
}