<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);

$subject = (isset($_POST['subject'])) ? stripslashes($_POST['subject']) : '';
$content = (isset($_POST['content'])) ? stripslashes($_POST['content']) : '';
$is_preview = false;

if (isset($_POST['action']) && $_POST['action'] == 'submit')
{
	if (empty($subject) || empty($content))
	{
		$ERROR = $ERR['5014'];
	}
	else
	{
		$COUNTER = 0;
		switch($_POST['usersfilter'])
		{
			case 'all':
				$extra = '';
				break;
			case 'active':
				$extra = ' AND suspended = 0';
				break;
			case 'admin':
				$extra = ' AND suspended = 1';
				break;
			case 'fee':
				$extra = ' AND suspended = 9';
				break;
			case 'confirmed':
				$extra = ' AND suspended = 8';
				break;
		}
		$query = "SELECT email, id FROM " . $DBPrefix . "users WHERE nletter = 1" . $extra;
		$db->direct_query($query);
		while ($row = $db->result())
		{
			if ($send_email->send_newsletter($row['id'], $row['email'], $content, $subject))
			{
				$COUNTER++;
			}
		}
		$ERROR = $COUNTER . $MSG['5300'];
	}
}
elseif (isset($_POST['action']) && $_POST['action'] == 'preview')
{
	$is_preview = true;
}

$USERSFILTER = array('all' => $MSG['5296'],
	'active' => $MSG['5291'],
	'admin' => $MSG['5294'],
	'fee' => $MSG['5293'],
	'confirmed' => $MSG['5292']);

$selectsetting = (isset($_POST['usersfilter'])) ? $_POST['usersfilter'] : '';

$template->assign_vars(array(
	'SELECTBOX' => generateSelect('usersfilter', $USERSFILTER, $selectsetting),
	'SUBJECT' => $subject,
	'EDITOR' => $CKEditor->editor('content', stripslashes($content)),
	'PREVIEW' => $content,
	'B_PREVIEW' => $is_preview,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['607'],
	'PAGETITLE' => $MSG['607']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'newsletter.tpl'
		));
$template->display('body');
include 'adminFooter.php';