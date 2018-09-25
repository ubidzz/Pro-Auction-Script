<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include CONFIG_PATH . 'class_language_functions.php';
$langClass = new language();

$country = (isset($_GET['country'])) ? $security->decrypt($_GET['country']) : 'EN';

if(isset($_POST['action']) && $_POST['action'] == 'update')
{
	$langClass->buildFile();
}

// list of all language flags
foreach ($LANGUAGES as $lang => $value)
{
	$template->assign_block_vars('languages', array(
			'LANG' => $value,
			'B_DEFAULT' => ($lang == $system->SETTINGS['defaultlanguage']),
			'LANGS' => $security->encrypt($value)
		));
}
// display the default language
// display the default $ERR language
foreach ($ERR as $k => $v)
{
	$template->assign_block_vars('default_err', array(
		'KEY' => $k,
		'VALUE' => $v,
		'TRANS' => $langClass->getErrName($country, $k)
	));
}
// display the default $MSG language
foreach ($MSG as $k => $v)
{
	$template->assign_block_vars('default_msg', array(
		'KEY' => $k,
		'VALUE' => $v,
		'TRANS' => $langClass->getName($country, $k)
	));
}

$template->assign_vars(array(
	'CHAR' => $langClass->getCharset($country),
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'DOCDIR' => $langClass->getDocdir($country),
	'COUNTRY' => $country
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'translate.tpl'
		));
$template->display('body');
include 'adminFooter.php';