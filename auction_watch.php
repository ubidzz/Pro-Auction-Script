<?php/******************************************************************************* *   copyright				: (C) 2014 - 2018 Pro-Auction-Script *   site					: https://www.pro-auction-script.com *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license *******************************************************************************/include 'common.php';// If user is not logged in redirect to login pageif (!$user->checkAuth()){	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'auction_watch.php';	header('location: user_login.php');	exit;}// insert a new watch itemif (isset($_GET['insert']) && $_GET['insert'] == 'true' && !empty($_REQUEST['add'])){	$requestadd = $system->cleanvars($_REQUEST['add']);	// Check if this keyword is not already added	$auctions = trim($user->user_data['auc_watch']);	unset($match); // just incase	if (!empty($auctions))	{		$checkarray = explode(' ', $requestadd);		$requestadd = '';		foreach ($checkarray as $check)		{			if (strpos($auctions, $check) === false)			{				$requestadd .= $check . ' ';			}		}	}	if (!isset($match) || empty($match))	{		$auction_watch = trim($auctions . ' ' . $requestadd);		$query = "UPDATE " . $DBPrefix . "users SET auc_watch = :watch WHERE id = :user_id";				$params = array(			array(':watch', $system->cleanvars($auction_watch), 'str'),			array(':user_id', $user->user_data['id'], 'int')		);		$db->query($query, $params);		$user->user_data['auc_watch'] = $auction_watch;	}}// Delete auction from auction watchif (isset($_GET['delete'])){	$auctions = trim($user->user_data['auc_watch']);	$auc_id = explode(' ', $auctions);	$auction_watch = '';	for ($j = 0; $j < count($auc_id); $j++)	{		$match = strstr($auc_id[$j], $_GET['delete']);		if ($match)		{			$auction_watch = $auction_watch;		}		else		{			$auction_watch = $auc_id[$j] . ' ' . $auction_watch;		}	}	$auction_watch = trim($auction_watch);	$query = "UPDATE " . $DBPrefix . "users SET auc_watch = :watch WHERE id = :user_id";	$params = array(		array(':watch', $system->cleanvars($auction_watch), 'str'),		array(':user_id', $user->user_data['id'], 'int')	);	$db->query($query, $params);	$user->user_data['auc_watch'] = $auction_watch;}$auctions = trim($user->user_data['auc_watch']);if ($auctions != ''){	$auction = explode(' ', $auctions);	    	for ($j = 0; $j < count($auction); $j++)	{		$template->assign_block_vars('items', array(			'ITEM' => $auction[$j],			'ITEMENCODE' => urlencode($auction[$j])		));	}}$template->assign_vars(array(	'ACTIVEBUYINGTAB' => 'class="active"',	'ACTIVEAUCTIONWATCH' => 'class="active"',	'ACTIVEBUYINGPANEL' => 'active'));include 'header.php';$template->set_filenames(array(		'body' => 'auction_watch.tpl'		));$template->display('body');include 'footer.php';