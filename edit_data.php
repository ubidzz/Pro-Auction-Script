<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/



include 'common.php';

include INCLUDE_PATH . 'countries.inc.php';

include INCLUDE_PATH . 'config/timezones.php';

include PLUGIN_PATH . 'smsConfig/smsCarriers.php';

$_SESSION['REDIRECT_AFTER_LOGIN'] = 'edit_data.php';

if (!$user->checkAuth())

{

	header('location: user_login.php');

	exit;

}

// Retrieve users signup settings

$MANDATORY_FIELDS = unserialize($system->SETTINGS['mandatory_fields']);

$gateway_data = $system->loadTable('gateways');

if(isset($_GET['facebook']))

{

	if($_GET['facebook'] == 'link') {

		$facebookAPP->connectToFacebook();

	}elseif($_GET['facebook'] == 'unlink') {

		$facebookAPP->FacebookUnlink();

	}

}

if (isset($_POST['action']) && $_POST['action'] == 'update')

{

	// Check data

	if ($_POST['TPL_email'])

	{

		if (strlen($_POST['TPL_password']) < 6 && strlen($_POST['TPL_password']) > 0)

		{

			$ERROR = $ERR['011'];

		}

		elseif ($_POST['TPL_password'] != $_POST['TPL_repeat_password'])

		{

			$ERROR = $ERR['109'];

		}

		elseif (strlen($_POST['TPL_email']) < 5)

		{

			$ERROR = $ERR['110'];

		}

		elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['TPL_email']))

		{

			$ERROR = $ERR['008'];

		}

		elseif (strlen($_POST['TPL_zip']) < 4 && $MANDATORY_FIELDS['zip'] == 'y')

		{

			$ERROR = $ERR['616'];

		}

		elseif (strlen($_POST['TPL_phone']) < 3 && $MANDATORY_FIELDS['tel'] == 'y')

		{

			$ERROR = $ERR['617'];

		}

		elseif ((empty($_POST['TPL_day']) || empty($_POST['TPL_month']) || empty($_POST['TPL_year'])) && $MANDATORY_FIELDS['birthdate'] == 'y')

		{

			$ERROR = $MSG['948'];

		}

		elseif (!empty($_POST['TPL_day']) && !empty($_POST['TPL_month']) && !empty($_POST['TPL_year']) && !checkdate($_POST['TPL_month'], $_POST['TPL_day'], $_POST['TPL_year']))

		{

			$ERROR = $ERR['117'];

		}

		elseif ($gateway_data['paypal_required'] == 1 && (empty($_POST['TPL_pp_email']) || !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['TPL_pp_email'])))

		{

			$ERROR = $MSG['810'];

		}

		elseif ($gateway_data['authnet_required'] == 1 && (empty($_POST['TPL_authnet_id']) || empty($_POST['TPL_authnet_pass'])))

		{

			$ERROR = $MSG['811'];

		}

		elseif ($gateway_data['skrill_required'] == 1 && (empty($_POST['TPL_skrill_email']) || !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['TPL_skrill_email'])))

		{

			$ERROR = $MSG['822'];

		}

		elseif ($gateway_data['toocheckout_required'] == 1 && (empty($_POST['TPL_toocheckout_id'])))

		{

			$ERROR = $MSG['821'];

		}

		elseif ($gateway_data['worldpay_required'] == 1 && (empty($_POST['TPL_worldpay_id'])))

		{

			$ERROR = $MSG['823'];

		}

		elseif ($gateway_data['bank_required'] == 1 && (empty($_POST['TPL_bank_name']) || empty($_POST['TPL_bank_account']) || empty($_POST['TPL_bank_routing'])))  

        {  

            $ERROR = $MSG['30_0223'];  

        } 

		if (!empty($_POST['TPL_day']) && !empty($_POST['TPL_month']) && !empty($_POST['TPL_year']))

		{

			$TPL_birthdate = $_POST['TPL_year'] . $_POST['TPL_month'] . $_POST['TPL_day'];

		}

		else

		{

			$TPL_birthdate = 0;

		}

		if($_POST['TPL_cellPhone'] !='')

		{

			$activateSMS = isset($_POST['TPL_activate']) ? $_POST['TPL_activate'] : '';

			$resend = isset($_POST['resendCode']) && $_POST['resendCode'] == 'y' ? true : false;

			if($resend)

			{

				$smsAlerts->alertSettingHandler('re-sendActivationCode', array('userID' => $user->user_data['id'],'phoneNumber' => $_POST['TPL_cellPhone']));

			}else{

				$build_smsSettingsArray = array(
				
					'userID' => $user->user_data['id'],

					'cellPhoneCarrier' => isset($_POST['TPL_cellPhoneCarrier']) ? $_POST['TPL_cellPhoneCarrier'] : '',

					'cellPhoneNumber' => isset($_POST['TPL_cellPhone']) ? $_POST['TPL_cellPhone'] : '',

					'smsLoginAlert' => isset($_POST['TPL_smsLoginAlert']) ? $_POST['TPL_smsLoginAlert'] : '',

					'smsMessagesAlert' => isset($_POST['TPL_smsMessagesAlert']) ? $_POST['TPL_smsMessagesAlert'] : '',

					'smsItemWonAlert' => isset($_POST['TPL_smsItemWonAlert']) ? $_POST['TPL_smsItemWonAlert'] : '',

					'smsItemSoldAlert' => isset($_POST['TPL_smsItemSoldAlert']) ? $_POST['TPL_smsItemSoldAlert'] : '',

					'smsBidAlert' => isset($_POST['TPL_smsBidAlert']) ? $_POST['TPL_smsBidAlert'] : '',

					'smsStrength' => isset($_POST['TPL_smsStrength']) ? $_POST['TPL_smsStrength'] :  '',

					'smsActivationCode' => $activateSMS

				);
				
				$smsAlerts->alertSettingHandler('EditSMSSettings',$build_smsSettingsArray);

			}

		}


		$query = "UPDATE " . $DBPrefix . "users SET 

			email = :user_email, birthdate = :user_birthdate, address = :user_address, city = :user_city, 

			prov = :user_prov, country = :user_country, zip = :user_zip, phone = :user_phone, timezone = :user_timezone, 

			emailtype = :user_emailtype, hideOnline = :user_HideStatus, nletter = :user_nletter";

		$params = array();

		$params[] =	array(':user_email', $system->cleanvars($_POST['TPL_email']), 'str');

		$params[] =	array(':user_birthdate', $TPL_birthdate, 'int');

		$params[] =	array(':user_address', $system->cleanvars($_POST['TPL_address']), 'str');

		$params[] =	array(':user_city', $system->cleanvars($_POST['TPL_city']), 'str');

		$params[] =	array(':user_prov', $system->cleanvars($_POST['TPL_prov']), 'str');

		$params[] =	array(':user_country', $system->cleanvars($_POST['TPL_country']), 'str');

		$params[] =	array(':user_zip', $system->cleanvars($_POST['TPL_zip']), 'str');

		$params[] =	array(':user_phone', $system->cleanvars($_POST['TPL_phone']), 'str');

		$params[] =	array(':user_timezone', $system->cleanvars($_POST['TPL_timezone']), 'str');

		$params[] =	array(':user_emailtype', $system->cleanvars($_POST['TPL_emailtype']), 'str');

		$params[] =	array(':user_HideStatus', $system->cleanvars($_POST['TPL_HideStatus']), 'bool');

		$params[] =	array(':user_nletter', $system->cleanvars($_POST['TPL_nletter']), 'bool');


		if ($_POST['TPL_HideStatus'] == 'y')

		{

			$query .= ", is_online = :user_online_time";

			$params[] = array(':user_online_time', $system->CTIME - 350, 'int');

		}else{

			$query .= ", is_online = :user_online_time";

			$params[] = array(':user_online_time', $system->CTIME, 'int');

		}

		if ($gateway_data['paypal_active'] == 1 && $_POST['TPL_pp_email'] !='')

		{

			$query .= ", paypal_email = :user_paypal_email";

			$params[] = array(':user_paypal_email', $system->cleanvars($_POST['TPL_pp_email']), 'str');

		}

		if ($gateway_data['authnet_active'] == 1 && $_POST['TPL_authnet_id'] !='' && $_POST['TPL_authnet_pass'] !='')

		{

			$query .= ", authnet_id = :user_authnet_id, authnet_pass = :user_authnet_pass";

			$params[] = array(':user_authnet_id', $system->cleanvars($_POST['TPL_authnet_id']), 'str');

			$params[] = array(':user_authnet_pass', $system->cleanvars($_POST['TPL_authnet_pass']), 'str');

		}

		if ($gateway_data['worldpay_active'] == 1 && $_POST['TPL_worldpay_id'] !='')

		{

			$query .= ", worldpay_id = :user_worldpay_id";

			$params[] = array(':user_worldpay_id', $system->cleanvars($_POST['TPL_worldpay_id']), 'str');

		}

		if ($gateway_data['skrill_active'] == 1 && $_POST['TPL_skrill_email'] !='')

		{

			$query .= ", skrill_email = :user_skrill_email";

			$params[] = array(':user_skrill_email', $system->cleanvars($_POST['TPL_skrill_email']), 'str');

		}

		if ($gateway_data['toocheckout_active'] == 1 && $_POST['TPL_toocheckout_id'] !='')

		{

			$query .= ", toocheckout_id = :user_toocheckout_id";

			$params[] = array(':user_toocheckout_id', $system->cleanvars($_POST['TPL_toocheckout_id']), 'str');

		}

		if ($gateway_data['bank_active'] == 1 && $_POST['TPL_bank_name'] !='' || $_POST['TPL_bank_account'] !='' || $_POST['TPL_bank_routing'] !='')  

      	{  

          	$query .= ", bank_name = :user_bank_name, bank_account = :user_bank_account, bank_routing = :user_bank_routing";

        	$params[] = array(':user_bank_name', $system->cleanvars($_POST['TPL_bank_name']), 'str');

         	$params[] = array(':user_bank_account', $system->cleanvars($_POST['TPL_bank_account']), 'str');

           	$params[] = array(':user_bank_routing', $system->cleanvars($_POST['TPL_bank_routing']), 'str');

        } 

		if (strlen($_POST['TPL_password']) > 0)

		{

			$query .= ", password = :user_password";

			$params[] = array(':user_password', $phpass->HashPassword($_POST['TPL_password']), 'str');

			$query .= ", hash = :user_hash";

			$params[] = array(':user_hash', get_hash(), 'str');

		}

		$query .= " WHERE id = :user_id";

		$params[] = array(':user_id', $user->user_data['id'], 'int');

		$db->query($query, $params);

		$ERROR = $MSG['183'];			

		if(!empty($_FILES['avatar']['tmp_name']) && $_FILES['avatar']['tmp_name'] !='')

		{
			
			/* GetImageSize() function pulls out valid info about image such as image type, height etc. If it fails 

			then it is not valid image. */

			if (!getimagesize($_FILES['avatar']['tmp_name']))

			{ 

				$ERR .= '<br>' . $MSG['3500_1015988'];

		  	}

			$imgtype = array('1' => '.gif', '2' => '.jpg' , '3' => '.png', '4' => '.jpeg', '5' => '.x-png', '6' => '.pjpeg');

		  	// extract the width and height of image

		  	list($width, $height, $type, $attr) = getimagesize($_FILES['avatar']['tmp_name']);

		 	// Extract the image extension

		  	switch ($type)

		  	{

		  		case 1: $ext='.gif'; break;

		  		case 2: $ext = '.jpg'; break;

		  		case 3: $ext='.png'; break;

		  		case 4: $ext='.jpeg'; break;

		  		case 5: $ext='.x-png'; break;

		  		case 6: $ext='.pjpeg'; break;

		  	}

		  	// Dont allow gif files to upload as it may  contain harmful code

		  	if ( $ext == '.gif') {

		  	  	$ERROR .= '<br>' . $MSG['3500_1015987'];

		    }

		 	/* Specify maximum height and width of users uploading image */

		   	if ($width > 1000 || $height > 1000)

		  	{

		   		$ERROR .= '<br>' . $MSG['3500_1015986'];

		  	}

		  	/* Specify maximum file size here in bytes */

		  	if ($_FILES['avatar']['size'] > $system->SETTINGS['maxuploadsize'])

		    {

		    	$ERROR .= '<br>' . $MSG['3500_1015985'];

		    }

		    

		    // The uploads folder must have writable permissions.

		    $uploaddir = 'uploaded/avatar/' . $user->user_data['id'] . '/';

		    if (!is_dir($uploaddir)) mkdir($uploaddir, 0777);

			if (!is_dir($uploaddir)) chmod($uploaddir, 0777);

		    $secondname = rand(100,99);

		    $uploadfile =  $uploaddir . "img-$secondname". $ext;

		    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile ))

		    {

		       	$ERROR .= '<br>' . $MSG['3500_1015984'];

		     }

		    $query = "UPDATE " . $DBPrefix . "users SET avatar = '" . $system->SETTINGS['siteurl'] . $uploadfile . "' WHERE id = :user_id";

		    $params = array(

				array(':user_id', $user->user_data['id'], 'int')

			);

			$db->query($query, $params);

		 	$user->user_data['avatar'] = $uploadfile;

			$ERROR .= '<br>' . $MSG['3500_1015983'];

		}

		unset($_SESSION['FB_ED']);

		unset($_SESSION['FBOOK_USER_IDS']);

		header("Refresh:0");

	}

	else

	{

		$ERROR = $ERR['112'];

	}

}



if ($user->user_data['birthdate'] != 0)

{

	$TPL_day = substr($user->user_data['birthdate'], 6, 2);

	$TPL_month = substr($user->user_data['birthdate'], 4, 2);

	$TPL_year = substr($user->user_data['birthdate'], 0, 4);

}

else

{

	$TPL_day = '';

	$TPL_month = '';

	$TPL_year = '';

}



$country = '';

foreach ($countries as $code => $name)

{

	$country .= '<option value="' . $name . '"';

	if ($name == $user->user_data['country'])

	{

		$country .= ' selected';

	}

	$country .= '>' . $name . '</option>' . "\n";

}

$dobmonth = '<span class="input-group-btn"><select name="TPL_month" class="form-control">

		<option value="01"' . (($TPL_month == '01') ? ' selected' : '') . '>' . $MSG['MON_001E'] . '</option>

		<option value="02"' . (($TPL_month == '02') ? ' selected' : '') . '>' . $MSG['MON_002E'] . '</option>

		<option value="03"' . (($TPL_month == '03') ? ' selected' : '') . '>' . $MSG['MON_003E'] . '</option>

		<option value="04"' . (($TPL_month == '04') ? ' selected' : '') . '>' . $MSG['MON_004E'] . '</option>

		<option value="05"' . (($TPL_month == '05') ? ' selected' : '') . '>' . $MSG['MON_005E'] . '</option>

		<option value="06"' . (($TPL_month == '06') ? ' selected' : '') . '>' . $MSG['MON_006E'] . '</option>

		<option value="07"' . (($TPL_month == '07') ? ' selected' : '') . '>' . $MSG['MON_007E'] . '</option>

		<option value="08"' . (($TPL_month == '08') ? ' selected' : '') . '>' . $MSG['MON_008E'] . '</option>

		<option value="09"' . (($TPL_month == '09') ? ' selected' : '') . '>' . $MSG['MON_009E'] . '</option>

		<option value="10"' . (($TPL_month == '10') ? ' selected' : '') . '>' . $MSG['MON_010E'] . '</option>

		<option value="11"' . (($TPL_month == '11') ? ' selected' : '') . '>' . $MSG['MON_011E'] . '</option>

		<option value="12"' . (($TPL_month == '12') ? ' selected' : '') . '>' . $MSG['MON_012E'] . '</option>

	</select></span>';

$dobday = '<span class="input-group-btn"><select name="TPL_day" class="form-control">';

for ($i = 1; $i <= 31; $i++)

{

	$j = (strlen($i) == 1) ? '0' . $i : $i;

	$dobday .= '<option value="' . $j . '"' . (($TPL_day == $j) ? ' selected' : '') . '>' . $j . '</option>';

}

$dobday .= '</select></span>';



$time_correction = generateSelect('TPL_timezone', $timezones, $user->user_data['timezone']);



$query = "SELECT * FROM " . $DBPrefix . "sms_settings WHERE user_id = :user"; 

$params = array(

	array(':user', $user->user_data['id'], 'int')

);

$db->query($query, $params);

if($db->numrows() == 1)

{

	$smsSettings = $db->result();

}else{

	$smsSettings['smsActivated'] = 'n';

	$smsSettings['messageAlert'] = 'n';

	$smsSettings['itemWonAlert'] = 'n';

	$smsSettings['itemSoldAlert'] = 'n';

	$smsSettings['outBiddedAlert'] = 'n';

	$smsSettings['codeStrength'] = '';

	$smsSettings['carrier'] = '';

	$smsSettings['loginAlert'] = 'n';

}

$cellPhoneCarriers = generateSelect('TPL_cellPhoneCarrier', $carriers, $smsSettings['carrier']);



$query = "SELECT fb_id FROM " . $DBPrefix . "facebookLogin WHERE fb_id = :check_id";

$params = array(

	array(':check_id', $user->user_data['facebook_id'], 'int')

);

$db->query($query, $params);

$fb_id_checked = '';

if($db->numrows('fb_id') == 1) {

	$fb_id_checked = $db->result('fb_id');

}



if ($user->user_data['facebook_id'] == $fb_id_checked && $user->user_data['facebook_id'] !='')

{

	$fbconnected = '<img src="images/longin1.png">' . $MSG['350_10190'] . '<br><br>

	<a class="btn btn-danger btn-sm" href="' . $system->SETTINGS['siteurl'] . 'edit_data.php?facebook=unlink"><span class="glyphicon glyphicon-remove"></span> ' . $MSG['3500_1015943'] . '</a>';



}	

elseif ($user->user_data['facebook_id'] == 0)

{

	$fbconnected = '<img src="' . $system->SETTINGS['siteurl'] . 'images/redlogin1.png">' . $MSG['350_10191'] . '<br><br>

	<a class="btn btn-success btn-sm" href="#" onclick="editUserFacebookLogin();"><span class="glyphicon glyphicon-ok"></span> ' . $MSG['350_10204_c'] . '</a>';

}


// User Online Status

$loggedtime = $system->CTIME - 300; // 5 min



$query = "SELECT is_online FROM " . $DBPrefix . "users WHERE id = :user_id"; 

$params = array(

	array(':user_id', $user->user_data['id'], 'int')

);

$db->query($query, $params);

 

while ($onlinecheck = $db->result()) 

{

    if($onlinecheck['is_online'] >  $loggedtime) 

    { 

    $online = '<img src="' . $system->SETTINGS['siteurl'] . 'images/online.png">' . $MSG['350_10111'];

    } 

    else { 

    $online = '<img src="' . $system->SETTINGS['siteurl'] . 'images/offline.png">' . $MSG['350_10112'];

    }     

} 



$template->assign_vars(array(

	'COUNTRYLIST' => $country,

	'NAME' => $user->user_data['name'],

	'HIDEONLINE1' => $user->user_data['hideOnline'] == 'y' ? ' checked="checked"' : '',

	'HIDEONLINE2' => $user->user_data['hideOnline'] == 'n' ? ' checked="checked"' : '',

	'IS_ONLINE' => $online,

	'NICK' => $user->user_data['nick'],

	'EMAIL' => $user->user_data['email'],

	'YEAR' => $TPL_year,

	'ADDRESS' => $user->user_data['address'],

	'CITY' => $user->user_data['city'],

	'PROV' => $user->user_data['prov'],

	'ZIP' => $user->user_data['zip'],

	'PHONE' => $user->user_data['phone'],

	'DATEFORMAT' => ($system->SETTINGS['datesformat'] == 'USA') ? $dobmonth . ' ' . $dobday : $dobday . ' ' . $dobmonth,

	'TIMEZONE' => $time_correction,

	'CELLPHONECARRIERS' => $cellPhoneCarriers,

	'PP_EMAIL' => $user->user_data['paypal_email'],

	'AN_ID' => $user->user_data['authnet_id'],

	'AN_PASS' => $user->user_data['authnet_pass'],

	'WP_ID' => $user->user_data['worldpay_id'],

	'TC_ID' => $user->user_data['toocheckout_id'],

	'MB_EMAIL' => $user->user_data['skrill_email'],

	'BANK' => $user->user_data['bank_name'], 

   	'BANK_ACCOUNT' => $user->user_data['bank_account'], 

    'BANK_ROUTING' => $user->user_data['bank_routing'],

    'MAXUPLOADSIZE' =>$system->SETTINGS['maxuploadsize'],

	'NLETTER1' => $user->user_data['nletter'] == 1 ? ' checked="checked"' : '',

	'NLETTER2' => $user->user_data['nletter'] == 2 ? ' checked="checked"' : '',

	'EMAILTYPE1' => $user->user_data['emailtype'] == 'html' ? ' checked="checked"' : '',

	'EMAILTYPE2' => $user->user_data['emailtype'] == 'text' ? ' checked="checked"' : '',

	'B_FB_LINK' => 'editUserFacebookLogin',

	'B_NEWLETTER' => ($system->SETTINGS['newsletter'] == 1),

	'B_PAYPAL' => ($gateway_data['paypal_active'] == 1),

	'B_AUTHNET' => ($gateway_data['authnet_active'] == 1),

	'B_WORLDPAY' => ($gateway_data['worldpay_active'] == 1),

	'B_TOOCHECKOUT' => ($gateway_data['toocheckout_active'] == 1),

	'B_MONEYBOOKERS' => ($gateway_data['skrill_active'] == 1),

	'B_BANK_TRANSFER' => ($gateway_data['bank_active'] == 1),

	'FBOOK_EMAIL' => $fbconnected,

	'FBOOK_ID' => (isset($_SESSION['FBOOK_USER_IDS'])) ? $_SESSION['FBOOK_USER_IDS'] : '',

	'AVATAR' => $user->user_data['avatar'],

	//These are used in the bootstrap 3 theme

	'ACTIVEACCOUNTTAB' => 'class="active"',

	'ACTIVEEDITACCOUNT' => 'class="active"',

	'ACTIVEACCOUNTPANEL' => 'active',

	'B_SMSACTIVATED' => $smsSettings['smsActivated'] == 'n' ? true : false,

	'SMSPHONENUMBER' => isset($smsSettings['cellPhoneNumber']) !='' ? $smsSettings['cellPhoneNumber'] : '',

	'CODESTRENGTH1' => $smsSettings['codeStrength'] == 'y' ? 'checked="checked"' : '',

	'CODESTRENGTH2' => $smsSettings['codeStrength'] == 'n' ? 'checked="checked"' : '',

	'CODESTRENGTH' => $smsSettings['codeStrength'] == 'y' ? 'alert alert-success' : 'alert alert-danger',

	'LOGINALERT1' => $smsSettings['loginAlert'] == 'y' ? 'checked="checked"' : '',

	'LOGINALERT2' => $smsSettings['loginAlert'] == 'n' ? 'checked="checked"' : '',

	'MESSAGEALERT1' => $smsSettings['messageAlert'] == 'y' ? 'checked="checked"' : '',

	'MESSAGEALERT2' => $smsSettings['messageAlert'] == 'n' ? 'checked="checked"' : '',

	'WONITEMALERT1' => $smsSettings['itemWonAlert'] == 'y' ? 'checked="checked"' : '',

	'WONITEMALERT2' => $smsSettings['itemWonAlert'] == 'n' ? 'checked="checked"' : '',

	'ITEMSOLDALERT1' => $smsSettings['itemSoldAlert'] == 'y' ? 'checked="checked"' : '',

	'ITEMSOLDALERT2' => $smsSettings['itemSoldAlert'] == 'n' ? 'checked="checked"' : '',

	'BIDALERT1' => $smsSettings['outBiddedAlert'] == 'y' ? 'checked="checked"' : '',

	'BIDALERT2' => $smsSettings['outBiddedAlert'] == 'n' ? 'checked="checked"' : '',

	'LOGINALERT' => $smsSettings['loginAlert'] == 'y' ? 'alert alert-success' : 'alert alert-danger',

	'MESSAGEALERT' => $smsSettings['messageAlert'] == 'y' ? 'alert alert-success' : 'alert alert-danger',

	'WONITEMALERT' => $smsSettings['itemWonAlert'] == 'y' ? 'alert alert-success' : 'alert alert-danger',

	'ITEMSOLDALERT' => $smsSettings['itemSoldAlert'] == 'y' ? 'alert alert-success' : 'alert alert-danger',

	'BIDALERT' => $smsSettings['outBiddedAlert'] == 'y' ? 'alert alert-success' : 'alert alert-danger',

	'RESENDCODE' => isset($smsSettings['smsActivationCode']) !='' ? true : false,

	'ALLOWEDSIZE' => $system->SETTINGS['minimum_password_length'],

	'PASSWORD_SIZE' => sprintf($MSG['3500_1015639'], $system->SETTINGS['minimum_password_length']),

	'B_SMS' => ($system->SETTINGS['sms_alerts'] == 'y') ? true : false

));



include 'header.php';

$template->set_filenames(array(

		'body' => 'edit_data.tpl'

		));

$template->display('body');

include 'footer.php';