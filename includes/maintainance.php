<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/


if (basename($_SERVER['PHP_SELF']) != 'user_login.php')
{
	// Check if we are in Maintainance mode
	// And if the logged in user is the superuser
	if ($system->check_maintainance_mode())
	{
		echo stripslashes($system->SETTINGS['maintainancetext']);
		exit;
	}
}