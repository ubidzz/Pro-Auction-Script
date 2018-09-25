<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/



include 'common.php';



// If user is not logged in redirect to login page

if (!$user->logged_in)

{

	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'buying.php';

	header('location: user_login.php');

	exit;

}

include INCLUDE_PATH . 'auction/class_item_setting.php';

$ItemStatus = new ItemSettings();



if(isset($_POST['update']) && $_POST['update'] == 'shipped')

{

	if (isset($_POST['shipped']) && $_POST['shipped'] > 0)

	{

		$ItemStatus->UpdateShippingStatus(2, 'winner');

		

		//prevent users from refreshing the pages to change the DB

		header('location: buying.php');

		exit;

	}

}



$query = "SELECT a.id 

		FROM " . $DBPrefix . "winners a

		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)

		WHERE (b.closed = 1 OR b.bn_only = 'y') AND b.suspended = 0 AND a.winner = :user_id ORDER BY a.closingdate DESC";

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

$query = "SELECT DISTINCT a.shipped, b.auction_type, b.shipping_cost_additional, a.id, a.shipper, a.winner, a.shipper_url, a.tracking_number, a.qty, a.seller, a.paid, a.feedback_win, a.bid, a.auction, b.title, b.ends, b.shipping_cost, b.shipping, d.item, d.hash, d.auctions, u.nick, u.email

		FROM " . $DBPrefix . "winners a

		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)

		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.seller)

		LEFT JOIN " . $DBPrefix . "digital_items d ON (a.auction = d.auctions)

		WHERE (b.closed = 1 OR b.bn_only = 'y') AND b.suspended = 0

		AND a.winner = :user_id ORDER BY a.closingdate DESC LIMIT :offset, :perpage";

$params = array(

	array(':user_id', $user->user_data['id'], 'int'),

	array(':offset', $OFFSET, 'int'),

	array(':perpage', $system->SETTINGS['perpage'], 'int')

);

$db->query($query, $params);



while ($row = $db->result())

{	

	$ashipping = ($row['shipping_cost_additional'] * ($row['qty'] - 1));

	$totalcost = ($row['qty'] > 1) ? ($row['bid'] * $row['qty']) : $row['bid'];

	$totalcost = ($row['shipping'] == 2) ? $totalcost : ($totalcost + $row['shipping_cost'] + $ashipping);

	$totalcost = ($row['shipping'] == 3) ? $row['bid'] : $totalcost;



	$template->assign_block_vars('items', array(

		'AUC_ID' => $row['auction'],

		'TITLE' => $row['title'],

		'ID' => $row['id'],

		'ENDS' => $system->dateToTimestamp($row['ends']),

		'BID' => $row['bid'],

		'FBID' => $row['bid'] > 0 ? $system->print_money($row['bid']) : $MSG['3500_1015745'],

		'SEO_TITLE' => generate_seo_link($row['title']),

		'QTY' => ($row['qty'] > 0) ? $row['qty'] : 1,

		'TOTAL' => $system->print_money($totalcost),

		'SELLID' => $row['seller'],

		'WINNERID' => $row['winner'],

		'SELLNICK' => $row['nick'],

		'SELLEMAIL' => $row['email'],

		'SHIPPINGCOST' => $system->print_money($row['shipping_cost']),

		'BUYER_ID' => $user->user_data['id'],

		'PAY_LINK' => (empty($row['item'])) ? 'pay.php?a=2' : 'pay.php?a=10',

		'SHIPPER' => isset($row['shipper']) ? $row['shipper'] : '',

		'SHIPPERURL' => isset($row['shipper_url']) ? $row['shipper_url'] : '',

		'TRACKINGNUMBER' => isset($row['tracking_number']) ? $row['tracking_number'] : '',

		'DIGITAL_ITEM_SHIPPING' => $system->print_money('0.00'),

		'DIGITAL_ITEM_QUANTITY' => '1',

		'DIGITAL_ITEM_BID' => $system->print_money($row['bid']),

		'DIGITAL_ITEMS' => $security->encrypt($row['hash']),

		'B_SHIPPER' => isset($row['shipper']) && isset($row['tracking_number']) && $row['auction_type'] < 3 ? true : false,

		'B_SHIPPERURL' => empty($row['shipper_url']) ? true : false,

		'B_SHIPPED_0' => ($row['shipped'] == 0) ? true : false,

		'B_SHIPPED_1' => ($row['shipped'] == 1) ? true : false,

		'B_SHIPPED_2' => ($row['shipped'] == 2) ? true : false,

		'B_PAID' => ($row['paid'] == 1) ? true : false,

		'B_DIGITAL_ITEM' => (!empty($row['item'])) ? true : false,

		'FB_LINK' => ($row['feedback_win'] == 0) ? true : false

	));

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

				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'buying.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'

				));

		$COUNTER++;

	}

}



$template->assign_vars(array(

	'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'buying.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',

	'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'buying.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',

	'PAGE' => $PAGE,

	'PAGES' => $PAGES,

	'ACTIVEBUYINGTAB' => 'class="active"',

	'ACTIVEAUCTIONSWON' => 'class="active"',

	'ACTIVEBUYINGPANEL' => 'active'

));



include 'header.php';

$template->set_filenames(array(

		'body' => 'buying.tpl'

		));

$template->display('body');

include 'footer.php';