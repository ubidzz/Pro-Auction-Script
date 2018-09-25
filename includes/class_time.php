<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/


if (!defined('InProAuctionScript')) exit('Access denied');

// work in progress
class siteTime
{	
	// used to be: dates.inc.php FormatDate($DATE, $spacer = '/', $GMT = true)
	public function formatTimestamp($timestamp, $format = '', $timezone_ajust = true)
	{
		if ($format == '')
		{
			$format = ($this->SETTINGS['datesformat'] == 'USA') ? 'm/d/Y' : 'd/m/Y';
		}
		//$dt = DateTime::createFromFormat('U', $timestamp, $this->SETTINGS['timezone']);
		if ($timezone_ajust && !$this->tz_user)
		{
			$timeZone = $this->tz_user;
		}else{
			$timeZone = 'America/New_York';
		}
		
		$dt = self::getConvertedDateTimeObject($timestamp, $timeZone);
		return $dt->format($format);
	}
	// used to be: dates.inc.php FormatTimeStamp($DATE, $spacer = '-')
	public function dateToTimestamp($unixTime, $format = ' ')
	{		
		$format = ($this->SETTINGS['datesformat'] == 'USA') ? 'M' . $format . 'd' . $format . 'Y' : 'd' . $format . 'M' . $format . 'Y';
		$dt = self::getConvertedDateTimeObject($unixTime, $this->SETTINGS['timezone']);
		return $dt->format($format);
	}
	public function ArrangeDateAndTime($DATE, $TIMEZONE = FALSE, $NAME = FALSE, $FORMAT = FALSE)
	{
		if($TIMEZONE !='')
		{
			$setTimezone = $TIMEZONE;
		}else{
			$setTimezone = $this->SETTINGS['timezone'];
		}
		if($NAME !=FALSE)
		{
			if ($this->SETTINGS['datesformat'] == 'USA') {
				$format = 'M j Y H:i:s';
			} else {
				$format = 'j M Y H:i:s';
			}
		}else{
			if ($this->SETTINGS['datesformat'] == 'USA') {
				$format = 'm' . $FORMAT . 'j' . $FORMAT . 'Y H:i:s';
			} else {
				$format = 'j' . $FORMAT . 'm' . $FORMAT . 'Y H:i:s';
			}
		}
		$dt = self::getConvertedDateTimeObject($DATE, $setTimezone);
		return $dt->format($format);
	}
	public function countDownClock($timestamp, $TIMEZONE = '')
	{
		if($TIMEZONE !='')
		{
			$setTimezone = $TIMEZONE;
		}else{
			$setTimezone = $this->SETTINGS['timezone'];
		}
		$dt = self::getConvertedDateTimeObject($timestamp, $setTimezone);
		return $dt->format('m/d/Y H:i:s');
	}
	public function GetLeftSeconds()
	{
		$today = explode('|', date('j|n|Y|G|i|s'));
		$month = $today[1];
		$mday = $today[0];
		$year = $today[2];
		$lday = 31;
		// Calculate last day
		while (!checkdate($month, $lday, $year))
		{
			$lday--;
		}
		// Days left t the end of the month
		$daysleft = intval($lday - date('d'));
		$hoursleft = 24 - $today[3];
		$minsleft = 60 - $today[4];
		$secsleft = 60 - $today[5];
		$left = $secsleft + ($minsleft * 60) + ($hoursleft * 3600) + ($daysleft * 86400);
		return $left;
	}
	public function formatTimeLeft($diff)
	{
		global $MSG;
		$days_difference = floor($diff / 86400);
		$difference = $diff % 86400;
		$hours_difference = floor($difference / 3600);
		$difference = $difference % 3600;
		$minutes_difference = floor($difference / 60);
		$seconds_difference = $difference % 60;
		$secshow = false;
		$timeleft = '';
		if ($days_difference > 0)
		{
			$timeleft = $days_difference . 'd ';
		}
		if ($hours_difference > 0)
		{
			$timeleft .= $hours_difference . 'h ';
		}
		else
		{
			$secshow = true;
		}
		if ($diff > 60)
		{
			$timeleft .= $minutes_difference . 'm ';
		}
		elseif ($diff > 60 && !$seconds)
		{
			$timeleft = '<1m';
		}
		if ($secshow)
		{
			$timeleft .= $seconds_difference . 's ';
		}
		if ($diff < 0)
		{
			$timeleft = $MSG['911'];
		}
		if (($diff * 60) < 15)
		{
			$timeleft = '<span style="color:#FF0000;">' . $timeleft . '</span>';
		}
		return $timeleft;
	}
	private function checkDurationIfItIsMonths($duration)
	{
		$durationArray = array(30 => 1, 60 => 2, 90 => 3, 120 => 4, 150 => 5, 180 => 6, 210 => 7, 240 => 8, 270 => 9, 300 => 10, 330 => 11);
		if(array_key_exists($duration, $durationArray)) {
			$newDuration = $durationArray[$duration];
		}else{
			$newDuration = 0;
		}
		return $newDuration;
	}
	private function checkDurationIfItIsYears($duration)
	{
		$durationArray = array(365 => 1, 730 => 2, 1460 => 3, 1825 => 4, 2190 => 5);
		if(array_key_exists($duration, $durationArray)) {
			$newDuration = $durationArray[$duration];
		}else{
			$newDuration = 0;
		}
		return $newDuration;
	}
	private function getConvertedAuctionDateTimeObject($timeStamp, $duration)
	{
		$monthsDuration = self::checkDurationIfItIsMonths($duration); // fixing the duration for months
		$yearsDuration = self::checkDurationIfItIsYears($duration); // fixing the duration for years
		# create auction timezone objects and also making sure all auctions use the default timezone
		$DefaultTimeZone = new DateTimeZone($this->SETTINGS['timezone']);
		$date = DateTime::createFromFormat('U', $timeStamp, $DefaultTimeZone);
		
		// checking the duration to run the correct modify for day, days, month, months, year and years
		if($duration == 1) {
			$date->modify('+1 day');
		}elseif($duration > 1 && $duration < 30) {
			$date->modify('+' . $duration . ' days');
		}elseif($monthsDuration == 1) {
			$date->modify('+1 month');
		}elseif($monthsDuration > 1) {
			$date->modify('+' . $monthsDuration . ' months');
		}elseif($yearsDuration == 1) {
			$date->modify('+1 year');
		}elseif($yearsDuration > 1) {
			$date->modify('+' . $yearsDuration . ' years');
		}
		return $date;
	}
	private function getConvertedTimeObject($timeStamp, $duration, $math, $type)
	{
		$toZone = new DateTimeZone($this->SETTINGS['timezone']);
		$DefaultTimeZone = new DateTimeZone($this->SETTINGS['timezone']);
		$date = DateTime::createFromFormat('U', $timeStamp, $DefaultTimeZone);
		$date->modify($math . $duration . ' ' . $type);
		$date->setTimezone($toZone);
		return $date;
	}
	private function getConvertedDateTimeObject($timeStamp, $userTimeZone = '')
	{
		# create server and user timezone objects
		if($userTimeZone !='')
		{
			$userZone = $userTimeZone;
		}else{
			$userZone = $this->SETTINGS['timezone'];
		}
		$toZone = new DateTimeZone($userZone);
		$DefaultTimeZone = new DateTimeZone($this->SETTINGS['timezone']);
		$date = DateTime::createFromFormat('U', $timeStamp, $DefaultTimeZone);
		$date->setTimezone($toZone);
		return $date;
	}
	public function getUserTimestamp($timeStamp, $userTimeZone = '')
	{
		$dt = self::getConvertedDateTimeObject($timeStamp, $userTimeZone);
		$dt->getTimestamp();
		return $dt->format('U');
	}
	public function getUserOffset($timeStamp, $userTimeZone  = '')
	{
		$dt = self::getConvertedDateTimeObject($timeStamp, $userTimeZone);
		$dt->getOffset();
		return $dt->format('U');
	}
	public function ConvertedAuctionDateTimeObject($timestamp, $duration)
	{
		$dt = self::getConvertedAuctionDateTimeObject($timestamp, $duration);
		$dt->getTimestamp();
		return $dt->format('U');
	}
	
	// The ConvertedTimeObject function so that we can manualy edit the timestamp without making a new function
	// $timestamp  => 1484694269 (Must be unix timestamp)
	// $duration  => 4 (Changing how many years, months, days, minutes or seconds)
	// $math  => + or - (Adding or subtracting the $duration)
	// $type  => years, months, days, minutes or seconds (What we are changing in the timestamp)
	public function ConvertedTimeObject($timestamp, $duration, $math, $type)
	{
		$dt = self::getConvertedTimeObject($timestamp, $duration, $math, $type);
		return $dt->getTimestamp();
	}
}