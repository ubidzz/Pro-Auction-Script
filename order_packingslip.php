<?php 
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

include 'common.php';
include INCLUDE_PATH . 'functions_invoices.php';



// If user is not logged in redirect to login page

if (!$user->checkAuth())

{

	header('location: user_login.php');

	exit;

}

$jsfiles = 'js/jquery.js;';

$query = "SELECT w.id, w.winner, w.closingdate, w.seller, w.bid, w.paid, a.id AS auctid, a.title, a.subtitle, a.auction_type, a.bn_only, a.shipping_cost, a.shipping_cost_additional, w.qty, a.payment, u.id As uid, u.rate_sum, d.hash, d.auctions

	FROM " . $DBPrefix . "auctions a

	LEFT JOIN " . $DBPrefix . "winners w ON (a.id = w.auction)

	LEFT JOIN " . $DBPrefix . "users u ON (u.id = w.seller)

	LEFT JOIN " . $DBPrefix . "digital_items d ON (a.id = d.auctions)

	WHERE a.id = :pfval AND w.id = :pfwon";

$params = array(

	array(':pfval', intval($_POST['pfval']), 'int'),

	array(':pfwon', intval($_POST['pfwon']), 'int')

);

$db->query($query, $params);

//check its real

if ($db->numrows() < 1)

{

	header('location: selling.php');

	exit;

}
       

$data = $db->result();

$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :seller_id";
$params = array(
	array(':seller_id', intval($data['seller']), 'int')
);
$db->query($query, $params);
$seller = $db->result();
$template->assign_block_vars('seller', array(
	'NAME' => $seller['name'],
	'COMPANY' => $seller['company'],
	'ADDRESS' => $seller['address'],
	'CITY' => $seller['city'],
	'PROV' => $seller['prov'],
	'POSTCODE' => $seller['zip'],
	'COUNTRY' => $seller['country'],
	'EMAIL' => $seller['email']
));

$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :seller_id";
$params = array(
	array(':seller_id', intval($data['winner']), 'int')
);
$db->query($query, $params);
$seller = $db->result();
$template->assign_block_vars('winner', array(
	'NAME' => $seller['name'],
	'COMPANY' => $seller['company'],
	'ADDRESS' => $seller['address'],
	'CITY' => $seller['city'],
	'PROV' => $seller['prov'],
	'POSTCODE' => $seller['zip'],
	'COUNTRY' => $seller['country'],
	'EMAIL' => $seller['email']
));

foreach($sender as $k => $v)

{

	if ($v !== '')

	{

		$sendadd .= "$v<br />";

	}

}

$winner = getwinner(intval($data['winner']));

foreach($winner as $k => $v)

{

	if ($v !== '')

	{

    	$winneradd .= "$v<br />";

    }

}

$item_quantity = $data['qty'];

$title = $data['title'];

$subtitle = $data['subtitle'];

$sale = intval($_POST['pfwon']);

$bid = $data['bid'];

$qty = $data['qty'];

$qaty = $data['qty'];

$qauty = $data['qty'];

$qanty = $data['qty'];

$qaty = $data['qty'];

$additional_shipping = $data['shipping_cost_additional'];

$shipping_cost = $data['shipping_cost'];

$additional_shipping_cost = $qty - 1;

$dadditional_shipping_cost = $qty - 1;

		

//-----rating------	

include 'includes/' . 'membertypes.inc.php';

foreach ($membertypes as $idm => $memtypearr)

{$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;}

ksort($memtypesarr, SORT_NUMERIC);

$TPL_rate_ratio_value = '';

	foreach ($memtypesarr as $k => $l)

	{

		if ($k >= $data['rate_sum'] || $l++ == (count($memtypesarr) - 1))

		{

			$TPL_rate_ratio_value = "images/icons/" . $l['icon'] ."";

			break;

		}

	} 

//----------rating end-------



// payment methods------

$payment = explode(', ', $data['payment']);

$payment_methods = '';

$gateways_data = $system->loadTable('gateways');

$gateway_list = explode(',', $gateways_data['gateways']);

$p_first = true;

foreach ($gateway_list as $v)

{

	$v = strtolower($v);

	if ($gateways_data[$v . '_active'] == 1 && _in_array($v, $payment))

	{

		if (!$p_first)

		{

			$payment_methods .= ', ';

		}

		else

		{

			$p_first = false;

		}

		$payment_methods .= $system->SETTINGS['gateways'][$v];

	}

}



$payment_options = unserialize($system->SETTINGS['payment_options']);

foreach ($payment_options as $k => $v)

{

	if (_in_array($k, $payment))

	{

		if (!$p_first)

		{

			$payment_methods .= ', ';

		}

		else

		{

			$p_first = false;

		}

		$payment_methods .= $v;

	}

}

// payment methods ends

$additionalShippingPrice = $shipping_cost > 0 ? $data['auction_type'] == 2 ? $MSG['350_1008'] . ': ' . $system->print_money($shipping_cost + $bid * $qaty + $additional_shipping * $qanty = $additional_shipping_cost) : $MSG['350_1008'] . ': ' . $system->print_money($data['shipping_cost_additional'] * $qty = $dadditional_shipping_cost) : '';

$template->assign_vars(array(

	'CHARSET' => $CHARSET,

	'LANGUAGE' => $language,

	'THEME' => $system->SETTINGS['theme'],

	'INCURL' => $system->SETTINGS['siteurl'],

	'AUCTION_TITLE' => strtoupper($title),

	'QTY' => $qty,

	'AUCTION_ID' => $data['auctid'],

	'RATE_SUM' => $data['rate_sum'],

	'RATE_RATIO' => $TPL_rate_ratio_value,

	'SHIPPING_METHOD' => "N/A",

	'BIDF' => $system->print_money($bid * $qty),

	'SHIPPING' => $data['auction_type'] == 3 ? $system->print_money('0.00') :$system->print_money($shipping_cost),

	'ADDITIONAL_SHIPPING_COST' => $additionalShippingPrice,

	'ATOTAL' => $system->print_money($shipping_cost + $bid * $qaty + $additional_shipping * $qanty = $additional_shipping_cost),

	'DOCDIR' => $DOCDIR, // Set document direction (set in includes/messages.XX.inc.php) ltr/rtl	 		 

	'DTOTAL' => $system->print_money($shipping_cost + ($data['bid'] * $data['qty']) + ($data['shipping_cost_additional'] * $qaty)),

	'TOTAL' => $system->print_money($shipping_cost + $bid * $data['qty']),

	'PAYMENT_METHOD' => $payment_methods,	

	'SALE_DATE' => "N/A",

 	'SUBTITLE' => strtoupper($subtitle ),

	'CLOSING_DATE' => $system->ArrangeDateAndTime($data['closingdate']),

	'DOWNLOAD' => $system->SETTINGS['siteurl'] . 'my_downloads.php?diupload=3&fromfile=' . $security->encrypt($data['hash']),

	'PAYMENT' => $data['payment'],

	'ITEM_QUANTITY' => $data['auction_type'] == 3 ? 1 : $data['qty'],

	'ORDERS' => 1,  //can link to an if statment or something to show else part in html

	'LOGO' => ($system->SETTINGS['logo']) ? '<a href="' . $system->SETTINGS['siteurl'] . 'home"><img src="' . $system->SETTINGS['siteurl'] . 'uploaded/logos/' . $system->SETTINGS['logo'] . '" border="0" alt="' . $system->SETTINGS['sitename'] . '"></a>' : '&nbsp;',

	'JSFILES' => $jsfiles,

	'FAVICON' => $system->SETTINGS['favicon'],

	'PAYMENTSTATUS' => $data['paid'] == 1 ? $MSG['755'] : $MSG['3500_1015909'],

	'B_BUY_NOW_ONLY' => $data['bn_only'] == 'y',

	'B_DUCH' => $data['auction_type'] == 2,

	'B_STANDARD' => $data['auction_type'] == 1,

	'B_DIGITAL' => $data['auction_type'] == 3

));



$template->set_filenames(array(

		'body' => 'order_packingslip.tpl'

		));

$template->display('body');