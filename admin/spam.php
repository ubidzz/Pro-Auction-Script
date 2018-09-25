<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (($_POST['spam_sendtofriend'] == 2 || $_POST['spam_register'] == 2) && empty($_POST['recaptcha_public']) && empty($_POST['recaptcha_private']))
	{
		$ERROR = $MSG['751'];
	}
	else
	{
		if (empty($_POST['disposable_email']) && $_POST['disposable_email'] != 'y') $_POST['disposable_email'] = 'n';
		
		$image_captcha_length = $_POST['image_captcha_length'];
		if($image_captcha_length == 3)
		{
			$image_captcha_width = 115;
		}
		elseif($image_captcha_length == 4)
		{
			$image_captcha_width = 145;
		}
		elseif($image_captcha_length == 5)
		{
			$image_captcha_width = 175;
		}
		elseif($image_captcha_length == 6)
		{
			$image_captcha_width = 205;
		}
		elseif($image_captcha_length == 7)
		{
			$image_captcha_width = 235;
		}
		elseif($image_captcha_length == 8)
		{
			$image_captcha_width = 265;
		}
		elseif($image_captcha_length == 9)
		{
			$image_captcha_width = 295;
		}
		elseif($image_captcha_length == 10)
		{
			$image_captcha_width = 325;
		}
		
		$system->writesetting("settings", "recaptcha_public", $_POST['recaptcha_public'], 'str');
		$system->writesetting("settings", "recaptcha_private", $_POST['recaptcha_private'], 'str');
		$system->writesetting("settings", "spam_register", $_POST['spam_register'], 'bool_int');
		$system->writesetting("settings", "spam_sendtofriend", $_POST['spam_register'], 'bool_int');
		$system->writesetting("settings", "disposable_email_block", $_POST['disposable_email'], 'bool');
		$system->writesetting("settings", "image_captcha_length", $image_captcha_length, 'int');
		$system->writesetting("settings", "image_captcha_width", $image_captcha_width, 'int');
		$ERROR = $MSG['750'];
	}
}

loadblock($MSG['746'], $MSG['748'], 'text', 'recaptcha_public', $system->SETTINGS['recaptcha_public']);
loadblock($MSG['747'], '', 'text', 'recaptcha_private', $system->SETTINGS['recaptcha_private']);
loadblock($MSG['743'], $MSG['745'], 'select3num', 'spam_register', $system->SETTINGS['spam_register'], array($MSG['740'], $MSG['741'], $MSG['742']));
loadblock($MSG['744'], '', 'select3num', 'spam_sendtofriend', $system->SETTINGS['spam_sendtofriend'], array($MSG['740'], $MSG['741'], $MSG['742']));
loadblock($MSG['3500_1015545'], $MSG['3500_1015546'], 'yesno', 'disposable_email', $system->SETTINGS['disposable_email_block'], array($MSG['030'], $MSG['029']));

loadblock($MSG['3500_1015661'], '', '', '', '', array(), true);
loadblock($MSG['3500_1015662'], $MSG['3500_1015663'], 'text', 'image_captcha_length', $system->SETTINGS['image_captcha_length']);


$template->assign_vars(array(
	'TYPENAME' => $MSG['5142'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['749'],
	'PAGETITLE' => $MSG['749']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';