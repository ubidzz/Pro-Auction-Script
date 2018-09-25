<?php
include 'common.php';
// If user is not logged in redirect to login page
if (!$user->checkAuth())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'deletebanner.php';
	header('location: user_login.php');
	exit;
}

if (!isset($_GET['banner']) || empty($_GET['banner']))
{
	header('location: managebanners.php');
	exit;
}

$banner = $_GET['banner'];
$id = $_GET['id'];


$query = "SELECT name, user, id FROM " . $DBPrefix . "banners WHERE id = :banner";
$params = array(
	array(':banner', $banner, 'int')
);
$db->query($query, $params);
$banners_info = $db->result();
$bannername = $banners_info ['name'];
$banneruser = $banners_info ['user'];
$checkid = $banners_info ['id'];

if($checkid > 0)
{
	$query = "UPDATE " . $DBPrefix . "bannersusers SET newuser = :yes WHERE id = :banner_user_id";
    $params = array(
    	array(':yes', 'y', 'str'),
		array(':banner_user_id', $id, 'int')
	);
	$db->query($query, $params);
}

$query = "DELETE FROM " . $DBPrefix . "banners WHERE id = :banner_id";
$params = array(
	array(':banner_id', $banner, 'int')
);
$db->query($query, $params);

$query = "DELETE FROM " . $DBPrefix . "bannerscategories WHERE banner = :banner_categories";
$params = array(
	array(':banner_categories', $banner, 'int')
);
$db->query($query, $params);

$query = "DELETE FROM " . $DBPrefix . "bannerskeywords WHERE banner = :banner_keywords";
$params = array(
	array(':banner_keywords', $banner, 'int')
);
$db->query($query, $params);
@unlink(UPLOAD_PATH . 'banners/' . $banneruser . '/' . $bannername);

// Redirect
header('location: managebanners.php');