<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

// Retrieve data
$query = "SELECT * FROM " . $DBPrefix . "currentplatforms WHERE month = :m AND year = :y ORDER BY counter DESC";
$params = array();
$params[] = array(':m', date('m'), 'int');
$params[] = array(':y', date('Y'), 'int');
$db->query($query, $params);

$MAX = 0;
$TOTAL = 0;
while ($row = $db->result())
{
	$PLATFORMS[$row['platform']] = $row['counter'];
	$TOTAL = $TOTAL + $row['counter'];
	if ($row['counter'] > $MAX)
	{
		$MAX = $row['counter'];
	}
}
if (is_array($PLATFORMS))
{
	foreach ($PLATFORMS as $k => $v)
	{
		$template->assign_block_vars('sitestats', array(
			'PLATFORM' => $k,
			'COUNT' => $PLATFORMS[$k],
			'NUM' => $PLATFORMS[$k],
			'WIDTH' => ($PLATFORMS[$k] * 100) / $MAX,
			'PERCENTAGE' => ceil(intval($PLATFORMS[$k] * 100 / $TOTAL))
			));
	}
}

$template->assign_vars(array(
	'STATSMONTH' => date('F Y'),
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['5318'],
	'PAGETITLE' => $MSG['5318']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'viewplatformstats.tpl'
		));
$template->display('body');
include 'adminFooter.php';