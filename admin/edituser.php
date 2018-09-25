<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include INCLUDE_PATH . 'countries.inc.php';

unset($ERROR);
$userid = intval($_REQUEST['userid']);

// Data check
if (empty($userid) || $userid <= 0)
{
	header('location: listusers.php?PAGE=' . intval($_GET['offset']));
	exit;
}

// Retrieve users signup settings
$MANDATORY_FIELDS = unserialize($system->SETTINGS['mandatory_fields']);

if (isset($_POST['admin']) && $_POST['admin'] == 'sub')
{
	$query = "UPDATE " . $DBPrefix . "users SET admin = '1' WHERE id = :i";
	$params = array();
	$params[] = array(':i', $userid, 'int');
	$db->query($query, $params);
	header('location: edituser.php?userid=' . $userid .'&offset=' . intval($_POST['offset']));
	exit;
}
elseif (isset($_POST['admin']) && $_POST['admin'] == 'main')
{
	$query = "UPDATE " . $DBPrefix . "users SET admin = :a WHERE id = :i";
	$params = array();
	$params[] = array(':a', 2, 'int');
	$params[] = array(':i', $userid, 'int');
	$db->query($query, $params);
	header('location: edituser.php?userid=' . $userid .'&offset=' . intval($_POST['offset']));
	exit;
}
elseif (isset($_POST['admin']) && $_POST['admin'] == 'normal')
{
	$query = "UPDATE " . $DBPrefix . "users SET admin = :a WHERE id = :i";
	$params = array();
	$params[] = array(':a', 0, 'int');
	$params[] = array(':i', $userid, 'int');
	$db->query($query, $params);
	header('location: edituser.php?userid=' . $userid .'&offset=' . intval($_POST['offset']));
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if ($_POST['name'] && $_POST['email'])
	{
		if (!empty($_POST['birthdate']))
		{
			$DATE = explode('/', $_POST['birthdate']);
			if ($system->SETTINGS['datesformat'] == 'USA')
			{
				$birth_day = $DATE[1];
				$birth_month = $DATE[0];
				$birth_year = $DATE[2];
			}
			else
			{
				$birth_day = $DATE[0];
				$birth_month = $DATE[1];
				$birth_year = $DATE[2];
			}

			if (strlen($birth_year) == 2)
			{
				$birth_year = '19' . $birth_year;
			}
		}

		if (strlen($_POST['password']) > 0 && ($_POST['password'] != $_POST['repeat_password']))
		{
			$ERROR = $ERR['006'];
		}
		elseif (strlen($_POST['email']) < 5) //Primitive mail check
		{
			$ERROR = $ERR['110'];
		}
		elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['email']))
		{
			$ERROR = $ERR['008'];
		}
		elseif (!preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{2,4})$/', $_POST['birthdate']) && $MANDATORY_FIELDS['birthdate'] == 'y')
		{ //Birthdate check
			$ERROR = $ERR['043'];
		}
		elseif (strlen($_POST['zip']) < 4 && $MANDATORY_FIELDS['zip'] == 'y')
		{ //Primitive zip check
			$ERROR = $ERR['616'];
		}
		elseif (strlen($_POST['phone']) < 3 && $MANDATORY_FIELDS['tel'] == 'y')
		{ //Primitive phone check
			$ERROR = $ERR['617'];
		}
		elseif (empty($_POST['address']) && $MANDATORY_FIELDS['address'] == 'y')
		{
			$ERROR = $ERR['5034'];
		}
		elseif (empty($_POST['city']) && $MANDATORY_FIELDS['city'] == 'y')
		{
			$ERROR = $ERR['5035'];
		}
		elseif (empty($_POST['prov']) && $MANDATORY_FIELDS['prov'] == 'y')
		{
			$ERROR = $ERR['5036'];
		}
		elseif (empty($_POST['country']) && $MANDATORY_FIELDS['country'] == 'y')
		{
			$ERROR = $ERR['5037'];
		}
		elseif (count($_POST['group']) == 0)
		{
			$ERROR = $ERR['044'];
		}
		else
		{
			if (!empty($_POST['birthdate']))
			{
				$birthdate = $birth_year . $birth_month . $birth_day;
			}
			else
			{
				$birthdate = 0;
			}
			
			if($system->SETTINGS['fee_max_debt'] <= -1 * $_POST['balance'])
			{
				$suspend = 7;
			}
			else
			{
				$suspend = 0;
			}
			
			$query = "UPDATE " . $DBPrefix . "users SET 
			name = :user_name, email = :user_email, address = :user_address, city = :user_city, prov = :user_prov, 
			country = :user_country, zip = :user_zip, phone = :user_phone, birthdate = :user_birthdate, 
			groups = :user_group,suspended = :user_suspend, balance = :user_balance";
			$params = array();
			$params[] = array(':user_name', $system->cleanvars($_POST['name']), 'str');
			$params[] = array(':user_email', $system->cleanvars($_POST['email']), 'str');
			$params[] = array(':user_address', $system->cleanvars($_POST['address']), 'str');
			$params[] = array(':user_city', $system->cleanvars($_POST['city']), 'str');
			$params[] = array(':user_prov', $system->cleanvars($_POST['prov']), 'str');
			$params[] = array(':user_country', $system->cleanvars($_POST['country']), 'str');
			$params[] = array(':user_zip', $system->cleanvars($_POST['zip']), 'str');
			$params[] = array(':user_phone', $system->cleanvars($_POST['phone']), 'str');
			$params[] = array(':user_birthdate', $system->cleanvars($birthdate), 'str');
			$params[] = array(':user_group', implode(',', $_POST['group']), 'str');
			$params[] = array(':user_suspend', $suspend, 'int');
			$params[] = array(':user_balance', $_POST['balance'], 'str');
			
			if ($system->SETTINGS['fee_max_debt'] <= (-1 * $_POST['balance']) && $_POST['email_sent'] == 'y')
			{
				//this will let the system resend the payment reminder email when the user logs in
				$query .=  ", payment_reminder_sent = :user_payment_reminder"; 
				$params[] = array(':user_payment_reminder', 'n', 'bool');
			}
			if (strlen($_POST['password']) > 0)
			{
				$hashed_password = $phpass->HashPassword($_POST['password']);
				$query .=  ", password = :hashed_password";
				$params[] = array(':hashed_password', $hashed_password, 'str');
			}
			$query .=  " WHERE id = :user_id";
			$params[] = array(':user_id', $userid, 'int');
			$db->query($query, $params);
			//header('location: listusers.php?PAGE=' . intval($_POST['offset']));
			//exit;
		}
	}
	else
	{
		$ERROR = $ERR['112'];
	}
}

// load the page
$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :user_id";
$params = array();
$params[] = array(':user_id', $userid, 'int');
$db->query($query, $params);
$user_data = $db->result();

if ($user_data['birthdate'] != 0)
{
	$birth_day = substr($user_data['birthdate'], 6, 2);
	$birth_month = substr($user_data['birthdate'], 4, 2);
	$birth_year = substr($user_data['birthdate'], 0, 4);

	if ($system->SETTINGS['datesformat'] == 'USA')
	{
		$birthdate = $birth_month . '/' . $birth_day . '/' . $birth_year;
	}
	else
	{
		$birthdate = $birth_day . '/' . $birth_month . '/' . $birth_year;
	}
}
else
{
	$birthdate = '';
}

$country_list = '';
foreach ($countries as $code => $descr)
{
	$country_list .= '<option value="' . $descr . '"';
	if ($descr == $user_data['country'])
	{
		$country_list .= ' selected';
	}
	$country_list .= '>' . $descr . '</option>' . "\n";
}

$query = "SELECT id, group_name FROM ". $DBPrefix . "groups";
$db->direct_query($query);
$usergroups = '';
$groups = explode(',', $user_data['user_groups']);
while ($row = $db->result())
{
	$member = (in_array($row['id'], $groups)) ? ' checked' : '';
	$usergroups .= '<p><input type="checkbox" name="group[]" value="' . $row['id'] . '"' . $member . '> ' . $row['group_name'] . '</p>';
}

$template->assign_vars(array(
		'ERROR' => (isset($ERROR)) ? $ERROR : '',
		'REALNAME' => $user_data['name'],
		'USERNAME' => $user_data['nick'],
		'EMAIL' => $user_data['email'],
		'ADDRESS' => $user_data['address'],
		'CITY' => $user_data['city'],
		'PROV' => $user_data['prov'],
		'ZIP' => $user_data['zip'],
		'COUNTRY' => $user_data['country'],
		'PHONE' => $user_data['phone'],
		'BALANCE' => $user_data['balance'],
		'DOB' => $birthdate,
		'COUNTRY_LIST' => $country_list,
		'ID' => $userid,
		'EMAIL_SENT' => $user_data['payment_reminder_sent'],
		'PAGENAME' => $MSG['511'],
		'PAGETITLE' => $MSG['511'],
		'OFFSET' => $_GET['offset'],
		'USERGROUPS' => $usergroups,
		'B_SUB_ADMIN' => $user_data['admin'] == 0,
		'B_MAIN_ADMIN' => $user_data['admin'] == 0,
		'B_UPGRADE_ADMIN' => $user_data['admin'] == 1,
		'B_UPGRADE_NORMAL' => $user_data['admin'] == 1 || $user_data['admin'] == 2,
		'REQUIRED' => array(
					($MANDATORY_FIELDS['birthdate'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['address'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['city'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['prov'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['country'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['zip'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['tel'] == 'y') ? ' *' : ''
					)
		));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'edituser.tpl'
		));
$template->display('body');
include 'adminFooter.php';