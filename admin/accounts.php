<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);

// get form variables
$list_type = isset($_GET['type']) ? intval($_GET['type']) : 'a';
$from_date = isset($_GET['from_date']) ? intval($_GET['from_date']) : 0;
$to_date = isset($_GET['to_date']) ? intval($_GET['to_date']) : 0;

// Set offset and limit for pagination
if (isset($_GET['PAGE']) && is_numeric($_GET['PAGE']))
{
	$PAGE = intval($_GET['PAGE']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
elseif (isset($_SESSION['RETURN_LIST_OFFSET']) && $_SESSION['RETURN_LIST'] == 'accounts.php')
{
	$PAGE = intval($_SESSION['RETURN_LIST_OFFSET']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
else
{
	$OFFSET = 0;
	$PAGE = 1;
}

$where_sql = '';
if ($from_date != 0)
{
	$where_sql = 'paid_date > \'' . $system->formatTimestamp($from_date, '-') . '\'';
}
if ($to_date != 0)
{
	if (!empty($where_sql))
	{
		$where_sql .= ' AND ';
	}
	$where_sql .= 'paid_date < \'' . $system->formatTimestamp($to_date, '-') . '\'';
}

if ($list_type == 'm' || $list_type == 'w' || $list_type == 'd')
{
	$OFFSET = 0;
	$PAGE = 1;
	$PAGES = 1;
	$show_pagnation = false;
	
	if ($list_type == 'm')
	{
		$query = "SELECT *, SUM(amount) As total FROM " . $DBPrefix . "accounts
				" . ((!empty($where_sql)) ? ' WHERE ' . $where_sql : '') . "
				GROUP BY month, year ORDER BY year, month";
	}
	elseif ($list_type == 'w')
	{
		$query = "SELECT *, SUM(amount) As total FROM " . $DBPrefix . "accounts
				" . ((!empty($where_sql)) ? ' WHERE ' . $where_sql : '') . "
				GROUP BY week, year ORDER BY year, week";
	}
	else
	{
		$query = "SELECT *, SUM(amount) As total FROM " . $DBPrefix . "accounts
				" . ((!empty($where_sql)) ? ' WHERE ' . $where_sql : '') . "
				GROUP BY day, year ORDER BY year, day";
	}
	$db->direct_query($query);
	
	$bg = '';
	while ($row = $db->result())
	{
		if ($list_type == 'm')
		{
			$date = $MSG['MON_0' . $row['month'] . 'E'] . ', ' . $row['year'];
		}
		elseif ($list_type == 'w')
		{
			$date = $MSG['828'] . ' ' . $row['week'] . ', ' . $row['year'];
		}
		else
		{
			$date = $system->dateToTimestamp($row['paid_date']);
		}
		$template->assign_block_vars('accounts', array(
				'DATE' => $date,
				'AMOUNT' => $system->print_money($row['amount'], true, false),
				'BG' => $bg
				));
		$bg = ($bg == '') ? 'class="bg"' : '';
	}
}
else
{
	$_SESSION['RETURN_LIST'] = 'accounts.php';
	$_SESSION['RETURN_LIST_OFFSET'] = $PAGE;
	$show_pagnation = true;

	$query = "SELECT COUNT(id) As accounts FROM " . $DBPrefix . "accounts" . ((!empty($where_sql)) ? ' WHERE :sql' : '');
	$params = array();
	$params[] = array(':sql', $where_sql, 'str');
	$db->query($query, $params);
	$num_accounts = $db->result('accounts');
	$PAGES = ($num_accounts == 0) ? 1 : ceil($num_accounts / $system->SETTINGS['perpage']);
	$query = "SELECT * FROM " . $DBPrefix . "accounts
			" . ((!empty($where_sql)) ? ' WHERE :sql' : '') . " ORDER BY paid_date LIMIT :off, :page";
	$params = array();
	$params[] = array(':sql', $where_sql, 'str');
	$params[] = array(':off', $OFFSET, 'int');
	$params[] = array(':page', $system->SETTINGS['perpage'], 'int');
	$db->query($query, $params);

	$bg = '';
	while ($row = $db->result())
	{
		$template->assign_block_vars('accounts', array(
				'ID' => $row['id'],
				'NICK' => $row['nick'],
				'RNAME' => $row['name'],
				'DATE' => $system->ArrangeDateAndTime($row['paid_date']),
				'AMOUNT' => $system->print_money($row['amount'], true, false),
				'TEXT' => $row['text'],
				'BG' => $bg
				));
		$bg = ($bg == '') ? 'class="bg"' : '';
	}
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
				'PAGE' => ($PAGE == $COUNTER) ? '<li class="active disabled"><a href="#"><u>' . $COUNTER . '</u></a></li>' : '<li><a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/accounts.php?PAGE=' . $COUNTER . '">' . $COUNTER . '</a></li>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
	'TYPE' => $list_type,
	'FROM_DATE' => ($from_date == 0) ? '' : $from_date,
	'TO_DATE' => ($to_date == 0) ? '' : $to_date,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['854'],
	'PAGETITLE' => $MSG['854'],
	'PAGNATION' => $show_pagnation,
	'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<li><a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] .'/accounts.php?PAGE=' . $PREV . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>' : '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>',
	'NEXT' => ($PAGE < $PAGES) ? '<li><a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/accounts.php?PAGE=' . $NEXT . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>' : '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>',
	'PAGE' => $PAGE,
	'PAGES' => $PAGES
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'accounts.tpl'
		));
$template->display('body');
include 'adminFooter.php';