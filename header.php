<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
if (!defined('InProAuctionScript')) exit('Access denied');

include INCLUDE_PATH . 'maintainance.php';
include INCLUDE_PATH . 'functions_banners.php';
if (basename($_SERVER['PHP_SELF']) != 'error.php')
include INCLUDE_PATH . 'stats.inc.php';
include INCLUDE_PATH . 'functions_item_counters.php';

// prepare categories list for templates/template 
// Prepare categories sorting
if ($system->SETTINGS['catsorting'] == 'alpha')
{
	$catsorting = 'ORDER BY cat_name ASC';
}
else
{
	$catsorting = 'ORDER BY cat_name DESC';
}
	
$query = "SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id = -1";
$db->direct_query($query);
$cats_ids = $db->result('cat_id');

$query = "SELECT * FROM " . $DBPrefix . "categories WHERE parent_id = :cat_ids " . $catsorting ." LIMIT :catstoshows";
$params = array(
	array(':cat_ids', $cats_ids, 'int'),
	array(':catstoshows', $system->SETTINGS['catstoshow'], 'int')
);
$db->query($query, $params);
while ($row = $db->result())
{
	$sub_counter = $row['sub_counter'];
	$cat_counter = $row['counter'];
	if ($sub_counter != 0 && $system->SETTINGS['cat_counters'] == 'y')
	{
		$count_string = ' <span class="label label-success">' . $sub_counter . '</span>';	
	}
	else
	{
		$count_string = '';
	}
	$template->assign_block_vars('cat_list_drop_down', array(
		'CATAUCNUM' => ($row['sub_counter'] != 0) ? ' <span class="label label-success">' . $row['sub_counter'] . '</span>' : '',
		'ID' => $row['cat_id'],
		'IMAGE' => (!empty($row['cat_image'])) ? '<img src="' . $row['cat_image'] . '" border=0>' : '',
		'SEO_NAME' => generate_seo_link($category_names[$row['cat_id']]),
		'COLOR' => (empty($row['cat_color'])) ? '#FFFFFF' : $row['cat_color'],
		'NAME' => $category_names[$row['cat_id']] . ' ' . $count_string
	));
}

// Build list of help topics
$query = "SELECT id, category FROM " . $DBPrefix . "faqscat_translated WHERE lang = :languages ORDER BY category ASC";
$params = array(
	array(':languages', $language, 'str')
);
$db->query($query, $params);
$i = 0;
while ($faqscat = $db->result())
{
	$template->assign_block_vars('helpbox', array(
			'ID' => $faqscat['id'],
			'TITLE' => $faqscat['category']
			));
	$i++;
}
$helpbox = ($i > 0) ? true : false;
if(isset($_POST['setCookieDirective']))
{
	if($_POST['setCookieDirective'] == 'y')
	{
		$system->SetCookieDirective();
	}
}

//metatags
$metadesc = isset($fb_desc) ? $fb_desc : ($system->SETTINGS['descriptiontag'] !='') ? $system->SETTINGS['descriptiontag'] : $system->SETTINGS['sitename'];
$wordstags = ($system->SETTINGS['keywordstag'] !='') ? stripslashes($system->SETTINGS['keywordstag']) : $system->SETTINGS['sitename'];
$wordstags = isset($page_title) !='' ? $page_title : $wordstags;

$template->assign_vars(array(
	'FLAGS' => ShowFlags(true),
	'B_MULT_LANGS' => count($LANGUAGES) > 1 ? true : false,
	'DOCDIR' => $DOCDIR, // Set document direction (set in includes/messages.XX.inc.php) ltr/rtl
	'THEME' => $system->SETTINGS['theme'],
	'PAGE_TITLE' => isset($page_title) ? $system->SETTINGS['sitename'] . ' - ' . $page_title : $system->SETTINGS['sitename'],
	'CHARSET' => $CHARSET,
	'JSFILES' => 'js/jquery.js;',
	'LOADCKEDITOR' => basename($_SERVER['PHP_SELF']) == 'sell.php',
	'ACTUALDATE' => $system->CTIME,
	'LOGO' => $system->SETTINGS['logo'] ? '<a href="' . $system->SETTINGS['siteurl'] . 'home"><img src="' . $system->SETTINGS['siteurl'] . UPLOAD_FOLDER . 'logos/' . $system->SETTINGS['logo'] . '" border="0" alt="' . $system->SETTINGS['sitename'] . '"></a>' : '&nbsp;',
	'B_BANNERMANAGER' => $system->SETTINGS['banners'] == 1 ? true : false,
	'HEADERCOUNTER' => load_counters(),
	'SITEURL' => $system->SETTINGS['siteurl'],
	'SITENAME' => $system->SETTINGS['sitename'],
	'RESENDEMAIL' => $system->SETTINGS['activationtype'] == 1 ? TRUE : FALSE,
	'Q' => isset($q) ? $q : '',
	'SELECTION_BOX' => file_get_contents(LANGUAGE_PATH . $language . '/categories_select_box.inc.php'),
	'YOURUSERNAME' => $user->logged_in ? $user->user_data['nick'] : '',
	'LANGUAGE' => $language,
	'FBOOK_APPID' => $system->SETTINGS['facebook_app_id'],
	'FBOOK_APPSECRET' => $system->SETTINGS['facebook_app_secret'],
	'B_FBOOK' => $system->SETTINGS['facebook_login'] == 'y' ? true : false,
	'B_FEES' => $system->SETTINGS['fees'] == 'y' ? true : false,
	'B_HELPBOX' => $helpbox && $system->SETTINGS['helpbox'] == 1 ? true : false,
	//Banner and adsense system
	'BANNER' => $system->SETTINGS['banners'] == 1 ? view() : '',
	'HEADER_ADSENSE' => !$system->ADSENSE['header_banner_1'] ? '' : $system->ADSENSE['header_banner_1'],
	'INDEX_ADSENSE_1' => !$system->ADSENSE['index_banner_1'] ? '' : '<div class="hidden-phone" align="center">' . $system->ADSENSE['index_banner_1'] . '</div>',
	'INDEX_ADSENSE_2' => !$system->ADSENSE['index_banner_2'] ? '' : '<div class="hidden-phone col-sm-6">' . $system->ADSENSE['index_banner_2'] . '</div>',
	'INDEX_ADSENSE_3' => !$system->ADSENSE['index_banner_3'] ? '' : '<div class="hidden-phone" align="center">' . $system->ADSENSE['index_banner_3'] . '</div>',
	'BROWSE_ADSENSE_1' => !$system->ADSENSE['browse_banner_1'] ? '' : '<div class="hidden-phone" align="center">' . $system->ADSENSE['browse_banner_1'] . '</div>',
	'USER_MENU_ADSENSE_1' => !$system->ADSENSE['user_menu_banner_1'] ? '' : $system->ADSENSE['user_menu_banner_1'],
	'B_USER_MENU_ADSENSE' => !$system->ADSENSE['user_menu_banner_1'] ? false : true,
	'B_INDEX_ADSENSE_3' => !$system->ADSENSE['index_banner_3'] ? false : true,
	'B_INDEX_ADSENSE_2' => !$system->ADSENSE['index_banner_2'] ? false : true,
	'B_INDEX_ADSENSE_1' => !$system->ADSENSE['index_banner_1'] ? false : true,
	'B_BROWSE_ADSENSE_1' => !$system->ADSENSE['browse_banner_1'] ? false : true,		
	'BROWSE_SEO' => generate_seo_link($MSG['277_1']),
	'B_CAN_SELL' => $user->can_sell || !$user->logged_in,
	'B_ADMIN' => isset($user->user_data['admin']) && $user->user_data['admin'] == 1 || isset($user->user_data['admin']) && $user->user_data['admin'] == 2 ? true : false,
	'ADMIN_FOLDER' => $system->SETTINGS['admin_folder'],
	'KEYWORDS' => $wordstags,
	'DESCRIPTION' => $metadesc,
	'B_DIGITAL_ITEM_ON' => $system->SETTINGS['digital_auctions'] == 'y' ? true : false,
	'B_LOGGED_IN' => $user->logged_in,
	'MAXIMAGESIZE' => $system->SETTINGS['thumb_show'],
	'MAXIMAGESIZELIST' => $system->SETTINGS['thumb_list'],
	'GOOGLE_ANALYTICS' => $system->SETTINGS['googleanalytics'],
	'FAVICON' => $system->SETTINGS['favicon'],
	'B_FBOOK_LOGIN' => $system->SETTINGS['facebook_login'] == 'y' ? true : false,
	'B_COOKIE_DIRECTIVE' => $system->SETTINGS['cookies_directive'] == 'y' ? true : false,
	'B_BOARDS' => $system->SETTINGS['boards'] == 'y' ? true : false,
	'B_CAT_COUNTER' => $system->SETTINGS['cat_counters'] == 'y' ? true : false,
	'B_VIEW_TERMS' => $system->SETTINGS['termspolicy'] == 'y' ? true : false,
	'B_VIEW_PRIVPOL' => $system->SETTINGS['privacypolicy'] == 'y'  ? true : false,
	'B_VIEW_ABOUTUS' => $system->SETTINGS['aboutus'] == 'y'  ? true : false,
	'B_VIEW_COOKIES' => $system->SETTINGS['cookiespolicy'] == 'y'  ? true : false,
	'B_FEES' => $system->SETTINGS['fees'] == 'y' ? true : false,
	'B_SMSLOGINALERT' => $displayAlertLoginModal,
	'B_LIVECHAT' => $system->SETTINGS['liveChat'] == 'y' ? true : false,
));

$template->set_filenames(array(
		'header' => 'global_header.tpl'
		));
$template->display('header');
