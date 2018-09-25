<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);
$catscontrol = new MPTTcategories();

// Data check
if (!isset($_REQUEST['id']))
{
	if (!isset($_SESSION['RETURN_LIST']))
	{
		$URL = 'listauctions.php';
	}
	else
	{
		$URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET'];
	}
	unset($_SESSION['RETURN_LIST'], $_SESSION['RETURN_LIST_OFFSET']);
	header('location: ' . $URL);
	exit;
}

function load_gallery($uploaded_path, $auc_id)
{
	$UPLOADED_PICTURES = array();
	if (file_exists('../' . $uploaded_path . $auc_id))
	{
		$dir = @opendir('../' . $uploaded_path . $auc_id);
		if ($dir)
		{
			while ($file = @readdir($dir))
			{
				if ($file != '.' && $file != '..' && strpos($file, 'thumb-') === false)
				{
					$UPLOADED_PICTURES[$K] = $uploaded_path . $auc_id . '/' . $file;
					$K++;
				}
			}
			@closedir($dir);
		}
	}
	return $UPLOADED_PICTURES;
}
if (isset($_POST['action']) && $_POST['action'] == 'update')
{

	// Close auctions
	if (isset($_POST['closed']) && $_POST['closed'] == $MSG['3500_1015501'])
	{
		$k = $_POST['id'];
			// Retrieve auction data
			$query = "SELECT duration, category FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $k, 'int');
			$db->query($query, $params);
			$AUCTION = $db->result();

			// auction ends
			$WILLEND = $system->CTIME + ($AUCTION['duration'] * 24 * 60 * 60);
			$suspend = 0;
			$NOW = $system->CTIME;
			$NOWB = date('Ymd');
			
			$query = "UPDATE " . $DBPrefix . "auctions
				  SET starts = :now,
				  ends = :ends,
				  closed = :close,
				  num_bids = :num_bid,
				  relisted = relisted + :relist,
				  current_bid = :current_bids,
				  sold = :no_sold,
				  suspended = :suspend
				  WHERE id = :auc_id";
			$params = array();
			$params[] = array(':now', $NOW, 'int');
			$params[] = array(':ends', $NOW, 'int');
			$params[] = array(':close', 1, 'int');
			$params[] = array(':num_bid', 0, 'int');
			$params[] = array(':relist', 0, 'int');
			$params[] = array(':current_bids', 0, 'int');
			$params[] = array(':no_sold', 'n', 'str');
			$params[] = array(':suspend', $suspend, 'int');
			$params[] = array(':auc_id', $k, 'int');
			$db->query($query, $params); 

			// delete bids
			$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $k, 'int');
			$db->query($query, $params);

			// Proxy Bids
			$query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $k, 'int');
			$db->query($query, $params);

			// Update COUNTERS table
			$system->writesetting("counters", "auctions",  $system->COUNTERS['auctions'] + 0, 'int');

			$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_ids";
			$params = array();
			$params[] = array(':cat_ids', $AUCTION['category'], 'int');
			$db->query($query, $params);

			$parent_node = $db->fetchall();
			$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
			// update recursive categories
			for ($i = 0; $i < count($crumbs); $i++)
			{
				$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter - :sub WHERE cat_id = :cat_ids";
				$params = array();
				$params[] = array(':sub', 1, 'int');
				$params[] = array(':cat_ids', $crumbs[$i]['cat_id'], 'int');
				$db->query($query, $params);
			}
		}
		
		
	// Re-list auctions
	if (isset($_POST['relist']) && $_POST['relist'] == $MSG['2__0051'])
	{
		$k = $_POST['id'];
			// Retrieve auction data
			$query = "SELECT duration, category FROM " . $DBPrefix . "auctions WHERE id = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $k, 'int');
			$db->query($query, $params);
			$AUCTION = $db->result();

			// auction ends
			$WILLEND = $system->CTIME + ($AUCTION['duration'] * 24 * 60 * 60);
			$suspend = 0;
			$NOW = $system->CTIME;
			$NOWB = date('Ymd');
			
			$query = "UPDATE " . $DBPrefix . "auctions
				  SET starts = :now,
				  ends = :ends,
				  closed = :close,
				  num_bids = :num_bid,
				  relisted = relisted + :relist,
				  current_bid = :current_bids,
				  sold = :no_sold,
				  suspended = :suspend
				  WHERE id = :auc_id";
			$params = array();
			$params[] = array(':now', $NOW, 'int');
			$params[] = array(':ends', $WILLEND, 'int');
			$params[] = array(':close', 0, 'int');
			$params[] = array(':num_bid', 0, 'int');
			$params[] = array(':relist', 1, 'int');
			$params[] = array(':current_bids', 0, 'int');
			$params[] = array(':no_sold', 'n', 'str');
			$params[] = array(':suspend', $suspend, 'int');
			$params[] = array(':auc_id', $k, 'int');
			$db->query($query, $params);

			// Insert into relisted table
			$query = "INSERT INTO " . $DBPrefix . "closedrelisted VALUES (:auc_id, :relist, :new_auc_id)";
			$params = array();
			$params[] = array(':auc_id', $k, 'int');
			$params[] = array(':relist', $NOWB, 'int');
			$params[] = array(':new_auc_id', $k, 'int');
			$db->query($query, $params);

			// delete bids
			$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $k, 'int');
			$db->query($query, $params);

			// Proxy Bids
			$query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = :auc_id";
			$params = array();
			$params[] = array(':auc_id', $k, 'int');
			$db->query($query, $params);

			// Update COUNTERS table
			$system->writesetting("counters", "auctions", $system->COUNTERS['auctions'] + 1, 'int');

			$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat_ids";
			$params = array();
			$params[] = array(':cat_ids', $AUCTION['category'], 'int');
			$db->query($query, $params);

			$parent_node = $db->fetchall();
			$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
			// update recursive categories
			for ($i = 0; $i < count($crumbs); $i++)
			{
				$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + :sub WHERE cat_id = :cat_ids";
				$params = array();
				$params[] = array(':sub', 1, 'int');
				$params[] = array(':cat_ids', $crumbs[$i]['cat_id'], 'int');
				$db->query($query, $params);
			}
		}

	if (isset($_POST['act']) && $_POST['act'] == $MSG['089'])
	{
		// Check that all the fields are not NULL
		if (!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['duration']) && !empty($_POST['category']) && !empty($_POST['description']) && !empty($_POST['min_bid']))
		{
			// fix values
			$_POST['quantity'] = (empty($_POST['quantity'])) ? 1 : $_POST['quantity'];
			$_POST['customincrement'] = (empty($_POST['customincrement'])) ? 0 : $_POST['customincrement'];
			// Check the input values for validity.
			if ($_POST['quantity'] < 1) // 1 or more items being sold
			{
				$ERROR = $ERR['701'];
			}
			elseif ($_POST['current_bid'] < $_POST['min_bid'] && $_POST['current_bid'] != 0) // bid > min_bid
			{
				$ERROR = $ERR['702'];
			}
			else
			{
				// Retrieve auction data
				$query = "SELECT * from " . $DBPrefix . "auctions WHERE id = :ids";
				$params = array();
				$params[] = array(':ids', intval($_POST['id']), 'int');
				$db->query($query, $params);
				$AUCTION = $db->result();
	
				$start = date('H i s n j Y', $AUCTION['starts']);
				$start = explode(' ', $start);
				$a_start = gmmktime($start[0], $start[1], $start[2], $start[3], $start[4], $start[5]);
				$a_ends = $a_start + ($_POST['duration'] * 24 * 60 * 60);
	
				if ($AUCTION['category'] != $_POST['category'])
				{
					// and increase new category counters
					$ct = intval($_POST['category']);
					$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :ids";
					$params = array();
					$params[] = array(':ids', $ct, 'int');
					$db->query($query, $params);
					$parent_node = $db->result();
					$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
	
					for ($i = 0; $i < count($crumbs); $i++)
					{
						if ($crumbs[$i]['cat_id'] == $ct)
						{
							$query = "UPDATE " . $DBPrefix . "categories SET counter = counter + 1, sub_counter = sub_counter + 1 WHERE cat_id = :ids";
							$params = array();
							$params[] = array(':ids', $crumbs[$i]['cat_id'], 'int');
						}
						else
						{
							$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + 1 WHERE cat_id = :ids";
							$params = array();
							$params[] = array(':ids', $crumbs[$i]['cat_id'], 'int');
						}
						$db->query($query, $params);
					}
	
					// and decrease old category counters
					$cta = intval($AUCTION['category']);
					$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :ids";
					$params = array();
					$params[] = array(':ids', $cta, 'int');
					$db->query($query, $params);
					$parent_node = $db->result();
					$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
	
					for ($i = 0; $i < count($crumbs); $i++)
					{
						if ($crumbs[$i]['cat_id'] == $cta)
						{
							$query = "UPDATE " . $DBPrefix . "categories SET counter = counter - 1, sub_counter = sub_counter - 1 WHERE cat_id = :ids";
							$params = array();
							$params[] = array(':ids', $crumbs[$i]['cat_id'], 'int');
						}
						else
						{
							$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter - 1 WHERE cat_id = :ids";
							$params = array();
							$params[] = array(':ids', $crumbs[$i]['cat_id'], 'int');
						}
						$db->query($query, $params);
					}
				}
	
				if ($AUCTION['secondcat'] != $_POST['secondcat'])
				{
					// and increase new category counters
					$ct = intval($_POST['secondcat']);
					$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :ids";
					$params = array();
					$params[] = array(':ids', $ct, 'int');
					$db->query($query, $params);
					$parent_node = $db->result();
					$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
	
					for ($i = 0; $i < count($crumbs); $i++)
					{
						if ($crumbs[$i]['cat_id'] == $ct)
						{
							$query = "UPDATE " . $DBPrefix . "categories SET counter = counter + 1, sub_counter = sub_counter + 1 WHERE cat_id = :ids";
							$params = array();
							$params[] = array(':ids', $crumbs[$i]['cat_id'], 'int');
						}
						else
						{
							$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + 1 WHERE cat_id = :ids";
							$params = array();
							$params[] = array(':ids', $crumbs[$i]['cat_id'], 'int');
						}
						$db->query($query, $params);
					}
	
					// and decrease old category counters
					$cta = intval($AUCTION['secondcat']);
					$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :ids";
					$params = array();
					$params[] = array(':ids', $cta, 'int');
					$db->query($query, $params);
					$parent_node = $db->result();
					$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
	
					for ($i = 0; $i < count($crumbs); $i++)
					{
						if ($crumbs[$i]['cat_id'] == $cta)
						{
							$query = "UPDATE " . $DBPrefix . "categories SET counter = counter - 1, sub_counter = sub_counter - 1 WHERE cat_id = :ids";
							$params = array();
							$params[] = array(':ids', $crumbs[$i]['cat_id'], 'int');
						}
						else
						{
							$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter - 1 WHERE cat_id = :ids";
							$params = array();
							$params[] = array(':ids', $crumbs[$i]['cat_id'], 'int');
						}
						$db->query($query, $params);
					}
				}
	
				// clean unwanted images
				if (isset($_POST['gallery']) && is_array($_POST['gallery']))
				{
					$uploaded = load_gallery(UPLOAD_FOLDER, $_POST['id']);
					foreach ($uploaded as $img)
					{
						if (in_array($img, $_POST['gallery']))
						{
							unlink(MAIN_PATH . $img);
						}
					}
				}
							
				
				$item_condition = (isset($_POST['item_condition'])) ? $_POST['item_condition'] : $AUCTION['item_condition'];
				$item_manufacturer = (isset($_POST['item_manufacturer'])) ? $_POST['item_manufacturer'] : $AUCTION['item_manufacturer'];
				$item_model = (isset($_POST['item_model'])) ? $_POST['item_model'] : $AUCTION['item_model'];
				$item_color = (isset($_POST['item_color'])) ? $_POST['item_color'] : $AUCTION['item_color'];
				$item_year = (isset($_POST['item_year'])) ? $_POST['item_year'] : $AUCTION['item_year'];
	
				$query = "UPDATE " . $DBPrefix . "auctions SET
						title = '" . $system->cleanvars($_POST['title']) . "',
						subtitle = '" . $system->cleanvars($_POST['subtitle']) . "',
						ends = '" . $a_ends . "',
						duration = '" . $system->cleanvars($_POST['duration']) . "',
						category = '" . intval($_POST['category']) . "',
						secondcat = '" . intval($_POST['secondcat']) . "',
						description = '" . $_POST['description'] . "',
						quantity = '" . intval($_POST['quantity']) . "',
						minimum_bid = '" . $system->input_money($_POST['min_bid']) . "',
						shipping_cost = '" . $system->input_money($_POST['shipping_cost']) . "',
						buy_now = '" . $system->input_money($_POST['buy_now']) . "',
						bn_only = '" . $system->cleanvars($_POST['buy_now_only']) . "',
						reserve_price = '" . $system->input_money($_POST['reserve_price']) . "',
						increment = " . $system->input_money($_POST['customincrement']) . ",
						shipping = '" . $_POST['shipping'] . "',
						payment = '" . $system->cleanvars(implode(', ', $_POST['payment'])) . "',
						international = " . ((isset($_POST['international'])) ? 1 : 0) . ",
						shipping_terms = '" . $system->cleanvars($_POST['shipping_terms']) . "',
						bold = '" . ((isset($_POST['is_bold'])) ? 'y' : 'n') . "',
						highlighted = '" . ((isset($_POST['is_highlighted'])) ? 'y' : 'n') . "',
						item_condition = '" . $system->cleanvars($item_condition) . "',
						item_manufacturer = '" . $system->cleanvars($item_manufacturer) . "',
						item_model = '" . $system->cleanvars($item_model) . "',
						item_color = '" . $system->cleanvars($item_color) . "',
						item_year = '" . $system->cleanvars($item_year) . "',
						auction_type = '" . intval($_POST['atype']) . "',
						returns = '" . intval($_POST['returns']) . "',
						sell_type = '" . $_POST['sellType'] . "',
						featured = '" . ((isset($_POST['is_featured'])) ? 'y' : 'n') . "'
						WHERE id = " . $_POST['id'];
				$db->direct_query($query);
					
				$URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET'];
				unset($_SESSION['RETURN_LIST'], $_SESSION['RETURN_LIST_OFFSET']);
				header('location: ' . $URL);
				exit;
			}
		}
		else
		{
			$ERROR = $ERR['112'];
		}
	}
}
$auc_id = intval($_REQUEST['id']);
$query =   "SELECT u.nick, a.* FROM " . $DBPrefix . "auctions a
			LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
			WHERE a.id = :ids";
$params = array();
$params[] = array(':ids', $auc_id, 'int');
$db->query($query, $params);

if ($db->numrows() == 0)
{
	if (!isset($_SESSION['RETURN_LIST']))
	{
		$URL = 'listauctions.php';
	}
	else
	{
		$URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET'];
	}
	unset($_SESSION['RETURN_LIST'], $_SESSION['RETURN_LIST_OFFSET']);
	header('location: ' . $URL);
	exit;
}

$auction_data = $db->result();

// DURATIONS
$dur_list = ''; // empty string to begin HTML list
$query = "SELECT days, description FROM " . $DBPrefix . "durations";
$db->direct_query($query);

while ($row = $db->result())
{
	$dur_list .= '<option value="' . $row['days'] . '"';
	if ($row['days'] == $auction_data['duration'])
	{
		$dur_list .= ' selected';
	}
	$dur_list .= '>' . $row['description'] . '</option>' . "\n";
}

// CATEGORIES
$categories_list1 = '<select name="category">' . "\n";
if (isset($category_plain) && count($category_plain) > 0)
{
	foreach ($category_plain as $k => $v)
	{
		$categories_list1 .= '	<option value="' . $k . '"' . (($k == $auction_data['category']) ? ' selected="true"' : '') . '>' . $v . '</option>' . "\n";
	}
}
$categories_list1 .= '</select>' . "\n";

$categories_list2 = '<select name="secondcat">' . "\n";
if (isset($category_plain) && count($category_plain) > 0)
{
	foreach ($category_plain as $k => $v)
	{
		$categories_list2 .= '	<option value="' . $k . '"' . (($k == $auction_data['secondcat']) ? ' selected="true"' : '') . '>' . $v . '</option>' . "\n";
	}
}
$categories_list2 .= '</select>' . "\n";


$query = "SELECT item_condition FROM " . $DBPrefix . "conditions ";
		$db->direct_query($query);
		$TPL_item_condition_list = '<select class="form-control" name="item_condition">' . "\n";
		while ($condition = $db->result())
		{
			$selected = ($condition['item_condition'] == $auction_data['item_condition']) ? 'selected="true"' : '';
			$TPL_item_condition_list .= "\t" . '<option value="' . $condition['item_condition'] . '" ' . $selected . '>' . $condition['item_condition'] . '</option>' . "\n";
		}
		$TPL_item_condition_list .= '</select>' . "\n";
		
// Pictures Gellery
$K = 0;
$UPLOADED_PICTURES = array();
if (file_exists('../' . UPLOAD_FOLDER . $auc_id))
{
	// load dem pictures
	$UPLOADED_PICTURES = load_gallery(UPLOAD_FOLDER, $auc_id);

	if (is_array($UPLOADED_PICTURES))
	{
		foreach ($UPLOADED_PICTURES as $k => $v)
		{
			$TMP = @getimagesize('../' . $v);
			if ($TMP[2] >= 1 && $TMP[2] <= 3)
			{
				$template->assign_block_vars('gallery', array(
						'V' => $v
						));
			}
		}
	}
}

// payments
$payment = explode(', ', $auction_data['payment']);
$payment_methods = '';
$gateways_data = $system->loadTable('gateways');

$gateway_list = explode(',', $gateways_data['gateways']);
foreach ($gateway_list as $v)
{
	$v = strtolower($v);
	if ($gateways_data[$v . '_active'] == 1 && _in_array($v, $payment))
	{
		$checked = (in_array($v, $payment)) ? 'checked' : '';
		$payment_methods .= '<p><input type="checkbox" name="payment[]" value="' . $v . '" ' . $checked . '> ' . $system->SETTINGS['gateways'][$v] . '</p>';
	}
}

$payment_options = unserialize($system->SETTINGS['payment_options']);
foreach ($payment_options as $k => $v)
{
	$checked = (_in_array($k, $payment)) ? 'checked' : '';
	$payment_methods .= '<p><input type="checkbox" name="payment[]" value="' . $k . '" ' . $checked . '> ' . $v . '</p>';
}

$canrelist = false;
if ($auction_data['closed'] == 1 && $auction_data['suspended'] == 0)
{
	$canrelist = true;
}
if ($auction_data['closed'] == 0 && $auction_data['suspended'] == 0)
{
	$close = true;
}

$TPL_auction_type = '<select name="atype" id="atype">' . "\n";
foreach ($system->SETTINGS['auction_types'] as $key => $val)
{
	$TPL_auction_type .= "\t" . '<option name="atype" value="' . $key . '" ' . (($key == $auction_data['auction_type']) ? 'selected="true"' : '') . '>' . $val . '</option>' . "\n";
}
$TPL_auction_type .= '</select>' . "\n";

$template->assign_vars(array(
		'ERROR' => (isset($ERROR)) ? $ERROR : '',
		'ID' => intval($_REQUEST['id']),
		'USER' => $auction_data['nick'],
		'TITLE' => $auction_data['title'],
		'SUBTITLE' => $auction_data['subtitle'],
		'DURLIST' => $dur_list,
		'CATLIST1' => $categories_list1,
		'CATLIST2' => $categories_list2,
		'DESC' => $CKEditor->editor('description', stripslashes($auction_data['description'])),
		'CURRENT_BID' => $system->print_money_nosymbol($auction_data['current_bid']),
		'MIN_BID' => $system->print_money_nosymbol($auction_data['minimum_bid']),
		'QTY' => $auction_data['quantity'],
		'PAYMENTS' => $payment_methods,
		'ATYPE' => $TPL_auction_type,
		'FREEITEM_Y' => ($auction_data['sell_type'] == 'free') ? 'checked="checked"' : '',
		'FREEITEM_N' => ($auction_data['sell_type'] == 'sell') ? 'checked="checked"' : '',

		'SHIPPING_COST' => $system->print_money_nosymbol($auction_data['shipping_cost']),
		'RESERVE' => $system->print_money_nosymbol($auction_data['reserve_price']),
		'BN_ONLY_Y' => ($auction_data['bn_only'] == 'y') ? 'checked' : '',
		'BN_ONLY_N' => ($auction_data['bn_only'] == 'y') ? '' : 'checked',
		'BN_PRICE' => $system->print_money_nosymbol($auction_data['buy_now']),
		'CUSTOM_INC' => ($auction_data['increment'] > 0) ? $system->print_money_nosymbol($auction_data['increment']) : '',
		'SHIPPING1' => ($auction_data['shipping'] == 1 || empty($auction_data['shipping'])) ? 'checked' : '',
		'SHIPPING2' => ($auction_data['shipping'] == 2) ? 'checked' : '',
		'INTERNATIONAL' => (!empty($auction_data['international'])) ? 'checked' : '',
		'SHIPPING_TERMS' => $auction_data['shipping_terms'],
		'IS_BOLD' => ($auction_data['bold'] == 'y') ? 'checked' : '',
		'IS_HIGHLIGHTED' => ($auction_data['highlighted'] == 'y') ? 'checked' : '',
		'IS_FEATURED' => ($auction_data['featured'] == 'y') ? 'checked' : '',
		'SUSPENDED' => ($auction_data['suspended'] == 0) ? $MSG['029'] : $MSG['030'],
		'ITEM_CONDITION'=> $TPL_item_condition_list,
		'ITEM_MANUFACTURER'=> $auction_data['item_manufacturer'],
        'ITEM_MODEL'=>   $auction_data['item_model'],
        'ITEM_COLOR'=> $auction_data['item_color'],
        'ITEM_YEAR' =>  $auction_data['item_year'],
		'RETURNS' => (intval($auction_data['returns'] == 1)) ? 'checked' : '',
		
		'B_CONDITION'=> ($system->SETTINGS['item_conditions'] == 'y'),
		'B_CANRELIST' => $canrelist,
		'B_CLOSE' => $close,
		'B_MKFEATURED' => ($system->SETTINGS['ao_hpf_enabled'] == 'y'),
		'B_MKBOLD' => ($system->SETTINGS['ao_bi_enabled'] == 'y'),
		'PAGENAME' => $MSG['512'],
		'PAGETITLE' => $MSG['512'],
		'B_MKHIGHLIGHT' => ($system->SETTINGS['ao_hi_enabled'] == 'y')
));
include 'adminHeader.php';
$template->set_filenames(array(
	'body' => 'editauction.tpl'
));
$template->display('body');
include 'adminFooter.php';