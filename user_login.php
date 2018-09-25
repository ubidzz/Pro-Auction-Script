<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/

define('AtLogin', 1);
include 'common.php';

if(isset($_GET['facebook']) && $_GET['facebook'] == 'login')

{
	$facebookAPP->connectToFacebook();
}

if (isset($_POST['action']) && isset($_POST['username']) && isset($_POST['password']))
{
	if (filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) 
	{
		$query = "SELECT * FROM " . $DBPrefix . "users WHERE email = :check_nick";
	} else {
		$query = "SELECT * FROM " . $DBPrefix . "users WHERE nick = :check_nick";
	}
	
	$params = array(
		array(':check_nick', $_POST['username'], 'str'),
	);
	$db->query($query, $params);

	$user_data = $db->result();

	if ($phpass->CheckPassword($_POST['password'], $user_data['password']))
	{
		//get server time
		$NOW = $system->CTIME;
		// create a new key every time a user login
		$user_key = base64_encode($security->genRandString(32));
		//generator user token
		$_SESSION['csrftoken'] = $security->encrypt($user_key);

		if ($user_data['suspended'] == 9)
		{
			$_SESSION['signup_id'] = $user_data['id'];
			header('location: pay.php?a=3');
			exit;
		}
		elseif ($user_data['suspended'] == 1)
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
		else
		{
			$_SESSION[$system->SETTINGS['sessionsname'] . '_LOGGED_IN'] 		= $security->encrypt($user_data['id']);
			$_SESSION[$system->SETTINGS['sessionsname'] . '_LOGGED_NUMBER'] 	= $security->encrypt(strspn($user_data['password'], $user_data['hash']));
			$_SESSION[$system->SETTINGS['sessionsname'] . '_LOGGED_PASS'] 		= $security->encrypt($user_data['password']);

			// Update "last login" fields in users table
			$query = "UPDATE " . $DBPrefix . "users SET lastlogin = :date, user_key = :key WHERE id = :user_id";
			$params = array(
				array(':date', $system->ArrangeDateAndTime($NOW), 'str'),
				array(':key', $user_key, 'str'),
				array(':user_id', $user_data['id'], 'int')
			);
			$db->query($query, $params);

			// Remember me option
			if (isset($_POST['rememberme']))
			{
				$remember_key = md5($NOW);
				$query = "INSERT INTO " . $DBPrefix . "rememberme VALUES (:user_id, :remember_key)";
				$params = array(
					array(':remember_key', $remember_key, 'str'),
					array(':user_id', $user_data['id'], 'int')
				);
				$db->query($query, $params);
				
				//build the remember me cookie
				$system->buildCookie($system->SETTINGS['cookiesname'] . '-RM_ID', $MSG['25_0085'], $NOW + (3600 * 24 * 365));
			}

			$query = "SELECT id FROM " . $DBPrefix . "usersips WHERE USER = :user_id AND ip = :user_ip";
			$params = array(
				array(':user_ip', $_SERVER['REMOTE_ADDR'], 'str'),
				array(':user_id', $user_data['id'], 'int')
			);
			$db->query($query, $params);
			
			if ($db->numrows() == 0)
			{
				$query = "INSERT INTO " . $DBPrefix . "usersips VALUES (NULL, :user_id, :user_ip, 'after','accept')";
				$params = array(
					array(':user_ip', $_SERVER['REMOTE_ADDR'], 'str'),
					array(':user_id', $user_data['id'], 'int')
				);
				$db->query($query, $params);
			}
				
			if (isset($_POST['hideOnline']))
			{
				$query = "UPDATE " . $DBPrefix . "users SET hideOnline = 'y' WHERE id = :user_id";
				$params = array(
					array(':user_id', $user_data['id'], 'int')
				);
				$db->query($query, $params);
			}
			else
			{
				$query = "UPDATE " . $DBPrefix . "users SET hideOnline = 'n' WHERE id = :user_id";
				$params = array(
					array(':user_id', $user_data['id'], 'int')
				);
				$db->query($query, $params);
			}
			
			// delete your old session
			if (isset($_COOKIE[$system->SETTINGS['cookiesname'] . '-ONLINE']))
			{
				$query = "DELETE from " . $DBPrefix . "online WHERE SESSION = :SESSION";
				$params = array(
					array(':SESSION', alphanumeric($_COOKIE[$system->SETTINGS['cookiesname'] . '-ONLINE']), 'str')
				);
				$db->query($query, $params);
			}

			if (in_array($user_data['suspended'], array(5, 6, 7)))
			{
				$_SESSION['msg_title'] = $MSG['753'];
				$URL = $system->SETTINGS['siteurl'] . 'message.php';
			}
			elseif (isset($_SESSION['REDIRECT_AFTER_LOGIN']))
			{
				$URL = str_replace('\r', '', str_replace('\n', '', $_SESSION['REDIRECT_AFTER_LOGIN']));
				unset($_SESSION['REDIRECT_AFTER_LOGIN']);
			}
			else
			{
				$URL = $system->SETTINGS['siteurl'] . 'home';
			}
			header('location: ' . $URL);
			exit;
		}
	}
	else
	{
		$ERROR = $ERR['038'];
	}
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'B_FB_LINK' => 'facebookLogin',
	'USER' => (isset($_POST['username'])) ? $_POST['username'] : ''
));

include 'header.php';
$template->set_filenames(array(
		'body' => 'user_login.tpl'
		));
$template->display('body');
include 'footer.php';

