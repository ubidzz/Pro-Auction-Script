<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include INCLUDE_PATH . 'countries.inc.php';

unset($ERROR);
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Update database
	$system->writesetting("settings", "defaultcountry", $_POST['country'], 'str');
	$ERROR = $MSG['5323'];
}

//build country list
$country = '<select name="country" class="form-control">';
foreach ($countries as $key => $name)
{
	$country .= '<option value="' . $name . '"';
	if ($system->SETTINGS['defaultcountry'] == $name)
	{
		$country .= ' selected';
	}
	$country .= '>' . $name . '</option>' . "\n";
}
$country .= '</select>';

loadblock($MSG['5322'], $MSG['5321'], $country);

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'SITEURL' => $system->SETTINGS['siteurl'],
	'TYPENAME' => $MSG['25_0008'],
	'PAGENAME' => '<a style="color:lime" href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_default_country" target="_blank">' . $MSG['5322'] . '</a>',
	'PAGETITLE' => $MSG['5322']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';