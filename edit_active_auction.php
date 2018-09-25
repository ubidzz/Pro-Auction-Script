<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/



include 'common.php';



$NOW = $system->CTIME;



// Is the seller logged in?

if (!$user->logged_in)

{

	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'select_category.php';

	header('location: user_login.php');

	exit;

}

$auctionsID = isset($_GET['id']) ? intval($_GET['id']) : 0;



$query = "SELECT id FROM " . $DBPrefix . "bids WHERE auction = :id";

$params = array(

	array(':id', $auctionsID, 'int')

);

$db->query($query, $params);

if ($db->numrows() > 0) 

{

	header('location: home');

	exit;

}



if (!isset($_POST['action'])) // already closed auctions

{

	// Get Closed auctions data

	unset($_SESSION['UPLOADED_PICTURES']);

	$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE id = :id AND user = :user_id";

	$params = array(

		array(':id', $auctionsID, 'int'),

		array(':user_id', $user->user_data['id'], 'int')

	);

	$db->query($query, $params);

	

	$data = $db->result();



	$difference = $data['ends'] - $NOW;



	if ($user->user_data['id'] == $data['user'] && $difference > 0)

	{

		$_SESSION['SELL_auction_id']	= $data['id'];

		$_SESSION['SELL_starts']		= $data['starts'];
		
		$_SESSION['SELL_starts_now']		= $data['starts'];

		$_SESSION['SELL_ends']			= $data['ends'];

		$_SESSION['SELL_title']			= $data['title'];

		$_SESSION['SELL_subtitle']		= $data['subtitle'];

		$_SESSION['SELL_description']	= $data['description'];

		$_SESSION['SELL_atype']			= $data['auction_type'];

		$_SESSION['SELL_buy_now_only']	= $data['bn_only'];

		$_SESSION['SELL_suspended']		= $data['suspended'];

		$_SESSION['SELL_iquantity']		= $data['quantity'];

		$_SESSION['SELL_is_bold']			= $data['bold'];

		$_SESSION['SELL_is_highlighted']	= $data['highlighted'];

		$_SESSION['SELL_is_featured']		= $data['featured'];

		$_SESSION['SELL_is_taxed']			= $data['tax'];

		$_SESSION['SELL_tax_included']		= $data['taxinc'];

		$_SESSION['SELL_current_fee']		= $data['current_fee'];

		$_SESSION['SELL_item_condition']		= $data['item_condition'];

		$_SESSION['SELL_item_manufacturer']		= $data['item_manufacturer'];

		$_SESSION['SELL_item_model']		= $data['item_model'];

		$_SESSION['SELL_item_color']		= $data['item_color'];

		$_SESSION['SELL_item_year']		= $data['item_year'];

		$_SESSION['SELL_returns']		= $data['returns'];

		$_SESSION['SELL_sell_type']		= $data['sell_type'];

		$_SESSION['SELL_googleMap']		= $data['locationMap'];
		

		if ($data['bn_only'] == 'n')

		{

			$_SESSION['SELL_minimum_bid'] = $system->print_money_nosymbol($data['minimum_bid']);

		}

		else

		{

			$_SESSION['SELL_minimum_bid'] = 0;

		}



		if (floatval($data['reserve_price']) > 0)

		{

			$_SESSION['SELL_reserve_price'] = $system->print_money_nosymbol($data['reserve_price']);

			$_SESSION['SELL_with_reserve'] 	= 'yes';

		}

		else

		{

			$_SESSION['SELL_reserve_price'] = '';

			$_SESSION['SELL_with_reserve'] 	= 'no';

		}



		$_SESSION['SELL_sellcat1']	= $data['category'];

		$_SESSION['SELL_sellcat2']	= $data['secondcat'];



		if (floatval($data['buy_now']) > 0)

		{

			$_SESSION['SELL_buy_now_price'] = $system->print_money_nosymbol($data['buy_now']);

			$_SESSION['SELL_with_buy_now']	= 'yes';

		}

		else

		{

			$_SESSION['SELL_buy_now_price'] = '';

			$_SESSION['SELL_with_buy_now'] 	= 'no';

		}

		$_SESSION['SELL_duration']	= $data['duration'];

		$_SESSION['SELL_relist']	= $data['relist'];

		if (floatval($data['increment']) > 0)

		{

			$_SESSION['SELL_increments']			= 2;

			$_SESSION['SELL_customincrement']	= $system->print_money_nosymbol($data['increment']);

		}

		else

		{

			$_SESSION['SELL_increment']			= 1;

			$_SESSION['SELL_customincrement']	= 0;

		}

		$_SESSION['SELL_shipping_cost']	 = $system->print_money_nosymbol($data['shipping_cost']);

		$_SESSION['SELL_additional_shipping_cost']	= $system->print_money_nosymbol($data['shipping_cost_additional']);

		$_SESSION['SELL_shipping']		 = $data['shipping'];

		$_SESSION['SELL_shipping_terms'] = $data['shipping_terms'];

		$_SESSION['SELL_payment']		 = explode(', ', $data['payment']);

		$_SESSION['SELL_international']	 = $data['international'];

		$_SESSION['SELL_file_uploaded']	 = $data['photo_uploaded'];

		$_SESSION['SELL_pict_url']		 = $data['pict_url'];

		$_SESSION['SELL_pict_url_temp']	 = str_replace('thumb-', '', $data['pict_url']);



		// get gallery images

		$UPLOADED_PICTURES = array();

		$file_types = array('gif', 'jpg', 'jpeg', 'png');

		if (is_dir(UPLOAD_PATH . 'auctions/' . $auctionsID))

		{

			$dir = opendir(UPLOAD_PATH . 'auctions/' . $auctionsID);

			while (($myfile = readdir($dir)) !== false)

			{

				if ($myfile != '.' && $myfile != '..' && !is_file($myfile))

				{

					$file_ext = strtolower(substr($myfile, strrpos($myfile, '.') + 1));

					if (in_array($file_ext, $file_types) && (strstr($data['pict_url'], 'thumb-') === false || $data['pict_url'] != $myfile))

					{

						$UPLOADED_PICTURES[] = $myfile;

					}

				}

			}

			closedir($dir);

		}

		$_SESSION['UPLOADED_PICTURES'] = $UPLOADED_PICTURES;



		if (count($UPLOADED_PICTURES) > 0)

		{

			if (!file_exists(UPLOAD_PATH . 'temps/' . session_id()))

			{

				umask();

				mkdir(UPLOAD_PATH . 'temps/' . session_id(), 0755);

			}

			foreach ($UPLOADED_PICTURES as $k => $v)

			{

				$system->move_file(UPLOAD_PATH . 'auctions/' . $auctionsID . '/' . $v, UPLOAD_PATH . 'temps/' . session_id() . '/' . $v, false);

			}

			if (!empty($data['pict_url']))

			{

				$system->move_file(UPLOAD_PATH . 'auctions/' . $auctionsID . '/' . $data['pict_url'], UPLOAD_PATH . 'temps/' . session_id() . '/' . $data['pict_url'], false);

			}

		}

		

		//checking to see if it is a digital item auction

		$query = "SELECT item FROM " . $DBPrefix . "digital_items WHERE auctions = :id AND seller = :user_id";

		$params = array(

			array(':id', $data['id'], 'int'),

			array(':user_id', $user->user_data['id'], 'int')

		);

		$db->query($query, $params);

		if($db->numrows() == 1 && $data['auction_type'] == 3)

		{	

			$digital_item = $db->result('item');

			$_SESSION['SELL_upload_file'] = $digital_item;

			//make the temp folder

			if (!file_exists(UPLOAD_PATH . 'temps/' . session_id() . '/items'))

			{

				umask();

				mkdir(UPLOAD_PATH . 'temps/' . session_id() . '/items', 0755);

			}

			//copy the digital item to the temp folder

			$system->move_file(UPLOAD_PATH . 'items/' . $user->user_data['id'] . '/' . intval($data['id']) . '/' . $digital_item, UPLOAD_PATH . 'temps/' . session_id() . '/items/' . $digital_item, false);

		}

		

		$_SESSION['SELL_action'] = 'edit';

		if ($_SESSION['SELL_starts'] > $NOW)

		{

			$_SESSION['editstartdate'] = true;

		}

		else

		{

			$_SESSION['editstartdate'] = false;

		}

		sleep(1);

		header('location: sell.php?mode=recall');

	}

	else

	{

		header('location: home');

	}

}

