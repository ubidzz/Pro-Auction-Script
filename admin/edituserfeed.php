<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);
$id = intval($_GET['id']);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	$user = intval($_POST['user']);
	$query = "UPDATE " . $DBPrefix . "feedbacks SET rate = :r, feedback = :f WHERE id = :i";
	$params = array();
	$params[] = array(':r', $_POST['aTPL_rate'], 'int');
	$params[] = array(':f', $_POST['TPL_feedback'], 'str');
	$params[] = array(':i', $id, 'int');
	$db->query($query, $params);

	// Update user's record
	$query = "SELECT SUM(rate) as FSUM, count(feedback) as FNUM FROM " . $DBPrefix . "feedbacks
			  WHERE rated_user_id = :i";
	$params = array();
	$params[] = array(':i', $user, 'int');
	$db->query($query, $params);
	$num_sum = $db->result();
	$SUM = $num_sum['FSUM'];
	$NUM = $num_sum['FNUM'];

	$query = "UPDATE " . $DBPrefix . "users SET rate_sum = :s, rate_num = :n WHERE id = :u";
	$params = array();
	$params[] = array(':s', $SUM, 'int');
	$params[] = array(':n', $NUM, 'int');
	$params[] = array(':u', $user, 'int');
	$db->query($query, $params);

	$ERROR = $MSG['183'];
}

$query = "SELECT u.nick, u.id, f.rater_user_nick, f.feedback, f.rate FROM " . $DBPrefix . "feedbacks f
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = f.rated_user_id) WHERE f.id = :i";
$params = array();
$params[] = array(':i', $id, 'int');
$db->query($query, $params);
$feedback = $db->result();

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'RATED_USER' => $feedback['nick'],
	'RATED_USER_ID' => $feedback['id'],
	'RATER_USER' => $feedback['rater_user_nick'],
	'FEEDBACK' => $feedback['feedback'],
	'SEL1' => ($feedback['rate'] == 1),
	'SEL2' => ($feedback['rate'] == 0),
	'SEL3' => ($feedback['rate'] == -1)
));
include 'adminHeader.php';		
$template->set_filenames(array(
		'body' => 'edituserfeed.tpl'
		));
$template->display('body');
include 'adminFooter.php';