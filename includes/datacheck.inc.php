<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');

function CheckFirstRegData()
{
	/*
	Checks the first data posted by the user
	in the registration process

	Return codes:   000 = data ok!
	002 = name missing
	003 = nick missing
	004 = password missing
	005 = second password missing
	006 = passwords do not match
	007 = email address missing
	008 = email address not valid
	009 = nick already exists
	010 = nick too short
	011 = password too short
	*/
	global $name, $nick, $password, $repeat_password, $email;
	if (!isset($name) || empty($name))
	{
		return '002';
	}
	if (!isset($nick) || empty($nick))
	{
		return '003';
	}
	if (!isset($password) || empty($password))
	{
		return '004';
	}
	if (!isset($repeat_password) || empty($repeat_password))
	{
		return '005';
	}
	if ($password != $repeat_password)
	{
		return '006';
	}
	if (!isset($email) || empty($email))
	{
		return '007';
	}
	if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $email))
	{
		return '008';
	}
	if (strlen($nick) < 6)
	{
		return '010';
	}
	if (strlen($password) < 6)
	{
		return '011';
	}
	$query = "SELECT nick FROM " . $DBPrefix . "users WHERE nick = '" . $nick . "'";
	$result = mysql_query($query);
	if (mysql_num_rows($result))
	{
		return '009';
	}
	return '000';
} //CheckFirstRegData()

function CheckSellData()
{
	/*
	return codes:
	017 = item title missing
	018 = item description missing
	019 = minimum bid missing
	020 = minimum bid not valid
	021 = reserve price missing
	022 = reserve price not valid
	023 = category missing
	024 = payment method missing
	025 = payment method missing
	060 = start time has already happened
	061 = buy now price inserted is not correct
	062 = may not set a reserve price in a Dutch Auction
	063 = may not use custom increments in a Dutch Auction
	064 =  may not use the Buy Now feature in a Dutch Auction
	600 = wrong auction type
	601 = wrong quantity of items
	25_0004 = No digital item was uploaded
	*/
	
	global $auctionData;
	global $category;
	global $system, $_SESSION;
	global $num, $nnum;

	if (empty($auctionData->title))
	{
		return '017';
	}

	if (empty($auctionData->description))
	{
		return '018';
	}

	if (!$system->CheckMoney($auctionData->minimum_bid) && $auctionData->buy_now_only == 'n')
	{
		return '058';
	}

	// format the info correctly
	$clean_minimum_bid = $system->input_money($auctionData->minimum_bid);
	$clean_reserve_price = $system->input_money($auctionData->reserve_price);
	$clean_buy_now_price = $system->input_money($auctionData->buy_now_price);
	if($auctionData->freeItime == 'sell' && ($auctionData->atype == 1 || $auctionData->atype == 2))
	{
		if ((empty($auctionData->minimum_bid) || floatval($clean_minimum_bid) <= 0) && ($auctionData->buy_now_only == 'n' || !$auctionData->buy_now_only))
		{
			return '019';
		}
	}
	
	if($auctionData->atype == 3 && !$auctionData->digital_item)
	{
		return '25_0004';
	}
	
	if (empty($auctionData->reserve_price) && $auctionData->with_reserve == 'yes' && $auctionData->buy_now_only == 'n' && $auctionData->freeItime == 'sell' && ($auctionData->atype == 1 || $auctionData->atype == 2))
	{
		return '021';
	}

	if ($auctionData->increments == 2 && (empty($auctionData->customincrement) || floatval($system->input_money($auctionData->customincrement)) == 0) && ($auctionData->atype == 1 || $auctionData->atype == 2))
	{
		return '056';
	}

	if (!(empty($auctionData->customincrement) || floatval($system->input_money($auctionData->customincrement)) == 0) && !$system->CheckMoney($auctionData->customincrement) && ($auctionData->atype == 1 || $auctionData->atype == 2))
	{
		return '057';
	}

	if ($auctionData->with_reserve == 'yes' && !$system->CheckMoney($auctionData->reserve_price) && ($auctionData->atype == 1 || $auctionData->atype == 2))
	{
		return '022';
	}
	
	if ($auctionData->buy_now_only == 'y')
	{
		$auctionData->buy_now = 'yes';
	}
	
	if ($auctionData->buy_now == 'yes' && (!$system->CheckMoney($auctionData->buy_now_price) || empty($auctionData->buy_now_price)  || floatval($clean_buy_now_price) == 0) && $auctionData->freeItime == 'sell')
	{
		return '061';
	}
	
	if($auctionData->freeItime == 'sell')
	{
		$numpay = count($auctionData->payment);
		if ($numpay == 0)
		{
			return '024';
		}
	}
	if (!isset($system->SETTINGS['auction_types'][intval($auctionData->atype)]))
	{
		return '600';
	}

	if (intval($auctionData->iquantity) < 1)
	{
		return '601';
	}

	if ($auctionData->atype == 2)
	{
		if ($auctionData->with_reserve == 'yes')
		{
			$auctionData->with_reserve = 'no';
			$auctionData->reserve_price = '';
			return '062';
		}
		if ($auctionData->increments == 2)
		{
			$auctionData->increments = 1;
			$auctionData->customincrement = '';
			return '063';
		}
		if ($auctionData->buy_now == 'yes')
		{
			$auctionData->buy_now = 'no';
			$auctionData->buy_now_price = '';
			return '064';
		}
	}

	if ($auctionData->with_reserve == 'yes' && $clean_reserve_price <= $clean_minimum_bid && ($auctionData->atype == 1 || $auctionData->atype == 2))
	{
		return '5045';
	}

	if ($auctionData->buy_now == 'yes' && $auctionData->buy_now_only == 'n' && $auctionData->freeItime == 'sell')
	{
		if (($auctionData->with_reserve == 'yes' && $clean_buy_now_price <= $clean_reserve_price) || $clean_buy_now_price <= $clean_minimum_bid)
		{
			return '5046';
		}
	}

	if ($system->SETTINGS['autorelist'] == 'y')
	{
		if (!empty($auctionData->relist) && !is_numeric($auctionData->relist))
		{
			return '714';
		}
		elseif ($auctionData->relist > $system->SETTINGS['autorelist_max'] && !empty($auctionData->relist))
		{
			return '715';
		}
	}

	if (!(strpos($auctionData->a_starts, '-') === false) && empty($auctionData->start_now) && $_SESSION['SELL_action'] != 'edit')
	{
		$auctionData->a_starts = _gmmktime(substr($auctionData->a_starts, 11, 2),
			substr($a_starts, 14, 2),
			substr($a_starts, 17, 2),
			substr($a_starts, 0, 2),
			substr($a_starts, 3, 2),
			substr($a_starts, 6, 4), 0);

		if ($auctionData->a_starts < $system->CTIME)
		{
			return '060';
		}
	}
}//--CheckSellData

function CheckBidData()
{
	global $bid, $next_bid, $atype, $qty, $Data, $bidder_id, $system;
	
	if ($Data['suspended'] > 0)
	{
		return '619';
	}
	
	if ($bidder_id == $Data['user'])
	{
		return '612';
	}
	
	if ($atype == 1) //normal auction
	{
		// have to use bccomp to check if bid is less than next_bid
		if (bccomp($bid, $next_bid, $system->SETTINGS['moneydecimals']) == -1)
		{
			return '607';
		}
		if ($qty > $Data['quantity'])
		{
			return '608';
		}
	}
	else //dutch auction
	{
		if (($qty == 0) || ($qty > $Data['quantity']))
		{
			return '608';
		}
	}
	
	return 0;
}
?>