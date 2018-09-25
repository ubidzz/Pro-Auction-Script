<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);

// Set offset and limit for pagination
if (isset($_GET['PAGE']) && is_numeric($_GET['PAGE']))
{
	$PAGE = intval($_GET['PAGE']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
elseif (isset($_SESSION['RETURN_LIST_OFFSET']) && $_SESSION['RETURN_LIST'] == 'listsuspendedauctions.php')
{
	$PAGE = intval($_SESSION['RETURN_LIST_OFFSET']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
else
{
	$OFFSET = 0;
	$PAGE = 1;
}

$_SESSION['RETURN_LIST'] = 'listsuspendedauctions.php';
$_SESSION['RETURN_LIST_OFFSET'] = $PAGE;

$query = "SELECT COUNT(id) As auctions FROM " . $DBPrefix . "auctions WHERE suspended != :s";
$params = array();
$params[] = array(':s', 0, 'int');
$db->query($query, $params);
$num_auctions = $db->result('auctions');
$PAGES = ($num_auctions == 0) ? 1 : ceil($num_auctions / $system->SETTINGS['perpage']);

$query = "SELECT a.id, u.nick, a.title, a.starts, a.ends, a.suspended, c.cat_name FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
		LEFT JOIN " . $DBPrefix . "categories c ON (c.cat_id = a.category)
		WHERE a.suspended != :s ORDER BY nick LIMIT :o, :p";
$params = array();
$params[] = array(':s', 0, 'int');
$params[] = array(':o', $OFFSET, 'int');
$params[] = array(':p', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);
$bg = '';
while ($row = $db->result())
{
	$template->assign_block_vars('auctions', array(
			'SUSPENDED' => $row['suspended'],
			'ID' => $row['id'],
			'TITLE' => $row['title'],
			'START_TIME' => $system->ArrangeDateAndTime($row['starts']),
			'END_TIME' => $system->ArrangeDateAndTime($row['ends']),
			'USERNAME' => $row['nick'],
			'CATEGORY' => $row['cat_name'],
			'B_HASWINNERS' => false,
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
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/listsuspendedauctions.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
	'NUM_AUCTIONS' => $num_auctions,
	'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/listsuspendedauctions.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
	'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/listsuspendedauctions.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
	'PAGE' => $PAGE,
	'PAGES' => $PAGES,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['5227'],
	'PAGETITLE' => $MSG['5227']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'listauctions.tpl'
		));
$template->display('body');
include 'adminFooter.php';