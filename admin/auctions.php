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
	if ($_POST['status'] == 'enabled' && (!is_numeric($_POST['timebefore']) || !is_numeric($_POST['extend'])))
	{
		$ERROR = $MSG['2_0038'];
	}
	elseif ($_POST['maxpicturesize'] == 0)
	{
		$ERROR = $ERR['707'];
	}
	elseif (!empty($_POST['maxpicturesize']) && !intval($_POST['maxpicturesize']))
	{
		$ERROR = $ERR['708'];
	}
	elseif (!empty($_POST['maxpictures']) && !intval($_POST['maxpictures']))
	{
		$ERROR = $ERR['706'];
	}
	else
	{
		// Update database
		$system->writesetting("settings", "proxy_bidding", $_POST['proxy_bidding'], 'bool');
		$system->writesetting("settings", "edit_starttime", $_POST['edit_starttime'], 'bool_int');
		$system->writesetting("settings", "cust_increment", $_POST['cust_increment'], 'bool_int');
		$system->writesetting("settings", "ao_hpf_enabled", $_POST['ao_hpf_enabled'], 'bool');
		$system->writesetting("settings", "ao_hi_enabled", $_POST['ao_hi_enabled'], 'bool');
		$system->writesetting("settings", "ao_bi_enabled", $_POST['ao_bi_enabled'], 'bool');
		$system->writesetting("settings", "subtitle", $_POST['subtitle'], 'bool');
		$system->writesetting("settings", "extra_cat", $_POST['extra_cat'], 'bool');
		$system->writesetting("settings", "autorelist", $_POST['autorelist'], 'bool');
		$system->writesetting("settings", "ae_status", $_POST['status'], 'bool');
		$system->writesetting("settings", "ae_timebefore", $_POST['timebefore'], 'int');
		$system->writesetting("settings", "ae_extend", $_POST['extend'], 'int');
		$system->writesetting("settings", "picturesgallery", $_POST['picturesgallery'], 'bool_int');
		$system->writesetting("settings", "maxpictures", $_POST['maxpictures'], 'int');
		$system->writesetting("settings", "maxuploadsize", $_POST['maxpicturesize'] * 1024, 'int');
		$system->writesetting("settings", "item_conditions", $_POST['conditions'], 'bool');
		$system->writesetting("settings", "dutch_auctions", $_POST['dutch'], 'bool');
		$system->writesetting("settings", "max_image_width", $_POST['max_image_width'], 'int');
		$system->writesetting("settings", "auction_setup_types", $_POST['setup_types'], 'bool_int');
		$system->writesetting("settings", "max_image_height", $_POST['max_image_height'], 'int');
		$system->writesetting("settings", "digital_auctions", $_POST['digital_auctions'], 'bool');
		$system->writesetting("settings", "standard_auctions", $_POST['standard'], 'bool');
		$system->writesetting("settings", "freemaxpictures", $_POST['freemaxpictures'], 'int');
		$system->writesetting("settings", "shipping_conditions", $_POST['shipping_conditions'], 'bool');
		$system->writesetting("settings", "shipping_terms", $_POST['shipping_terms'], 'bool');
		$system->writesetting("settings", "thumb_show", $_POST['thumb_show'], 'int');
		$system->writesetting("settings", "default_minbid", $_POST['default_minbid'], 'float');
		$system->writesetting("settings", "allowed_image_mime", explode(',',$_POST['allowed_image_mime']), 'array');
		$system->writesetting("settings", "digital_item_size", $_POST['digital_item_size'] * 1024, 'int');
		
		// Turn on the buy now only if the digital item auction is turned on
		if($_POST['setup_types'] == 2 || $_POST['setup_types'] == 0 || $_POST['digital_auctions'] == 'y')
		{
			$system->writesetting("settings", "buy_now", '2', 'bool_int');
			$system->writesetting("settings", "bn_only", 'y', 'bool');
		}
		$ERROR = $MSG['5088'];
	}
}

loadblock($MSG['257'], '', '', '', '', array(), true);
loadblock($MSG['1021'], $MSG['3500_1015738'], 'yesno', 'standard', $system->SETTINGS['standard_auctions'], array($MSG['030'], $MSG['029']));
loadblock($MSG['1020'], $MSG['3500_1015514'], 'yesno', 'dutch', $system->SETTINGS['dutch_auctions'], array($MSG['030'], $MSG['029']));
loadblock($MSG['350_1010'], $MSG['350_10185'], 'yesno', 'digital_auctions', $system->SETTINGS['digital_auctions'], array($MSG['030'], $MSG['029']));

//digital item options
loadblock($MSG['350_10179'], '', '', '', '', array(), true);
loadblock($MSG['350_10180'], $MSG['350_10181'], 'decimals', 'digital_item_size', ($system->SETTINGS['digital_item_size'] / 1024), array($MSG['672']));

loadblock($MSG['897'], '', '', '', '', array(), true);
loadblock($MSG['3500_1015744'], $MSG['3500_1015757'], 'select3num', 'setup_types', $system->SETTINGS['auction_setup_types'], array($MSG['3500_1015754'], $MSG['3500_1015755'], $MSG['3500_1015756']));
loadblock($MSG['427'], $MSG['428'], 'yesno', 'proxy_bidding', $system->SETTINGS['proxy_bidding'], array($MSG['030'], $MSG['029']));
loadblock($MSG['3500_1015762'], $MSG['3500_1015764'], 'yesno', 'shipping_conditions', $system->SETTINGS['shipping_conditions'], array($MSG['030'], $MSG['029']));
loadblock($MSG['3500_1015763'], $MSG['3500_1015765'], 'yesno', 'shipping_terms', $system->SETTINGS['shipping_terms'], array($MSG['030'], $MSG['029']));


loadblock($MSG['5090'], $MSG['5089'], 'batch', 'edit_starttime', $system->SETTINGS['edit_starttime'], array($MSG['030'], $MSG['029']));
loadblock($MSG['068'], $MSG['070'], 'batch', 'cust_increment', $system->SETTINGS['cust_increment'], array($MSG['030'], $MSG['029']));
loadblock($MSG['3500_1015488'], $MSG['3500_1015492'], 'yesno', 'conditions', $system->SETTINGS['item_conditions'], array($MSG['030'], $MSG['029']));
loadblock($MSG['142'], $MSG['157'], 'yesno', 'ao_hpf_enabled', $system->SETTINGS['ao_hpf_enabled'], array($MSG['030'], $MSG['029']));
loadblock($MSG['162'], $MSG['164'], 'yesno', 'ao_hi_enabled', $system->SETTINGS['ao_hi_enabled'], array($MSG['030'], $MSG['029']));
loadblock($MSG['174'], $MSG['194'], 'yesno', 'ao_bi_enabled', $system->SETTINGS['ao_bi_enabled'], array($MSG['030'], $MSG['029']));
loadblock($MSG['797'], $MSG['798'], 'yesno', 'subtitle', $system->SETTINGS['subtitle'], array($MSG['030'], $MSG['029']));
loadblock($MSG['799'], $MSG['800'], 'yesno', 'extra_cat', $system->SETTINGS['extra_cat'], array($MSG['030'], $MSG['029']));
loadblock($MSG['849'], $MSG['850'], 'yesno', 'autorelist', $system->SETTINGS['autorelist'], array($MSG['030'], $MSG['029']));
loadblock($MSG['851'], $MSG['852'], 'days', 'autorelist_max', $system->SETTINGS['autorelist_max']);
loadblock($MSG['3500_1015852'], $MSG['3500_1015853'], 'decimals', 'default_minbid', $system->SETTINGS['default_minbid']);

// auction extension options
loadblock($MSG['2_0032'], '', '', '', '', array(), true); // :O
loadblock($MSG['2_0034'], $MSG['2_0039'], 'yesno', 'status', $system->SETTINGS['ae_status'], array($MSG['030'], $MSG['029']));
$string = $MSG['2_0035'] . '<input type="text" name="extend" value="' . $system->SETTINGS['ae_extend'] . '" size="5">' . $MSG['2_0036'] . '<input type="text" name="timebefore" value="' . $system->SETTINGS['ae_timebefore'] . '" size="5">' . $MSG['2_0037'];
loadblock('', $string, '');

// picture gallery options
loadblock($MSG['663'], '', '', '', '', array(), true);
loadblock($MSG['665'], $MSG['664'], 'batch', 'picturesgallery', $system->SETTINGS['picturesgallery'], array($MSG['030'], $MSG['029']));
loadblock($MSG['666'], $MSG['3500_1015759'], 'days', 'maxpictures', $system->SETTINGS['maxpictures']);
loadblock($MSG['3500_1015758'], $MSG['3500_1015760'], 'days', 'freemaxpictures', $system->SETTINGS['freemaxpictures']);
loadblock($MSG['671'], $MSG['25_0187'], 'decimals', 'maxpicturesize', ($system->SETTINGS['maxuploadsize'] / 1024), array($MSG['672']));
loadblock($MSG['25_0107'], $MSG['896'], 'decimals', 'thumb_show', $system->SETTINGS['thumb_show'], array($MSG['2__0045']));

loadblock($MSG['3500_1015722'], $MSG['3500_1015719'], 'decimals', 'max_image_width', $system->SETTINGS['max_image_width'], array($MSG['3500_1015721']));
loadblock($MSG['3500_1015723'], $MSG['3500_1015720'], 'decimals', 'max_image_height', $system->SETTINGS['max_image_height'], array($MSG['3500_1015721']));
$mimeArray = unserialize($system->SETTINGS['allowed_image_mime']);
foreach($mimeArray as $k => $v)
{
	if(end($mimeArray) == $v) {
		$mimeType .= $v;
	}else{
		$mimeType .= $v . ',';
	}
}

loadblock($MSG['3500_1015892'], $MSG['3500_1015893'], 'text', 'allowed_image_mime', $mimeType);


$template->assign_vars(array(
	'TYPENAME' => $MSG['5142'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_asettings" target="_blank">' . $MSG['5087'] . '</a>',
	'PAGETITLE' => $MSG['5087']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';