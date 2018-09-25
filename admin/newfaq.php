<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
$current_page = $MSG['5231'];

unset($ERROR);

// Insert new message
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (empty($_POST['question'][$system->SETTINGS['defaultlanguage']]) || empty($_POST['answer'][$system->SETTINGS['defaultlanguage']]))
	{
		$ERROR = $ERR['067'];
	}
	else
	{
		$query = "INSERT INTO " . $DBPrefix . "faqs values (NULL, :q, :d, :c)";
		$params = array();
		$params[] = array(':q', stripslashes($_POST['question'][$system->SETTINGS['defaultlanguage']]), 'str');
		$params[] = array(':d', stripslashes($_POST['answer'][$system->SETTINGS['defaultlanguage']]), 'str');
		$params[] = array(':c', $_POST['category'], 'int');
		$db->query($query, $params);
		$id = $db->lastInsertId();
		// Insert into translation table.
		reset($LANGUAGES);
		foreach ($LANGUAGES as $k => $v)
		{
			$query = "INSERT INTO ".$DBPrefix."faqs_translated VALUES (:i, :l, :q, :a)";
			$params = array();
			$params[] = array(':i', $id, 'int');
			$params[] = array(':l', $k, 'str');
			$params[] = array(':q', stripslashes($_POST['question'][$k]), 'str');
			$params[] = array(':a', stripslashes($_POST['answer'][$k]), 'str');
			$db->query($query, $params);
		}
		header('location: faqs.php');
		exit;
	}
}

// Get data from the database
$query = "SELECT * FROM " . $DBPrefix . "faqscategories";
$db->direct_query($query);

while ($row = $db->result())
{
	$template->assign_block_vars('cats', array(
			'ID' => $row['id'],
			'CATEGORY' => $row['category']
			));
}

foreach ($LANGUAGES as $k => $language)
{
	$template->assign_block_vars('lang', array(
		'LANG' => $language,
		'TITLE' => (isset($_POST['question'][$k])) ? $_POST['question'][$k] : '',
		'CONTENT' => $CKEditor->editor('answer[' . $k . ']', $_POST['answer'][$k])
	));
}
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['5231'],
	'PAGETITLE' => $MSG['5231']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'newfaq.tpl'
		));
$template->display('body');
include 'adminFooter.php';