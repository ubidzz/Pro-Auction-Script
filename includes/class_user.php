<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');

class user
{
	public $logged_in = false;
		
	//default user groups
	public $can_sell = false;
	public $can_buy = false;
		
	//user group fee settings
	public $no_fees = false;
	public $no_setup_fee = false;
	public $no_excat_fee = false;
	public $no_subtitle_fee = false;
	public $no_relist_fee = false;
	public $no_picture_fee = false;
	public $no_hpfeat_fee = false;
	public $no_hlitem_fee = false;
	public $no_bolditem_fee = false;
	public $no_rp_fee = false;
	public $no_buyout_fee = false;
	public $no_fp_fee = false;
	public $no_geomap_fee = false;
		
	//user data array
	public $user_data = [];

	//system handler
	private $system;
	private $database;
	private $DBPrefix;
	private $emailer;
	private $message;
	private $security;

	function __construct()
	{
		global $MSG, $system, $DBPrefix, $db, $security, $send_email;
		
		$this->system = $system;
		$this->database = $db;
		$this->DBPrefix = $DBPrefix;
		$this->emailer = $send_email;
		$this->message = $MSG;
		$this->security = $security;
		$this->numbers = '1234567890';
		
		if (self::checkLoginSession() !=false)
		{
			if(isset($_COOKIE[$system->SETTINGS['cookiesname'] . '-RM_ID']))
			{
				self::rememberMeLogin($_COOKIE[$system->SETTINGS['cookiesname'] . '-RM_ID']);
			}
			self::userPermissions();
		}
	}
	
	private function checkLoginSession()
	{
		$bool = false;
		if (isset($_SESSION[$this->system->SETTINGS['sessionsname'] . '_LOGGED_NUMBER']) && isset($_SESSION[$this->system->SETTINGS['sessionsname'] . '_LOGGED_IN']) && isset($_SESSION[$this->system->SETTINGS['sessionsname'] . '_LOGGED_PASS']))
		{
			$query = "SELECT * FROM " . $this->DBPrefix . "users WHERE password = :pass AND id = :login";
			$params = array(
				array(':pass', $this->security->decrypt($_SESSION[$this->system->SETTINGS['sessionsname'] . '_LOGGED_PASS']), 'str'),
				array(':login', $this->security->decrypt($_SESSION[$this->system->SETTINGS['sessionsname'] . '_LOGGED_IN']), 'str')
			);
			$this->database->query($query, $params);
			if ($this->database->numrows() > 0)
			{
				$user_data = $this->database->result();
				if (strspn($user_data['password'], $user_data['hash']) == $this->security->decrypt($_SESSION[$this->system->SETTINGS['sessionsname'] . '_LOGGED_NUMBER']))
				{
					$this->user_data = $user_data;
					self::checkBalance($user_data);
					$this->logged_in = true;
					$bool = true;
				}
			}
		}
		return $bool;
	}

	public function checkAuth()
	{	
		if(isset($_SESSION['csrftoken']))
		{
			if($_SESSION['csrftoken'] !='')
			{
				$session_csrftoken = $this->security->decrypt($_SESSION['csrftoken']);
			}else{
				$session_csrftoken = '';
			}
		}else{
			$session_csrftoken = '';
		}

		if(isset($_POST['csrftoken']))
		{
			if($_POST['csrftoken'] !='')
			{
				$post_csrftoken = $this->security->decrypt($_POST['csrftoken']);
			}else{
				$post_csrftoken = '';
			}
		}else{
			$post_csrftoken = '';
		}
		
		# Token should exist as soon as a user is logged in and helps prevent hacking the website
		if($_SERVER["REQUEST_METHOD"] == 'POST' && $this->logged_in == true)
		{
			$valid_req = true;
			if(1 <= count($_POST))		# More than 0 parameters in a POST (csrftoken + 1 more) => check
			{				
				if($session_csrftoken !='' && $post_csrftoken !='')
				{
					//Checking all the csrftoken POST and SESSION
					//The POST and SESSION csrftoken must match with the stored user key
					if($post_csrftoken == $session_csrftoken) {
						$valid_req = false;   # All the checks passed
					}
				}
			}
			if($valid_req)
			{
	            global $ERR;
	                 
	            $_SESSION['msg_title'] = $this->message['936']; 
	            $_SESSION['msg_body'] = $ERR['077']; 
	            header('location: message.php'); 
	        	exit; // kill the page 
	        }
	    }
	    return $this->logged_in;
	}
	private function checkBalance($user_data)
	{
		// check if user needs to be suspended
		if ($this->system->SETTINGS['fee_type'] == 1 && $this->logged_in && $this->system->SETTINGS['fee_disable_acc'] == 'y')
		{
			if ($this->system->SETTINGS['fee_max_debt'] <= (-1 * $user_data['balance']))
			{
				if($user_data['suspended'] !=7)
				{
					$query = "UPDATE " . $this->DBPrefix . "users SET suspended = 7, payment_reminder_sent = 'y' WHERE id = :user_id";
					$params = array(
						array(':user_id', $user_data['id'], 'int')
					);
					$this->database->query($query, $params);
	
					// send email
					$this->emailer->payment_reminder($user_data['name'], $user_data['balance'], $user_data['id'], $user_data['email']);
				}
			}
		}
	}
	public function checkUserValid($id) 
    { 
        global $ERR;
         
        $query = "SELECT id FROM " . $this->DBPrefix . "users WHERE id = :user"; 
        $params = array(
			array(':user', intval($id), 'int')
		);
		$this->database->query($query, $params);
 
        if ($this->database->numrows('id') == 0) 
        { 
            $_SESSION['msg_title'] = $this->message['415']; 
            $_SESSION['msg_body'] = $ERR['025']; 
            header('location: message.php'); 
            exit; 
        } 
    }
    
    public function rememberMeLogin($userCookie) 
    {          
        $query = "SELECT userid FROM " . $this->DBPrefix . "rememberme WHERE hashkey = :RM_ID";
		$params = array(
			array(':RM_ID', $userCookie, 'str')
		);
		$this->database->query($query, $params);
		if ($this->database->numrows() == 1)
		{
			// generate a random unguessable token
			$id = $this->database->result('userid');
			$query = "SELECT hash, password FROM " . $this->DBPrefix . "users WHERE id = :user_id";
			$params = array(
				array(':user_id', $id, 'int')
			);
			$this->database->query($query, $params);
			$user_data = $this->database->result();
			
			// Update "last login" fields in users table
			$user_key = $this->security->genRandString(32);// they get a new key every time they login and used to decrypt the data
			$query = "UPDATE " . $DBPrefix . "users SET user_key = :key WHERE id = :user_id";
			$params = array(
				array(':key', $user_key, 'str'),
				array(':user_id', $id, 'int')
			);
			$this->database->query($query, $params);
	
			$_SESSION['csrftoken'] = $this->security->encrypt($user_key);
			$_SESSION[$this->system->SETTINGS['sessionsname'] . '_LOGGED_IN'] 		= $this->security->encrypt($id);
			$_SESSION[$this->system->SETTINGS['sessionsname'] . '_LOGGED_NUMBER'] 	= $this->security->encrypt(strspn($user_data['password'], $user_data['hash']));
			$_SESSION[$this->system->SETTINGS['sessionsname'] . '_LOGGED_PASS'] 		= $this->security->encrypt($user_data['password']);
		}
    }

    private function userPermissions() 
    { 
    	if ($this->logged_in)
		{
			if ($this->user_data['suspended'] != 7)
			{
				// check if user can sell or buy
				if (strlen($this->user_data['user_groups']) > 0)
				{
					$query = "SELECT * FROM " . $this->DBPrefix . "groups WHERE id IN (" . $this->user_data['user_groups'] . ") AND (can_sell = :sell OR can_buy = :buy)";
					$params = array(
						array(':sell', 1, 'int'),
						array(':buy', 1, 'int')
					);
					$this->database->query($query, $params);
			
					while ($row = $this->database->result()) {
						if ($row['can_sell'] == 1) {
							$this->can_sell = true;
						}
						if ($row['can_buy'] == 1) {
							$this->can_buy = true;
						}
						if ($row['no_fees'] == 1) {
							$this->no_fees = true;
						}
						if ($row['no_setup_fee'] == 1) {
							$this->no_setup_fee = true;
						}
						if ($row['no_excat_fee'] == 1) {
							$this->no_excat_fee = true;
						}
						if ($row['no_subtitle_fee'] == 1) {
							$this->no_subtitle_fee = true;
						}
						if ($row['no_relist_fee'] == 1) {
							$this->no_relist_fee = true;
						}
						if ($row['no_picture_fee'] == 1) {
							$this->no_picture_fee = true;
						}
						if ($row['no_hpfeat_fee'] == 1) {
							$this->no_hpfeat_fee = true;
						}
						if ($row['no_hlitem_fee'] == 1) {
							$this->no_hlitem_fee = true;
						}
						if ($row['no_bolditem_fee'] == 1) {
							$this->no_bolditem_fee = true;
						}
						if ($row['no_rp_fee'] == 1) {
							$this->no_rp_fee = true;
						}
						if ($row['no_buyout_fee'] == 1) {
							$this->no_buyout_fee = true;
						}
						if ($row['no_fp_fee'] == 1) {
							$this->no_fp_fee = true;
						}
						if ($row['no_geomap_fee'] == 1) {
							$this->no_geomap_fee = true;
						}
					}
				}
			}
		}
	}
}