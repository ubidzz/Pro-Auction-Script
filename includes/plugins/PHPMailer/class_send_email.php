<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

if (!defined('InProAuctionScript')) exit('Access denied');

class send_email
{
	private $emailer;
	private $msg;
	private $system;
	private $user;
	private $security;
	private $md5_prefix;
	private $db_prefix;
	private $database;
	private $returnMessage;

	function __construct()
	{
		global $system, $user, $MSG, $security, $MD5_PREFIX, $DBPrefix, $db;
		
		$this->emailer = new email_handler();
		$this->msg = $MSG;
		$this->system = $system;
		$this->user = $user->user_data;
		$this->security = $security;
		$this->md5_prefix = $MD5_PREFIX;
		$this->db_prefix = $DBPrefix;
		$this->database = $db;
		$this->returnMessage = '';
	}
	private function sending_email($email, $emailPage, $subject, $userID = false)
	{
		if($userID) {
			$this->emailer->email_uid = $userID;
		}
		$this->emailer->email_sender($email, $emailPage, $subject);
		return $this->returnMessage;
	}
	public function confirmation($auction_id, $title, $atype, $pict_url, $minimum_bid, $reserve_price, $buy_now_price, $a_ends)
	{	
		$this->emailer->assign_vars(array(
			'SITE_URL' => $this->system->SETTINGS['siteurl'],
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'A_ID' => $auction_id,
			'A_TITLE' => $title,
			'SEO_TITLE' => generate_seo_link($title),
			'A_TYPE' => ($atype == 1) ? $this->msg['642'] : $this->msg['641'],
			'A_PICURL' => ($pict_url != '') ? $this->system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $this->system->SETTINGS['thumb_show'] . '&fromfile=' . $this->security->encrypt($auction_id . '/' . $pict_url, true) : $this->system->SETTINGS['siteurl'] . 'images/email_alerts/default_item_img.jpg',
			'A_MINBID' => $this->system->print_money($minimum_bid, true, false),
			'A_RESERVE' => $this->system->print_money($reserve_price, true, false),
			'A_BNPRICE' => $this->system->print_money($buy_now_price, true, false),
			'A_ENDS' => $this->system->ArrangeDateAndTime($a_ends + $this->system->TDIFF),
			'MAXIMAGESIZE' => $this->system->SETTINGS['thumb_show'],
			'C_NAME' => $this->user['name']
		));		
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' ' . $this->msg['099'] . ': ' . $title . ' (' . $auction_id . ')';
		return self::sending_email($this->user['email'], 'auctionmail.inc.php', $buildSubtitle, $this->user['id']);
	}
	public function cumulative($report, $name, $email, $id)
	{		
		$this->emailer->assign_vars(array(
			'SITE_URL' => $this->system->SETTINGS['siteurl'],
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'ADMINMAIL' => $this->system->SETTINGS['adminmail'],
			'REPORT' => $report,
			'S_NAME' => $name
		));
		return self::sending_email($email, 'endauction_cumulative.inc.php', $this->msg['25_0199'], $id);
	}
	public function nowinner($title, $id, $ends_string, $pict_url, $Sid)
	{		
		$query = "SELECT * FROM " . $this->db_prefix . "users WHERE id = :seller"; 
		$params = array();
		$params[] = array(':seller', $Sid, 'int');
		$this->database->query($query, $params);
		$seller = $this->database->result();
		
		$this->emailer->assign_vars(array(
			'S_NAME' => $seller['name'],
			'S_NICK' => $seller['nick'],
			'S_EMAIL' => $seller['email'],
			'A_TITLE' => $title,
			'A_ID' => $id,
			'A_END' => $ends_string,
			'A_URL' => $this->system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($title) . '-' . $id,
			'SITE_URL' => $this->system->SETTINGS['siteurl'],
			'A_PICURL' => ($pict_url != '') ? $this->system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $this->system->SETTINGS['thumb_show'] . '&fromfile=' . $this->security->encrypt($id . '/' . $pict_url, true) : $this->system->SETTINGS['siteurl'] . 'images/email_alerts/default_item_img.jpg',
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'MAXIMAGESIZE' => $this->system->SETTINGS['thumb_show']
		));		
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' ' . $this->msg['112'];
		return self::sending_email($seller['email'], 'endauction_nowinner.inc.php', $buildSubtitle, $Sid);
	}
	public function winner($title, $id, $pict_url, $current_bid, $quantity, $ends_string, $seller_id, $winner_id, $win_id)
	{		
		//winners table data to see if the item was paid
		$query = "SELECT paid FROM " . $this->db_prefix . "winners WHERE id = :win"; 
		$params = array();
		$params[] = array(':win', $win_id, 'int');
		$this->database->query($query, $params);
		$paid = $this->database->result('paid');

		//seller data
		$query = "SELECT * FROM " . $this->db_prefix . "users WHERE id = :seller"; 
		$params = array();
		$params[] = array(':seller', $seller_id, 'int');
		$this->database->query($query, $params);
		$seller = $this->database->result();
		
		//winner data
		$query = "SELECT * FROM " . $this->db_prefix . "users WHERE id = :winner"; 
		$params = array();
		$params[] = array(':winner', $winner_id, 'int');
		$this->database->query($query, $params);
		$winner = $this->database->result();

		$this->emailer->assign_vars(array(
			'S_NAME' => $seller['name'],
			'A_URL' => $this->system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($title) . '-' . $id,
			'A_PICURL' => ($pict_url != '') ? $this->system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $this->system->SETTINGS['thumb_show'] . '&fromfile=' . $this->security->encrypt($id . '/' . $pict_url, true) : $this->system->SETTINGS['siteurl'] . 'images/email_alerts/default_item_img.jpg',
			'A_TITLE' => $title,
			'A_CURRENTBID' => $this->system->print_money($current_bid, true, false),
			'A_QTY' => $quantity,
			'A_ENDS' => $ends_string,
			'PAID' => $paid == 1 ? '<span style="color:green">' . $this->msg['755'] . '</span>' : '<span style="color:red">' . $this->msg['350_10024'] . '</span>',
			'SITE_URL' => $this->system->SETTINGS['siteurl'],
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'WINNER_NAME' => $winner['name'],
			'WINNER_EMAIL' => $winner['email'],
			'WINNER_ADDRESS' => $winner['address'],
			'WINNER_CITY' => $winner['city'],
			'WINNER_PROV' => $winner['prov'],
			'WINNER_COUNTRY' => $winner['country'],
			'WINNER_ZIP' => $winner['zip'],
			'MAXIMAGESIZE' => $this->system->SETTINGS['thumb_show']
		));		
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' ' . $this->msg['079'] . ' ' . $this->msg['907'] . ' ' . $this->system->uncleanvars($title);
		return self::sending_email($seller['email'], 'endauction_winner.inc.php', $buildSubtitle, $seller['id']);
	}
	public function youwin($Auc_description, $wanted, $quantity, $title, $Aid, $current_bid, $ends_string, $seller_id, $payment_details, $Winner_id)
	{		
		//winner data
		$query = "SELECT * FROM " . $this->db_prefix . "users WHERE id = :winner"; 
		$params = array();
		$params[] = array(':winner', $Winner_id, 'int');
		$this->database->query($query, $params);
		$winner = $this->database->result();

		//seller data
		$query = "SELECT * FROM " . $this->db_prefix . "users WHERE id = :seller"; 
		$params = array();
		$params[] = array(':seller', $seller_id, 'int');
		$this->database->query($query, $params);
		$seller = $this->database->result();

		if(strlen(strip_tags($Auc_description)) > 60)
		{
			$description = substr(strip_tags($Auc_description), 0, 50) . '...';
		}
		else
		{
			$description = $Auc_description;
		}
		
		
		$this->emailer->assign_vars(array(
			'W_NAME' => $winner['name'],
			'W_WANTED' => $wanted,
			'W_GOT' => $quantity,
			'A_URL' => $this->system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($title) . '-' . $Aid,
			'A_TITLE' => $title,
			'A_DESCRIPTION' => $description,
			'A_CURRENTBID' => $this->system->print_money($WINNERS_BID[$current_bid], true, false),
			'A_ENDS' => $ends_string,
			'S_NICK' => $seller['nick'],
			'S_EMAIL' => $seller['email'],
			'S_PAYMENT' => $payment_details,
			'SITE_URL' => $this->system->SETTINGS['siteurl'],
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'ADMINEMAIL' => $this->system->SETTINGS['adminmail']
		));		
		$buildSubtitle = $this->msg['909'] . ' ' . $title;
		return self::sending_email($winner['email'], 'endauction_youwin.inc.php', $buildSubtitle, $winner['id']);
	}
	public function youwin_nodutch($Auc_title, $Auction_pict_url, $Auction_id, $Auction_current_bid, $ends_string, $Seller_id, $Winner_id)
	{		
		//seller data
		$query = "SELECT nick, email FROM " . $this->db_prefix . "users WHERE id = :seller"; 
		$params = array();
		$params[] = array(':seller', $Seller_id, 'int');
		$this->database->query($query, $params);
		$seller = $this->database->result();
		
		//winner data
		$query = "SELECT id, name, email FROM " . $this->db_prefix . "users WHERE id = :winner"; 
		$params = array();
		$params[] = array(':winner', $Winner_id, 'int');
		$this->database->query($query, $params);
		$winner = $this->database->result();

		$item_title = $this->system->uncleanvars($Auc_title);
		
		$this->emailer->assign_vars(array(
			'W_NAME' => $winner['name'],
			'A_PICURL' => ($Auction_pict_url != '') ? $this->system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $this->system->SETTINGS['thumb_show'] . '&fromfile=' . $this->security->encrypt($Auction_id . '/' . $Auction_pict_url, true) : $this->system->SETTINGS['siteurl'] . 'images/email_alerts/default_item_img.jpg',
			'A_URL' => $this->system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($Auc_title) . '-' . $Auction_id,
			'A_TITLE' => $Auc_title,
			'A_CURRENTBID' => $this->system->print_money($Auction_current_bid, true, false),
			'A_ENDS' => $ends_string,
			'S_NICK' => $seller['nick'],
			'S_EMAIL' => $seller['email'],		
			'SITE_URL' => $this->system->SETTINGS['siteurl'],
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'MAXIMAGESIZE' => $this->system->SETTINGS['thumb_show']
		));		
		$buildSubtitle = $this->system->SETTINGS['sitename'] . $this->msg['909'] . ': ' . $item_title;
		return self::sending_email($winner['email'], 'endauction_youwin_nodutch.inc.php', $buildSubtitle, $winner['id']);
	}
	public function outbid($item_title, $OldWinner_name, $last_highest_bid, $new_bid, $ends_string, $item_id, $OldWinner_id, $OldWinner_email, $pict_url = '')
	{	
		$title = $this->system->uncleanvars($item_title);		
		$this->emailer->assign_vars(array(
			'SITE_URL' => $this->system->SETTINGS['siteurl'],
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'C_NAME' => $OldWinner_name,
			'C_BID' => $last_highest_bid,
			'N_BID' => $new_bid,
			'A_TITLE' => $title,
			'A_ENDS' => $ends_string,
			'MAXIMAGESIZE' => $this->system->SETTINGS['thumb_show'],
			'A_PICURL' => ($pict_url != '') ? $this->system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $this->system->SETTINGS['thumb_show'] . '&fromfile=' . $this->security->encrypt($item_id . '/' . $pict_url, true) : $this->system->SETTINGS['siteurl'] . 'images/email_alerts/default_item_img.jpg',
			'A_URL' => $this->system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($title) . '-' . $item_id
		));		
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' ' . $this->msg['906'] . ': ' . $title;
		self::sending_email($OldWinner_email, 'no_longer_winner.inc.php', $buildSubtitle, $OldWinner_id);
	}
	public function approved($name, $language, $email)
	{		
		$this->emailer->assign_vars(array(
			'SITE_URL' => $this->system->SETTINGS['siteurl'],
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'C_NAME' => $name
		));
		$this->returnMessage = $this->msg['016_b'];
		$this->emailer->userlang = $language;		
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' ' . $this->msg['095'];
		return self::sending_email($email, 'user_approved.inc.php', $buildSubtitle);
	}
	public function user_confirmation($TPL_name_hidden, $TPL_id_hidden, $TPL_email_hidden, $TPL_nick_hidden)
	{
		$this->emailer->assign_vars(array(
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'SITEURL' => $this->system->SETTINGS['siteurl'],
			'ADMINMAIL' => $this->system->SETTINGS['adminmail'],
			'CONFIRMURL' => $this->system->SETTINGS['siteurl'] . 'confirm.php?id=' . $this->security->encrypt($TPL_id_hidden . '-' . md5($this->md5_prefix . $this->system->uncleanvars($TPL_nick_hidden))),
			'C_NAME' => $TPL_name_hidden
		));
		$this->returnMessage = sprintf($this->msg['016'], $TPL_email_hidden, $this->system->SETTINGS['sitename']);
		$buildSubtitle = $this->system->SETTINGS['sitename']. ' ' . $this->msg['098'];
		return self::sending_email($TPL_email_hidden, 'usermail.inc.php', $buildSubtitle, $TPL_id_hidden);
	}
	public function needapproval($TPL_id_hidden, $TPL_name_hidden, $TPL_nick_hidden, $TPL_address, $TPL_city, $TPL_prov, $TPL_zip, $TPL_country, $TPL_phone, $TPL_email, $TPL_password_hidden, $TPL_email_hidden)
	{
		$this->emailer->assign_vars(array(
			'C_ID' => addslashes($TPL_id_hidden),
			'C_NAME' => addslashes($TPL_name_hidden),
			'C_NICK' => addslashes($TPL_nick_hidden),
			'C_ADDRESS' => addslashes($TPL_address),
			'C_CITY' => addslashes($TPL_city),
			'C_PROV' => addslashes($TPL_prov),
			'C_ZIP' => addslashes($TPL_zip),
			'C_COUNTRY' => addslashes($TPL_country),
			'C_PHONE' => addslashes($TPL_phone),
			'C_EMAIL' => addslashes($TPL_email),
			'C_PASSWORD' => addslashes($TPL_password_hidden),
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'SITEURL' => $this->system->SETTINGS['siteurl'],
			'ADMINEMAIL' => $this->system->SETTINGS['adminmail'],
			'CONFIRMATION_PAGE' => $this->system->SETTINGS['siteurl'] . 'confirm.php?id=' . $TPL_id_hidden . '&hash=' . md5($this->md5_prefix . $TPL_nick_hidden),
			'LOGO' => $this->system->SETTINGS['siteurl'] . 'themes/' . $this->system->SETTINGS['theme'] . '/' . $this->system->SETTINGS['logo']
		));
		$this->returnMessage = $this->msg['016_a'];
		$buildSubtitle = $this->system->SETTINGS['sitename']. ' '.$this->msg['098'];
		return self::sending_email($this->system->SETTINGS['adminmail'], 'user_needapproval.inc.php', $buildSubtitle, $TPL_id_hidden);
	}
	public function requesttoadmin($name, $nick, $email, $id)
	{
		$this->emailer->assign_vars(array(
			'NAME' => $name,
			'NICK' => $nick,
			'EMAIL' => $email,
			'ID' => $id
		));
		$this->returnMessage = $this->msg['25_0142'];
		return self::sending_email($this->system->SETTINGS['adminmail'], 'buyer_request.inc.php', $this->msg['820']);
	}
	public function admin_support($sendto, $subject, $nowmessage, $sellerdata_email, $title, $userarray_email)
	{
		$this->emailer->assign_vars(array(
			'NAME' => $sendto,
			'SUBJECT' => $subject,
			'MESSAGE' => $nowmessage,
			'A_URL' => $this->system->SETTINGS['siteurl'] . 'support',
			'S_EMAIL' => $sellerdata_email,
			'SITE_URL' => $this->system->SETTINGS['siteurl'],
			'SITENAME' => $this->system->SETTINGS['sitename'],
		));		
		$buildSubtitle = $this->msg['335'] . ' ' . $this->system->SETTINGS['sitename'] . ' ( ' . $this->msg['3500_1015435'] . ' )';
		return self::sending_email($userarray_email, 'support_ticket.inc.php', $buildSubtitle);
	}
	public function reply_user($id, $nick, $name, $email)
	{
		$this->emailer->assign_vars(array(
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'SITEURL' => $this->system->SETTINGS['siteurl'],
			'ADMINMAIL' => $this->system->SETTINGS['adminmail'],
			'CONFIRMURL' => $this->system->SETTINGS['siteurl'] . 'confirm.php?id=' . $id . '&hash=' . md5($this->md5_prefix . $nick),
			'C_NAME' => $name
		));
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' ' . $this->msg['098'];
		$this->returnMessage = $this->msg['059'];
		return self::sending_email($email, 'usermail.inc.php', $buildSubtitle, $id);
	}
	public function final_value_fee_email($id, $title, $name, $uid, $email)
	{
		$this->emailer->assign_vars(array(
			'ID' => $id,
			'TITLE' => $title,
			'NAME' => $name,
			'LINK' => $this->system->SETTINGS['siteurl'] . 'pay.php?a=7&auction_id=' . $id
			));		
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' - ' . $this->msg['523'];
		return self::sending_email($email, 'final_value_fee.inc.php', $buildSubtitle, $uid);
	}
	public function buyer_fee_email($id, $title, $name, $Aid, $uid, $email)
	{		
		$this->emailer->assign_vars(array(
			'ID' => $id,
			'TITLE' => $title,
			'NAME' => $name,
			'LINK' => $this->system->SETTINGS['siteurl'] . 'pay.php?a=6&auction_id=' . $Aid
		));
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' - ' . $this->msg['522'];
		return self::sending_email($email, 'buyer_fee.inc.php', $buildSubtitle, $uid);
	}
	public function email_request($user_id, $subject, $email, $message, $user_name, $from_email)
	{		
		$this->emailer->email_uid = $user_id;
		$this->emailer->email_basic($subject, $email, $message, $from_email);
	}
	public function email_request_support($senders_name, $cleaned_question, $cleaned_subject, $senders_email, $admin_nick, $user_id, $admin_email, $sender_email)
	{		
		$this->emailer->assign_vars(array(
			'SENDER_NAME' => $senders_name,
			'SENDER_QUESTION' => stripslashes($cleaned_question),
			'SUBJECT' => stripslashes($cleaned_subject),
			'SENDER_EMAIL' => $senders_email,
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'SITEURL' => $this->system->SETTINGS['siteurl'],
			'SELLER_NICK' => $admin_nick
		));
		$this->returnMessage = $this->msg['337'] . ': <i>' . $admin_nick . '</i>';
		$subject = $this->system->SETTINGS['sitename'] . '-' . 'contact us';
		$subject2 = $this->system->SETTINGS['sitename'] . '-' . 'contact us' . '-' . '(Copy)';		
		self::sending_email($sender_email, 'email_request2.inc.php', $subject2, $user_id);
		return self::sending_email($admin_email, 'email_request.inc.php', $subject);

	}
	public function forgot_password($name, $random_pwd, $id, $email)
	{		
		$this->emailer->assign_vars(array(
			'REALNAME' => $name,
			'NEWPASS' => $random_pwd,
			'SITENAME' => $this->system->SETTINGS['sitename']
		));
		$this->returnMessage = sprintf($this->msg['3500_1015849'], $email);
		return self::sending_email($email, 'newpasswd.inc.php', $this->msg['024'], $id);
	}
	public function send_friend_email($sender_name, $sender_email, $sender_comment, $friend_name, $TPL_item_title, $id, $friend_email)
	{		
		$this->emailer->assign_vars(array(
			'S_NAME' => $sender_name,
			'S_EMAIL' => $sender_email,
			'S_COMMENT' => $sender_comment,
			'F_NAME' => $friend_name,
			'TITLE' => $TPL_item_title,
			'URL' => $this->system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($TPL_item_title) . '-' . $id,
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'THEME' => $this->system->SETTINGS['theme'],
			'SITEURL' => $this->system->SETTINGS['siteurl'],
			'ADMINEMAIL' => $this->system->SETTINGS['adminmail']
		));
		return self::sending_email($friend_email, 'friendmail.inc.php', $this->msg['905']);

	}
	public function digital_item_email($title, $name, $auction, $bid, $nick, $email, $hash, $pict_url, $id)
	{		
		$this->emailer->assign_vars(array(
			'A_TITLE' => $title,
			'W_NAME' => $name,
			'A_URL' => $this->system->SETTINGS['siteurl'] . 'products/'. generate_seo_link($title).'-' . $auction,
			'BID' => $this->system->print_money($bid),
			'S_NICK' => $nick,
			'S_EMAIL' => $email,
			'SITE_URL' => $this->system->SETTINGS['siteurl'],
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'MAXIMAGESIZE' => $this->system->SETTINGS['thumb_show'],
							
			'DIGITAL_ITEMS' => 'my_downloads.php?diupload=3&fromfile=' . $hash,
			'A_PICURL' => ($pict_url != '') ? $this->system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $this->system->SETTINGS['thumb_show'] . '&fromfile=' . $this->security->encrypt($auction . '/' . $pict_url, true) : $this->system->SETTINGS['siteurl'] . 'images/email_alerts/default_item_img.jpg',
		));
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' - ' . $this->msg['350_10177'] . ' - ' . $title;
		return self::sending_email($email, 'endauction_youwin_digital_item.inc.php', $buildSubtitle, $id);
	}
	public function digital_item_email_pt2($title, $name, $auction, $bid, $seller_nick, $seller_email, $hash, $pict_url, $winner, $email)
	{		
		$this->emailer->assign_vars(array(
			'A_TITLE' => $title,
			'W_NAME' => $name,
			'A_URL' => $this->system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($title) . '-' . $auction,
			'BID' => $this->system->print_money($bid),
			'S_NICK' => $seller_nick,
			'S_EMAIL' => $seller_email,
			'SITE_URL' => $this->system->SETTINGS['siteurl'],
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'DIGITAL_ITEMS' => 'my_downloads.php?diupload=3&fromfile=' . $hash,
			'MAXIMAGESIZE' => $this->system->SETTINGS['thumb_show'],
			'A_PICURL' => ($pict_url != '') ? $this->system->SETTINGS['siteurl'] . 'getthumb.php?w=' . $this->system->SETTINGS['thumb_show'] . '&fromfile=' . $this->security->encrypt($auction . '/' . $pict_url, true) : $this->system->SETTINGS['siteurl'] . 'images/email_alerts/default_item_img.jpg',		
		));		
		$buildSubtitle = $this->msg['335'] . ' ' . $this->system->SETTINGS['sitename'] . ' ( ' . $this->msg['337_1'] . ' ' . $this->system->uncleanvars($title) . ' )';
		return self::sending_email($email, 'endauction_youwin_digital_item.inc.php', $buildSubtitle, $winner);
	}
	public function balance_limit($name, $balance, $id, $email)
	{		
		$this->emailer->assign_vars(array(
			'SITENAME' => $this->system->SETTINGS['sitename'],

			'NAME' => $name,
			'BALANCE' => $this->system->print_money($balance, true, false),
			'OUTSTANDING' => $this->system->SETTINGS['siteurl'] . 'outstanding.php'
		));
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' - ' . $this->msg['753'];
		return self::sending_email($email, 'suspended_balance.inc.php', $buildSubtitle, $id);
	}
	public function item_watch_emails($name, $title, $bid, $id, $uid, $email)
	{		
		$this->emailer->assign_vars(array(
			'REALNAME' => $name,
			'TITLE' => $title,
			'BID' => $this->system->print_money($bid, false),
			'AUCTION_URL' => $this->system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($title) . '-' . $id
		));		
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' - ' . $this->msg['472'];
		return self::sending_email($email, 'item_watch.inc.php', $buildSubtitle, $uid);
	}
	public function messages($subject, $sendto, $nowmessage, $from_email)
	{		
		$this->emailer->email_basic($subject, $sendto, $nowmessage, $from_email);
	}
	public function submit_new_ticket($subject, $nowmessage, $user_nick)
	{		
		$this->emailer->assign_vars(array(
			'SUBJECT' => $subject,
			'MESSAGE' => $nowmessage,
			'USER' => $user_nick,
			'REPLY' => $this->msg['3500_1015439t'],
			'SITE_URL' => $this->system->SETTINGS['siteurl'],
			'SITENAME' => $this->system->SETTINGS['sitename'],
		));
		$this->returnMessage = $this->msg['3500_1015439l'];
		$buildSubtitle = $this->msg['335'] . ' ' . $this->system->SETTINGS['sitename'] . ' ( ' . $this->msg['3500_1015439t'] . ' )';
		return self::sending_email($this->system->SETTINGS['adminmail'], 'admin_ticket.inc.php', $buildSubtitle);
	}
	public function reply_to_ticket($subject, $nowmessage, $user_nick, $user_email)
	{		
		$this->emailer->assign_vars(array(
			'SUBJECT' => $subject,
			'MESSAGE' => $nowmessage,
			'USER' => $user_nick,
			'REPLY' => ($user_email == $this->system->SETTINGS['adminmail']) ? $this->msg['3500_1015439v'] : $this->msg['3500_1015435'],
			'SITE_URL' => $this->system->SETTINGS['siteurl'],
			'SITENAME' => $this->system->SETTINGS['sitename'],
		));
		$this->returnMessage = $this->msg['3500_1015439n'];
		$subtitleCheck = ($user_email == $this->system->SETTINGS['adminmail']) ? $this->msg['3500_1015439v'] : $this->msg['3500_1015435'];		
		$buildSubtitle = $this->msg['335'] . ' ' . $this->system->SETTINGS['sitename'] . ' ( ' . $subtitleCheck  . ' )';
		return self::sending_email($user_email, 'admin_ticket.inc.php', $buildSubtitle);
	}
	public function auction_watch($auction_id, $title, $name, $auc_watch, $id, $email)
	{		
		$this->emailer->assign_vars(array(
			'URL' => $this->system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($title) . '-' . $auction_id,
			'SITENAME' =>  $this->system->SETTINGS['sitename'],
			'TITLE' => $title,
			'REALNAME' => $name,
			'KWORD' => $auc_watch
		));		
		$buildSubtitle = $this->system->SETTINGS['sitename'] . '  ' . $this->msg['471'];
		return self::sending_email($email, 'auction_watchmail.inc.php', $buildSubtitle, $id);
	}
	public function auction_question($sender_name, $cleaned_question, $sender_email, $auction_id, $title, $seller_nick, $seller_id, $seller_email)
	{		
		$this->emailer->assign_vars(array(
			'SEOLINK' => $this->system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($title) . '-' . $auction_id,
			'SENDER_NAME' => $sender_name,
			'SENDER_QUESTION' => $cleaned_question,
			'SENDER_EMAIL' => $sender_email,
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'SITEURL' => $this->system->SETTINGS['siteurl'],
			'AID' => $auction_id,
			'TITLE' => $title,
			'SELLER_NICK' => $seller_nick
		));		
		$this->returnMessage = $this->msg['337'] . ': <i>' . $seller_nick . '</i>';
		$buildSubtitle = $this->msg['335'] . ' ' . $this->system->SETTINGS['sitename'] . ' ' . $this->msg['336'] . ' ' . $this->system->uncleanvars($title);
		return self::sending_email($seller_email, 'send_email.inc.php', $buildSubtitle, $seller_id);
	}
	public function watch_emails($Auction_title, $id, $watchusers_name, $watchusers_id, $watchusers_email)
	{				
		$this->emailer->assign_vars(array(
			'URL' => $this->system->SETTINGS['siteurl'] . 'products/' . generate_seo_link($Auction_title) . '-' . $id,
			'TITLE' => $Auction_title,
			'NAME' => $watchusers_name
		));
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' - ' . $this->msg['471'];
		return self::sending_email($watchusers_email, 'auctionend_watchmail.inc.php', $buildSubtitle, $watchusers_id);
	}
	public function payment_reminder($name, $balance, $id, $email)
	{		
		$this->emailer->assign_vars(array(
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'LINK' => $this->system->SETTINGS['siteurl'] . 'outstanding.php',
			'C_NAME' => $name,
			'BALANCE' => $this->system->print_money($balance)
		));		
		$this->returnMessage = $this->msg['765'];
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' ' . $this->msg['766'];
		return self::sending_email($email, 'payment_reminder.inc.php', $buildSubtitle, $id);
	}
	public function send_newsletter($id, $email, $content, $subject)
	{		
		$this->emailer->assign_vars(array(
			'SITEURL' => $this->system->SETTINGS['siteurl'],
			'SITENAME' => $this->system->SETTINGS['sitename'],
			'CONTENT' => $content,
			'SUBJECT' => $this->system->SETTINGS['sitename'] . ' ' . $this->msg['25_0079'] . ' (' .$subject . ')'
		));
		$buildSubtitle = $this->system->SETTINGS['sitename'] . ' ' . $this->msg['25_0079'] . ' (' .$subject . ')';
		$this->returnMessage = 1;
		return self::sending_email($email, 'newsletter.inc.php', $buildSubtitle, $id);
	}
	
	public function send_sms($address, $message, $subject = '')
	{
		$this->emailer->sms_sender($address, $message, $this->system->SETTINGS['adminmail'], $this->system->SETTINGS['sitename'] . ' ' . $subject);
	}
}