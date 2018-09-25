<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

$supportArray = checkSupportTickets();
$warningArray = checkReportedListing();

	$template->assign_vars(array(
		'DOCDIR' => $DOCDIR,
		'THEME' => $system->SETTINGS['theme'],
		'SITEURL' => $system->SETTINGS['siteurl'],
		'CHARSET' => $CHARSET,
		'EXTRAJS' => ';js/jquery-ui.js;',
		'ADMIN_USER' => $security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_USER']),
		'ADMIN_ID' => $security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_IN']),
		'LAST_LOGIN' => last_login($security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_TIME'])),
		'LASTLOGIN' => (isset($last_login)),
       	'LASTREPORT' => (isset($last_report)),
       	'WARNINGREPORT' => $warningArray['reports'],
       	'WARNINGMESSAGE' => (isset($warningArray['warning'])),
       	'SUPPORTMESSAGE' => ($supportArray['reports'] == 1) ? true : false,
       	'MESSAGES' => $supportArray['supports'],
       	'ADMIN_FOLDER' => $system->SETTINGS['admin_folder'],
		'ADMIN_NOTES' => getAdminNotes(),
		'MYVERSION' => $api->version_check($api->check()),
		'THIS_VERSION' => $system->SETTINGS['version'],
		'REALVERSION' => $api->check(),
		'LANGUAGE' => $language,
		'ADMIN_THEME' => $system->SETTINGS['admin_theme'],
		'FAVICON' => 'uploaded/logos/favicon/' . $system->SETTINGS['favicon'],
		'B_MULT_LANGS' => (count($LANGUAGES) > 1),
		'FLAGS' => ShowFlags(true,true),
		'SITENAME' => $system->SETTINGS['sitename'],
		'CHECKAPI' => $api->scriptMessages(),
		'SCRIPTMESSAGE' => $api->scriptMessages(),
		'DONATE' => $api->donationMessage(),
	));
	
	foreach ($LANGUAGES as $lang => $value)
	{
		$template->assign_block_vars('langs', array(
				'LANG' => $value,
				'B_DEFAULT' => ($lang == $system->SETTINGS['defaultlanguage'])
				));
	}
	
	$template->set_filenames(array(
		'header' => 'global_header.tpl'
		));
	$template->display('header');
