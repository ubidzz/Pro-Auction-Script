<?php 
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
 
if (!defined('InProAuctionScript')) exit('Access denied');


function getTax()
{
	global $DBPrefix, $db;
	
	$query = "SELECT * FROM " . $DBPrefix . "tax WHERE tax_name = 'Site Fees'";
	$db->direct_query($query);

	if ($db->numrows() == 0)
	{
		$tax_rate = 0;
	}
	else
	{
		$tax_rate = $db->result('tax_rate');
	}

	return $tax_rate;
}

function setfeetemplate($data)
{
	global $template, $system, $MSG;

	$feenames = array(
		'signup' => $MSG['430'],
		'buyer' => $MSG['775'],
		'setup' => $MSG['432'],
		'featured' => $MSG['433'],
		'bold' => $MSG['439'],
		'highlighted' => $MSG['434'],
		'subtitle' => $MSG['803'],
		'extcat' => $MSG['804'],
		'reserve' => $MSG['440'],
		'image' => $MSG['435'],
		'relist' => $MSG['437'],
		'buynow' => $MSG['436'],
		'finalval' => $MSG['791'],
		'geomap' => $MSG['3500_1015816'],
		'balance' => $MSG['935']
		);
	$total = 0;
	$total_exculding = 0;
	foreach ($data as $k => $v)
	{
		if (in_array($k, array('setup', 'featured', 'bold', 'highlighted', 'subtitle', 'relist', 'reserve', 'buynow', 'image', 'extcat', 'signup', 'buyer', 'finalval', 'geomap', 'balance')))
		{
			if ($v > 0)
			{
				$tax = getTax();
				$tax_price = round(($tax * ($v / 100)), $system->SETTINGS['moneydecimals']);
				$total = round(($v + $tax_price), $system->SETTINGS['moneydecimals']);

				$template->assign_block_vars('fees', array(
						'FEE' => $feenames[$k],
						'UNIT_PRICE' => $system->print_money_nosymbol($v),
						'UNIT_PRICE_WITH_TAX' => $system->print_money_nosymbol($tax_price),
						'TOTAL_WITH_TAX' => $system->print_money_nosymbol($total)
						));
			}
		}
	}
	return array($total, $total_exculding);
}

// add vat
function vat($price)
{
	global $system, $vat;
    $price_with_vat = $price + ($vat * ($price / 100));
    $price_with_vat = round($price_with_vat, $system->SETTINGS['moneydecimals']);
    return $price_with_vat;
}

// remove vat
function vatexcluding($gross)
{
	global $system, $user;
	
	$vat = getTax(true, $user->user_data['country']);
	$multiplier = ($vat + 100) / 100;
	$net = $gross / $multiplier;
	return number_format($net, $system->SETTINGS['moneydecimals']);
}

function invaildinvoice($packingslip = false)
{
	global $template, $system;

	$template->assign_vars(array(
			'LOGO' => $system->SETTINGS['siteurl'] . 'themes/' . $system->SETTINGS['theme'] . '/' . $system->SETTINGS['logo'],
			'LANGUAGE' => $language,
			'SALE_ID' => 0,
			'B_INVOICE' => false
			));

	$file = ($packingslip) ? 'order_packingslip.tpl' : 'order_invoice.tpl';

	$template->set_filenames(array(
			'body' => $file
			));
	$template->display('body');
	exit;
}
?>
