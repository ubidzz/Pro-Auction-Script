<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);

if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	foreach ($_POST['delete'] as $val)
	{
		$query = "DELETE FROM " . $DBPrefix . "faqs WHERE id = :i";
		$params = array();
		$params[] = array(':i', $val, 'int');
		$db->query($query, $params);

		$query = "DELETE FROM " . $DBPrefix . "faqs_translated WHERE faq_id = :i";
		$params = array();
		$params[] = array(':i', $val, 'int');
		$db->query($query, $params);
	}
}

// Get data from the database
$query = "SELECT id, category FROM " . $DBPrefix . "faqscategories";
$db->direct_query($query);
foreach ($db->fetchall() as $row)
{
	$template->assign_block_vars('cats', array(
		'CAT' => '<strong>' . $row['category'] . '<strong>'
	));

	$query = "SELECT id, question FROM " . $DBPrefix . "faqs WHERE category = :id";
	$params = array();
	$params[] = array(':id', $row['id'], 'int');
	$db->query($query, $params);
	
	while ($cat_row = $db->result())
	{
		$template->assign_block_vars('cats.faqs', array(
			'ID' => $cat_row['id'],
			'FAQ' => $cat_row['question']
		));
	}
}
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['5232'],
	'PAGETITLE' => $MSG['5232']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'faqs.tpl'
		));
$template->display('body');
include 'adminFooter.php';