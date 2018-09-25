<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/



include 'common.php';

include INCLUDE_PATH . 'membertypes.inc.php';



foreach ($membertypes as $idm => $memtypearr)

{

	$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;

}



ksort($memtypesarr, SORT_NUMERIC);

$NOW = $system->CTIME;



if (isset($_REQUEST['auction_id']))

{

	$_SESSION['CURRENT_ITEM'] = intval($_REQUEST['auction_id']);

}



$auction_id = isset($_SESSION['CURRENT_ITEM']) ? $_SESSION['CURRENT_ITEM'] : false;

$pg = (empty($_REQUEST['pg'])) ? 1 : $_REQUEST['pg'];

$ws = (isset($_GET['ws'])) ? $_GET['ws'] : 'w';



if (isset($_POST['addfeedback'])) // submit the feedback

{

	if (!$user->checkAuth())

	{

		header('location: user_login.php');

		exit;

	}



	if (((isset($_POST['TPL_password']) && $system->SETTINGS['usersauth'] == 'y') || $system->SETTINGS['usersauth'] == 'n') && isset($_POST['TPL_rate']) && isset($_POST['TPL_feedback']) && !empty($_POST['TPL_feedback']))

	{

		$query = "SELECT winner, seller, feedback_win, feedback_sel, paid FROM " . $DBPrefix . "winners

				WHERE auction = :auc_id

				AND winner = :winner_id AND seller = :seller_id

				AND ((seller = :user_id AND feedback_sel = :sel)

				OR (winner = :login_id AND feedback_win = :win))";

		$params = array(

			array(':auc_id', $auction_id, 'int'),

			array(':winner_id', intval($_REQUEST['wid']), 'int'),

			array(':seller_id', intval($_REQUEST['sid']), 'int'),

			array(':user_id', $user->user_data['id'], 'int'),

			array(':sel', 0, 'int'),

			array(':login_id', $user->user_data['id'], 'int'),

			array(':win', 0, 'int')

		);

		$db->query($query, $params);

		if ($db->numrows() > 0)

		{

			if ($user->user_data['nick'] != $_POST['TPL_nick_hidden'])

			{

				$wsell = $db->result();

				// winner/seller check

				$ws = ($user->user_data['id'] == $wsell['winner']) ? 'w' : 's';

				if ((intval($_REQUEST['sid']) == $user->user_data['id'] && $wsell['feedback_sel'] == 1) || (intval($_REQUEST['wid']) == $user->user_data['id'] && $wsell['feedback_win'] == 1))

				{

					$TPL_err = 1;

					$TPL_errmsg = $ERR['074'];

				}

				//elseif ((intval($_REQUEST['wid']) == $user->user_data['id'] && $wsell['paid'] == 1) || (intval($_REQUEST['sid']) == $user->user_data['id']))

				else

				{

					$check = $phpass->CheckPassword($_POST['TPL_password'], $user->user_data['password']);

					if ($system->SETTINGS['usersauth'] == 'n' || $check)

					{

						$secTPL_feedback = $system->cleanvars($_POST['TPL_feedback']);

						$uid = ($ws == 'w') ? $_REQUEST['sid'] : $_REQUEST['wid'];

						$query = "UPDATE " . $DBPrefix . "users SET rate_sum = rate_sum + :rate_sum, rate_num = rate_num + :rate_num WHERE id = :id";

						$params = array(

							array(':rate_sum', $_POST['TPL_rate'], 'int'),

							array(':rate_num', 1, 'int'),

							array(':id', intval($uid), 'int')

						);

						$db->query($query, $params);



						if ($system->SETTINGS['wordsfilter'] == 'y')

						{

							$secTPL_feedback = $system->filter($secTPL_feedback);

						}

						

						$query = "SELECT title FROM " . $DBPrefix . "auctions WHERE id = :auc_id LIMIT :limit";

						$params = array(

							array(':auc_id', $auction_id, 'int'),

							array(':limit', 1, 'int')

						);			

						$db->query($query, $params);

						$auc_title = $db->result('title');

						

						$query = "INSERT INTO " . $DBPrefix . "feedbacks (id, rated_user_id, rater_user_nick, feedback, rate, feedbackdate, auction_id, auction_title) VALUES (NULL, :uid, :user_id, :feedback, :rate, :times, :auc_id, :auc_title)";

						$params = array(

							array(':uid', intval($uid), 'int'),

							array(':user_id', $user->user_data['nick'], 'int'),

							array(':feedback', $secTPL_feedback, 'int'),

							array(':rate', intval($_POST['TPL_rate']), 'int'),

							array(':times', $system->CTIME, 'int'),

							array(':auc_id', $auction_id, 'int'),

							array(':auc_title', $auc_title, 'str')

						);

						$db->query($query, $params);



						if ($ws == 's')

						{

							$sqlset = "feedback_sel = 1";

						}

						if ($ws == 'w')

						{

							$sqlset = "feedback_win = 1";

						}

						$query = "UPDATE " . $DBPrefix . "winners SET $sqlset WHERE auction = :auc_id AND winner = :winner AND seller = :seller";

						$params = array(

							array(':auc_id', $auction_id, 'int'),

							array(':winner', intval($_REQUEST['wid']), 'int'),

							array(':seller', intval($_REQUEST['sid']), 'int')

						);

						$db->query($query, $params);

						header ('location: feedback.php?faction=show&id=' . intval($uid));

						exit;

					}

					else

					{

						$TPL_err = 1;

						$TPL_errmsg = $ERR['101'];

					}

				}

				/*

				else

				{

					$TPL_err = 1;

					$TPL_errmsg = $ERR['705'];

				}*/

			}

			else

			{

				$TPL_err = 1;

				$TPL_errmsg = $ERR['103'];

			}

		}

		else

		{

			$TPL_err = 1;

			$TPL_errmsg = $ERR['704'];

		}

	}

	else

	{

		$TPL_err = 1;

		$TPL_errmsg = $ERR['104'];

	}

}



if ((isset($_GET['wid']) && isset($_GET['sid'])) || isset($TPL_err)) // gets user details

{

	$secid = ($ws == 'w') ? $_REQUEST['sid'] : $_REQUEST['wid'];

	if ($_REQUEST['sid'] == $user->user_data['id'])

	{

		$them = $_REQUEST['wid'];

		$sbmsg = $MSG['131'];

	}

	else

	{

		$them = $_REQUEST['sid'];

		$sbmsg = $MSG['125'];

	}



	$query = "SELECT title FROM " . $DBPrefix . "auctions WHERE id = :auc_id LIMIT :limit";

	$params = array(

		array(':auc_id', $auction_id, 'int'),

		array(':limit', 1, 'int')

	);

	$db->query($query, $params);

	$item_title = $db->result('title');

	

	$query = "SELECT nick, rate_sum, rate_num FROM " . $DBPrefix . "users WHERE id = :id";

	$params = array(

		array(':id', intval($secid), 'int')

	);					

	$db->query($query, $params);

	if ($db->numrows() > 0)

	{

		$arr = $db->result();

		$TPL_nick = $arr['nick'];

		$i = 0;

		foreach ($memtypesarr as $k => $l)

		{

			if ($k >= $arr['rate_sum'] || $i++ == (count($memtypesarr) - 1))

			{

				$TPL_rate_ratio_value = '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';

				break;

			}

		}

		$TPL_feedbacks_num = $arr['rate_num'];

		$TPL_feedbacks_sum = $arr['rate_sum'];

	}

	else

	{

		$TPL_err = 1;

		$TPL_errmsg = $ERR['105'];

	}

}



if (isset($_GET['faction']) && $_GET['faction'] == 'show')

{

	// determine limits for SQL query

	$secid = $_GET['id'];

	if ($pg == 0) $pg = 1;

	$left_limit = ($pg - 1) * $system->SETTINGS['perpage'];



	$query = "SELECT rate_sum, nick FROM " . $DBPrefix . "users WHERE id = :id";

	$params = array(

		array(':id', intval($secid), 'int')

	);					

	$db->query($query, $params);

	$hash = $db->result();

	$total = $hash['rate_sum'];

	$TPL_nick = $hash['nick'];

	$TPL_feedbacks_num = $total;

	// get number of pages

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



	$PAGES = ($TPL_feedbacks_num == 0) ? 1 : ceil($TPL_feedbacks_num / $system->SETTINGS['perpage']);

	

	$query = "SELECT f.*, a.title, u.id As uId, u.rate_num, u.rate_sum FROM " . $DBPrefix . "feedbacks f 

		LEFT JOIN " . $DBPrefix . "auctions a ON (a.id = f.auction_id) 

		LEFT JOIN " . $DBPrefix . "users u ON (u.nick = f.rater_user_nick) 

		WHERE rated_user_id = :id ORDER by feedbackdate DESC LIMIT :offset, :perpage";

	$params = array(

		array(':id', intval($secid), 'int'),

		array(':offset', $OFFSET, 'int'),

		array(':perpage', $system->SETTINGS['perpage'], 'int')

	);

				

	$db->query($query, $params);

	$i = 0;

	$feed_disp = array();

	while ($arrfeed = $db->result())

	{

		$j = 0;

		foreach ($memtypesarr as $k => $l)

		{

			if ($k >= $arrfeed['rate_sum'] || $j++ == (count($memtypesarr) - 1))

			{

				$usicon = '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';

				break;

			}

		}

		switch ($arrfeed['rate'])

		{

			case 1: $uimg = $system->SETTINGS['siteurl'] . 'images/positive.png';

				break;

			case - 1: $uimg = $system->SETTINGS['siteurl'] . 'images/negative.png';

				break;

			case 0 : $uimg = $system->SETTINGS['siteurl'] . 'images/neutral.png';

				break;

		}

		$template->assign_block_vars('fbs', array(

			'BGCOLOR' => (!($i % 2)) ? '' : 'class="alt-row"',

			'IMG' => $uimg,

			'USFLINK' => 'profile.php?user_id=' . $arrfeed['uId'] . '&auction_id=' . $arrfeed['auction_id'],

			'USERID' => $arrfeed['uId'],

			'USERNAME' => $arrfeed['rater_user_nick'],

			'USFEED' => $arrfeed['rate_sum'],

			'USICON' => (isset($usicon)) ? $usicon : '',

			'FBDATE' => $system->dateToTimestamp($arrfeed['feedbackdate']),

			'AUCTIONID' => $arrfeed['auction_id'],

			'AUCTIONURL' => ($arrfeed['title']) ? '<a href="' . $system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($arrfeed['title']) . '-' . $arrfeed['auction_id'] . '">' . $arrfeed['title'] . '</a>' : $arrfeed['auction_title'],

			'FEEDBACK' => nl2br(stripslashes($arrfeed['feedback']))

		));

		$i++;

	}

}



// Calls the appropriate templates/templates

if ((isset($TPL_err) && !empty($TPL_err)) || !isset($_GET['faction']))

{

	$template->assign_vars(array(

			'ERROR' => (isset($TPL_errmsg)) ? $TPL_errmsg : '',

			'USERNICK' => (isset($TPL_nick)) ? $TPL_nick : '',

			'USERFB' => (isset($TPL_feedbacks_sum)) ? $TPL_feedbacks_sum : '',

			'USERFBIMG' => (isset($TPL_rate_ratio_value)) ? $TPL_rate_ratio_value : '',

			'AUCT_ID' => $auction_id,

			'AUCT_TITLE' => $item_title,

			'WID' => $_GET['wid'],

			'SID' => $_GET['sid'],

			'SEO_TITLE' => generate_seo_link($item_title),

			'WS' => $ws,

			'CFEEDBACK' => (isset($secTPL_feedback)) ? $secTPL_feedback : '',

			'RATE1' => (!isset($_POST['TPL_rate']) || $_POST['TPL_rate'] == 1) ? ' checked="true"' : '',

			'RATE2' => (isset($_POST['TPL_rate']) && $_POST['TPL_rate'] == 0) ? ' checked="true"' : '',

			'RATE3' => (isset($_POST['TPL_rate']) && $_POST['TPL_rate'] == -1) ? ' checked="true"' : '',

			'SBMSG' => $sbmsg,

			'THEM' => $them,

			'ACTIVEACCOUNTTAB' => 'class="active"',

			'ACTIVELEAVEFEEDBACK' => 'class="active"',

			'ACTIVEACCOUNTPANEL' => 'active',

			'B_USERAUTH' => ($system->SETTINGS['usersauth'] == 'y'),

			'BACK_TO_AUCTION' => $system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($item_title) . '-' . $auction_id,

			));

	include 'header.php';

	$template->set_filenames(array(

			'body' => 'feedback.tpl'

			));

	$template->display('body');

	include 'footer.php';

}



if (isset($_GET['faction']) && $_GET['faction'] == 'show')

{

	$query = "SELECT title FROM " . $DBPrefix . "auctions WHERE id = :auc_id";

	$params = array(

		array(':auc_id', intval($auction_id), 'int')

	);				

	$db->query($query, $params);

	$title = $db->result('title');



	$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :id";

	$params = array(

		array(':id', intval($_REQUEST['id']), 'int')

	);			

	$db->query($query, $params);

	if ($arr = $db->result())

	{

		$TPL_rate_ratio_value = '';

		foreach ($memtypesarr as $k => $l)

		{

			if ($k >= $arr['rate_sum'] || $i++ == (count($memtypesarr) - 1))

			{

				$TPL_rate_ratio_value = '<img src="' . $system->SETTINGS['siteurl'] . 'images/icons/' . $l['icon'] . '" alt="' . $l['icon'] . '" class="fbstar">';

				break;

			}

		}

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

					'PAGE' => ($PAGE == $COUNTER) ? '<li class="disabled"><a href="#">' . $COUNTER . '</a></li>' : '<li><a href="' . $system->SETTINGS['siteurl'] . 'feedback.php?id=' . $_REQUEST['id'] . '&faction=show&PAGE=' . $COUNTER . '">' . $COUNTER . '</a></li>'

					));

			$COUNTER++;

		}

	}



	$template->assign_vars(array(

		'USERNICK' => $TPL_nick,

		'USERFB' => $TPL_feedbacks_num,

		'BACK_TO_AUCTION' => $system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($title) . '-' . $auction_id,

		'USERFBIMG' => (isset($TPL_rate_ratio_value)) ? $TPL_rate_ratio_value : '',

		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'feedback.php?id=' . $_REQUEST['id'] . '&faction=show&PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',

		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'feedback.php?id=' . $_REQUEST['id'] . '&faction=show&PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',

		'PAGE' => $PAGE,

		'PAGES' => $PAGES,

		'AUCT_ID' => $auction_id,

		'B_FB_LINK' => 'IndexFBLogin',

		'ID' => $_REQUEST['id'],

		'ACTIVEACCOUNTTAB' => 'class="active"',

		'ACTIVELEAVEFEEDBACK' => 'class="active"',

		'ACTIVEACCOUNTPANEL' => 'active'

	));

	include 'header.php';

	$template->set_filenames(array(

			'body' => 'show_feedback.tpl'

			));

	$template->display('body');

	include 'footer.php';

}