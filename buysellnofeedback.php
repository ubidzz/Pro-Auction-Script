<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/



include 'common.php';



// If user is not logged in redirect to login page

if (!$user->checkAuth())

{

	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'buysellnofeedback.php';

	header('location: user_login.php');

	exit;

}



$query = "SELECT DISTINCT a.auction, a.seller, a.winner, a.bid, b.id, b.current_bid, b.title, a.qty, a.closingdate

		FROM " . $DBPrefix . "winners a

		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)

		WHERE (b.closed = 1 OR b.bn_only = 'y')

		AND b.suspended = 0

		AND ((a.seller = :user_id AND a.feedback_sel = 0) OR (a.winner = :user_ids AND a.feedback_win = 0))

		AND a.paid = 1";

$params = array(

	array(':user_id', $user->user_data['id'], 'int'),

	array(':user_ids', $user->user_data['id'], 'int')

);

$db->query($query, $params);



$k = 0;

while ($row = $db->result())

{

	$them = ($row['winner'] == $user->user_data['id']) ? $row['seller'] : $row['winner'];

	// Get details

	$query = "SELECT u.nick, u.email

			FROM " . $DBPrefix . "users u

			WHERE u.id = :them";

	$params = array(

		array(':them', $them, 'int')

	);

	$db->query($query, $params);

	$info = $db->result();



	$template->assign_block_vars('fbs', array(

			'ID' => $row['id'],

			'ROWCOLOR' => ($k % 2) ? 'bgcolor="#FFFEEE"' : '',

			'TITLE' => $row['title'],

			'WINORSELLNICK' => $info['nick'],

			'WINORSELL' => ($row['winner'] == $user->user_data['id']) ? $MSG['25_0002'] : $MSG['25_0001'],

			'WINORSELLEMAIL' => $info['email'],

			'SEO_TITLE' => generate_seo_link($row['title']),

			'BID' => $row['bid'],

			'BIDFORM' => $system->print_money($row['bid']),

			'QTY' => ($row['qty'] == 0) ? 1 : $row['qty'],

			'WINNER' => $row['winner'],

			'SELLER' => $row['seller'],

			'CLOSINGDATE' => $system->dateToTimestamp($row['closingdate']),

			'WS' => ($row['winner'] == $user->user_data['id']) ? 'w' : 's'

			));

	$k++;

}

$template->assign_vars(array(

	'NUM_AUCTIONS' => $k,

	'ACTIVEACCOUNTTAB' => 'class="active"',

	'ACTIVELEAVEFEEDBACK' => 'class="active"',

	'ACTIVEACCOUNTPANEL' => 'active'

));



$TPL_rater_nick = $user->user_data['nick'];

include 'header.php';

$template->set_filenames(array(

		'body' => 'sellbuyfeedback.tpl'

		));

$template->display('body');

include 'footer.php';