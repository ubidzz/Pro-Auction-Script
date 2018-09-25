<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
if (!defined('InProAuctionScript')) exit('Access denied');

class ItemSettings
{
	private $system; private $DBPrefix; private $database; private $user; private $listingType; private $conf; private $post; private $emailing; private $security;
	
	function __construct()
	{
		global $_POST, $system, $DBPrefix, $db, $user, $send_email, $security;
		
		// system settings
		$this->system = $system;
		$this->DBPrefix = $DBPrefix;
		$this->database = $db;
		$this->post = !isset($_POST) ? false : $_POST;
		$this->user = $user;
		$this->emailing = $send_email;
		$this->security = $security;
	}
	public function UpdatePaidStatus()
	{
		$query = "UPDATE " . $this->DBPrefix . "winners SET paid = 1, is_counted = :set_counted WHERE id = :wid AND seller = :user_id";
		$params = array(
			array(':set_counted', 'y', 'bool'),
			array(':wid', $this->post['db_id'], 'int'),
			array(':user_id', $this->post['user_id'], 'int')
		);
		$this->database->query($query, $params);
		
		$this->system->writesetting("counters", "itemssold", $this->system->COUNTERS['itemssold'] + 1, 'int');
		
		if (!empty($this->post['item']))
		{
			//Digital item was paid now send email with digital item link
			//Get auction id, winner id and seller id 
			$query = "SELECT DISTINCT w.seller, d.seller, u.nick, u.email
				FROM " . $this->DBPrefix . "winners w
			    LEFT JOIN " . $this->DBPrefix . "users u ON (u.id = w.seller) 
			    LEFT JOIN " . $this->DBPrefix . "digital_items d ON (d.auctions = w.auction)
			    WHERE w.id = :get_paid AND d.hash = :get_item";
			$params = array(
				array(':get_paid', $this->post['db_id'], 'int'),
				array(':get_item', $this->post['item'], 'str')
			);
			$this->database->query($query, $params);
			$sellerdata = $this->database->result();
			
			$query = "SELECT DISTINCT w.bid, w.winner, w.auction, w.bid, b.pict_url, b.title, d.item, d.seller, d.hash, u.nick, u.email, u.name, pict_url
				FROM " . $this->DBPrefix . "winners w
			    LEFT JOIN " . $this->DBPrefix . "auctions b ON (b.id = w.auction) 
			    LEFT JOIN " . $this->DBPrefix . "users u ON (u.id = w.winner) 
			    LEFT JOIN " . $this->DBPrefix . "digital_items d ON (d.auctions = w.auction)
			    WHERE w.id = :get_paid AND d.hash = :get_item"; 
			$params = array(
				array(':get_paid', $this->post['db_id'], 'int'),
				array(':get_item', $this->security->decrypt($this->post['item']), 'str')
			);
			$this->database->query($query, $params); 
				
			while ($data = $this->database->result())
			{
				$this->emailing->digital_item_email_pt2($data['title'], $data['name'], $data['auction'], $data['bid'], $sellerdata['nick'], $sellerdata['email'], $this->security->encrypt($data['hash']), $data['pict_url'], $data['winner'], $data['email']);
			}
		}
	}
	public function UpdateShippingStatus($value, $user)
	{
		$query = "UPDATE " . $this->DBPrefix . "winners SET shipped = :status WHERE id = :wid AND " . $user . " = :user_id";
		$params = array(
			array(':status', $value, 'int'),
			array(':wid', $this->post['shipped'], 'int'),
			array(':user_id', $this->post['user_id'], 'int'),
			array(':user_id', $this->post['user_id'], 'int'),
		);
		$this->database->query($query, $params);
	}
	public function UpdateReadStatus($wid, $sellerID)
	{
		$query = "UPDATE " . $this->DBPrefix . "winners SET is_read = 1 WHERE auction = :get_id AND seller = :user_id";
		$params[] = array(
			array(':get_id', $wid, 'int'),
			array(':user_id', $sellerID, 'int')
		);
		$this->database->query($query, $params);
	}
	public function AddTrackingInfo()
	{
		$query = "UPDATE " . $this->DBPrefix . "winners SET shipper = :shipper, shipper_url = :shipperURL, tracking_number = :tracking WHERE id = :wid AND seller = :user_id";
		$params = array(
			array(':shipper', $this->post['shipper'], 'str'),
			array(':shipperURL', $this->post['shipperURL'], 'str'),
			array(':tracking', $this->post['trackingNumber'], 'str'),
			array(':wid', $this->post['wid'], 'int'),
			array(':user_id', $this->user->user_data['id'], 'int'),
		);
		$this->database->query($query, $params);
	}
}