<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include INCLUDE_PATH . 'membertypes.inc.php';

foreach ($membertypes as $idm => $memtypearr)
{
	$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;
}
ksort($memtypesarr, SORT_NUMERIC);

$secid = intval($_GET['id']);
$query = "SELECT nick, rate_sum, rate_num FROM " . $DBPrefix . "users WHERE id = :i";
$params = array();
$params[] = array(':i', $secid, 'int');
$db->query($query, $params);
$bg = '';

if ($db->numrows() > 0)
{
	$arr = $db->result();
	$num_fbs = $arr['rate_num'];
	// get page limits
	if (!isset($_GET['PAGE']) || $_GET['PAGE'] == '')
	{
		$OFFSET = 0;
		$PAGE = 1;
	}
	else
	{
		$PAGE = intval($_GET['PAGE']);
		$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
	}
	$PAGES = ($num_fbs == 0) ? 1 : ceil($num_fbs / $system->SETTINGS['perpage']);

	$i = 0;
	foreach ($memtypesarr as $k => $l)
	{
		if ($k >= $arr['rate_sum'] || $i++ == (count($memtypesarr)-1))
		{
			$feedback_image = '<img src="' . $system->SETTINGS['siteurl'] . '/images/icons/' . $l['icon'] . '" class="fbstar">';
			break;
		}
	}

	$query = "SELECT * FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = :rui ORDER by feedbackdate DESC";
	$params = array();
	$params[] = array(':rui', $secid, 'int');
	$db->query($query, $params);
	while ($arrfeed = $db->result())
	{
		switch($arrfeed['rate'])
		{
			case 1:
				$fb_type = 'positive';
				break;
			case -1:
				$fb_type = 'negative';
				break;
			case 0:
				$fb_type = 'neutral';
				break;
		}

		$template->assign_block_vars('feedback', array(
				'FB_TYPE' => $fb_type,
				'FB_FROM' => $arrfeed['rater_user_nick'],
				'FB_TIME' => $system->dateToTimestamp($arrfeed['feedbackdate'], '/', false),
				'FB_MSG' => nl2br($arrfeed['feedback']),
				'FB_ID' => $arrfeed['id'],
				'BG' => $bg
				));
		$bg = ($bg == '') ? 'class="bg"' : '';
	}
}
else
{
	$ERROROR = $ERROR['105'];
}

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
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/userfeedback.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
	'ID' => $secid,
	'NICK' => $arr['nick'],
	'FB_NUM' => $arr['rate_num'],
	'FB_IMG' => $feedback_image,
	'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/userfeedback.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
	'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/userfeedback.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
	'PAGE' => $PAGE,
	'PAGES' => $PAGES,
	'ERROR' => (isset($ERROROR)) ? $ERROROR : '',
	'PAGENAME' => $MSG['503'],
	'PAGETITLE' => $MSG['503']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'userfeedback.tpl'
		));
$template->display('body');
include 'adminFooter.php';