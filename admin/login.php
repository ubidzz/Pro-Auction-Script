<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: http://www.Pro-Auction-Script.com
 *******************************************************************************/

define('InAdmin', 1);
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';

//Checking to see if the Admin is already logged in
if (!checkAdminLoginSession())
{
	header("location: index.php");
	exit;
}

if (isset($_POST['action']))
{
	switch ($_POST['action'])
	{
		case 'insert': //add new admin account
			// Additional security check
			$query = "SELECT id FROM " . $DBPrefix . "adminusers";
			$db->direct_query($query);
			if ($db->numrows() > 0)
			{
				header('location: login.php');
				exit;
			}
			$admin_password = $phpass->HashPassword($_POST['password']);
			$query = "INSERT INTO " . $DBPrefix . "adminusers VALUES (NULL, :user, :pass, :hash, :create, :login, :s, NULL)";
			$params = array();
			$params[] = array(':user', $system->cleanvars($_POST['username']), 'str');
			$params[] = array(':pass', $admin_password, 'str');
			$params[] = array(':hash', get_hash(), 'str');
			$params[] = array(':create', date('Ymd'), 'int');
			$params[] = array(':login', $system->CTIME, 'int');
			$params[] = array(':s', 1, 'int');
			$db->query($query, $params);
			$admin_id = $db->lastInsertId();
			
			//checking to see if the admin user was added and if it did now make the normail user account
			if (isset($admin_id))
			{
				if(empty($_POST['noUser']))
				{
					$pass_word = (isset($_POST['pass_word'])) ? $_POST['pass_word'] : $_POST['password'];
					$query = "SELECT id FROM " . $DBPrefix . "groups WHERE auto_join = :j";
					$params = array();
					$params[] = array(':j', 1, 'int');
					$db->query($query, $params);
					$groups = array();
					while ($gid = $db->result('id'))
					{
							$groups[] = $gid;
					}
					$hashed_pass_word = $phpass->HashPassword($pass_word);
					$query = "INSERT INTO " . $DBPrefix . "users (nick, password, hash, name, admin, groups, reg_date, emailtype, startemailmode, endemailmode, nletter, email, language, rate_sum, rate_num, suspended, bn_only, timezone) VALUES 
					('" . $_POST['user_name'] . "', '" . $hashed_pass_word . "', '" . get_hash() . "', '" . $_POST['full_name'] . "', 2, '" . implode(',', $groups) . "', '" . $system->CTIME . "', 'html', 'yes', 'one', 1, '" . $_POST['email'] . "', '" . $system->SETTINGS['defaultlanguage'] . "', 0, 0, 0, 'y', 'America/New_York')";
					$db->direct_query($query);
				}
			}
			// Redirect
			header('location: login.php');
			exit;
		break;

		case 'login':
			if (strlen($_POST['username']) == 0 || strlen($_POST['password']) == 0)
			{
				$ERROR = $ERR['047'];
			}
			elseif (!preg_match('([a-zA-Z0-9]*)', $_POST['username']))
			{
				$ERROR = $ERR['071'];
			}
			else
			{
				$query = "SELECT id, password, hash FROM " . $DBPrefix . "adminusers WHERE username = :user_name";
				$params = array();
				$params[] = array(':user_name', $system->cleanvars($_POST['username']), 'str');
				$db->query($query, $params);
				
				// generate a random unguessable token
				$admin = $db->result();
				if($phpass->CheckPassword($_POST['password'], $admin['password']))
				{
					// Set sessions vars
					$_SESSION['admincsrftoken'] = $security->encrypt($security->genRandString(32));
					$_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_NUMBER'] = $security->encrypt(strspn($admin['password'], $admin['hash']));
					$_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_PASS'] = $security->encrypt($admin['password']);
					$_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_IN'] = $security->encrypt($admin['id']);
					$_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_USER'] = $security->encrypt($_POST['username']);
					$_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_TIME'] = $security->encrypt($system->CTIME);
					// Update last login information for this user
					$query = "UPDATE " . $DBPrefix . "adminusers SET lastlogin = :timer WHERE id = :user_id";
					$params = array();
					$params[] = array(':timer', $system->CTIME, 'int');
					$params[] = array(':user_id', $admin['id'], 'int');
					$db->query($query, $params);
					//print_r($security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_IN']));
					// Redirect
					print '<script type="text/javascript">parent.location.href = \'index.php\';</script>';
					exit;
				}
				else
				{
					$ERROR = $ERR['048'];
				}
			}
		break;
	}
}

$query = "SELECT id FROM " . $DBPrefix . "adminusers LIMIT :setlimit";
$params = array();
$params[] = array(':setlimit', 1, 'int');
$db->query($query, $params);
$countDB = $db->numrows();
$template->assign_vars(array(
		'ERROR' => (isset($ERROR)) ? $ERROR : '',
		'FLAGS' => ShowFlags(false,true),
		'B_MULT_LANGS' => (count($LANGUAGES) > 1),
		'SITEURL' => $system->SETTINGS['siteurl'],
		'THEME' => $system->SETTINGS['theme'],
		'PAGE' => $countDB == 0 ? 1 : 2,
		'LANGUAGE' => $language,
		'DOCDIR' => $DOCDIR, // Set document direction (set in includes/messages.XX.inc.php) ltr/rtl
		'ADMIN_THEME' => $system->SETTINGS['admin_theme'],
		'FAVICON' => 'uploaded/logos/favicon/' . $system->SETTINGS['favicon'],
		'CHARSET' => $CHARSET,
));
$template->set_filenames(array(
		'body' => 'login.tpl'
		));
$template->display('body'); 
