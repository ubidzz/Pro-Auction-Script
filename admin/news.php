<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
$current_page = $MSG['516'];

// get page limits
if (!isset($_GET['PAGE']) || $_GET['PAGE'] == '')
{
	$OFFSET = 0;
	$PAGE = 1;
}
elseif (isset($_SESSION['RETURN_LIST_OFFSET']) && $_SESSION['RETURN_LIST'] == 'news.php')
{
	$PAGE = intval($_SESSION['RETURN_LIST_OFFSET']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
else
{
	$PAGE = intval($_GET['PAGE']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}

$_SESSION['RETURN_LIST'] = 'news.php';
$_SESSION['RETURN_LIST_OFFSET'] = $PAGE;

$query = "SELECT COUNT(id) As news FROM " . $DBPrefix . "news";
$db->direct_query($query);
$new_count = $db->result('news');
$PAGES = ($new_count == 0) ? 1 : ceil($new_count / $system->SETTINGS['perpage']);

$query = "SELECT * FROM " . $DBPrefix . "news ORDER BY new_date LIMIT :o, :p";
$params = array();
$params[] = array(':o', $OFFSET, 'int');
$params[] = array(':p', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);
$bg = '';
while ($row = $db->result())
{
	$template->assign_block_vars('news', array(
			'ID' => $row['id'],
			'TITLE' => $row['title'],
			'DATE' => $system->dateToTimestamp($row['new_date']),
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
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'admin/news.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
	'NEWS_COUNT' => $new_count,
	'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/news.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
	'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/news.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
	'PAGE' => $PAGE,
	'PAGES' => $PAGES,
	'ERROR' => (isset($ERR)) ? $ERR : '',
	'PAGENAME' => $MSG['516'],
	'PAGETITLE' => $MSG['516']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'news.tpl'
		));
$template->display('body');
include 'adminFooter.php';