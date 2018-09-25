<?php 
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php'; 
if (!isset($_REQUEST['id'])) 
{ 
    $URL = $_SESSION['RETURN_LIST']; 
    unset($_SESSION['RETURN_LIST']); 
    header('location: ' . $URL); 
    exit; 
} 


if (isset($_POST['action']) && $_POST['action'] == $MSG['030']) 
{    $id = intval($_POST['reportid']); 
    // update auction table for individial report 
        $query = "UPDATE " . $DBPrefix . "report_listing SET report_closed = :c WHERE id = :i"; 
        $params = array();
        $params[] = array(':c', 1, 'int');
		$params[] = array(':i', $id, 'int');
		$db->query($query, $params);  
     
    $message = 'this would remove the report'; 
    $URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET']; 
    unset($_SESSION['RETURN_LIST']); 
    header('location: ' . $URL); 
    exit; 
} 
elseif (isset($_POST['action']) && $_POST['action'] == $MSG['029']) 
{ 
    $message = 'this would not remove the report'; 
    $URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET']; 
    unset($_SESSION['RETURN_LIST']); 
    header('location: ' . $URL); 
    exit; 
} 
elseif (isset($_POST['action']) && $_POST['action'] == 'All') 
{   
	$id = intval($_POST['id']); 
    // update auction table for all reports on same auction 
        $query = "UPDATE " . $DBPrefix . "report_listing SET report_closed = :c WHERE listing_id = :id"; 
        $params = array();
        $params[] = array(':c', 1, 'int');
		$params[] = array(':id', $id, 'int');
		$db->query($query, $params);
         
    $message = 'this would not remove the report'; 
    $URL = $_SESSION['RETURN_LIST'] . '?offset=' . $_SESSION['RETURN_LIST_OFFSET']; 
    unset($_SESSION['RETURN_LIST']); 
    header('location: ' . $URL); 
    exit; 
} 

$query = "SELECT u.nick, a.title, a.starts, a.description, a.category, d.description as duration, 
        a.suspended, a.current_bid, a.quantity, a.reserve_price 
        FROM " . $DBPrefix . "auctions a 
        LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user) 
        LEFT JOIN " . $DBPrefix . "durations d ON (d.days = a.duration) 
        WHERE a.id = :i"; 
$params = array();
$params[] = array(':i', $_GET['id'], 'int');
$db->query($query, $params);
 
$auc_data = $db->result(); 

if ($system->SETTINGS['datesformat'] == 'USA') 
{ 
    $date = date('m/d/Y', $auc_data['starts']); 
} 
else 
{ 
    $date = date('d/m/Y', $auc_data['starts']); 
} 

$template->assign_vars(array( 
  	'ID' => $_GET['id'], 
  	'TITLE' => $auc_data['title'], 
  	'NICK' => $auc_data['nick'], 
   	'STARTS' => $date, 
 	'DURATION' => $auc_data['duration'], 
  	'DESCRIPTION' => stripslashes($auc_data['description']), 
  	'CURRENT_BID' => $system->print_money($auc_data['current_bid']), 
   	'QTY' => $auc_data['quantity'], 
   	'RESERVE_PRICE' => $system->print_money($auc_data['reserve_price']), 
  	'SUSPENDED' => $auc_data['suspended'], 
  	'OFFSET' => $_REQUEST['offset'], 
	'REPORTID' => $_REQUEST['reportid'],
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['1424'],
	'PAGETITLE' => $MSG['1424']
)); 
include 'adminHeader.php';
$template->set_filenames(array( 
        'body' => 'closereportedauctions.tpl' 
        )); 
$template->display('body');
include 'adminFooter.php';