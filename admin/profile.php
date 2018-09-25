<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);

$MANDATORY_FIELDS = unserialize($system->SETTINGS['mandatory_fields']);
$DISPLAYED_FIELDS = unserialize($system->SETTINGS['displayed_feilds']);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	$MANDATORY_FIELDS = array(
			'birthdate' => $_POST['birthdate'],
			'address' => $_POST['address'],
			'city' => $_POST['city'],
			'prov' => $_POST['prov'],
			'country' => $_POST['country'],
			'zip' => $_POST['zip'],
			'tel' => $_POST['tel']
			);
			
	$DISPLAYED_FIELDS = array(
			'birthdate_regshow' => $_POST['birthdate_regshow'],
			'address_regshow' => $_POST['address_regshow'],
			'city_regshow' => $_POST['city_regshow'],
			'prov_regshow' => $_POST['prov_regshow'],
			'country_regshow' => $_POST['country_regshow'],
			'zip_regshow' => $_POST['zip_regshow'],
			'tel_regshow' => $_POST['tel_regshow']
			);

	// common sense check field cant be required if its not visible
	$required = array_keys($MANDATORY_FIELDS);
	$display = array_keys($DISPLAYED_FIELDS);
	for ($i = 0; $i <= 7; $i++)
	{
		if ($MANDATORY_FIELDS[$required[$i]] == 'y' && $DISPLAYED_FIELDS[$display[$i]] == 'n')
		{
			$ERROR = $MSG['809'];
		}
	}
	
	if(empty($_POST['username_size']))
	{
		$ERROR = $MSG['3500_1015644'];
	}
	elseif(empty($_POST['username_size']))
	{
		$ERROR = $MSG['3500_1015645'];
	}
	
	if (!isset($ERROR))
	{
		$system->writesetting("settings", "mandatory_fields", $MANDATORY_FIELDS, 'array');
		$system->writesetting("settings", "displayed_feilds", $DISPLAYED_FIELDS, 'array');
		$system->writesetting("settings", "minimum_username_length", $_POST['username_size'], 'int');
		$system->writesetting("settings", "minimum_password_length", $_POST['password_size'], 'int');
		$ERROR = $MSG['779'];
	}
}

$template->assign_vars(array(
	'USERNAME_SIZE' => $system->SETTINGS['minimum_username_length'],
	'PASSWORD_SIZE' => $system->SETTINGS['minimum_password_length'],
	'REQUIRED_0' => ($MANDATORY_FIELDS['birthdate'] == 'y') ? true : false,
	'REQUIRED_1' => ($MANDATORY_FIELDS['address'] == 'y') ? true : false,
	'REQUIRED_2' => ($MANDATORY_FIELDS['city'] == 'y') ? true : false,
	'REQUIRED_3' => ($MANDATORY_FIELDS['prov'] == 'y') ? true : false,
	'REQUIRED_4' => ($MANDATORY_FIELDS['country'] == 'y') ? true : false,
	'REQUIRED_5' => ($MANDATORY_FIELDS['zip'] == 'y') ? true : false,
	'REQUIRED_6' => ($MANDATORY_FIELDS['tel'] == 'y') ? true : false,
	'DISPLAYED_0' => ($DISPLAYED_FIELDS['birthdate_regshow'] == 'y') ? true : false,
	'DISPLAYED_1' => ($DISPLAYED_FIELDS['address_regshow'] == 'y') ? true : false,
	'DISPLAYED_2' => ($DISPLAYED_FIELDS['city_regshow'] == 'y') ? true : false,
	'DISPLAYED_3' => ($DISPLAYED_FIELDS['prov_regshow'] == 'y') ? true : false,
	'DISPLAYED_4' => ($DISPLAYED_FIELDS['country_regshow'] == 'y') ? true : false,
	'DISPLAYED_5' => ($DISPLAYED_FIELDS['zip_regshow'] == 'y') ? true : false,
	'DISPLAYED_6' => ($DISPLAYED_FIELDS['tel_regshow'] == 'y') ? true : false,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['048'],
	'PAGETITLE' => $MSG['048']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'profile.tpl'
		));
$template->display('body');
include 'adminFooter.php';