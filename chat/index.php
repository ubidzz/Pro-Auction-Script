<?php
include '../common.php';
// If user is not logged in redirect to login page
if (!$user->checkAuth())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'chat';
	header('location: ' . $system->SETTINGS['siteurl'] . 'user_login.php');
	exit;
}
// If the live chat feacture is turned off
if($system->SETTINGS['liveChat'] == 'n')
{
	header('location: ' . $system->SETTINGS['siteurl']);
	exit;
}
//
// Whatever Parameters you need to set, goes here
//
require_once MAIN_PATH . "chat/src/phpfreechat.class.php";
$params = array();
$params["data_public_url"]   = "/chat/data/public";
$params["container_type"] = "mysql";
$params["container_cfg_mysql_host"] = $DbHost;
$params["container_cfg_mysql_database"] = $DbDatabase; 
$params["container_cfg_mysql_table"] = $DBPrefix . "phpchat"; 
$params["container_cfg_mysql_username"] = $DbUser; 
$params["container_cfg_mysql_password"] = $DbPassword;
$params["title"] = $system->SETTINGS['liveChatTitle'];
$params["nick"] = $user->user_data['nick'];  // setup the intitial nickname
$params["serverid"] = md5(__FILE__); // calculate a unique id for this chat
if(intval($user->user_data['admin']) == 2) {
	$params['isadmin'] = true;
}elseif(intval($user->user_data['admin']) == 1) {
	$params['isadmin'] = true;
}
if($system->SETTINGS['liveChatLockNick'] == 'y') {
	$params["frozen_nick"] = true;
}else{
	$params["frozen_nick"] = false;
}
if(intval($system->SETTINGS['liveChatTheme']) == 1) {
	$params["theme"] = "green";
}elseif(intval($system->SETTINGS['liveChatTheme']) == 2) {
	$params["theme"] = "blune";
}elseif(intval($system->SETTINGS['liveChatTheme']) == 3) {
	$params["theme"] = "zilveer";
}else{
	$params["theme"] = "default";
}
$params["nickmeta_private"] = array('ip');
$params["max_privmsg"] = intval($system->SETTINGS['liveChatPMLimit']);
$params["max_text_len"] = intval($system->SETTINGS['liveChatTextLen']);
$params["max_msg"] = intval($system->SETTINGS['liveChatMaxMSG']);
$params["max_displayed_lines"] = intval($system->SETTINGS['liveChatMaxDisplayMSG']);
$params["display_pfc_logo"] = false;
$params['max_nick_len'] = 55;
$params['timeout'] = 1000000;
//$params["debug"] = true;
$chat = new phpFreeChat($params);

// Create the Chat HTML
$chat_html = $chat->printChat(true);

// Store the HTML in the template variables
$template->assign_vars(array(
	'CHAT_HTML' => $chat_html,
	'B_ADMIN_COMMANDS' => $user->user_data['admin'] == 1 || $user->user_data['admin'] == 2 ? true : false
));

// Lets build a page ...
include '../header.php';
$template->set_filenames(array(
 	'body' => 'phpChat.tpl')
);
$template->display('body');    
include '../footer.php';