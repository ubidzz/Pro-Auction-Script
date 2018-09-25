<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');

include INCLUDE_PATH . 'class_time.php';

class global_class extends siteTime
{
	public $SETTINGS;
	public $ADSENSE;
	public $CTIME; 
	public $TDIFF; 
	public $COUNTERS;
	public $complete_validation = false;
	
	private $database = '';
	private $DBPrefix = '';
	private $message = '';

	public function __construct()
	{
		global $DBPrefix, $db, $MSG;
				
		// Load settings
		self::loadsettings();
		
		$this->database = $db;
		$this->DBPrefix = $DBPrefix;
		$this->message = $MSG;
		
		
		//load the website time
		date_default_timezone_set($this->SETTINGS['timezone']);
		$this->TDIFF = self::getUserOffset(date('U'), $this->SETTINGS['timezone']);
		$this->CTIME = self::getUserTimestamp(date('U'), $this->SETTINGS['timezone']);	
				
		// Check ip
		if (!defined('ErrorPage') && !defined('InAdmin'))
		{
			$query = "SELECT id FROM " . $this->DBPrefix . "usersips WHERE ip = :user_ip AND action = 'deny'";
			$params = array(
				array(':user_ip', $_SERVER['REMOTE_ADDR'], 'str')
			);
			$this->database->query($query, $params);
			if ($this->database->numrows() > 0)
			{
				$_SESSION['msg_title'] = $this->message['2_0027'];
				$_SESSION['msg_body'] = $this->message['2_0026'];
				header('location: message.php');
				exit;
			}
		}
	}
	
	public function loadTable($table)
	{
		global $DBPrefix, $db;
		
		$tableArray = '';
		$query = "SELECT * FROM " . $DBPrefix . $table;
		$db->direct_query($query);
		while ($data = $db->result())
		{
			$tableArray[$data['fieldname']] = $data['value'];
		}
		return $tableArray;
	}

	private function loadsettings()
	{
		$this->SETTINGS = self::loadTable('settings');;	
		$this->SETTINGS['gateways'] = unserialize($this->SETTINGS['gateways']);
		
		// check to see witch http to load with the site URL			
		if ($this->SETTINGS['https'] == 'y') {
			$this->SETTINGS['siteurl'] = 'https://' . $this->SETTINGS['siteurl'];
			$sslurl = !empty($this->SETTINGS['https_url']) ? $this->SETTINGS['https_url'] : $this->SETTINGS['siteurl'];
		} else {
			$this->SETTINGS['siteurl'] = 'http://' . $this->SETTINGS['siteurl'];
		}
		
		if ($this->SETTINGS['https'] == 'y' && $_SERVER['HTTPS'] != 'on' && $sslurl)
		{
			header('Location: ' . $sslurl . 'home');
			exit;
		}		
		//load google adsense
		$this->ADSENSE = self::loadTable('adsense');
		
		//load counters db
		$this->COUNTERS = self::loadTable('counters');
	}
		
	public function writesetting($table, $settings, $value = '', $type = 'str')
	{
		global $security;
		
		$modifiedby = isset($_SESSION[$this->SETTINGS['sessionsname'] . '_ADMIN_IN']) ? $security->decrypt($_SESSION[$this->SETTINGS['sessionsname'] . '_ADMIN_IN']) : '';
		$modifieddate = $this->CTIME;
		
		if(isset($modifiedby) !='')
		{
			$settings = array(array('table' => $table, 'column' => $settings, 'value' => $value, 'type' => $type));
			foreach ($settings as $setting)
			{
				// check arguments are set
				if (!isset($setting['table']) || !isset($setting['column']) || !isset($setting['value']))
				{
					continue;
				}
				$setting['type'] = (isset($setting['type'])) ? $setting['type'] : 'str';
				$fieldname = $setting['column'];
				$value = $setting['value'];
				$type = $setting['type'];
				// TODO: Use the data type to check if the value is valid
				$typeCheck = true;
				switch($type)
				{
					case "str":
						if(is_string($value)) {
							$value = $value;
						}else {
							$typeCheck = false;
						}
					break;
					case "int":
						if(is_numeric($value)) {
							$value = intval($value);
						}else {
							$typeCheck = false;
						}
					break;
					case "bool":
						if($value == 'y') {
							$value = 'y';
						}elseif($value == 'n') {
							$value = 'n';
						}else {
							$typeCheck = false;
						}
					break;
					case "bool_int":
						if(is_numeric($value))
						{
							$value = intval($value);
						}else {
							$typeCheck = false;
							$type = 'bool';
						}
					break;
					case "array":
						if(is_array($value))
						{
							$value = serialize($value);
							$type = 'str';
						}else{
							$typeCheck = false;
						}
					break;
					case "float":
						if(is_string($value))
						{
							$value = $value;
						}else{
							$typeCheck = false;
						}
					break;

				}
				if($typeCheck)
				{
					$query = "SELECT * FROM " . $this->DBPrefix . $setting['table'] . " WHERE fieldname = :fieldname";
					$params = array(
						array(':fieldname', $fieldname, 'str')
					);
					$this->database->query($query, $params);
					if ($this->database->numrows() > 0)
					{
						$type = $this->database->result('fieldtype');
						$query = "UPDATE " . $this->DBPrefix . $setting['table'] . " SET
								fieldtype = :fieldtype,
								value = :value,
								modifieddate = :modifieddate,
								modifiedby = :modifiedby
								WHERE fieldname = :fieldname";
					}
					else
					{
						$query = "INSERT INTO " . $this->DBPrefix . $setting['table'] . " (fieldname, fieldtype, value, modifieddate, modifiedby) VALUES
								(:fieldname, :fieldtype, :value, :modifieddate, :modifiedby)";
					}
					$params = array(
						array(':fieldname', $fieldname, 'str'),
						array(':fieldtype', $type, 'str'),
						array(':value', $value, 'str'),
						array(':modifieddate', $modifieddate, 'int'),
						array(':modifiedby', $modifiedby, 'int')
					);
					$this->database->query($query, $params);
					
					// nesting the values to the class SETTINGS, COUNTERS and ADSENSE varibales 
					// depending on witch table is being updated
					switch($setting['table'])
					{
						case "settings":
							$this->SETTINGS[$fieldname] = $value;
						break;
						case "counters":
							$this->COUNTERS[$fieldname] = $value;
						break;
						case "maintainance":
							$this->SETTINGS[$fieldname] = $value;
						break;
						case "adsense":
							$this->ADSENSE[$fieldname] = $value;
						break;
					}
				}
			}
		}
	}

	/* possible types cron, error, admin, user, mod */
	public function log($type = '', $message = '', $user = 0, $action_id = 0)
	{
		global $DBPrefix, $db;
		$query = "INSERT INTO " . $this->DBPrefix . "logs (id, type, message, action_id, user_id, ip, timestamp) VALUES
				(NULL, :log_type, :log_message, :log_auction_id, :log_user_id, :log_ip, :log_time)";
		$params = array(
			array(':log_type', $type, 'str'),
			array(':log_message', $message, 'str'),
			array(':log_auction_id', $action_id, 'str'),
			array(':log_user_id', $user, 'int'),
			array(':log_ip', $_SERVER['REMOTE_ADDR'], 'str'),
			array(':log_time', $this->CTIME, 'int'),
		);
		$this->database->query($query, $params);
	}

	public function check_maintainance_mode()
	{
		$str = self::loadTable('maintainance');
		$this->SETTINGS['superuser'] = $str['superuser'];
		$this->SETTINGS['maintainancetext'] = $str['maintainancetext'];
		$this->SETTINGS['active'] = $str['active'];
		
		if ($this->SETTINGS['active'] == 'y')
		{
			if ($user->logged_in && ($user->user_data['nick'] == $this->SETTINGS['superuser'] || $user->user_data['id'] == $this->SETTINGS['superuser']))
			{
				return false;
			}
			return true;
		}
		return false;
	}

	public function cleanvars($i, $trim = false)
	{ 
		if ($trim)
			$i = trim($i);
		$i = addslashes($i);
		$i = rtrim($i);
		$look = array('&', '#', '<', '>', '"', '\'', '(', ')', '%');
		$safe = array('&amp;', '&#35;', '&lt;', '&gt;', '&quot;', '&#39;', '&#40;', '&#41;', '&#37;');
		$i = str_replace($look, $safe, $i);
		return $i;
	}

	public function uncleanvars($i)
	{
		$look = array('&', '#', '<', '>', '"', '\'', '(', ')', '%');
		$safe = array('&amp;', '&#35;', '&lt;', '&gt;', '&quot;', '&#39;', '&#40;', '&#41;', '&#37;');
		$i = str_replace($safe, $look, $i);
		return $i;
	}

	public function filter($txt)
	{		
		$query = "SELECT * FROM " . $this->DBPrefix . "filterwords";
		$this->database->direct_query($query);
		while ($word = $this->database->result())
		{
			$txt = preg_replace('(' . $word['word'] . ')', '', $txt); //best to use str_ireplace but not avalible for PHP4
		}
		return $txt;
	}
	
	public function URLRedirect($link) //Hel pervent header error
	{
		header('location: ' . $link);
		exit;
	}


	public function move_file($from, $to, $removeorg = 1)
	{
		$upload_mode = (@ini_get('open_basedir') || @ini_get('safe_mode') || strtolower(@ini_get('safe_mode')) == 'on') ? 'move' : 'copy';
		switch ($upload_mode)
		{
			case 'copy':
				if (!@copy($from, $to))
				{
					if (!@move_uploaded_file($from, $to))
					{
						return false;
					}
				}
				if ($removeorg == 1)
					@unlink($from);
				break;

			case 'move':
				if (!@move_uploaded_file($from, $to))
				{
					if (!@copy($from, $to))
					{
						return false;
					}
				}
				if ($removeorg == 1)
					@unlink($from);
				break;
		}
		@chmod($to, 0644);
		return true;
	}

	//CURRENCY FUNCTIONS
	public function input_money($str)
	{
		if (empty($str))
			return 0;

		$str = preg_replace("/[^0-9\.\,\-]/", '', $str);
		if ($this->SETTINGS['moneyformat'] == 1)
		{
			// Drop thousands separator
			$str = str_replace(',', '', $str);
		}
		elseif ($this->SETTINGS['moneyformat'] == 2)
		{
			// Drop thousands separator
			$str = str_replace('.', '', $str);

			// Change decimals separator
			$str = str_replace(',', '.', $str);
		}

		return floatval($str);
	}
	
	public function buildCookie($cookie_name, $cookie_value = '', $cookie_time, $flag = false)
	{
		if($this->SETTINGS['https'] == 'y')
		{
			setcookie($cookie_name, $cookie_value, $cookie_time, '/', $_SERVER['HTTP_HOST'], true, $flag !=false ? true : false);
		}else{
			setcookie($cookie_name, $cookie_value, $cookie_time, '/', $_SERVER['HTTP_HOST'], false, $flag !=false ? true : false);
		}
	}
	
	public function checkEncoding($content)
	{
		if(mb_detect_encoding($content, "\xEF\xBB\xBF", true))
		{
			return  "\xEF\xBB\xBF" . $content;
		}else{
			return $content;
		}
	}
	
	public function SetCookieDirective()
	{
		self::buildCookie('CookieDirective', 'Agree', $this->CTIME + 28684800);
	}


	public function CheckMoney($amount)
	{
		if ($this->SETTINGS['moneyformat'] == 1) {
            if (!preg_match('#^([0-9]+|[0-9]{1,3}(,[0-9]{3})*)(\.[0-9]{0,3})?$#', $amount)) {
                return false;
            }
        } else {
            if (!preg_match('#^([0-9]+|[0-9]{1,3}(\.[0-9]{3})*)(,[0-9]{0,3})?$#', $amount)) {
                return false;
            }
        }
        return true;
	}
	
	public function Check_Validation($bool)
	{
		if(isset($bool) || $bool !=false)
		{
			$this->complete_validation = true;
		}else{
			$this->complete_validation = false;
		}
	}
	
	public function print_money($str, $from_database = true, $link = true, $bold = true)
	{
		$str = $this->print_money_nosymbol($str, $from_database);

		if ($link)
		{
			$currency = '<a href="' . $this->SETTINGS['siteurl'] . 'converter.php?AMOUNT=' . $str . '" alt="converter" data-fancybox-type="iframe" class="converter">' . $this->SETTINGS['currency'] . '</a>';
		}
		else
		{
			$currency = $this->SETTINGS['currency'];
		}

		if ($bold)
		{
			$str = '<b>' . $str . '</b>';
		}

		if ($this->SETTINGS['moneysymbol'] == 2) // Symbol on the right
		{
			return $str . ' ' . $currency;
		}
		elseif ($this->SETTINGS['moneysymbol'] == 1) // Symbol on the left
		{
			return $currency . ' ' . $str;
		}
	}

	public function print_money_nosymbol($str, $from_database = true)
	{
		if($str == 0) {
			$str = '0.00';
		}
		$a = ($this->SETTINGS['moneyformat'] == 1) ? '.' : ',';
        $b = ($this->SETTINGS['moneyformat'] == 1) ? ',' : '.';
        if (!$from_database) {
            $str = $this->input_money($str);
        }
        return number_format(floatval($str), $this->SETTINGS['moneydecimals'], $a, $b);
	}
}

// global functions
function _gmmktime($hr, $min, $sec, $mon, $day, $year)
{
	global $system;
	if ($system->SETTINGS['datesformat'] != 'USA')
	{
		$mon_ = $mon;
		$mon = $day;
		$day = $mon_;
	}

	if (@phpversion() >= '5.1.0')
	{
		return gmmktime($hr, $min, $sec, $mon, $day, $year); // is_dst is deprecated
	}

    if (gmmktime(0,0,0,6,1,2008, 0) == 1212282000)
    {
        //Seems to be running PHP (like 4.3.11).
        //At least if current local timezone is Europe/Stockholm with DST in effect, skipping the ,0 helps:
        return gmmktime($hr, $min, $sec, $mon, $day, $year); //without is_dst-parameter at the end
    }
    return gmmktime($hr, $min, $sec, $mon, $day, $year, 0);
}

function load_counters()
{
	global $system, $DBPrefix, $MSG, $user, $db;
	
	$counters = '';
	//counting all activate auctions
	if ($system->SETTINGS['counter_sold'] == 'y')
	{
		$counters .= '<b>' . $system->COUNTERS['itemssold'] . '</b> ' . strtoupper($MSG['3500_1015548']) . ' | ';
	}
	//counting all activate auctions
	if ($system->SETTINGS['counter_auctions'] == 'y')
	{
		$count_auctions = $system->COUNTERS['auctions'] - $system->COUNTERS['suspendedauctions'];
		$counters .= '<b>' . $count_auctions . '</b> ' . strtoupper($MSG['232']) . '| ';
	}
	//counting all registered account
	if ($system->SETTINGS['counter_users'] == 'y')
	{
		$counters .= '<b>' . $system->COUNTERS['users'] . '</b> ' . strtoupper($MSG['231']) . ' | ';
	}
	//counting all users/guests
	if ($system->SETTINGS['counter_online'] == 'y')
	{
		$cookie_name = $system->SETTINGS['cookiesname'] . '-ONLINE';
		if (!$user->logged_in)
		{		
			if(isset($_COOKIE[$cookie_name]))
			{
				$s = alphanumeric($_COOKIE[$system->SETTINGS['cookiesname'] . '-ONLINE']);
				$cookie_time = time() + 86400;
				$system->buildCookie($cookie_name, $s, $cookie_time);
				$g = $s;
			}
			else
			{
				$s = md5(rand(0, 99) . session_id());
				$cookie_time = time() + 86400;
				$system->buildCookie($cookie_name, $s, $cookie_time);
			}
		}
		else
		{
			$s = 'uId-' . $user->user_data['id'];
			//deleting the cookie we dont need it after logged in
			if(isset($_COOKIE[$system->SETTINGS['cookiesname'] . '-ONLINE']))
			{
				$cookie_hash = '';
				$cookie_time = time() - 86450;
				$system->buildCookie($cookie_name, $cookie_hash, $cookie_time);
			}
		}
		$u = isset($g) ? $g : '';
		$query = "SELECT ID FROM " . $DBPrefix . "online WHERE SESSION = :user";
		$params = array(
			array(':user', $s, 'str')
		);
		$db->query($query, $params);

		if ($db->numrows('ID') == 0)
		{
			$query = "INSERT INTO " . $DBPrefix . "online (SESSION, time) VALUES (:user, :timer)";
			$params = array(
				array(':user', $s, 'str'),
				array(':timer', $system->CTIME, 'int')
			);
			$db->query($query, $params);
		}
		else
		{
			$oID = $db->result('ID');
			$query = "UPDATE " . $DBPrefix . "online SET time = :timer WHERE ID = :online_id";
			$params = array(
		 		array(':timer', $system->CTIME, 'int'),
				array(':online_id', $oID, 'int')
			);
			$db->query($query, $params);
		}
		$query = "DELETE from " . $DBPrefix . "online WHERE time <= :timer";
		$params = array(
			array(':timer', $system->CTIME - 300, 'int')
		);
		$db->query($query, $params);
		
		$query = "SELECT id FROM " . $DBPrefix . "online";
		$db->direct_query($query);
		
		$counters .= '<b>' . $db->numrows('id') . '</b> ' . $MSG['2__0064'] . ' | ';
	}
	
	//counting users logged in
	if ($system->SETTINGS['counter_users_online'] == 'y')
	{
		if($user->logged_in)
		{
			$query = "SELECT hideOnline, id FROM " . $DBPrefix . "users WHERE id = :user_id"; 
			$params = array(
				array(':user_id', $user->user_data['id'], 'int')
			);
			$db->query($query, $params);	
			$user_time = $db->result();
			
			if($user_time['hideOnline'] == 'y') 
			{
				$query = "UPDATE " . $DBPrefix . "users SET is_online = :loggedout WHERE id = :user_id";
			    $params = array(
			    	array(':loggedout', $system->CTIME - 320, 'int'),
					array(':user_id', $user_time['id'], 'int')
				);
				$db->query($query, $params);
			}
			else
			{
				$query = "UPDATE " . $DBPrefix . "users SET is_online = :time WHERE id = :user_id";
				$params = array(
					array(':time', $system->CTIME + 300, 'int'),
					array(':user_id', $user_time['id'], 'int')
				);
				$db->query($query, $params);       
			}
		}
		
		$query = "SELECT id FROM " . $DBPrefix . "users WHERE is_online > :user_timer AND hideOnline = :hide"; 
		$params = array(
			array(':hide', 'n', 'str'),
			array(':user_timer', $system->CTIME, 'int')
		);
		$db->query($query, $params);
		
		$counters .= '<b>' . $db->numrows('id') . '</b> ' . $MSG['2__10059'] . ' | ';
	}	
	
	// Display current Date/Time
	$counters .= $system->dateToTimestamp($system->CTIME);
	$counters .= ' <span id="servertime">' . date('H:i:s', $system->CTIME) . '</span>';
	return $counters;
}

function _in_array($needle, $haystack)
{
	$needle = "$needle"; //important turns integers into strings
	foreach ($haystack as $val)
	{
		if ($val == $needle)
			return true;
	}
	return false;
}

// strip none alpha-numeric characters
function alphanumeric($str)
{
	$str = preg_replace("/[^a-zA-Z0-9\s]/", '', $str);
	return $str;
}

// this is a stupid way of doing things these need to be changed to bools
function ynbool($str)
{
	$str = preg_replace("/[^yn]/", '', $str);
	return $str;
}

function CheckAge($day, $month, $year) // check if the users > 18
{
	$NOW_year = date('Y');
	$NOW_month = date('m');
	$NOW_day = date('d');

	if (($NOW_year - $year) > 18)
	{
		return 1;
	}
	elseif ((($NOW_year - $year) == 18) && ($NOW_month > $month))
	{
		return 1;
	}
	elseif ((($NOW_year - $year) == 18) && ($NOW_month == $month) && ($NOW_day >= $day))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

function get_hash()
{
	$string = '0123456789abcdefghijklmnopqrstuvyxz';
	$hash = '';
	for ($i = 0; $i < 5; $i++)
	{
		$rand = rand(0, (34 - $i));
		$hash .= $string[$rand];
		$string = str_replace($string[$rand], '', $string);
	}
	return $hash;
}

//Check to see if the user email domain is blacklisted
function emailblacklist($email) 
{
	//Split the email and make a array
	$email_split = explode('@', $email);
	$build_url = http_build_query(array(
		'action' => 'api-check',
		'email' => $email_split[1],
		'api' => 'vixgkGHRV1YKJnCXewX9w15x60cJsUwiJ'
	));
	//Set the data that is getting sent
	$content = load_file_from_url("https://Pro-Auction-Script.com/api/check.php?" . $build_url);
	//Decode the json data to get the value
	$IsSpammer = json_decode($content, true); 
	//Return the value to the if() statemant 
	//that is checking the user email domain
	return $IsSpammer['check'];
}

function arrangeCountries($data, $default, $countries)
{
	global $system;
	
	if($default == true && is_array($countries))
	{
		foreach($countries as $k => $v)
		{
			if($system->SETTINGS['defaultcountry'] == $k)
			{
				return $v;
			}
		}
	}
}
function generateSelect($name = '', $options = array(), $selectsetting = '')
{	
	$html = '<select class="form-control" name="' . $name . '">';
	foreach ($options as $option => $value)
	{
		if ($selectsetting == $option)
		{
			$html .= "<option value=" . $option . " selected>" . $value . "</option>";
		}
		else
		{
			$html .= "<option value=" . $option . ">" . $value . "</option>";
		}
	}
	$html .= '</select>';
	return $html;
}

function checkMissing()
{
	global $missing;
	foreach ($missing as $value)
	{
		if ($value)
		{
			return true;
		}
	}
	return false;
}

function ShowFlags($options = false, $admin = false)
{
	global $system, $LANGUAGES, $db, $DBPrefix;
	
	$flags = '';
	if(count($LANGUAGES) > 1)
	{
		$query = "SELECT * FROM " . $DBPrefix . "regionalCodes";
		$db->direct_query($query);
		$regionCode = $db->fetchall();
		foreach ($LANGUAGES as $lang => $value) {
			if($options) {
				foreach($regionCode as $data) {
					if($data['code'] == $lang) {
						if($admin)
						{
							$flags .= '<a href="?lan=' . $lang . '"><img vspace="2" hspace="2" src="' . $system->SETTINGS['siteurl'] . 'language/flags/' . $lang . '.gif" border="0" alt="' . $lang . '">' . $data['region'] . '</a>';
						}else{
			 				$flags .= '<a href="' . $system->SETTINGS['siteurl'] . 'home-lan=' . $lang . '"><img vspace="2" hspace="2" src="' . $system->SETTINGS['siteurl'] . 'language/flags/' . $lang . '.gif" border="0" alt="' . $lang . '"> ' . $data['region'] . '</a>';
						}
					}
				}
			}else{
				if($admin) {
					$flags .= '<a href="?lan=' . $lang . '"><img vspace="2" hspace="2" src="' . $system->SETTINGS['siteurl'] . 'language/flags/' . $lang . '.gif" border="0" alt="' . $lang . '"></a>';
				}else{
					$flags .= '<a href="' . $system->SETTINGS['siteurl'] . 'home-lan=' . $lang . '"><img vspace="2" hspace="2" src="' . $system->SETTINGS['siteurl'] . 'language/flags/' . $lang . '.gif" border="0" alt="' . $lang . '"></a>';
				}
			}
		}
	}
	return $flags;
}

function formatSizeUnits($bytes)
{
	if ($bytes >= 1073741824)
    {
    	$bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
    	$bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
    	$bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
    	$bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
    	$bytes = $bytes . ' byte';
    }
    else
    {
    	$bytes = '0 bytes';
    }
    return $bytes;
}
function load_file_from_url($url)
{
	if(false !== ($str = file_get_contents($url)))
	{
		return $str; 
	}
	elseif(($handle = @fopen($url, 'r')) !== false)
	{
		$str = fread($handle, 5);
		if(false !== $str)
		{
			fclose($handle);
			return $str;
		}
	}
	elseif (function_exists('curl_init') && function_exists('curl_setopt')
	&& function_exists('curl_exec') && function_exists('curl_close'))
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_REFERER, $system->SETTINGS['siteurl']);
		$str = curl_exec($curl);
		curl_close($curl);
		return $str;
	}
	return false;
}

//still not finish and needs the cookie path fixed for sub-Directory so the cookie is not only using / for all sub-Directory
//and should be /test/ = sub-Directory folder
function get_domain($domain, $strip = 0, $cookie = 0, $cookie_name = false, $cookie_value = false, $cookie_expire = false)
{
	global $system;
	
	$stipped_domain = array_filter(explode('//',$domain)); // strip the domain from the http and https
	$stipped_slash = array_filter(explode('/',$stipped_domain[1])); // strip the ending slash's
	
	// strip all slash's and is only used in making cookies so don't need to loop the domain just need the main domain name
	if($strip == 1) {
		if(!isset($stipped_slash[0])) {
			//only runs if the ending slash is missing and the array is empty
			$build_domain = $stipped_domain[1];
		}else {
			//only runs if the ending slash is found
			$build_domain = $stipped_slash[0];
		}
		if($cookie == 1) {
			//building a complete website cookie
			if($system->SETTINGS['https'] == 'y')
			{
				$http = true;
			}else{
				$http = false;
			}
			setcookie($cookie_name, $cookie_value, $cookie_expire, '/', $build_domain, $http, true);	
		}
	}else {
		//only runs if we are not stripping the ending slash in the URL or making cookies
		foreach($stipped_slash as $k => $v) {
			if(!isset($v)) {
				//only runs if the ending slash is missing and readds the ending slash
				$build_domain = $stipped_domain[1] . '/';
			}else {
				//only runs if the ending slash was found
				$build_domain = $v  . '/';
			}
		}
	}
	return $build_domain; //the domain was rebuilt and display the result
}

//this only runs if it is adding fees to a user that is not logged in
function check_user_groups_fees($user_id = 0, $no_fees = 0, $no_buyout_fee = 0, $no_fp_fee = 0) 
{ 
	global $DBPrefix, $db;
	
	$pay_fees = true; 
		
	// pulling the user groups from the user it is adding fees to
	$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array(
		array(':user_id', $user_id, 'int')
	);
	$db->direct_query($query, $params);
	$groups = $db->result('groups');
	
	//checking the groups to see what fee to add 
	$query = "SELECT * FROM " . $DBPrefix . "groups WHERE id IN (" . $groups . ")";
	$db->direct_query($query); 
	while ($row = $db->result())
	{
		if ($row['no_fees'] == 1 && $no_fees == 1) //checking to see if the user don't hves to pay no fees
		{
			$pay_fees = false;
		}
		if($pay_fees) //will run if the $no_fees is true
		{
			if ($row['no_buyout_fee'] == 1 && $no_buyout_fee == 1) //checking to see if the user has to pay Buyer fee
			{
				$no_fees = false;
			}
			if ($row['no_fp_fee'] == 1 && $no_fp_fee == 1) //checking to see if the user has to pay Final Price fee
			{
				$no_fees = false;
			}
		}
	}
	return $no_fees;
}