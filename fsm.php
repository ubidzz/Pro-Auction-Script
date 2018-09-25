<?php
include 'common.php';

// If user is not logged in redirect to login page
if (!$user->checkAuth())
{
	header('location: user_login.php');
	exit;
}

// Delete favourite seller 
if (isset($_POST['action']) && $_POST['action'] == 'delfaveseller') 
{ 
    if (is_array($_POST['O_delete'])) 
    { 
        foreach ($_POST['O_delete'] as $k => $v) 
        { 
            // Update end time to the current time 
            $query = "DELETE FROM " . $DBPrefix . "favesellers WHERE user_id = :user_id AND seller_id = :seller_id"; 
            $params = array(
				array(':user_id', $user->user_data['id'], 'int'),
				array(':seller_id', intval($v), 'int')
			);
			$db->query($query, $params); 
        } 
         
    } 
}  

$query = "SELECT seller_id FROM " . $DBPrefix . "favesellers WHERE user_id = :users_id";
$params = array(
	array(':users_id', $user->user_data['id'], 'int')
);
$db->query($query, $params);
while ($id = $db->result())
{
		$query = "SELECT rate FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = :seller_id";
		$params = array(
			array(':seller_id', $id['seller_id'], 'int')
		);
		$db->query($query, $params);
		// count numbers
		$fb_pos = $fb_neg = 0;
		while ($fb_arr = $db->result('rate'))
		{
			if ($fb_arr == 1)
			{
				$fb_pos++;
			}
			elseif ($fb_arr == - 1)
			{
				$fb_neg++;
			}
		}
		$query = "SELECT nick FROM " . $DBPrefix . "users WHERE id = :seller_id";
		$params = array(
			array(':seller_id', $id['seller_id'], 'int')
		);
		$db->query($query, $params);

		$nick = $db->result('nick');  
		$total_rate = $fb_pos - $fb_neg;
		$template->assign_block_vars('sellers', array(
			'ID' => $id['seller_id'],
			'NICK' => $nick,
			'FB' => $total_rate
			));
}
$template->assign_vars(array(
	'ACTIVEBUYINGTAB' => 'class="active"',
	'ACTIVEFSM' => 'class="active"',
	'ACTIVEBUYINGPANEL' => 'active'
));

include 'header.php';
$TMP_usmenutitle = $MSG['FSM7'];
include 'includes/user_cp.php';
$template->set_filenames(array(
		'body' => 'fsm.tpl'
		));
$template->display('body');
include 'footer.php';