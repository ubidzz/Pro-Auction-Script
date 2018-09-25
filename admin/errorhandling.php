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
	// clean up everything
	$conf = array();
	$conf['safe'] = $system->SETTINGS['htmLawed_safe'];
	$conf['deny_attribute'] = $system->SETTINGS['htmLawed_deny_attribute'];
	$text = htmLawed($_POST['errortext'], $conf);

	// Update database
	$system->writesetting("settings", "errortext", $text, 'str');
	$ERROR = $MSG['413'];
}

loadblock($MSG['411'], $MSG['410'], $CKEditor->editor('errortext', stripslashes($system->SETTINGS['errortext'])));

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'SITEURL' => $system->SETTINGS['siteurl'],
	'TYPENAME' => $MSG['5142'],
	'PAGENAME' => '<a style="color:lime" href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_error_handling" target="_blank">' . $MSG['409'] . '</a>',
	'PAGETITLE' => $MSG['409']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';