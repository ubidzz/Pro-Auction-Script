<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
@ob_start();
if (version_compare(phpversion(), '5.4.0', '<=')) {
    if(session_id() == '') {
   		@session_start();
    }
}
else
{
    if (session_status() != PHP_SESSION_ACTIVE) {
   		@session_start();
	}
}

//Normal Logging errors
//$error_reporting = E_ALL^E_NOTICE;
$error_reporting = E_ALL; // use this for debugging every page

define('InProAuctionScript', 1);
define('TrackUserIPs', 1);

// check for the config file or the install folder and load the config file if it exists
$install_path = (!defined('InAdmin')) ? 'install/install.php' : '../install/install.php';
if((file_exists($install_path)) || (!@include('includes/config/config.inc.php')))
{
	header('location: ' . $install_path);
	exit;
}
$MD5_PREFIX = (!isset($MD5_PREFIX)) ? 'XO8sytc8G5enleZLUnbfCCUZJojiCwkp' : $MD5_PREFIX; // if the user didnt set a code

//define the system paths
define('MAIN_PATH', $main_path);
define('CACHE_PATH', MAIN_PATH . 'cache/');
define('INCLUDE_PATH', MAIN_PATH . 'includes/');
define('DATABASE_PATH', INCLUDE_PATH . 'database/');
define('PLUGIN_PATH', INCLUDE_PATH . 'plugins/');
define('LANGUAGE_PATH', MAIN_PATH . 'language/');
define('SECURITY_PATH', INCLUDE_PATH . 'security/');
define('FEES_PATH', INCLUDE_PATH . 'fees/');
define('UPLOAD_FOLDER', 'uploaded/');
define('UPLOAD_PATH', MAIN_PATH . UPLOAD_FOLDER);
define('CONFIG_PATH', INCLUDE_PATH . 'config/');

//// Including all the pages that are need to run the Pro-Auction-Script script ////
/// load all the pages and classes that is needed to run the script ///

// SQL handler, classes
include DATABASE_PATH . 'Database.php';
include DATABASE_PATH . 'DatabasePDO.php';
$db = new DatabasePDO();

// Connect to the SQL database
if (isset($CHARSET)) {
	$db->connect($DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix, $CHARSET);
}else{
	$db->connect($DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix, 'UTF-8');
}

// Overall system main handler
include INCLUDE_PATH . 'functions_global.php';
$system = new global_class();

//Logging all the debugging errors
if($system->SETTINGS['debugging'] == 'y') $error_reporting = E_ALL; // use this for debugging

// Security handler and classes
include SECURITY_PATH . 'functions_security.php';
$security = new security();

// User handler and classes
include INCLUDE_PATH . 'class_user.php';
$user = new user();

// Build the language messages
include INCLUDE_PATH . 'messages.inc.php';

// Categories handler
include CONFIG_PATH . 'class_MPTTcategories.php';

// Fees handler
include FEES_PATH . 'process_fees.php';

//template handler and class
include PLUGIN_PATH . 'template/Template.php';
$template = new template();

//password handler and class
include PLUGIN_PATH . 'PHPass/phpass.php';
$phpass = new PasswordHash(8, false);

// SEO handler and functions
include PLUGIN_PATH . 'SEO/seo-core.php';

// Multi language Categories array
include LANGUAGE_PATH . $language . '/categories.inc.php';

//Facebook login function
include PLUGIN_PATH . 'facebook/facebook_cnt.php';
$facebookAPP = new FacebookConnect();

//Email handler and classes
include PLUGIN_PATH . 'PHPMailer/class_email_handler.php';
$send_email = new send_email();

//SMS handler and classes
include PLUGIN_PATH . 'smsConfig/smsSettings.php';
$smsAlerts = new SMSsettings();

// Error handler
include INCLUDE_PATH . 'errors.inc.php';

//Error function for all errors to be submitted to db
set_error_handler('ProAuctionScriptErrorHandler', $error_reporting);

// add auction types
$system->SETTINGS['auction_types'] = array();
if ($system->SETTINGS['standard_auctions'] == 'y') {		
	//only standard auction
	$system->SETTINGS['auction_types'][1] = $MSG['1021'];
}
if ($system->SETTINGS['dutch_auctions'] == 'y') {
	//only standard auction and dutch auction
	$system->SETTINGS['auction_types'][2] = $MSG['1020'];
}
if ($system->SETTINGS['digital_auctions'] == 'y') {
	//only standard auction and digital item auction
	$system->SETTINGS['auction_types'][3] = $MSG['350_1010'];
}

// Atuomatically login user is necessary "Remember me" option
if (!$user->logged_in && isset($_COOKIE[$system->SETTINGS['cookiesname'] . '-RM_ID']))
{
	$user->rememberMeLogin(alphanumeric($_COOKIE[$system->SETTINGS['cookiesname'] . '-RM_ID']));
}

// Convert the system clock from the default timezone to the logged in user timezone
if($user->logged_in)
{
	$smsAlerts->alertSettingHandler('loginAlert', array('userID' => $user->user_data['id']));
}


$template->set_template();