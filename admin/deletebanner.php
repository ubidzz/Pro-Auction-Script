<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

if (!isset($_GET['banner']) || empty($_GET['banner']))
{
	header('location: managebanners.php');
	exit;
}

$banner = $_GET['banner'];

$query = "SELECT name, user FROM " . $DBPrefix . "banners WHERE id = :banner_id";
$params = array();
$params[] = array(':banner_id', $banner, 'int');
$db->query($query, $params);
$data = $db->result();
$bannername = $data['name'];
$banneruser = $data['user'];


$query = "DELETE FROM " . $DBPrefix . "banners WHERE id = :banner_id";
$params = array();
$params[] = array(':banner_id', $banner, 'int');
$db->query($query, $params);

$query = "DELETE FROM " . $DBPrefix . "bannerscategories WHERE banner = :banner_id";
$params = array();
$params[] = array(':banner_id', $banner, 'int');
$db->query($query, $params);

$query = "DELETE FROM " . $DBPrefix . "bannerskeywords WHERE banner = :banner_id";
$params = array();
$params[] = array(':banner_id', $banner, 'int');
$db->query($query, $params);

@unlink(UPLOAD_PATH . 'banners/' . $banneruser . '/' . $bannername);

// Redirect
header('location: userbanners.php?id=' . $banneruser);
