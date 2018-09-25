<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);

if (isset($_POST['resend_email']) && $_POST['resend_email'] == 'send' && isset($_POST['user_id']) && is_numeric($_POST['user_id']))
{
	$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array(
		array(':user_id', $_POST['user_id'], 'int')
	);
	$db->query($query, $params);
	if ($db->numrows() == 1)
	{
		$USER = $db->result();
		$ERROR = $send_email->reply_user($USER['id'], $USER['nick'], $USER['name'], $USER['email']);
	}
}
elseif(isset($_POST['payreminder_email']) && $_POST['payreminder_email'] == 'send' && isset($_POST['user_id']) && is_numeric($_POST['user_id']))
{
	$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :user_id";
	$params = array(
		array(':user_id', $_POST['user_id'], 'int')
	);
	$db->query($query, $params);
	if ($db->numrows() == 1)
	{
		$USER = $db->result();
		$ERROR = $send_email->payment_reminder($USER['name'], $USER['balance'], $USER['id'], $USER['email']);
	}
}

if (isset($_GET['usersfilter']))
{
	$_SESSION['usersfilter'] = $_GET['usersfilter'];
	switch($_GET['usersfilter'])
	{
		case 'all':
			unset($_SESSION['usersfilter']);
			unset($Q);
		break;
		case 'active':
			$Q = 0;
		break;
		case 'admin':
			$Q = 1;
		break;
		case 'confirmed':
			$Q = 8;
		break;
		case 'fee':
			$Q = 9;
		break;
		case 'admin_approve':
			$Q = 10;
		break;
	}
}
elseif (!isset($_GET['usersfilter']) && isset($_SESSION['usersfilter']))
{
	switch($_SESSION['usersfilter'])
	{
		case 'active':
			$Q = 0;
		break;
		case 'admin':
			$Q = 1;
		break;
		case 'confirmed':
			$Q = 8;
		break;
		case 'fee':
			$Q = 9;
		break;
		case 'admin_approve':
			$Q = 10;
		break;
	}
}
else
{
	unset($_SESSION['usersfilter']);
	unset($Q);
}

// Retrieve active auctions from the database
if (isset($Q))
{
	$query = "SELECT COUNT(id) as COUNT FROM " . $DBPrefix . "users WHERE suspended = :s";
	$params = array(
		array(':s', $Q, 'int')
	);
	$db->query($query, $params);
}
elseif (isset($_POST['keyword']))
{
	$keyword = $system->cleanvars($_POST['keyword']);
	$query = "SELECT COUNT(id) as COUNT FROM " . $DBPrefix . "users WHERE name LIKE :nl OR nick LIKE :nkl OR email LIKE :el";
	$params = array(
		array(':nl', '%' . $keyword . '%', 'str'),
		array(':nkl', '%' . $keyword . '%', 'str'),
		array(':el', '%' . $keyword . '%', 'str')
	);
	$db->query($query, $params);
}
else
{
	$query = "SELECT COUNT(id) as COUNT FROM " . $DBPrefix . "users";
	$db->direct_query($query);
}
$TOTALUSERS = $db->result('COUNT');

// get page limits
if (isset($_GET['PAGE']) && is_numeric($_GET['PAGE']))
{
	$PAGE = intval($_GET['PAGE']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
elseif (isset($_SESSION['RETURN_LIST_OFFSET']) && $_SESSION['RETURN_LIST'] == 'listusers.php')
{
	$PAGE = intval($_SESSION['RETURN_LIST_OFFSET']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
else
{
	$OFFSET = 0;
	$PAGE = 1;
}

$_SESSION['RETURN_LIST'] = 'listusers.php';
$_SESSION['RETURN_LIST_OFFSET'] = $PAGE;
$PAGES = ($TOTALUSERS == 0) ? 1 : ceil($TOTALUSERS / $system->SETTINGS['perpage']);
$params = array();
if (isset($Q))
{
	$query = "SELECT * FROM " . $DBPrefix . "users WHERE suspended = :s";
	$params[] = array(':s', $Q, 'str');
}
elseif (isset($_POST['keyword']))
{
	$query = "SELECT * FROM " . $DBPrefix . "users WHERE name LIKE :ln OR nick LIKE :lnk OR email LIKE :le";
	$params[] = array(':ln', '%' . $keyword . '%', 'str');
	$params[] = array(':lnk', '%' . $keyword . '%', 'str');
	$params[] = array(':le', '%' . $keyword . '%', 'str');
}
else
{
	$query = "SELECT * FROM " . $DBPrefix . "users";
}
$query .= " ORDER BY nick LIMIT :o, :p";
$params[] = array(':o', $OFFSET, 'int');
$params[] = array(':p', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);

$bg = '';
while ($row = $db->result())
{
	$template->assign_block_vars('users', array(
		'ID' => $row['id'],
		'NICK' => $row['nick'],
		'NAME' => $row['name'],
		'COUNTRY' => $row['country'],
		'EMAIL' => $row['email'],
		'NEWSLETTER' => ($row['nletter'] == 1) ? $MSG['030'] : $MSG['029'],
		'SUSPENDED' => $row['suspended'],
		'BALANCE' => $system->print_money($row['balance'], true, false),
		'BALANCE_CLEAN' => $row['balance'],
		'PAGENAME' => $MSG['045'],
		'PAGETITLE' => $MSG['045'],
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
			'PAGE' => ($PAGE == $COUNTER) ? '<li class="active disabled"><a href="#">' . $COUNTER . '</a></li>' : '<li><a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/listusers.php?PAGE=' . $COUNTER . '">' . $COUNTER . '</a></li>'
		));
		$COUNTER++;
	}
}

$template->assign_vars(array(
	'TOTALUSERS' => $TOTALUSERS,
	'USERFILTER' => (isset($_SESSION['usersfilter'])) ? $_SESSION['usersfilter'] : '',
	'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a aria-label="Previous" href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/listusers.php?PAGE=' . $PREV . '"><span aria-hidden="true">&laquo;</span></a>' : '',
	'NEXT' => ($PAGE < $PAGES) ? '<a aria-label="Next" href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/listusers.php?PAGE=' . $NEXT . '"><span aria-hidden="true">&raquo;</span></a>' : '',
	'PAGE' => $PAGE,
	'PAGES' => $PAGES,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['045'],
	'PAGETITLE' => $MSG['045']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'listusers.tpl'
		));
$template->display('body');
include 'adminFooter.php';