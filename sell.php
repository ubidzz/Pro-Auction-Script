<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/

 

include 'common.php';



if (!$user->checkAuth())

{

	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'sell.php';

	header('location: user_login.php');

	exit;

}

include INCLUDE_PATH . 'auction/class_sell.php';

$auctionData = new AuctionSetup();



include INCLUDE_PATH . 'datacheck.inc.php';

include LANGUAGE_PATH . $language . '/categories.inc.php';

include PLUGIN_PATH . 'ckeditor/ckeditor.php';



$_SESSION['action'] = (!isset($_SESSION['action'])) ? 1 : $_SESSION['action'];

$_SESSION['action'] = (!isset($_POST['action'])) ? $_SESSION['action'] : $_POST['action'];



//categories class

$catscontrol = new MPTTcategories();



if (!isset($_SESSION['SELL_sellcat1']) || !is_numeric($_SESSION['SELL_sellcat1']))

{

	header('location: select_category.php');

	exit;

}

elseif (in_array($user->user_data['suspended'], array(5, 6, 7)))

{

	header('location: message.php');

	exit;

}

elseif (!$user->can_sell)

{

	$_SESSION['TMP_MSG'] = $MSG['818'];

	header('location: user_menu.php?cptab=selling');

	exit;

}



// set variables

$auctionData->buildVariables();



if (isset($_GET['mode']) && $_GET['mode'] == 'recall') $_SESSION['action'] = 1;



// category name

$category_string1 = $auctionData->get_category_string($auctionData->sellcat1);

$category_string2 = $auctionData->get_category_string($auctionData->sellcat2);



if($_SESSION['action'] == 4 && $system->SETTINGS['usersauth'] == 'y')

{

	$check = $phpass->CheckPassword($_POST['password'], $user->user_data['password']);

	if ($check == 0)

	{

		$ERROR = $ERR['026'];

		$_SESSION['action'] = 3;

	}

}





switch ($_SESSION['action'])

{

	case 4: // finalise auction (submit to db)

		if (isset($ERROR))

		{

			$_SESSION['action'] = 3;

		}

		else

		{

			$payment_text = implode(', ', $auctionData->payment);

			// set time back to GMT

			$a_starts = empty($auctionData->start_now) || $_SESSION['SELL_action'] == 'edit' ? date('U',$auctionData->a_starts) : $system->CTIME;			

			$auctionData->ends = $system->ConvertedAuctionDateTimeObject($a_starts, $auctionData->duration);

			if ($_SESSION['SELL_action'] == 'edit')

			{

				$auctionData->updateauction(1);

			}

			elseif ($_SESSION['SELL_action'] == 'relist')

			{

				$auctionData->remove_bids($auctionData->auction_id); // incase they've not already been removed

				$auctionData->updateauction(2);

			}

			else

			{

				// insert auction

				$auctionData->addauction();

				if($auctionData->auction_id == 0)

				{
					$_SESSION['action'] = 3;

					header('location: sell.php');

					exit;

				}

			}
			
			// get fee
			$feeArray = $auctionData->get_fee($auctionData->minimum_bid, false);
			$fee_data = $feeArray[1];
			$fee = $feeArray[0];

			$email_message = false;

			$addcounter = true;

			

			// work out & add fee

			if ($system->SETTINGS['fees'] == 'y')

			{

				$feeupdate = false;

				// attach the new invoice to users account

				$auctionData->addoutstanding($fee_data, $fee);



				// deal with the auction

				if ($system->SETTINGS['fee_type'] == 2 && $fee > 0)

				{

					$addcounter = false;

				}

				else

				{

					$query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee WHERE id = :user_id";

					$params = array(

						array(':fee', $fee, 'float'),

						array(':user_id', $user->user_data['id'], 'int')

					);

					$db->query($query, $params);

				}

			}

			if ($addcounter && isset($_SESSION['SELL_action']) && $_SESSION['SELL_action'] != 'edit')

			{

				$system->writesetting("counters", "auctions", $system->COUNTERS['auctions'] + 1, 'int');

			}

			elseif (!$addcounter && $_SESSION['SELL_action'] == 'edit')

			{

				$system->writesetting("counters", "auctions", $system->COUNTERS['auctions'] - 1, 'int');

			}


			if (!($system->SETTINGS['fees'] == 'y' && $system->SETTINGS['fee_type'] == 2 && $fee > 0) && isset($_SESSION['SELL_action']) && $_SESSION['SELL_action'] != 'edit')

			{

				// update recursive categories

				$auctionData->update_cat_counters(true, $auctionData->sellcat1);

				if (isset($auctionData->sellcat2) && !empty($auctionData->sellcat2))

				{

					$auctionData->update_cat_counters(true, $auctionData->sellcat2);

				}

			}



			if (!$addcounter && $_SESSION['SELL_action'] == 'edit')

			{

				// update recursive categories

				$auctionData->update_cat_counters(false, $auctionData->sellcat1);

				if (isset($auctionData->sellcat2) && !empty($auctionData->sellcat2))

				{

					$auctionData->update_cat_counters(false, $auctionData->sellcat2);

				}

			}

			$UPLOADED_PICTURES = $auctionData->uploaded_pictures;

			// remove old images if any

			if (is_dir(UPLOAD_PATH . 'auctions/' . $auctionData->auction_id))

			{

				if ($dir = opendir(UPLOAD_PATH . 'auctions/' . $auctionData->auction_id))

				{

					while (($file = readdir($dir)) !== false)

					{

						if (is_file(UPLOAD_PATH . 'auctions/' . $auctionData->auction_id . '/' . $file))

							unlink(UPLOAD_PATH . 'auctions/' . $auctionData->auction_id . '/' . $file);

					}

					closedir($dir);

					if(count($UPLOADED_PICTURES) == 1)

					{
						if(file_exists(UPLOAD_PATH . '/auctions/' . $auctionData->auction_id))
						{
							$files = glob(UPLOAD_PATH . '/auctions/' . $auctionData->auction_id . '/*');
							foreach($files as $file){ // iterate files
							  	if(is_file($file))
							    	unlink($file); // delete file
							}
							@rmdir(UPLOAD_PATH . '/auctions/' . $auctionData->auction_id); // delete session folder
						}
					}

				}

			}

			// Create pictures gallery if any

			if ($system->SETTINGS['picturesgallery'] == 1 && count($UPLOADED_PICTURES) > 0)

			{

				// Create dirctory

				umask();

				if (!is_dir(UPLOAD_PATH . '/auctions/' . $auctionData->auction_id))

				{

					mkdir(UPLOAD_PATH . '/auctions/' . $auctionData->auction_id, 0755);

				}

				// Copy files

				foreach ($UPLOADED_PICTURES as $k => $v)

				{

					$system->move_file(UPLOAD_PATH . 'temps/' . session_id() . '/' . $v, UPLOAD_PATH . '/auctions/' . $auctionData->auction_id . '/' . $v);

					chmod(UPLOAD_PATH . '/auctions/' . $auctionData->auction_id . '/' . $v, 0644);

				}

				if (!empty($pict_url))

				{

					$system->move_file(UPLOAD_PATH . 'temps/' . session_id() . '/' . $auctionData->pict_url, UPLOAD_PATH . '/auctions/' . $auctionData->auction_id . '/' . $auctionData->pict_url);

					chmod(UPLOAD_PATH . '/auctions/' . $auctionData->auction_id . '/' . $auctionData->pict_url, 0644);

				}

				// Delete files, using dir (to eliminate eventual odd files)

				if ($dir = opendir(UPLOAD_PATH . 'temps/' . session_id()))

				{

					while (($file = readdir($dir)) !== false)

					{

						if (!is_dir(UPLOAD_PATH . 'temps/' . session_id() . '/' . $file))

							unlink(UPLOAD_PATH . 'temps/' . session_id() . '/' . $file);

					}

					closedir($dir);

					rmdir(UPLOAD_PATH . 'temps/' . session_id());

				}

			}

			//digital item auctions settings
			$split = explode('.', $auctionData->digital_item);
			if ($system->SETTINGS['digital_auctions'] == 'y' && $auctionData->atype == 3)

			{															
					if(file_exists(UPLOAD_PATH . 'temps/' . session_id() . '/' . 'items/' . $split[0] . '.encrypted') !== false)
					{
						$auctionData->add_digital_item();
					}
	    	}	

	    	//delete the temp folder

	    	if (is_dir(UPLOAD_PATH . session_id())) rmdir(UPLOAD_PATH . session_id());



			if (!isset($_SESSION['SELL_action']) || empty($_SESSION['SELL_action']))

			{

				//send emails message

				$email_message = true;

				

				// Send notification if users keyword matches (Auction Watch)

				$query = "SELECT auc_watch, email, nick, name, id FROM " . $DBPrefix . "users WHERE auc_watch != '' AND id != :user_id";

				$params = array(

					array(':user_id', $user->user_data['id'], 'int')

				);

				$db->query($query, $params);

				$sent_to = array();

				while ($row = $db->result())

				{

					if (isset($match)) unset($match);

					$w_title = explode(' ', strtolower($auctionData->title));

					$w_descr = explode(' ', strtolower(str_replace(array('<br>', "\n"), '', strip_tags($auctionData->description))));

					$w_nick = strtolower($user->user_data['nick']);

					$key = explode(' ', $row['auc_watch']);

					if (is_array($key) && count($key) > 0)

					{

						foreach ($key as $k => $v)

						{

							$v = trim(strtolower($v));

							if ((in_array($v, $w_title) || in_array($v, $w_descr) || $v == $w_nick) && !in_array($row['id'], $sent_to))

							{

								$send_email->auction_watch($auctionData->auction_id, $auctionData->subtitle, $row['name'], $row['auc_watch'], $row['id'], $row['email']);

								$sent_to[] = $row['id'];

							}

						}

					}

				}

				if ($system->SETTINGS['fee_type'] == 1)

				{

					if ($user->user_data['startemailmode'] == 'yes')

					{

						$send_email->confirmation($auctionData->auction_id, $auctionData->title, $auctionData->atype, $auctionData->pict_url, $auctionData->minimum_bid, $auctionData->reserve_price, $auctionData->buy_now_price, $auctionData->ends);

					}

				}

				

				if ($system->SETTINGS['bn_only'] == 'y' && $system->SETTINGS['bn_only_disable'] == 'y' && $system->SETTINGS['bn_only_percent'] < 100)

				{

					$query = "SELECT COUNT(*) as count FROM " . $DBPrefix . "auctions

						 WHERE closed = 0 AND suspended = 0 AND user = :user_id";

					$params = array(

						array(':user_id', $user->user_data['id'], 'int')

					);

					$db->query($query, $params);

					$totalaucs = $db->result('count');

					if ($totalaucs > 0)

					{

						$query = "SELECT COUNT(*) as count FROM " . $DBPrefix . "auctions

							 WHERE closed = 0 AND suspended = 0 AND bn_only = 'y' AND user = :user_id";

						$params = array(

							array(':user_id', $user->user_data['id'], 'int')

						);

						$db->query($query, $params);

						$totalbnaucs = $db->result('count');

						$percent = ($totalbnaucs * 100) / $totalaucs;

						if ($user->user_data['bn_only'] == 'y' && $system->SETTINGS['bn_only_percent'] <= $percent)

						{

							$query = "UPDATE " . $DBPrefix . "users SET bn_only = 'n' WHERE id = :user_id";

							$params = array(

								array(':user_id', $user->user_data['id'], 'int')

							);

							$db->query($query, $params);

						}

						if ($user->user_data['bn_only'] == 'n' && $system->SETTINGS['bn_only_percent'] > $percent)

						{

							$query = "UPDATE " . $DBPrefix . "users SET bn_only = 'y' WHERE id = :user_id";

							$params = array(

								array(':user_id', $user->user_data['id'], 'int')

							);

							$db->query($query, $params);

						}

					}

				}

			}

			

			if (defined('TrackUserIPs'))

			{

				// log auction setup IP

				$system->log('user', 'List Item', $user->user_data['id'], $auctionData->auction_id);

			}

			if ($system->SETTINGS['fees'] == 'y' && $system->SETTINGS['fee_type'] == 2 && $fee > 0)

			{

				$_SESSION['auction_id'] = $auctionData->auction_id;

				header('location: pay.php?a=4');

				exit;

			}

			

			$query = "SELECT title FROM " . $DBPrefix . "auctions WHERE id = :auc_id";

			$params = array(

				array(':auc_id', $auctionData->auction_id, 'int')

			);

			$db->query($query, $params);

			$auc_title = $db->result('title');



			$template->assign_vars(array(

				'TITLE' => $MSG['028'],

				'PAGE' => 3,
				
				'ATYPE_PLAIN' => $auctionData->atype,

				'SEO_TITLE' =>  generate_seo_link($auc_title),

				'AUCTION_ID' => $auctionData->auction_id,

				'MESSAGE' => sprintf($MSG['102'], $auc_title, $system->ArrangeDateAndTime($auctionData->ends, false, true)),

				'B_EMAIL' => $email_message

			));

			$auctionData->unsetBuildSessions();

		}

	break;

	case 3: // confirm auction

		$noerror = true;

		if ($auctionData->with_reserve == 'no') $auctionData->reserve_price = 0;

		if ($auctionData->buy_now == 'no') $auctionData->buy_now_price = 0;

		// run the word filter

		if ($system->SETTINGS['wordsfilter'] == 'y')

		{

			$title = $system->filter($auctionData->title);

			$subtitle = $system->filter($auctionData->subtitle);

			$description = $system->filter($auctionData->description);

		}

		// check for errors

		if (count($auctionData->uploaded_pictures) > $system->SETTINGS['maxpictures'])

		{

			$ERROR = sprintf($MSG['674'], $system->SETTINGS['maxpictures']);

		}
		
		$checkErrors = CheckSellData() !='' ? CheckSellData() : false;
		if($checkErrors)
		{
			$ERROR = $ERR[$checkErrors];
		}

		if (isset($ERROR))

		{

			$_SESSION['action'] = 1;

			$noerror = false;

		}


		if ($noerror)

		{

			// payment methods

			$payment_methods = '';

			$gateways_data = $system->loadTable('gateways');

			$gateway_list = explode(',', $gateways_data['gateways']);

			foreach ($gateway_list as $v)

			{

				$v = strtolower($v);

				if ($gateways_data[$v . '_active'] == 1 && _in_array($v, $auctionData->payment))

				{

					$payment_methods .= '<p>' . $system->SETTINGS['gateways'][$v] . '</p>';

				}

			}



			$payment_options = unserialize($system->SETTINGS['payment_options']);

			foreach ($payment_options as $k => $v)

			{

				if (_in_array($k, $auctionData->payment))

				{

					$payment_methods .= '<p>' . $v . '</p>';

				}

			}

			

			$query = "SELECT description FROM " . $DBPrefix . "durations WHERE days = :duration";

			$params = array(

				array(':duration', $auctionData->duration, 'int')

			);

			$db->query($query, $params);

			$duration_desc = $db->result('description');

			// built gallery

			if ($system->SETTINGS['picturesgallery'] == 1 && isset($auctionData->uploaded_pictures) && count($auctionData->uploaded_pictures) > 0)

			{

				foreach ($auctionData->uploaded_pictures as $k => $v)

				{

					$template->assign_block_vars('gallery', array(

							'K' => $k,

							'IMAGE' => UPLOAD_FOLDER . 'temps/' . session_id() . '/' . $v

							));

				}

			}

			$di_items = '';

			if ($system->SETTINGS['digital_auctions'] == 'y')

			{

				//Checking to see if there is a main dir that was made

				if (is_dir(UPLOAD_PATH . 'items' . '/' . $security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_LOGGED_IN']) . '/' . $auctionData->auction_id))

				{

					// Check to see if a file name is stored in the SQL

					$query = "SELECT item FROM " . $DBPrefix . "digital_items WHERE auctions = :auction_id"; 

					$params = array(

						array(':auction_id', $auctionData->auction_id, 'int')

					);

					$db->query($query, $params);

 

					while ($diitem = $db->result('item'))  

					{ 

						$item_stored = $diitem;

					}

				}	

				

				//Checking to see if a file name is stored on the sql or if a file was uploaded or both

				//This sets the salts so that the file name get added to the sql if a file was uploaded or not

				if ((isset($item_stored)) && (empty($digital_item)))

    			{

		    		$di_items = $item_stored;    					

    				$auctionData->digital_item = $item_stored;

    			}

    			if ((empty($item_stored)) && (isset($auctionData->digital_item)))

    			{

    				$di_items = $auctionData->digital_item;

    			}

    			if ((isset($item_stored)) && (isset($auctionData->digital_item)))

    			{			

    				$di_items = $item_stored;

    			}

				if (isset($auctionData->digital_item))

				{

						$template->assign_block_vars('d_items', array(

							'ITEM' => sprintf($MSG['350_10166'], $auctionData->digital_item)								

						));

				}

			}

			$iquantity = ($auctionData->atype == 2 || $auctionData->buy_now_only == 'y') ? $auctionData->iquantity : 1;



			if (!(strpos($auctionData->a_starts, '-') === false))

			{

				$auctionData->a_starts = _gmmktime(substr($auctionData->a_starts, 11, 2),

					substr($auctionData->a_starts, 14, 2),

					substr($auctionData->a_starts, 17, 2),

					substr($auctionData->a_starts, 0, 2),

					substr($auctionData->a_starts, 3, 2),

					substr($auctionData->a_starts, 6, 4), 0);

			}



			$shippingtext = '';

			if ($auctionData->shipping == 1)

				$shippingtext = $MSG['033'];

			elseif ($auctionData->shipping == 2)

				$shippingtext = $MSG['032'];

			elseif ($auctionData->shipping == 3)

				$shippingtext = $MSG['867'];

			$feeArray = $auctionData->fee_amount();

			$template->assign_vars(array(

					'TITLE' => stripslashes($system->cleanvars($auctionData->title)),

					'SUBTITLE' => stripslashes($system->cleanvars($auctionData->subtitle)),

					'ERROR' => (isset($ERROR)) ? $ERROR : '',

					'PAGE' => 2,
					

					'MINTEXT' => ($auctionData->atype == 2) ? $MSG['038'] : $MSG['020'],

					'BOLD' => $auctionData->is_bold == 'y' ? $MSG['030'] : $MSG['029'],
					
					'FEATURED' => $auctionData->is_featured == 'y' ? $MSG['030'] : $MSG['029'],
					
					'HIGHLIGHTED' => $auctionData->is_highlighted == 'y' ? $MSG['030'] : $MSG['029'],
					
					'GOOGLEMAP' => $auctionData->google_map == 'y' ? $MSG['030'] : $MSG['029'],

					'AUC_DESCRIPTION' => stripslashes($auctionData->description),

					'MAINIMAGE' => (empty($auctionData->pict_url)) ? $MSG['114'] : '<img style="max-height:250px; max-width:250px" src="' . UPLOAD_FOLDER . 'temps/' . session_id() . '/' . $auctionData->pict_url . '" style="max-width:100%; max-height:100%;">',

					'MIN_BID' => $system->print_money($auctionData->minimum_bid, false),

					'RESERVE' => $system->print_money($auctionData->reserve_price, false),

					'BN_PRICE' => $system->print_money($auctionData->buy_now_price, false),

					'SHIPPING_COST' => $system->print_money($auctionData->shipping_cost, false),

					'ADDITIONAL_SHIPPING_COST' => $system->print_money($auctionData->additional_shipping_cost, false),

					'STARTDATE' => (empty($start_now)) ? $system->ArrangeDateAndTime($auctionData->a_starts, false, true) : $system->ArrangeDateAndTime($system->CTIME),

					'DURATION' => $auctionData->duration,

					'INCREMENTS' => ($auctionData->increments == 1) ? $MSG['614'] : $system->print_money($auctionData->customincrement, false),

					'ATYPE' => $system->SETTINGS['auction_types'][$auctionData->atype],

					'ATYPE_PLAIN' => $auctionData->atype,

					'SHIPPING' => $shippingtext,
					
					'RELIST' => $auctionData->relist,

					'INTERNATIONAL' => ($auctionData->international) ? $MSG['033'] : $MSG['043'],

					'SHIPPING_TERMS' => nl2br(stripslashes($auctionData->shipping_terms)),

					'SHIPPINGTERM_OPTIONS' => $system->SETTINGS['shipping_terms'],

					'SHIPPINGCONDITION_OPTIONS' => $system->SETTINGS['shipping_conditions'],

					'PAYMENTS_METHODS' => $payment_methods,

					'CAT_LIST1' => $category_string1,

					'CAT_LIST2' => $category_string2,

					'RETURNS' => ($auctionData->returns) ? $MSG['025_B'] : $MSG['025_D'],

					'FEE' => $system->print_money($auctionData->get_fee($auctionData->minimum_bid,true)),

					'FILE' => $di_items,

					'FREEITEM' => $auctionData->freeItime,

					'B_USERAUTH' => ($system->SETTINGS['usersauth'] == 'y'),

					'B_BN_ONLY' => (!($system->SETTINGS['buy_now'] == 2 && $auctionData->buy_now_only == 'y')),

					'B_BN' => ($system->SETTINGS['buy_now'] == 2),

					'B_GALLERY' => ($system->SETTINGS['picturesgallery'] == 1 && isset($auctionData->uploaded_pictures) && count($auctionData->uploaded_pictures) > 0),

					'B_CUSINC' => ($system->SETTINGS['cust_increment'] == 1),

					'B_FEES' => ($system->SETTINGS['fees'] == 'y'),

					'B_SUBTITLE' => ($system->SETTINGS['subtitle'] == 'y' && $auctionData->subtitle !=''),
					
					'B_MKFEATURED' => ($system->SETTINGS['ao_hpf_enabled'] == 'y' ? true : false),

					'B_MKBOLD' => ($system->SETTINGS['ao_bi_enabled'] == 'y' ? true : false),

					'B_MKHIGHLIGHT' => ($system->SETTINGS['ao_hi_enabled'] == 'y' ? true : false),
					
					'B_RELIST' => $auctionData->relist > 0 ? true : false,
					
					'ITEM_CONDITION'=> $auctionData->item_condition,

            		'ITEM_MANUFACTURER'=> stripslashes($auctionData->item_manufacturer),

            		'ITEM_MODEL'=>   stripslashes($auctionData->item_model),

            		'ITEM_COLOR'=> stripslashes($auctionData->item_color),

            		'ITEM_YEAR' =>  $auctionData->item_year

					));

			break;

		}

	case 1:  // enter auction details		

		// auction types

		if($system->SETTINGS['dutch_auctions'] == 'y')

		{

			if ($system->SETTINGS['auction_setup_types'] == 2 || $system->SETTINGS['auction_setup_types'] == 0) $freeMessage = $MSG['3500_1015751'];

			elseif($system->SETTINGS['auction_setup_types'] == 1) $freeMessage = $MSG['640'];

			$DutchMessage = 'data-content="' . $freeMessage . '" data-original-title="' . $MSG['257'] . '" data-trigger="hover"';

		}

		else

		{

			$DutchMessage = '';

		}

		$TPL_auction_type = '<select class="form-control" name="atype" id="atype" ' . $DutchMessage . '>' . "\n";

		foreach ($system->SETTINGS['auction_types'] as $key => $val)

		{

			$TPL_auction_type .= "\t" . '<option value="' . $key . '" ' . (($key == $auctionData->atype) ? 'selected="true"' : '') . '>' . $val . '</option>' . "\n";

		}

		$TPL_auction_type .= '</select>' . "\n";



		// duration

		$time_passed = ($_SESSION['SELL_action'] != 'edit') ? 0 : ($system->CTIME - $auctionData->a_starts) / (3600 * 24); // get time passed in days

		$query = "SELECT * FROM " . $DBPrefix . "durations WHERE days > :days ORDER BY days";

		$params = array(

			array(':days', floor($time_passed), 'int')

		);

		$db->query($query, $params);

		$TPL_durations_list = '<select class="form-control" name="duration">' . "\n";

		while ($row = $db->result())

		{

			$selected = ($row['days'] == $auctionData->duration) ? 'selected="true"' : '';

			$TPL_durations_list .= "\t" . '<option value="' . $row['days'] . '" ' . $selected . '>' . $row['description'] . '</option>' . "\n";

		}

		$TPL_durations_list .= '</select>' . "\n";

		

		// can seller charge tax

		$can_tax = false;

		if (!empty($user->user_data['country']))

		{

			$query = "SELECT id FROM " . $DBPrefix . "tax WHERE countries_seller LIKE :country";

			$params = array(

				array(':country', $user->user_data['country'], 'str')

			);

			$db->query($query, $params);

			if ($db->numrows() > 0)

			{

				$can_tax = true;

			}

		}



		// payments

		$payment_methods = '';

		$gateways_data = $system->loadTable('gateways');

		$gateway_list = explode(',', $gateways_data['gateways']);

		foreach ($gateway_list as $v)

		{

			if ($gateways_data[$v . '_active'] == 1 && $auctionData->check_gateway($v))

			{

				$v = strtolower($v);

				$checked = (_in_array($v, $auctionData->payment)) ? 'checked' : '';

				$payment_methods .= '<label class="checkbox"><input type="checkbox" name="payment[]" value="' . $v . '" ' . $checked . '>' . $system->SETTINGS['gateways'][$v] . '</label>';

			}

		}



		$payment_options = unserialize($system->SETTINGS['payment_options']);

		foreach ($payment_options as $k => $v)

		{

			$checked = (_in_array($k, $auctionData->payment)) ? 'checked' : '';

			$payment_methods .= '<label class="checkbox"><input type="checkbox" name="payment[]" value="' . $k . '" ' . $checked . '>' . $v . '</label>';

		}



		// make hour

		if ($system->SETTINGS['datesformat'] == 'USA')

		{

			$gmdate_string = 'm-d-Y H:i:s';

		}

		else

		{

			$gmdate_string = 'd-m-Y H:i:s';

		}

		if ($_SESSION['SELL_action'] != 'edit')

		{

			if (empty($auctionData->a_starts))

			{

				$TPL_start_date = date($gmdate_string, $system->CTIME);

			}

			else

			{
				$TPL_start_date = $auctionData->a_starts;
			}
		}

		else

		{

			$TPL_start_date = $auctionData->a_starts;

		}



		$CKEditor = new CKEditor();

		$CKEditor->basePath = $system->SETTINGS['siteurl'] . 'includes/plugins/ckeditor/';

		$CKEditor->returnOutput = true;

		$CKEditor->config['width'] = '100%';

		$CKEditor->config['height'] = 200;



		// build the fees javascript

		$fees = array( //0 = single value, 1 = staged fees

			'setup' => 1,

			'hpfeat_fee' => 0,

			'bolditem_fee' => 0,

			'hlitem_fee' => 0,

			'rp_fee' => 0,

			'picture_fee' => 0,

			'buyout_fee' => 0,

			'subtitle_fee' => 0,

			'relist_fee' => 0,

			'geomap_fee' => 0

			);

		$feevarsset = array();

		$fee_javascript = '';

		$relist_fee = $subtitle_fee = $fee_rp = $fee_bn = $fee_min_bid = $geomap_fee = 0;

		$query = "SELECT * FROM " . $DBPrefix . "fees ORDER BY type, fee_from ASC";

		$db->direct_query($query);

		while ($row = $db->result())

		{

			$fees_values = !$user->no_fees ? $row['value'] : '0.00';

			if(!$user->no_fees)

			{

				if (isset($fees[$row['type']]) && $fees[$row['type']] == 0)

					$fee_javascript .= 'var ' . $row['type'] . ' = ' . $fees_values . ';' . "\n";

				if (isset($fees[$row['type']]) && $fees[$row['type']] == 1)

				{

					if (!isset($feevarsset[$row['type']]))

					{

						$fee_javascript .= 'var ' . $row['type'] . ' = new Array();' . "\n";

						$feevarsset[$row['type']] = 0;

					}

					$fee_javascript .= $row['type'] . '[' . $feevarsset[$row['type']] . '] = new Array();' . "\n";

					$fee_javascript .= $row['type'] . '[' . $feevarsset[$row['type']] . '][0] = ' . $row['fee_from'] . ';' . "\n";

					$fee_javascript .= $row['type'] . '[' . $feevarsset[$row['type']] . '][1] = ' . $row['fee_to'] . ';' . "\n";

					$fee_javascript .= $row['type'] . '[' . $feevarsset[$row['type']] . '][2] = ' . $fees_values . ';' . "\n";

					$fee_javascript .= $row['type'] . '[' . $feevarsset[$row['type']] . '][3] = \'' . $row['fee_type'] . '\';' . "\n";

					$feevarsset[$row['type']]++;

				}

				if ($auctionData->minimum_bid >= $row['fee_from'] && $auctionData->minimum_bid <= $row['fee_to'] && $row['type'] == 'setup' && !$user->no_setup_fee)

				{

					if ($row['fee_type'] == 'flat')

					{

						$fee_min_bid = $row['value'];

					}

					else

					{

						$fee_min_bid = ($row['value'] / 100) * $auctionData->minimum_bid;

					}

				}

				if ($row['type'] == 'buyout_fee' && $auctionData->buy_now_price > 0 && !$user->no_buyout_fee)

				{

					$fee_bn = $row['value'];

				}

				if ($row['type'] == 'rp_fee' && $auctionData->reserve_price > 0 && !$user->no_rp_fee)

				{

					$fee_rp = $row['value'];

				}

				if ($row['type'] == 'subtitle_fee' && strlen($auctionData->subtitle) > 0 && !$user->no_subtitle_fee)

				{

					$subtitle_fee = $row['value'];

				}

				if ($row['type'] == 'relist_fee' && strlen($auctionData->relist) > 0 && !$user->no_relist_fee)

				{

					$relist_fee = $row['value'];

				}

				if ($row['type'] == 'geomap_fee' && strlen($auctionData->google_map) > 0 && !$user->no_geomap_fee)

				{

					$geomap_fee = $row['value'];

				}

			}

		}

		$fee_javascript .= 'var current_fee = ' . ((isset($_SESSION['SELL_current_fee'])) ? $_SESSION['SELL_current_fee'] : '0') . ';';

		$relist_options = '<select class="form-control" id="relist" data-content="' . $MSG['_0162'] . '" data-original-title="' . $MSG['_0161'] . '" data-trigger="hover" name="autorelist" id="autorelist">';

		for ($i = 0; $i <= $system->SETTINGS['autorelist_max']; $i++)

		{

			$relist_options .= '<option value="' . $i . '"' . (($auctionData->relist == $i) ? ' selected="selected"' : '') . '>' . $i . '</option>';

		}

		$relist_options .= '</select>';

		

		$query = "SELECT item_condition FROM " . $DBPrefix . "conditions ";

		$db->direct_query($query);

		$TPL_item_condition_list = '<select class="form-control" data-content="' . $MSG['1047'] . '" id="item_condition" data-original-title="' . $MSG['104400'] . '" data-trigger="hover" name="item_condition"><option value=""></option>' . "\n";

		while ($condition = $db->result())

		{

			$selected = ($condition['item_condition'] == $auctionData->item_condition) ? 'selected="true"' : '';

			$TPL_item_condition_list .= "\t" . '<option value="' . $condition['item_condition'] . '" ' . $selected . '>' . $condition['item_condition'] . '</option>' . "\n";

		}

		$TPL_item_condition_list .= '</select>' . "\n";

		

		$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = :fee";

		$params = array(

			array(':fee', 'picture_fee', 'str')

		);

		$db->query($query, $params);

		$pictureFees = $db->result('value');

		

		$mimeArray = unserialize($system->SETTINGS['allowed_image_mime']);

		$mimeType = '';

		foreach($mimeArray as $k => $v)

		{

			if(end($mimeArray) == $v) {

				$mimeType .= $v;

			}else{

				$mimeType .= $v . ', ';

			}

		}

		if($system->SETTINGS['digital_auctions'] == 'y')
		{
			$query = "SELECT file_extension FROM " . $DBPrefix . "digital_item_mime WHERE use_mime = 'y'";

			$db->direct_query($query);
			
			$allowtype = '';
			
			while ($row = $db->result())
			
			{
			
				$allowtype .= $row['file_extension'] . ', ';
			
			}
			
			$max_size = formatSizeUnits($system->SETTINGS['digital_item_size']); 
			
			
			
			if (is_dir(UPLOAD_PATH . 'items' . '/' . $user->user_data['id'] . '/' . $auctionData->auction_id))
			
			{
			
				// Check to see if a upload file is stored in the SQL
			
				$query = "SELECT item FROM " . $DBPrefix . "digital_items WHERE auctions = :auct_id AND seller = :seller_id"; 
			
				$params = array(
			
					array(':auct_id', $_SESSION['SELL_auction_id'], 'int'),
			
					array(':seller_id', $security->decrypt($_SESSION[$system->SETTINGS['sessionsname'] . '_LOGGED_IN']), 'int')
			
				);
			
				$db->query($query, $params);
			
				if($db->numrows() > 0)
			
				{
			
					$di_items = true;
			
					$diitem = $db->result();
			
				}
			
			}

			$template->assign_vars(array(
				'STORED' => (isset($di_items)) ? $diitem['item'] :'',
			
				'FILE_UPLOADED' => (isset($_SESSION['SELL_upload_file'])) ? $_SESSION['SELL_upload_file'] : '',
			
				'SIZE' => sprintf($MSG['350_10176'], $max_size),
						
				'TYPES' => sprintf($MSG['350_10175'], $allowtype),
			
				'THEME' => $system->SETTINGS['theme'],

			));
		}

		$template->assign_vars(array(

				'TITLE' => $MSG['028'],

				'MAXPICS' => sprintf($MSG['673'], $system->SETTINGS['maxpictures'], formatSizeUnits($system->SETTINGS['maxuploadsize'])),

				'FREEMAXPIC' => $pictureFees > 0 ? sprintf($MSG['3500_1015761'], $system->SETTINGS['freemaxpictures'], $system->SETTINGS['freemaxpictures'], $system->print_money($pictureFees)) : '',

				'ERROR' => (isset($ERROR)) ? $ERROR : '',

				'CAT_LIST1' => $category_string1,

				'CAT_LIST2' => $category_string2,

				'ATYPE' => $TPL_auction_type,

				'ATYPE_PLAIN' => $auctionData->atype,

				'CURRENCY' => $system->SETTINGS['currency'],

				'DURATIONS' => $TPL_durations_list,

				'PAYMENTS' => $payment_methods,

				'PAGE' => 0,

				'MINTEXT' => ($auctionData->atype == 2) ? $MSG['038'] : $MSG['020'],

				'FEE_JS' => $fee_javascript,

				// auction details

				'AUC_TITLE' => htmlentities($system->uncleanvars(stripslashes($auctionData->title)), ENT_COMPAT, $CHARSET),

				'AUC_SUBTITLE' => htmlentities($system->uncleanvars(stripslashes($auctionData->subtitle)), ENT_COMPAT, $CHARSET),

				'AUC_DESCRIPTION' => $CKEditor->editor('itemDescription', stripslashes($auctionData->description)),

				'ITEMQTY' => $auctionData->iquantity,

				'MIN_BID' => $system->print_money_nosymbol($auctionData->minimum_bid, false),

				'BN_ONLY' => ($auctionData->buy_now_only == 'y' || !$auctionData->with_reserve) ? 'disabled' : '',

				'SHIPPING_COST' => $system->print_money_nosymbol($auctionData->shipping_cost, false),

				'ADDITIONAL_SHIPPING_COST' => $system->print_money_nosymbol($auctionData->additional_shipping_cost, false),

				'RESERVE_Y' => ($auctionData->with_reserve == 'yes') ? 'checked' : '',

				'RESERVE_N' => ($auctionData->with_reserve == 'yes') ? '' : 'checked',

				'RESERVE' => $system->print_money_nosymbol($auctionData->reserve_price, false),

				'START_TIME' => $system->ArrangeDateAndTime($TPL_start_date, false, false, '-'),

				'BN_ONLY_Y' => ($auctionData->buy_now_only == 'y' || $auctionData->atype == 3) ? 'checked' : '',

				'BID_PRICE' => ($auctionData->buy_now_only == 'y' || $auctionData->atype == 3 || $auctionData->atype == 2) ? 'disabled' : '',

				'BN_ONLY_N' => ($auctionData->buy_now_only == 'y') ? '' : 'checked',

				'BN_Y' => ($auctionData->buy_now == 'yes' || $auctionData->atype == 3 || $auctionData->freeItime == 'free') ? 'checked' : '',

				'BN' => ($auctionData->buy_now_only == 'y' || $auctionData->buy_now == 'yes' || $auctionData->atype == 3) ? '' : 'disabled',

				'BN_N' => ($auctionData->buy_now == 'yes') ? '' : 'checked',

				'BN_PRICE' => $system->print_money_nosymbol($auctionData->buy_now_price, false),

				'INCREMENTS1' => ($auctionData->increments == 1 || empty($auctionData->increments)) ? 'checked' : '',

				'INCREMENTS2' => ($auctionData->increments == 2) ? 'checked' : '',

				'INCREMENTS3' => ($auctionData->increments == 2) ? '' : 'disabled',

				'CUSTOM_INC' => ($auctionData->customincrement > 0) ? $system->print_money_nosymbol($auctionData->customincrement, false) : '',

				'SHIPPING1' => (intval($auctionData->shipping) == 1) ? 'checked' : '',

				'SHIPPING2' => (intval($auctionData->shipping) == 2 || empty($auctionData->shipping)) ? 'checked' : '',

				'SHIPPING3' => (intval($auctionData->shipping) == 3) ? 'checked' : '',

				'INTERNATIONAL' => (!empty($auctionData->international)) ? 'checked' : '',

				'RETURNS' => (intval($auctionData->returns == 1)) ? 'checked' : '',

				'SHIPPING_TERMS' => $auctionData->shipping_terms,

				'SHIPPINGTERM_OPTIONS' => $system->SETTINGS['shipping_terms'],

				'SHIPPINGCONDITION_OPTIONS' => $system->SETTINGS['shipping_conditions'],

				'ITEMQTYD' => ($auctionData->atype == 2 || $auctionData->buy_now_only == 'y' || $auctionData->atype == 3) ? '' : 'disabled',

				'DIGITAL_ITEM' => ($auctionData->atype == 3 || $auctionData->buy_now_only == 'y') ? '' : 'style="display:none"',

				'START_NOW' => (!empty($auctionData->start_now)) ? 'checked' : '',

				'IS_BOLD' => ($auctionData->is_bold == 'y') ? 'checked' : '',

				'IS_HIGHLIGHTED' => ($auctionData->is_highlighted == 'y') ? 'checked' : '',

				'IS_FEATURED' => ($auctionData->is_featured == 'y') ? 'checked' : '',

				'NUMIMAGES' => count($auctionData->uploaded_pictures),

				'RELIST' => $relist_options,

				'MAXRELIST' => $system->SETTINGS['autorelist_max'],

				'FREEITEM' => $auctionData->freeItime,

				'FREEITEM_Y' => ($auctionData->freeItime == 'free') ? 'checked="checked"' : '',

				'FREEITEM_N' => ($auctionData->freeItime == 'sell') ? 'checked="checked"' : '',

				'TAX_Y' => (intval($auctionData->is_taxed) == 'y') ? 'checked' : '',

				'TAX_N' => (intval($auctionData->is_taxed) == 'n' || empty($auctionData->is_taxed)) ? 'checked' : '',

				'TAXINC_Y' => (intval($auctionData->tax_included) == 'y' || empty($auctionData->tax_included)) ? 'checked' : '',

				'TAXINC_N' => (intval($auctionData->tax_included) == 'n') ? 'checked' : '',

				'MAXPICS' => sprintf($MSG['673'], $system->SETTINGS['maxpictures'], formatSizeUnits($system->SETTINGS['maxuploadsize'])),

        		'DATES_FORMAT' =>  $system->SETTINGS['datesformat'] == 'USA' ? 'mm-dd-yyyy hh:ii:ss' : 'dd-mm-yyyy hh:ii:ss',

				'COUNTRY' => $user->user_data['country'],

				'ZIP' => $user->user_data['zip'],

				'MAPKEY' => isset($system->SETTINGS['googleMapKey']) ? $system->SETTINGS['googleMapKey'] : '',

				'FEE_VALUE' => $auctionData->get_fee($auctionData->minimum_bid),

				'FEE_VALUE_F' => number_format($auctionData->get_fee($auctionData->minimum_bid), $system->SETTINGS['moneydecimals']),

				'FEE_MIN_BID' => $fee_min_bid,

				'FEE_BN' => $fee_bn,

				'FEE_RP' => $fee_rp,

				'FEE_SUBTITLE' => $subtitle_fee,

				'FEE_RELIST' => $relist_fee,

				'FEE_DECIMALS' => $system->SETTINGS['moneydecimals'],

				'B_CAN_TAX' => $can_tax,

				'B_GALLERY' => ($system->SETTINGS['picturesgallery'] == 1 ? true : false),

				'B_BN_ONLY' => ($system->SETTINGS['buy_now'] == 2 && $system->SETTINGS['bn_only'] == 'y' && (($system->SETTINGS['bn_only_disable'] == 'y' && $user->user_data['bn_only'] == 'y') || $system->SETTINGS['bn_only_disable'] == 'n') ? true : false),

				'B_BN' => ($system->SETTINGS['buy_now'] == 2 ? true : false),

				'B_EDITING' => ($_SESSION['SELL_action'] == 'edit'),

				// options,

				'B_CUSINC' => ($system->SETTINGS['cust_increment'] == 1 ? true : false),

				'B_EDIT_STARTTIME' => ($system->SETTINGS['edit_starttime'] == 1 ? true : false),

				'B_MKFEATURED' => ($system->SETTINGS['ao_hpf_enabled'] == 'y' ? true : false),

				'B_MKBOLD' => ($system->SETTINGS['ao_bi_enabled'] == 'y' ? true : false),

				'B_MKHIGHLIGHT' => ($system->SETTINGS['ao_hi_enabled'] == 'y' ? true : false),

				'B_FEES' => ($system->SETTINGS['fees'] == 'y' ? true : false),

				'B_SUBTITLE' => ($system->SETTINGS['subtitle'] == 'y' ? true : false),

				'B_AUTORELIST' => ($system->SETTINGS['autorelist'] == 'y' ? true : false),

				'B_FREEITEM' => ($system->SETTINGS['auction_setup_types'] == 2 ? true : false),

				'B_SELL_DI' => ($system->SETTINGS['digital_auctions'] == 'y' ? true : false),

				'ALLOWEDPICTURETYPES' => sprintf($MSG['3500_1015896'], $mimeType),

				));

		break;

}



include 'header.php';

$template->set_filenames(array(

		'body' => 'sell.tpl'

		));

$template->display('body');

include 'footer.php';