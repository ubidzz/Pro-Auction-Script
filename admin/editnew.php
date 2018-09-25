<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

if (!isset($_POST['id']) && (!isset($_GET['id']) || empty($_GET['id'])))
{
	header('location: news.php');
	exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Data check
	if (empty($_POST['title']) || empty($_POST['content']))
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

		$news_id = intval($_POST['id']);
		$query = "UPDATE " . $DBPrefix . "news SET title = :t, content = :c, suspended = :s WHERE id = :i";
		$params = array();
		$params[] = array(':t', stripslashes($_POST['title'][$system->SETTINGS['defaultlanguage']]), 'str');
		$params[] = array(':c', stripslashes($_POST['content'][$system->SETTINGS['defaultlanguage']]), 'str');
		$params[] = array(':s', intval($_POST['suspended']), 'int');
		$params[] = array(':i', $news_id, 'int');
		$db->query($query, $params);


		foreach ($LANGUAGES as $k => $v)
		{
			$query = "SELECT id FROM " . $DBPrefix . "news_translated WHERE lang = :l AND id = :i";
			$params = array();
			$params[] = array(':l', $k, 'str');
			$params[] = array(':i', $news_id, 'int');
			$db->query($query, $params);
			
			$ex_params = array();
			if ($db->numrows('id') > 0)
			{
				$query = "UPDATE " . $DBPrefix . "news_translated SET title = :t, content = :c WHERE lang = :l AND id = :i";
				$ex_params[] = array(':t', stripslashes($_POST['title'][$k]), 'str');
				$ex_params[] = array(':c', stripslashes($_POST['content'][$k]), 'str');
				$ex_params[] = array(':l', $k, 'str');
				$ex_params[] = array(':i', $news_id, 'int');
			}
			else
			{
				$query = "INSERT INTO " . $DBPrefix . "news_translated VALUES (:i, :l, :t, :c)";
				$ex_params[] = array(':i', $news_id, 'int');
				$ex_params[] = array(':l', $k, 'str');
				$ex_params[] = array(':t', stripslashes($_POST['title'][$k]), 'str');
				$ex_params[] = array(':c', stripslashes($_POST['content'][$k]), 'str');
			}
			$db->query($query, $ex_params);
		}
		header('location: news.php');
		exit;
	}
}


// get news story
$query = "SELECT t.*, n.suspended FROM " . $DBPrefix . "news_translated t
		LEFT JOIN " . $DBPrefix . "news n ON (n.id = t.id) WHERE t.id = :i";
$params = array();
$params[] = array(':i', intval($_GET['id']), 'int');
$db->query($query, $params);

$CONT_tr = array();
$TIT_tr = array();
while ($arr = $db->result())
{
	$suspended = $arr['suspended'];
	$template->assign_block_vars('lang', array(
			'LANG' => $arr['lang'],
			'TITLE' => $arr['title'],
			'CONTENT' => $CKEditor->editor('content[' . $arr['lang'] . ']', $system->uncleanvars($arr['content']))
			));
}

$template->assign_vars(array(
	'SITEURL' => $system->SETTINGS['siteurl'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'TITLE' => $MSG['343'],
	'BUTTON' => $MSG['530'],
	'ID' => intval($_GET['id']),
	'PAGENAME' => $MSG['5278'],
	'PAGETITLE' => $MSG['5278'],
	'B_ACTIVE' => ((isset($suspended) && $suspended == 0) || !isset($suspended)),
	'B_INACTIVE' => (isset($suspended) && $suspended == 1),
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'addnew.tpl'
		));
$template->display('body');
include 'adminFooter.php';