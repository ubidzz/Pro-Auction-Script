<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);
$mail_protocol = array('0' => 'Pro-Auction-Script  MAIL', '1' => 'MAIL', '2' => 'SMTP', '4' => 'SENDMAIL', '5'=> 'QMAIL', '3' => 'NEVER SEND EMAILS (may be useful for testing purposes)');
$smtp_secure_options =array('none' => 'None', 'tls' => 'TLS', 'ssl' => 'SSL');
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// checks 
	if (intval($_POST['mail_protocol']) == 2)
	{
		if (empty($_POST['smtp_host']) || empty($_POST['smtp_username']) || empty($_POST['smtp_password']) || empty($_POST['smtp_port']) || intval($_POST['smtp_port']) <= 0 )
		{ 
			$ERROR = $MSG['3500_1015563'];
		}
	}
	
	if (array_key_exists(intval($_POST['mail_protocol']), $mail_protocol))
	{
	
	 	if  (intval($_POST['mail_protocol']) !== 2)
	 	{
	   		// Update database
			$system->writesetting("settings", "mail_protocol", $_POST['mail_protocol'], 'bool_int');
			$system->writesetting("settings", "mail_parameter", $_POST['mail_parameter'], 'str');
			$system->writesetting("settings", "alert_emails", $_POST['alert_emails'], 'str');
	    }
		else
		{
			$system->writesetting("settings", "mail_protocol", '2', 'bool_int');
			$system->writesetting("settings", "smtp_authentication", $_POST['smtp_authentication'], 'bool');
			$system->writesetting("settings", "smtp_security", $_POST['smtp_security'], 'str');
			$system->writesetting("settings", "smtp_port", $_POST['smtp_port'], 'int');
			$system->writesetting("settings", "smtp_username", $_POST['smtp_username'], 'str');
			$system->writesetting("settings", "smtp_password", $_POST['smtp_password'], 'str');
			$system->writesetting("settings", "smtp_host", $_POST['smtp_host'], 'str');
			$system->writesetting("settings", "alert_emails", $_POST['alert_emails'], 'str');	  
	    }
	  	$ERROR = $MSG['3500_1015676'];
	} 
}

$selectsetting = isset($system->SETTINGS['mail_protocol'])? $system->SETTINGS['mail_protocol'] : '0';
loadblock($MSG['3500_1015551'], '', generateSelect('mail_protocol', $mail_protocol, $selectsetting));
loadblock($MSG['3500_1015552'] , '<span class="non_smtp para">' . $MSG['3500_1015553'], 'text', 'mail_parameter', $system->SETTINGS['mail_parameter']);
loadblock($MSG['3500_1015564'] .'<span class="smtp"></span>' . $MSG['3500_1015783'], '', '', '', '', array(), true);
loadblock($MSG['3500_1015560'], '<span class="smtp"></span>', 'yesno', 'smtp_authentication', $system->SETTINGS['smtp_authentication'], array($MSG['030'], $MSG['029']));
$SMTPselectsetting = isset($system->SETTINGS['smtp_security'])? $system->SETTINGS['smtp_security'] : 'none';
loadblock($MSG['3500_1015559'] , '<span class="smtp"></span>', generateSelect('smtp_security', $smtp_secure_options, $SMTPselectsetting));
loadblock($MSG['3500_1015558'] , '<span class="smtp"></span>', 'text', 'smtp_port', $system->SETTINGS['smtp_port']);
loadblock($MSG['3500_1015556'], '<span class="smtp"></span>', 'text', 'smtp_username', $system->SETTINGS['smtp_username']);
loadblock($MSG['3500_1015557'] , '<span class="smtp"></span>', 'password', 'smtp_password', $system->SETTINGS['smtp_password']);
loadblock($MSG['3500_1015554'] , '<span class="smtp"></span>', 'text', 'smtp_host', $system->SETTINGS['smtp_host']);
loadblock($MSG['3500_1015561'] , sprintf($MSG['3500_1015562'], $system->SETTINGS['adminmail']), 'text', 'alert_emails', $system->SETTINGS['alert_emails']);
$mail_info2 = '';
// send test email
if (isset($_GET['test_email']))
{
	$user_name      = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
	$to_email       = filter_var($_POST["user_email"], FILTER_SANITIZE_EMAIL);
	$subject        = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
	$message        = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
    
	$emailer = new email_handler();
	$send_mail = $emailer->email_basic($subject, $to_email, $message);
	if($send_mail)
    {
		$output = json_encode(array('type'=>'error', 'text' => 'Could not send mail! Please check your PHP mail configuration.Response:<br>' . $send_mail));
		die($output);
    }
	else
	{
		$output = json_encode(array('type'=>'message', 'text' => 'Hi '.$user_name .' Your email(s) has been processed and sent. No error(s) to report.'));
		die($output);
    }
}
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'TYPENAME' => $MSG['524'],
	'PAGENAME' => $MSG['3500_1015675'],
	'PAGETITLE' => $MSG['3500_1015675'],
	'MAIL_PROTOCOL' => $mail_protocol[$system->SETTINGS['mail_protocol']],
	'SMTP_AUTH' => $system->SETTINGS['smtp_authentication'],
	'SMTP_SEC' => $system->SETTINGS['smtp_security'],
	'SMTP_PORT' => (!empty($system->SETTINGS['smtp_port']) && is_numeric($system->SETTINGS['smtp_port'])) ? $system->SETTINGS['smtp_port'] : 25,
	'SMTP_USER' => $system->SETTINGS['smtp_username'],
	'SMTP_PASS' => $system->SETTINGS['smtp_password'],
	'SMTP_HOST' => $system->SETTINGS['smtp_host'],
	'ALERT_EMAILS' => $system->SETTINGS['alert_emails'],
	'ADMIN_EMAIL' => $system->SETTINGS['adminmail'],
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'emailsettings.tpl'
		));
$template->display('body');
include 'adminFooter.php';