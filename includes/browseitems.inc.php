<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');

function browseItems($query, $params, $query_feat, $params_feat, $total, $current_page, $extravar = '')
{
	global $system, $MSG, $ERR, $db;
	global $template, $PAGES, $PAGE;

	$feat_items = false;

	if ($query_feat != '')
	{
		$db->query($query_feat, $params_feat);
		$k = 0;
		while ($row = $db->result())
		{
			// get the data we need
			$row = build_items($row);

			// time left till the end of this auction
			$ends = $row['ends'];
			$difference = $ends - $system->CTIME;
			if ($difference > 0)
			{
				$ends_string = $system->FormatTimeLeft($difference);
			}
			else
			{
				$ends_string = $MSG['911'];
			}

			$bgcolor = ($k % 2) ? 'info' : '';
			$color = ($row['highlighted'] == 'y') ? 'success' : $bgcolor;
			$template->assign_block_vars('featured_items', array(
				'ID' => $row['id'],
				'ROWCOLOR' => $color,
				'IMAGE' => $row['pict_url'],
				'TITLE' => $row['title'],
				'SHIPPING_COST' => isset($auction_data['shipping_cost']) ? $system->print_money($auction_data['shipping_cost']) : '',
				'SUBTITLE' => $row['subtitle'],
				'SEO_TITLE' => generate_seo_link($row['title']),
				'BUY_NOW' => ($difference < 0) ? '' : $row['buy_now'],
				'BID' => $row['current_bid'],
				'BIDFORM' => $row['current_bid'],
				'SHIPPING_COST' => $system->print_money($row['shipping_cost']),
				'CLOSES' => $system->ArrangeDateAndTime($row['ends']),
				'NUMBIDS' => sprintf($MSG['950'], $row['num_bids']),
				'TIMELEFT' => $ends_string,
				'BUYNOWLOGO' => isset($row['buy_now_logo']) ? $row['buy_now_logo'] : '',
				'B_BOLD' => ($row['bold'] == 'y')
			));
			$k++;
			$feat_items = true;
		}
	}

	$db->query($query, $params);
	$k = 0;
	
	while ($row = $db->result())
	{
		// get the data we need
		$row = build_items($row);
		
		// time left till the end of this auction 
		$ends = $row['ends'];
		$difference = $ends - $system->CTIME;
		if ($difference > 0)
		{
			$ends_string = $system->FormatTimeLeft($difference);
		}
		else
		{
			$ends_string = $MSG['911'];
		}
		$bgcolor = ($k % 2) ? 'info' : '';
		$color = ($row['highlighted'] == 'y') ? 'success' : $bgcolor;
		$template->assign_block_vars('items', array(
			'ID' => $row['id'],
			'ROWCOLOR' => $color,
			'IMAGE' => $row['pict_url'],
			'TITLE' => $row['title'],
			'SUBTITLE' => $row['subtitle'],
			'BUY_NOW' => ($difference < 0) ? '' : $row['buy_now'],
			'BID' => $row['current_bid'],
			'SHIPPING_COST' => isset($auction_data['shipping_cost']) ? $system->print_money($auction_data['shipping_cost']) : '',
			'SEO_TITLE' => generate_seo_link($row['title']),
			'BIDFORM' => $row['current_bid'],
			'CLOSES' => $system->ArrangeDateAndTime($row['ends']),
			'SHIPPING_COST' => $system->print_money($row['shipping_cost']),
			'TIMELEFT' => $ends_string,
			'NUMBIDS' => sprintf($MSG['950'], $row['num_bids']),
			'BUYNOWLOGO' => isset($row['buy_now_logo']) ? $row['buy_now_logo'] : '',
			'B_BOLD' => ($row['bold'] == 'y')
		));
		$k++;
	}

	$extravar = (empty($extravar)) ? '' : '&' . $extravar;
	$PREV = intval($PAGE - 1);
	$NEXT = intval($PAGE + 1);
	if ($PAGES > 1)
	{
		$LOW = $PAGE - 5;
		if ($LOW <= 0) $LOW = 1;
		$COUNTER = $LOW;
		while ($COUNTER <= $PAGES && $COUNTER < ($PAGE+6))
		{
			$template->assign_block_vars('pages', array(
				'PAGE' => ($PAGE == $COUNTER) ? '<li class="active"><a href="#">' . $COUNTER . '</a></li>' : '<a href="' . $system->SETTINGS['siteurl'] . $current_page . '?PAGE=' . $COUNTER . $extravar . '">' . $COUNTER . '</a>'
			));
			$COUNTER++;
		}
	}

	$template->assign_vars(array(
		'B_FEATURED_ITEMS' => $feat_items,
		'B_SUBTITLE' => ($system->SETTINGS['subtitle'] == 'y'),

		'NUM_AUCTIONS' => ($total == 0) ? $ERR['114'] : $total,
		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . $current_page . '?PAGE=' . $PREV . $extravar . '">' . $MSG['5119'] . '</a>' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . $current_page . '?PAGE=' . $NEXT . $extravar . '">' . $MSG['5120'] . '</a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES
	));
}

function build_items($row)
{
	global $system, $MSG, $security;

	// image icon
	if (!empty($row['pict_url']))
	{
		$row['pict_url'] = $system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $system->SETTINGS['thumb_list'] . '&fromfile=' . $security->encrypt($row['id'] . '/' . $row['pict_url'], true);
	}
	else
	{
		$row['pict_url'] = get_lang_img('nopicture.gif');
	}
	
	if($row['sell_type'] == 'sell')
	{
		if ($row['current_bid'] == 0)
		{
			$row['current_bid'] = $system->print_money($row['minimum_bid']);
		}
	}else{
		$row['current_bid'] = $MSG['3500_1015745'];
	}
	
	if($row['sell_type'] == 'sell')
	{
		if ($row['buy_now'] > 0 && $row['bn_only'] == 'n' && ($row['num_bids'] == 0 || ($row['reserve_price'] > 0 && $row['current_bid'] < $row['reserve_price'])))
		{
			$row['buy_now'] = '<br><br><a style="cursor:pointer" class="btn btn-success btn-sm" href="' . $system->SETTINGS['siteurl'] . 'buy_now.php?id=' . $row['id'] . '"><span class="glyphicon glyphicon-shopping-cart"></span> ' . $MSG['3500_1015531'] . '</a> <br><small>' . $system->print_money($row['buy_now']) . '</small>';
		}
		elseif ($row['buy_now'] > 0 && $row['bn_only'] == 'y')
		{
			$row['current_bid'] = $system->print_money($row['buy_now']);
			$row['buy_now'] = '<br><a style="cursor:pointer" class="btn btn-success btn-sm" href="' . $system->SETTINGS['siteurl'] . 'buy_now.php?id=' . $row['id'] . '"><span class="glyphicon glyphicon-shopping-cart"></span> ' . $MSG['3500_1015531'] . '</a>';
			$row['buy_now_logo'] = '<span class="badge badge-warning">' . $MSG['3500_1015530'] . '</span>';
		}
		else
		{
			$row['buy_now'] = '';
			$row['buy_now_logo'] = '';
		}
	}else{
		$row['buy_now'] = '<br><a style="cursor:pointer" class="btn btn-success btn-sm" href="' . $system->SETTINGS['siteurl'] . 'buy_now.php?id=' . $row['id'] . '"><span class="glyphicon glyphicon-shopping-cart"></span> <b>' . $MSG['3500_1015747'] . '</b></a><br><br><span class="badge badge-warning">' . $MSG['3500_1015748'] . '</span>';
		$row['buy_now_logo'] = '<span class="badge badge-warning">' . $MSG['3500_1015748'] . '</span>';
	}

	return $row;
}
?>