<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/

include 'common.php';



//Used for downloading the digital items

if (isset($_GET['fromfile']) && ($_GET['diupload'] == 3))

{	

	$query = "SELECT hash FROM " . $DBPrefix . "digital_items WHERE hash = :hash_id"; 

	$params = array(

		array(':hash_id', $security->decrypt($_GET['fromfile']), 'str')

	);

	$db->query($query, $params);

	if($db->numrows() == 1)

	{

		include PLUGIN_PATH . 'DigitalItemHandler/DownloadHandler.php';

		$handler = new DigitalItem();

		$handler->downloadItem($_GET['fromfile'], 'passed');

	}else{

		header('location: ' . $system->SETTINGS['siteurl'] . 'home');

		exit;

	}

}



// If user is not logged in redirect to login page

if (!$user->logged_in)

{

	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'my_downloads.php';

	header('location: user_login.php');

	exit;

}



$query = "SELECT DISTINCT w.id

		FROM " . $DBPrefix . "winners w

		LEFT JOIN " . $DBPrefix . "users u ON (u.id = w.seller)

		LEFT JOIN " . $DBPrefix . "digital_items d ON (d.auctions = w.auction)

		LEFT JOIN " . $DBPrefix . "auctions a ON (a.id = w.auction)

		WHERE w.auction = d.auctions AND w.winner = :user_id";

$params = array(

	array(':user_id', $user->user_data['id'], 'int')

);

$db->query($query, $params);

$TOTALAUCTIONS = $db->numrows('id');

if (!isset($_GET['PAGE']) || $_GET['PAGE'] <= 1 || $_GET['PAGE'] == '')

{

	$OFFSET = 0;

	$PAGE = 1;

}

else

{

	$PAGE = intval($_GET['PAGE']);

	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];

}

$PAGES = ($TOTALAUCTIONS == 0) ? 1 : ceil($TOTALAUCTIONS / $system->SETTINGS['perpage']);



// Get closed auctions with winners

$query = "SELECT DISTINCT a.title, w.id, w.seller, w.paid, w.feedback_win, d.item, d.hash, d.auctions, d.seller, u.nick, u.email

		FROM " . $DBPrefix . "winners w

		LEFT JOIN " . $DBPrefix . "users u ON (u.id = w.seller)

		LEFT JOIN " . $DBPrefix . "digital_items d ON (d.auctions = w.auction)

		LEFT JOIN " . $DBPrefix . "auctions a ON (a.id = w.auction)

		WHERE w.auction = d.auctions AND w.winner = :user_id LIMIT :offset, :perpage";

$params = array(

	array(':user_id', $user->user_data['id'], 'int'),

	array(':offset', $OFFSET, 'int'),

	array(':perpage', $system->SETTINGS['perpage'], 'int')

);

$db->query($query, $params);



while ($row = $db->result())

{

	if(!empty($row['item']))

	{

		$template->assign_block_vars('items', array(

			'AUC_ID' => $row['auctions'],

			'ID' => $row['id'],

			'DIGITAL_ITEM_NAME' => $row['item'],

			'DIGITAL_ITEM' => $security->encrypt($row['hash']),

			'SELLNICK' => $row['nick'],

			'SEO_TITLE' => generate_seo_link($row['title']),

			'SELLEMAIL' => $row['email'],

			'TITLE' => $row['title'],

			'FB_LINK' => ($row['feedback_win'] == 0) ? '<a href="' . $system->SETTINGS['siteurl'] . 'feedback.php?auction_id=' . $row['auctions'] . '&wid=' . $user->user_data['id'] . '&sid=' . $row['seller'] . '&ws=w">' . $MSG['207'] . '</a>' : '',

			'B_PAID' => ($row['paid'] == 1),

			'B_DIGITAL_ITEM' => (isset($row['item'])),

			'B_DIGITAL_ITEM_PAID' => (isset($row['item'])) ? $row['paid'] == 1 : ''

		));

	}

}



// get pagenation

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

				'PAGE' => ($PAGE == $COUNTER) ? '<li class="disabled"><a href="#">' . $COUNTER . '</a></li>' : '<li><a href="' . $system->SETTINGS['siteurl'] . 'my_downloads.php?PAGE=' . $COUNTER . '">' . $COUNTER . '</a></li>'

				));

		$COUNTER++;

	}

}



$template->assign_vars(array(

	'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<li><a href="' . $system->SETTINGS['siteurl'] . 'my_downloads.php?PAGE=' . $PREV . '">' . $MSG['5119'] . '</a></li>' : '',

	'NEXT' => ($PAGE < $PAGES) ? '<li><a href="' . $system->SETTINGS['siteurl'] . 'my_downloads.php?PAGE=' . $NEXT . '">' . $MSG['5120'] . '</a></li>' : '',

	'PAGE' => $PAGE,

	'PAGES' => $PAGES,

	'ACTIVEBUYINGTAB' => 'class="active"',

	'ACTIVEMYDOWNLOADS' => 'class="active"',

	'ACTIVEBUYINGPANEL' => 'active'

));



include 'header.php';

$template->set_filenames(array(

		'body' => 'my_download.tpl'

		));

$template->display('body');

include 'footer.php';