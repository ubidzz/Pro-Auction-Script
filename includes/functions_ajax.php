<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/



if (!defined('InProAuctionScript')) exit('Access denied');

function converter_call($post_data = true, $data = array())
{
	global $system;
	include INCLUDE_PATH . 'converter.inc.php';

	// get convertion data
	if ($post_data)
	{
		global $_REQUEST;
		$amount = $_REQUEST['amount'];
		$from = $_REQUEST['from'];
		$to = $_REQUEST['to'];
	}
	else
	{
		$amount = $data['amount'];
		$from = $data['from'];
		$to = $data['to'];
	}
	$amount = $system->input_money($amount);

	$CURRENCIES = CurrenciesList();

	$conversion = ConvertCurrency($from, $to, $amount);
	// construct string
	echo $amount . ' ' . $CURRENCIES[$from] . ' = ' . $system->print_money_nosymbol($conversion, true) . ' ' . $CURRENCIES[$to];
}

// reload the gallery table on upldgallery.php page
function getupldtable()
{
	global $_SESSION;
	foreach ($_SESSION['UPLOADED_PICTURES'] as $k => $v)
	{
		echo '<tr>
			<td>
				<img src="' . UPLOAD_FOLDER . session_id() . '/' . $v . '" width="60" border="0">
			</td>
			<td width="46%">
				' . $v . '
			</td>
			<td align="center">
				<a href="?action=delete&img=' . $k . '"><IMG SRC="images/trash.gif" border="0"></a>
			</td>
			<td align="center">
				<a href="?action=makedefault&img=' . $v . '"><img src="images/' . (($v == $_SESSION['SELL_pict_url_temp']) ? 'selected.gif' : 'unselected.gif') . '" border="0"></a>
			</td>
		</tr>';
	}
}
?>