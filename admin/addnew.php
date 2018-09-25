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
	// Data check
	if (!isset($_POST['title']) || !isset($_POST['content']))
	{
		$ERROR = $ERR['112'];
	}
	else
	{
		// clean up everything
		$conf = array();
		$conf['safe'] = $system->SETTINGS['htmLawed_safe'];
		$conf['deny_attribute'] = $system->SETTINGS['htmLawed_deny_attribute'];
		foreach ($_POST['title'] as $k => $v)
		{
			$_POST['title'][$k] = htmLawed($v, $conf);
			$_POST['content'][$k] = htmLawed($_POST['content'][$k], $conf);
		}

		$query = "INSERT INTO " . $DBPrefix . "news VALUES (NULL, :t, :c, :tm, :s)";
		$params = array();
		$params[] = array(':t', stripslashes($_POST['title'][$system->SETTINGS['defaultlanguage']]), 'str');
		$params[] = array(':c', stripslashes($_POST['content'][$system->SETTINGS['defaultlanguage']]), 'str');
		$params[] = array(':tm', $system->CTIME, 'int');
		$params[] = array(':s', intval($_POST['suspended']), 'int');
		$db->query($query, $params);

		$news_id = $db->lastInsertId();

		// Insert into translation table
		foreach ($LANGUAGES as $k => $v)
		{
			$query = "INSERT INTO " . $DBPrefix . "news_translated VALUES (:id, :l, :t, :c)";
			$params = array();
			$params[] = array(':id', $news_id, 'int');
			$params[] = array(':l', $k, 'str');
			$params[] = array(':t', stripslashes($_POST['title'][$k]), 'str');
			$params[] = array(':c', stripslashes($_POST['content'][$k]), 'str');
			$db->query($query, $params);
		}
		header('location: news.php');
		exit;
	}
}

foreach ($LANGUAGES as $k => $language)
{
	$template->assign_block_vars('lang', array(
			'LANG' => $language,
			'TITLE' => (isset($_POST['title'][$k])) ? $_POST['title'][$k] : '',
			'CONTENT' => $CKEditor->editor('content[' . $k . ']', $_POST['content'][$k]) 
			));
}

$template->assign_vars(array(
	'TITLE' => $MSG['518'],
	'BUTTON' => $MSG['518'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['518'],
	'PAGETITLE' => $MSG['518'],
	'B_ACTIVE' => ((isset($_POST['suspended']) && $_POST['suspended'] == 0) || !isset($_POST['suspended'])),
	'B_INACTIVE' => (isset($_POST['suspended']) && $_POST['suspended'] == 1)
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'addnew.tpl'
		));
$template->display('body');
include 'adminFooter.php';