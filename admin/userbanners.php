<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

unset($ERROR);
$id = intval($_REQUEST['id']);

// Activate Account
function activate_account($get_id, $paid)
{
	global $DBPrefix, $db;
	
	$query = "UPDATE " . $DBPrefix . "bannersusers SET paid = :activate WHERE id = :wid"; 
    $Aparams = array();
	$Aparams[] = array(':activate', $paid, 'int');
	$Aparams[] = array(':wid', $get_id, 'int');
	$db->query($query, $Aparams);
	
	$query = "UPDATE " . $DBPrefix . "bannersusers SET newuser = :notnew WHERE id = :wid"; 
    $Aparams = array();
	$Aparams[] = array(':notnew', $paid, 'int');
	$Aparams[] = array(':wid', $get_id, 'int');
	$db->query($query, $Aparams);

	header('location: userbanners.php?id=' . $get_id);
}

// Activate extra banner
function activate_extra_banner($get_id)
{
	global $DBPrefix, $db;
	
	$query = "UPDATE " . $DBPrefix . "bannersusers SET ex_banner_paid = :ebp WHERE id = :i"; 
    $Eparams = array();
	$Eparams[] = array(':ebp', 'y', 'str');
	$Eparams[] = array(':i', $get_id, 'int');
	$db->query($query, $Eparams);
	header('location: userbanners.php?id=' . $get_id);
}

// insert a new banner
function insert_banner($id)
{
	global $DBPrefix, $db, $_FILES, $_POST;
	
	// Data integrity
	if (empty($_FILES['bannerfile']) || empty($_POST['url']))
	{
		$ERROROR = $ERROR['047'];
	}
	else
	{
		// Handle upload
		if (!file_exists(UPLOAD_PATH . 'banners'))
		{
			umask();
			mkdir(UPLOAD_PATH . 'banners', 0777);
		}
		if (!file_exists(UPLOAD_PATH . 'banners/' . $id))
		{
			umask();
			mkdir(UPLOAD_PATH . 'banners/' . $id, 0777);
		}

		$TARGET = UPLOAD_PATH . 'banners/' . $id . '/' . $_FILES['bannerfile']['name'];
		if (file_exists($TARGET))
		{
			$ERROR = sprintf($MSG['_0047'], $TARGET);
		}
		else
		{
			list($imagewidth, $imageheight, $imageType) = getimagesize($_FILES['bannerfile']['tmp_name']);
			$filename = basename($_FILES['bannerfile']['name']);
			$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
			$file_types = array('gif', 'jpg', 'jpeg', 'png', 'swf');
			if (!in_array(strtolower($file_ext), $file_types))
			{
				$ERROR = $MSG['_0048'];
			}
			else
			{
				$imageType = image_type_to_mime_type($imageType);
				switch ($imageType)
				{
					case 'image/gif':
						$FILETYPE = 'gif';
						break;
					case 'image/pjpeg':
					case 'image/jpeg':
					case 'image/jpg':
						$FILETYPE = 'jpg';
						break;
					case 'image/png':
					case 'image/x-png':
						$FILETYPE = 'png';
						break;
					case 'application/x-shockwave-flash':
						$FILETYPE = 'swf';
						break;
				}
				if (!empty($_FILES['bannerfile']['tmp_name']) && $_FILES['bannerfile']['tmp_name'] != 'none')
				{
					move_uploaded_file($_FILES['bannerfile']['tmp_name'], $TARGET);
					chmod($TARGET, 0666);
				}

				// Update database
				$query = "INSERT INTO " . $DBPrefix . "banners VALUES
						(NULL, '" . $_FILES['bannerfile']['name'] . "',
						'" . $FILETYPE . "', 0, 0, '" . $_POST['url'] . "',
						'" . $_POST['sponsortext'] . "', '" . $_POST['alt'] . "',
						" . intval($_POST['purchased']) . ", " . $imagewidth . ", " . $imageheight . ", " . $id . ", " . $id . ")";
				$db->direct_query($query);
				$ID = $db->lastInsertId();

				// Handle filters
				if (!empty($_POST['category']))
				{
					foreach ($_POST['category'] as $k => $v)
					{
						$query = "INSERT INTO " . $DBPrefix . "bannerscategories VALUES (:b, :c)";
						$params = array();
						$params[] = array(':b', $ID, 'int');
						$params[] = array(':c', $v, 'int');
						$db->query($query, $params);
					}
				}
				if (!empty($_POST['keywords']))
				{
					$KEYWORDS = explode("\n", $_POST['keywords']);
					
					foreach ($KEYWORDS as $k => $v)
					{
						if (!empty($v))
						{
							$query = "INSERT INTO " . $DBPrefix . "bannerskeywords VALUES (:b, :k)";
							$params = array();
							$params[] = array(':b', $ID, 'int');
							$params[] = array(':k', $system->cleanvars(trim($v)), 'str');
							$db->query($query, $params);
						}
					}
				}
				header('location: userbanners.php?id=' . $id);
				exit;
			}
		}
	}
}

$activate = isset($_GET['activate']) ? $_GET['activate'] : '';
$banner_paid = isset($_POST['paid']) ? $_POST['paid'] : '';
$extra_banner_paid = isset($_POST['extra_banner_paid']) ? $_POST['extra_banner_paid'] : '';
$posted_id = isset($_POST['id']) ? $_POST['id'] : '';

if (isset($activate))
{
	switch($activate) 
	{
		case "activate_acc":
			if (isset($banner_paid) && $banner_paid == 1)
			{
				activate_account($id, 1);
			}
		break;
		case "add_extra":
			if (isset($extra_banner_paid) && $extra_banner_paid == 2)
			{
				activate_extra_banner($id);
			}
		break;
		case "insert":
			if (isset($posted_id))
			{	
				insert_banner($id);
			}
		break;

	}
}

$BANNERS = array();
// Retrieve if user's paid
$query = "SELECT paid, ex_banner_paid  FROM " . $DBPrefix . "bannersusers WHERE id = :i";
$params = array();
$params[] = array(':i', $id, 'int');
$db->query($query, $params);
while ($paid = $db->result())
{
	$template->assign_block_vars('paidbanners', array(
		'B_PAID' => $paid['paid'] == '0',
		'B_EX_PAID' => $paid['ex_banner_paid'] == 'n',
		));
}

// Retrieve user's information
$query = "SELECT id, name, company, email FROM " . $DBPrefix . "bannersusers WHERE id = :i";
$params = array();
$params[] = array(':i', $id, 'int');
$db->query($query, $params);
$USER = $db->result();
	
// REtrieve user's banners
$query = "SELECT * FROM " . $DBPrefix . "banners WHERE user = :u";
$params = array();
$params[] = array(':u', $USER['id'], 'int');
$db->query($query, $params);
$bg = '';
while ($row = $db->result())
{
	$template->assign_block_vars('banners', array(
			'ID' => $row['id'],
			'TYPE' => $row['type'],
			'NAME' => $row['name'],
			'BANNER' => UPLOAD_FOLDER . 'banners/' . $id . '/' . $row['name'],
			'WIDTH' => $row['width'],
			'HEIGHT' => $row['height'],
			'URL' => $row['url'],
			'ALT' => $row['alt'],
			'SPONSERTEXT' => $row['sponsortext'],
			'VIEWS' => $row['views'],
			'CLICKS' => $row['clicks'],
			'PURCHASED' => $row['purchased'],
			'BG' => $bg,
			
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

// category
$TPL_categories_list = '<select name="category[]" rows="12" multiple>' . "\n";
if (isset($category_plain) && count($category_plain) > 0)
{
	foreach ($category_plain as $k => $v)
	{
		if (isset($_POST['categories']) && is_array($_POST['categories']))
			$select = (in_array($k, $_POST['categories'])) ? ' selected="true"' : '';
		else
			$select = '';
		$TPL_categories_list .= "\t" . '<option value="' . $k . '" ' . $select . '>' . $v . '</option>' . "\n";
	}
}
$TPL_categories_list .= '</select>' . "\n";

$template->assign_vars(array(
	'ID' => $id,
	'NAME' => $USER['name'],
	'COMPANY' => $USER['company'],
	'EMAIL' => $USER['email'],
	// form values
	'BANNERID' => '',
	'URL' => (isset($_POST['url'])) ? $_POST['url'] : '',
	'SPONSORTEXT' => (isset($_POST['sponsortext'])) ? $_POST['sponsortext'] : '',
	'ALT' => (isset($_POST['alt'])) ? $_POST['alt'] : '',
	'PURCHASED' => (isset($_POST['purchased'])) ? $_POST['purchased'] : '',
	'KEYWORDS' => (isset($_POST['keywords'])) ? $_POST['keywords'] : '',
	'CATEGORIES' => $TPL_categories_list,
	'NOTEDIT' => true,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['_0024'],
	'PAGETITLE' => $MSG['_0024']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'userbanners.tpl'
		));
$template->display('body');
include 'adminFooter.php';