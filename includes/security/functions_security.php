<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
if (!defined('InProAuctionScript')) exit('Access denied');
if (!defined('SECURITY_PATH')) exit('Access denied');

if ($system->SETTINGS['encryptionType'] == 'n' && function_exists('mcrypt_encrypt')) 
{	
	include SECURITY_PATH . 'mcrypt.php';
}
elseif($system->SETTINGS['encryptionType'] == 'y' && extension_loaded('openssl'))
{
	include SECURITY_PATH . 'openssl.php';
}