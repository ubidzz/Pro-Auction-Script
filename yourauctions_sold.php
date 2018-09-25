<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/

include 'common.php';



// If user is not logged in redirect to login page

if (!$user->checkAuth())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'yourauctions_sold.php';

	header('location: user_login.php');

	exit;
}



$NOW = $system->CTIME;

$NOWB = date('Ymd');



function get_reminders($user_id, $id) 

{ 

	global $DBPrefix, $db;

	// get auctions sold item

	$query = "SELECT COUNT(DISTINCT a.id) AS total FROM " . $DBPrefix . "winners a

		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)

		WHERE b.id = :aid AND (b.closed = 1 OR b.bn_only = :only) AND a.seller = :sellers AND a.is_read = 0";

	$params = array(

		array(':aid', $id, 'int'),

		array(':only', 'y', 'str'),

		array(':sellers', $user_id, 'int')

	);

	$db->query($query, $params);

	$data0 = $db->result('total');

	if ($data0 > 0)

	{

		$data[] = $data0;

	}

	else

	{

		$data[] = 0;

	}

	// Count auctions still requiring payment

	$query = "SELECT COUNT(DISTINCT a.id) AS rq_total FROM " . $DBPrefix . "winners a

		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)

		WHERE b.id = a.auction AND b.id = :aid AND (b.closed = 1 OR b.bn_only = :only) AND a.seller = :sellers AND a.paid = 0";

	$params = array(

		array(':aid', $id, 'int'),

		array(':only', 'y', 'str'),

		array(':sellers', $user_id, 'int')

	);

	$db->query($query, $params);

	$data1 = $db->result('rq_total');

	if ($data1 > 0)

	{

		$data[] = $data1;

	}

	else

	{

		$data[] = 0;

	}

	// Count auctions received payment

	$query = "SELECT COUNT(DISTINCT a.id) AS rv_total FROM " . $DBPrefix . "winners a

		LEFT JOIN " . $DBPrefix . "auctions b ON (a.auction = b.id)

		WHERE b.id = :aid AND (b.closed = 1 OR b.bn_only = :bnonly) AND a.seller = :sellers AND a.paid = 1";

	$params = array(

		array(':aid', $id, 'int'),

		array(':bnonly', 'y', 'str'),

		array(':sellers', $user_id, 'int')

	);

	$db->query($query, $params);

	$data2 = $db->result('rv_total');

	if ($data2 > 0)

	{

		$data[] = $data2;

	}

	else

	{

		$data[] = 0;

	}

	return $data;

}

// Update

if (isset($_POST['action']) && $_POST['action'] == 'update')

{

	// Re-list auctions

	if (is_array($_POST['relist']))

	{

		foreach ($_POST['relist'] as $k)

		{

			$k = intval($k);

			$query = "SELECT duration, category FROM " . $DBPrefix . "auctions WHERE id = :auc_id";

			$params = array(

				array(':auc_id', $k, 'int')

			);

			$db->query($query, $params);

			$AUCTION = $db->result();



			// auction ends

			$WILLEND = $system->CTIME + ($AUCTION['duration'] * 24 * 60 * 60);

			$suspend = 0;



			if ($system->SETTINGS['fees'] == 'y')

			{

				if ($system->SETTINGS['fee_type'] == 1)

				{

					// charge relist fee

					$query = "UPDATE " . $DBPrefix . "users SET balance = balance - :fee WHERE id = :user_id";

					$params = array(

						array(':fee', $relist_fee, 'float'),

						array(':user_id', $relist_fee, 'int')

					);

					$db->query($query, $params);

				}

				else

				{

					$suspend = 8;

				}

			}



			$query = "UPDATE " . $DBPrefix . "auctions

				  SET starts = :now,

				  ends = :end,

				  closed = :close,

				  num_bids = :count_bid,

				  relisted = relisted + :relist,

				  current_bid = :bids,

				  sold = :item_sold,

				  suspended = :suspend

				  WHERE id = :auc_id";

			$params = array(

				array(':now', $NOW, 'int'),

				array(':end', $WILLEND, 'int'),

				array(':close', 0, 'int'),

				array(':count_bid', 0, 'int'),

				array(':relist', 1, 'int'),

				array(':bids', 0, 'int'),

				array(':item_sold', 'n', 'str'),

				array(':suspend', $suspend, 'int'),

				array(':auc_id', $k, 'int')

			);

			$db->query($query, $params);



			// Insert into relisted table

			$query = "INSERT INTO " . $DBPrefix . "closedrelisted VALUES (:auc_id, :now, :auct_ids)";

			$params = array(

				array(':auc_id', $k, 'int'),

				array(':now', $NOW, 'int'),

				array(':auct_ids', $k, 'int')

			);

			$db->query($query, $params);



			// delete bids

			$query = "DELETE FROM " . $DBPrefix . "bids WHERE auction = :auc_id";

			$params = array(

				array(':auc_id', $k, 'int')

			);

			$db->query($query, $params);



			// Proxy Bids

			$query = "DELETE FROM " . $DBPrefix . "proxybid WHERE itemid = :auc_id";

			$params = array(

				array(':auc_id', $k, 'int')

			);

			$db->query($query, $params);



			// Winners: only in case of reserve not reached

			$query = "DELETE FROM " . $DBPrefix . "winners WHERE auction = :auc_id";

			$params = array(

				array(':auc_id', $k, 'int')

			);

			$db->query($query, $params);



			// Update COUNTERS table

			$system->writesetting("counters", "auctions",  $system->COUNTERS['auctions'] + 1, 'int');



			$query = "SELECT left_id, right_id, level FROM " . $DBPrefix . "categories WHERE cat_id = :cat";

			$params = array(

				array(':cat', $AUCTION['category'], 'int')

			);

			$db->query($query, $params);

			

			$parent_node = $db->fetchall();

			$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

			// update recursive categories

			for ($i = 0; $i < count($crumbs); $i++)

			{

				$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + 1 WHERE cat_id = :cat";

				$params = array(

					array(':cat', $crumbs[$i]['cat_id'], 'int')

				);

				$db->query($query, $params);

			}

			if ($system->SETTINGS['fee_type'] == 2 && isset($relist_fee) && $relist_fee > 0)

			{

				header('location: pay.php?a=5');

				exit;

			}

		}

	}

}



// Retrieve closed auction data from the database

$query = "SELECT a.* FROM " . $DBPrefix . "auctions a, " . $DBPrefix . "winners w 

	WHERE a.user = :user_id AND a.suspended = 0 AND a.id = w.auction GROUP BY w.auction";

$params = array(

	array(':user_id', $user->user_data['id'], 'int')

);

$db->query($query, $params);

$TOTALAUCTIONS = $db->numrows();



if (!isset($_GET['PAGE']) || $_GET['PAGE'] < 0 || empty($_GET['PAGE']))

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



// Handle columns sorting variables

if (!isset($_SESSION['solda_ord']) && empty($_GET['solda_ord']))

{

	$_SESSION['solda_ord'] = 'title';

	$_SESSION['solda_type'] = 'asc';

}

elseif (!empty($_GET['solda_ord']))

{

	$_SESSION['solda_ord'] = $_GET['solda_ord'];

	$_SESSION['solda_type'] = $_GET['solda_type'];

}

elseif (isset($_SESSION['solda_ord']) && empty($_GET['solda_ord']))

{

	$_SESSION['solda_nexttype'] = $_SESSION['solda_type'];

}



if (!isset($_SESSION['solda_nexttype']) || $_SESSION['solda_nexttype'] == 'desc')

{

	$_SESSION['solda_nexttype'] = 'asc';

}

else

{

	$_SESSION['solda_nexttype'] = 'desc';

}



if (!isset($_SESSION['solda_type']) || $_SESSION['solda_type'] == 'desc')

{

	$_SESSION['solda_type_img'] = '<img src="images/arrow_up.gif" align="center" hspace="2" border="0" alt="up"/>';

}

else

{

	$_SESSION['solda_type_img'] = '<img src="images/arrow_down.gif" align="center" hspace="2" border="0" alt="down"/>';

}



$query = "SELECT a.id, a.title, a.starts, a.ends, a.current_bid, a.num_bids, a.closed 

	FROM " . $DBPrefix . "auctions a

	LEFT JOIN " . $DBPrefix . "winners w (a.user = w.seller)

	WHERE a.user = :user_id AND a.suspended = 0 AND w.auction = a.id 

	GROUP BY w.auction ORDER BY " . $_SESSION['solda_ord'] . " " . $_SESSION['solda_type'] . " 

	LIMIT :offset, :perpage";

$params = array(

	array(':user_id', $user->user_data['id'], 'int'),

	array(':offset', $OFFSET, 'int'),

	array(':perpage', $system->SETTINGS['perpage'], 'int')

);

$db->query($query, $params);



while ($item = $db->fetch())

{

	$get_reminders = $user->logged_in ? get_reminders($user->user_data['id'], $item['id']) : '';

	$template->assign_block_vars('items', array(

			'ID' => $item['id'],

			'TITLE' => $item['title'],

			'STARTS' => $system->dateToTimestamp($item['starts']),

			'ENDS' => $system->dateToTimestamp($item['ends']),

			'BID' => ($item['current_bid'] == 0) ? '-' : $system->print_money($item['current_bid']),

			'BIDS' => $item['num_bids'],

			'SEO_TITLE' => generate_seo_link($item['title']),

			'ITEM_SOLD' => ($get_reminders[0] > 0) ? ' <small><span class="label label-success">(' . $get_reminders[0] . ')&nbsp;&nbsp;' . $MSG['3500_1015412'] . ' </span></small> ' : '',

			'NO_PAYMENT' => ($get_reminders[1] > 0) ? ' <small><span class="label label-important">(' . $get_reminders[1] . ')&nbsp;&nbsp;' . $MSG['3500_1015410'] . ' </span></small> ' : '',

			'PAID' => ($get_reminders[2] > 0) ? ' <small><span class="label label-success">(' . $get_reminders[2] . ')&nbsp;&nbsp;' . $MSG['3500_1015411'] . ' </span></small> ' : '',

			'B_CLOSED' => ($item['closed'] == 1),

			'B_HASNOBIDS' => ($item['current_bid'] == 0),

	));

}



// get pagenation

$PREV = intval($PAGE - 1);

$NEXT = intval($PAGE + 1);

if ($PAGES > 1)

{

	$LOW = $PAGE - 5;

	if ($LOW <= 0) $LOW = 1;

	$COUNTER = $LOW;

	while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6))

	{

		$template->assign_block_vars('pages', array(

				'PAGE' => ($PAGE == $COUNTER) ? '<li class="disabled"><a href="#">' . $COUNTER . '</a></li>' : '<li><a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_sold.php?PAGE=' . $COUNTER . '&id=' . $id . '">' . $COUNTER . '</a></li>'

				));

		$COUNTER++;

	}

}



$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = :feeType";

$params = array(

	array(':feeType', 'relist_fee', 'int')

);

$db->query($query, $params);

$relistFee = $db->result();



$template->assign_vars(array(

	'ORDERCOL' => $_SESSION['solda_ord'],

	'ORDERNEXT' => $_SESSION['solda_nexttype'],

	'ORDERTYPEIMG' => $_SESSION['solda_type_img'],

	'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_sold.php?PAGE=' . $PREV . '&id=' . $id . '">' . $MSG['5119'] . '</a>' : '',

	'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'yourauctions_sold.php?PAGE=' . $NEXT . '&id=' . $id . '">' . $MSG['5120'] . '</a>' : '',

	'PAGE' => $PAGE,

	'PAGES' => $PAGES,

	'ACTIVESELLINGTAB' => 'class="active"',

	'ACTIVESOLDAUCTIONS' => 'class="active"',

	'ACTIVESELLINGPANEL' => 'active',

	'RELIST_FEE' => $system->input_money($relistFee['value'])

));



include 'header.php';

$template->set_filenames(array(

		'body' => 'yourauctions_sold.tpl'

		));

$template->display('body');

include 'footer.php';