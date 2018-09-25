<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

// If $id is not defined -> error
if (!isset($_GET['id']))
{
	$URL = $_SESSION['RETURN_LIST'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}

$id = intval($_GET['id']);

// Retrieve auction's data
$query = "SELECT a.title, a.minimum_bid, a.starts, a.ends, a.auction_type, u.name, u.nick FROM " . $DBPrefix . "auctions a
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user)
		WHERE a.id = :i";
$params = array();
$params[] = array(':i', $id, 'int');
$db->query($query, $params);
if ($db->numrows() == 0)
{
	$URL = $_SESSION['RETURN_LIST'];
	unset($_SESSION['RETURN_LIST']);
	header('location: ' . $URL);
	exit;
}

$AUCTION = $db->result();

// Retrieve winners
$query = "SELECT w.bid, w.qty, u.name, u.nick FROM " . $DBPrefix . "winners w
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = w.winner)
		WHERE w.auction = :i";
$params = array();
$params[] = array(':i', $id, 'int');
$db->query($query, $params);
$winners = false;
while ($row = $db->result())
{
	$winners = true;
	$template->assign_block_vars('winners', array(
		'W_NICK' => $row['nick'],
		'W_NAME' => $row['name'],
		'BID' => $system->print_money($row['bid']),
		'QTY' => $row['qty']
		));
}

// Retrieve bids
$query = "SELECT b.bid, b.quantity, u.name, u.nick FROM " . $DBPrefix . "bids b
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = b.bidder)
		WHERE b.auction = :i";
$params = array();
$params[] = array(':i', $id, 'int');
$db->query($query, $params);
$bids = false;
while ($row = $db->result())
{
	$bids = true;
	$template->assign_block_vars('bids', array(
		'W_NICK' => $row['nick'],
		'W_NAME' => $row['name'],
		'BID' => $system->print_money($row['bid']),
		'QTY' => $row['quantity']
		));
}

$template->assign_vars(array(
	'ID' => $id,
	'TITLE' => $AUCTION['title'],
	'S_NICK' => $AUCTION['nick'],
	'S_NAME' => $AUCTION['name'],
	'MIN_BID' => $system->print_money($AUCTION['minimum_bid']),
	'STARTS' => $system->dateToTimestamp($AUCTION['starts']),
	'ENDS' => $system->dateToTimestamp($AUCTION['ends']),
	'AUCTION_TYPE' => $system->SETTINGS['auction_types'][$AUCTION['auction_type']],
	'B_WINNERS' => $winners,
	'B_BIDS' => $bids,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => isset($current_page) ? $current_page : '',
	'PAGETITLE' => isset($current_page) ? $current_page : ''
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'viewwinners.tpl'
		));
$template->display('body');
include 'adminFooter.php';