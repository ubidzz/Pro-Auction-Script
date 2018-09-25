<?php/******************************************************************************* *   copyright				: (C) 2014 - 2018 Pro-Auction-Script *   site					: https://www.pro-auction-script.com *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license *******************************************************************************/include 'common.php';// Run cron according to SETTINGS as non-batchif ($system->SETTINGS['cron'] == 2){	include_once 'cron.php';}$fb_return_page = 'home';$_SESSION['REDIRECT_AFTER_LOGIN'] = 'home';$NOW = $system->CTIME;// prepare categories list for templates/template// Prepare categories sortingif ($system->SETTINGS['catsorting'] == 'alpha'){	$catsorting = 'ORDER BY cat_name ASC';}else{	$catsorting = 'ORDER BY sub_counter DESC';}$query = "SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id = :parent_id";$params = array(	array(':parent_id', -1, 'int'));$db->query($query, $params);$cate_ids = $db->result('cat_id');$query = "SELECT * FROM " . $DBPrefix . "categories WHERE parent_id = :cateids " . $catsorting . " LIMIT :catsshows";$params = array(	array(':cateids', $cate_ids, 'int'),	array(':catsshows', $system->SETTINGS['catstoshow'], 'int'));$db->query($query, $params);while ($row = $db->result()){	$sub_counter = $row['sub_counter'];	$cat_counter = $row['counter'];		if ($sub_counter > 0 && $system->SETTINGS['cat_counters'] == 'y')	{		$count_string = ' (' . $sub_counter . ')';		}	else	{		$count_string = '';	}	$template->assign_block_vars('cat_list', array(			'CATAUCNUM' => ($row['sub_counter'] != 0) ? '(' . $row['sub_counter'] . ')' : '',			'ID' => $row['cat_id'],			'SEO_NAME' => generate_seo_link($category_names[$row['cat_id']]),			'IMAGE' => (!empty($row['cat_image'])) ? '<img src="' . $row['cat_image'] . '" border=0>' : '',			'COLOR' => (empty($row['cat_color'])) ? '#FFFFFF' : $row['cat_color'],			'NAME' => $category_names[$row['cat_id']] . ' ' . $count_string			));}// get featured items$query = "SELECT id, title, current_bid, pict_url, ends, num_bids, minimum_bid, bn_only, buy_now, sell_type        FROM " . $DBPrefix . "auctions         WHERE closed = 0 AND suspended = 0 AND starts <= :now AND featured = :yes ORDER BY RAND() DESC LIMIT :limit";$params = array( 	array(':now', $NOW, 'int'),	array(':yes', 'y', 'str'),	array(':limit', $system->SETTINGS['featurednumber'], 'int'));$db->query($query, $params);$i = 0;while($row = $db->result()){	$ends = $row['ends'];	$difference = $ends - $system->CTIME;	if ($difference > 0)	{		$ends_string = $system->FormatTimeLeft($difference);	}	else	{		$ends_string = $MSG['911'];	}	if($row['sell_type'] == 'free')	{		$high_bid = $MSG['3500_1015745'];	}else{		$high_bid = ($row['num_bids'] == 0) ? $row['minimum_bid'] : $row['current_bid'];		$high_bid = ($row['bn_only'] == 'y') ? $system->print_money($row['buy_now']) : $system->print_money($high_bid);	}	$template->assign_block_vars('featured', array(			'ENDS' => $ends_string,			'ID' => $row['id'],			'SEO_TITLE' => generate_seo_link($row['title']),			'BID' => $high_bid,			'IMAGE' => (!empty($row['pict_url'])) ? $system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $system->SETTINGS['thumb_list'] . '&fromfile=' . $security->encrypt($row['id'] . '/' . $row['pict_url'], true) : 'images/email_alerts/default_item_img.jpg',			'TITLE' => $row['title']			));	$i++;}$featured_items = ($i > 0) ? true : false;// get last created auctions$query = "SELECT id, title,pict_url, starts from " . $DBPrefix . "auctions WHERE closed = 0 AND suspended = 0 AND starts <= :now ORDER BY starts DESC LIMIT :limit";$params = array(	array(':now', $NOW, 'int'),	array(':limit', $system->SETTINGS['lastitemsnumber'], 'int'));$db->query($query, $params);$i = 0;while ($row = $db->result()){	$date = $row['starts'] + $system->TDIFF;	$template->assign_block_vars('auc_last', array(			'BGCOLOR' => (!($i % 2)) ? '' : 'class="alt-row"',			'DATE' => $system->ArrangeDateAndTime($row['starts']),			'ID' => $row['id'],			'SEO_TITLE' => generate_seo_link($row['title']),			'IMAGE' => (!empty($row['pict_url'])) ? $system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $system->SETTINGS['thumb_list'] . '&fromfile=' . $security->encrypt($row['id'] . '/' . $row['pict_url'], true) : 'images/email_alerts/default_item_img.jpg',			'TITLE' => $row['title']			));	$i++;}$auc_last = ($i > 0) ? true : false;// get ending soon auctions$query = "SELECT ends, id, title, pict_url FROM " . $DBPrefix . "auctionsWHERE closed = 0 AND suspended = 0 AND starts <= :now ORDER BY ends LIMIT :limit";$params = array(	array(':now', $NOW, 'int'),	array(':limit', $system->SETTINGS['endingsoonnumber'], 'int'));$db->query($query, $params);$i = 0;while ($row = $db->result()){	$difference = $row['ends'] - $system->CTIME;	if ($difference > 0)	{		$ends_string = $system->FormatTimeLeft($difference);	}	else	{		$ends_string = $MSG['911'];	}	$template->assign_block_vars('end_soon', array(			'BGCOLOR' => (!($i % 2)) ? '' : 'class="alt-row"',			'DATE' => $ends_string,			'ID' => $row['id'],			'SEO_TITLE' => generate_seo_link($row['title']),			'IMAGE' => (!empty($row['pict_url'])) ? $system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $system->SETTINGS['thumb_list'] . '&fromfile=' . $security->encrypt($row['id'] . '/' . $row['pict_url'], true) : 'images/email_alerts/default_item_img.jpg',			'TITLE' => $row['title']			));	$i++;}$end_soon = ($i > 0) ? true : false;// get hot items$query = "SELECT a.id, a.title, a.current_bid, a.pict_url, a.ends, a.num_bids, a.minimum_bid, a.bn_only, a.buy_now, a.sell_type         FROM " . $DBPrefix . "auctions a         LEFT JOIN " . $DBPrefix . "auccounter c ON (a.id = c.auction_id)         WHERE closed = 0 AND suspended = 0 AND starts <= :now ORDER BY c.counter DESC LIMIT :limit";$params = array(  	array(':now', $NOW, 'int'),	array(':limit', $system->SETTINGS['hotitemsnumber'], 'int'));$db->query($query, $params);$i = 0;while ($row = $db->result()){	$i++;	$ends = $row['ends'];    $difference = $ends - $system->CTIME;    if ($difference > 0)	{        $ends_string = $system->FormatTimeLeft($difference);     }	else	{        $ends_string = $MSG['911'];    }    if($row['sell_type'] == 'free')	{		$high_bid = $MSG['3500_1015745'];	}else{		$high_bid = ($row['num_bids'] == 0) ? $row['minimum_bid'] : $row['current_bid'];		$high_bid = ($row['bn_only'] == 'y') ? $system->print_money($row['buy_now']) : $system->print_money($high_bid);	}    $template->assign_block_vars('hotitems', array(            'ENDS' => $ends_string,            'ID' => $row['id'],            'SEO_TITLE' => generate_seo_link($row['title']),            'BID' => $high_bid,            'IMAGE' => (!empty($row['pict_url'])) ? $system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $system->SETTINGS['thumb_list'] . '&fromfile=' . $security->encrypt($row['id'] . '/' . $row['pict_url'], true) : 'images/email_alerts/default_item_img.jpg',            'TITLE' => $row['title']            ));}$hot_items = ($i > 0) ? true : false;// Build news list$query = "SELECT n.title As t, n.new_date, t.* FROM " . $DBPrefix . "news nLEFT JOIN " . $DBPrefix . "news_translated t ON (t.id = n.id)WHERE t.lang = :languages AND n.suspended = :zero ORDER BY new_date DESC, id DESC LIMIT :limit";$params = array(	array(':languages', $language, 'str'),	array(':zero', 0, 'int'),	array(':limit', $system->SETTINGS['newstoshow'], 'int'));$db->query($query, $params);$i = 0;while ($new = $db->result()){	$template->assign_block_vars('newsbox', array(		'ID' => $new['id'],		'DATE' => $system->dateToTimestamp($new['new_date']),		'SEO_TITLE' => generate_seo_link($new['title']),		'TITLE' => (!empty($new['title'])) ? $new['title'] : $new['t']		));	$i++;}$newsbox = ($i > 0) ? true : false;$template->assign_vars(array(		'B_FB_LINK' => 'IndexFacebookLogin',		'B_FEATU_ITEMS' => $featured_items,		'B_AUC_LAST' => $auc_last,		'B_HOT_ITEMS' => $hot_items,		'B_AUC_ENDSOON' => $end_soon,		'B_LOGIN_BOX' => ($system->SETTINGS['loginbox'] == 1),		'B_NEWS_BOX' => ($newsbox && $system->SETTINGS['newsbox'] == 1)		));include 'header.php';$template->set_filenames(array(		'body' => 'home.tpl'		));$template->display('body');include 'footer.php';unset($_SESSION['loginerror']);