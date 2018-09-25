<?php
 /*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);

// check if looking for users auctions 
$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0; 
$user_sql = isset($_GET['uid']) ? " AND a.user = " . $uid : ''; 

// Set offset and limit for pagination
if (isset($_GET['PAGE']) && is_numeric($_GET['PAGE']))
{
	$PAGE = intval($_GET['PAGE']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
elseif (isset($_SESSION['RETURN_LIST_OFFSET']) && $_SESSION['RETURN_LIST'] == 'listreportedauctions.php')
{
	$PAGE = intval($_SESSION['RETURN_LIST_OFFSET']);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}
else
{
	$OFFSET = 0;
	$PAGE = 1;
}

$_SESSION['RETURN_LIST'] = 'listreportedauctions.php';
$_SESSION['RETURN_LIST_OFFSET'] = $PAGE;

$query = "SELECT COUNT(id) As auctions FROM " . $DBPrefix . "report_listing  WHERE report_closed = 0 " . $user_sql; 
$db->direct_query($query);

$num_auctions = $db->result('auctions');
$PAGES = ($num_auctions == 0) ? 1 : ceil($num_auctions / $system->SETTINGS['perpage']);

$query = "SELECT a.id,  a.suspended, a.pict_url,  c.* FROM " . $DBPrefix . "auctions a 
        LEFT JOIN " . $DBPrefix . "users u ON (u.id = a.user) 
        LEFT JOIN " . $DBPrefix . "report_listing c ON (c.listing_id = a.id) 
        WHERE c.report_closed = :rc " . $user_sql . " ORDER BY report_date LIMIT :o, :p"; 
$params = array();
$params[] = array(':rc', 0, 'int');
$params[] = array(':o', $OFFSET, 'int');
$params[] = array(':p', $system->SETTINGS['perpage'], 'int');
$db->query($query, $params);
$username = $bg = ''; 
while ($row = $db->result()) 
{ 
$gotoreporter =  'contactusers.php?&seller=' . rawurlencode($row['seller_nick']) .'&seller_id=' . rawurlencode($row['seller_id']) . '&reporter_id='. rawurlencode($row['reporter_id']) . '&reporter=' . rawurlencode($row['reporter_nick']) . '&auction_id=' . rawurlencode($row['listing_id']) . '&subject=' . rawurlencode($row['report_reason']) . '&title=' . rawurlencode($row['listing_title']) . '&usersfilter=reporter&listingpic=' . rawurlencode($row['pict_url']) . '&offset=';

$gotoseller =  'contactusers.php?&seller=' . rawurlencode($row['seller_nick']) .'&seller_id=' . rawurlencode($row['seller_id']) . '&reporter_id='. rawurlencode($row['reporter_id']) . '&reporter=' . rawurlencode($row['reporter_nick']) . '&auction_id=' . rawurlencode($row['listing_id']) . '&subject=' . rawurlencode($row['report_reason']) . '&title=' . rawurlencode($row['listing_title']) . '&usersfilter=seller&listingpic=' . rawurlencode($row['pict_url']) . '&offset=';

$auctpict = '<div align="center"><a href="' . $system->SETTINGS['siteurl'] . 'item.php?id=' . $row['listing_id'] . '" target="_blank"><img src="' . $system->SETTINGS['siteurl'] . ((!empty($row['pict_url'])) ? 'getthumb.php?w=120&fromfile=' . UPLOAD_FOLDER . $row['listing_id'] . '/' . $row['pict_url'] : 'images/email_alerts/default_item_img.jpg') . '"></a></div>';

    $template->assign_block_vars('auctions', array( 
            'SUSPENDED' => $row['suspended'], 
            'ID' => $row['listing_id'], 
            'TITLE' => $row['listing_title'], 
            'SELLERNAME' => $row['seller_nick'], 
            'SELLERID'=>$row['seller_id'], 
            'REPORTERNAME'=>$row['reporter_nick'], 
            'REPORTERID'=>$row['reporter_id'], 
            'REPORTREASON'=>$row['report_reason'], 
            'REPORTCOMMENT'=>$row['report_comment'], 
            'REPORTDATE'=>$system->ArrangeDateAndTime($row['report_date']), 
            'REPORTID' => $row['id'],  
			'CONTREPORTER' => $gotoreporter,
			'CONTSELLER' => $gotoseller,
			'LISTINGPIC' => $row['pict_url'],
			'AUCTIONPIC' => $auctpict,
            'BG' => $bg 
            )); 
    $bg = ($bg == '') ? 'class="bg"' : ''; 
}
// this is used when viewing a users auctions 
if ((!isset($username) || empty($username)) && $uid > 0) 
{ 
    $query = "SELECT nick FROM " . $DBPrefix . "users WHERE id = :i"; 
    $params = array();
	$params[] = array(':i', $uid, 'int');
	$db->query($query, $params);
 
    $username = $db->result('nick'); 
}  

// get pagenation
$PREV = intval($PAGE - 1);
$NEXT = intval($PAGE + 1);
if ($PAGES > 1)
{
	$LOW = $PAGE - 5;
	if ($LOW <= 0) $LOW = 1;
	$COUNTER = $LOW;
	while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6))
	{
		$template->assign_block_vars('pages', array(
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/listreportedauctions.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
	'NUM_AUCTIONS' => $num_auctions,
	'B_SEARCHUSER' => ($uid > 0), 
    'USERNAME' => $username,
	'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/listreportedauctions.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
	'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/listreportedauctions.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
	'PAGE' => $PAGE,
	'PAGES' => $PAGES,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['1400'],
	'PAGETITLE' => $MSG['1400']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'listreportedauctions.tpl'
		));
$template->display('body');
include 'adminFooter.php';