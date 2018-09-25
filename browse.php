<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/



include 'common.php';

$catscontrol = new MPTTcategories();



// Get parameters from the URL

$get_name = $_GET['id'] ;  // get the full product name

$get_array = explode('-',$get_name) ;  // split the product name into segments and put into an array (product id must be separated by '-' )

$get_id = end($get_array) ; // extract the last array i.e product id form full product name

// Get parameters from the URL

$id = (isset($get_id)) ? intval($get_id) : 0; //OLD -> $id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;

$_SESSION['browse_id'] = $id;

$all_items = true;

$params = array();



$checkSort = isset($_SESSION['sortAuctions']) ? $_SESSION['sortAuctions'] : '';

$_SESSION['sortAuctions'] = isset($_POST['sortAuctions']) ? $_POST['sortAuctions'] : $checkSort;



$checkFilter = isset($_SESSION['filterAuctions']) ? $_SESSION['filterAuctions'] : '';

$_SESSION['filterAuctions'] = isset($_POST['filterAuctions']) ? $_POST['filterAuctions'] : $checkFilter;

	

if ($id != 0)

{

	$query = "SELECT right_id, left_id FROM " . $DBPrefix . "categories WHERE cat_id = " . $id;

	$params[] = array(':id', $id, 'int');

}

else

{

	$query = "SELECT right_id, left_id, cat_id FROM " . $DBPrefix . "categories WHERE left_id = :one";

	$params[] = array(':one', 1, 'int');

}

$db->query($query, $params);

$parent_node = $db->result();

$id = (isset($parent_node['cat_id'])) ? $parent_node['cat_id'] : $id;

$catalist = '';

if ($parent_node['left_id'] != 1)

{

	$children = $catscontrol->get_children_list($parent_node['left_id'], $parent_node['right_id']);

	$childarray = array($id);

	foreach ($children as $k => $v)

	{

		$childarray[] = $v['cat_id'];

	}

	$catalist = '(';

	$catalist .= implode(',', $childarray);

	$catalist .= ')';

	$all_items = false;

}



$NOW = $system->CTIME;



/*

specified category number

look into table - and if we don't have such category - redirect to full list

*/

$query = "SELECT * FROM " . $DBPrefix . "categories WHERE cat_id = " . $id;

$params = array(

	array(':id', $id, 'int')

);

$db->query($query, $params);

$category = $db->result();

if ($db->numrows() == 0)

{

	// redirect to global categories list

	header ('location: cat/all-categories-0');

	exit;

}

else

{

	// Retrieve the translated category name

	$par_id = $category['parent_id'];

	$TPL_categories_string = '';

	$crumbs = $catscontrol->get_bread_crumbs($category['left_id'], $category['right_id']);

	for ($i = 0; $i < count($crumbs); $i++)

	{

		if ($crumbs[$i]['cat_id'] > 0)

		{

			$TPL_categories_string .= '<li><a href="' . $system->SETTINGS['siteurl'] . 'cat/'. generate_seo_link($category_names[$crumbs[$i]['cat_id']]) .'-' . $crumbs[$i]['cat_id'] . '">' . $category_names[$crumbs[$i]['cat_id']] . '</a></li>';

			$current_cat_name = $category_names[$crumbs[$i]['cat_id']];

		}

	}

	if ($system->SETTINGS['catsorting'] == 'alpha')

	{

		$catsorting = ' ORDER BY cat_name ASC';

	}

	else

	{

		$catsorting = ' ORDER BY sub_counter DESC';

	}

	

	$query = "SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id = :one";

	$params = array(

		array(':one', -1, 'int')

	);

	$db->query($query, $params);

	$parent_ids = $db->result();

	

	$query = "SELECT * FROM " . $DBPrefix . "categories WHERE parent_id = :parent_ids" . $catsorting . " LIMIT :catstoshow";

	$params = array(

		array(':parent_ids', $parent_ids, 'int'),

		array(':catstoshow', $system->SETTINGS['catstoshow'], 'int')

	);

	$db->query($query, $params);

	

	while ($row = $db->result())

	{

		$template->assign_block_vars('cat_list_drop', array(

				'CATAUCNUM' => ($row['sub_counter'] != 0) ? '(' . $row['sub_counter'] . ')' : '',

				'ID' => $row['cat_id'],

				'IMAGE' => (!empty($row['cat_image'])) ? '<img src="' . $row['cat_image'] . '" border=0>' : '',

				'COLOR' => (empty($row['cat_color'])) ? '#FFFFFF' : $row['cat_color'],

				'NAME' => $category_names[$row['cat_id']]

				));

	}



	// get list of subcategories of this category

	$subcat_count = 0;

	$query = "SELECT * FROM " . $DBPrefix . "categories WHERE parent_id = :id ORDER BY cat_name";

	$params = array(

		array(':id', $id, 'int')

	);

	$db->query($query, $params);

	$need_to_continue = 1;

	$cycle = 1;



	$TPL_main_value = '';

	while ($row = $db->result())

	{

		++$subcat_count;

		if ($cycle == 1)

		{

			$TPL_main_value .= '<div class="col-sm-3">' . "\n";

		}

		$sub_counter = $row['sub_counter'];

		$cat_counter = $row['counter'];

		if ($sub_counter != 0 && $system->SETTINGS['cat_counters'] == 'y')

		{

			$count_string = ' <span class="label label-success">' . $sub_counter . '</span>';

			

		}

		else

		{

			if ($cat_counter != 0 && $system->SETTINGS['cat_counters'] == 'y')

			{

				$count_string = ' <span class="label label-success">' . $cat_counter . '</span>';

			}

			else

			{

				$count_string = '';

			}

		}

		if ($row['cat_color'] != '')

		{

			$BG = '<div class="success">';

		}

		else

		{

			$BG = '<div>';

		}

		// Retrieve the translated category name

		$row['cat_name'] = $category_names[$row['cat_id']];

		$catimage = (!empty($row['cat_image'])) ? '<img src="' . $row['cat_image'] . '" border=0>' : '';

		$TPL_main_value .= "\t" . $BG . $catimage . '<a href="' . $system->SETTINGS['siteurl'] . 'cat/'. generate_seo_link($row['cat_name']) .'-'. $row['cat_id'] .'">' . $row['cat_name'] . $count_string . '</a></div>' . "\n";



		++$cycle;

		if ($cycle == 4)

		{

			$cycle = 1;

			$TPL_main_value .= '</div>' . "\n";

		}

	}



	if ($cycle >= 2 && $cycle <= 3)

	{

		while ($cycle < 4)

		{

			$TPL_main_value .= '	<div>&nbsp;</div>' . "\n";

			++$cycle;

		}

		$TPL_main_value .= '</div>' . "\n";

	}



	$insql = "(category IN " . $catalist;

	if ($system->SETTINGS['extra_cat'] == 'y')

	{

		$insql .= " OR secondcat IN " . $catalist;

	}

	$insql = (!$all_items) ? $insql . ") AND" : '';



	// get total number of records

	$query = "SELECT id FROM " . $DBPrefix . "auctions

	WHERE " . $insql . " starts <= :start AND closed = 0 AND suspended = 0";

	$params = array();

	if (!empty($_POST['catkeyword']))

	{

		$query .= " AND title LIKE :title";

		$params[] = array(':title', '%' . $system->cleanvars($_POST['catkeyword']) . '%', 'str');

	}

	$params[] = array(':start', $NOW, 'int');

	$db->query($query, $params);	

	$TOTALAUCTIONS = $db->numrows('id');



	// Handle pagination

	if (!isset($_GET['PAGE']) || $_GET['PAGE'] <= 1 || $_GET['PAGE'] == '')

	{

		$OFFSET = 0;

		$PAGE = 1;

	}

	else

	{

		$PAGE = intval($_GET['PAGE']);

		$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];

	}

	$PAGES = ($TOTALAUCTIONS == 0) ? 1 : ceil($TOTALAUCTIONS / $system->SETTINGS['perpage']);

	

	switch ($_SESSION['sortAuctions'])

	{

		case 'low':

			$sortingSQL = ' ORDER BY minimum_bid ASC';

			$sortLow = 'selected';

		break;

		case 'high':

			$sortingSQL = ' ORDER BY minimum_bid DESC';

			$sortHigh = 'selected';

		break;

		case 'lowBuyNow':

			$sortingSQL = ' ORDER BY buy_now ASC';

			$sortLowBuyNow = 'selected';

		break;

		case 'highBuyNow':

			$sortingSQL = ' ORDER BY buy_now DESC';

			$sortHighBuyNow = 'selected';

		break;

		case 'mostBids':

			$sortingSQL = ' ORDER BY num_bids ASC';

			$sortBids = 'selected';

		break;

		case 'newAuctions':

			$sortingSQL = ' ORDER BY ends DESC';

			$sortNew = 'selected';

		break;

		case 'closingAuctions':

			$sortingSQL = ' ORDER BY ends ASC';

			$sortEnd = 'selected';

		break;

		case 'lowShipping':

			$lowshipping = 'selected';

			$sqlFilter = ' ORDER BY shipping_cost ASC';

		break;

		case 'highShipping':

			$highshipping = 'selected';

			$sqlFilter = ' ORDER BY shipping_cost DESC';

		break;

		default :

			$sortingSQL = ' ORDER BY ends ASC';

			$sortEnd = 'selected';

		break;

	}

	

	switch ($_SESSION['filterAuctions'])

	{

		case 'filterAll':

			$filterAll = 'selected';

			$sqlFilter = '';

		break;

		case 'filterBuyNow':

			$filterBuyNow = 'selected';

			$sqlFilter = ' AND buy_now > "0.00" ';

		break;

		case 'filterFreeShipping':

			$filterFreeShipping = 'selected';

			$sqlFilter = ' AND shipping = 1 ';

		break;

		case 'filterDigitalItem':

			$filterDigitalItem = 'selected';

			$sqlFilter = ' AND auction_type = 3 ';

		break;

		case 'filterstandard':

			$filterStandard = 'selected';

			$sqlFilter = ' AND auction_type = 1 ';

		break;

		case 'filterdutch':

			$filterDutch = 'selected';

			$sqlFilter = ' AND auction_type = 2 ';

		break;

		default:

			$filterAll = 'selected';

			$sqlFilter = '';

		break;

	}

	

	// get normal auctions

	$query = "SELECT * FROM " . $DBPrefix . "auctions WHERE " . $insql . " starts <= :times AND closed = 0 AND suspended = 0";

	$params = array();

	$params[] = array(':times', $NOW, 'int');

	if (!empty($_POST['catkeyword']))

	{

		$query .= " AND title LIKE :title";

		$params[] = array(':title', '%' . $system->cleanvars($_POST['catkeyword']) . '%', 'str');

	}

	$query .= $sqlFilter . $sortingSQL . " LIMIT :offset, :perpage";

	$params[] = array(':offset', $OFFSET, 'int');

	$params[] = array(':perpage', $system->SETTINGS['perpage'], 'int');

		

	// get featured items

	$query_feat = "SELECT * FROM " . $DBPrefix . "auctions WHERE " . $insql . " starts <= :times AND closed = 0 AND suspended = 0 AND featured = 'y'";

	$params_feat = array();

	$params_feat[] = array(':times', $NOW, 'int');

	if (!empty($_POST['catkeyword']))

	{

		$query_feat .= " AND title LIKE :title";

		$params_feat[] = array(':title', '%' . $system->cleanvars($_POST['catkeyword']) . '%', 'str');

	}

	$query_feat .= $sqlFilter . $sortingSQL . " LIMIT :offset, :perpage";

	$params_feat[] = array(':offset', $OFFSET, 'int');

	$params_feat[] = array(':perpage', $system->SETTINGS['perpage'], 'int');



	include INCLUDE_PATH . 'browseitems.inc.php';

	browseItems($query, $params, $query_feat, $params_feat, $TOTALAUCTIONS, 'browse.php', 'id=' . $id);

	$page_title = $current_cat_name;

	$template->assign_vars(array(

		'ID' => $id,

		'B_FB_LINK' => 'IndexFBLogin',

		'TOP_HTML' => $TPL_main_value,

		'CAT_STRING' => $TPL_categories_string,

		'CUR_CAT' => $current_cat_name,

		'ORDERCOL' => isset($_SESSION['oa_ord']) ? $_SESSION['oa_ord'] : '',

		'B_FB_LINK' => !$user->checkAuth() ? 'IndexFBLogin' : '',

        'ORDERNEXT' => isset($_SESSION['oa_nexttype']) ? $_SESSION['oa_nexttype'] : '',

        'ORDERTYPEIMG' => isset($_SESSION['oa_type_img']) ? $_SESSION['oa_type_img'] : '',

		'NUM_AUCTIONS' => $TOTALAUCTIONS,

		'SORTLOW' => (isset($sortLow)) ? $sortLow : '',

		'SORTHIGH' => (isset($sortHigh)) ? $sortHigh : '',

		'SORTLOWBUYNOW' => (isset($sortLowBuyNow)) ? $sortLowBuyNow : '',

		'SORTHIGHBUYNOW' => (isset($sortHighBuyNow)) ? $sortHighBuyNow : '',

		'SORTLOWESTSHIPPING' => (isset($lowshipping)) ? $lowshipping : '',

		'SORTHIGHESTSHIPPING' => (isset($highshipping)) ? $highshipping : '',

		'SORTBIDS' => (isset($sortBids)) ? $sortBids : '',

		'SORTNEW' => (isset($sortNew)) ? $sortNew : '',

		'SORTEND' => (isset($sortEnd)) ? $sortEnd : '',

		'FILTERALL' => (isset($filterAll)) ? $filterAll : '',

		'FILTERBUYNOW' => (isset($filterBuyNow)) ? $filterBuyNow : '',

		'FILTERSTANDARD' => (isset($filterStandard)) ? $filterStandard : '',

		'FILTERDUTCH' => (isset($filterDutch)) ? $filterDutch : '',

		'FILTERFREESHIPPING' => (isset($filterFreeShipping)) ? $filterFreeShipping : '',

		'B_DIGITALITEM' => $system->SETTINGS['digital_auctions'] == 'y' ? true : false,

		'FILTERDIGITALITEM' => (isset($filterDigitalItem)) ? $filterDigitalItem : '',

		'B_STANDARDAUCTION' => $system->SETTINGS['standard_auctions'] == 'y' ? true : false,

		'B_DUTCHAUCTION' => $system->SETTINGS['dutch_auctions'] == 'y' ? true : false,

	));

}



include 'header.php';

$template->set_filenames(array(

		'body' => 'browsecats.tpl'

		));

$template->display('body');

include 'footer.php';

