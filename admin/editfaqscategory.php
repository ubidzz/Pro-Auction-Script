<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);

if ($_POST['action'] == 'update')
{
	if (strlen($_POST['category']) == 0)
	{
		$ERROR = $ERR['049'];
	}
	else
	{
		$query = "UPDATE " . $DBPrefix . "faqscategories SET category = :c WHERE id = :i";
		$params = array();
		$params[] = array(':c', $system->cleanvars($_POST['category'][$system->SETTINGS['defaultlanguage']]), 'str');
		$params[] = array(':i', $_POST['id'], 'int');
		$db->query($query, $params);

	}
	
	foreach ($_POST['category'] as $k => $v)
	{
		$query = "SELECT category FROM " . $DBPrefix . "faqscat_translated WHERE lang = :l AND id = :i";
		$params = array();
		$params[] = array(':l', $k, 'str');
		$params[] = array(':i', $_POST['id'], 'str');
		$db->query($query, $params);
		if ($db->numrows('category') > 0)
		{
			$query = "UPDATE " . $DBPrefix . "faqscat_translated SET category = :c WHERE lang = :l AND id = :i";
			$params = array();
			$params[] = array(':c', $system->cleanvars($_POST['category'][$k]), 'str');
			$params[] = array(':l', $k, 'str');
			$params[] = array(':i', $_POST['id'], 'str');
		}
		else
		{
			$query = "INSERT INTO " . $DBPrefix . "faqscat_translated VALUES (:i, :l, :c)";
			$params = array();
			$params[] = array(':i', $_POST['id'], 'str');
			$params[] = array(':l', $k, 'str');
			$params[] = array(':c', $system->cleanvars($_POST['category'][$k]), 'str');
		}
		$db->query($query, $params);
	}
	header('location: faqscategories.php');
	exit;
}

$query = "SELECT * FROM " . $DBPrefix . "faqscat_translated WHERE id = :i";
$params = array();
$params[] = array(':i', $_GET['id'], 'int');
$db->query($query, $params);

// get all translations
$tr = array();
while ($row = $db->result())
{
	$tr[$row['lang']] = $row['category'];
}

foreach ($LANGUAGES as $k => $v)
{
	$k = trim($k);
	$template->assign_block_vars('flangs', array(
			'LANGUAGE' => $k,
			'TRANSLATION' => $tr[$k]
			));
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'FAQ_NAME' => $tr[$system->SETTINGS['defaultlanguage']],
	'PAGENAME' => $MSG['5232'],
	'ID' => $_GET['id'],
	'PAGETITLE' => $MSG['5232']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'editfaqscategory.tpl'
		));
$template->display('body');
include 'adminFooter.php';