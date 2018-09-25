<?php

/*******************************************************************************

 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script

 *   site					: https://www.pro-auction-script.com

 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license

 *******************************************************************************/



include 'common.php';



// If user is not logged in redirect to login page

if (!$user->checkAuth())

{

	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'mail.php';

	header('location: user_login.php');

	exit;

}



$x = (isset($_GET['x']))? $_GET['x'] : '';

$u = (isset($_GET['u']))? (int)$_GET['u'] : 0;

$replymessage = (isset($_GET['message']))? $_GET['message'] : '';

$order = (isset($_GET['order']))? $_GET['order'] : '';

$action = (isset($_GET['action']))? $_GET['action'] : '';

$messageid = (isset($_GET['id']))? $_GET['id'] : '';

$delete = (isset($_POST['delete']))? $_POST['delete'] : NULL;

$email = false;



include PLUGIN_PATH . 'htmLawed/htmLawed.php';

$conf = array();

$conf = $system->SETTINGS['htmLawed_safe'];

$conf = $system->SETTINGS['htmLawed_deny_attribute'];



include PLUGIN_PATH . 'ckeditor/ckeditor.php';

$CKEditor = new CKEditor();

$CKEditor->basePath = $system->SETTINGS['siteurl'] . 'includes/plugins/ckeditor/';

$CKEditor->returnOutput = true;

$CKEditor->config['width'] = '100%';

$CKEditor->config['height'] = 200;



if (isset($_POST['sendto']) && isset($_POST['subject']) && isset($_POST['message']))

{

	// get message info + set cookies for if an error occours

	$sendto = $system->cleanvars($_POST['sendto']);

	$_SESSION['sendto'] = $sendto;

	$subject = $system->cleanvars($_POST['subject']);

	$_SESSION['subject'] = $subject;

	$message = $system->cleanvars($_POST['message']);

	$_SESSION['messagecont'] = $message;

	// check user exists

	$query = "SELECT * FROM " . $DBPrefix . "users WHERE nick = :sendtouser";

	$params = array(

		array(':sendtouser', $sendto, 'str')

	);

	$db->query($query, $params);

	$usercheck = $db->numrows();

	if ($usercheck == 0) // no such user

	{

		if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $sendto))

		{

			$_SESSION['message'] = $ERR['609'];

			header('location: mail.php?x=1');

			exit;

		}

		else

		{

			$email = true;

		}

	}



	$nowmessage = nl2br(stripslashes($message));

	if (!$email)

	{

		$userarray = $db->result();



		// check use mailbox insnt full

		$query = "SELECT * FROM " . $DBPrefix . "messages WHERE sentto = :user_id";

		$params = array(

			array(':user_id', $userarray['id'], 'int')

		);

		$db->query($query, $params);



		$mailboxsize = $db->numrows();

		if ($mailboxsize >= 30)

		{

			$_SESSION['message'] = sprintf($MSG['443'], $sendto);

			header('location: mail.php');

			exit;

		}

	}

	else

	{

		// send the email

		$from_email = ($system->SETTINGS['users_email'] == 'n') ? $user->user_data['email'] : $system->SETTINGS['adminmail'];

		$send_email->messages($subject, $sendto, $nowmessage, $from_email);

	}



	// send message

	$id_type = ($email) ? 'fromemail' : 'sentto';

	$mail_id = ($email) ? $sendto : $userarray['id'];

	$query = "INSERT INTO " . $DBPrefix . "messages (" . $id_type . ", sentfrom, sentat, message, subject, reply_of, question) 

	VALUES (:to_ids, :sender_id, :times, :nowmessages, :subjects, :reply_of_hash, :question_hash)";

	$params = array(

		array(':to_ids', $mail_id, 'int'),

		array(':sender_id', $user->user_data['id'], 'int'),

		array(':times', $system->CTIME, 'int'),

		array(':nowmessages', $nowmessage, 'str'),

		array(':subjects', $subject, 'str'),

		array(':reply_of_hash', $_SESSION['reply_of' . $_POST['hash']], 'str'),

		array(':question_hash', $_SESSION['question' . $_POST['hash']], 'str')

	);

	$db->query($query, $params);



	// Track IP

	if (defined('TrackUserIPs'))

	{

		$system->log('user', 'Post Private Message', $user->user_data['id'], $db->lastInsertId());

	}



	if (isset($_POST['is_question']) && isset($_SESSION['reply_of' . $_POST['hash']]) && $_SESSION['reply_of' . $_POST['hash']] > 0)

	{

		$public = (isset($_POST['public'])) ? 1 : 0;

		$query = "UPDATE " . $DBPrefix . "messages SET public = :public_mes WHERE id = :mes_id";

		$params = array(

			array(':public_mes', $public, 'int'),

			array(':mes_id', $_SESSION['reply_of' . $_POST['hash']], 'str')

		);		

		$db->query($query, $params);

	}



	if (isset($_SESSION['reply' . $_POST['hash']]))

	{

		$reply = $_SESSION['reply' . $_POST['hash']];

		$query = "UPDATE " . $DBPrefix . "messages SET replied = :one WHERE id = :id";

		$params = array(

			array(':one', 1, 'int'),

			array(':id', $reply, 'int')

		);

		$db->query($query, $params);

		unset($_SESSION['reply' . $_POST['hash']]);

	}

	// delete session of sent message

	unset($_SESSION['messagecont' . $_POST['hash']]);

	unset($_SESSION['subject' . $_POST['hash']]);

	unset($_SESSION['sendto' . $_POST['hash']]);

	unset($_SESSION['reply_of' . $_POST['hash']]);

}



if (isset($_REQUEST['deleteid']) && is_array($_REQUEST['deleteid']))

{

	$temparr = $_REQUEST['deleteid'];

	$message_id = 0;

	for ($i = 0; $i < count($temparr); $i++)

	{

		$message_id .= ',' . intval($temparr[$i]);

	}

	$query = "DELETE FROM " . $DBPrefix . "messages WHERE id IN (" . $message_id . ")";

	$db->direct_query($query);

	$ERROR = $MSG['444'];

}



// if sending a message

if ($x == 1)

{

	$subject = $_SESSION['subject' . $replymessage];

	$sendto = $_SESSION['sendto' . $replymessage];

	$question = false;

	// if sent from userpage

	if ($u > 0)

	{

		$query = "SELECT nick FROM " . $DBPrefix . "users WHERE id = :id";

		$params = array(

			array(':id', $u, 'int')

		);

		$db->query($query, $params);

		$sendto = $db->result('nick');

	}



	// get convo

	if (isset($_SESSION['reply_of' . $_GET['message']]) && $_SESSION['reply_of' . $_GET['message']] != 0)

	{

		$tid = $_SESSION['reply_of' . $_GET['message']];

		$query = "SELECT sentfrom, question, public FROM " . $DBPrefix . "messages WHERE id = :id";

		$params = array(

			array(':id', $tid, 'int')

		);

		$db->query($query, $params);

		$array = $db->result();

		$reply_public = $array['public'];

		if ($array['question'] > 0 && $user->user_data['id'] != $array['sentfrom'])

		{

			$question = true;

		}



		$query = "SELECT sentfrom, message, question FROM " . $DBPrefix . "messages WHERE reply_of = :tid OR id = :tid ORDER BY id DESC";

		$params = array(

			array(':tid', $tid, 'int')

		);

		$db->query($query, $params);

		$oid = 0;

		while ($row = $db->result())

		{

			$oid = ($oid == 0) ? $row['sentfrom'] : $oid;

			$template->assign_block_vars('convo', array(

					'BGCOLOR' => ($oid == $row['sentfrom']) ? ' background-color: #EEEEEE' : '',

					'MSG' => $row['message']

					));

		}

	}

}



// table headers

$sentfrom = '<a href="mail.php?order=3">' . $MSG['240'] . '</a>';

$whensent = '<a href="mail.php?order=1">' . $MSG['242'] . '</a>';

$title = '<a href="mail.php?order=5">' . $MSG['519'] . '</a>';



// order messages

switch ($order)

{

	case 1:

		$orderby = "ORDER BY id DESC";

		$whensent = '<a href="mail.php?order=2">' . $MSG['242'] . ' <img src="images/arrow_down.gif"></a>';

	break;

	case 2:

		$orderby = "ORDER BY id ASC";

		$whensent = '<a href="mail.php?order=1">' . $MSG['242'] . ' <img src="images/arrow_up.gif"></a>';

	break;

	case 3:

		$orderby = "ORDER BY sentfrom DESC";

		$sentfrom = '<a href="mail.php?order=4">' . $MSG['240'] . ' <img src="images/arrow_down.gif"></a>';

	break;

	case 4:

		$orderby = "ORDER BY sentfrom ASC";

		$sentfrom = '<a href="mail.php?order=3">' . $MSG['240'] . ' <img src="images/arrow_up.gif"></a>';

	break;

	case 5:

		$orderby = "ORDER BY subject DESC";

		$title = '<a href="mail.php?order=6">' . $MSG['519'] . ' <img src="images/arrow_down.gif"></a>';

	break;

	case 6:

		$orderby = "ORDER BY subject ASC";

		$title = '<a href="mail.php?order=5">' . $MSG['519'] . ' <img src="images/arrow_up.gif"></a>';

	break;

	default:

		$orderby = "ORDER BY id DESC";

	break;

}



$query = "SELECT m.*, u.nick FROM " . $DBPrefix . "messages m

		LEFT JOIN " . $DBPrefix . "users u ON (u.id = m.sentfrom)

		WHERE sentto = :user_ids " . $orderby;

// get users messages

$params = array(

	array(':user_ids', $user->user_data['id'], 'int')

);

$db->query($query, $params);

$messages = $db->numrows();

// display number of messages

$messagespaceused = ($messages * 4) + 1;

$messagespaceleft = (30 - $messages) * 4;

$messagesleft = 30 - $messages;



while ($array = $db->result())

{

	$sender = ($array['sentfrom'] == 0) ? 'Admin' : '<a href="profile.php?user_id=' . $array['sentfrom'] . '">' . $array['nick'] . '</a>';

	$sender = (!empty($array['fromemail'])) ? $array['fromemail'] : $sender;

	$template->assign_block_vars('msgs', array(

		'SENT' => $system->ArrangeDateAndTime($array['sentat']),

		'ID' => $array['id'],

		'SENDER' => $sender,

		'SUBJECT' => ($array['isread'] == 0) ? '<b>' . $array['subject'] . '</b>' : $array['subject']

	));

}



$ERROR = (isset($_SESSION['message'])) ? $_SESSION['message'] : (isset($ERROR)) ? $ERROR : '';

unset($_SESSION['message']);



$template->assign_vars(array(

	'WHENSENT' => $whensent,

	'TITLE' => $title,

	'SENTFROM' => $sentfrom,

	'REPLYBX' => $CKEditor->editor('message', ''),

	'MSGCOUNT' => $messages,

	'HASH' => $replymessage,

	'REPLY_X' => $x,

	'REPLY_TO' => (isset($sendto)) ? $sendto : '',

	'REPLY_SUBJECT' => (isset($subject)) ? $subject : '',

	'REPLY_PUBLIC' => (isset($reply_public) && $reply_public == 1) ? ' checked="checked"' : '',



	'B_QMKPUBLIC' => (isset($question)) ? $question : false,

	'B_CONVO' => (isset($_GET['message'])) ? (isset($_SESSION['reply_of' . $_GET['message']])) : '',

	'ACTIVEACCOUNTTAB' => 'class="active"',

	'ACTIVEVIEWMESSAGES' => 'class="active"',

	'ACTIVEACCOUNTPANEL' => 'active'

));



include 'header.php';

$template->set_filenames(array(

		'body' => 'mail.tpl'

		));

$template->display('body');

include 'footer.php';

