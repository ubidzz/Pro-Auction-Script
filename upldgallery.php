<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/

/*******************************************************************************

 *   This Pro-Auction-Script is a Paid version of Pro-Auction-Script script.

 *   You are not allowed to resell/sell this script is  copyrighted to Pro-Auction-Script.com.

 *   If you have been sold this script from a 3rd party and not from the 

 *   https://Pro-Auction-Script.com website or https://ubidzz.com ask for a refund.

 *******************************************************************************/

/*******************************************************************************

 * If you bought this script from the https://Pro-Auction-Script.com website or https://ubidzz.com 

 * Please register at https://Pro-Auction-Script.com/forum and contact the Pro-Auction-Script admin  

 * at https://Pro-Auction-Script.com/forum with your order number and full name so we can change 

 * your group to premium so you can view the paid area on the forums.

 *******************************************************************************/

 

include 'common.php';



if (!$user->checkAuth())

{

	//if your not logged in you shouldn't be here

	header("location: user_login.php");

	exit;

}

$jsfiles = 'js/jquery.js;';



$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = :fee";

$params = array(

	array(':fee', 'picture_fee', 'str')

);

$db->query($query, $params);

$pictureFees = $db->result('value');



$template->assign_vars(array(

		'SITENAME' => $system->SETTINGS['sitename'],

		'SITEURL' => $system->SETTINGS['siteurl'],

		'DOCDIR' => $DOCDIR, // Set document direction (set in includes/messages.XX.inc.php) ltr/rtl

		'LANGUAGE' => $language,

		'THEME' => $system->SETTINGS['theme'],

		'JSFILES' => $jsfiles,

		'PICURL' => (isset($_SESSION['SELL_pict_url'])) ? $_SESSION['SELL_pict_url'] : 'Default',

		'B_PICURL' => (isset($_SESSION['SELL_pict_url'])),

		'MAXPICS' => sprintf($MSG['673'], $system->SETTINGS['maxpictures'], formatSizeUnits($system->SETTINGS['maxuploadsize'])),

		'FREEMAXPIC' => $pictureFees > 0 ? sprintf($MSG['3500_1015761'], $system->SETTINGS['freemaxpictures'], $system->SETTINGS['freemaxpictures'], $system->print_money($pictureFees)) : ''

		));

$template->set_filenames(array(

		'body' => 'upldgallery.tpl'

		));

$template->display('body');