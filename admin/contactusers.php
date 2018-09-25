<?php
 /*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);
$reporter = '';
$seller = '';
$auctid = '';
$displaymessage = '';
$displaymessage1 = '';
//$subject = (isset($_POST['subject'])) ? filter_var($_POST['subject'], FILTER_SANITIZE_STRING) : '';
$content = (isset($_POST['content'])) ? filter_var($_POST['content'], FILTER_SANITIZE_STRING) : '';

$seller = (isset($_GET['seller'])) ? filter_var($_GET['seller'], FILTER_SANITIZE_STRING) : '';
$seller_id = (isset($_GET['seller_id'])) ? filter_var($_GET['seller_id'], FILTER_SANITIZE_NUMBER_INT) : '';
$auctid = (isset($_GET['auction_id'])) ? filter_var($_GET['auction_id'], FILTER_SANITIZE_NUMBER_INT) : '';
$reporter = (isset($_GET['reporter'])) ? filter_var($_GET['reporter'], FILTER_SANITIZE_STRING) : '';
$reporter_id = (isset($_GET['reporter_id'])) ? filter_var($_GET['reporter_id'], FILTER_SANITIZE_NUMBER_INT) : '';
$subject1 = (isset($_GET['subject'])) ? filter_var($_GET['subject'], FILTER_SANITIZE_STRING) : '';
$title = (isset($_GET['title'])) ? urldecode($_GET['title']) : '';
$pic_url = (isset($_GET['listingpic'])) ? filter_var($_GET['listingpic'], FILTER_SANITIZE_STRING) : '';
$usersfilter = (isset($_POST['usersfilter'])) ? filter_var($_POST['usersfilter'], FILTER_SANITIZE_STRING) : '';


        
$thumbimage='<img src="' . $system->SETTINGS['siteurl'] . ((!empty($pic_url)) ? 'getthumb.php?w=120&fromfile=' . UPLOAD_FOLDER . $auctid . '/' . $pic_url : 'images/email_alerts/default_item_img.jpg') . '">';


if (isset($subject1) && !empty($subject1))
{
$subject = 'Ref: Reported Auction: ' . stripslashes($title).' (Auct.ID:' . $auctid . ')';
}

if (isset($_REQUEST['usersfilter']) &&  filter_var($_REQUEST['usersfilter'], FILTER_SANITIZE_STRING) == 'reporter')
{ $displaymessage = 'Contacting the Reporter <b>' . $reporter .'</b> (UserID:<b>' . $reporter_id . '</b>) for reported Auction ID: <b>' . $auctid . '</b></br>';
$displaymessage .= 'Seller: <b>' . $seller . '</b>  (User-ID: <b>' . $seller_id .'</b>) - reported Auction: <b>' . stripslashes($title) . '</b>';
 
}
if (isset($_REQUEST['usersfilter']) && filter_var($_REQUEST['usersfilter'], FILTER_SANITIZE_STRING) == 'seller')
{ $displaymessage = 'Contacting the Seller <b>' . $seller .'</b> (UserID:<b>' . $seller_id . '</b>) for reported Auction ID: <b>' . $auctid . '</b></br>';
$displaymessage .= 'Reporter: <b>' . $reporter . '</b>  (User-ID: <b>' . $reporter_id .'</b>)  -  Reported Auction: <b>' . stripslashes($title) . '</b>';

}
$nowmessagetoadmin = 'Regarding the Auction: ' . $title .' - Auction ID: ' . $auctid  . ' reported as ' . $subject1;
$nowmessagetoadmin = nl2br($nowmessagetoadmin);

if (isset($_POST['action']) && filter_var($_POST['action'], FILTER_SANITIZE_STRING) == 'update')
{
    if (empty($subject) || empty($content))
    {
        $ERROR = $ERR['5014'];
    }
    if (empty($_REQUEST['usersfilter']) || !isset($_REQUEST['usersfilter']))
    {
        $ERROR = $MSG['3500_1015505'];
    }
    else
    {
        $COUNTER = 0;
        
        $query = "SELECT email FROM " . $DBPrefix . "users";
        $params = array();
        $emailer = new email_handler();
        switch($usersfilter)
        {
            
            case 'seller':
                $query .= " WHERE id = :i";
                $params[] = array(':i', $seller_id, 'int');
                $displaymessage1 = '<div class="msg done"><b>Your Email has been sent to the Seller <b>' . $seller. '.</b></div>';
                $emailer->assign_vars(array(
                'S_NAME' => 'ADMIN',
                'S_EMAIL' => $system->SETTINGS['adminmail'],
                'S_COMMENT' => $content,
                'F_NAME' =>  $seller,
                'TITLE' => $title,
                'URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $auctid,
                'SITENAME' => $system->SETTINGS['sitename'],
                'SITEURL' => $system->SETTINGS['siteurl'],
                'SITE_URL' => $system->SETTINGS['siteurl'],
                //'ADMINEMAIL' => $system->SETTINGS['adminmail'],
                'SUBJECT' => $nowmessagetoadmin,
                'A_PICURL' => $thumbimage,
                ));    
                
                
                break;
            case 'reporter':
                $query .= " WHERE id = :i";
                $params[] = array(':i', $seller_id, 'int');
                $displaymessage1 = '<div class="msg done"><b>Your Email has been sent to the Reporter ' . $reporter . '.</b></div>';
                $emailer->assign_vars(array(
                'S_NAME' => 'ADMIN',
                'S_EMAIL' => $system->SETTINGS['adminmail'],
                'S_COMMENT' => $content,
                'F_NAME' =>  $reporter,
                'TITLE' => $title,
                'URL' => $system->SETTINGS['siteurl'] . 'item.php?id=' . $auctid,
                'SITENAME' => $system->SETTINGS['sitename'],
                'SITEURL' => $system->SETTINGS['siteurl'],
                'SITE_URL' => $system->SETTINGS['siteurl'],
                //'ADMINEMAIL' => $system->SETTINGS['adminmail'],
                'SUBJECT' => $nowmessagetoadmin,
                'A_PICURL' => $thumbimage,
                ));    
                break;
                
            default:
            $ERROR = $MSG['3500_1015505'];
        }
        
        if ( empty($ERROR) && isset($usersfilter) && !empty($usersfilter) )
     {
        $db->query($query, $params);
                
        $mailsento = '';
        while ($row = $db->result())
        {        $emailer->to = $row['email'];
                 $emailer->subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
                 $emailer->build_header();
                 if ( $usersfilter == 'reporter' ) { $emailer->buildmessage('report_listing_buyer.inc.php');}
                 else if ( $usersfilter == 'seller' ) { $emailer->buildmessage('report_listing_seller.inc.php' ); }
                 
            if (mail($emailer->to, $emailer->subject, $emailer->message, $emailer->headers))
            {
                $COUNTER++;
                $mailsento .= $row['email'];
            }
        }
        $ERROR = $COUNTER . substr_replace($MSG['5300'] ,"",-1) . ' to the ' . $usersfilter . ' at: ' . $mailsento;
     } else {$displaymessage1 = '<div class="msg warning"><b>Your Email has not been sent to the  ' . $usersfilter . '.</b></div>';}
    }
}

$USERSFILTER = array(
    'seller' => 'Seller',
    'reporter' => 'Reporter');

$selectsetting = (isset($_REQUEST['usersfilter'])) ? filter_var($_REQUEST['usersfilter'], FILTER_SANITIZE_STRING) : '';

$auctpict = '<div align="center"><a href="' . $system->SETTINGS['siteurl'] . 'item.php?id=' . $auctid . '" target="_blank">Auction ID: <b>' . $auctid . '</b><img src="' . $system->SETTINGS['siteurl'] . ((!empty($pic_url)) ? 'getthumb.php?w=120&fromfile=' . UPLOAD_FOLDER . $auctid . '/' . $pic_url : 'images/email_alerts/default_item_img.jpg') . '" style="padding:10px;"><br><b>' . $title . '</b></a><a href="' . $system->SETTINGS['siteurl'] . 'profile.php?user_id=' . $seller_id . '&auction_id=' . $auctid . '" target="_blank"><br>Seller: ' . $seller. '</a></div>';

loadblock($MSG['5299'], $displaymessage, generateSelect('usersfilter', $USERSFILTER, $selectsetting));
loadblock(stripslashes($auctpict), $displaymessage1, '');
loadblock($MSG['332'], '', 'text', 'subject', $subject, array($MSG['030'], $MSG['029']));
loadblock($MSG['605'], $MSG['30_0055'], $CKEditor->editor('content', stripslashes($content)));

$template->assign_vars(array(
  	'TYPENAME' => $MSG['25_0010'],
  	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['3500_1015857'],
	'PAGETITLE' => $MSG['35001015857']
));
include 'adminHeader.php';
$template->set_filenames(array(
        'body' => 'contactusers.tpl'
        ));
$template->display('body');
include 'adminFooter.php';