<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

// Retrieve data
$query = "SELECT * FROM " . $DBPrefix . "currentbrowsers WHERE month = :m AND year = :y ORDER BY counter DESC";
$params = array();
$params[] = array(':m', date('m'), 'int');
$params[] = array(':y', date('Y'), 'int');
$db->query($query, $params);

$MAX = 0;
$TOTAL = 0;
while ($row = $db->result())
{
	$BROWSERS[$row['browser']] = $row['counter'];
	$TOTAL = $TOTAL + $row['counter'];

	if ($row['counter'] > $MAX)
	{
		$MAX = $row['counter'];
	}
}

if (is_array($BROWSERS))
{
	foreach ($BROWSERS as $k => $v)
	{
		$template->assign_block_vars('sitestats', array(
			'BROWSER' => $k,
			'COUNT' => $BROWSERS[$k],
			'NUM' => $BROWSERS[$k],
			'WIDTH' => ($BROWSERS[$k] * 100) / $MAX,
			'PERCENTAGE' => ceil(intval($BROWSERS[$k] * 100 / $TOTAL))
			));
	}
}

$template->assign_vars(array(
	'STATSMONTH' => date('F Y'),
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['5165'],
	'PAGETITLE' => $MSG['5165']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'viewbrowserstats.tpl'
		));
$template->display('body');
include 'adminFooter.php';