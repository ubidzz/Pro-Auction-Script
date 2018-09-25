<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
 
if (!defined('InProAuctionScript')) exit('Access denied');

// Errors handling functions
if (!function_exists('MySQLError'))
{
	function MySQLError($Q, $line = '', $page = '')
	{
		global 	$ERR, $system, $_SESSION;

		$SESSION_ERROR = $ERR['001'] . "\t" . $Q . "\n\t" . mysql_error() . "\n\tpage:" . $page . " line:" . $line;
		if (!isset($_SESSION['SESSION_ERROR']) || !is_array($_SESSION['SESSION_ERROR']))
		{
			$_SESSION['SESSION_ERROR'] = array();
		}
		$_SESSION['SESSION_ERROR'][] = $SESSION_ERROR;
		$system->log('error', $SESSION_ERROR);
	}
}

if (!function_exists('ProAuctionScriptErrorHandler'))
{
	function ProAuctionScriptErrorHandler($errno, $errstr, $errfile, $errline)
	{
		global $system, $_SESSION;
		switch ($errno)
		{
			case E_USER_ERROR:
				$error = "<b>My ERROR</b> [$errno] $errstr\n";
				$error .= "  Fatal error on line $errline in file $errfile";
				$error .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")\n";
				$error .= "Aborting...\n";
				break;
		
			case E_USER_WARNING:
				$error = "<b>My WARNING</b> [$errno] $errstr on $errfile line $errline\n";
				break;
		
			case E_USER_NOTICE:
				$error = "<b>My NOTICE</b> [$errno] $errstr on $errfile line $errline\n";
				break;
		
			default:
				$error = "Unknown error type: [$errno] $errstr on $errfile line $errline\n";
				break;
		}
		if (!isset($_SESSION['SESSION_ERROR']) || !is_array($_SESSION['SESSION_ERROR']))
		{
			$_SESSION['SESSION_ERROR'] = array();
		}
		$_SESSION['SESSION_ERROR'][] = $error;
		// log the error
		$system->log('error', $error);
		if ($errno == E_USER_ERROR)
			exit(1);
		return true;
	}
}
?>