<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);

if (isset($_POST['action']) && $_POST['action'] == 'update' && isset($_POST['defaultlanguage']))
{
	$system->writesetting("settings", "defaultlanguage", $_POST['defaultlanguage'], 'str');
	$ERROR = $MSG['3500_1015725'];
}

$html = '';
if (is_array($LANGUAGES))
{
	reset($LANGUAGES);
	foreach ($LANGUAGES as $k => $v){
		$html .= '<input type="radio" name="defaultlanguage" value="' . $k . '"' . (($system->SETTINGS['defaultlanguage'] == $k) ? ' checked="checked"' : '') . '>
	<img src="../language/flags/' . $k . '.gif" hspace="2">
	' . $v . (($system->SETTINGS['defaultlanguage'] == $k) ? '&nbsp;' . $MSG['2__0005'] : '') . '<br>';
	}
}

loadblock($MSG['2__0004'], $MSG['2__0003'], $html);

$template->assign_vars(array(
	'TYPENAME' => $MSG['25_0008'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_multilingual_support" target="_blank">' .  $MSG['2__0002'] . '</a>',
	'PAGETITLE' => $MSG['2__0002']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';