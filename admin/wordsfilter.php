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
	// Update database
	$system->writesetting("settings", "wordsfilter", $_POST['wordsfilter'], 'bool');

	//purge the old wordlist
	$query = "DELETE FROM " . $DBPrefix . "filterwords";
	$db->direct_query($query);

	
	//rebuild the wordlist
	$TMP = explode("\n", $_POST['filtervalues']);
	if (is_array($TMP))
	{
		foreach ($TMP as $k => $v)
		{
			$v = trim($v);
			if (!empty($v))
			{
				$query = "INSERT INTO " . $DBPrefix . "filterwords VALUES (:f)";
				$params = array();
				$params[] = array(':f', $v, 'int');
				$db->query($query, $params);
			}
		}
	}
	$ERROR = $MSG['5073'];
}

$query = "SELECT * FROM " . $DBPrefix . "filterwords";
$db->direct_query($query);

$WORDSLIST = '';
while ($word = $db->result())
{
	$WORDSLIST .= $word['word'] . "\n";
}

$template->assign_vars(array(
	'WORDLIST' => $WORDSLIST,
	'WFYES' => ($system->SETTINGS['wordsfilter'] == 'y') ? ' checked="checked"' : '',
	'WFNO' => ($system->SETTINGS['wordsfilter'] == 'n') ? ' checked="checked"' : '',
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['5068'],
	'PAGETITLE' => $MSG['5068']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'wordfilter.tpl'
		));
$template->display('body');
include 'adminFooter.php';