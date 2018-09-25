<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

$query = "SELECT COUNT(id) as COUNT FROM " . $DBPrefix . "users";
$db->direct_query($query);
$TOTALUSERS = $db->result('COUNT');

// get page limits
if (isset($_GET['PAGE']) && is_numeric($_GET['PAGE']))
{
	$PAGE = intval($_GET['PAGE']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
else
{
	$OFFSET = 0;
	$PAGE = 1;
}

$PAGES = ($TOTALUSERS == 0) ? 1 : ceil($TOTALUSERS / $system->SETTINGS['perpage']);

$query = "SELECT * FROM " . $DBPrefix . "users ORDER BY nick LIMIT :offset, :perpage";
$params = array();
$params[] = array(':offset', $OFFSET, 'int');
$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);
$bg = '';
while ($row = $db->result())
{	
	if($row['is_online'] >  $system->CTIME - 330) 
	{ 
	    $online = '<img src="' . $system->SETTINGS['siteurl'] . 'images/online.png">' . $MSG['350_10111'];
	} 
	else 
	{ 
		$online = '<img src="' . $system->SETTINGS['siteurl'] . 'images/offline.png">' . $MSG['350_10112'];
	}     

	$template->assign_block_vars('active_users', array(
			'NICK' => $row['nick'],
			'NAME' => $row['name'],
			'ONLINESTATUS' => $online,
			'LASTLOGIN' => $row['lastlogin'],
			'SUSPENDED' => $row['suspended'],
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

// get pagenation
$PREV = intval($PAGE - 1);
$NEXT = intval($PAGE + 1);
if ($PAGES > 1)
{
	$LOW = $PAGE - 5;
	if ($LOW <= 0) $LOW = 1;
	$COUNTER = $LOW;
	while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6))
	{
		$template->assign_block_vars('pages', array(
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/useractivity.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
	'TOTALUSERS' => $TOTALUSERS,
	'USERFILTER' => (isset($_SESSION['usersfilter'])) ? $_SESSION['usersfilter'] : '',
	'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/useractivity.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
	'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/useractivity.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
	'PAGE' => $PAGE,
	'PAGES' => $PAGES,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['350_10210'],
	'PAGETITLE' => $MSG['350_10210']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'useractivity.tpl'
		));
$template->display('body');
include 'adminFooter.php';