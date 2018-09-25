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

// check input data
$id = (intval($security->decrypt($_GET['id'])) > 0 && isset($_GET['id'])) ? $security->decrypt($_GET['id']) : 0;

if (intval($id) == 0 || !isset($id))

{

	invaildinvoice();

}

// get fee data

$query = "SELECT * FROM " . $DBPrefix . "useraccounts WHERE useracc_id = :user_id";

$params = array(

	array(':user_id', intval($id), 'int')

);

$db->query($query, $params);


// check its real

if ($db->numrows() < 1)

{

	invaildinvoice();

}



$data = $db->result();

$vat = getTax();

$payvalue = $data['total'];

// create fee data ready for template & get totals
$tax_price = round(($vat * ($payvalue / 100)), $system->SETTINGS['moneydecimals']);

$total = $payvalue + $tax_price;

setfeetemplate($data);

$template->assign_vars(array(

	'ID' => $data['useracc_id'],

	'DOCDIR' => $DOCDIR,
	
	'SITENAME' => $system->SETTINGS['sitename'],
	
	'STATUS' => ($data['paid'] == 1) ? '<strong style="color:green">' . $MSG['898'] . '</strong>' : '<strong style="color:red">' . $MSG['3500_1016037'] . '</strong>',

	'LOGO' => ($system->SETTINGS['logo']) ? '<a href="' . $system->SETTINGS['siteurl'] . 'home"><img src="' . $system->SETTINGS['siteurl'] . UPLOAD_FOLDER . 'logos/' . $system->SETTINGS['logo'] . '" border="0" alt="' . $system->SETTINGS['sitename'] . '"></a>' : '&nbsp;',

	'CHARSET' => $CHARSET,

	'LANGUAGE' => $language,

	'AUCTION_ID' => $data['auc_id'],

	'INVOICE_DATE' => $system->ArrangeDateAndTime($data['date']),

	// tax start

	'TAX' => sprintf($MSG['1052'], $vat) . '%:',

	'VAT_TOTAL' => $system->print_money($tax_price, true, false),

	'TOTAL_SUM' => $system->print_money($payvalue, true, false),

	// tax end
		
	'TOTAL' => $system->print_money($total, true, false),
	
	'THANKYOU' => $system->SETTINGS['invoice_thankyou']

));



$template->set_filenames(array(

		'body' => 'order_invoice.tpl'

		));

$template->display('body');

