<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
 define('InAdmin', 1);
include 'adminCommon.php';
include INCLUDE_PATH . 'countries.inc.php';
$NOW = $system->CTIME;
if (isset($_POST['action']))
{
	switch($_POST['action'])
	{
		case 'clearcache':
			clearCache();
			$ERROR = $MSG['30_0033'];
		break;

		case 'updatecounters':
			//-----update the counters handler------//
			//get all active users
			$query = "SELECT id FROM " . $DBPrefix . "users WHERE suspended = :is_suspended";
			$params = array();
			$params[] = array(':is_suspended', 0, 'int');
			$db->query($query, $params);
			$active_users = $db->numrows('id');
						
			//get all suspended users
			$query = "SELECT id FROM " . $DBPrefix . "users WHERE suspended = :is_suspended";
			$params = array();
			$params[] = array(':is_suspended', 8, 'int');
			$db->query($query, $params);
			$inactive_users = $db->numrows('id');
						
			//get all open auction
			$query = "SELECT id FROM " . $DBPrefix . "auctions WHERE closed = :close AND suspended = :suspend";
			$params = array();
			$params[] = array(':close', 0, 'int');
			$params[] = array(':suspend', 0, 'int');
			$db->query($query, $params);
			$active_auctions = $db->numrows('id');
						
			//get all closed auction
			$query = "SELECT id FROM " . $DBPrefix . "auctions WHERE closed != :close";
			$params = array();
			$params[] = array(':close', 0, 'int');
			$db->query($query, $params);
			$closed_auctions = $db->numrows('id');	
			
			//get all suspended auctions
			$query = "SELECT id FROM " . $DBPrefix . "auctions WHERE closed = :close and suspended != :suspend";
			$params = array();
			$params[] = array(':close', 0, 'int');
			$params[] = array(':suspend', 0, 'int');
			$db->query($query, $params);
			$suspended_auctions = $db->numrows('id');
						
			//get all bids
			$query = "SELECT b.id FROM " . $DBPrefix . "bids b
				LEFT JOIN " . $DBPrefix . "auctions a ON (b.auction = a.id)
				WHERE a.closed = :close AND a.suspended = :suspend";
			$params = array();
			$params[] = array(':close', 0, 'int');
			$params[] = array(':suspend', 0, 'int');
			$db->query($query, $params);
			$user_bids = $db->numrows('id');
				
			$query = "SELECT id FROM " . $DBPrefix . "winners WHERE paid = :is_paid";
			$params = array();
			$params[] = array(':is_paid', 1, 'int');
			$db->query($query, $params);
			$paid_items = $db->numrows('id');
			
			//now update all the counters in the database
			$system->writesetting("counters", "users", $active_users, 'int');
			$system->writesetting("counters", "inactiveusers", $inactive_users, 'int');
			$system->writesetting("counters", "auctions", $active_auctions, 'int');
			$system->writesetting("counters", "closedauctions", $closed_auctions, 'int');
			$system->writesetting("counters", "suspendedauctions", $suspended_auctions, 'int');
			$system->writesetting("counters", "bids", $user_bids, 'int');
			$system->writesetting("counters", "itemssold", $paid_items, 'int');
					
			// we have to set the categories counters to 0 so it can be recounted
			//correctly and the next code below will add the new counter 
			$query = "UPDATE " . $DBPrefix . "categories set counter = 0, sub_counter = 0";
			$params = array();
			$db->query($query, $params);
						
			$query = "SELECT COUNT(id) As COUNT, category, secondcat FROM " . $DBPrefix . "auctions
				WHERE closed = 0 AND starts <= :timer AND suspended = 0 GROUP BY category";
			$params = array();
			$params[] = array(':timer', $NOW, 'int');
			$db->query($query, $params);
			while ($row = $db->fetch())
			{
				if ($row['COUNT'] * 1 > 0 && !empty($row['category'])) // avoid some errors
				{
					$query = "SELECT left_id, right_id, counter FROM " . $DBPrefix . "categories WHERE cat_id = :cat";
					$params = array();
					$params[] = array(':cat', $row['category'], 'int');
					$db->query($query, $params);
					
					$parent_node = $db->result();	
					$add_cat = $parent_node['counter'] + $row['COUNT'];
					$catscontrol = new MPTTcategories();	
					$main_crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
					
					for ($i = 0; $i < count($main_crumbs); $i++)
					{
						$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + :sub_counters WHERE cat_id = :cat_ids";
						$params = array();
						$params[] = array(':sub_counters', $add_cat, 'int');
						$params[] = array(':cat_ids', $main_crumbs[$i]['cat_id'], 'int');
						$db->query($query, $params);
					}
					
					$query = "UPDATE " . $DBPrefix . "categories SET counter = :count_cat WHERE cat_id = :cat_id";
					$params = array();
					$params[] = array(':count_cat', $add_cat, 'int');
					$params[] = array(':cat_id', $row['category'], 'int');
					$db->query($query, $params);
					
					//adding extra categories if the function is turned on
					if ($row['secondcat'] > 0 && !empty($row['secondcat']) && $system->SETTINGS['extra_cat'] == 'y') // avoid some errors
					{
						$query = "SELECT left_id, right_id, counter FROM " . $DBPrefix . "categories WHERE cat_id = :extra_cat";
						$params = array();
						$params[] = array(':extra_cat', $row['secondcat'], 'int');
						$db->query($query, $params);
						
						$extra_parent_node = $db->result();			
						$add_extra_cat = $extra_parent_node['counter'] + $row['COUNT'];	
						$extra_crumbs = $catscontrol->get_bread_crumbs($extra_parent_node['left_id'], $extra_parent_node['right_id']);
						
						for ($i = 0; $i < count($extra_crumbs); $i++)
						{
							$query = "UPDATE " . $DBPrefix . "categories SET sub_counter = sub_counter + :sub_counters WHERE cat_id = :extra_cat_id";
							$params = array();
							$params[] = array(':sub_counters', $add_extra_cat, 'int');
							$params[] = array(':extra_cat_id', $extra_crumbs[$i]['cat_id'], 'int');
							$db->query($query, $params);
						}
						
						$query = "UPDATE " . $DBPrefix . "categories SET counter = :count_cat WHERE cat_id = :extra_cat_id";
						$params = array();
						$params[] = array(':count_cat', $add_extra_cat, 'int');
						$params[] = array(':extra_cat_id', $row['secondcat'], 'int');
						$db->query($query, $params);
					}
				}
			}
			$ERROR = $MSG['1029'];
		break;
	}
}

$query = "SELECT pageviews, uniquevisitors, usersessions FROM " . $DBPrefix . "currentaccesses WHERE year = " . date('Y') . " AND month = " . date('m') . " AND day = " . date('d');
$db->direct_query($query);
$ACCESS = $db->result();
$pageviews = (!isset($ACCESS['pageviews']) || empty($ACCESS['pageviews'])) ? 0 : $ACCESS['pageviews'];
$uniquevisitors = (!isset($ACCESS['uniquevisitors']) || empty($ACCESS['uniquevisitors'])) ? 0 : $ACCESS['uniquevisitors'];
$usersessions = (!isset($ACCESS['usersessions']) || empty($ACCESS['usersessions'])) ? 0 : $ACCESS['usersessions'];

if ($system->SETTINGS['activationtype'] == 0)
{
	$query = "SELECT id FROM " . $DBPrefix . "users WHERE suspended = 10";
	$db->direct_query($query);
	$uuser_count = $db->numrows('id');
}

//getting the correct email settings
if($system->SETTINGS['mail_protocol'] == 0) $email_settings = $MSG['3500_1015843'];
if($system->SETTINGS['mail_protocol'] == 1) $email_settings = $MSG['3500_1015844'];
if($system->SETTINGS['mail_protocol'] == 2) $email_settings = $MSG['3500_1015845'];
if($system->SETTINGS['mail_protocol'] == 3) $email_settings = $MSG['3500_1015846'];
if($system->SETTINGS['mail_protocol'] == 4) $email_settings = $MSG['3500_1015847'];
if($system->SETTINGS['mail_protocol'] == 5) $email_settings = $MSG['3500_1015848'];

$template->assign_vars(array(
	'ADMINMAIL' => $system->SETTINGS['adminmail'],
	'CRON' => ($system->SETTINGS['cron'] == 1) ? '<b>' . $MSG['373'] . '</b><br>' . $MSG['25_0027'] : '<b>' . $MSG['374'] . '</b>',
	'GALLERY' => ($system->SETTINGS['picturesgallery'] == 1) ? '<b>' . $MSG['2__0066'] . '</b><br>' . $MSG['666'] . ': ' . $system->SETTINGS['maxpictures'] . '<br>' . $MSG['671'] . ': ' . formatSizeUnits($system->SETTINGS['maxuploadsize']) : '<b>' . $MSG['2__0067'] . '</b>',
	'BUY_NOW' => ($system->SETTINGS['buy_now'] == 1) ? '<b>' . $MSG['2__0067'] . '</b>' : '<b>' . $MSG['2__0066'] . '</b>',
	'CURRENCY' => $system->SETTINGS['currency'],
	'TIMEZONE' => ($system->SETTINGS['timecorrection'] == 0) ? $MSG['25_0036'] : $MSG['25_0037'],
	'DATEFORMAT' => $system->SETTINGS['datesformat'],
	'DATEEXAMPLE' => ($system->SETTINGS['datesformat'] == 'USA') ? $MSG['382'] : $MSG['383'],
	'DEFULTCONTRY' => $system->SETTINGS['defaultcountry'],
	'USERCONF' => $system->SETTINGS['activationtype'],
	'C_USERS' => $system->COUNTERS['users'],
	'C_IUSERS' => $system->COUNTERS['inactiveusers'],
	'C_ISOLD' => $system->COUNTERS['itemssold'],
	'C_UUSERS' => (isset($uuser_count)) ? $uuser_count : '',
	'C_AUCTIONS' => $system->COUNTERS['auctions'],
	'C_CLOSED' => $system->COUNTERS['closedauctions'],
	'C_BIDS' => $system->COUNTERS['bids'],
	'A_PAGEVIEWS' => $pageviews,
	'A_UVISITS' => $uniquevisitors,
	'A_USESSIONS' => $usersessions,
	'EMAIL_HANDLER' => $email_settings,
	'CACHE' => $system->SETTINGS['cache_theme'] == 'y' ? '<b>' . $MSG['2__0066'] . '</b>' : '<b>' . $MSG['2__0067'] . '</b>',
	'COOKIE_DIRECTIVE' => $system->SETTINGS['cookies_directive'] == 'y' ? '<b>' . $MSG['2__0066'] . '</b>' : '<b>' . $MSG['2__0067'] . '</b>',
	'B_VISITS' => $pageviews == 0 && $uniquevisitors == 0 && $usersessions == 0 ? false : true,
	'B_AUCTIONS' => $system->COUNTERS['auctions'] == 0 && $system->COUNTERS['closedauctions'] == 0 && $system->COUNTERS['bids'] == 0 && $system->COUNTERS['itemssold'] == 0 ? false : true,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['166'],
	'PAGETITLE' => $MSG['166']
));
include 'adminHeader.php';
$template->set_filenames(array(
	'body' => 'home.tpl'
));
$template->display('body');
include 'adminFooter.php';