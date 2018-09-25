<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

// Retrieve data
$query = "SELECT * FROM " . $DBPrefix . "currentbots WHERE month = :m AND year = :y ORDER BY counter DESC";
$params = array();
$params[] = array(':m', date('m'), 'int');
$params[] = array(':y', date('Y'), 'int');
$db->query($query, $params);

$MAX = 0;
$TOTAL = 0;
while ($row = $db->result())
{
	$PLANTFORMS[] = $row['platform'];
	$PLANTFORMSWITHBROWSERS[] = $row['browser'];
	$BROWSERS[$row['browser']] = $row['counter'];
	$TOTAL = $TOTAL + $row['counter'];

	if ($row['counter'] > $MAX)
	{
		$MAX = $row['counter'];
	}
}
if (is_array($BROWSERS) && is_array($PLANTFORMS) && is_array($PLANTFORMSWITHBROWSERS))
{
	foreach ($PLANTFORMS as $plantformKey => $plantformValue)
	{
		foreach ($PLANTFORMSWITHBROWSERS as $plantformBrowserKey => $plantformBrowserValue)
		{
			foreach ($BROWSERS as $browserKey => $browserValue)
			{
				if($plantformBrowserValue == $browserKey && $plantformBrowserKey == $plantformKey)
				{
					$template->assign_block_vars('sitestats', array(
						'PLANTFORM' => $plantformValue,
						'BROWSER' => $plantformBrowserValue,
						'COUNT' => $BROWSERS[$browserKey],
						'NUM' => $BROWSERS[$browserKey],
						'WIDTH' => ($BROWSERS[$browserKey] * 100) / $MAX,
						'PERCENTAGE' => ceil(intval($BROWSERS[$browserKey] * 100 / $TOTAL))
					));
				}
			}
		}
	}
}

$template->assign_vars(array(
	'STATSMONTH' => date('F Y'),
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['3500_1015742'],
	'PAGETITLE' => $MSG['3500_1015742']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'viewbotstats.tpl'
		));
$template->display('body');
include 'adminFooter.php';