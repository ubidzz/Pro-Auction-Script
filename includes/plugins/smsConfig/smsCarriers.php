<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');

$cuntry_array = array(
	'Argentina', 
	'Australia', 
	'Canada', 
	'China', 
	'Colombia', 
	'Costa Rica', 
	'France', 
	'Germany', 
	'Guyana', 
	'Hong Kong', 
	'Iceland', 
	'India', 
	'Israel', 
	'Mauritius',
	'Nicaragua',
	'Panama',
	'Puerto Rico',
	'Russia',
	'Singapore',
	'South Africa',
	'South Korea',
	'Spain',
	'Switzerland',
	'United Kingdom',
	'United States',
	'Virgin Islands'
);
	
if(isset($user->user_data['country']) && in_array($user->user_data['country'], $cuntry_array))
{
	if($user->user_data['country'] == 'Argentina')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Argentina.php';
	}elseif($user->user_data['country'] == 'Australia')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Australia.php';
	}elseif($user->user_data['country'] == 'Canada')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Canada.php';
	}elseif($user->user_data['country'] == 'China')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/China.php';
	}elseif($user->user_data['country'] == 'Colombia')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Colombia.php';
	}elseif($user->user_data['country'] == 'Costa Rica')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/CostaRica.php';
	}elseif($user->user_data['country'] == 'France')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/France.php';
	}elseif($user->user_data['country'] == 'Germany')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Germany.php';
	}elseif($user->user_data['country'] == 'Guyana')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Guyana.php';
	}elseif($user->user_data['country'] == 'Hong Kong')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/HongKong.php';
	}elseif($user->user_data['country'] == 'Iceland')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Iceland.php';
	}elseif($user->user_data['country'] == 'India')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/India.php';
	}elseif($user->user_data['country'] == 'Israel')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Israel.php';
	}elseif($user->user_data['country'] == 'Mauritius')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Mauritius.php';
	}elseif($user->user_data['country'] == 'Mexico')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Mexico.php';
	}elseif($user->user_data['country'] == 'Nicaragua')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Nicaragua.php';
	}elseif($user->user_data['country'] == 'Panama')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Panama.php';
	}elseif($user->user_data['country'] == 'Puerto Rico')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/PuertoRico.php';
	}elseif($user->user_data['country'] == 'Russia')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Russia.php';
	}elseif($user->user_data['country'] == 'Singapore')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Singapore.php';
	}elseif($user->user_data['country'] == 'South Africa')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/SouthAfrica.php';
	}elseif($user->user_data['country'] == 'South Korea')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/SouthKorea.php';
	}elseif($user->user_data['country'] == 'Spain')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Spain.php';
	}elseif($user->user_data['country'] == 'Switzerland')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/Switzerland.php';
	}elseif($user->user_data['country'] == 'United Kingdom')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/UnitedKingdom.php';
	}elseif($user->user_data['country'] == 'United States')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/UnitedStates.php';
	}elseif($user->user_data['country'] == 'Virgin Islands')
	{
		include PLUGIN_PATH . 'smsConfig/carriers/VirginIslands.php';
	}
}

