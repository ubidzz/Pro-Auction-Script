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

	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'invoices.php';

	header('location: user_login.php');

	exit;

}



if (!isset($_GET['PAGE']) || $_GET['PAGE'] == 1)

{

	$OFFSET = 0;

	$PAGE = 1;

}

else

{

	$PAGE = intval($_GET['PAGE']);

	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];

}



// count the pages

$query = "SELECT COUNT(useracc_id) As COUNT FROM " . $DBPrefix . "useraccounts

    WHERE user_id = :user_id";

$params = array(

	array(':user_id', $user->user_data['id'], 'int')

);

$db->query($query, $params);

$TOTALINVOICES = $db->result('COUNT');

$PAGES = ($TOTALINVOICES == 0) ? 1 : ceil($TOTALINVOICES / $system->SETTINGS['perpage']);



// get this page of data
$query = "SELECT tax_rate FROM " . $DBPrefix . "tax WHERE tax_name = 'Site Fees'";
$db->direct_query($query);
if ($db->numrows() == 0)
{
	$tax_rate = 0;
}
else
{
	$tax_rate = $db->result('tax_rate');
}


$query = "SELECT * FROM " . $DBPrefix . "useraccounts WHERE user_id = :user_ids ORDER BY useracc_id desc LIMIT " . intval($OFFSET) . ", " . $system->SETTINGS['perpage'] . "";

$params = array(

	array(':user_ids', $user->user_data['id'], 'int')

);

$db->query($query, $params);



while ($row = $db->result())

{

	if ($row['total'] > 0)

	{

		$tax_price = round(($tax_rate * ($row['total'] / 100)), $system->SETTINGS['moneydecimals']);

		$template->assign_block_vars('topay', array(

			'INVOICE' => $security->encrypt($row['useracc_id']),
			
			'ID' => $row['useracc_id'],

			'AUC_ID' => $row['auc_id'],

			'DATE' => $system->ArrangeDateAndTime($row['date'], $user->user_data['timezone']),

			'TOTAL' => $system->print_money($row['total'] + $tax_price),

			'PAID' => ($row['paid'] == 1), // true if paid

			'PDF' => $system->SETTINGS['siteurl'] . 'item_invoice.php?id=' . $row['auc_id']

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

				'PAGE' => ($PAGE == $COUNTER) ? '<li class="disabled"><a href="#">' . $COUNTER . '</a></li>' : '<li><a href="' . $system->SETTINGS['siteurl'] . 'outstanding.php?PAGE=' . $COUNTER . '">' . $COUNTER . '</a></li>'

				));

		$COUNTER++;

	}

}



$_SESSION['INVOICE_RETURN'] = 'invoices.php';

$template->assign_vars(array(

	'CURRENCY' => $system->SETTINGS['currency'],

	'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'outstanding.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',

	'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'outstanding.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',

	'PAGE' => $PAGE,

	'PAGES' => $PAGES,

	'ACTIVEACCOUNTTAB' => 'class="active"',

	'ACTIVEOUTSTANDING' => 'class="active"',

	'ACTIVEACCOUNTPANEL' => 'active'

));



include 'header.php';

$template->set_filenames(array(

		'body' => 'invoices.tpl'

		));

$template->display('body');

include 'footer.php';

