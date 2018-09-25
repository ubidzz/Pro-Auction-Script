<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/



include 'common.php';

if (isset($_GET['fail']) || isset($_GET['completed']))

{

	$template->assign_vars(array(

			'TITLE_MESSAGE' => (isset($_GET['fail'])) ? $MSG['425'] :  $MSG['423'],

			'BODY_MESSAGE' => (isset($_GET['fail'])) ? $MSG['426'] :  $MSG['424']

			));

	include 'header.php';

	$template->set_filenames(array(

			'body' => 'message.tpl'

			));

	$template->display('body');

	include 'footer.php';

	exit;

}



$fees = new process_fees;

$fees->data = $_POST;



if (isset($_GET['paypal']))

{

	$fees->paypal_validate();

}

if (isset($_GET['authnet']))

{

	$fees->authnet_validate();

}

if (isset($_GET['worldpay']))

{

	$fees->worldpay_validate();

}

if (isset($_GET['skrill']))

{

	$fees->skrill_validate();

}

if (isset($_GET['toocheckout']))

{

	$fees->toocheckout_validate();

}