<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/


if (!defined('InProAuctionScript')) exit('Access denied');

if (!function_exists('view'))
{
	function view()
	{
		global $system, $DBPrefix, $db;

		$return = '';
		$joinings = '';
		$extra = '';
		$BANNERSARRAY = array();

		if (strstr($_SERVER['SCRIPT_FILENAME'], 'adsearch.php')) // check search terms
		{
			global $_SESSION;
			// check title search
			if (isset($_SESSION['advs']['title']) && !empty($_SESSION['advs']['title']))
			{
				$joinings .= ' LEFT JOIN ' . $DBPrefix . 'bannerskeywords k ON (k.banner = b.id)';
				$tmp = explode(' ', $_SESSION['advs']['title']);
				$extra .= build_keyword_sql($tmp);
			}
			// check category search
			if (isset($_SESSION['advs']['category']) && !empty($_SESSION['advs']['category']))
			{
				$joinings .= ' LEFT JOIN ' . $DBPrefix . 'bannerscategories c ON (c.banner = b.id)';
				$extra .=  " OR c.category = " . $_SESSION['advs']['category'];
			}
			if ($extra != '')
			{
				$extra = ' AND (' . $extra . ')';
			}
		}
		elseif (strstr($_SERVER['SCRIPT_FILENAME'], 'search.php')) // check search terms
		{
			global $term;
			$joinings .= ' LEFT JOIN ' . $DBPrefix . 'bannerskeywords k ON (k.banner = b.id)';
			$tmp = explode(' ', $term);
			$extra .= ' AND ' . build_keyword_sql($tmp);
		}

		$query = "SELECT b.id FROM " . $DBPrefix . "banners b " . $joinings . "
				WHERE (b.views < b.purchased OR b.purchased = :purchased)" . $extra;
		$params = array();
		$params[] = array(':purchased', 0, 'int');
		$db->query($query, $params);
		
		$CKcount = false;

		if ($db->numrows('id') == 0)
		{
			$query = "SELECT b.id, COUNT(k.banner) as Kcount, COUNT(c.banner) as Ccount FROM " . $DBPrefix . "banners b
					LEFT JOIN " . $DBPrefix . "bannerscategories c ON (c.banner = b.id)
					LEFT JOIN " . $DBPrefix . "bannerskeywords k ON (k.banner = b.id)
					WHERE (b.views < b.purchased OR b.purchased = :purchased) AND k.keyword = NULL AND c.category = NULL
					GROUP BY k.banner, c.banner";
			$params = array();
			$params[] = array(':purchased', 0, 'int');
			$db->query($query, $params);
			$CKcount = true;
		}

		// We have at least one banners to show
		while ($row = $db->result())
		{
			if ($CKcount && $row['Kcount'] == 0 && $row['Ccount'] == 0)
			{
				$BANNERSARRAY[] = $row;
			}
			elseif (!$CKcount)
			{
				$BANNERSARRAY[] = $row;
			}
		}

		// Display banner
		if (count($BANNERSARRAY) > 0)
		{
			$RAND_IDX = array_rand($BANNERSARRAY);
			$BANNERTOSHOW = $BANNERSARRAY[$RAND_IDX]['id'];

			$query = "SELECT * FROM " . $DBPrefix . "banners WHERE id = :BANNER";
			$params = array();
			$params[] = array(':BANNER', $BANNERTOSHOW, 'int');
			$db->query($query, $params);
			$THISBANNER = $db->result();
			if ($THISBANNER['type'] == 'swf')
			{
				$return .= '<a href="' . $system->SETTINGS['siteurl'] . 'clickthrough.php?banner=' . $THISBANNER['id'] . '" target="_blank">
				<object type="application/x-shockwave-flash" data="' . $system->SETTINGS['siteurl'] . UPLOAD_FOLDER . 'banners/' . $THISBANNER['user'] . '/' . $THISBANNER['name'] . '" width="' . $THISBANNER['width'] . '" height="' . $THISBANNER['height'] . '">
					<param name="quality" value="high">
					<param name="play" value="true">
					<param name="LOOP" value="true">
					<param name="wmode" value="transparent">
					<param name="allowScriptAccess" value="true">
				</object></a><br>';
			}
			else
			{
				$return .= '
				<a href="' . $system->SETTINGS['siteurl'] . 'clickthrough.php?banner=' . $THISBANNER['id'] . '" target="_blank"> <img border=0 alt="' . $THISBANNER['alt'] . '" src="' . $system->SETTINGS['siteurl'] . UPLOAD_FOLDER . 'banners/' . $THISBANNER['user'] . '/' . $THISBANNER['name'] . '" /></a><br>';
			}
			
			if (!empty($THISBANNER['sponsortext']))
			{
				$return .= '<a href="' . $system->SETTINGS['siteurl'] . 'clickthrough.php?banner=' . $THISBANNER['id'] . '" target="_blank">' . $THISBANNER['sponsortext'] . '</a><br>';
			}
			
			// Update views
			$query = "UPDATE " . $DBPrefix . "banners set views = views + :add WHERE id = :BANNER_ID";
			$params = array();
			$params[] = array(':add', 1, 'int');
			$params[] = array(':BANNER_ID', $THISBANNER['id'], 'int');
			$db->query($query, $params);
		}
		return $return;
	}
}

function build_keyword_sql($array)
{
	$query = '(';
	if (is_array($array))
	{
		$i = 0;
		foreach($array as $val)
		{
			if ($i > 0)
				$query .= ' OR ';
			$query .= "k.keyword LIKE '%" . $val . "%'";
			$i++;
		}
	}
	else
	{
		$query .= "k.keyword LIKE '%" . $array . "%'";
	}
	$query .= ')';
	return $query;
}
?>