<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');

class cronHandler
{
	private $system;
	private $DBPrefix;
	private $database;
	private $sendEmail;
	private $message;
	
	function __construct()
	{
		global $send_email, $db, $system, $DBPrefix, $MSG;
		// system settings
		$this->system = $system;
		$this->DBPrefix = $DBPrefix;
		$this->database = $db;
		$this->sendEmail = $send_email;
		$this->message = $MSG;
	}
	private function getBuyerFee()
	{
		$query = "SELECT value, fee_type FROM " . $this->DBPrefix . "fees WHERE type = 'buyer_fee'";
		$this->database->direct_query($query);
		return $this->database->result();
	}
	public function buyerFeeValue()
	{
		$row = self::getBuyerFee();
		return $row['value'];
	}
	public function buyerFeeType()
	{
		$row = self::getBuyerFee();
		return $row['fee_type'];
	}
	public function buildFees()
	{
		// get closed auction fee
		$query = "SELECT * FROM " . $this->DBPrefix . "fees WHERE type = 'endauc_fee' ORDER BY value ASC";
		$this->database->direct_query($query);
		$endauc_fee = array();
		while($row = $this->database->result())
		{
			$endauc_fee[] = $row;
		}
		return $endauc_fee;
	}
	public function checkCronLogs()
	{
		$corn_log = '';
		//delete old cron logs so we don't overload the db
		$query = "SELECT id, timestamp FROM " . $this->DBPrefix . "logs WHERE type = 'cron' ORDER BY timestamp ASC";
		$this->database->direct_query($query);
		$logs = 0;
		foreach ($this->database->fetchall() as $row)
		{
			if($this->database->numrows('id') > 35 || $this->system->ConvertedTimeObject($row['timestamp'], 20, '+', 'minutes') <= $this->system->CTIME)
			{
				$query = "DELETE FROM " . $this->DBPrefix . "logs WHERE type = 'cron' AND id = :log_id";
				$params = array(
					array(':log_id', $row['id'], 'int')
				);
				$this->database->query($query, $params);
				$logs++;
			}
		}
		$corn_log .= '<br>' . $this->message['3500_1015598'];
		$corn_log .= '<strong>' . $logs . '</strong>' . $this->message['3500_1015600'];
		return $corn_log;
	}
	public function printLog($str)
	{	
		global $system;
		if (defined('LogCron') && LogCron == true)
		{
			$system->log('cron', $str);
		}
	}
	
	public function constructCategories()
	{	
		$query = "SELECT cat_id, parent_id, sub_counter, counter FROM " . $this->DBPrefix . "categories ORDER BY 'cat_id'";
		$this->database->direct_query($query);
		while ($row = $this->database->result())
		{
			$row['updated'] = false;
			$categories[$row['cat_id']] = $row;
		}
		return $categories;
	}
	
	public function sendWatchEmails($id, $auctionTitle)
	{		
		if($id !=NULL) {
			$query = "SELECT name, email, item_watch, id FROM " . $this->DBPrefix . "users WHERE item_watch LIKE '% :auc_id %'";
			$params = array(
				array(':auc_id', $id, 'int')
			);
			$this->database->query($query, $params);
			while ($watchusers = $this->database->result())
			{
				$keys = explode(' ', $watchusers['item_watch']);
				// If keyword matches with opened auction title or/and desc send user a mail
				if (in_array($id, $keys))
				{
					// send message
					$this->sendEmail->watch_emails($auctionTitle, $id, $watchusers['name'], $watchusers['id'], $watchusers['email']);
				}
			}	
		}
	}
	public function purgThumbnailsCache()
	{
		// Purging thumbnails cache
		$corn_log = '';
		$purged = 0;
		//checking see if the cache folder is found
		if (!file_exists(UPLOAD_PATH . 'cache'))
		{
			mkdir(UPLOAD_PATH . 'cache', 0755);
		}
		//checking see if the purge page is found in the cache folder
		if (!file_exists(UPLOAD_PATH . 'cache/purge'))
		{
			touch(UPLOAD_PATH . 'cache/purge');
		}
		//now checking the cache time and deleting old cache files
		if (($this->system->CTIME - fileCTIME(UPLOAD_PATH . 'cache/purge')) > 1800) //purge image cache every 30minutes
		{
			if ($dh = opendir(UPLOAD_PATH . 'cache'))
			{
				while (($file = readdir($dh)) !== false)
				{
					if ($file != 'purge' && !is_dir(UPLOAD_PATH . 'cache/' . $file) && ($this->system->CTIME - fileCTIME(UPLOAD_PATH . 'cache/' . $file)) > 900)
					{
						unlink(UPLOAD_PATH . 'cache/' . $file);
						$purged++;
					}
				}
				closedir($dh);
			}
			touch(UPLOAD_PATH . 'cache/purge');
		}

		$corn_log .= '<br>' . $this->message['3500_1015596'];
		$corn_log .= '<strong>' . $purged . '</strong>' . $this->message['3500_1015597'];
		return $corn_log;
	}
	public function updateSiteCounters()
	{
		//get all active users
		$query = "SELECT id FROM " . $this->DBPrefix . "users WHERE suspended = 0";
		$this->database->direct_query($query);
		$active_users = $this->database->numrows('id');
					
		//get all suspended users
		$query = "SELECT id FROM " . $this->DBPrefix . "users WHERE suspended = 8";
		$this->database->direct_query($query);
		$inactive_users = $this->database->numrows('id');
					
		//get all open auction
		$query = "SELECT id FROM " . $this->DBPrefix . "auctions WHERE closed = 0 AND suspended = 0";
		$this->database->direct_query($query);
		$active_auctions = $this->database->numrows('id');
					
		//get all closed auction
		$query = "SELECT id FROM " . $this->DBPrefix . "auctions WHERE closed != 0";
		$this->database->direct_query($query);
		$closed_auctions = $this->database->numrows('id');	
		
		//get all suspended auctions
		$query = "SELECT id FROM " . $this->DBPrefix . "auctions WHERE closed = 0 and suspended != 0";
		$this->database->direct_query($query);
		$suspended_auctions = $this->database->numrows('id');
					
		//get all bids
		$query = "SELECT b.id FROM " . $this->DBPrefix . "bids b
			LEFT JOIN " . $this->DBPrefix . "auctions a ON (b.auction = a.id)
			WHERE a.closed = 0 AND a.suspended = 0";
		$this->database->direct_query($query);
		$user_bids = $this->database->numrows('id');
			
		$query = "SELECT id FROM " . $this->DBPrefix . "winners WHERE paid = 1";
		$this->database->direct_query($query);
		$paid_items = $this->database->numrows('id');
		
		//now update all the counters in the database
		$this->system->writesetting("counters", "users", $active_users, 'int');
		$this->system->writesetting("counters", "inactiveusers", $inactive_users, 'int');
		$this->system->writesetting("counters", "auctions", $active_auctions, 'int');
		$this->system->writesetting("counters", "suspendedauctions", $suspended_auctions, 'int');
		$this->system->writesetting("counters", "bids", $user_bids, 'int');
		$this->system->writesetting("counters", "itemssold", $paid_items, 'int');
	}
	public function updateCategories()
	{
		// we have to set the categories counters to 0 so it can be recounted
		//correctly and the next code below will add the new counter 
		$query = "UPDATE " . $this->DBPrefix . "categories set counter = 0, sub_counter = 0";
		$this->database->direct_query($query);
					
		$query = "SELECT COUNT(id) As COUNT, category, secondcat FROM " . $this->DBPrefix . "auctions
			WHERE closed = 0 AND starts <= :timer AND suspended = 0 GROUP BY category";
		$params = array(
			array(':timer', $this->system->CTIME, 'int')
		);
		$this->database->query($query, $params);
		while ($row = $this->database->fetch())
		{
			if ($row['COUNT'] * 1 > 0 && !empty($row['category'])) // avoid some errors
			{
				$query = "SELECT left_id, right_id, counter FROM " . $this->DBPrefix . "categories WHERE cat_id = :cat";
				$params = array(
					array(':cat', $row['category'], 'int')
				);
				$this->database->query($query, $params);
				
				$parent_node = $this->database->result();	
				$add_cat = $parent_node['counter'] + $row['COUNT'];
				$catscontrol = new MPTTcategories();	
				$main_crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);
				
				for ($i = 0; $i < count($main_crumbs); $i++)
				{
					$query = "UPDATE " . $this->DBPrefix . "categories SET sub_counter = sub_counter + :sub_counters WHERE cat_id = :cat_ids";
					$params = array(
						array(':sub_counters', $add_cat, 'int'),
						array(':cat_ids', $main_crumbs[$i]['cat_id'], 'int')
					);
					$this->database->query($query, $params);
				}
				
				$query = "UPDATE " . $this->DBPrefix . "categories SET counter = :count_cat WHERE cat_id = :cat_id";
				$params = array(
					array(':count_cat', $add_cat, 'int'),
					array(':cat_id', $row['category'], 'int')
				);
				$this->database->query($query, $params);
				
				//adding extra categories if the function is turned on
				if ($row['secondcat'] > 0 && !empty($row['secondcat']) && $this->system->SETTINGS['extra_cat'] == 'y') // avoid some errors
				{
					$query = "SELECT left_id, right_id, counter FROM " . $this->DBPrefix . "categories WHERE cat_id = :extra_cat";
					$params = array(
						array(':extra_cat', $row['secondcat'], 'int')
					);
					$this->database->query($query, $params);
					
					$extra_parent_node = $this->database->result();			
					$add_extra_cat = $extra_parent_node['counter'] + $row['COUNT'];	
					$extra_crumbs = $catscontrol->get_bread_crumbs($extra_parent_node['left_id'], $extra_parent_node['right_id']);
					
					for ($i = 0; $i < count($extra_crumbs); $i++)
					{
						$query = "UPDATE " . $this->DBPrefix . "categories SET sub_counter = sub_counter + :sub_counters WHERE cat_id = :extra_cat_id";
						$params = array(
							array(':sub_counters', $add_extra_cat, 'int'),
							array(':extra_cat_id', $extra_crumbs[$i]['cat_id'], 'int')
						);
						$this->database->query($query, $params);
					}
					
					$query = "UPDATE " . $this->DBPrefix . "categories SET counter = :count_cat WHERE cat_id = :extra_cat_id";
					$params = array(
						array(':count_cat', $add_extra_cat, 'int'),
						array(':extra_cat_id', $row['secondcat'], 'int')
					);
					$this->database->query($query, $params);
				}
			}
		}
	}
}