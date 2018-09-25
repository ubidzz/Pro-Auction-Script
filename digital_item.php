<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/



include 'common.php';

include INCLUDE_PATH . 'auction/class_sell.php';



if (!$user->checkAuth())

{

	//if your not logged in you shouldn't be here

	header("location: user_login.php");

	exit;

}



//uploading a digital item

if(isset($_GET['diupload']) && $_GET['diupload'] == 1 && isset($_FILES['file_up']))

{

	include PLUGIN_PATH . 'DigitalItemHandler/UploadHandler.php';

	$handler = new DigitalItem();

	echo $handler->UploadItem();

	exit;

}else{
	exit;
}

