<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

$TOTAL_PAGEVIEWS = 0;
$TOTAL_UNIQUEVISITORS = 0;
$TOTAL_USERSESSIONS = 0;

$listby = 'd';
$params = array();
$year = date('Y');
$month = date('m');

if (isset($_GET['type']) && in_array($_GET['type'], array('d','w', 'm')))
{
	$listby = $_GET['type'];
}

// Retrieve data
if ($listby == 'm')
{
	$query = "SELECT SUM(pageviews) as pageviews, SUM(uniquevisitors) as uniquevisitors, SUM(usersessions) as usersessions, month, year
			FROM " . $DBPrefix . "currentaccesses GROUP BY month ORDER BY :asc ASC";
			$params[] = array(':asc', 'month', 'str');
	$statsview = $MSG['5281'];
	$statstext = $MSG['5280'];
}
elseif ($listby == 'w')
{
	$query = "SELECT * FROM " . $DBPrefix . "currentaccesses WHERE year = :years ORDER BY day ASC";
	$params[] = array(':years', $year, 'int');
	$statsview = $MSG['827'];
	$statstext = $MSG['828'];
}
else
{
	$query = "SELECT * FROM " . $DBPrefix . "currentaccesses WHERE month =  " . $month . " AND year = :y ORDER BY day ASC";
	$params[] = array(':y', $year, 'int');
	$statsview = date('F Y');
	$statstext = $MSG['109'];
}


$db->query($query, $params);

// set the arrays up
$data_line = array();
$data_max = array();
$data_max[] = 0;
while ($row = $db->result())
{
	if ($listby == 'w')
	{
		$date = $row['year'] . '/' . $row['month'] . '/' . $row['day'];
		$weekno = date('W', strtotime($date));
		if (!isset($data_line[$weekno]))
		{
			$data_line[$weekno] = array();
			$data_line[$weekno]['pageviews'] = 0;
			$data_line[$weekno]['uniquevisitors'] = 0;
			$data_line[$weekno]['usersessions'] = 0;
		}
		$data_line[$weekno]['pageviews'] += $row['pageviews'];
		$data_line[$weekno]['uniquevisitors'] += $row['uniquevisitors'];
		$data_line[$weekno]['usersessions'] += $row['usersessions'];
		$data_max[$weekno] += $row['pageviews'];
	}
	elseif ($listby == 'm')
	{
		$monthno = $row['month'] . $row['year'];
		if (!isset($data_line[$monthno]))
		{
			$data_line[$monthno] = array();
			$data_line[$monthno]['month'] = $row['month'];
			$data_line[$monthno]['year'] = $row['year'];
			$data_line[$monthno]['pageviews'] = 0;
			$data_line[$monthno]['uniquevisitors'] = 0;
			$data_line[$monthno]['usersessions'] = 0;
		}
		$data_line[$monthno]['pageviews'] += $row['pageviews'];
		$data_line[$monthno]['uniquevisitors'] += $row['uniquevisitors'];
		$data_line[$monthno]['usersessions'] += $row['usersessions'];
		$data_max[$monthno] += $row['pageviews'];
	}
	else
	{
		$data_line[] = $row;
	$data_max[] = $row['pageviews'];
	}
	$TOTAL_PAGEVIEWS += $row['pageviews'];
	$TOTAL_UNIQUEVISITORS += $row['uniquevisitors'];
	$TOTAL_USERSESSIONS += $row['usersessions'];
}

$MAX = max($data_max);
foreach ($data_line as $k => $v)
{
	if ($listby == 'w')
	{
		$date = $k;
	}
	elseif ($listby == 'm')
	{
		$date = $v['month'] . '/' . $v['year'];
	}
	else
	{
		$date = $v['day'] . '/' . $v['month'] . '/' . $v['year'];
	}
	$template->assign_block_vars('sitestats', array(
			'DATE' => $date,
			'PAGEVIEWS' => $v['pageviews'],
			'PAGEVIEWS_WIDTH' => ($v['pageviews'] * 100) / $MAX,
			'UNIQUEVISITORS' => $v['uniquevisitors'],
			'UNIQUEVISITORS_WIDTH' => ($v['uniquevisitors'] * 100) / $MAX,
			'USERSESSIONS' => $v['usersessions'],
			'USERSESSIONS_WIDTH' => ($v['usersessions'] * 100) / $MAX
			));
}

$template->assign_vars(array(
	'TOTAL_PAGEVIEWS' => $TOTAL_PAGEVIEWS,
	'TOTAL_UNIQUEVISITORS' => $TOTAL_UNIQUEVISITORS,
	'TOTAL_USERSESSIONS' => $TOTAL_USERSESSIONS,
	'STATSMONTH' => $statsview,
	'STATSTEXT' => $statstext,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => isset($current_page) ? $current_page : '',
	'PAGETITLE' => isset($current_page) ? $current_page : ''
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'viewaccessstats.tpl'
		));
$template->display('body');
include 'adminFooter.php';