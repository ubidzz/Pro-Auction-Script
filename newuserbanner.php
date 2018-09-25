<?php
$current_page = 'banners';
include 'common.php';


// If user is not logged in redirect to login page
if (!$user->checkAuth())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'managebanners.php';
	header('location: user_login.php');
	exit;
}
  
unset($ERROR);
$id = intval($_REQUEST['id']);
$banner_user = $user->user_data['id'];

$query = "SELECT * FROM " . $DBPrefix . "bannersusers WHERE id = :id AND seller = :user";
$params = array(
	array(':id', $id, 'int'),
	array(':user', $banner_user, 'int')
);
$db->query($query, $params);
$paid_status = $db->result();

//Checking to see if the user has an banner's account
if($paid_status['newuser'] == 'n' && $paid_status['ex_banner_paid'] == 'n' && $paid_status['paid'] == 1)
{
	header('location: userbanners.php?id=' . $id);
	exit;
}
elseif($paid_status['newuser'] == 'n' && $paid_status['ex_banner_paid'] == 'n' && $paid_status['paid'] == 0)
{
	header('location: managebanners.php');
	exit;
}
else
{
	// insert a new banner
	if (isset($_POST['action']) && $_POST['action'] == 'insert')
	{
		// Data integrity
		if (empty($_FILES['bannerfile']) || empty($_POST['url']))
		{
			$ERROR = $ERR['047'];
		}
		else
		{
			// Handle upload
			if (!file_exists(UPLOAD_PATH . 'banners'))
			{
				umask();
				mkdir(UPLOAD_PATH . 'banners', 0755);
			}
			if (!file_exists(UPLOAD_PATH . 'banners/' . $id))
			{
				umask();
				mkdir(UPLOAD_PATH . 'banners/' . $id, 0755);
			}

			$TARGET = UPLOAD_PATH . 'banners/' . $id . '/' . $_FILES['bannerfile']['name'];
			if (file_exists($TARGET))
			{
				unlink($TARGET);
			}
			list($imagewidth, $imageheight, $imageType) = getimagesize($_FILES['bannerfile']['tmp_name']);
			$filename = basename($_FILES['bannerfile']['name']);
			$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
			$file_types = explode(', ', $system->SETTINGS['banner_types']);
			$split = explode('.', strtolower($_FILES['bannerfile']['name']));
			$type = end($split); 

			if ($imagewidth > $system->SETTINGS['banner_width'] || $imageheight > $system->SETTINGS['banner_height'])
 			{
   				$ERROR = sprintf($MSG['350_1012333'], $system->SETTINGS['banner_width'], $system->SETTINGS['banner_height']);
  			}
  			else
			{
				if (!in_array($type, $file_types))
				{
					$ERROR = $MSG['_0048'];
				}
				else
				{
					$check_type = image_type_to_mime_type($imageType);
					switch ($check_type)
					{
						case 'image/gif':
							$FILETYPE = 'gif';
						break;
						case 'image/pjpeg':
							$FILETYPE = 'jpg';
						break;
						case 'image/jpeg':
							$FILETYPE = 'jpg';
						break;
						case 'image/jpg':
							$FILETYPE = 'jpg';
						break;
						case 'image/png':
							$FILETYPE = 'png';
						break;
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
						chmod($TARGET, 0655);
					}
					// Update database start
					if(isset($FILETYPE))
					{							
						//Add new banner to database
						$query = "INSERT INTO " . $DBPrefix . "banners VALUES (NULL, :banner_name, :file_type, :views, :clicks, :banner_url, :sponsortext, :alt, :purchased, :imagewidth, :imageheight, :banner_id, :seller_id)";
						$params = array(
							array(':banner_name', $_FILES['bannerfile']['name'], 'str'),
							array(':file_type', $FILETYPE, 'str'),
							array(':views', 0, 'int'),
							array(':clicks', 0, 'int'),
							array(':banner_url', $_POST['url'], 'str'),
							array(':sponsortext', $_POST['sponsortext'], 'str'),
							array(':alt', $_POST['alt'], 'str'),
							array(':purchased', intval($_POST['purchased']), 'int'),
							array(':imagewidth', $imagewidth, 'int'),
							array(':imageheight', $imageheight, 'int'),
							array(':banner_id', $id, 'int'),
							array(':seller_id', $banner_user, 'int')
						);
						$db->query($query, $params);
						
						//get the new banner id and put it in to a salt
						$ID = $db->lastInsertId();
						
						if ($paid_status['newuser'] == 'n' && $paid_status['ex_banner_paid'] == 'y' && $paid_status['paid'] == 1)
						{
							//Update's the extra banner column after banner was uploaded
							$query = "UPDATE " . $DBPrefix . "bannersusers SET ex_banner_paid = :no WHERE id = :dbID AND seller = :banner_user_id";
		        			$params = array(
								array(':no', 'n', 'bool'),
								array(':dbID', $id, 'int'),
								array(':banner_user_id', $banner_user, 'int')
							);
							$db->query($query, $params);
	        			}
	        			
	        			if ($paid_status['newuser'] == 'y' && $paid_status['ex_banner_paid'] == 'n' && $paid_status['paid'] == 1)
						{
							//Update's the banner column after banner was uploaded
							$query = "UPDATE " . $DBPrefix . "bannersusers SET newuser = :no WHERE id = :dbID AND seller =:banner_user_id";
		        			$params = array(
								array(':no', 'n', 'bool'),
								array(':dbID', $id, 'int'),
								array(':banner_user_id', $banner_user, 'int')
							);
							$db->query($query, $params);
	        			}
						
						// Handle filters
						if (!empty($_POST['keywords']))
						{
							$KEYWORDS = explode("\n", $_POST['keywords']);
						
							foreach ($KEYWORDS as $k => $v)
							{
								if (!empty($v))
								{
									$query = "INSERT INTO " . $DBPrefix . "bannerskeywords VALUES (:id, :keywords)";
									$params = array(
										array(':id', $ID, 'int'),
										array(':keywords', $system->cleanvars(trim($v)), 'str')
									);
									$db->query($query, $params);
								}
							}
						}
						
						header('location: userbanners.php?id=' . $id);
						exit;
					}
					$ERROR = $MSG['3500_1015533'];
				}
			}
		}
	}
}
$BANNERS = array();

// Retrieve user's information
$query = "SELECT id, name, company, email FROM " . $DBPrefix . "bannersusers WHERE id = :id";
$params = array(
	array(':id', $id, 'int')
);
$db->query($query, $params);
$USER = $db->result();
	
// REtrieve user's banners
$query = "SELECT * FROM " . $DBPrefix . "banners WHERE user = :user_id";
$params = array(
	array(':user_id', $USER['id'], 'int')
);
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
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
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
	'NOTEDIT' => true,
	'B_BANNER_PAID' => $paid_status['newuser'] == 'y' && $paid_status['ex_banner_paid'] == 'n' && $paid_status['paid'] == 1,
	'B_EXBANNER_PAID' => $paid_status['newuser'] == 'n' && $paid_status['ex_banner_paid'] == 'y' && $paid_status['paid'] == 1,
	'ACTIVEACCOUNTTAB' => 'class="active"',
	'ACTIVEMYADVERTISMENT' => 'class="active"',
	'ACTIVEACCOUNTPANEL' => 'active',
	'IMAGESIZE' => sprintf($MSG['350_1012333'], $system->SETTINGS['banner_width'], $system->SETTINGS['banner_height'])
));

include 'header.php';
include 'includes/user_cp.php';
$template->set_filenames(array(
		'body' => 'newuserbanner.tpl'
		));
$template->display('body');
include 'footer.php';