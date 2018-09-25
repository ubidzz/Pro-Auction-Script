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
	$htmLawed_safe = $_POST['htmLawed_safe'] == 2 ? 0 : 1;
	$encryptionKey = $_POST['key'];
	if($security->checkKey(str_replace(' ', '', $encryptionKey))) {
		$system->writesetting("settings", "encryption_key", base64_encode($encryptionKey), 'str');
	}else{
		$ERROR = $ERR['081'] . '<br>';
	}
	// Update data
	$system->writesetting("settings", "https", $_POST['https'], 'bool');
	$system->writesetting("settings", "https_url", $_POST['https_url'], 'str');
	$system->writesetting("settings", "cookiesname", $_POST['cookie_name'], 'str');
	$system->writesetting("settings", "sessionsname", $_POST['sessions_name'], 'str');
	$system->writesetting("settings", "customcode", $_POST['custom_code'], 'str');
	$system->writesetting("settings", "encryptionType", $_POST['encryptionType'], 'bool');
	$system->writesetting("settings", "htmLawed_safe", $htmLawed_safe, 'bool_int');
	$system->writesetting("settings", "htmLawed_deny_attribute", $_POST['htmLawed_deny_attribute'], 'str');
	
	// changing the admin folder name and updating the robots.txt
	$stored_folder = MAIN_PATH . $system->SETTINGS['admin_folder'];
	if ($system->SETTINGS['admin_folder'] != $_POST['new_admin_folder'] && isset($_POST['new_admin_folder']))
	{
		//Changing the admin folder name
		$new_name = $_POST['new_admin_folder'];
		rename($stored_folder, MAIN_PATH . $new_name);
			
		//Updating the robots.txt file this helps prevent crawling 
		$replacing = str_replace('/' . $system->SETTINGS['admin_folder'] . '/', '/' . $new_name . '/', file_get_contents('../robots.txt')); 
		file_put_contents('../robots.txt', $replacing); //edit the file
					
		//Updating the admin_folder column in the database
		$system->writesetting("settings", "admin_folder", $new_name, 'str');
			
		$_SESSION['EROR'] = $MSG['30_0231'];
		$link = $system->SETTINGS['siteurl'] . $new_name . '/security.php';
		return header('location: ' . $link);
		exit();
	}
	$ERROR .= $MSG['3500_1015544'];
}

// SLL settings
loadblock($MSG['1022'], '', '', '', '', array(), true);
loadblock($MSG['1023'], $MSG['1024'], 'yesno', 'https', $system->SETTINGS['https'], array($MSG['030'], $MSG['029']));
loadblock($MSG['801'], $MSG['802'], 'text', 'https_url', $system->SETTINGS['https_url']);

loadblock($MSG['3500_1015817'], '', '', '', '', array(), true);
loadblock($MSG['3500_1015818'], $MSG['3500_1015819'], 'batch', 'htmLawed_safe', $system->SETTINGS['htmLawed_safe'] == 1 ? 1 : 2, array($MSG['030'], $MSG['029']));
loadblock($MSG['3500_1015820'], $MSG['3500_1015821'], 'text', 'htmLawed_deny_attribute', $system->SETTINGS['htmLawed_deny_attribute']);

$template->assign_vars(array(
	'TYPENAME' => $MSG['5142'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_security_settings" target="_blank">' . $MSG['3500_1015543'] . '</a>',
	'PAGETITLE' => $MSG['3500_1015543']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';