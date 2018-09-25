<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

$banner = $_GET['banner'];

// Retrieve filters
$query = "SELECT * FROM " . $DBPrefix . "bannerscategories WHERE banner = :i";
$params = array();
$params[] = array(':i', $banner, 'int');
$db->query($query, $params);

if ($db->numrows() > 0)
{
	while ($row = $db->result())
	{
		$query = "SELECT cat_name FROM " . $DBPrefix . "categories WHERE cat_id = :c";
		$params = array();
		$params[] = array(':c', $row['category'], 'str');
		$db->query($query, $params);

		$res_ = @$db->result('cat_name');
		if ($res_ && @$db->numrows('cat_name') > 0)
		{
			$CATEGORIES .= $db->result('cat_name') . "<BR>";
		}
	}
}
$query = "SELECT * FROM " . $DBPrefix . "bannerskeywords WHERE banner = :b";
$params = array();
$params[] = array(':b', $banner, 'int');
$db->query($query, $params);

if ($db->numrows() > 0)
{
	$i = 0;
	while ($i < $db->numrows())
	{
		$KEYWORDS .= $db->result('keyword') . "<BR>";
		$i++;
	}
}
?>

<html><head>

<title>Untitled Document</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#ffffff">
<center>
  <p><b> 
	Banner filter</b> </p>
   <p align="center"><a href="javascript:window.close()" class="bluelink">Close</a></p>

  <table width="352" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td bgcolor="#eeeeee">
	  
	  <?php echo $MSG['_0053']; ?>
	  
	  </td>
	</tr>
	<tbody>
	<tr>
	  <td> 
	  <?php echo $CATEGORIES; ?></td>
	</tr>
	<tr>
	  <td bgcolor="#ffffff">&nbsp;
	  
	  </td>
	</tr>
	<tr>
	  <td bgcolor="#eeeeee">
	  
	  <?php echo $MSG['_0054']; ?>
	  
	  </td>
	</tr>
	<tr>
	  <td>
	  	
		<?php echo $KEYWORDS; ?>
		
	  </td>
	</tr>
	</tbody>
  </table>
  </center>
 <p align="center"><a href="javascript:window.close()" class="bluelink">Close</a></p>

</body></html>
