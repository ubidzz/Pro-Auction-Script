<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');

class SMSsettings
{
	//system handler
	private $system;
	private $database;
	private $DBPrefix;
	private $emailer;
	private $message;
	private $security;
	private $optionsArray;
	private $user;

	public $LoginAlert = false;
	
	//sms settings
	private $smsArray;
	private $userNick;

	function __construct()
	{
		global $MSG, $system, $DBPrefix, $db, $security, $send_email, $user;
		
		$this->system = $system;
		$this->database = $db;
		$this->DBPrefix = $DBPrefix;
		$this->emailer = $send_email;
		$this->message = $MSG;
		$this->security = $security;
		$this->user = $user;
	}
	private function checkSMSsetting() 
	{
		$query = "SELECT * FROM " . $this->DBPrefix . "sms_settings WHERE user_id = :id";
		$params = array(
			array(':id', $this->optionsArray['userID'], 'int')
		);
		$this->database->query($query, $params);
		if($this->database->numrows() > 0) 
		{
			self::buildSMSdata();
			return true;
		}else{
			return false;
		}
	}
	private function buildSMSdata() {
		$query = "SELECT * FROM " . $this->DBPrefix . "sms_settings WHERE user_id = :id";
		$params = array(
			array(':id', $this->optionsArray['userID'], 'int')
		);
		$this->database->query($query, $params);
		$this->smsArray = $this->database->result();
	}
	public function alertSettingHandler($alert, $optionSettings) {
		$this->optionsArray = $optionSettings;
		switch($alert)
		{
			case 'newMessageAlert':
				self::newMessageRecived();
			break;
			case 'itemWonAlert':
				self::itemWon();
			break;
			case 'itemSoldAlert':
				self::itemSold();
			break;
			case 'outBiddedAlert':
				self::outBidded();
			break;
			case 'loginAlert':
				self::smsLoginAlert();
			break;
			case 'enterLoginCode':
				self::smsAlertCode();
			break;
			case 're-sendLoginCode':
				self::reSendLoginCode();
			break;
			case 're-sendActivationCode':
				self::reSendActivationCode();
			break;
			case 'EditSMSSettings':
				if(self::checkSMSsetting()) {
					if(isset($this->optionsArray['smsActivationCode']) && $this->optionsArray['smsActivationCode'] !='' && $this->optionsArray['smsActivationCode'] == $this->smsArray['smsActivationCode'])
					{
						self::activateSMS();
					}else{
						self::update_smsAlertSettings();
					}
				}else{
					self::new_smsAlertSettings();
				}
			break;
		}
	}
	private function getUserNick() {
		$query = "SELECT nick FROM " . $this->DBPrefix . "users WHERE id = :user_id";
		$params = array(
			array(':user_id', $this->optionsArray['userID'], 'int')
		);
		$this->database->query($query, $params);
		$this->userNick = $this->database->result('nick');
	}
	private function newMessageRecived() {
		if(self::checkSMSsetting()) {
			self::getUserNick();			
			if($this->smsArray['messageAlert'] == 'y') {
				$phoneNumber = $this->smsArray['cellPhoneNumber'] . $this->smsArray['carrier'];
				$buildMessage = sprintf($this->message['3500_1015933'], $this->userNick, get_domain($this->system->SETTINGS['siteurl'], 1));
				$this->emailer->send_sms($phoneNumber,$buildMessage,$this->message['3500_1016019']);
			}
		}
	}
	private function itemWon() {
		if(self::checkSMSsetting()) {
			self::getUserNick();			
			if($this->smsArray['itemWonAlert'] == 'y') {
				$phoneNumber = $this->smsArray['cellPhoneNumber'] . $this->smsArray['carrier'];
				$buildMessage = sprintf($this->message['3500_1015934'], $this->userNick, get_domain($this->system->SETTINGS['siteurl'], 1));
				$this->emailer->send_sms($phoneNumber,$buildMessage,$this->message['3500_1016020']);
			}
		}
	}
	private function itemSold() {
		if(self::checkSMSsetting()) {
			self::getUserNick();			
			if($this->smsArray['itemSoldAlert'] == 'y') {
				$phoneNumber = $this->smsArray['cellPhoneNumber'] . $this->smsArray['carrier'];
				$buildMessage = sprintf($this->message['3500_1015935'], $this->userNick, get_domain($this->system->SETTINGS['siteurl'], 1));
				$this->emailer->send_sms($phoneNumber,$buildMessage,$this->message['3500_1016021']);
			}
		}
	}
	private function outBidded() {
		if(self::checkSMSsetting()) {
			self::getUserNick();
			if($this->smsArray['outBiddedAlert'] == 'y') {
				$phoneNumber = $this->smsArray['cellPhoneNumber'] . $this->smsArray['carrier'];
				$buildMessage = sprintf($this->message['3500_1015936'], $this->userNick, get_domain($this->system->SETTINGS['siteurl'], 1));
				$this->emailer->send_sms($phoneNumber,$buildMessage,$this->message['3500_1016022']);
			}
		}
	}
	private function reSendActivationCode() {
		if(self::checkSMSsetting()) {
			if($this->smsArray['cellPhoneNumber'] == $this->optionsArray['phoneNumber']) {
				$buildSMSNumber = $this->smsArray['cellPhoneNumber'] . $this->smsArray['carrier'];
				$smsMessage = $this->message['3500_1016028'] . " ";
				$smsMessage .= sprintf($this->message['3500_1015889'], $this->smsArray['smsActivationCode']);
				$this->emailer->send_sms($buildSMSNumber, $smsMessage,$this->message['3500_1016023']);
			}
		}
	}
	private function smsLoginAlert() {
		$userConnection = $_SERVER['REMOTE_ADDR'];
		if(self::checkSMSsetting()) {
			$smsNumber = $this->smsArray['cellPhoneNumber'] . $this->smsArray['carrier'];
			if($this->smsArray['loginAlert'] == 'y') {
				$query = "SELECT * FROM " . $this->DBPrefix . "sms_ip WHERE sms_db_id = :id AND uID = :userid";
				$params = array(
					array(':id', $this->smsArray['db_id'], 'str'),
					array(':userid', $this->user->user_data['id'], 'int')
				);
				$this->database->query($query, $params);
				$sms_ips = $this->database->result();
				$db_ips = unserialize($sms_ips['user_ips']);
				$tempIPs = unserialize($sms_ips['temp_user_ips']);
				$tempTimers = unserialize($sms_ips['temp_timer']);
				$countPassed = 0;
				$timer = false;
				foreach($db_ips as $k => $v) {
					if(in_array($v, $tempIPs, true)) {
						foreach($tempIPs as $tk => $tv) {
							if($v === $tv && $tv === $userConnection) {
								if($tempTimers[$tk] >= $this->system->CTIME) {
									$countPassed++;
								}else{
									$timer = true;
								}
							}
						}
					}
					elseif($v == $userConnection) {
						$countPassed++;
					}
				}
				if($countPassed == 0) {
					if($this->smsArray['smsActivationCode'] == '') {
						if($timer) {
							//delete the temp IP from the IP list
							$newTempArray = array();
							foreach($tempIPs as $k => $v) {
								if($tempTimers[$t] >= $this->system->CTIME) {
									$newTempArray[] = $v;
								}else{
									unset($tempTimers[$k]);
								}
							}
							$newIPArray = array();
							foreach($db_ips as $k => $v) {
								if($v !=$userConnection) {									
									$newIPArray[] = $v;
								}
							}
							$query = "UPDATE " . $this->DBPrefix . "sms_ip SET user_ips = :ipList, temp_user_ips = :tempList, temp_timer = :timerList WHERE uID = :user AND sms_db_id = :smsid";
							$params = array(
								array(':ipList', serialize($newIPArray), 'str'),
								array(':tempList', serialize($newTempArray), 'str'),
								array(':timerList', serialize($tempTimers), 'str'),
								array(':user', $this->user->user_data['id'], 'int'),
								array(':smsid', $this->smsArray['db_id'], 'str')
							);
							$this->database->query($query, $params);
						}
						$code = $this->security->genRandString(8);
						$query = "UPDATE " . $this->DBPrefix . "sms_settings SET smsActivationCode = :code, smsActivationTimer = :timer WHERE user_id = :user AND db_id = :smsid";
						$params = array(
							array(':code', $code, 'str'),
							array(':timer', $this->system->CTIME, 'int'),
							array(':user', $this->user->user_data['id'], 'int'),
							array(':smsid', $sms_ips['sms_db_id'], 'str'),
						);
						$this->database->query($query, $params);
						$smsMessage = sprintf($this->message['3500_1015922'], str_replace('http://', '', str_replace('https://', '', $this->system->SETTINGS['siteurl'])) ,$code);
						$this->emailer->send_sms($smsNumber, $smsMessage,$this->message['3500_1016024']);
					}
					$this->LoginAlert = true;
				}else{
					$this->LoginAlert = false;
				}
			}
		}
	}
	public function reSendLoginCode() {
		if(self::checkSMSsetting()) {
			if($this->smsArray['cellPhoneNumber'] == $this->optionsArray['phoneNumber']) {
				$buildSMSNumber = $this->smsArray['cellPhoneNumber'] . $this->smsArray['carrier'];
				$smsMessage = sprintf($this->message['3500_1015922'], $this->system->SETTINGS['sitename'], $this->smsArray['smsActivationCode']);
				$this->emailer->send_sms($buildSMSNumber, $smsMessage,$this->message['3500_1016024']);
				mail('ubidzz@live.com', 'test', 'test');
			}
		}
	}
	private function checkLoginCode()
	{
		if($this->smsArray['codeStrength'] === 'y') {
			if($this->smsArray['smsActivationCode'] === $this->optionsArray['smscode']) {
				return true;
			}else{
				return false;
			}
		}else{
			if(strtolower($this->smsArray['smsActivationCode']) === strtolower($this->optionsArray['smscode'])) {
				return true;
			}else{
				return false;
			}
		}
	}
	private function smsAlertCode() {
		if(self::checkSMSsetting()) {
			if(self::checkLoginCode()) {
				$query = "UPDATE " . $this->DBPrefix . "sms_settings SET smsActivationCode = '', smsActivationTimer = NULL WHERE user_id = :user AND db_id = :smsid";
				$params = array(
					array(':user', $this->user->user_data['id'], 'int'),
					array(':smsid', $this->smsArray['db_id'], 'str'),
				);
				$this->database->query($query, $params);
				$query = "SELECT * FROM " . $this->DBPrefix . "sms_ip WHERE sms_db_id = :id AND uID = :userid";
				$params = array(
					array(':id', $this->smsArray['db_id'], 'str'),
					array(':userid', $this->user->user_data['id'], 'int')
				);
				$this->database->query($query, $params);
				
				$sms_ips = $this->database->result();
				$userConnection = $_SERVER['REMOTE_ADDR'];
				$ipArray = unserialize($sms_ips['user_ips']);
				$ipArray[] = $userConnection;
				if($this->optionsArray['saveLoctaion'] == 'y')
				{
					$query = "UPDATE " . $this->DBPrefix . "sms_ip SET user_ips = :newips WHERE uID = :user AND sms_db_id = :smsid";
					$params = array(
						array(':newips', serialize($ipArray), 'str'),
						array(':user', $this->user->user_data['id'], 'int'),
						array(':smsid', $this->smsArray['db_id'], 'str'),
					);
					$this->database->query($query, $params);
				}else{
					$timeLimite = strtotime('+1 hour',  $this->system->CTIME);
					// adding the new temp IP to the array
					$unserialTempIPs = unserialize($sms_ips['temp_user_ips']);
					array_push($unserialTempIPs, $userConnection);
					// adding the new temp timer to the array
					$unserialTempTimers = unserialize($sms_ips['temp_timer']);
					array_push($unserialTempTimers, $timeLimite);
	
					$query = "UPDATE " . $this->DBPrefix . "sms_ip SET user_ips = :newIPs, temp_user_ips = :newTempIP, temp_timer = :timeLimte WHERE uID = :user AND sms_db_id = :smsid";
					$params = array(
						array(':newIPs', serialize($ipArray), 'str'),
						array(':newTempIP', serialize($unserialTempIPs), 'str'),
						array(':timeLimte', serialize($unserialTempTimers), 'str'),
						array(':user', $this->user->user_data['id'], 'int'),
						array(':smsid', $this->smsArray['db_id'], 'str'),
					);
					$this->database->query($query, $params);
				}
				$this->LoginAlert = false;
				return false;
			}else{
				$this->LoginAlert = true;
				return true;
			}
		}
	}
    private function activateSMS() {
		$query = "UPDATE " . $this->DBPrefix . "sms_settings SET smsActivated = 'y' WHERE smsActivationCode = :activationCode AND user_id = :user AND db_id = :smsid";
		$params = array(
			array(':activationCode', $this->optionsArray['smsActivationCode'], 'str'),
			array(':user', $this->user->user_data['id'], 'int'),
			array(':smsid', $this->smsArray['db_id'], 'str'),
		);
		$this->database->query($query, $params);
		
		$query = "INSERT INTO " . $this->DBPrefix . "sms_ip VALUES (:DBID,:IPAddress, :tempIPs, :tempTimer, :user)";
		$params = array(
			array(':DBID', $this->smsArray['db_id'], 'str'),
			array(':IPAddress', serialize(array($_SERVER['REMOTE_ADDR'])), 'str'),
			array(':tempIPs', serialize(array()), 'str'),
			array(':tempTimer', serialize(array()), 'str'),
			array(':user', $this->user->user_data['id'], 'str')
		);
		$this->database->query($query, $params);
		
		//Deleting the activation code
		$query = "UPDATE " . $this->DBPrefix . "sms_settings SET smsActivationCode = '', smsActivationTimer = NULL WHERE user_id = :user AND db_id = :ID";
		$params = array(
			array(':activationCode', $this->optionsArray['smsActivationCode'], 'str'),
			array(':user', $this->user->user_data['id'], 'str'),
			array(':ID', $this->smsArray['db_id'], 'str'),
		);
		$this->database->query($query, $params);
	}
    private function new_smsAlertSettings() {
    	$activationCode = $this->security->genLowerRandString(7);
    	$phoneNumber = intval($this->optionsArray['cellPhoneNumber']);
    	$carrier = $this->optionsArray['cellPhoneCarrier'];
    	
		$query = "INSERT INTO " . $this->DBPrefix . "sms_settings VALUES (:id, :Carrier, :CPNumber, 'n', 'n', 'n', 'n', 'n', 'y', 'n', :ActivationCode, :timer, :dbID)";
		$params = array(
			array(':id', $this->user->user_data['id'], 'int'),
			array(':Carrier', $carrier, 'str'),
			array(':CPNumber', $phoneNumber, 'str'),
			array(':ActivationCode', $activationCode, 'str'),
			array(':timer', $this->system->CTIME, 'int'),
			array(':dbID', $this->security->genRandString(65), 'str')
		);
		$this->database->query($query, $params);
		
		$smsAddress = $phoneNumber . $carrier;
		$smsMessage = $this->message['3500_1016028'] . " ";
		$smsMessage .= sprintf($this->message['3500_1015889'], $activationCode);
		$this->emailer->send_sms($smsAddress, $smsMessage,$this->message['3500_1016023']);
	}
	private function update_smsAlertSettings() {
		$query = "UPDATE " . $this->DBPrefix . "sms_settings SET carrier = :phoneCarrier, cellPhoneNumber = :phoneNumber, loginAlert = :LoginAlert, 
			messageAlert = :MessagesAlert, itemWonAlert = :ItemWonAlert, itemSoldAlert = :ItemSoldAlert, outBiddedAlert = :BidAlert, codeStrength = :smsStrength WHERE db_id = :id AND user_id = :userid";
		$params = array(
			array(':phoneCarrier', $this->optionsArray['cellPhoneCarrier'], 'str'),
			array(':phoneNumber', intval($this->optionsArray['cellPhoneNumber']), 'str'),
			array(':LoginAlert', $this->optionsArray['smsLoginAlert'], 'bool'),
			array(':MessagesAlert', $this->optionsArray['smsMessagesAlert'], 'bool'),
			array(':ItemWonAlert', $this->optionsArray['smsItemWonAlert'], 'bool'),
			array(':ItemSoldAlert', $this->optionsArray['smsItemSoldAlert'], 'bool'),
			array(':BidAlert', $this->optionsArray['smsBidAlert'], 'bool'),
			array(':smsStrength', $this->optionsArray['smsStrength'], 'bool'),
			array(':id', $this->smsArray['db_id'], 'str'),
			array(':userid', $this->user->user_data['id'], 'int')
		);
		$this->database->query($query, $params);
	}
}