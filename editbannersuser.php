<?php
$current_page = 'banners';
include 'common.php';

// If user is not logged in redirect to login page
if (!$user->checkAuth())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'editbanneruser.php';
	header('location: user_login.php');
	exit;
}

unset($ERROR);
$id = $_REQUEST['id'];

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if (empty($_POST['name']) || empty($_POST['company']) || empty($_POST['email']))
	{
		$ERROR = $ERR['047'];
		$USER = $_POST;
	}
	elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['email']))
	{
		$ERROR = $ERR['008'];
		$USER = $_POST;
	}
	else
	{
		// Update database
		$query = "UPDATE " . $DBPrefix . "bannersusers SET
				  name = :user_id,
				  company = :user_company,
				  email = :user_email
				  WHERE id = :id";
		$params = array(
			array(':user_name', $_POST['name'], 'str'),
			array(':user_company', $_POST['company'], 'str'),
			array(':user_email', $_POST['email'], 'str'),
			array(':id', $_POST['email'], 'str')
		);
		$db->query($query, $params);

		header('location: managebanners.php');
		exit;
	}
}
else
{
	$query = "SELECT * FROM " . $DBPrefix . "bannersusers WHERE id = :id";
	$params = array(
		array(':id', $id, 'int')
	);
	$db->query($query, $params);
	if ($db->numrows() > 0)
	{
		$USER = $db->result();
	}
}

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'ID' => $id,
	'NAME' => (isset($USER['name'])) ? $USER['name'] : '',
	'COMPANY' => (isset($USER['company'])) ? $USER['company'] : '',
	'EMAIL' => (isset($USER['email'])) ? $USER['email'] : '',
	'ACTIVEACCOUNTTAB' => 'class="active"',
	'ACTIVEMYADVERTISMENT' => 'class="active"',
	'ACTIVEACCOUNTPANEL' => 'active'
));

include 'header.php';
$template->set_filenames(array(
		'body' => 'editbanneruser.tpl'
		));
$template->display('body');
include 'footer.php';