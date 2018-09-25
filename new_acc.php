<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

include 'common.php';
include INCLUDE_PATH . 'countries.inc.php';
include INCLUDE_PATH . 'config/timezones.php';
$page_name = $MSG['350_10160'];

$_SESSION['REDIRECT_AFTER_LOGIN'] = 'new_account';

if(isset($_GET['facebook']) && $_GET['facebook'] == 'link' || isset($_POST['fbid']) && $system->SETTINGS['facebook_login'] == 'y') {
	$facebookAPP->connectToFacebook();
}

// check recaptcha is enabled
$spam_html = '';
if ($system->SETTINGS['spam_register'] == 2)
{
	include PLUGIN_PATH . 'captcha/recaptchalib.php';
	$capcha_text = recaptcha_get_html($system->SETTINGS['recaptcha_public']);
	if(isset($_POST["g-recaptcha-response"]))
	{
		$resp = recaptcha_check_answer($system->SETTINGS['recaptcha_private'], $_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
	}
}
elseif ($system->SETTINGS['spam_register'] == 1)
{
	include PLUGIN_PATH . 'captcha/securimage.php';
	$resp = new Securimage();
	$spam_html = $resp->show_html();
}
unset($ERROR);

$query = "SELECT id FROM " . $DBPrefix . "groups WHERE auto_join = 1";
$db->direct_query($query);
$groups = array();
$autoJoin = false;
while ($row_id = $db->result('id'))
{
	$groups[] = $row_id;
	$autoJoin = true;
}
$gateway_data = $system->loadTable('gateways');

// Retrieve users signup settings
$MANDATORY_FIELDS = unserialize($system->SETTINGS['mandatory_fields']);
$DISPLAYED_FIELDS = unserialize($system->SETTINGS['displayed_feilds']);

// missing check bools
$missing = array();

$missing['name'] = $missing['nick'] = $missing['password'] = $missing['repeat_password'] = $missing['email'] = $missing['address'] = $missing['city'] = $missing['prov'] = $missing['country'] = $missing['zip'] = $missing['tel'] = $missing['birthday'] = $missing['paypal'] = $missing['authnet'] = $missing['skrill'] = $missing['toocheckout'] = $missing['worldpay'] = $missing['bank'] = $missing['group'] = false;

if (isset($_POST['action']) && $_POST['action'] == 'first')
{
	if (!isset($_POST['terms_check']))
	{
		$ERROR = $ERR['078'];
	}
	if (!isset($_POST['cookies_check']))
    {
        $ERROR = $ERR['079'];
    }  
    if(!$autoJoin && !array_filter($_POST['group']))
    {
    	$missing['name'] = true;
    }
	if (empty($_POST['TPL_name']))
	{
		$missing['name'] = true;
	}
	if (empty($_POST['TPL_nick']))
	{
		$missing['nick'] = true;
	}
	if (empty($_POST['TPL_password']))
	{
		$missing['password'] = true;
	}
	if (empty($_POST['TPL_repeat_password']))
	{
		$missing['repeat_password'] = true;
	}
	if (empty($_POST['TPL_email']))
	{
		$missing['email'] = true;
	}
	if (empty($_POST['TPL_address']) && $MANDATORY_FIELDS['address'] == 'y')
	{
		$missing['address'] = true;
	}
	if (empty($_POST['TPL_city']) && $MANDATORY_FIELDS['city'] == 'y')
	{
		$missing['city'] = true;
	}
	if (empty($_POST['TPL_prov']) && $MANDATORY_FIELDS['prov'] == 'y')
	{
		$missing['prov'] = true;
	}
	if (empty($_POST['TPL_country']) && $MANDATORY_FIELDS['country'] == 'y')
	{
		$missing['country'] = true;
	}
	if (empty($_POST['TPL_zip']) && $MANDATORY_FIELDS['zip'] == 'y')
	{
		$missing['zip'] = true;
	}
	if (empty($_POST['TPL_phone']) && $MANDATORY_FIELDS['tel'] == 'y')
	{
		$missing['tel'] = true;
	}
	if ((empty($_POST['TPL_day']) || empty($_POST['TPL_month']) || empty($_POST['TPL_year'])) && $MANDATORY_FIELDS['birthdate'] == 'y')
	{
		$missing['birthday'] = true;
	}
	if ($gateway_data['paypal_required'] == 1 && empty($_POST['TPL_pp_email']))
	{
		$missing['paypal'] = true;
	}
	if ($gateway_data['authnet_required'] == 1 && (empty($_POST['TPL_authnet_id']) || empty($_POST['TPL_authnet_pass'])))
	{
		$missing['authnet'] = true;
	}
	if ($gateway_data['skrill_required'] == 1 && (empty($_POST['TPL_skrill_email']) || !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['TPL_skrill_email'])))
	{
		$missing['skrill'] = true;
	}
	if ($gateway_data['toocheckout_required'] == 1 && (empty($_POST['TPL_toocheckout_id'])))
	{
		$missing['toocheckout'] = true;
	}
	if ($gateway_data['worldpay_required'] == 1 && (empty($_POST['TPL_worldpay_id'])))
	{
		$missing['worldpay'] = true;
	}
	if ($gateway_data['bank_required'] == 1 && (empty($_POST['TPL_bank_name']) || empty($_POST['TPL_bank_account']) || empty($_POST['TPL_bank_routing'])))
	{
		$missing['bank'] = true;
	}
	if (checkMissing())
	{
		$ERROR = $ERR['047'];
	}
	if (!isset($ERROR))
	{
		$birth_day = (isset($_POST['TPL_day'])) ? $_POST['TPL_day'] : '';
		$birth_month = (isset($_POST['TPL_month'])) ? $_POST['TPL_month'] : '';
		$birth_year = (isset($_POST['TPL_year'])) ? $_POST['TPL_year'] : '';
		$DATE = $birth_year . $birth_month . $birth_day;
		
   		if ($system->SETTINGS['spam_register'] == 2 && !$resp)
		{
          	$ERROR = $MSG['752'];
		}
		elseif ($system->SETTINGS['spam_register'] == 1 && !$resp->check($_POST['captcha_code']))
		{
			$ERROR = $MSG['752'];
		}
		elseif (strlen($_POST['TPL_nick']) < $system->SETTINGS['minimum_username_length'])
		{
			$ERROR = $ERR['107'];
		}
		elseif (strlen ($_POST['TPL_password']) < $system->SETTINGS['minimum_password_length'])
		{
			$ERROR = $ERR['108'];
		}
		elseif ($_POST['TPL_password'] != $_POST['TPL_repeat_password'])
		{
			$ERROR = $ERR['109'];
		}
		elseif (!preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+([\.][a-zA-Z0-9-]+)+$/i', $_POST['TPL_email']))
		{
			$ERROR = $ERR['110'];
		}
		elseif (!CheckAge($birth_day, $birth_month, $birth_year) && $MANDATORY_FIELDS['birthdate'] == 'y')
		{
			$ERROR = $ERR['113'];
		}
		elseif (!empty($birth_month) && !empty($birth_day) && !empty($birth_year) && !checkdate($birth_month, $birth_day, $birth_year))
		{
			$ERROR = $ERR['117'];
		}
		else
		{
			// check the email to see if it is a Disposable email and blacklisted
			if ($system->SETTINGS['disposable_email_block'] == 'y' && emailblacklist($_POST['TPL_email']) == "failed") 
			{
				//Disposable email detected
				$ERROR = $ERR['115_a'];
			}
			// check username
			$query = "SELECT nick FROM " . $DBPrefix . "users WHERE nick = :name";
			$params = array(
				array(':name', $system->cleanvars($_POST['TPL_nick']), 'str')
			);
			$db->query($query, $params);
			if ($db->numrows('nick') > 0)
			{
				$ERROR = $ERR['111']; // Selected user already exists
			}
			$query = "SELECT email FROM " . $DBPrefix . "users WHERE email = :email";
			$params = array(
				array(':email', $system->cleanvars($_POST['TPL_email']), 'str')
			);
			$db->query($query, $params);
			if ($db->numrows('email') > 0)
			{
				$ERROR = $ERR['115']; // E-mail already used
			}
			// check payment info if it is already used
			if ($gateway_data['worldpay_required'] == 1 && (isset($_POST['TPL_worldpay_id'])))
			{
				$payments = $_POST['TPL_worldpay_id'];
				$sql_payment = 'worldpay_id';
			}
			if ($gateway_data['toocheckout_required'] == 1 && (isset($_POST['TPL_toocheckout_id'])))
			{
				$payments = $_POST['TPL_toocheckout_id'];
				$sql_payment = 'toocheckout_id';
			}
			if ($gateway_data['bank_required'] == 1 && (isset($_POST['TPL_bank_account'])))
			{
				$payments = $_POST['TPL_bank_account'];
				$sql_payment = 'bank_account';
			}
			if ($gateway_data['skrill_required'] == 1 && (isset($_POST['TPL_skrill_email'])))
			{
				$payments = $_POST['TPL_skrill_email'];
				$sql_payment = 'skrill_email';
			}
			if ($gateway_data['authnet_required'] == 1 && (isset($_POST['TPL_authnet_id']) || isset($_POST['TPL_authnet_pass'])))
			{
				$payments = $_POST['TPL_authnet_id'];
				$sql_payment = 'authnet_id';
			}
			if ($gateway_data['paypal_required'] == 1 && (isset($_POST['TPL_pp_email'])))
			{
				$payments = $_POST['TPL_pp_email'];
				$sql_payment = 'paypal_email';
			}
			if (isset($payments))
			{
				$query = "SELECT " . $sql_payment . " FROM " . $DBPrefix . "users WHERE " . $sql_payment . " = :info";
				$params = array(
					array(':info', $system->cleanvars($payments), 'str')
				);
				$db->query($query, $params);
				if ($db->numrows($sql_payment) > 0)
				{
					$ERROR = $ERR['115_b']; // payment already used
				}
			}
			if (!isset($ERROR))
			{
				$TPL_nick_hidden = $_POST['TPL_nick'];
				$TPL_password_hidden = $_POST['TPL_password'];
				$TPL_name_hidden = $_POST['TPL_name'];
				$TPL_email_hidden = $_POST['TPL_email'];
				$SUSPENDED = ($system->SETTINGS['activationtype'] == 2) ? 0 : 8;
				$SUSPENDED = ($system->SETTINGS['activationtype'] == 0) ? 10 : $SUSPENDED;
				$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = 'signup_fee'";
				$db->direct_query($query);
				$signup_fee = $db->result('value');
				if ($system->SETTINGS['fee_type'] == 2 && $signup_fee > 0)
				{
					$SUSPENDED = 9;
					$system->writesetting("counters", "inactiveusers", $system->COUNTERS['inactiveusers'] + 1, 'int');
				}
				elseif ($system->SETTINGS['activationtype'] == 1 || $system->SETTINGS['activationtype'] == 0)
				{
					$system->writesetting("counters", "inactiveusers", $system->COUNTERS['inactiveusers'] + 1, 'int');
				}
				else
				{
					$system->writesetting("counters", "users", $system->COUNTERS['users'] + 1, 'int');
				}
				$balance = ($system->SETTINGS['fee_type'] == 2) ? 0 : ($system->SETTINGS['fee_signup_bonus'] - $signup_fee);
				if(isset($_POST['group']))
				{
					foreach($_POST['group'] as $k => $v)
					{
						$groups[] = $v;
					}
				}
				$hash = get_hash();
				$hashed_password = $phpass->HashPassword($TPL_password_hidden);
				$query = "INSERT INTO " . $DBPrefix . "users
						(nick, password, hash, name, address, city, prov, country, zip, phone, nletter, email, reg_date, birthdate,
						suspended, language, user_groups, balance, avatar, facebook_id, timezone, paypal_email, worldpay_id, skrill_email, 
						toocheckout_id, authnet_id, authnet_pass, bank_name, bank_account, bank_routing)
						VALUES
						(:nick, :password, :hash, :name, :address, :city, :prov, :country, :zip, :phone, :nletter, :email, :reg_date, :birthdate,
						:suspended, :language, :user_groups, :balance, :avatar, :facebook, :timezone, :paypal_email, :worldpay_id, :skrill_email, :toocheckout_id, 
						:authnet_id, :authnet_pass, :bank_name, :bank_account, :bank_routing)";
				$params = array(
					array(':nick', $system->cleanvars($TPL_nick_hidden), 'str'),
					array(':password', $phpass->HashPassword($TPL_password_hidden), 'str'),
					array(':hash', $hash, 'str'),
					array(':name', $system->cleanvars($TPL_name_hidden), 'str'),
					array(':address', $system->cleanvars((isset($_POST['TPL_address'])) ? $_POST['TPL_address'] : ''), 'str'),
					array(':city', $system->cleanvars((isset($_POST['TPL_city'])) ? $_POST['TPL_city'] : ''), 'str'),
					array(':prov', $system->cleanvars((isset($_POST['TPL_prov'])) ? $_POST['TPL_prov'] : ''), 'str'),
					array(':country', $system->cleanvars((isset($_POST['TPL_country'])) ? $_POST['TPL_country'] : ''), 'str'),
					array(':zip', $system->cleanvars((isset($_POST['TPL_zip'])) ? $_POST['TPL_zip'] : ''), 'str'),
					array(':phone', $system->cleanvars((isset($_POST['TPL_phone'])) ? $_POST['TPL_phone'] : ''), 'str'),
					array(':nletter', $_POST['TPL_nletter'], 'int'),
					array(':email', $system->cleanvars($_POST['TPL_email']), 'str'),
					array(':reg_date', $system->CTIME, 'int'),
					array(':birthdate', ((!empty($DATE)) ? $DATE : 0), 'str'),
					array(':suspended', $SUSPENDED, 'int'),
					array(':language', $language, 'str'),
					array(':user_groups', implode(',', $groups), 'str'),
					array(':balance', $balance, 'float'),
					array(':avatar', (isset($_POST['image'])) ? $_POST['image'] : '', 'str'),
					array(':facebook', (isset($_POST['fbid'])) ? $_POST['fbid'] : '', 'str'),
					array(':timezone', $_POST['TPL_timezone'], 'str'),
					array(':paypal_email', $_POST['TPL_pp_email'], 'str'),
					array(':worldpay_id', $_POST['TPL_worldpay_id'], 'str'),
					array(':skrill_email', $_POST['TPL_skrill_email'], 'str'),
					array(':toocheckout_id', $_POST['TPL_toocheckout_id'], 'str'),
					array(':authnet_id', $_POST['TPL_authnet_id'], 'str'),
					array(':authnet_pass', $_POST['TPL_authnet_pass'], 'str'),
					array(':bank_name', $_POST['TPL_bank_name'], 'str'),
					array(':bank_account', $_POST['TPL_bank_account'], 'str'),
					array(':bank_routing', $_POST['TPL_bank_routing'], 'str'),
				);		
				$db->query($query, $params);
				$TPL_id_hidden = $db->lastInsertId();
				if($TPL_id_hidden > 0)
				{
					$system->Check_Validation(true);
					
					$query = "UPDATE ". $DBPrefix . "groups SET count = count + 1 WHERE auto_join = 1";
					$db->direct_query($query);
					
					if(count(array_filter($groups)) > 0)
					{
						foreach($groups as $k => $v)
						{
							$query = "UPDATE ". $DBPrefix . "groups SET count = count + 1 WHERE id = :group_ID";
							$params = array(
								array(':group_ID', $v, 'int'),
							);
							$db->query($query, $params);
						}
					}
					
					$query = "INSERT INTO " . $DBPrefix . "usersips VALUES (NULL, :id_hidden, :remote_addr, :first, :accept)";
					$params = array(
						array(':id_hidden', $TPL_id_hidden, 'int'),
						array(':remote_addr', $_SERVER['REMOTE_ADDR'], 'int'),
						array(':first', 'first', 'str'),
						array(':accept', 'accept', 'str')
					);
					$db->query($query, $params);
					$_SESSION['language'] = $language;
					if (defined('TrackUserIPs'))
					{
						// log registration IP
						$system->log('user', 'Regestered User', $TPL_id_hidden);
					}
					if ($system->SETTINGS['activationtype'] == 0)
					{
						$TPL_message = $send_email->needapproval($TPL_id_hidden, $TPL_name_hidden, $TPL_nick_hidden, $_POST['TPL_address'], $_POST['TPL_city'], $_POST['TPL_prov'], $_POST['TPL_zip'], $_POST['TPL_country'], $_POST['TPL_phone'], $_POST['TPL_email'], $TPL_password_hidden, $TPL_email_hidden);
					}
					elseif ($system->SETTINGS['activationtype'] == 1)
					{
						$TPL_message = $send_email->user_confirmation($TPL_name_hidden, $TPL_id_hidden, $TPL_email_hidden, $TPL_nick_hidden);
					}
					else
					{
						$USER = array('name' => $TPL_name_hidden, 'email' => $_POST['TPL_email']);
						$TPL_message = $send_email->approved($USER['name'], $language, $USER['email']);
					}
					if ($system->SETTINGS['fee_type'] == 2 && $signup_fee > 0)
					{
						$_SESSION['signup_id'] = $TPL_id_hidden;
						header('location: pay.php?a=3');
						exit;
					}
					$template->assign_vars(array(
						'L_HEADER' => sprintf($MSG['859'], $TPL_name_hidden),
						'L_MESSAGE' => $TPL_message
					));
				}else{
					$ERROR = $MSG['3500_1015851'];
				}
			}
			unset($_POST["g-recaptcha-response"]);
		}
	}
}

$country = '';
$selcountry = isset($_POST['TPL_country']) ? $_POST['TPL_country'] : '';
foreach ($countries as $key => $name)
{
	$country .= '<option value="' . $name . '"';
	if ($name == $selcountry)
	{
		$country .= ' selected';
	}
	elseif ($system->SETTINGS['defaultcountry'] == $name)
	{
		$country .= ' selected';
	}
	$country .= '>' . $name . '</option>' . "\n";
}
$dobmonth = '<span class="input-group-btn"><select name="TPL_month" class="missing form-control">
		<option value="01"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '01') ? ' selected' : '') . '>' . $MSG['MON_001E'] . '</option>
		<option value="02"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '02') ? ' selected' : '') . '>' . $MSG['MON_002E'] . '</option>
		<option value="03"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '03') ? ' selected' : '') . '>' . $MSG['MON_003E'] . '</option>
		<option value="04"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '04') ? ' selected' : '') . '>' . $MSG['MON_004E'] . '</option>
		<option value="05"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '05') ? ' selected' : '') . '>' . $MSG['MON_005E'] . '</option>
		<option value="06"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '06') ? ' selected' : '') . '>' . $MSG['MON_006E'] . '</option>
		<option value="07"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '07') ? ' selected' : '') . '>' . $MSG['MON_007E'] . '</option>
		<option value="08"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '08') ? ' selected' : '') . '>' . $MSG['MON_008E'] . '</option>
		<option value="09"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '09') ? ' selected' : '') . '>' . $MSG['MON_009E'] . '</option>
		<option value="10"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '10') ? ' selected' : '') . '>' . $MSG['MON_010E'] . '</option>
		<option value="11"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '11') ? ' selected' : '') . '>' . $MSG['MON_011E'] . '</option>
		<option value="12"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '12') ? ' selected' : '') . '>' . $MSG['MON_012E'] . '</option>
	</select></span >';

$dobday = '<span class="input-group-btn"><select name="TPL_day" class="missing form-control">';

for ($i = 1; $i <= 31; $i++)
{
	$j = (strlen($i) == 1) ? '0' . $i : $i;
	$dobday .= '<option value="' . $j . '"' . ((isset($_POST['TPL_day']) && $_POST['TPL_day'] == $j) ? ' selected' : '') . '>' . $j . '</option>';
}
$dobday .= '</select></span>';

$selectsetting = (isset($_POST['TPL_timezone'])) ? $_POST['TPL_timezone'] : $system->SETTINGS['timezone'];
$time_correction = generateSelect('TPL_timezone', $timezones, $selectsetting);

$query = "SELECT id, group_name FROM " . $DBPrefix . "groups WHERE auto_join = :join";
$params = array(
	array(':join', 0, 'int')
);
$db->query($query,$params);
$isGroups = false;
while ($groups = $db->result())
{
	$template->assign_block_vars('groups', array(
		'GROUPNAME' => $groups['group_name'],
		'ID' => $groups['id'],
		'GROUPCHECKED' => isset($_POST['group']) && in_array($groups['id'], $_POST['group']) ? 'checked' : '',
	));
	$isGroups = true;
}

$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = :signup";
$params = array(
	array(':signup', 'signup_fee', 'str')
);
$db->query($query, $params);
$sightUpFee = $db->result('value');
$template->assign_vars(array(
	'B_SINGUP_FEE' => ($sightUpFee > 0),
	'FEE'=> $system->print_money($sightUpFee)
));

$fbCity = '';
$fbProv = '';

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'L_COUNTRIES' => $country,
	'L_DATEFORMAT' => ($system->SETTINGS['datesformat'] == 'USA') ? $dobmonth . ' ' . $dobday : $dobday . ' ' . $dobmonth,
	'TIMEZONE' => $time_correction,
	'TERMSTEXT' => $system->SETTINGS['termspolicytext'],
	'COOKIESTEXT' => $system->SETTINGS['cookiespolicytext'],
	//payment stuff
	'PP_EMAIL' => (isset($_POST['TPL_pp_email'])) ? $_POST['TPL_pp_email'] : '',
	'AN_ID' => (isset($_POST['TPL_authnet_id'])) ? $_POST['TPL_authnet_id'] : '',
	'AN_PASS' => (isset($_POST['TPL_authnet_pass'])) ? $_POST['TPL_authnet_pass'] : '',
	'WP_ID' => (isset($_POST['TPL_worldpay_id'])) ? $_POST['TPL_worldpay_id'] : '',
	'MB_EMAIL' => (isset($_POST['TPL_skrill_email'])) ? $_POST['TPL_skrill_email'] : '',
	'TC_ID' => (isset($_POST['TPL_toocheckout_id'])) ? $_POST['TPL_toocheckout_id'] : '',
	'BANK' => (isset($_POST['TPL_bank_name'])) ? $_POST['TPL_bank_name'] : '',
	'BANK_ACCOUNT' => (isset($_POST['TPL_bank_account'])) ? $_POST['TPL_bank_account'] : '',
	'BANK_ROUTING' => (isset($_POST['TPL_bank_routing'])) ? $_POST['TPL_bank_routing'] : '',
	'B_ADMINAPROVE' => ($system->SETTINGS['activationtype'] == 0),
	'BONUS' => $system->print_money($system->SETTINGS['fee_signup_bonus'], false),
 	'B_BONUS_FEE' => ($system->SETTINGS['fee_signup_bonus'] > 0),
	'B_NLETTER' => ($system->SETTINGS['newsletter'] == 1),
	'B_FIRST' => ($system->complete_validation == false) ? true : false,
	'B_PAYPAL' => ($gateway_data['paypal_active'] == 1),
	'B_AUTHNET' => ($gateway_data['authnet_active'] == 1),
	'B_WORLDPAY' => ($gateway_data['worldpay_active'] == 1),
	'B_TOOCHECKOUT' => ($gateway_data['toocheckout_active'] == 1),
	'B_MONEYBOOKERS' => ($gateway_data['skrill_active'] == 1),
	'B_BANK_TRANSFER' => ($gateway_data['bank_active'] == 1),
	'B_SSL' => ($system->SETTINGS['https'] == 'y'),
	'CAPTCHATYPE' => $system->SETTINGS['spam_register'],
	'CAPCHA' => ($system->SETTINGS['spam_register'] == 2) ? $capcha_text : $spam_html,
	'BIRTHDATE' => ($DISPLAYED_FIELDS['birthdate_regshow'] == 'y'),
	'ADDRESS' => ($DISPLAYED_FIELDS['address_regshow'] == 'y'),
	'CITY' => ($DISPLAYED_FIELDS['city_regshow'] == 'y'),
	'PROV' => ($DISPLAYED_FIELDS['prov_regshow'] == 'y'),
	'COUNTRY' => ($DISPLAYED_FIELDS['country_regshow'] == 'y'),
	'ZIP' => ($DISPLAYED_FIELDS['zip_regshow'] == 'y'),
	'TEL' => ($DISPLAYED_FIELDS['tel_regshow'] == 'y'),
	'FBID' => $facebookAPP->FBid !='' ? $facebookAPP->FBid : (isset($_POST['fbid'])) ? $_POST['fbid'] : '',
	'FBIMAGE' => $facebookAPP->FBimage !='' ? $facebookAPP->FBimage : (isset($_POST['image'])) ? $_POST['image'] : '',
	'REQUIRED' => array(
		($MANDATORY_FIELDS['birthdate'] == 'y') ? ' *' : '',
		($MANDATORY_FIELDS['address'] == 'y') ? ' *' : '',
		($MANDATORY_FIELDS['city'] == 'y') ? ' *' : '',
		($MANDATORY_FIELDS['prov'] == 'y') ? ' *' : '',
		($MANDATORY_FIELDS['country'] == 'y') ? ' *' : '',
		($MANDATORY_FIELDS['zip'] == 'y') ? ' *' : '',
		($MANDATORY_FIELDS['tel'] == 'y') ? ' *' : '',
		($gateway_data['paypal_required'] == 1) ? ' *' : '',
		($gateway_data['authnet_required'] == 1) ? ' *' : '',
		($gateway_data['worldpay_required'] == 1) ? ' *' : '',
		($gateway_data['toocheckout_required'] == 1) ? ' *' : '',
		($gateway_data['skrill_required'] == 1) ? ' *' : '',
		($gateway_data['bank_required'] == 1) ? ' *' : ''
	),
	'MISSING0' => ($missing['name']) ? 1 : 0,
	'MISSING1' => ($missing['nick']) ? 1 : 0,
	'MISSING2' => ($missing['password']) ? 1 : 0,
	'MISSING3' => ($missing['repeat_password']) ? 1 : 0,
	'MISSING4' => ($missing['email']) ? 1 : 0,
	'MISSING5' => ($missing['birthday']) ? 1 : 0,
	'MISSING6' => ($missing['address']) ? 1 : 0,
	'MISSING7' => ($missing['city']) ? 1 : 0,
	'MISSING8' => ($missing['prov']) ? 1 : 0,
	'MISSING9' => ($missing['country']) ? 1 : 0,
	'MISSING10' => ($missing['zip']) ? 1 : 0,
	'MISSING11' => ($missing['tel']) ? 1 : 0,
	'MISSING12' => ($missing['paypal']) ? 1 : 0,
	'MISSING13' => ($missing['authnet']) ? 1 : 0,
	'MISSING14' => ($missing['worldpay']) ? 1 : 0,
	'MISSING15' => ($missing['toocheckout']) ? 1 : 0,
	'MISSING16' => ($missing['skrill']) ? 1 : 0,
	'MISSING17' => ($missing['bank']) ? 1 : 0,
	'V_YNEWSL' => ((isset($_POST['TPL_nletter']) && $_POST['TPL_nletter'] == 1) || !isset($_POST['TPL_nletter'])) ? 'checked=true' : '',
	'V_NNEWSL' => (isset($_POST['TPL_nletter']) && $_POST['TPL_nletter'] == 2) ? 'checked=true' : '',
	'V_YNAME' => (isset($_POST['TPL_name'])) ? $_POST['TPL_name'] : $facebookAPP->FBname !='' ? $facebookAPP->FBname : '',
	'V_UNAME' => (isset($_POST['TPL_nick'])) ? $_POST['TPL_nick'] : '',
	'V_EMAIL' => (isset($_POST['TPL_email'])) ? $_POST['TPL_email'] : $facebookAPP->FBemail !='' ? $facebookAPP->FBemail : '',
	'V_YEAR' => (isset($_POST['TPL_year'])) ? $_POST['TPL_year'] : '',
	'V_ADDRE' => (isset($_POST['TPL_address'])) ? $_POST['TPL_address'] : '',
	'V_CITY' => (isset($_POST['TPL_city'])) ? $_POST['TPL_city'] : '',
	'V_PROV' => (isset($_POST['TPL_prov'])) ?  $_POST['TPL_prov'] : '',
	'V_POSTCODE' => (isset($_POST['TPL_zip'])) ? $_POST['TPL_zip'] : '',
	'V_PHONE' => (isset($_POST['TPL_phone'])) ? $_POST['TPL_phone'] : '',
	'B_FB_LINK' => 'facebookRegister',
	'B_GROUPS' => $isGroups,
	'FBOOK_EMAIL' => $facebookAPP->FBemail !='',
	'FBOOK_ID' => $facebookAPP->FBid !='' ? $facebookAPP->FBid : '',
	'USERNAME_SIZE' => sprintf($MSG['3500_1015639'], $system->SETTINGS['minimum_username_length']),
	'PASSWORD_SIZE' => sprintf($MSG['3500_1015639'], $system->SETTINGS['minimum_password_length']),
	'ALLOWEDSIZE' => $system->SETTINGS['minimum_password_length']
));
		
include 'header.php';
$template->set_filenames(array(
		'body' => 'register.tpl'
		));
$template->display('body');
include 'footer.php';