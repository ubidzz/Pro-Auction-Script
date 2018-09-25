<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/



include 'common.php';

include INCLUDE_PATH . 'membertypes.inc.php';



// Get parameters from the URL

foreach ($membertypes as $idm => $memtypearr)

{

	$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;

}

ksort($memtypesarr, SORT_NUMERIC);



$get_name = $_REQUEST['id'] ;  //NEW get the full product name

$get_array = explode('-',htmlentities($system->uncleanvars($get_name), ENT_COMPAT, $CHARSET)) ;  //NEW split the product name into segments and put into an array (product id must be separated by '-' )

$get_id = end($get_array) ; //NEW extract the last array i.e product id form full product name

$id = (isset($_SESSION['CURRENT_ITEM'])) ? intval($_SESSION['CURRENT_ITEM']) : 0;

$id = (isset($get_id)) ? intval($get_id) : 0; if (!is_numeric($id)) $id = 0;

$bidderarray = array();

$bidderarraynum = 1;

$catscontrol = new MPTTcategories();



$_SESSION['CURRENT_ITEM'] = $id;



// get auction all needed data

$query = "SELECT a.*, ac.counter, u.city, u.nick, u.reg_date, u.country, u.zip 

FROM " . $DBPrefix . "auctions a

LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)

LEFT JOIN " . $DBPrefix . "auccounter ac ON (ac.auction_id = a.id)

WHERE a.id = :auction_id LIMIT 1";

$params = array(

	array(':auction_id', $id, 'int')

);

$db->query($query, $params);

if ($db->numrows() == 0)

{

	$_SESSION['msg_title'] = $ERR['622'];

	$_SESSION['msg_body'] = $ERR['623'];

	header('location: ' . $system->SETTINGS['siteurl'] . 'message.php');

	exit;

}

$auction_data = $db->fetch();

$category = $auction_data['category'];

$auction_type = $auction_data['auction_type'];

$ends = $auction_data['ends'];

$start = $auction_data['starts'];

$user_id = $auction_data['user'];

$minimum_bid = $auction_data['minimum_bid'];

$high_bid = $auction_data['current_bid'];

$customincrement = $auction_data['increment'];

$seller_reg = $system->dateToTimestamp($auction_data['reg_date'], '/');

$item_condition = $auction_data['item_condition'];

$item_manufacturer = $auction_data['item_manufacturer'];

$item_model = $auction_data['item_model'];

$item_color = $auction_data['item_color'];

$item_year = $auction_data['item_year'];

$titel = $auction_data['title'];

$description = $auction_data['description'];

$city = $auction_data['city'];

$page_title = $titel;

$_SESSION['REDIRECT_AFTER_LOGIN'] = 'products/' . generate_seo_link($titel) . '-' . $id;



$query = "SELECT avatar FROM " . $DBPrefix . "users WHERE id = :id";

$params = array(

	array(':id', $user_id, 'int')

);	

$db->query($query, $params);

$TPL_avatar = $db->result('avatar');



if(isset($_GET['getbid']))

{

	$high_bid = $system->print_money($high_bid);

}



function is_fave($seller)

{

	global $DBPrefix, $user, $db;

	

	$sql = "SELECT id FROM " . $DBPrefix . "favesellers WHERE user_id = :user_id AND seller_id = :seller_id";

	$params = array(

		array(':user_id', $user->user_data['id'], 'int'),

		array(':seller_id', $seller, 'int')

	);

	$db->query($sql, $params);

	if($db->numrows('id') > 0)

	{

		return false;

	}

	else

	{

		return true;

	}

}



function add_fave($seller)

{

	global $user, $DBPrefix, $MSG, $db;



	$query = "INSERT INTO " . $DBPrefix . "favesellers VALUES (NULL, :user_id, :seller_id);";

	$params = array(

		array(':user_id', $user->user_data['id'], 'int'),	

		array(':seller_id', $seller, 'int')

	);

	$db->query($query, $params);

	if($db->lastInsertId() > 0)

	{

		return '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-info-sign"></span> ' . $MSG['FSM4'] . '</div>';

	}

	else

	{

		return '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign"></span> ' . $MSG['FSM8'] . '</div>';

	}

}

if(isset($_POST['faveseller']) && $_POST['faveseller'] == 'yes')

{

	if ($user->logged_in)

	{

		if(is_fave($user_id))

		{

			$fsm = add_fave($user_id);

		}

	}

}

else

{

	if ($user->logged_in)

	{

		if (is_fave($user_id))

		{

			$faveset = 1;

		}

		else

		{

			$fsm = '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-info-sign"></span> ' . $MSG['FSM3'] . '</div>';

		}

	}

	else

	{

		$fsm = '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' . $MSG['FSM2'] . '</div>';

	}

}



// sort out counter

if (empty($auction_data['counter']))

{

	$query = "INSERT INTO `" . $DBPrefix . "auccounter` (`auction_id`, `counter`) VALUES (:counter, :limit)";

	$params = array(

		array(':counter', $id, 'int'),

		array(':limit', 1, 'int')

	);

	$db->query($query, $params);

	$auction_data['counter'] = 1;

}

else

{

	if (!isset($_SESSION[$system->SETTINGS['sessionsname'] . '_VIEWED_AUCTIONS']))

	{

		$_SESSION[$system->SETTINGS['sessionsname'] . '_VIEWED_AUCTIONS'] = array();

	}

	if (!in_array($id, $_SESSION[$system->SETTINGS['sessionsname'] . '_VIEWED_AUCTIONS']))

	{

		$query = "UPDATE " . $DBPrefix . "auccounter set counter = counter + 1 WHERE auction_id = :auction_id";

		$params = array(

			array(':auction_id', $id, 'int')

		);

		$db->query($query, $params);

		$_SESSION[$system->SETTINGS['sessionsname'] . '_VIEWED_AUCTIONS'][] = $id;

	}

}



// get watch item data

if ($user->logged_in)

{

	// Check if this item is not already added

	$query = "SELECT item_watch FROM " . $DBPrefix . "users WHERE id = :user_id";

	$params = array(

		array(':user_id', $user->user_data['id'], 'int')

	);

	$db->query($query, $params);



	$watcheditems = $db->result();

	$auc_ids = explode(' ', $watcheditems['item_watch']);

	if (in_array($id, $auc_ids))

	{

		$watch_var = 'delete';

		$watch_string = $MSG['5202_0'];

	}

	else

	{

		$watch_var = 'add';

		$watch_string = $MSG['5202'];

	}

}

else

{

	$watch_var = '';

	$watch_string = '';

}



// get ending time

$difference = $ends - $system->CTIME;



// build bread crumbs

$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_id";

$params = array(

	array(':cat_id', $auction_data['category'], 'int')

);

$db->query($query, $params);

$parent_node = $db->result();



$cat_value = '';

$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

for ($i = 0; $i < count($crumbs); $i++)

{

	if ($crumbs[$i]['cat_id'] > 0)

	{

		if ($i > 0)

		{

			$cat_value .= ' > ';

		}

		$cat_value .= '<a href="' . $system->SETTINGS['siteurl'] . 'browse.php?id=' . $crumbs[$i]['cat_id'] . '">' . $category_names[$crumbs[$i]['cat_id']] . '</a>';

	}

}



$secondcat_value = '';

if ($system->SETTINGS['extra_cat'] == 'y' && intval($auction_data['secondcat']) > 0)

{

	$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :sec_cat_id";

	$params = array(

		array(':sec_cat_id', $auction_data['secondcat'], 'int')

	);

	$db->query($query, $params);

	$parent_node = $db->result();



	$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

	for ($i = 0; $i < count($crumbs); $i++)

	{

		if ($crumbs[$i]['cat_id'] > 0)

		{

			if ($i > 0)

			{

				$secondcat_value .= ' > ';

			}

			$secondcat_value .= '<a href="' . $system->SETTINGS['siteurl'] . 'browse.php?id=' . $crumbs[$i]['cat_id'] . '">' . $category_names[$crumbs[$i]['cat_id']] . '</a>';

		}

	}

}



// history

$query = "SELECT b.*, u.nick, u.rate_sum FROM " . $DBPrefix . "bids b

LEFT JOIN " . $DBPrefix . "users u ON (u.id = b.bidder)

WHERE b.auction = :auct_ids ORDER BY b.bid DESC, b.quantity DESC, b.id DESC";

$params = array(

	array(':auct_ids', $id, 'int')

);

$db->query($query, $params);

$num_bids = $db->numrows();

$i = 0;

$left = $auction_data['quantity'];

$hbidder_data = array();

foreach ($db->fetchall() as $bidrec)

{

	if (!isset($bidderarray[$bidrec['nick']]))

	{

		if ($system->SETTINGS['buyerprivacy'] == 'y' && $user->user_data['id'] != $auction_data['user'] && $user->user_data['id'] != $bidrec['bidder'])

		{

			$bidderarray[$bidrec['nick']] = $MSG['176'] . ' ' . $bidderarraynum;

			$bidderarraynum++;

		}

		else

		{

			$bidderarray[$bidrec['nick']] = $bidrec['nick'];

		}

	}

	if ($left > 0 && !in_array($bidrec['bidder'], $hbidder_data)) //store highest bidder details

	{

		$hbidder_data[] = $bidrec['bidder'];

		$fb_pos = $fb_neg = 0;

		// get seller feebacks

		$query = "SELECT rate FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = :rate_users_ids";

		$params = array(

			array(':rate_users_ids', $bidrec['bidder'], 'int')

		);

		$db->query($query, $params);

		// count numbers

		$fb_pos = $fb_neg = 0;

		while ($fb_arr = $db->fetchall())

		{

			$arr = isset($fb_arr['rate']) ? $fb_arr['rate'] : '';

			if ($arr == 1)

			{

				$fb_pos++;

			}

			elseif ($arr == - 1)

			{

				$fb_neg++;

			}

		}



		$total_rate = $fb_pos - $fb_neg;



		foreach ($memtypesarr as $k => $l)

		{

			if ($k >= $total_rate || $i++ == (count($memtypesarr) - 1))

			{

				$buyer_rate_icon = $l['icon'];

				break;

			}

		}

			$template->assign_block_vars('high_bidders', array(

					'BUYER_ID' => $bidrec['bidder'],

					'BUYER_NAME' => $bidderarray[$bidrec['nick']],

					'BUYER_FB' => $bidrec['rate_sum'],

					'BUYER_FB_ICON' => (!empty($buyer_rate_icon) && $buyer_rate_icon != 'transparent.gif') ? '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $buyer_rate_icon . '" alt="' . $buyer_rate_icon . '" class="fbstar">' : ''

					));

		

	}

	$template->assign_block_vars('bidhistory', array(

			'BGCOLOR' => (!($i % 2)) ? '' : 'class="alt-row"',

			'ID' => $bidrec['bidder'],

			'NAME' => $bidderarray[$bidrec['nick']],

			'BID' => $system->print_money($bidrec['bid']),

			'WHEN' => $system->ArrangeDateAndTime($bidrec['bidwhen'] + $system->TDIFF) . ':' . date('s', $bidrec['bidwhen']),

			'QTY' => $bidrec['quantity']

			));

	$left -= $bidrec['quantity'];

	$i++;

}



$userbid = false;

if ($user->logged_in && $num_bids > 0)

{

	// check if youve bid on this before

	$query = "SELECT bid FROM " . $DBPrefix . "bids WHERE auction = :auction AND bidder = :bidder LIMIT 1";

	$params = array(

		array(':auction', $id, 'int'),

		array(':bidder', $user->user_data['id'], 'int')

	);

	$db->query($query, $params);

	if ($db->numrows('bid') > 0)

	{

		if (in_array($user->user_data['id'], $hbidder_data))

		{

			$yourbidmsg = '<div id="bid_message" class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> ' . $MSG['25_0088'] . '</div>';

			$yourbidclass = 'yourbidwin';

			if ($difference <= 0 && $auction_data['reserve_price'] > 0 && $auction_data['current_bid'] < $auction_data['reserve_price'])

			{

				$yourbidmsg = $MSG['514'];

				$yourbidclass = 'yourbidloss';

			}

			elseif ($difference <= 0 || $auction_data['bn_only'] == 'y')

			{

				$yourbidmsg = '<div id="bid_message" class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> ' . $MSG['25_0089'] . '</div>';

			}

		}

		else

		{

			$yourbidmsg = '<div id="bid_message" class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> ' . $MSG['25_0087'] . '</div>';

			$yourbidclass = 'yourbidloss';

		}

		$userbid = true;

	}

}



// sort out user questions

$query = "SELECT id FROM " . $DBPrefix . "messages WHERE reply_of = 0 AND public = 1 AND question = :question_ids";

$params = array(

	array(':question_ids', $id, 'int')

);

$db->query($query, $params);

$num_questions = $db->numrows();

while ($message_id = $db->result('id'))

{

	$template->assign_block_vars('questions', array()); // just need to create the block

	$query = "SELECT sentfrom, message FROM " . $DBPrefix . "messages WHERE question = :id AND reply_of = :message_id OR id = :message_id ORDER BY sentat ASC";

	$params = array(

		array(':id', $id, 'int'),

		array(':message_id', $message_id, 'int')

	);

	$db->query($query, $params);



	while ($rows = $db->result())	

	{

		$template->assign_block_vars('questions.conv', array(

			'MESSAGE' => $rows['message'],

			'BY_WHO' => ($user_id == $rows['sentfrom']) ? $MSG['125'] : $MSG['555']

		));

	}

}



$high_bid = ($num_bids == 0) ? $minimum_bid : $high_bid;

if ($customincrement == 0)

{

	// Get bid increment for current bid and calculate minimum bid

	$query = "SELECT increment FROM " . $DBPrefix . "increments WHERE

			((low <= :val AND high >= :val) OR

			(low < :val AND high < :val)) ORDER BY increment DESC";

	$params = array(

		array(':val ', $high_bid, 'float')

	);

	$db->query($query, $params);

	if ($db->numrows() != 0)

	{

		$increment = $db->result('increment');

	}

}

else

{

	$increment = $customincrement;

}



if ($auction_type == 2)

{

	$increment = 0;

}



if ($customincrement > 0)

{

	$increment = $customincrement;

}



if ($num_bids == 0 || $auction_type == 2)

{

	$next_bidp = $minimum_bid;

}

else

{

	$incr = isset($increment) ? + $increment : '';

	$next_bidp = $high_bid . $incr;

}



$view_history = '';

if ($num_bids > 0)

{

	$view_history = '';

}

else

{

	$view_history = 1;

}

$min_bid = $system->print_money($minimum_bid);

$high_bid = $system->print_money($high_bid);

if ($difference > 0)

{

	$next_bid = $system->print_money($next_bidp);

}

else

{

	$next_bid = '--';

}



// get seller feebacks

$query = "SELECT rate FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = :user_ids";

$params = array(

	array(':user_ids', $user_id, 'int')

);

$db->query($query, $params);

$num_feedbacks = $db->numrows('rate');

// count numbers

$fb_pos = $fb_neg = 0;

while ($fb_arr = $db->result())

{

	if ($fb_arr['rate'] == 1)

	{

		$fb_pos++;

	}

	elseif ($fb_arr['rate'] == - 1)

	{

		$fb_neg++;

	}

}



$total_rate = $fb_pos - $fb_neg;



if ($total_rate > 0)

{

	$i = 0;

	foreach ($memtypesarr as $k => $l)

	{

		if ($k >= $total_rate || $i++ == (count($memtypesarr) - 1))

		{

			$seller_rate_icon = $l['icon'];

			break;

		}

	}

}



// Pictures Gellery

$K = 0;

$UPLOADED_PICTURES = array();

if (file_exists(UPLOAD_FOLDER . '/auctions/' . $id))

{

	$dir = @opendir(UPLOAD_FOLDER . '/auctions/' . $id);

	if ($dir)

	{

		while ($file = @readdir($dir))

		{

			if ($file != '.' && $file != '..' && strpos($file, 'thumb-') === false)

			{

				$UPLOADED_PICTURES[$K] = $file;

				$K++;

			}

		}

		@closedir($dir);

	}

	$GALLERY_DIR = $id;



	if (is_array($UPLOADED_PICTURES))

	{

		$C = 0;

		foreach ($UPLOADED_PICTURES as $k => $v)

		{

			$TMP = @getimagesize(UPLOAD_FOLDER . '/auctions/' . $id . '/' . $v);

			if ($TMP[2] >= 1 && $TMP[2] <= 3)

			{

				$template->assign_block_vars('gallery', array(

						'THUMB_V' => $system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $system->SETTINGS['thumb_show'] . '&fromfile=' . $security->encrypt($id . '/' . $v, true),

						'V' => $system->SETTINGS['siteurl'] . 'getthumb.php?w=1000&fromfile=' . $security->encrypt($id . '/' . $v, true),

						'NAME' => $v,

						'COUNT' => $C++

						));

			}

		}

	}

}



// payment methods

$payment = explode(', ', $auction_data['payment']);

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

$has_ended = $ends < $system->CTIME ? true : false;

if ($has_ended)

{

	if ($user->logged_in)

	{

		$bn_link = ' <a href="' . $system->SETTINGS['siteurl'] . 'buy_now.php?id=' . $id . '"><img border="0" align="absbottom" alt="' . $MSG['496'] . '" src="' . get_lang_img('buy_it_now.gif') . '"></a>';

		$bn_link2 = '&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="' . $system->SETTINGS['siteurl'] . 'buy_now.php?id=' . $id . '">' . $MSG['350_1015402'] . '</a><hr />';

	}

}





$query = "SELECT item_condition, condition_desc FROM " . $DBPrefix . "conditions ";

$db->direct_query($query);

$condition_desc = '';
while ($row = $db->result())

{

	if ($row['item_condition'] == $item_condition) 

	{

		$condition_desc =   ' ' . $row['condition_desc'] ;

	}

}

//See if seller is online

$loggedtime = $system->CTIME - 320; // 5 min

$query = "SELECT is_online, hideOnline FROM " . $DBPrefix . "users WHERE id = :user_id"; 

$params = array(

	array(':user_id', $user_id, 'int')

);

$db->query($query, $params);

 

while ($onlinecheck = $db->result()) 

{ 



    if($onlinecheck['is_online'] > $loggedtime && $onlinecheck['hideOnline'] == 'n') 

    { 

    	$online = true;

    } 

    else 

    { 

    	$online = false; 

    }     

} 



$shipping = '';

if ($auction_data['shipping'] == 1) $shipping = $MSG['031'];

elseif ($auction_data['shipping'] == 2) $shipping = $MSG['032'];

elseif ($auction_data['shipping'] == 3) $shipping = $MSG['867'];


$googleMap = $auction_type != 3 && isset($auction_data['zip']) && isset($auction_data['country']) && $system->SETTINGS['googleMap'] == 'y' && $auction_data['locationMap'] == 'y' ? true : false;



if (!empty($auction_data)) 

{

	if (!empty($auction_data) && !empty($minimum_bid)) 

	{

		$buy_now_price = strip_tags($system->print_money($auction_data['buy_now']));

		$bid_price = strip_tags($system->print_money($minimum_bid));

				

	}

	//Checking to see if the auction is a Buy Now only auction

	if (!empty($auction_data) && isset($auction_data['buy_now']) && $auction_data['bn_only'] == 'y');

	{

	    $fb_price = " - " . $MSG['931'] . ": " . $buy_now_price;

	}

	//Checking the auction to see if it is a Standard Auction with a buy now botton

	if (isset($min_bid) && ($auction_data['bn_only'] == 'n') && (isset($auction_data['buy_now'])))

	{

	    $fb_price = " - " . $MSG['116'] . ": " . $bid_price . $MSG['3500_1015944'] . $buy_now_price;

	}

	//Checking the auction to see if it is a Standard Auction with no buy now botton

	if (isset($min_bid) && ($auction_data['bn_only'] == 'n') && ($auction_data['buy_now'] == 0))

	{

	    $fb_price = " - " . $MSG['116'] . ": " . $bid_price;

	}

}			

/////////////////////////////////

///////// Auction Description ///

/////////////////////////////////

function shortText($string,$lenght) 

{

    $string = substr($string,0,$lenght)."...";

    $string_ende = strrchr($string, " ");

    $string = str_replace($string_ende," ...", $string);

    return $string;

}



if (isset($auction_data['description'])) {

	$fbdescW = strip_tags($auction_data['description']);

	$fbdescW = trim($fbdescW);

	$fb_desc = $fbdescW;

}

else         

{

	$fb_desc = strip_tags(stripslashes($system->SETTINGS['descriptiontag']));

}		

$fb_desc = shortText($fb_desc,200);

			

$fb_url = $system->SETTINGS['https'] == 'y' ? 'https://' : 'http://';

$fb_url .= $_SERVER['HTTP_HOST'];

$fb_url .= $_SERVER['REQUEST_URI'];



if($user->checkAuth())

{

	$endingTime = $system->ArrangeDateAndTime($system->getUserTimestamp($ends, $user->user_data['timezone']), $user->user_data['timezone'], true);

	$startingTime = $system->ArrangeDateAndTime($system->getUserTimestamp($start, $user->user_data['timezone']), $user->user_data['timezone'], true);

	$countDownClock = $system->countDownClock($ends, $user->user_data['timezone']);

}else{

	$endingTime = $system->ArrangeDateAndTime($system->getUserTimestamp($ends), $system->SETTINGS['timezone'], true);

	$startingTime = $system->ArrangeDateAndTime($system->getUserTimestamp($start), $system->SETTINGS['timezone'], true);

	$countDownClock = $system->countDownClock($ends);

}



$template->assign_vars(array(

	'ID' => $auction_data['id'],

	'FBTITLE' => $titel,

	'TITLE' => $titel,

	'SERVERTIME' => $system->countDownClock($system->CTIME),

	'SUBTITLE' => $system->cleanvars($auction_data['subtitle']),

	'SEO_TITLE' => generate_seo_link($titel),

	'AUCTION_DESCRIPTION' => $description,

	'FB_PIC_URL' => (!empty($auction_data['pict_url'])) ? 'getthumb.php?w=' . $system->SETTINGS['thumb_show'] . '&fromfile=' . $security->encrypt($auction_data['id'] . '/' . $auction_data['pict_url'], true) : 'images/email_alerts/default_item_img.jpg',

	'PIC_URL' => (!empty($auction_data['pict_url'])) ? 'getthumb.php?w=' . $system->SETTINGS['thumb_show'] . '&fromfile=' . $security->encrypt($auction_data['id'] . '/' . $auction_data['pict_url'], true) : 'images/email_alerts/default_item_img.jpg',

	'SHIPPING_COST' => $system->print_money($auction_data['shipping_cost']),

	'ADDITIONAL_SHIPPING_COST' => $system->print_money($auction_data['shipping_cost_additional']),

	'COUNTRY' => $auction_data['country'],

	'CITY' => $city,

	'ZIP' => $auction_data['zip'],

	'QTY' => $auction_data['quantity'],

	'ENDS_IN' => $countDownClock,

	'STARTTIME' => $startingTime,

	'ENDTIME' => $endingTime,

	'BUYNOW' => $system->print_money($auction_data['buy_now']),

	'NUMBIDS' => $num_bids,

	'MINBID' => $min_bid,

	'MAXBID' => $high_bid,

	'NEXTBID' => $next_bid,

	'INTERNATIONAL' => ($auction_data['international'] == 1) ? $MSG['033'] : $MSG['043'],

	'SHIPPING' => $shipping,

	'SHIPPINGTERMS' => nl2br($auction_data['shipping_terms']),

	'PAYMENTS' => $payment_methods,

	'AUCTION_VIEWS' => $auction_data['counter'],

	'AUCTION_TYPE' => ($auction_data['bn_only'] == 'n') ? $system->SETTINGS['auction_types'][$auction_type] : $MSG['933'],

	'ATYPE' => $auction_type,

	'THUMBWIDTH' => $system->SETTINGS['thumb_show'],

	'TOPCATSPATH' => ($system->SETTINGS['extra_cat'] == 'y' && isset($_SESSION['browse_id']) && $_SESSION['browse_id'] == $auction_data['secondcat']) ? $secondcat_value : $cat_value,

	'CATSPATH' => $cat_value,

	'SECCATSPATH' => $secondcat_value,

	'CAT_ID' => $auction_data['category'],

	'UPLOADEDPATH' => UPLOAD_FOLDER,

	'BNIMG' => get_lang_img('buy_it_now.gif'),

	'IS_ONLINE' => $online,

	'RETURNS' => ($auction_data['returns'] == 1) ? $MSG['025_B'] : $MSG['025_D'],

	'SELLER_REG' => $seller_reg,

	'SELLER_ID' => $auction_data['user'],

	'SELLER_NICK' => $auction_data['nick'],

	'SELLER_TOTALFB' => $total_rate,

	'SELLER_FBICON' => (!empty($seller_rate_icon) && $seller_rate_icon != 'transparent.gif') ? '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $seller_rate_icon . '" alt="' . $seller_rate_icon . '" class="fbstar">' : '',

	'SELLER_NUMFB' => $num_feedbacks,

	'SELLER_FBPOS' => ($num_feedbacks > 0) ? '(' . ceil($fb_pos * 100 / $num_feedbacks) . '%)' : '0',

	'SELLER_FBNEG' => ($fb_neg > 0) ? $MSG['5507'] . ' (' . ceil($fb_neg * 100 / $total_rate) . '%)' : '0',	

	'WATCH_VAR' => $watch_var,

	'WATCH_STRING' => $watch_string,

	'FSM' => isset($fsm) ? $fsm : '',

	'B_SETFSM' => (isset($faveset)),

	'YOURBIDMSG' => (isset($yourbidmsg)) ? $yourbidmsg : '',

	'YOURBIDCLASS' => (isset($yourbidclass)) ? $yourbidclass : '',

	'B_HASENDED' => $has_ended,

	'B_CANEDIT' => ($user->logged_in && $user->user_data['id'] == $auction_data['user'] && $num_bids == 0 && $difference > 0),

	'B_CANCONTACTSELLER' => (($system->SETTINGS['contactseller'] == 'always' || ($system->SETTINGS['contactseller'] == 'logged' && $user->logged_in)) && (!$user->logged_in || $user->user_data['id'] != $auction_data['user'])),

	'B_HASIMAGE' => (!empty($auction_data['pict_url'])),

	'B_NOTBNONLY' => ($auction_data['bn_only'] == 'n'),

	'B_HASRESERVE' => ($auction_data['reserve_price'] > 0 && $auction_data['reserve_price'] > $auction_data['current_bid']),

	'B_BNENABLED' => ($system->SETTINGS['buy_now'] == 2),

	'B_HASGALELRY' => (count($UPLOADED_PICTURES) > 0),

	'B_SHOWHISTORY' => (isset($view_history) && $num_bids > 0),

	'B_FREE_ITEM' => ($auction_data['sell_type'] == 'free') ? true : false,

	'B_BUY_NOW' => ($auction_data['buy_now'] > 0 && ($auction_data['bn_only'] == 'y' || $auction_data['bn_only'] == 'n' && ($auction_data['num_bids'] == 0 || ($auction_data['reserve_price'] > 0 && $auction_data['current_bid'] < $auction_data['reserve_price'])))),

	'B_BUY_NOW_ONLY' => ($auction_data['bn_only'] == 'y'),

	'B_ADDITIONAL_SHIPPING_COST' => ($auction_data['auction_type'] == '2'),

	'B_USERBID' => $userbid,

	'B_BIDDERPRIV' => ($system->SETTINGS['buyerprivacy'] == 'y' && (!$user->logged_in || ($user->logged_in && $user->user_data['id'] != $auction_data['user']))),

	'B_HASBUYER' => (count($hbidder_data) > 0),

	'B_COUNTDOWN' => $ends - $system->CTIME,

	'B_HAS_QUESTIONS' => ($num_questions > 0),

	'B_CAN_BUY' => $user->can_buy && !($start > $system->CTIME),

	'B_CANSEE' => ($user->logged_in && $user->user_data['id'] != $auction_data['user']),

	'B_CONDITION'=> $system->SETTINGS['item_conditions'] == 'y' && $item_condition !='',

	'ITEM_CONDITION'=> $item_condition,

	'CONDITION_DESCRIPTION'=> $condition_desc,

	'ITEM_MANUFACTURER'=> $item_manufacturer,

    'ITEM_MODEL'=>   $item_model,

	'ITEM_COLOR'=> $item_color,

	'ITEM_YEAR' =>  $item_year,

	'FBLOGIN' => $_SESSION['REDIRECT_AFTER_LOGIN'] . '-facebook',

	'AVATAR' => $TPL_avatar,

	'B_SHIPPING_TERMS' => $system->SETTINGS['shipping_terms'] == 'y' ? true : false,

	'B_SHIPPING_CONDITIONS' => $system->SETTINGS['shipping_conditions'] == 'y' ? true : false,

	'B_FB_LINK' => 'ItemFacebookLogin',

	'B_ITEM_CONDITION' => (!empty($item_condition)),

	'B_ITEM_MANUFACTURER' => (!empty($item_manufacturer)),

	'B_ITEM_MODEL' => (!empty($item_model)),

	'B_ITEM_COLOR' => (!empty($item_color)),

	'B_ITEM_YEAR' => (!empty($item_year)),

	'B_GOOGLE_MAP' => $googleMap,

	'FB_TITLE' => isset($fb_title) ? $fb_title : '',

	'FB_DESC' => isset($fb_desc) ? $fb_desc : '',

	'FB_URL' => isset($fb_url) ? $fb_url : '',

	'FB_PRICE' => isset($fb_price) ? $fb_price : '',

	'MAPKEY' => $system->SETTINGS['googleMapKey']

));

		

//we are changing the $high_bid salt to a new salt because of the bid php page

$current_high_bids = $high_bid;

if(isset($yourbidmsg) !='')

{

	$yourmsg = $yourbidmsg;

}else{

	$yourmsg = '';

}

include INCLUDE_PATH . 'functions_bid.php';

//this is for the live bid update

if(isset($_GET['live']) && $_GET['live'] == 'update')

{

	echo '<div id="bid_message">' . $yourmsg . '</div>';

	echo '<div id="current_bid"><span class="glyphicon glyphicon-ok"></span> <b>' . $MSG['116'] . ' </b>' . $current_high_bids . '</div>';

	echo '<div id="current_bid_box"><span class="glyphicon glyphicon-ok"></span> <b>' . $MSG['116'] . ' </b>' . $current_high_bids . '</div>';

	echo '<div id="next_bid"><small><b>' . $MSG['124'] . ':</b> ' . $system->print_money($next_bid) . '</small></div>';

	echo '<div id="no_of_bids">' . $MSG['119'] . ' ' . $num_bids . '</div>';

}else{

	include 'header.php';

	$template->set_filenames(array(

			'body' => 'item.tpl'

			));

	$template->display('body');

	include 'footer.php';

}

unset($_SESSION['browse_id']);

