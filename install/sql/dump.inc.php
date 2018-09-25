<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/

# 
# Table structure for table `" . $DBPrefix . "accesseshistoric`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "accesseshistoric`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "accesseshistoric` (
  `month` char(2) NOT NULL default '',
  `year` char(4) NOT NULL default '',
  `pageviews` int(11) NOT NULL default '0',
  `uniquevisitiors` int(11) NOT NULL default '0',
  `usersessions` int(11) NOT NULL default '0'
) ;";

# 
# Dumping data for table `" . $DBPrefix . "accesseshistoric`
#  

# ############################

# 
# Table structure for table `" . $DBPrefix . "accounts`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "accounts`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "accounts` (
	`id` INT(7) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`nick` VARCHAR(20) NOT NULL,
	`name` TINYTEXT NOT NULL,
	`text` TEXT NOT NULL,
	`type` VARCHAR(15) NOT NULL,
	`paid_date` VARCHAR(16) NOT NULL,
	`amount` DOUBLE(6,2) NOT NULL,
	`day` INT(3) NOT NULL,
	`week` INT(2) NOT NULL,
	`month` INT(2) NOT NULL,
	`year` INT(4) NOT NULL
)";

# 
# Dumping data for table `" . $DBPrefix . "accounts`
# 

# ############################

# 
# Table structure for table `" . $DBPrefix . "adsense`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "adsense`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "adsense` (
	`fieldname` varchar(50) NOT NULL,
	`fieldtype` varchar(10) NOT NULL,
	`value` text,
	`modifieddate` int(11) NOT NULL,
	`modifiedby` int(32) NOT NULL,
	PRIMARY KEY (`fieldname`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "adsense`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "adsense` VALUES ('header_banner_1', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "adsense` VALUES ('index_banner_2', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "adsense` VALUES ('index_banner_3', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "adsense` VALUES ('browse_banner_1', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "adsense` VALUES ('index_banner_1', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "adsense` VALUES ('user_menu_banner_1', 'str', '', UNIX_TIMESTAMP(), 1);";


# ############################

# 
# Table structure for table `" . $DBPrefix . "adminusers`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "adminusers`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "adminusers` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) COLLATE utf8_bin NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `hash` varchar(5) NOT NULL default '',
  `created` varchar(8) NOT NULL default '',
  `lastlogin` varchar(14) NOT NULL default '',
  `status` int(2) NOT NULL default '0',
  `notes` text,
  KEY `id` (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "adminusers`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "auccounter`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "auccounter`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "auccounter` (
  `auction_id` int(11) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0',
  PRIMARY KEY  (`auction_id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "auccounter`
# 

# ############################

# 
# Table structure for table `" . $DBPrefix . "auctions`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "auctions`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "auctions` (
  `id` int(32) NOT NULL auto_increment,
  `user` int(32) default NULL,
  `title` varchar(70) COLLATE utf8_bin,
  `subtitle` varchar(70) COLLATE utf8_bin,
  `starts` int(14) default NULL,
  `description` text COLLATE utf8_bin,
  `pict_url` tinytext,
  `category` int(11) default NULL,
  `secondcat` int(11) default NULL,
  `minimum_bid` double(16,2) default '0',
  `shipping_cost` double(16,2) default '0',
  `shipping_cost_additional` double(16,2) default '0',
  `reserve_price` double(16,2) default '0',
  `buy_now` double(16,2) default '0',
  `auction_type` char(1) default NULL,
  `duration` varchar(7) default NULL,
  `increment` double(8,2) NOT NULL default '0',
  `shipping` int(1) default NULL,
  `payment` tinytext,
  `international` int(1) default NULL,
  `ends` int(14) default NULL,
  `current_bid` double(16,2) default '0',
  `closed` int(1) default '0',
  `photo_uploaded` tinyint(1) default NULL,
  `quantity` int(11) default NULL,
  `suspended` int(1) default '0',
  `relist` int(11) NOT NULL default '0',
  `relisted` int(11) NOT NULL default '0',
  `num_bids` int(11) NOT NULL default '0',
  `sold` enum('y','n','s') NOT NULL default 'n',
  `shipping_terms` tinytext NOT NULL,
  `bn_only` enum('y','n') NOT NULL default 'n',
  `bold` enum('y','n') NOT NULL default 'n',
  `highlighted` enum('y','n') NOT NULL default 'n',
  `featured` enum('y','n') NOT NULL default 'n',
  `current_fee` double(16,2) default '0',
  `tax`  enum('y','n') NOT NULL default 'n',
  `taxinc`  enum('y','n') NOT NULL default 'y',
  `item_condition` varchar(40) default '',
  `item_manufacturer` varchar(32) default '',
  `item_model` varchar(32) default '',
  `item_color` varchar(32) default '',
  `item_year` varchar(11) default '',
  `returns` char(1) default NULL,
  `sell_type` enum('free','sell') NOT NULL default 'sell',
  `locationMap`  enum('y','n') NOT NULL default 'n',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
);";

# 
# Dumping data for table `" . $DBPrefix . "auctions`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "banners`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "banners`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "banners` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `type` enum('gif','jpg','png','swf') default NULL,
  `views` int(11) default NULL,
  `clicks` int(11) default NULL,
  `url` varchar(255) default NULL,
  `sponsortext` varchar(255) default NULL,
  `alt` varchar(255) default NULL,
  `purchased` int(11) NOT NULL default '0',
  `width` int(11) NOT NULL default '0',
  `height` int(11) NOT NULL default '0',
  `user` int(11) NOT NULL default '0',
  `seller` int(11) NOT NULL,
  KEY `id` (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "banners`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "bannerscategories`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "bannerscategories`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "bannerscategories` (
  `banner` int(11) NOT NULL default '0',
  `category` int(11) NOT NULL default '0'
) ;";

# 
# Dumping data for table `" . $DBPrefix . "bannerscategories`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "bannerskeywords`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "bannerskeywords`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "bannerskeywords` (
  `banner` int(11) NOT NULL default '0',
  `keyword` varchar(255) NOT NULL default ''
) ;";

# 
# Dumping data for table `" . $DBPrefix . "bannerskeywords`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "bannersstats`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "bannersstats`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "bannersstats` (
  `banner` int(11) default NULL,
  `purchased` int(11) default NULL,
  `views` int(11) default NULL,
  `clicks` int(11) default NULL,
  KEY `id` (`banner`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "bannersstats`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "bannersusers`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "bannersusers`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "bannersusers` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `company` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `seller` int(11) default NULL,
  `newuser` enum('y','n') default NULL,
  `paid` int(2) default NULL,
  `ex_banner_paid` enum('y','n') default NULL,
  `time_stamp` int(20) default NULL,
  KEY `id` (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "bannersusers`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "bids`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "bids`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "bids` (
  `id` int(11) NOT NULL auto_increment,
  `auction` int(32) default NULL,
  `bidder` int(32) default NULL,
  `bid` double(16,2) default NULL,
  `bidwhen` varchar(14) default NULL,
  `quantity` int(11) default '0',
  PRIMARY KEY  (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "bids`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "categories`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "categories`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "categories` (
  `cat_id` int(4) NOT NULL auto_increment,
  `parent_id` int(4) default NULL,
  `left_id` INT(8) NOT NULL,
  `right_id` INT(8) NOT NULL,
  `level` INT(1) NOT NULL,
  `cat_name` tinytext COLLATE utf8_bin,
  `sub_counter` int(11) default 0,
  `counter` int(11) default 0,
  `cat_color` varchar(15) default '',
  `cat_image` varchar(150) default '',
  PRIMARY KEY  (`cat_id`),
  INDEX (`left_id`, `right_id`, `level`)
);";

# 
# Dumping data for table `" . $DBPrefix . "categories`
# 

if ($_GET['cats'] == 1)
{
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(1, -1, 1, 394, -1, 'All', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(2, 1, 340, 393, 0, 'Art &amp; Antiques', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(3, 2, 391, 392, 1, 'Textiles &amp; Linens', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(4, 2, 389, 390, 1, 'Amateur Art', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(5, 2, 387, 388, 1, 'Ancient World', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(6, 2, 385, 386, 1, 'Books &amp; Manuscripts', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(7, 2, 383, 384, 1, 'Cameras', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(8, 2, 363, 382, 1, 'Ceramics &amp; Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(9, 8, 364, 381, 2, 'Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(10, 9, 379, 380, 3, '40s, 50s &amp; 60s', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(11, 9, 377, 378, 3, 'Art Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(12, 9, 375, 376, 3, 'Carnival', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(13, 9, 373, 374, 3, 'Chalkware', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(14, 9, 371, 372, 3, 'Chintz &amp; Shelley', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(15, 9, 369, 370, 3, 'Contemporary Glass', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(16, 9, 367, 368, 3, 'Decorative', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(17, 9, 365, 366, 3, 'Porcelain', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(18, 2, 361, 362, 1, 'Fine Art', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(19, 2, 359, 360, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(20, 2, 357, 358, 1, 'Musical Instruments', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(21, 2, 355, 356, 1, 'Orientalia', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(22, 2, 353, 354, 1, 'Painting', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(23, 2, 351, 352, 1, 'Photographic Images', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(24, 2, 349, 350, 1, 'Post-1900', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(25, 2, 347, 348, 1, 'Pre-1900', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(26, 2, 345, 346, 1, 'Prints', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(27, 2, 343, 344, 1, 'Scientific Instruments', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(28, 2, 341, 342, 1, 'Silver &amp; Silver Plate', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(29, 1, 262, 339, 0, 'Books', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(30, 29, 337, 338, 1, 'Animals', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(31, 29, 335, 336, 1, 'Arts, Architecture &amp; Photography', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(32, 29, 333, 334, 1, 'Audiobooks', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(33, 29, 331, 332, 1, 'Biographies &amp; Memoirs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(34, 29, 329, 330, 1, 'Business &amp; Investing', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(35, 29, 327, 328, 1, 'Catalogs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(36, 29, 325, 326, 1, 'Children', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(37, 29, 323, 324, 1, 'Computers &amp; Internet', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(38, 29, 321, 322, 1, 'Contemporary', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(39, 29, 319, 320, 1, 'Cooking, Food &amp; Wine', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(40, 29, 317, 318, 1, 'Entertainment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(41, 29, 315, 316, 1, 'Foreign Language Instruction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(42, 29, 313, 314, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(43, 29, 311, 312, 1, 'Health, Mind &amp; Body', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(44, 29, 309, 310, 1, 'Historical', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(45, 29, 307, 308, 1, 'History', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(46, 29, 305, 306, 1, 'Home &amp; Garden', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(47, 29, 303, 304, 1, 'Horror', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(48, 29, 301, 302, 1, 'Illustrated', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(49, 29, 299, 300, 1, 'Literature &amp; Fiction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(50, 29, 297, 298, 1, 'Men', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(51, 29, 295, 296, 1, 'Mystery &amp; Thrillers', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(52, 29, 293, 294, 1, 'News', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(53, 29, 291, 292, 1, 'Nonfiction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(54, 29, 289, 290, 1, 'Parenting &amp; Families', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(55, 29, 287, 288, 1, 'Poetry', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(56, 29, 285, 286, 1, 'Rare', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(57, 29, 283, 284, 1, 'Reference', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(58, 29, 281, 282, 1, 'Regency', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(59, 29, 279, 280, 1, 'Religion &amp; Spirituality', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(60, 29, 277, 278, 1, 'Science &amp; Nature', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(61, 29, 275, 276, 1, 'Science Fiction &amp; Fantasy', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(62, 29, 273, 274, 1, 'Sports', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(63, 29, 271, 272, 1, 'Sports &amp; Outdoors', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(64, 29, 269, 270, 1, 'Teens', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(65, 29, 267, 268, 1, 'Textbooks', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(66, 29, 265, 266, 1, 'Travel', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(67, 29, 263, 264, 1, 'Women', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(68, 1, 254, 261, 0, 'Clothing &amp; Accessories', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(69, 68, 259, 260, 1, 'Accessories', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(70, 68, 257, 258, 1, 'Clothing', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(71, 68, 255, 256, 1, 'Watches', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(72, 1, 248, 253, 0, 'Coins &amp; Stamps', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(73, 72, 251, 252, 1, 'Coins', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(74, 72, 249, 250, 1, 'Philately', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(75, 1, 172, 247, 0, 'Collectibles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(76, 75, 245, 246, 1, 'Advertising', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(77, 75, 243, 244, 1, 'Animals', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(78, 75, 241, 242, 1, 'Animation', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(79, 75, 239, 240, 1, 'Antique Reproductions', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(80, 75, 237, 238, 1, 'Autographs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(81, 75, 235, 236, 1, 'Barber Shop', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(82, 75, 233, 234, 1, 'Bears', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(83, 75, 231, 232, 1, 'Bells', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(84, 75, 229, 230, 1, 'Bottles &amp; Cans', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(85, 75, 227, 228, 1, 'Breweriana', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(86, 75, 225, 226, 1, 'Cars &amp; Motorcycles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(87, 75, 223, 224, 1, 'Cereal Boxes &amp; Premiums', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(88, 75, 221, 222, 1, 'Character', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(89, 75, 219, 220, 1, 'Circus &amp; Carnival', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(90, 75, 217, 218, 1, 'Collector Plates', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(91, 75, 215, 216, 1, 'Dolls', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(92, 75, 213, 214, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(93, 75, 211, 212, 1, 'Historical &amp; Cultural', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(94, 75, 209, 210, 1, 'Holiday &amp; Seasonal', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(95, 75, 207, 208, 1, 'Household Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(96, 75, 205, 206, 1, 'Kitsch', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(97, 75, 203, 204, 1, 'Knives &amp; Swords', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(98, 75, 201, 202, 1, 'Lunchboxes', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(99, 75, 199, 200, 1, 'Magic &amp; Novelty Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(100, 75, 197, 198, 1, 'Memorabilia', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(101, 75, 195, 196, 1, 'Militaria', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(102, 75, 193, 194, 1, 'Music Boxes', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(103, 75, 191, 192, 1, 'Oddities', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(104, 75, 189, 190, 1, 'Paper', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(105, 75, 187, 188, 1, 'Pinbacks', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(106, 75, 185, 186, 1, 'Porcelain Figurines', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(107, 75, 183, 184, 1, 'Railroadiana', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(108, 75, 181, 182, 1, 'Religious', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(109, 75, 179, 180, 1, 'Rocks, Minerals &amp; Fossils', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(110, 75, 177, 178, 1, 'Scientific Instruments', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(111, 75, 175, 176, 1, 'Textiles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(112, 75, 173, 174, 1, 'Tobacciana', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(113, 1, 154, 171, 0, 'Comics, Cards &amp; Science Fiction', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(114, 113, 169, 170, 1, 'Anime &amp; Manga', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(115, 113, 167, 168, 1, 'Comic Books', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(116, 113, 165, 166, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(117, 113, 163, 164, 1, 'Godzilla', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(118, 113, 161, 162, 1, 'Star Trek', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(119, 113, 159, 160, 1, 'The X-Files', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(120, 113, 157, 158, 1, 'Toys', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(121, 113, 155, 156, 1, 'Trading Cards', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(122, 1, 144, 153, 0, 'Computers &amp; Software', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(123, 122, 151, 152, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(124, 122, 149, 150, 1, 'Hardware', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(125, 122, 147, 148, 1, 'Internet Services', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(126, 122, 145, 146, 1, 'Software', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(127, 1, 132, 143, 0, 'Electronics &amp; Photography', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(128, 127, 141, 142, 1, 'Consumer Electronics', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(129, 127, 139, 140, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(130, 127, 137, 138, 1, 'Photo Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(131, 127, 135, 136, 1, 'Recording Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(132, 127, 133, 134, 1, 'Video Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(133, 1, 112, 131, 0, 'Home &amp; Garden', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(134, 133, 129, 130, 1, 'Baby Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(135, 133, 127, 128, 1, 'Crafts', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(136, 133, 125, 126, 1, 'Furniture', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(137, 133, 123, 124, 1, 'Garden', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(138, 133, 121, 122, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(139, 133, 119, 120, 1, 'Household Items', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(140, 133, 117, 118, 1, 'Pet Supplies', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(141, 133, 115, 116, 1, 'Tools &amp; Hardware', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(142, 133, 113, 114, 1, 'Weddings', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(143, 1, 98, 111, 0, 'Movies &amp; Video', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(144, 143, 109, 110, 1, 'Blueray', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(145, 143, 107, 108, 1, 'DVD', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(146, 143, 105, 106, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(147, 143, 103, 104, 1, 'HD-DVD', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(148, 143, 101, 102, 1, 'Laser Discs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(149, 143, 99, 100, 1, 'VHS', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(150, 1, 84, 97, 0, 'Music', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(151, 150, 95, 96, 1, 'CDs', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(152, 150, 93, 94, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(153, 150, 91, 92, 1, 'Instruments', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(154, 150, 89, 90, 1, 'Memorabilia', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(155, 150, 87, 88, 1, 'Records', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(156, 150, 85, 86, 1, 'Tapes', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(157, 1, 74, 83, 0, 'Office &amp; Business', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(158, 157, 81, 82, 1, 'Briefcases', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(159, 157, 79, 80, 1, 'Fax Machines', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(160, 157, 77, 78, 1, 'General Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(161, 157, 75, 76, 1, 'Pagers', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(162, 1, 58, 73, 0, 'Other Goods &amp; Services', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(163, 162, 71, 72, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(164, 162, 69, 70, 1, 'Metaphysical', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(165, 162, 67, 68, 1, 'Property', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(166, 162, 65, 66, 1, 'Services', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(167, 162, 63, 64, 1, 'Tickets &amp; Events', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(168, 162, 61, 62, 1, 'Transportation', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(169, 162, 59, 60, 1, 'Travel', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(170, 1, 50, 57, 0, 'Sports &amp; Recreation', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(171, 170, 55, 56, 1, 'Apparel &amp; Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(172, 170, 53, 54, 1, 'Exercise Equipment', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(173, 170, 51, 52, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(174, 1, 2, 49, 0, 'Toys &amp; Games', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(175, 174, 47, 48, 1, 'Action Figures', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(176, 174, 45, 46, 1, 'Beanie Babies &amp; Beanbag Toys', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(177, 174, 43, 44, 1, 'Diecast', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(178, 174, 41, 42, 1, 'Fast Food', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(179, 174, 39, 40, 1, 'Fisher-Price', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(180, 174, 37, 38, 1, 'Furby', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(181, 174, 35, 36, 1, 'Games', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(182, 174, 33, 34, 1, 'General', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(183, 174, 31, 32, 1, 'Giga Pet &amp; Tamagotchi', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(184, 174, 29, 30, 1, 'Hobbies', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(185, 174, 27, 28, 1, 'Marbles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(186, 174, 25, 26, 1, 'My Little Pony', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(187, 174, 23, 24, 1, 'Peanuts Gang', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(188, 174, 21, 22, 1, 'Pez', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(189, 174, 19, 20, 1, 'Plastic Models', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(190, 174, 17, 18, 1, 'Plush Toys', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(191, 174, 15, 16, 1, 'Puzzles', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(192, 174, 13, 14, 1, 'lot Cars', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(193, 174, 11, 12, 1, 'Teletubbies', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(194, 174, 9, 10, 1, 'Toy Soldiers', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(195, 174, 7, 8, 1, 'Vintage', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(196, 174, 5, 6, 1, 'Vintage Tin', 0, 0, '', '');";
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(197, 174, 3, 4, 1, 'Vintage Vehicles', 0, 0, '', '');";
}
else
{
	$query[] = "INSERT INTO `" . $DBPrefix . "categories` VALUES(NULL, -1, 1, 2, -1, 'All', 0, 0, '', '');";
}

# ############################

# 
# Table structure for table `" . $DBPrefix . "closedrelisted`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "closedrelisted`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "closedrelisted` (
  `auction` int(32) default '0',
  `relistdate` varchar(8) NOT NULL default '',
  `newauction` int(32) NOT NULL default '0'
) ;";

# 
# Dumping data for table `" . $DBPrefix . "closedrelisted`
# 

# Table structure for table `" . $DBPrefix . "comm_messages`

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "comm_messages`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "comm_messages` (
  `id` int(11) NOT NULL auto_increment,
  `boardid` int(11) NOT NULL default '0',
  `msgdate` varchar(14) COLLATE utf8_bin NOT NULL default '',
  `user` int(11) NOT NULL default '0',
  `username` varchar(255) COLLATE utf8_bin NOT NULL default '',
  `message` text NOT NULL,
  KEY `msg_id` (`id`)
);";

# Dumping data for table `" . $DBPrefix . "comm_messages`


# Table structure for table `" . $DBPrefix . "community`

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "community`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "community` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) COLLATE utf8_bin NOT NULL default '0',
  `messages` int(11) NOT NULL default '0',
  `lastmessage` varchar(14) NOT NULL default '0',
  `msgstoshow` int(11) NOT NULL default '0',
  `active` int(1) NOT NULL default '1',
  KEY `msg_id` (`id`)
);";

# Dumping data for table `" . $DBPrefix . "community`

$query[] = "INSERT INTO `" . $DBPrefix . "community` VALUES (1, 'Selling', 0, '', 30, 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "community` VALUES (2, 'Buying', 0, '', 30, 1);";

# ############################

# 
# Table structure for table `" . $DBPrefix . "counters`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "counters`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "counters` (
	`fieldname` VARCHAR(30) NOT NULL,
	`fieldtype` VARCHAR(10) NOT NULL,
	`value` text NOT NULL,
	`modifieddate` INT(11) NOT NULL,
	`modifiedby` INT(32) NOT NULL,
	PRIMARY KEY(`fieldname`)
)";

# 
# Dumping data for table `" . $DBPrefix . "counters`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "counters` VALUES ('users', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "counters` VALUES ('inactiveusers', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "counters` VALUES ('auctions', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "counters` VALUES ('closedauctions', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "counters` VALUES ('bids', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "counters` VALUES ('suspendedauctions', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "counters` VALUES ('itemssold', 'int', '0', UNIX_TIMESTAMP(), 1);";

# ############################

# 
# Table structure for table `" . $DBPrefix . "conditions`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "conditions`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "conditions` (
  `item_condition` varchar(40) COLLATE utf8_bin NOT NULL default '',
  `condition_desc` varchar(200) COLLATE utf8_bin default NULL
) ;";

# 
# Dumping data for table `" . $DBPrefix . "conditions`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "conditions` (`item_condition`, `condition_desc`) VALUES
('As New', 'As New: A used item that is fully functional and in excellent cosmetic condition,possibly without original packaging'),
('As New Never Used', 'As New Never Used: A brand-new unused item may not be in original packaging or packaging may not be sealed'),
('Brand New', 'Brand New: A brand-new unused unopened undamaged item ,in it&#39;s original packaging'),
('Faulty Suit Parts Only', 'Faulty Suit Parts Only: An item that has damage or is not working and is not worth repairing but may be used for parts'),
('Faulty Suit Parts or Repair', 'Faulty Suit Parts or Repair: An item that has damage or is not working and is possibly worth repairing or may be used for parts'),
('Manufacturer Refurbished', 'Manufacturer Refurbished: An item that has been restored by either the manufacturer or a professional repairer item should be perfect working order and in good cosmetic condition'),
('New Old Stock', 'New Old Stock: An item which was manufactured long ago but that has never been used and is either out of production or discontinued from the current line of product or has been sitting stored for some'),
('New With Tags', 'New With Tags: A brand-new unused and unworn item in it&#39;s original packaging if originally sold packaged with the original manufacturers tags'),
('New Without Tags', 'New Without Tags: A brand-new unused and unworn item maybe missing it&#39;s original packaging if originally sold packaged and without the original manufacturers tags'),
('Pre-Owned', 'Pre-Owned: An item that has been worn previously'),
('Seller Refurbished', 'Seller Refurbished: An item that has been restored by either the seller or a non professional repairer item should be perfect working order and in good cosmetic condition'),
('Used', 'Used: An item that has been used and may show signs of wear and tear but should be fully functional,unless stated in the item description.'),
('Factory Second', 'Factory Second: An item that is fully functional but may have some cosmectic damage ie dents or scratches');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "countries`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "countries`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "countries` (
  `country` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`country`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "countries`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Afghanistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Albania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Algeria');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('American Samoa');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Andorra');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Angola');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Anguilla');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Antarctica');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Antigua And Barbuda');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Argentina');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Armenia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Aruba');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Australia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Austria');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Azerbaijan Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bahamas');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bahrain');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bangladesh');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Barbados');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Belarus');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Belgium');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Belize');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Benin');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bermuda');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bhutan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bolivia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bosnia and Herzegowina');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Botswana');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bouvet Island');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Brazil');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('British Indian Ocean Territory');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Brunei Darussalam');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Bulgaria');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Burkina Faso');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Burma');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Burundi');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cambodia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cameroon');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Canada');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cape Verde');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cayman Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Central African Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Chad');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Chile');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('China');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Christmas Island');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cocos &#40;Keeling&#41; Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Colombia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Comoros');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Congo');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Congo, the Democratic Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cook Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Costa Rica');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cote d&#39;Ivoire');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Croatia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Cyprus');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Czech Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Denmark');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Djibouti');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Dominica');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Dominican Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('East Timor');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Ecuador');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Egypt');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('El Salvador');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Equatorial Guinea');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Eritrea');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Estonia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Ethiopia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Falkland Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Faroe Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Fiji');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Finland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('France');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('French Guiana');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('French Polynesia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('French Southern Territories');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Gabon');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Gambia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Georgia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Germany');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Ghana');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Gibraltar');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Great Britain');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Greece');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Greenland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Grenada');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Guadeloupe');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Guam');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Guatemala');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Guinea');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Guinea-Bissau');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Guyana');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Haiti');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Heard and Mc Donald Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Honduras');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Hong Kong');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Hungary');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Iceland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('India');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Indonesia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Ireland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Israel');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Italy');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Jamaica');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Japan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Jordan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Kazakhstan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Kenya');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Kiribati');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Korea &#40;South&#41;');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Kuwait');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Kyrgyzstan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Lao People&#39;s Democratic Republic');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Latvia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Lebanon');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Lesotho');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Liberia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Liechtenstein');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Lithuania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Luxembourg');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Macau');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Macedonia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Madagascar');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Malawi');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Malaysia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Maldives');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mali');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Malta');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Marshall Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Martinique');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mauritania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mauritius');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mayotte');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mexico');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Micronesia, Federated States of');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Moldova, Republic of');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Monaco');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mongolia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Montserrat');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Morocco');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Mozambique');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Namibia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Nauru');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Nepal');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Netherlands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Netherlands Antilles');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('New Caledonia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('New Zealand');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Nicaragua');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Niger');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Nigeria');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Niuev');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Norfolk Island');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Northern Mariana Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Norway');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Oman');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Pakistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Palau');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Panama');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Papua New Guinea');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Paraguay');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Peru');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Philippines');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Pitcairn');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Poland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Portugal');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Puerto Rico');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Qatar');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Reunion');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Romania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Russian Federation');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Rwanda');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Saint Kitts and Nevis');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Saint Lucia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Saint Vincent and the Grenadin');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Samoa &#40;Independent&#41;');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('San Marino');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Sao Tome and Principe');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Saudi Arabia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Senegal');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Seychelles');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Sierra Leone');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Singapore');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Slovakia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Slovenia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Solomon Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Somalia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('South Africa');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('South Georgia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Spain');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Sri Lanka');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('St. Helena');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('St. Pierre and Miquelon');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Suriname');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Svalbard and Jan Mayen Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Swaziland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Sweden');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Switzerland');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Taiwan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Tajikistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Tanzania');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Thailand');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Togo');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Tokelau');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Tonga');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Trinidad and Tobago');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Tunisia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Turkey');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Turkmenistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Turks and Caicos Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Tuvalu');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Uganda');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Ukraine');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('United Arab Emiratesv');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('United Kingdom');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('United States');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Uruguay');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Uzbekistan');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Vanuatu');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Venezuela');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Viet Nam');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Virgin Islands &#40;British&#41;');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Virgin Islands &#40;U.S.&#41;');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Wallis and Futuna Islands');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Western Sahara');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Yemen');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Zambia');";
$query[] = "INSERT INTO `" . $DBPrefix . "countries` VALUES ('Zimbabwe');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "currentaccesses`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "currentaccesses`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "currentaccesses` (
  `day` char(2) NOT NULL default '0',
  `month` char(2) NOT NULL default '0',
  `year` char(4) NOT NULL default '0',
  `pageviews` int(11) NOT NULL default '0',
  `uniquevisitors` int(11) NOT NULL default '0',
  `usersessions` int(11) NOT NULL default '0'
) ;";

# 
# Dumping data for table `" . $DBPrefix . "currentaccesses`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "currentbrowsers`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "currentbrowsers`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "currentbrowsers` (
  `month` char(2) NOT NULL default '0',
  `year` varchar(4) NOT NULL default '0',
  `browser` varchar(50) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0'
) ;";

# 
# Dumping data for table `" . $DBPrefix . "currentbrowsers`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "currentplatforms`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "currentplatforms`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "currentplatforms` (
  `month` char(2) NOT NULL default '0',
  `year` varchar(4) NOT NULL default '0',
  `platform` varchar(120) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0'
) ;";

# 
# Dumping data for table `" . $DBPrefix . "currentplatforms`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "currentbots`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "currentbots`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "currentbots` (
  `month` char(2) NOT NULL default '0',
  `year` varchar(4) NOT NULL default '0',
  `platform` varchar(120) NOT NULL default '0',
  `browser` varchar(50) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0'
) ;";

# 
# Dumping data for table `" . $DBPrefix . "currentbots`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "durations`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "durations`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "durations` (
  `days` int(11) NOT NULL default '0',
  `description` varchar(30) default NULL
) ;";

# 
# Dumping data for table `" . $DBPrefix . "durations`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (1, '1 day');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (2, '2 days');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (3, '3 days');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (7, '1 week');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (14, '2 weeks');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (21, '3 weeks');";
$query[] = "INSERT INTO `" . $DBPrefix . "durations` VALUES (30, '1 month');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "faqs`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "faqs`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "faqs` (
  `id` int(11) NOT NULL auto_increment,
  `question` varchar(200) COLLATE utf8_bin NOT NULL default '',
  `answer` longtext COLLATE utf8_bin NOT NULL,
  `category` int(11) NOT NULL default '0',
  PRIMARY KEY (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "faqs`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (1, 'Registering', 'To register as a new user, click on Register at the top of the window. You will be asked for your name, a username and password, and contact information, including your email address.\r\n\r\n<B>You must be at least 18 years of age to register.</B>!', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (2, 'Item Watch', '<p><b>Item watch</b>&nbsp;notifies you when someone bids on the auctions that you have added to your Item Watch.</p>', 3);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (3, 'What is a Dutch auction?', 'Dutch auction is a type of auction where the auctioneer begins with a high asking price which is lowered until some participant is willing to accept the auctioneer\'s price. The winning participant pays the last announced price.', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (4, 'Reporting an Auction', '<p>Report a Auction always the user to report a auction to the " . $siteName . " Support Team if that person fells that the auction has broken any " . $siteName . " rules. </p><br><p>They can click on the Report this Auction button that is located in the Additional Details tab and then Auction details. Then they would fill in the report form that gets sent to the " . $siteName . " Support Team.</p><br><p>Please Note: All reports are confidential your details will not be disclosed to the Seller </p><br><p>Please read the <a style=\"color:blue\"  href=\"https://" . $siteURL . "contents.php?show=terms\"><u> Terms & Conditions</u></a> and <a style=\"color:blue\" href=\"https://" . $siteURL . "contents.php?show=priv\"><u>Privacy Policy</u></a> pages before reporting a auction to " . $siteName . " Support Team.</p><br><p style=\"color:red\"><b>Misuse of the reporting system is not taken lightly</b></p>', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (5, 'Biding contract', '<p><strong>Biding contract: </strong>By placing a bid you are making a CONTRACT between you and the seller. Once you place a bid, you may not retract it. In some states, it is illegal to win an auction and not purchase the item. In other words, if you don&#39;t want to pay for it, don&#39;t bid!</p>', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (6, 'Buyer and Seller Arrangements', 'The buyer and seller are responsible for making their own arrangements to conclude the deal by payment and shipment. This auction merely offers a venue for buying and selling. We will not, and legally cannot, be held responsible in any way for any lack of performance by any and all parties. We simply provide a place that allows people to buy and sell. HOWEVER, do let us know of any problems. We can and will close the account of anyone who abuses our auction.', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (7, 'How do I pay for an item?', 'If you are the highest bidder when an auction closes, the item is yours, and you will need to pay the seller according to the terms of the auction. You will receive an email notifying you of your winning bid. The email will contain contact information for the seller, as well as button so that you can see the total due (shipping, handling, etc.) In some cases, sellers may opt to do calculated shipping rather than charge a flat rate, in which case you will need to contact the seller for a total amount due.', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (8, 'Bidding Basics', '</p>Buying is easy on " . $siteName . " Start by using the Search feature to find what you\'re looking for, or just browse the categories. To bid on an auction, first make sure your are registered and have logged in, then enter your maximum bid amount. Remember, that this is an auction, and you can always be outbid, so be sure to add the item to your Watch List and check it often. IMPORTANT By placing a winning bid, you are entering into a binding contract with the seller to purchase the item. Non-paying bidders may have their accounts suspended or they may be permanently banned from " . $siteName . "</p>', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (9, 'How do I retract a bid?', '<p>" . $siteName . " doesn\'t currently have a mechanism for retraction. You will be asked to confirm your bid, so please take that opportunity to double-check your bid amount. Remember that if you are the winning bidder you are obligated to follow through with the transaction. If you believe that the description of an auction item has changed significantly since you placed your bid, you are encouraged to contact the seller directly to resolve the issue. If you are unable to come to a resolution, <a href=\"https://" . $siteURL . "email_request_support.php\">contact us</a> at " . $siteName . "</p>', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (10, 'Why did I get outbid at the last second?', 'Bidding at the last second is common in all online auctions. Many bidders will wait until the last possible moment to place their bid in an effort to protect them from becoming involved in a (bidding war). We don\'t encourage last second bidding, or (sniping) for the sole reason that if your timing is off, or there is some type of delay in your information being sent through the Internet your bid may not be placed before the item bidding time ends.', 3);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (11, 'What is a Reserve Price?', '<p>Sellers will occasionally set a Reserve Price that is above the minimum starting bid, in an effort to make sure that they do not sell an item for less a specific amount. If a reserve price is in effect, then the seller does not have to sell the item unless the high bid meets or exceeds the reserve. Auctions with a reserve price will be noted in their listing, describing whether the reserve has been met or not. The actual amount of the reserve price may or may not be revealed to bidders in the auction description. When you submit a bid on a reserve price auction, one of three things might happen:</p><ol><li>If the reserve has already been met, then your bid will be submitted at one increment above the next highest competitor, in the same manner as an auction without a reserve price.</li><li>If the reserve has not been met, and your maximum bid is also less than the reserve, then your bid will be entered at one increment above the next highest competitor.</li><li>If the reserve has not been met, but your maximum bid is enough to meet the reserve, then your bid will be entered at one increment above the next highest competitor and at that point, the item will sell to the highest bidder.</li></ol><p>If your maximum was above the seller&#39;s reserve, then " . $siteURL . "&#39;s proxy bidding will defend your bid, up to your maximum. If you are the highest bidder at auction close but the reserve was not met, then seller is not obligated to complete the transaction.</p>', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (12, 'How do I view auctions that I am bidding on?', '<p>At the top of the " . $siteName . " page hover your mouse over My " . $siteName . " Panel a drop down menu will appear. Then under the Buying category click on the <a href=\"https://" . $siteURL . "yourbids.php\"> Your bids</a> link you will be able to see any items you are bidding on.</p>', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (13, 'Can I leave feedback for a buyer/seller?', '<p>You can leave feedback for a buyer or seller after an auction has closed. The feedback at " . $siteName . " is a simple positive/negative/neutral system. A feedback score is calculated on a percentage basis - for instance, five out of five positive feedback ratings equals an overall rating of 100%. To see your own feedback, or leave feedback for others, login and hovering your mouse over My " . $siteName . " Panel at the top of the " . $siteName . " page, then under My Account category click on Leave Feedback. Remember, members should do everything they can to resolve an issue before leaving negative feedback.</p>', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (14, 'What is your policy on copyright infringement?', '" . $siteName . " is essentially an open marketplace, and it is up to individual sellers to insure that items they are listing do not violate copyright law. " . $siteName . " is obligated to comply with US Copyright law and may remove auctions in violation of copyright at the request of affected intellectual property owners.', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (15, 'Basic Fees', '<p>This page sets out the fees charged by " . $siteName . ". There are no fees for browsing the site or using the services of the site, unless otherwise clearly stated.<br /><br>There are no charges for buyers, such as buyer&#39;s premium charged by many auction houses, and no charges for just browsing or searching the site, but you do need to register if you decide to bid on an item or use other facilities of the site.<br><br>The fees are charged to the seller for a &quot;normal&quot; auction. In effect the person who places the auction pays the fees.<br><br>Commission fees are charged to your account immediately a listing closes successfully and are not refundable. If a Buyer fails to make payment for an item, a commission fee refund is made only when the Procedures for non-paying bidders (NPB) has been followed and completed.<br /><br>You can find the " . $siteName . " fees by <a href=\"https://" . $siteURL . "fees.php\">Clicking Here</a>!</p>', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (16, 'Proxy bidding', 'Proxy bidding for all bids: Please bid the maximum amount you are willing to pay for this item. Your maximum amount will be kept secret; " . $siteName . " will bid on your behalf as necessary by increasing your bid by the current bid increment up until your maximum is reached. This saves you the trouble of having to keep track of the auction as it proceeds and prevents you from being outbid at the last minute unless your spending limit is exceeded. Also, in case of a tie for high bidder, earlier bids take precedence. And, keep in mind that you cannot reduce your maximum bid at a later date. If you have bid on this item before, note that your new bid must be greater than your previous bid.', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (17, 'What features does " . $siteName . " offer for free?', '<p>" . $siteName . " actually has a great list of features, including some things even the &quot;big guy&quot; doesn&#39;t offer.</p><br><p><b>Free " . $siteName . " features:</b><br />Image Gallery (upload up to 20 images) - Buy It Now - Dutch Auction - Relist - Reserve Price - Auction Setup - Extended Auction Durations (up to 3 weeks!) - Return Policy - Packing Slip - Reserve Price - Automatic Relists - Shipping Status ( The buyer and seller can update the shipping status from Item was Shipped to Item was Delivered ) - Seller Active Action Gallery (Displays the Sellers Active Auction list on the item page)</p>', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (18, 'Hide my online status', '<p>Hide my online status will allow you to browse " . $siteName . " well your online status displays offline well you are online.<br><br>You can hide your online status by checking the box for (Hide my online status) well you are filling in you username and password to login.<br><br>If you logged in to " . $siteURL . " with out checking the (Hide my online status) box and you want to hide your online status go to My " . $siteName . " panel > Edit your personal profile page and check the box for (Hide my online satus) than click save changes.</p>', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (19, 'How do I list an item I want to sell?', '<p>1. you must be a registered user and logged in</p><p>2. select the sell an item button on the home page</p><p>3. choose the category of the item you are going to sell  ex. books,clothing, etc. </p><p>4. select type of category</p><p>5. enter the item title and item subtitle (if desired) and as much information you may have on that item and pictures if you have any. select the item quantity, set the auction starting price and the required and or desired settings for your auction, and your shipping fees and any and all terms or agreements with the listed item</p><p>6. if your item is listed the way you  like it, select the submit auction button and you will see the auction preview window, this is where you can see how your auction will look like and you are able to make changes at this time please look over all of your posting and make any necessary changes before continuing</p><p>7. select the confirm auction button    </p><p>8. check your email that is registered with your " . $siteName . " account for the confirmation email</p><p>9. congratulations your item is now posted  good luck!! </p>', 2);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (20, 'How can I tell if a item was paid for?', '<p>1. Must be logged in.</p> <p>2. At the top of the " . $siteName . " page click My Account</p><p>3. Than click on WINNING DETAILS </p><p>4. You can find the Payment Status on the right side of the auction info.</p><p>5. If the item was not paid the status will display ( Waiting for Payment or Set as Paid ) </p><p>6. If the item was paid then the status will change to Paid.</p>', 2);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (21, 'Auction picture - How to create a thumnail', '<p>1. click on Choose file button (pick your image you want)<br>2. Click on Upload file button.<br><b>**</b> If the image is the first picture that was uploaded it will be displayed with a Save and Back buttons. If you choose the Save button the image will be displayed as the default image. If you choose the Back button the image will not be used as the default image<br><b>**</b>Repeat steps 1. and 2. for each picture you want to upload.<br>3.Make sure the default has been checked.)', 2);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (22, 'If an item does not sell can I relist?', '<p>If your item does not sell, you can relist as many as you\'d like. To relist an item, login and go to My " . $siteName . " panel, then under the Selling category click on the Closed Auctions link, then find your auction and click Relist.</p>', 2);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (23, 'How do I request payment for an item?', '<p>You will choose your payment method when you set up your auction listing. Payment options - Paypal. Once the auction has closed you will automatically receive an email with the buyer\'s contact information.</p>', 2);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (24, 'What is Buy-It-Now?', '<p>Buy-It-Now is an exciting optional enhancement to your listings. As a seller, if you choose to use the Buy-It-Now feature at the time of listing, you will be able to name a price at which you would be willing to sell your item to any buyer who meets your specified price. Your listing will be run as a normal auction, but will now feature a Buy-It-Now price. Buyers will have the option to buy your item instantly without waiting for the listing to end or can bid on your item as usual. </p><br><p><b>Why use Buy-It-Now?</b></p><br><table cellspacing=\"0\" cellpadding=\"8\" width=\"600\" border=\"2\"><tbody align=\"middle\"><tr bgcolor=\"#b4d0fa\"><td align=\"middle\"><b>Buyers</b></td><td align=\"middle\"><b>Sellers</b></td></tr><tr><td>Buy items without having to wait for the auction to end.</td><td>Sell your items fast, without waiting for the auction to end.</td></tr><tr><td>Quick, easy, and convenient way to shop for the holidays.</td><td>Quick, easy, and convenient way to sell items. </td></tr><tr><td>The choice to buy first or bid!</td><td>Get potential buyers to act on your items earlier</td></tr><tr><td>Buy an item at a fair price. </td><td>Sell your item for the price you want.</td></tr></tbody></table><br><p><b>How do I know an auction has a Buy-It-Now price?</b></p><p>It\'s easy! Look for the Buy Now icon:  <span class=\"buyN shadow5\"> Buy Now</span> or <img border=\"0\" align=\"absbottom\"  src=\"language/EN/images/buy_it_now.gif\"> on the search results page, and the item page itself.</p>', 3);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (25, 'How To Bid?', '<p>1. Register - You must be registered.<br>2. Learn more about the seller - Read the opinions of other users for the seller.<br>3. Learn more about the item - read the items description and ask any questions before bidding.<br>4. Ask a question - If you still have questions, then please contact the seller.<br></p>', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (26, 'Login with Facebook', '<p>You can use your facebook account to login to your " . $siteName . " account.<br /><br />1. You can link your facebook account to your " . $siteName . " account when you register for a new account on " . $siteName . ".<br /><br />2. If you have a account already on " . $siteName . " you can link your facebook account to your " . $siteName . " account in your Control Panel -&gt; Edit your personal profile page.<br /><br />3. You can unlink your facebook account from " . $siteName . " at any time in your Control Panel -&gt; &nbsp;Edit your personal profile page</p>', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (27, 'Changing language', 'You can change the language to a different language by clicking on the flag that is on the home page to change the language you want use.<br>This does not change the auctions description language.', 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs` VALUES (28, 'Unpaid items', '<p>Any unpaid items that are not paid with in 30 days will be deleted from our database and will not show up in the winner and seller control panel that the item was buaght.</p>', 1);";

# ############################

# 
# Table structure for table `" . $DBPrefix . "faqs_translated`
# 

$query[] = "DROP TABLE IF EXISTS " . $DBPrefix . "faqs_translated;";
$query[] = "CREATE TABLE `" . $DBPrefix . "faqs_translated` (
  `faq_id` int(11) NOT NULL default '0',
  `lang` char(2) NOT NULL default '',
  `question` varchar(200) COLLATE utf8_bin NOT NULL default '',
  `answer` longtext COLLATE utf8_bin NOT NULL
) ;";

# 
# Dumping data for table `" . $DBPrefix . "faqs_translated`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (1, 'EN', 'Registering', 'To register as a new user, click on Register at the top of the window. You will be asked for your name, a username and password, and contact information, including your email address.\r\n\r\n<B>You must be at least 18 years of age to register.</B>!');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (2, 'EN', 'Item Watch', '<p><b>Item watch</b>&nbsp;notifies you when someone bids on the auctions that you have added to your Item Watch.</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (3, 'EN', 'What is a Dutch auction?', 'Dutch auction is a type of auction where the auctioneer begins with a high asking price which is lowered until some participant is willing to accept the auctioneer\'s price. The winning participant pays the last announced price.');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (4, 'EN', 'Reporting an Auction', '<p>Report a Auction always the user to report a auction to the " . $siteName . " Support Team if that person fells that the auction has broken any " . $siteName . " rules. </p><br><p>They can click on the Report this Auction button that is located in the Additional Details tab and then Auction details. Then they would fill in the report form that gets sent to the " . $siteName . " Support Team.</p><br><p>Please Note: All reports are confidential your details will not be disclosed to the Seller </p><br><p>Please read the <a style=\"color:blue\"  href=\"https://" . $siteName . "contents.php?show=terms\"><u> Terms & Conditions</u></a> and <a style=\"color:blue\" href=\"https://" . $siteName . "contents.php?show=priv\"><u>Privacy Policy</u></a> pages before reporting a auction to " . $siteName . " Support Team.</p><br><p style=\"color:red\"><b>Misuse of the reporting system is not taken lightly</b></p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (5, 'EN', 'Biding contract', '<p><strong>Biding contract: </strong>By placing a bid you are making a CONTRACT between you and the seller. Once you place a bid, you may not retract it. In some states, it is illegal to win an auction and not purchase the item. In other words, if you don&#39;t want to pay for it, don&#39;t bid!</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (6, 'EN', 'Buyer and Seller Arrangements', 'The buyer and seller are responsible for making their own arrangements to conclude the deal by payment and shipment. This auction merely offers a venue for buying and selling. We will not, and legally cannot, be held responsible in any way for any lack of performance by any and all parties. We simply provide a place that allows people to buy and sell. HOWEVER, do let us know of any problems. We can and will close the account of anyone who abuses our auction.');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (7, 'EN', 'How do I pay for an item?', 'If you are the highest bidder when an auction closes, the item is yours, and you will need to pay the seller according to the terms of the auction. You will receive an email notifying you of your winning bid. The email will contain contact information for the seller, as well as button so that you can see the total due (shipping, handling, etc.) In some cases, sellers may opt to do calculated shipping rather than charge a flat rate, in which case you will need to contact the seller for a total amount due.');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (8, 'EN', 'Bidding Basics', '<p>Buying is easy on " . $siteName . "! Start by using the Search feature to find what you\'re looking for, or just browse the categories. To bid on an auction, first make sure your are registered and have logged in, then enter your maximum bid amount. Remember, that this is an auction, and you can always be outbid, so be sure to add the item to your Watch List and check it often. IMPORTANT! By placing a winning bid, you are entering into a binding contract with the seller to purchase the item. Non-paying bidders may have their accounts suspended or they may be permanently banned from " . $siteName . "</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (9, 'EN', 'How do I retract a bid?', '<p>" . $siteName . " doesn\'t currently have a mechanism for retraction. You will be asked to confirm your bid, so please take that opportunity to double-check your bid amount. Remember that if you are the winning bidder you are obligated to follow through with the transaction. If you believe that the description of an auction item has changed significantly since you placed your bid, you are encouraged to contact the seller directly to resolve the issue. If you are unable to come to a resolution, <a href=\"https://" . $siteName . "email_request_support.php\">contact us</a> at " . $siteName . "</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (10, 'EN', 'Why did I get outbid at the last second?', 'Bidding at the last second is common in all online auctions. Many bidders will wait until the last possible moment to place their bid in an effort to protect them from becoming involved in a (bidding war). We don\'t encourage last second bidding, or (sniping) for the sole reason that if your timing is off, or there is some type of delay in your information being sent through the Internet, your bid may not be placed before the item bidding time ends.');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (11, 'EN', 'What is a Reserve Price?', '<p>Sellers will occasionally set a Reserve Price that is above the minimum starting bid, in an effort to make sure that they do not sell an item for less a specific amount. If a reserve price is in effect, then the seller does not have to sell the item unless the high bid meets or exceeds the reserve. Auctions with a reserve price will be noted in their listing, describing whether the reserve has been met or not. The actual amount of the reserve price may or may not be revealed to bidders in the auction description. When you submit a bid on a reserve price auction, one of three things might happen:</p><ol><li>If the reserve has already been met, then your bid will be submitted at one increment above the next highest competitor, in the same manner as an auction without a reserve price.</li><li>If the reserve has not been met, and your maximum bid is also less than the reserve, then your bid will be entered at one increment above the next highest competitor.</li><li>If the reserve has not been met, but your maximum bid is enough to meet the reserve, then your bid will be entered at one increment above the next highest competitor and at that point, the item will sell to the highest bidder.</li></ol><p>If your maximum was above the seller&#39;s reserve, then " . $siteName . "&#39;s proxy bidding will defend your bid, up to your maximum. If you are the highest bidder at auction close but the reserve was not met, then seller is not obligated to complete the transaction.</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (12, 'EN', 'How do I view auctions that I am bidding on?', '<p>At the top of the " . $siteName . " page hover your mouse over My " . $siteName . " Panel a drop down menu will appear. Then under the Buying category click on the <a href=\"https://" . $siteName . "yourbids.php\"> Your bids</a> link you will be able to see any items you are bidding on.</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (13, 'EN', 'Can I leave feedback for a buyer/seller?', '<p>You can leave feedback for a buyer or seller after an auction has closed. The feedback at " . $siteName . " is a simple positive/negative/neutral system. A feedback score is calculated on a percentage basis - for instance, five out of five positive feedback ratings equals an overall rating of 100%. To see your own feedback, or leave feedback for others, login and hovering your mouse over My " . $siteName . " Panel at the top of the " . $siteName . " page, then under My Account category click on Leave Feedback. Remember, members should do everything they can to resolve an issue before leaving negative feedback.</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (14, 'EN', 'What is your policy on copyright infringement?', '" . $siteName . " is essentially an open marketplace, and it is up to individual sellers to insure that items they are listing do not violate copyright law. " . $siteName . " is obligated to comply with US Copyright law and may remove auctions in violation of copyright at the request of affected intellectual property owners.');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (15, 'EN', 'Basic Fees', '<p>This page sets out the fees charged by " . $siteName . ". There are no fees for browsing the site or using the services of the site, unless otherwise clearly stated.<br /><br>There are no charges for buyers, such as buyer&#39;s premium charged by many auction houses, and no charges for just browsing or searching the site, but you do need to register if you decide to bid on an item or use other facilities of the site.<br><br>The fees are charged to the seller for a &quot;normal&quot; auction. In effect the person who places the auction pays the fees.<br><br>Commission fees are charged to your account immediately a listing closes successfully and are not refundable. If a Buyer fails to make payment for an item, a commission fee refund is made only when the Procedures for non-paying bidders (NPB) has been followed and completed.<br /><br>You can find the " . $siteName . " fees by <a href=\"https://" . $siteName . "fees.php\">Clicking Here</a>!</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (16, 'EN', 'Proxy bidding', 'Proxy bidding for all bids: Please bid the maximum amount you are willing to pay for this item. Your maximum amount will be kept secret; " . $siteName . " will bid on your behalf as necessary by increasing your bid by the current bid increment up until your maximum is reached. This saves you the trouble of having to keep track of the auction as it proceeds and prevents you from being outbid at the last minute unless your spending limit is exceeded. Also, in case of a tie for high bidder, earlier bids take precedence. And, keep in mind that you cannot reduce your maximum bid at a later date. If you have bid on this item before, note that your new bid must be greater than your previous bid.');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (17, 'EN', 'What features does " . $siteName . " offer for free?', '<p>" . $siteName . " actually has a great list of features, including some things even the &quot;big guy&quot; doesn&#39;t offer.</p><br><p><b>Free " . $siteName . " features:</b><br />Image Gallery (upload up to 20 images) - Buy It Now - Dutch Auction - Relist - Reserve Price - Auction Setup - Extended Auction Durations (up to 3 weeks!) - Return Policy - Packing Slip - Reserve Price - Automatic Relists - Shipping Status ( The buyer and seller can update the shipping status from Item was Shipped to Item was Delivered ) - Seller Active Action Gallery (Displays the Sellers Active Auction list on the item page)</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (18, 'EN', 'Hide my online status', '<p>Hide my online status will allow you to browse " . $siteName . " well your online status displays offline well you are online.<br><br>You can hide your online status by checking the box for (Hide my online status) well you are filling in you username and password to login.<br><br>If you logged in to " . $siteName . " with out checking the (Hide my online status) box and you want to hide your online status go to My " . $siteName . " panel > Edit your personal profile page and check the box for (Hide my online satus) than click save changes.</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (19, 'EN', 'How do I list an item I want to sell?', '<p>1. you must be a registered user and logged in</p><p>2. select the sell an item button on the home page</p><p>3. choose the category of the item you are going to sell  ex. books,clothing, etc. </p><p>4. select type of category</p><p>5. enter the item title and item subtitle (if desired) and as much information you may have on that item and pictures if you have any. select the item quantity, set the auction starting price and the required and or desired settings for your auction, and your shipping fees and any and all terms or agreements with the listed item</p><p>6. if your item is listed the way you  like it, select the submit auction button and you will see the auction preview window, this is where you can see how your auction will look like and you are able to make changes at this time please look over all of your posting and make any necessary changes before continuing</p><p>7. select the confirm auction button    </p><p>8. check your email that is registered with your " . $siteName . " account for the confirmation email</p><p>9. congratulations your item is now posted  good luck!! </p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (20, 'EN', 'How can I tell if a item was paid for?', '<p>1. Must be logged in.</p> <p>2. At the top of the " . $siteName . " page click My Account</p><p>3. Than click on WINNING DETAILS </p><p>4. You can find the Payment Status on the right side of the auction info.</p><p>5. If the item was not paid the status will display ( Waiting for Payment or Set as Paid ) </p><p>6. If the item was paid then the status will change to Paid.</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (21, 'EN', 'Auction picture - How to create a thumnail', '<p>1. click on Choose file button (pick your image you want)<br>2. Click on Upload file button.<br><b>**</b> If the image is the first picture that was uploaded it will be displayed with a Save and Back buttons. If you choose the Save button the image will be displayed as the default image. If you choose the Back button the image will not be used as the default image<br><b>**</b>Repeat steps 1. and 2. for each picture you want to upload.<br>3.Make sure the default has been checked.)');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (22, 'EN', 'If an item does not sell can I relist?', '<p>If your item does not sell, you can relist as many as you\'d like. To relist an item, login and go to My " . $siteName . " panel, then under the Selling category click on the Closed Auctions link, then find your auction and click Relist.</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (23, 'EN', 'How do I request payment for an item?', '<p>You will choose your payment method when you set up your auction listing. Payment options - Paypal. Once the auction has closed you will automatically receive an email with the buyer\'s contact information.</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (24, 'EN', 'What is Buy-It-Now?', '<p>Buy-It-Now is an exciting optional enhancement to your listings. As a seller, if you choose to use the Buy-It-Now feature at the time of listing, you will be able to name a price at which you would be willing to sell your item to any buyer who meets your specified price. Your listing will be run as a normal auction, but will now feature a Buy-It-Now price. Buyers will have the option to buy your item instantly without waiting for the listing to end or can bid on your item as usual. </p><br><p><b>Why use Buy-It-Now?</b></p><br><table cellspacing=\"0\" cellpadding=\"8\" width=\"600\" border=\"2\"><tbody align=\"middle\"><tr bgcolor=\"#b4d0fa\"><td align=\"middle\"><b>Buyers</b></td><td align=\"middle\"><b>Sellers</b></td></tr><tr><td>Buy items without having to wait for the auction to end.</td><td>Sell your items fast, without waiting for the auction to end.</td></tr><tr><td>Quick, easy, and convenient way to shop for the holidays.</td><td>Quick, easy, and convenient way to sell items. </td></tr><tr><td>The choice to buy first or bid!</td><td>Get potential buyers to act on your items earlier</td></tr><tr><td>Buy an item at a fair price. </td><td>Sell your item for the price you want.</td></tr></tbody></table><br><p><b>How do I know an auction has a Buy-It-Now price?</b></p><p>It\'s easy! Look for the Buy Now icon:  <span class=\"buyN shadow5\"> Buy Now</span> or <img border=\"0\" align=\"absbottom\"  src=\"language/EN/images/buy_it_now.gif\"> on the search results page, and the item page itself.</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (25, 'EN', 'How To Bid?', '<p>1. Register - You must be registered.<br>2. Learn more about the seller - Read the opinions of other users for the seller.<br>3. Learn more about the item - read the items description and ask any questions before bidding.<br>4. Ask a question - If you still have questions, then please contact the seller.<br></p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (26, 'EN', 'Login with Facebook', '<p>You can use your facebook account to login to your " . $siteName . " account.<br /><br />1. You can link your facebook account to your " . $siteName . " account when you register for a new account on " . $siteName . ".<br /><br />2. If you have a account already on " . $siteName . " you can link your facebook account to your " . $siteName . " account in your Control Panel -&gt; Edit your personal profile page.<br /><br />3. You can unlink your facebook account from " . $siteName . " at any time in your Control Panel -&gt; &nbsp;Edit your personal profile page</p>');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (27, 'EN', 'Changing language', 'You can change the language to a different language by clicking on the flag that is on the home page to change the language you want use.<br>This does not change the auctions description language.');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqs_translated` VALUES (28, 'EN', 'Unpaid items', '<p>Any unpaid items that are not paid with in 30 days will be deleted from our database and will not show up in the winner and seller control panel that the item was buaght.</p>');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "faqscat_translated`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "faqscat_translated`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "faqscat_translated` (
  `id` int(11) NOT NULL default '0',
  `lang` char(2) NOT NULL default '',
  `category` varchar(255) COLLATE utf8_bin NOT NULL default ''
) ;";

# 
# Dumping data for table `" . $DBPrefix . "faqscat_translated`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "faqscat_translated` VALUES (3, 'EN', 'Buying');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqscat_translated` VALUES (1, 'EN', 'General');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqscat_translated` VALUES (2, 'EN', 'Selling');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "faqscategories`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "faqscategories`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "faqscategories` (
  `id` int(11) NOT NULL auto_increment,
  `category` varchar(200) COLLATE utf8_bin NOT NULL default '',
  PRIMARY KEY (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "faqscategories`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "faqscategories` VALUES (1, 'General');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqscategories` VALUES (2, 'Selling');";
$query[] = "INSERT INTO `" . $DBPrefix . "faqscategories` VALUES (3, 'Buying');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "favesellers`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "favesellers`;";
$query[] = "CREATE TABLE  `" . $DBPrefix . "favesellers` (
  `id` int(10) NOT NULL AUTO_INCREMENT ,
  `user_id` int(10) NOT NULL ,
  `seller_id` int(10) NOT NULL ,
  PRIMARY KEY (`id`)
);";

# 
# Dumping data for table `" . $DBPrefix . "favesellers`
# 

# ############################

# 
# Table structure for table `" . $DBPrefix . "facebookLogin`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "facebookLogin`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "facebookLogin` (
   `id` int(30) NOT NULL auto_increment,
   `fb_id` varchar(150) default NULL,
   `name` varchar(60) default NULL,
   `email` varchar(100) default NULL,
   `image` varchar(250) default NULL,
   `timestamp` int(15) default NULL,
   PRIMARY KEY  (`id`)
 ) ;";
 
# 
# Dumping data for table `" . $DBPrefix . "fblogin`
# 

# ############################

# 
# Table structure for table `" . $DBPrefix . "feedbacks`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "feedbacks`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "feedbacks` (
  `id` int(11) NOT NULL auto_increment,
  `rated_user_id` int(32) default NULL,
  `rater_user_nick` varchar(20) COLLATE utf8_bin default NULL,
  `feedback` mediumtext COLLATE utf8_bin,
  `rate` int(2) default NULL,
  `feedbackdate` INT(15) NOT NULL,
  `auction_id` int(32) NOT NULL default '0',
  `auction_title` varchar(200) COLLATE utf8_bin default NULL,
  PRIMARY KEY  (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "feedbacks`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "fees`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "fees`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "fees` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `fee_from` double(16,2) NOT NULL default '0',
  `fee_to` double(16,2) NOT NULL default '0',
  `fee_type` enum('flat', 'perc') NOT NULL default 'flat',
  `value` double(8,2) NOT NULL default '0',
  `type` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "fees`
# 

$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'signup_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'buyer_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'setup');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'hpfeat_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'bolditem_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'hlitem_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'rp_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'picture_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'subtitle_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'excat_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'relist_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'buyout_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'endauc_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'banner_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'ex_banner_fee');";
$query[] = "INSERT INTO " . $DBPrefix . "fees (value, type) VALUES (0, 'geomap_fee');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "filterwords`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "filterwords`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "filterwords` (
  `word` varchar(255) NOT NULL default ''
) ;";

# 
# Dumping data for table `" . $DBPrefix . "filterwords`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "filterwords` VALUES ('');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "gateways`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "gateways`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "gateways` (
  `fieldname` VARCHAR(30) NOT NULL,
  `fieldtype` VARCHAR(10) NOT NULL,
  `value` text NOT NULL,
  `modifieddate` INT(11) NOT NULL,
  `modifiedby` INT(32) NOT NULL,
  PRIMARY KEY(`fieldname`)
);";

#
# Dumping data for table `" .DBPrefix . "gateways`
#
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('gateways', 'str', 'paypal,authnet,worldpay,skrill,toocheckout,bank', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('paypal_address', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('paypal_required', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('paypal_active', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('authnet_address', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('authnet_password', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('authnet_required', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('authnet_active', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('worldpay_address', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('worldpay_required', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('worldpay_active', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('skrill_address', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('skrill_required', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('skrill_active', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('toocheckout_address', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('toocheckout_required', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('toocheckout_active', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('bank_name', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('bank_account', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('bank_routing', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('bank_required', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "gateways` VALUES ('bank_active', 'int', '1', UNIX_TIMESTAMP(), 1);";

# ############################

# 
# Table structure for table `" . $DBPrefix . "groups`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "groups`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "groups` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) COLLATE utf8_bin NOT NULL default '',
  `can_sell` int(1) NOT NULL default '0',
  `can_buy` int(1) NOT NULL default '0',
  `count` int(250) NOT NULL default '0',
  `auto_join` int(1) NOT NULL default '0',
  `no_fees` int(1) NOT NULL default '0',
  `no_setup_fee` int(1) NOT NULL default '0',
  `no_excat_fee` int(1) NOT NULL default '0',
  `no_subtitle_fee` int(1) NOT NULL default '0',
  `no_relist_fee` int(1) NOT NULL default '0',
  `no_picture_fee` int(1) NOT NULL default '0',
  `no_hpfeat_fee` int(1) NOT NULL default '0',
  `no_hlitem_fee` int(1) NOT NULL default '0',
  `no_bolditem_fee` int(1) NOT NULL default '0',
  `no_rp_fee` int(1) NOT NULL default '0',
  `no_buyout_fee` int(1) NOT NULL default '0',
  `no_fp_fee` int(1) NOT NULL default '0',
  `no_geomap_fee` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "groups`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "groups` VALUES (NULL, 'Seller', 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);";
$query[] = "INSERT INTO `" . $DBPrefix . "groups` VALUES (NULL, 'Buyer', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);";

# ############################

# 
# Table structure for table `" . $DBPrefix . "increments`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "increments`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "increments` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `low` double(16,2) default '0',
  `high` double(16,2) default '0',
  `increment` double(16,2) default '0',
  PRIMARY KEY  (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "increments`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 0.0000, 0.9900, 0.2800);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 1.0000, 9.9900, 0.5000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 10.0000, 29.9900, 1.0000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 30.0000, 99.9900, 2.0000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 100.0000, 249.9900, 5.0000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 250.0000, 499.9900, 10.0000);";
$query[] = "INSERT INTO `" . $DBPrefix . "increments` VALUES (NULL, 500.0000, 999.9900, 25.0000);";

# ############################

# 
# Table structure for table `" . $DBPrefix . "logs`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "logs`;";
$query[] = "CREATE TABLE  `" . $DBPrefix . "logs` (
  `id` INT(200) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `type` VARCHAR(5) NOT NULL ,
  `message` TEXT NOT NULL ,
  `action_id` INT(11) NOT NULL DEFAULT  '0',
  `user_id` INT(32) NOT NULL DEFAULT  '0',
  `ip` VARCHAR(45) NOT NULL,
  `timestamp` INT(11) NOT NULL DEFAULT  '0'
);";

# 
# Dumping data for table `" . $DBPrefix . "logs`
# 

# ############################

# 
# Table structure for table `" . $DBPrefix . "maintainance`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "maintainance`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "maintainance` (
  `fieldname` VARCHAR(30) NOT NULL,
  `fieldtype` VARCHAR(10) NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL,
  `modifieddate` INT(11) NOT NULL,
  `modifiedby` INT(32) NOT NULL,
  PRIMARY KEY(`fieldname`)
);";

# 
# Dumping data for table `" . $DBPrefix . "maintainance`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "maintainance` VALUES ('active', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "maintainance` VALUES ('superuser', 'str', 'ProAuctionScript', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "maintainance` VALUES ('maintainancetext', 'str', '<br>\r\n<center>\r\n<b>Under maintainance!!!!!!!</b>\r\n</center>', UNIX_TIMESTAMP(), 1);";

# ############################

# 
# Table structure for table `" . $DBPrefix . "membertypes`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "membertypes`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "membertypes` (
  `id` int(11) NOT NULL auto_increment,
  `feedbacks` int(11) NOT NULL default '0',
  `icon` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "membertypes`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (24, 9, 'transparent.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (22, 999999, 'starFR.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (21, 99999, 'starFV.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (20, 49999, 'starFT.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (19, 24999, 'starFY.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (23, 9999, 'starG.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (17, 4999, 'starR.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (16, 999, 'starT.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (15, 99, 'starB.gif');";
$query[] = "INSERT INTO `" . $DBPrefix . "membertypes` VALUES (14, 49, 'starY.gif');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "messages`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "messages`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "messages` (
  `id` int(50) NOT NULL AUTO_INCREMENT ,
  `sentto` int(25) NOT NULL default '0',
  `sentfrom` int(25) NOT NULL default '0',
  `fromemail` varchar(50) NOT NULL default '',
  `sentat` varchar(20) NOT NULL default '',
  `message` text COLLATE utf8_bin NOT NULL ,
  `isread` int(1) NOT NULL default '0',
  `subject` varchar(50) COLLATE utf8_bin NOT NULL default '',
  `replied` int(1) NOT NULL default '0',
  `reply_of` INT(50) NOT NULL default '0',
  `question` int(15) NOT NULL default '0',
  `public` INT(1) NOT NULL default '0',
  PRIMARY KEY (`id`)
) ;";

# ############################

# 
# Table structure for table `" . $DBPrefix . "mods`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "mods`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "mods` (
	`id` int(32) NOT NULL auto_increment,
	`mod_name` varchar(100) NOT NULL default '',
	`backup` varchar(100) NOT NULL default '',
	`mod_version` varchar(100) NOT NULL default '',
	`downloaded` enum('y','n') NOT NULL default 'n',
	`installed` enum('y','n') NOT NULL default 'n',
	`install_time` int(9) NOT NULL,
	PRIMARY KEY (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "mods`
# 

# ############################

# 
# Table structure for table `" . $DBPrefix . "news`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "news`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "news` (
  `id` int(32) NOT NULL auto_increment,
  `title` varchar(200) COLLATE utf8_bin NOT NULL default '',
  `content` text COLLATE utf8_bin NOT NULL,
  `new_date` int(8) NOT NULL default '0',
  `suspended` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "news`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "news_translated`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "news_translated`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "news_translated` (
  `id` int(11) NOT NULL default '0',
  `lang` char(2) NOT NULL default '',
  `title` varchar(255) COLLATE utf8_bin NOT NULL default '',
  `content` text COLLATE utf8_bin NOT NULL
) ;";

# 
# Dumping data for table `" . $DBPrefix . "news_translated`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "online`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "online`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "online` (
  `ID` bigint(21) NOT NULL auto_increment,
  `SESSION` varchar(32) NOT NULL default '',
  `time` bigint(21) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "online`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "pendingnotif`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "pendingnotif`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "pendingnotif` (
  `id` int(11) NOT NULL auto_increment,
  `auction_id` int(11) NOT NULL default '0',
  `seller_id` int(11) NOT NULL default '0',
  `winners` text NOT NULL,
  `auction` text NOT NULL,
  `seller` text NOT NULL,
  `thisdate` varchar(8) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "pendingnotif`
# 

# ############################

# 
# Table structure for table `" . $DBPrefix . "phpchat`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "phpchat`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "phpchat` (
  `server` varchar(32) NOT NULL default '',
  `group` varchar(64) NOT NULL default '',
  `subgroup` varchar(128) NOT NULL default '',
  `leaf` varchar(128) NOT NULL default '',
  `leafvalue` text NOT NULL,
  `timestamp` int(11) NOT NULL default 0,
  PRIMARY KEY  (`server`,`group`,`subgroup`,`leaf`),
) ;";

# 
# Dumping data for table `" . $DBPrefix . "phpchat`
# 

# ############################

# 
# Table structure for table `" . $DBPrefix . "proxybid`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "proxybid`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "proxybid` (
  `itemid` int(32) default NULL,
  `userid` int(32) default NULL,
  `bid` double(16,2) default '0'
) ;";

# 
# Dumping data for table `" . $DBPrefix . "proxybid`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "rates`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "rates`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "rates` (
  `id` int(11) NOT NULL auto_increment,
  `ime` tinytext NOT NULL,
  `valuta` tinytext NOT NULL,
  `symbol` char(3) NOT NULL default '',
  KEY `id` (`id`)
) AUTO_INCREMENT=64 ;";

# 
# Dumping data for table `" . $DBPrefix . "rates`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (1, 'Great Britain', 'Pound Sterling ', 'GBP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (2, 'Argentina', 'Argentinian Peso', 'ARS');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (3, 'Australia', 'Australian Dollar ', 'AUD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (4, 'Burma', 'Myanmar (Burma) Kyat', 'MMK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (5, 'Brazil', 'Brazilian Real ', 'BRL');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (6, 'Chile', 'Chilean Peso ', 'CLP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (7, 'China', 'Chinese Renminbi ', 'CNY');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (8, 'Colombia', 'Colombian Peso ', 'COP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (9, 'Neth. Antilles', 'Neth. Antilles Guilder', 'ANG');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (10, 'Czech. Republic', 'Czech. Republic Koruna ', 'CZK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (11, 'Denmark', 'Danish Krone ', 'DKK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (12, 'European Union', 'EURO', 'EUR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (13, 'Fiji', 'Fiji Dollar ', 'FJD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (14, 'Jamaica', 'Jamaican Dollar', 'JMD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (15, 'Trinidad & Tobago', 'Trinidad & Tobago Dollar', 'TTD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (16, 'Hong Kong', 'Hong Kong Dollar', 'HKD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (17, 'Ghana', 'Ghanaian Cedi', 'GHC');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (18, 'Iceland', 'Icelandic Krona ', 'INR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (19, 'India', 'Indian Rupee', 'INR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (20, 'Indonesia', 'Indonesian Rupiah ', 'IDR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (21, 'Israel', 'Israeli New Shekel ', 'ILS');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (22, 'Japan', 'Japanese Yen', 'JPY');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (23, 'Malaysia', 'Malaysian Ringgit', 'MYR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (24, 'Mexico', 'New Peso', 'MXN');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (25, 'Morocco', 'Moroccan Dirham ', 'MAD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (26, 'Honduras', 'Honduras Lempira', 'HNL');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (27, 'Hungaria', 'Hungarian Forint', 'HUF');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (28, 'New Zealand', 'New Zealand Dollar', 'NZD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (29, 'Norway', 'Norwege Krone', 'NOK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (30, 'Pakistan', 'Pakistan Rupee ', 'PKR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (31, 'Panama', 'Panamanian Balboa ', 'PAB');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (32, 'Peru', 'Peruvian New Sol', 'PEN');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (33, 'Philippine', 'Philippine Peso ', 'PHP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (34, 'Poland', 'Polish Zloty', 'PLN');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (35, 'Russian', 'Russian Rouble', 'RUR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (36, 'Singapore', 'Singapore Dollar ', 'SGD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (37, 'Slovakia', 'Koruna', 'SKK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (38, 'Slovenia', 'Slovenian Tolar', 'SIT');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (39, 'South Africa', 'South African Rand', 'ZAR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (40, 'South Korea', 'South Korean Won', 'KRW');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (41, 'Sri Lanka', 'Sri Lanka Rupee ', 'LKR');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (42, 'Sweden', 'Swedish Krona', 'SEK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (43, 'Switzerland', 'Swiss Franc', 'CHF');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (44, 'Taiwan', 'Taiwanese New Dollar ', 'TWD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (45, 'Thailand', 'Thailand Thai Baht ', 'THB');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (46, 'Pacific Financial Community', 'Pacific Financial Community Franc', 'CFP');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (47, 'Tunisia', 'Tunisisan Dinar', 'TND');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (48, 'Turkey', 'Turkish Lira', 'TRL');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (49, 'United States', 'U.S. Dollar', 'USD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (50, 'Venezuela', 'Bolivar ', 'VEB');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (51, 'Bahamas', 'Bahamian Dollar', 'BSD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (52, 'Croatia', 'Croatian Kuna', 'HRK');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (53, 'East Caribe', 'East Caribbean Dollar', 'XCD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (54, 'CFA Franc (African Financial Community)', 'African Financial Community Franc', 'CFA');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (55, 'Canadian', 'Canadian Dollar', 'CAD');";
$query[] = "INSERT INTO `" . $DBPrefix . "rates` VALUES (56, 'Romanian', 'Romanian Leu', 'RON');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "regionalCodes`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "regionalCodes`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "regionalCodes` (
	`id` int(11) NOT NULL auto_increment,
	`region` varchar(50) NOT NULL,
	`code` varchar(2) NOT NULL,
	PRIMARY KEY (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "regionalCodes`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Afar', 'AA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Alberta', 'AB');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'American Eskimo', 'AE');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Afrikaans', 'AF');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Anglo-French', 'AL');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Amharic', 'AM');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Arabic', 'AR');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Assamese', 'AS');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Aymara', 'AY');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Azerbaijani', 'AZ');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Bashkir', 'BA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Byelorussian', 'BE');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Bulgarian', 'BG');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Bihari', 'BH');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Bislama', 'BI');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Bengali', 'BN');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Tibetan', 'BO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Brazilian Portuguese', 'BP');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Beginning Russian', 'BR');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Catalan', 'CA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Canadian French', 'CF');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Confederation of Helvetia', 'CH');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Corsican', 'CO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Czech Republic', 'CR');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Czech', 'CS');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Welsh', 'CY');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'German', 'DE');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Danish', 'DK');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Dominican Republic', 'DR');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Bhutani', 'DZ');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'English French', 'EF');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'English German', 'EG');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'English Japanese', 'EJ');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Greek', 'EL');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'English', 'EN');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Esperanto', 'EO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'European Portuguese', 'EP');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'English Russian', 'ER');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Spanish', 'ES');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Estonian', 'ET');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Basque', 'EU');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Farsi', 'FA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Foreignish English', 'FE');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Finnish', 'FL');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Fiji', 'FJ');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Faroese', 'FO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'French', 'FR');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Frisian', 'FY');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Gaelic', 'GA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Scots Gaelic', 'GD');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Galician', 'GL');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Guarani', 'GN');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Gujarati', 'GU');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Hausa', 'HA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Hebrew', 'HE');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Hindi', 'HI');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Korean', 'HM');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Croatian', 'HR');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Hungarian', 'HU');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Armenian', 'HY');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Interlingua', 'IA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Interlingue', 'IE');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Inupiak', 'IK');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Illinois', 'IL');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Indonesian', 'IN');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Icelandic', 'IS');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Italian', 'IT');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Hebrew', 'IW');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Japanese', 'JA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Yiddish', 'JI');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Javanese', 'JV');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Georgian', 'KA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Kazakh', 'KK');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Greenlandic', 'KL');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Cambodian', 'NM');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Kannada', 'KN');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Korean', 'KO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Kashmiri', 'KS');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Kurdish', 'KU');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Kirghiz', 'KY');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Latin', 'LA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Lingala', 'LN');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Laothian', 'LO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Los Santos', 'LS');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Lithuanian', 'LT');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Latvian', 'LV');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Malagasy', 'MG');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Maori', 'MI');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Macedonian', 'MK');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Malayalam', 'ML');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Mongolian', 'MN');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Moldavian', 'MO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Marathi', 'MR');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Malay', 'MS');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Montana', 'MT');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Burmese', 'MY');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Nauru', 'NA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Nepali', 'NE');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Dutch', 'NL');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Norwegian', 'NO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'New Taiwanese', 'NT');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Occitan', 'OC');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Old French', 'OF');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Original German', 'OG');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Afan', 'OM');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Oriya', 'OR');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Punjabi', 'PA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Polish', 'PL');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Pitcairn', 'PN');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Pashto', 'PS');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Portuguese', 'PT');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Quechua', 'QU');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Russian English', 'RE');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Rhaeto-Romance', 'RM');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Kurundi', 'RN');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Romanian', 'RO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Russian', 'RU');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Kinyarwanda', 'RW');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Sanskrit', 'SA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Sardinian', 'SC');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Sindhi', 'SD');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Sentence Fragment', 'SF');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Sangho', 'SG');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Serbo-croatian', 'SH');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Sino Indian', 'SI');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Slovak', 'SK');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Slovenian', 'SL');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Samoan', 'SM');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Shona', 'SN');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Somali', 'SO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Albanian', 'SQ');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Serbian', 'SR');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Siswati', 'SS');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Sesotho', 'ST');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Sundanese', 'SU');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Swedish', 'SV');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Swahili', 'SW');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Tamil', 'TA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Telugu', 'TE');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Tajik', 'TG');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Thai', 'TH');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Tigrinya', 'TI');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Total Jive', 'TJ');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Turkmen', 'TK');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Tagalog', 'TL');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Setswana', 'TN');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Tonga', 'TO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Timor Portuguese', 'TP');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Turkish', 'TR');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Tsonga', 'TS');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Tatar', 'TT');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Twi', 'TW');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Ukraine', 'UA');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Ukrainian', 'UK');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Uppaal Language', 'UL');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Urdu', 'UR');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Uzbek', 'UZ');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Vietnamese', 'VI');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Volapuk', 'VO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Wolof', 'WO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Xhosa', 'XH');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Yoruba', 'YO');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Zagreb (Croatia)', 'ZG');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Chinese', 'ZH');";
$query[] = "INSERT INTO `" . $DBPrefix . "regionalCodes` VALUES (NULL, 'Zulu', 'ZU');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "rememberme`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "rememberme`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "rememberme` (
  `userid` int(11) NOT NULL default '0',
  `hashkey` char(32) NOT NULL default ''
) ;";

# 
# Dumping data for table `" . $DBPrefix . "rememberme`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "report_reasons`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "report_reasons`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "report_reasons` (
  `report_reason` tinytext COLLATE utf8_bin NOT NULL,
  `report_class` int(2) NOT NULL default '1'
) ;";

# 
# Dumping data for table `" . $DBPrefix . "report_reasons`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "report_reasons` (`report_reason`, `report_class`) VALUES
('Adult material', 3),
('Copyright or Trademark Violation', 3),
('Duplicate listing for one item', 3),
('Firearms, Weapons, or Knives Listed', 3),
('Fraudulent Listing Activities', 3),
('Hazardous Materials', 3),
('Illegal Plant or Animal Listed', 3),
('Inappropriate Category', 3),
('Listing in an Incorrect Category', 3),
('Misleading or Excessive Keywords', 3),
('Offensive Language used in Comments', 3),
('Offensive Language used in Listing', 3),
('Offensive or Violent Material', 3),
('Offering or Requiring Additional Purchases', 3),
('Other Illegal Activity Concerns', 3),
('Other Prohibited or Restricted Items', 3),
('Replica Item listed as Original', 3),
('Stolen Property', 3);";

# ############################

# 
# Table structure for table `" . $DBPrefix . "report_listing`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "report_listing`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "report_listing` (
  `id` int(11) NOT NULL auto_increment,
  `reporter_id` int(32) default NULL,
  `reporter_nick` varchar(64) COLLATE utf8_bin NOT NULL default '',
  `report_reason` varchar(64) COLLATE utf8_bin NOT NULL default '',
  `report_comment` mediumtext COLLATE utf8_bin,
  `report_date` int(15) NOT NULL,
  `listing_id` int(32) NOT NULL default '0',
  `listing_title` varchar(64) COLLATE utf8_bin NOT NULL default '',
  `seller_id` int(32) default NULL,
  `seller_nick` varchar(64) COLLATE utf8_bin NOT NULL default '',
  `report_closed` int(2) NOT NULL default '0',
  PRIMARY KEY (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "report_listing`
# 


# ############################

# 
# Table structure for table `" . $DBPrefix . "settings`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "settings`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "settings` (
  `fieldname` VARCHAR(30) NOT NULL,
  `fieldtype` VARCHAR(10) NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL,
  `modifieddate` INT(11) NOT NULL,
  `modifiedby` INT(32) NOT NULL,
  PRIMARY KEY(`fieldname`)
);";

#
# Dumping data for table `" .DBPrefix . "settings`
#

$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('aboutus', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('aboutustext', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('activationtype', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('admin_folder', 'str', 'admin', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('adminmail', 'str', '". $siteEmail ."', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('admin_theme', 'str', 'admin', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('ae_extend', 'int', '300', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('ae_status', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('ae_timebefore', 'int', '120', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('alert_emails', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('allowed_image_mime', 'str', 'a:4:{i:0;s:3:\"png\";i:1;s:4:\"jpeg\";i:2;s:3:\"gif\";i:3;s:3:\"jpg\";}', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('ao_bi_enabled', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('ao_hi_enabled', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('ao_hpf_enabled', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('archiveafter', 'int', 30, UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('auction_setup_types', 'int', 2, UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('authnet_sandbox', 'bool', n, UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('autorelist', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('autorelist_max', 'int', '10', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('banemail', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('banner_height', 'int', '60', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('banner_types', 'str', 'gif, jpg, jpeg, png, swf', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('banner_width', 'int', '468', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('banners', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('bn_only', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('bn_only_disable', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('bn_only_percent', 'str', '50', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('boards', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('boardsmsgs', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('buy_now', 'int', '2', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('buyerprivacy', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cache_theme', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('catsorting', 'str', 'alpha', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('catstoshow', 'int', '20', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cat_counters', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('checkout_sandbox', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('contactseller', 'str', 'always', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cookies_directive', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cookiesname', 'str', 'ProAuctionScript', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cookiespolicy', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cookiespolicytext', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('copyright', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cronlog', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('counter_auctions', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('counter_online', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('counter_sold', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('counter_users', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('counter_users_online', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cron', 'int', '2', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('currency', 'str', 'GBP', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('cust_increment', 'int', '2', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('customcode', 'str', 'ProAuctionScript', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('debugging', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('defaultcountry', 'str', 'United Kingdom', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('default_minbid', 'float', '0.99', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('defaultlanguage', 'str', 'EN', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('descriptiontag', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('digital_auctions', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('digital_item_size', 'int', '1126400', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('displayed_feilds', 'str', 'a:7:{s:17:\"birthdate_regshow\";s:1:\"y\";s:15:\"address_regshow\";s:1:\"y\";s:12:\"city_regshow\";s:1:\"y\";s:12:\"prov_regshow\";s:1:\"y\";s:15:\"country_regshow\";s:1:\"y\";s:11:\"zip_regshow\";s:1:\"y\";s:11:\"tel_regshow\";s:1:\"y\";}', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('disposable_email_block', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('datesformat', 'str', 'EUR', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('dutch_auctions', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('edit_starttime', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('encryption_key', 'str', '" . base64_encode(md5(uniqid(rand(0,99), true))) . "', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('encryptionType', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('endingsoonnumber', 'int', '8', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('errortext', 'str', '<p>An unexpected error occurred. The error has been forwarded to our technical team and will be fixed shortly</p>', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('expire_unpaid_items', 'int', '60', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('extra_cat', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('facebook_app_id', 'int', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('facebook_app_secret', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('facebook_login', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('favicon', 'str', 'favicon.ico', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fee_disable_acc', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fee_max_debt', 'float', '25.00', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fee_signup_bonus', 'float', '0.00', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fee_type', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('fees', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('freemaxpictures', 'int', '5', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('gateways', 'str', 'a:6:{s:6:\"paypal\";s:6:\"PayPal\";s:7:\"authnet\";s:13:\"Authorize.net\";s:8:\"worldpay\";s:8:\"WorldPay\";s:6:\"skrill\";s:6:\"Skrill\";s:11:\"toocheckout\";s:9:\"2Checkout\";s:4:\"bank\";s:13:\"Bank Transfer\";}', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('googleanalytics', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('googleMap', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('googleMapKey', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('helpbox', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('hotitemsnumber', 'int', '8', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('htmLawed_safe', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('htmLawed_deny_attribute', 'str', 'id, style', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('https', 'bool', '" . is_https() . "', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('https_url', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('image_captcha_length', 'int', '7', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('image_captcha_width', 'int', '230', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('invoice_thankyou', 'str', 'Thank you for shopping with us and we hope to see you return soon!', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('invoice_yellow_line', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('item_conditions', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('keywordstag', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('lastitemsnumber', 'int', '8', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('featurednumber', 'int', '8', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('liveChat', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('liveChatTitle', 'str', 'Live Chat', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('liveChatLockNick', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('liveChatPMLimit', 'int', '5', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('liveChatTextLen', 'int', '400', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('liveChatMaxMSG', 'int', '20', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('liveChatMaxDisplayMSG', 'int', '150', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('liveChatTheme', 'bool', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('loginbox', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('logo', 'str', 'logo.png', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('mail_parameter', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('mail_protocol', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('mandatory_fields', 'str', 'a:7:{s:9:\"birthdate\";s:1:\"n\";s:7:\"address\";s:1:\"y\";s:4:\"city\";s:1:\"y\";s:4:\"prov\";s:1:\"y\";s:7:\"country\";s:1:\"y\";s:3:\"zip\";s:1:\"y\";s:3:\"tel\";s:1:\"n\";}', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('maxpictures', 'int', '5', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('maxuploadsize', 'int', '3096576', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('max_image_width', 'int', '1000', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('max_image_height', 'int', '800', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('minimum_username_length', 'int', '6', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('minimum_password_length', 'int', '6', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('mod_queue', 'bool, 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('moneydecimals', 'int', '2', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('moneyformat', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('moneysymbol', 'int', '2', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('newsletter', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('newsbox', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('newstoshow', 'int', '5', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('payment_options', 'str', 'a:2:{i:0;s:13:\"Wire Transfer\";i:1;s:6:\"Cheque\";}', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('paypal_sandbox', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('perpage', 'int', '15', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('picturesgallery', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('privacypolicy', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('privacypolicytext', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('proxy_bidding', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('recaptcha_private', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('recaptcha_public', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('sessionsname', 'str', 'ProAuctionScript', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('shipping', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('shipping_conditions', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('shipping_terms', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('sitename', 'str', '" . $siteName . "', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('siteurl', 'str', '". $siteURL ."', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('skrill_sandbox', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('sms_alerts', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('smtp_authentication', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('smtp_host', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('smtp_password', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('smtp_port', 'int', '25', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('smtp_security', 'str', 'none', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('smtp_username', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('spam_register', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('spam_sendtofriend', 'int', '1', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('standard_auctions', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('subtitle', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('tax', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('taxuser', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('termspolicy', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('termspolicytext', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('timezone', 'str', 'Europe/London', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('theme', 'str', 'default', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('thumb_list', 'int', '120', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('thumb_show', 'int', '120', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('timecorrection', 'int', '0', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('upgradeAPIkey', 'str', '', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('users_email', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('usersauth', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('version', 'str', '". new_version() ."', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('watermark', 'str', 'logo.png', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('watermark_active', 'bool', 'n', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('wordsfilter', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "settings` VALUES ('worldpay_sandbox', 'bool', 'n', UNIX_TIMESTAMP(), 1);";

# ############################


# 
# Table structure for table `" . $DBPrefix . "sms_settings`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "sms_settings`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "sms_settings` (
  `user_id` int(255) NOT NULL,
  `carrier` varchar(255) NOT NULL,
  `cellPhoneNumber` varchar(15) NOT NULL,
  `loginAlert` enum('y','n') NOT NULL default 'n',
  `messageAlert` enum('y','n') NOT NULL default 'n',
  `itemWonAlert` enum('y','n') NOT NULL default 'n',
  `itemSoldAlert` enum('y','n') NOT NULL default 'n',
  `outBiddedAlert` enum('y','n') NOT NULL default 'n',
  `codeStrength` enum('y','n') NOT NULL default 'y',
  `smsActivated` enum('y','n') NOT NULL default 'n',
  `smsActivationCode` varchar(9) NOT NULL,
  `smsActivationTimer` int(13) NULL,
  `db_id` varchar(151) NOT NULL,
  PRIMARY KEY (`user_id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "sms_settings`
# 

# ############################

# 
# Table structure for table `" . $DBPrefix . "sms_ip`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "sms_ip`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "sms_ip` (
  `sms_db_id` VARCHAR(151) NOT NULL,
  `user_ips` text NOT NULL,
  `temp_user_ips` text NOT NULL,
  `temp_timer` text NOT NULL,
  `uID` int(251) NOT NULL,
  PRIMARY KEY (`sms_db_id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "sms_ip`
# 

# ############################

# 
# Table structure for table `" . $DBPrefix . "statssettings`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "statssettings`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "statssettings` (
  `fieldname` VARCHAR(30) NOT NULL,
  `fieldtype` VARCHAR(10) NOT NULL,
  `value` text NOT NULL,
  `modifieddate` INT(11) NOT NULL,
  `modifiedby` INT(32) NOT NULL,
  PRIMARY KEY(`fieldname`)
);";

# 
# Dumping data for table `" . $DBPrefix . "statssettings`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "statssettings` VALUES ('activate', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "statssettings` VALUES ('accesses', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "statssettings` VALUES ('browsers', 'bool', 'y', UNIX_TIMESTAMP(), 1);";
$query[] = "INSERT INTO `" . $DBPrefix . "statssettings` VALUES ('domains', 'bool', 'y', UNIX_TIMESTAMP(), 1);";

# ############################

# 
# Table structure for table `" . $DBPrefix . "support`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "support`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "support` (
	`id` int(128) NOT NULL auto_increment,
	`user` int(128) NOT NULL,
	`title` tinytext COLLATE utf8_bin,
	`ticket_id` varchar(50) NOT NULL,
	`status` enum('open','close') NOT NULL default 'open',
	`last_reply_user` int(255) NOT NULL,
	`last_reply_time` int(15) NOT NULL,
	`created_time` int(15) NOT NULL,
	`ticket_reply_status` enum('user','support') NOT NULL default 'support',
	PRIMARY KEY (`id`)
);";

# 
# Dumping data for table `" . $DBPrefix . "support`
# 

# ############################

# 
# Table structure for table `" . $DBPrefix . "support_messages`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "support_messages`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "support_messages` (
  `id` int(255) NOT NULL AUTO_INCREMENT ,
  `sentto` int(255) NOT NULL,
  `sentfrom` int(255) NOT NULL,
  `fromemail` varchar(255) NOT NULL,
  `sentat` int(15) NOT NULL,
  `message` text COLLATE utf8_bin,
  `subject` tinytext COLLATE utf8_bin,
  `reply_of` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "support_messages`
# 

# ############################


# 
# Table structure for table `" . $DBPrefix . "tax`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "tax`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "tax` (
	  `id` INT(2) NOT NULL AUTO_INCREMENT,
	  `tax_name` VARCHAR(30) COLLATE utf8_bin NOT NULL ,
	  `tax_rate` DOUBLE(16, 2) NOT NULL ,
	  `countries_seller` TEXT NOT NULL ,
	  `countries_buyer` TEXT NOT NULL ,
	  `fee_tax` INT(1) NOT NULL DEFAULT  '0',
	  PRIMARY KEY (`id`)
	);";

# 
# Dumping data for table `" . $DBPrefix . "tax`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "tax` VALUES (NULL, 'Site Fees', '0', '', '', '1');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "users`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "users`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "users` (
  `id` int(32) NOT NULL auto_increment,
  `nick` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) default '',
  `hash` varchar(5) default '',
  `name` tinytext COLLATE utf8_bin,
  `address` tinytext COLLATE utf8_bin,
  `city` varchar(25) COLLATE utf8_bin default '',
  `prov` varchar(20) COLLATE utf8_bin default '',
  `country` varchar(30) COLLATE utf8_bin default '',
  `zip` varchar(10) default '',
  `phone` varchar(40) default '',
  `email` varchar(50) default '',
  `reg_date` int(15) default NULL,
  `rate_sum` int(11) NOT NULL default '0',
  `rate_num` int(11) NOT NULL default '0',
  `birthdate` int(8) default '0',
  `suspended` int(1) default '0',
  `nletter` int(1) NOT NULL default '0',
  `balance` double(16,2) NOT NULL default '0',
  `auc_watch` text,
  `item_watch` text,
  `endemailmode` enum('one','cum','none') NOT NULL default 'one',
  `startemailmode` enum('yes','no') NOT NULL default 'yes',
  `emailtype` enum('html','text') NOT NULL default 'html',
  `lastlogin` datetime NOT NULL default '0000-00-00 00:00:00',
  `payment_details` text,
  `user_groups` text,
  `bn_only` enum('y','n') NOT NULL default 'y',
  `timezone` varchar(255) NOT NULL default '0',
  `paypal_email` varchar(50) default '',
  `authnet_id` varchar(50) default '',
  `authnet_pass` varchar(50) default '',
  `worldpay_id` varchar(50) default '',
  `skrill_email` varchar(50) default '',
  `toocheckout_id` varchar(50) default '',
  `language` char(2) NOT NULL default '',
  `facebook_id` varchar(100) default '',
  `avatar` varchar(250) default '',
  `is_online` int(10) NOT NULL default '0',
  `hideOnline` enum('y','n') NOT NULL default 'n',
  `bank_name` text,
  `bank_account` varchar(50) default '',
  `bank_routing` varchar(50) default '',
  `admin` int(1) NOT NULL default '0',
  `payment_reminder_sent` enum('y','n') NOT NULL default 'n',
  PRIMARY KEY (`id`)
);";

# 
# Dumping data for table `" . $DBPrefix . "users`
# 

# ############################

# 
# Table structure for table `" . $DBPrefix . "useraccounts`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "useraccounts`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "useraccounts` (
  `useracc_id` int(11) NOT NULL auto_increment,
  `auc_id` int(15) NOT NULL default '0',
  `user_id` int(15) NOT NULL default '0',
  `date` int(15) NOT NULL default '0',
  `setup` double(8,2) NOT NULL default '0',
  `featured` double(8,2) NOT NULL default '0',
  `bold` double(8,2) NOT NULL default '0',
  `highlighted` double(8,2) NOT NULL default '0',
  `subtitle` double(8,2) NOT NULL default '0',
  `relist` double(8,2) NOT NULL default '0',
  `reserve` double(8,2) NOT NULL default '0',
  `buynow` double(8,2) NOT NULL default '0',
  `image` double(8,2) NOT NULL default '0',
  `extcat` double(8,2) NOT NULL default '0',
  `signup` double(8,2) NOT NULL default '0',
  `buyer` double(8,2) NOT NULL default '0',
  `finalval` double(8,2) NOT NULL default '0',
  `geomap` double(8,2) NOT NULL default '0',
  `balance` double(8,2) NOT NULL default '0',
  `total` double(8,2) NOT NULL,
  `paid` int(1) NOT NULL default '0',
  PRIMARY KEY (`useracc_id`)
);";

# 
# Dumping data for table `" . $DBPrefix . "useraccounts`
# 

# ############################

# 
# Table structure for table `" . $DBPrefix . "usersips`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "usersips`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "usersips` (
  `id` int(11) NOT NULL auto_increment,
  `user` int(32) default NULL,
  `ip` varchar(15) default NULL,
  `type` enum('first','after') NOT NULL default 'first',
  `action` enum('accept','deny') NOT NULL default 'accept',
  PRIMARY KEY  (`id`)
) ;";

# 
# Dumping data for table `" . $DBPrefix . "usersips`
# 

# ############################

#
#Table structure for table `" . $DBPrefix . "digital_item`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "digital_items`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "digital_items` (
	`id` int(11) NOT NULL auto_increment,
	`auctions` INT(10) NOT NULL,
	`seller` INT(10) NOT NULL,
	`item` TINYTEXT NOT NULL,
	`hash` varchar(100) NOT NULL default '',
	PRIMARY KEY  (`id`)
)";

# 
# Dumping data for table `" . $DBPrefix . "digital_item`
# 

# ############################

#
#Table structure for table `" . $DBPrefix . "digital_item_mime`
#

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "digital_item_mime`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "digital_item_mime` (
	`id` int(11) NOT NULL auto_increment,
	`name` varchar(250) NOT NULL default '',
	`mine_type` varchar(250) NOT NULL default '',
	`file_extension` varchar(250) NOT NULL default '',
	`use_mime` enum('y','n') NOT NULL default 'n',
	PRIMARY KEY  (`id`)
)";

# 
# Dumping data for table `" . $DBPrefix . "digital_item_mime`
# 

$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, '7-Zip', 'application/x-7z-compressed', '7z', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'PostScript', 'application/postscript', 'ai', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Android Package Archive', 'application/vnd.android.package-archive', 'apk', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Audio Video Interleave (AVI)', 'video/x-msvideo', 'avi', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Bitmap Image File', 'image/bmp', 'bmp', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Cascading Style Sheets (CSS)', 'text/css', 'css', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Microsoft Word', 'application/msword', 'doc', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'PostScript', 'application/x-7z-compressed', '7z', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Microsoft Application', 'application/x-msdownload', 'exe', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Flash Video', 'video/x-f4v', 'f4v', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Flash Video', 'video/x-flv', 'flv', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Graphics Interchange Format', 'image/gif', 'gif', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'H.261', 'video/h261', 'h261', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'H.263', 'video/h263', 'h263', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'H.264', 'video/h264', 'h264', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'HyperText Markup Language (HTM)', 'text/html', 'htm', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'HyperText Markup Language (HTML)', 'text/html', 'html', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Icon Image', 'image/x-icon', 'ico', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Java Archive', 'application/java-archive', 'jar', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'JPEG Image', 'image/jpeg', 'jpe', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'JPEG Image', 'image/jpg', 'jpeg', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'JPEG Image', 'image/jpg', 'jpg', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'JavaScript', 'application/javascript', 'js', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'JavaScript Object Notation (JSON)', 'application/json', 'json', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'M4v', 'video/x-m4v', 'm4v', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Quicktime Video', 'video/quicktime', 'mov', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'MPEG-3 Audio', 'audio/mpeg', 'mp3', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'MPEG-4 Video', 'video/mp4', 'mp4', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'MPEG-4 Audio', 'audio/mp4', 'mp4a', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'MPEG Video', 'video/mpeg', 'mpeg', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'MPEG Audio', 'audio/mpeg', 'mpga', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'OpenDocument Spreadsheet', 'application/vnd.oasis.opendocument.spreadsheet', 'ods', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'OpenDocument Text', 'application/vnd.oasis.opendocument.text', 'odt', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Adobe Portable Document Format', 'application/pdf', 'pdf', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Portable Network Graphics (PNG)', 'image/png', 'png', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Microsoft PowerPoint', 'application/vnd.ms-powerpoint', 'ppt', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'PostScript', 'application/postscript', 'ps', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Photoshop Document', 'image/vnd.adobe.photoshop', 'psd', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Quicktime Video', 'video/quicktime', 'qt', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'RAR Archive', 'application/x-rar-compressed', 'rar', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Rich Text Format', 'application/rtf', 'rtf', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Digital Video Broadcasting', 'application/vnd.dvb.service', 'svc', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Scalable Vector Graphics (SVG)', 'image/svg+xml', 'svg', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Scalable Vector Graphics (SVG)', 'image/svg+xml', 'svgz', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Adobe Flash', 'application/x-shockwave-flash', 'swf', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Tagged Image File Format', 'image/tiff', 'tif', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Tagged Image File Format', 'image/tiff', 'tiff', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Text File', 'text/plain', 'txt', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Microsoft Windows Media', 'video/x-ms-wm', 'wm', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Microsoft Windows Media Audio', 'audio/x-ms-wma', 'wma', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Microsoft Excel', 'application/vnd.ms-excel', 'xls', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'XML - Extensible Markup Language', 'application/xml', 'xml', 'n');";
$query[] = "INSERT INTO `" . $DBPrefix . "digital_item_mime` VALUES (NULL, 'Zip Archive', 'application/zip', 'zip', 'n');";

# ############################

# 
# Table structure for table `" . $DBPrefix . "winners`
# 

$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "winners`;";
$query[] = "CREATE TABLE `" . $DBPrefix . "winners` (
  `id` int(11) NOT NULL auto_increment,
  `auction` int(32) NOT NULL default '0',
  `seller` int(32) NOT NULL default '0',
  `winner` int(32) NOT NULL default '0',
  `bid` double(16,2) NOT NULL default '0',
  `closingdate` int(15) NOT NULL default '0',
  `feedback_win` tinyint(1) NOT NULL default '0',
  `feedback_sel` tinyint(1) NOT NULL default '0',
  `qty` int(11) NOT NULL default '1',
  `paid` int(1) NOT NULL default '0',
  `bf_paid` INT(1) NOT NULL DEFAULT  '0',
  `ff_paid` INT(1) NOT NULL DEFAULT '1',
  `shipped` INT(1) NOT NULL DEFAULT '0',
  `is_read` INT(1) NOT NULL DEFAULT '0',
  `is_counted` enum('y','n') NOT NULL DEFAULT 'n',
  `shipper` tinytext,
  `shipper_url` text,
  `tracking_number` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ;";
?>