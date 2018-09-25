<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

// Default for error message (blank)
unset($ERROR);

// Update message
if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (empty($_POST['question'][$system->SETTINGS['defaultlanguage']])
		|| empty($_POST['answer'][$system->SETTINGS['defaultlanguage']]))
	{
		$ERROR = $ERR['067'];
		$faq = $_POST;
	}
	else
	{
		$query = "UPDATE " . $DBPrefix . "faqs SET category = :cat, question = :quest, answer = :answ WHERE id = :faqID";
		$params = array(
			array(':cat', $_POST['category'], 'int'),
			array(':quest', stripslashes($_POST['question'][$system->SETTINGS['defaultlanguage']]), 'str'),
			array(':answ', stripslashes($_POST['answer'][$system->SETTINGS['defaultlanguage']]), 'str'),
			array(':faqID', intval($_POST['id']), 'int')
		);
		$db->query($query, $params);

		reset($LANGUAGES);
		foreach ($LANGUAGES as $k => $v)
		{
			$query = "SELECT question FROM " . $DBPrefix . "faqs_translated WHERE lang = :language AND faq_id = :faqID";
			$params = array(
				array(':language', $v, 'str'),
				array(':faqID', intval($_POST['id']), 'int')
			);
			$db->query($query, $params);
			if ($db->numrows() > 0)
			{
				$query = "UPDATE " . $DBPrefix . "faqs_translated SET question = :quest, answer = :answ WHERE faq_id = :faqID AND lang = :language";
				$params = array(
					array(':quest', stripslashes($_POST['question'][$k]), 'str'),
					array(':answ', stripslashes($_POST['answer'][$k]), 'str'),
					array(':faqID', intval($_POST['id']), 'int'),
					array(':language', $v, 'str')
				);
				$db->query($query, $params);
			}
			else
			{
				$query = "INSERT INTO " . $DBPrefix . "faqs_translated (faq_id, lang, question, answer)VALUES (:faqID, :language, :quest, :answ)";
				$params = array(
					array(':faqID', intval($_POST['id']), 'int'),
					array(':language', $v, 'str'),
					array(':quest', stripslashes($_POST['question'][$k]), 'str'),
					array(':answ', stripslashes($_POST['answer'][$k]), 'str')
				);
				$db->query($query, $params);
			}
		}  
		print_r($db->error);
	}
}

// load categories
$query = "SELECT * FROM " . $DBPrefix . "faqscategories ORDER BY :o";
$params = array(
	array(':o', 'category', 'str')
);
$db->query($query, $params);
while ($row = $db->result())
{
	$template->assign_block_vars('cats', array(
			'ID' => $row['id'],
			'CAT' => $row['category']
			));
}

// Get data from the database
$query = "SELECT * FROM " . $DBPrefix . "faqs_translated WHERE faq_id = :i";
$params = array(
	array(':i', $_GET['id'], 'int')
);
$db->query($query, $params);
while ($row = $db->result())
{
	$QUESTION_tr[$row['lang']] = $row['question'];
	$ANSWER_tr[$row['lang']] = $row['answer'];
}
				
reset($LANGUAGES);
foreach ($LANGUAGES as $k => $v)
{
	$template->assign_block_vars('qs', array(
			'LANG' => $k,
			'QUESTION' => (isset($_POST['question'][$k])) ? $_POST['question'][$k] : $QUESTION_tr[$k]
			));
	$template->assign_block_vars('as', array(
			'LANG' => $k,
			'ANSWER' => $CKEditor->editor('answer[' . $k . ']', $ANSWER_tr[$k])
			));
}

// Get data from the database
$query = "SELECT * FROM " . $DBPrefix . "faqs WHERE id = :i";
$params = array(
	array(':i', $_GET['id'], 'int')
);
$db->query($query, $params);
$faq = $db->result();

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'ID' => $faq['id'],
	'FAQ_NAME' => $faq['question'],
	'PAGENAME' => $MSG['5241'],
	'FAQ_CAT' => $faq['category'],
	'PAGETITLE' => $MSG['5241']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'editfaq.tpl'
		));
$template->display('body');
include 'adminFooter.php';