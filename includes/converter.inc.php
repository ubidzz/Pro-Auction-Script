<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/


if (!defined('InProAuctionScript')) exit('Access denied');

include INCLUDE_PATH . 'currencies.php';

function CurrenciesList()
{
	global $system, $DBPrefix, $db;

	$query = "SELECT * FROM " . $DBPrefix . "rates ORDER BY valuta ASC";
	$db->direct_query($query);
	$CURRENCIES = array();
	while ($row = $db->result())
	{
		$CURRENCIES[$row['symbol']] = $row['valuta'];
	}
	return $CURRENCIES;
}

function ConvertCurrency($FROM, $INTO, $AMOUNT)
{
	global $conversionarray;

	$data = array(
		'amount'	=> $AMOUNT,
		'from' 		=> $FROM,
		'to' 		=> $INTO
		);
	if ($FROM == $INTO) return $AMOUNT;

	$CURRENCIES = CurrenciesList();

	$rate = findconversionrate($FROM, $INTO);
	if ($rate == 0)
	{
		$conversion = googleconvert($AMOUNT, $FROM, $INTO);
		$conversionarray[1][] = array('from' => $FROM, 'to' => $INTO, 'rate' => $conversion);
		buildcache($conversionarray[1]);
		return $AMOUNT * $conversion;
	}
	else
	{
		return $AMOUNT * $rate;
	}
}

function buildcache($newaarray)
{
	$output_filename = INCLUDE_PATH . 'currencies.php';
	$output = "<?php\n";
	$output.= "\$conversionarray[] = '" . time() . "';\n";
	$output.= "\$conversionarray[] = array(\n";

	for ($i = 0; $i < count($newaarray); $i++)
	{
		$output .= "\t" . "array('from' => '" . $newaarray[$i]['from'] . "', 'to' => '" . $newaarray[$i]['to'] . "', 'rate' => '" . floatval($newaarray[$i]['rate']) . "')";
		if ($i < (count($newaarray) - 1))
		{
			$output .= ",\n";
		}
		else
		{
			$output .= "\n";
		}
	}

	$output .= ");\n?>\n";

	$handle = fopen($output_filename, 'w');
	fputs($handle, $output);
	fclose($handle);
}

function findconversionrate($FROM, $INTO)
{
	global $conversionarray;

	if (time() - (3600 * 24) < $conversionarray[0])
	{
		for ($i = 0; $i < count($conversionarray[1]); $i++)
		{
			if ($conversionarray[1][$i]['from'] == $FROM && $conversionarray[1][$i]['to'] == $INTO)
				return $conversionarray[1][$i]['rate'];
		}
	}
	else
	{
		$conversionarray = array(0, array());
	}
	return 0;
}

function googleconvert($amount, $fromCurrency , $toCurrency)
{
	//Call Google API
	$fromCurrency = urlencode($fromCurrency);
	$toCurrency = urlencode($toCurrency);
	$get = file_get_contents("https://finance.google.com/finance/converter?a=$amount&from=$fromCurrency&to=$toCurrency");
	$get = explode("<span class=bld>",$get);
	$get = explode("</span>",$get[1]);  
	$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);	
	return $converted_amount;
}
?>