<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/

include 'common.php';

$getInfo = (isset($_GET['id'])) ? explode('-', $security->decrypt($_GET['id'])) : '';

$id = (isset($getInfo[0])) ? $getInfo[0] : '';
$id = (isset($_POST['id'])) ? $security->decrypt($_POST['id']) : $id;
$hash = (isset($getInfo[1])) ? $getInfo[1] : '';
$hash = (isset($_POST['hash'])) ? $_POST['hash'] : $hash;

if (!$id && !isset($_POST['action']))
{
	$errmsg = $ERR['025'];
	$page = 'invalid';
}else{
	$query = "SELECT suspended, nick FROM " . $DBPrefix . "users WHERE id = :id";
	$params = array(
		array(':id', $id, 'int')
	);
	$db->query($query, $params);
	$data = $db->result();
	
	if ($id !='' && !isset($_POST['action']))
	{
		if ($db->numrows('id') == 0)
		{
			$errmsg = $ERR['025'];
		}
		elseif (!isset($hash) || md5($MD5_PREFIX . $system->uncleanvars($data['nick'])) != $hash)
		{
			$errmsg = $ERR['033'];
		}
		elseif ($data['suspended'] == 0)
		{
			$errmsg = $ERR['039'];
		}
		elseif ($data['suspended'] == 2)
		{
			$errmsg = $ERR['039'];
		}
		if (isset($errmsg))
		{
			$page = 'invalid';
		}
		else
		{
			$page = 'confirm'; 
		}
	}
	
	if (isset($_POST['action']) && $_POST['action'] == 'confirm')
	{	
		if (md5($MD5_PREFIX . $data['nick']) == $hash)
		{
			// User wants to confirm his/her registration
			$query = "UPDATE " . $DBPrefix . "users SET suspended = 0 WHERE id = :id AND suspended = 8";
			$params = array(
				array(':id', $id, 'int')
			);
			$db->query($query, $params);
	
			$system->writesetting("counters", "users", $system->COUNTERS['users'] + 1, 'int');
			$system->writesetting("counters", "inactiveusers", $system->COUNTERS['inactiveusers'] - 1, 'int');
	
			// login user
			$query = "SELECT id, hash, password FROM " . $DBPrefix . "users WHERE id = :id";
			$params = array(
				array(':id', $id, 'int')
			);
			$db->query($query, $params);
			if ($db->numrows('id') > 0)
			{	
				$page = 'confirmed';
				$login_user = $db->result();
				//generator user token
				$user_key = $security->genRandString(32);
				$_SESSION['csrftoken'] = $security->encrypt($user_key);
				$_SESSION[$system->SETTINGS['sessionsname'] . '_LOGGED_IN'] = $security->encrypt($login_user['id']);
				$_SESSION[$system->SETTINGS['sessionsname'] .'_LOGGED_NUMBER'] = $security->encrypt(strspn($login_user['password'], $login_user['hash']));
				$_SESSION[$system->SETTINGS['sessionsname'] . '_LOGGED_PASS'] = $security->encrypt($login_user['password']);
	
				// Update "last login" fields in users table
				$query = "UPDATE " . $DBPrefix . "users SET lastlogin = :lastlogin WHERE id = :user_id";
				$params = array(
					array(':lastlogin', date("Y-m-d H:i:s"), 'str'),
					array(':user_id', $login_user['id'], 'int')
				);
				$db->query($query, $params);
	
				$query = "SELECT id FROM " . $DBPrefix . "usersips WHERE USER = :user_id AND ip = :ip";
				$params = array(
					array(':user_id', $login_user['id'], 'int'),
					array(':ip', $_SERVER['REMOTE_ADDR'], 'int')
				);
				$db->query($query, $params);
				if ($db->numrows('id') == 0)
				{
					$query = "INSERT INTO " . $DBPrefix . "usersips VALUES (NULL, :user_id, :ip, 'after', 'accept')";
					$params = array(
						array(':user_id', $login_user['id'], 'int'),
						array(':ip', $_SERVER['REMOTE_ADDR'], 'int')
					);
					$db->query($query, $params);
				}
			}
		}
		else
		{
			$errmsg = $ERR['033'];
			$page = 'invalid';
		}
	}
	
	if (isset($_POST['action']) && $_POST['action'] == 'delete')
	{
		if (md5($MD5_PREFIX . $data['nick']) == $hash)
		{
			// User doesn't want to confirm hid/her registration
			$query = "DELETE FROM " . $DBPrefix . "users WHERE id = :id AND suspended = 8";
			$params = array(
				array(':id', intval($id), 'int')
			);
			$db->query($query, $params);
			$system->writesetting("counters", "inactiveusers", $system->COUNTERS['inactiveusers'] - 1, 'int');
			$page = 'refused';
		}
		else
		{
			$errmsg = $ERR['033'];
			$page = 'invalid';
		}
	}
}

$template->assign_vars(array(
	'ERROR' => (isset($errmsg)) ? $errmsg : '',
	'USERID' => $security->encrypt($id),
	'HASH' => $hash,
	'PAGE' => $page
));

include 'header.php';
$template->set_filenames(array(
	'body' => 'confirm.tpl'
));
$template->display('body');
include 'footer.php';