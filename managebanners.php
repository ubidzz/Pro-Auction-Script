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
//Add new user account to database
if (isset($_POST['action']) && $_POST['action'] == 'insert')
{
	if (empty($_POST['name']) || empty($_POST['company']) || empty($_POST['email']))
	{
		$ERROR = $ERR['047'];
	}
	elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['email']))
	{
		$ERROR = $ERR['008'];
	}
	else
	{		
		$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = :fee";
		$params = array();
		$params[] = array(':fee', 'banner_fee', 'str');
		$db->query($query, $params);
		if($db->result('value') > 0)
		{
			$paid = 0;
		}
		else
		{
			$paid = 1;
		}
		
		// Update database
		$query = "INSERT INTO " . $DBPrefix . "bannersusers (id, name, company, email, seller, newuser, paid, ex_banner_paid, time_stamp) VALUES (NULL, :user_name, :company, :email, :user_id, :newuser, :paid, :extra_banner, :time_stamp)";
		$params = array(
			array(':user_name', $_POST['name'], 'str'),
			array(':company', $_POST['company'], 'str'),
			array(':email', $_POST['email'], 'str'),
			array(':user_id', $user->user_data['id'], 'int'),
			array(':newuser', 'y', 'bool'),
			array(':paid', $paid, 'int'),
			array(':extra_banner', 'n', 'bool'),
			array(':time_stamp', $system->CTIME, 'int')
		);
		$db->query($query, $params);
		$ID = $db->lastInsertId();
		
		if($paid == 1)
		{
			header('location: newuserbanner.php?id=' . $ID);
		}
		elseif($paid == 0)
		{
			header('location: pay.php?a=8');
		}
		exit;
	}
}

// Delete users and banners if the user click on the delete button
if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	foreach ($_POST['delete'] as $k => $v)
	{	
		$query = "DELETE FROM " . $DBPrefix . "banners WHERE user = :user";
		$params = array(
			array(':user', $v, 'int')
		);
		$db->query($query, $params);

		$query = "DELETE FROM " . $DBPrefix . "bannersusers WHERE id = :user";
		$params = array(
			array(':user', $v, 'int')
		);
		$db->query($query, $params);
	}
}

// check user ids
$query = "SELECT id FROM " . $DBPrefix . "users WHERE id = :user_id";
$params = array(
	array(':user_id', $user->user_data['id'], 'int')
);
$db->query($query, $params);
$user_id = $db->result('id');

// Retrieve users from the database
$query = "SELECT u.*, COUNT(b.user) as count FROM " . $DBPrefix . "bannersusers u
		LEFT JOIN " . $DBPrefix . "banners b ON (b.user = u.id)
		GROUP BY u.id ORDER BY u.name";
$db->direct_query($query);

$bg = '';

while ($row = $db->result())
{	
	//Checking user id and see if the user paid the fees
	if ($user->user_data['id'] == $row['seller'] && ($row['paid'] == '1') && ($row['seller'] == $user->user_data['id']))
	{		
			//Checking to see if the user has any banners uploaded
			if($row['count'] == 0)
			{
				//If the user has no banners uploaded the new user column will update so the
				//user can upload a banner for free as long as the user has an active account
				$query = "UPDATE " . $DBPrefix . "bannersusers SET newuser = :yes WHERE id = :id";
    			$params = array(
    				array(':yes', 'y', 'str'),
					array(':id', $row['id'], 'int')
				);
				$db->query($query, $params);
			}
			
				$template->assign_block_vars('busers', array(
					'ID' => $row['id'],
					'NAME' => $row['name'],
					'COMPANY' => $row['company'],
					'EMAIL' => $row['email'],
					'NUM_BANNERS' => $row['count'],
					'BG' => $bg,
					));
				$bg = ($bg == '') ? 'class="bg"' : '';
	}
}

// get fees
$query = "SELECT * FROM " . $DBPrefix . "fees";
$db->direct_query($query);
$i = 0;
while ($row = $db->result())
{
	if ($row['type'] == 'banner_fee')
	{
			$template->assign_vars(array(
				'B_SIGNUP_FEE' => ($row['value'] > 0) ? true : false,
				'SIGNUP_FEE' => $system->print_money($row['value'])
				));
	}
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'NAME' => (isset($_POST['name'])) ? $_POST['name'] : '',
	'COMPANY' => (isset($_POST['company'])) ? $_POST['company'] : '',
	'EMAIL' => (isset($_POST['email'])) ? $_POST['email'] : '',
	'ACTIVEACCOUNTTAB' => 'class="active"',
	'ACTIVEMYADVERTISMENT' => 'class="active"',
	'ACTIVEACCOUNTPANEL' => 'active'
));

include 'header.php';
$template->set_filenames(array(
		'body' => 'managebanners.tpl'
		));
$template->display('body');
include 'footer.php';