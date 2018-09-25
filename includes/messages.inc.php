<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');

//cookie settings
$cookie_lang = $system->SETTINGS['cookiesname'] . '-USERLANGUAGE';
$cookieTimestamp = $system->CTIME + (86400 * 30);

//find installed languages
$LANGUAGES = array();
if ($handle = opendir(MAIN_PATH . 'language')) {
    while (false !== ($file = readdir($handle))) {
        if ('.' != $file && '..' != $file && $file !='flags') {
            if (preg_match('/^([a-zA-Z_]{2,})$/i', $file)) {
                $LANGUAGES[$file] = $file;
            }
        }
    }
}
closedir($handle);

function checkLanguageExists($language)
{
    global $LANGUAGES, $system;
    // check language exists
    if (in_array($language, $LANGUAGES)) {
        return true;
    }
    return false;
}

// Language management
if (isset($_GET['lan']) && !empty($_GET['lan']))
{
	$language = preg_replace("/[^a-zA-Z\s]/", '', $_GET['lan']);
	if(checkLanguageExists($language))
	{
		if ($user->logged_in)
		{
			$query = "UPDATE " . $DBPrefix . "users SET language = :lang WHERE id = :user_id";
			$params = array(
				array(':lang', $language, 'str'),
				array(':user_id', $user->user_data['id'], 'int')
			);
			$db->query($query, $params);
		} 
	} else {
		$language = $system->SETTINGS['defaultlanguage'];
	}
}
elseif ($user->logged_in)
{
	$language = $user->user_data['language'];
	if (!checkLanguageExists($language)) {
		$language = $system->SETTINGS['defaultlanguage'];
	}
}
elseif (isset($_COOKIE[$cookie_lang]))
{
	$language = preg_replace("/[^a-zA-Z_]/", '', $_COOKIE[$cookie_lang]);
	if (!checkLanguageExists($language)) {
		$language = $system->SETTINGS['defaultlanguage'];
	}
}
if (!isset($language) || empty($language)) {
    $language = $system->SETTINGS['defaultlanguage'];
}

$system->buildCookie($cookie_lang, $language, $cookieTimestamp);


include LANGUAGE_PATH . $language . '/messages.inc.php';

function get_lang_img($string)
{
	global $system, $language;
	return $system->SETTINGS['siteurl'] . 'language/' . $language . '/images/' . $string;
}
?>