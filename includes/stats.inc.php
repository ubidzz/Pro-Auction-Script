<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
 
if (!defined('InProAuctionScript')) exit('Access denied');

include PLUGIN_PATH . 'useragent/useragent.inc.php';

// Retrieve stats settings
$STATSSETTINGS = $system->loadTable('statssettings');

$THISDAY	= date('d');
$THISMONTH	= date('m');
$THISYEAR	= date('Y');

if ($STATSSETTINGS['activate'] == 'y')
{
	// Users accesses
	if ($STATSSETTINGS['accesses'] == 'y')
	{		
		// check cookies and session vars
		if (isset($_SESSION['USER_STATS_SESSION']))
		{
			$UPDATESESSION = FALSE;
		}
		else
		{
			$USER_STATS_SESSION = $system->CTIME;
			$_SESSION['USER_STATS_SESSION'] = $USER_STATS_SESSION;
			$UPDATESESSION = TRUE;
		}
		
		// check cookies and session vars
		if (isset($_COOKIE[$system->SETTINGS['cookiesname'] . '-UNIQUEUSER']))
		{
			$UPDATECOOKIE = FALSE;
		}
		else
		{		
			$exp = $system->GetLeftSeconds(); // Get left seconds to the end of the month
			$cookie_name = $system->SETTINGS['cookiesname'] . '-UNIQUEUSER';
			$cookie_hash = md5(rand(0, 99) . session_id());
			$cookie_time = time() + $exp;
			$system->buildCookie($cookie_name, $cookie_hash, $cookie_time);
			$UPDATECOOKIE = TRUE;
		}
		
		$query = "SELECT day, month FROM " . $DBPrefix . "currentaccesses WHERE day = :THISDAY AND month = :THISMONTH";
		$params = array();
		$params[] = array(':THISDAY', $THISDAY, 'int');
		$params[] = array(':THISMONTH', $THISMONTH, 'str');
		$db->query($query, $params);
		if ($db->numrows() == 0)
		{
			$query = "INSERT INTO " . $DBPrefix . "currentaccesses VALUES (:THISDAY, :THISMONTH, :THISYEAR, 0, 0, 0)";
			$params = array();
			$params[] = array(':THISDAY', $THISDAY, 'int');
			$params[] = array(':THISMONTH', $THISMONTH, 'str');
			$params[] = array(':THISYEAR', $THISYEAR, 'int');
			$db->query($query, $params);
		}
		
		$query = "UPDATE " . $DBPrefix . "currentaccesses SET pageviews = pageviews + 1";
		if ($UPDATESESSION)
		{
			$query .= ", usersessions = usersessions + 1";
		}
		if ($UPDATECOOKIE)
		{
			$query .= ", uniquevisitors = uniquevisitors + 1";
		}
		$query .= " WHERE day = :THISDAY AND month = :THISMONTH AND year = :THISYEAR";
		$params = array();
		$params[] = array(':THISDAY', $THISDAY, 'int');
		$params[] = array(':THISMONTH', $THISMONTH, 'str');
		$params[] = array(':THISYEAR', $THISYEAR, 'int');
		$db->query($query, $params);
		// End users accesses
	}

	// Get user's agent and platform
	$browser_info = browser_detection('full');
	$browser_info[] = browser_detection('moz_version');
	//var_dump($browser_info);

	$os = '';
	switch ($browser_info[5])
	{
		case 'win':
			$os .= 'Windows ';
			break;
		case 'nt':
			$os .= 'Windows NT ';
			break;
		case 'linux':
			$os .= 'Linux ';
			break;
		case 'mac':
			$os .= 'Mac ';
			break;
		case 'unix':
			$os .= 'Unix Version: ';
			break;
		default:
			$os .= $browser_info[5];
	}
	
	if ($browser_info[5] == 'nt')
	{
		if ($browser_info[6] == '5')
		{
			$os .= '5.0 (Windows 2000)';
		}
		elseif ($browser_info[6] == '5.1')
		{
			$os .= '5.1 (Windows XP or Windows Server 2003)';
		}
		elseif ($browser_info[6] == '5.2')
		{
			$os .= '5.2 (Windows XP Professional x64 or Windows Server 2003 R2)';
		}
		elseif ($browser_info[6] == '6.0')
		{
			$os .= '6.0 (Windows Vista or Windows Server 2008)';
		}
		elseif ($browser_info[6] == '6.1')
		{
			$os .= '6.1 (Windows 7, Windows Server 2008 R2 or Windows Home Server 2011)';
		}
		elseif ($browser_info[6] == '6.2')
		{
			$os .= '6.2 (Windows 8 or Windows Server 2012)';
		}
		elseif ($browser_info[6] == '6.3')
		{
			$os .= '6.3 (Windows 8.1 or Windows Server 2012 R2)';
		}
		elseif ($browser_info[6] == '10.0')
		{
			$os .= '10.0 (Windows 10 or Windows Server 2016)';
		}
		elseif ($browser_info[6] == '')
		{
			$os .= ' (Unknown Windows)';
		}
	}
	elseif (($browser_info[5] == 'mac'))
	{
		$os .=  'Mac' . $browser_info[6];
	}
	elseif ($browser_info[5] == 'linux')
	{
		$os .= ( $browser_info[6] != '' ) ? 'Distro: ' . ucfirst ($browser_info[6] ) : 'Smart Move!!!';
	}
	elseif ($browser_info[5] == 'lin')
	{
		$os .= ( $browser_info[6] != '' ) ? 'Distro: ' . ucfirst ($browser_info[6] ) : 'Smart Move!!!';
	}
	elseif ($browser_info[6] == '')
	{
		$os .=  ' (version unknown)';
	}
	else
	{
		$os .=  strtoupper( $browser_info[6] );
	}
	
	$browser = '';
	if ($browser_info[0] == 'moz')
	{
		$a_temp = $browser_info[count($browser_info) - 1]; // use the last item in array, the moz array
		$browser .= ($a_temp[0] != 'mozilla') ? 'Mozilla/ ' . ucfirst($a_temp[0]) . ' ' : ucfirst($a_temp[0]) . ' ';
		$browser .= $a_temp[1];
		/* not really needed in this much detail
		$browser .= 'ProductSub: ';
		$browser .= ($a_temp[4] != '') ? $a_temp[4] . '<br />' : 'Not Available<br />';
		$browser .= ($a_temp[0] != 'galeon') ? 'Engine: Gecko RV: ' . $a_temp[3] : ''; */
	}
	elseif ($browser_info[0] == 'ns')
	{
		$browser .= 'Netscape ' . $browser_info[1];
	}
	elseif ($browser_info[0] == 'webkit')
	{
		$browser .= 'User Agent: ';
		$browser .= ucwords($browser_info[7]);
		$browser .= '<br />Engine: AppleWebKit ';
		$browser .= ($browser_info[1]) ? $browser_info[1] : 'Not Available';
	}
	else
	{
		$browser .= ($browser_info[0] == 'ie') ? strtoupper($browser_info[7]) : ucwords($browser_info[7]);
		$browser .= ' ' . $browser_info[1];
	}
	//we don't want to count the bots as normal person
	if($browser_info[8] == 'bot')
	{
		$bot = false;
	}
	else
	{
		$bot = true;
	}
	if ($STATSSETTINGS['browsers'] == 'y' && $UPDATECOOKIE)
	{
		if($bot == true) //the person is not a bot
		{
			// Update the browser stats
			$query = "SELECT month FROM " . $DBPrefix . "currentbrowsers WHERE month = :THISMONTH AND year = :THISYEAR AND browser = :browser";
			$params = array();
			$params[] = array(':THISMONTH', $THISMONTH, 'str');
			$params[] = array(':THISYEAR', $THISYEAR, 'int');
			$params[] = array(':browser', $browser, 'str');
			$db->query($query, $params);
			if ($db->numrows('month') == 0)
			{
				$query = "INSERT INTO " . $DBPrefix . "currentbrowsers VALUES (:THISMONTH, :THISYEAR, :browser, 1)";
				$params = array();
				$params[] = array(':THISMONTH', $THISMONTH, 'str');
				$params[] = array(':THISYEAR', $THISYEAR, 'int');
				$params[] = array(':browser', $browser, 'str');
				$db->query($query, $params);
			}
			else
			{
				$query = "UPDATE " . $DBPrefix . "currentbrowsers SET counter = counter + 1
					WHERE browser = :browser AND month = :THISMONTH AND year = :THISYEAR";
				$params = array();
				$params[] = array(':browser', $browser, 'str');
				$params[] = array(':THISMONTH', $THISMONTH, 'str');
				$params[] = array(':THISYEAR', $THISYEAR, 'int');
				$db->query($query, $params);
			}
			
			// Update the platfom stats
			$query = "SELECT month FROM " . $DBPrefix . "currentplatforms WHERE month = :THISMONTH AND year = :THISYEAR AND platform = :OS";
			$params = array();
			$params[] = array(':THISMONTH', $THISMONTH, 'str');
			$params[] = array(':THISYEAR', $THISYEAR, 'int');
			$params[] = array(':OS', $os, 'str');
			$db->query($query, $params);
			if ($db->numrows('month') == 0)
			{
				$query = "INSERT INTO " . $DBPrefix . "currentplatforms VALUES (:THISMONTH, :THISYEAR, :OS, 1)";
				$params = array();
				$params[] = array(':THISMONTH', $THISMONTH, 'str');
				$params[] = array(':THISYEAR', $THISYEAR, 'int');
				$params[] = array(':OS', $os, 'str');
				$db->query($query, $params);
			}
			else
			{
				$query = "UPDATE " . $DBPrefix . "currentplatforms SET counter = counter + 1
					WHERE platform = :OS AND month = :THISMONTH AND year = :THISYEAR";
				$params = array();
				$params[] = array(':OS', $os, 'str');
				$params[] = array(':THISMONTH', $THISMONTH, 'str');
				$params[] = array(':THISYEAR', $THISYEAR, 'int');
				$db->query($query, $params);
			}
		}
		elseif ($bot == false) //adding the bot
		{
			// Update the bot stats
			$query = "SELECT month FROM " . $DBPrefix . "currentbots WHERE month = :THISMONTH AND year = :THISYEAR AND browser = :browser AND platform = :OS";
			$params = array();
			$params[] = array(':THISMONTH', $THISMONTH, 'str');
			$params[] = array(':THISYEAR', $THISYEAR, 'int');
			$params[] = array(':browser', $browser, 'str');
			$params[] = array(':OS', $os, 'str');
			$db->query($query, $params);
			if ($db->numrows('month') == 0)
			{
				$query = "INSERT INTO " . $DBPrefix . "currentbots VALUES (:THISMONTH, :THISYEAR, :OS, :browser, 1)";
				$params = array();
				$params[] = array(':THISMONTH', $THISMONTH, 'str');
				$params[] = array(':THISYEAR', $THISYEAR, 'int');
				$params[] = array(':browser', $browser, 'str');
				$params[] = array(':OS', $os, 'str');
				$db->query($query, $params);
			}
			else
			{
				$query = "UPDATE " . $DBPrefix . "currentbots SET counter = counter + 1
					WHERE browser = :browser AND platform = :OS AND month = :THISMONTH AND year = :THISYEAR";
				$params = array();
				$params[] = array(':OS', $os, 'str');
				$params[] = array(':browser', $browser, 'str');
				$params[] = array(':THISMONTH', $THISMONTH, 'str');
				$params[] = array(':THISYEAR', $THISYEAR, 'int');
				$db->query($query, $params);
			}
		}
	}
}
?>