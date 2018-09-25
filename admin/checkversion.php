<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
$current_page = $MSG['25_0169a'];
$gdinfo = gd_info();
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'VERSION_TITLE' => $MSG['25_0169a'],
	'REQUIREMENTS_TITLE' => $MSG['3500_1015647'],
	'PHP_VERSION' => phpversion() > '5.3.0' ? true : false,
	'CURRENT_PHP_VERSION' => phpversion(),
	'GD' => extension_loaded('gd') && function_exists('gd_info') ? true : false,
	'BCMATH' => extension_loaded('bcmath') ? true : false,
	'PDO' => extension_loaded('pdo') ? true : false,
	'HASH_HMAC' => function_exists('hash_hmac') ? true : false,
	'MBSTRING' => extension_loaded('mbstring') ? true : false,
	'HEADERS_SUPPORT' => function_exists('getallheaders') ? true : false,
	'MCRYPT_ENCRYPT' => function_exists('mcrypt_encrypt') ? true : false,
	'OPEN_BASEDIR' => function_exists('open_basedir') ? true : false,
	'ALLOW_URL_FOPEN' => ini_get('allow_url_fopen') ? true : false,
	'FREETYPE' => $gdinfo['FreeType Support'] ? true : false,
	'OPENSSL' => extension_loaded('openssl') ? true : false,
	'FOPEN' => function_exists('fopen') ? true : false,
	'FREAD' => function_exists('fread') ? true : false,
	'FILE_GET_CONTENTS' => function_exists('file_get_contents') ? true : false,
	'CURL' => function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec') && function_exists('curl_close') ? true : false,
	'PAGENAME' => $MSG['25_0169a'],
	'PAGETITLE' => $MSG['25_0169a']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'checkversion.tpl'
		));
$template->display('body');
include 'adminFooter.php';