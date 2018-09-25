<?php
 /*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
unset($ERROR);
if (isset($_POST['action']))
{
	if ($_POST['action'] == $MSG['089'])
	{
		$checkingemails = isset($_POST['checkemails']) ? $_POST['checkemails'] : '';
		$checkingemailid = isset($_POST['emailid']) ? $_POST['emailid'] : '';
		$checkingdelete = isset($_POST['delete']) ? $_POST['delete'] : '';
		$checkingnew_check = isset($_POST['new_check']) ? $_POST['new_check'] : '';
		
		if (isset($checkingdelete) && is_array($checkingdelete))
		{
			foreach ($checkingdelete as $k => $v)
			{
				$api_key = 'pS1Zqa3aaElNgMUHiyilWEdH8lv6w81U';
				$content = file_get_contents("https://Pro-Auction-Script.com/api/check.php?action=api-delete&delete_domain=" . $v . "&api=" . $api_key);
				$geterr = json_decode($content, true);
				$ERROR = $geterr['ERR'];
			}
		}
				
		elseif (isset($checkingemails) && is_array($checkingemails) && isset($checkingemailid) && empty($checkingdelete) && empty($checkingnew_check))
		{
			foreach ($checkingemails as $k => $v)
			{
				if (!isset($checkingdelete[$k]))
				{
					$id = intval($checkingemailid[$k]);
					$api_key = 'om4DyibVmnSYPjPRO8JUVd7ZQerSKhIn';
					$content = file_get_contents("https://Pro-Auction-Script.com/api/check.php?action=api-update&updatind_list=" . $system->cleanvars($checkingemails[$k]) . "&check_id=" . $id . "&api=" . $api_key);
					$geterr = json_decode($content, true);
					$ERROR = $geterr['ERR'];
					
				}
				else
				{
					$ERROR = 'The delete data is not empty and matching the input';
				}
			}
		}
		
		elseif (isset($checkingnew_check))
		{
			if (empty($checkingdelete))
			{
				$api_key = 'uQwRzAdWj6GoLnPCylLodddrPnqLBiau';
				$new_line = $system->cleanvars($checkingnew_check);
				$content = file_get_contents("https://Pro-Auction-Script.com/api/check.php?action=api-new&add_new=" . $new_line . "&api=" . $api_key);
				$geterr = json_decode($content, true);
				$ERROR = $geterr['ERR'];
			}
			else
			{
				$ERROR = 'The delete input was not empty when trying to add a new domain';
			}
		}
	}
}

// sort the results
$sort = isset($_GET['SORT']) ? $_GET['SORT'] : '';
$checksort = isset($_SESSION['CHECKSORT']) ? $_SESSION['CHECKSORT'] : '';
$sortpage = isset($_GET['PAGE']) ? $_GET['PAGE'] : '';

if ($sort == 'DESC')
{
	$sortingemail = 'DESC';
	$_SESSION['CHECKSORT'] = 'DESC';
}
elseif ($sort == 'ASC')
{
	$sortingemail = 'ASC';
	$_SESSION['CHECKSORT'] = 'ASC';
}
else
{
	if (isset($checksort))
	{
		$sortingemail = $checksort;
	}
	else
	{
		$sortingemail = 'ASC';
	}
}

if (!isset($sortpage) || $sortpage <= 1 || $sortpage == '')
{
	$OFFSET = 0;
	$PAGE = 1;
}
else
{
	$PAGE = intval($sortpage);
	$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
}

$api_key = 'JBkqwdWJ3QrDlmoQk6JqdoM7cl396BUk9';
$content = file_get_contents("https://Pro-Auction-Script.com/api/check.php?action=api-list&sorting=" . $sortingemail . "&perpage=" . $system->SETTINGS['perpage'] . "&offset=" . $OFFSET . "&api=" . $api_key);
$getlist = json_decode($content, true);
	
foreach ($getlist as $k => $val)
{
	if(isset($val['ERR']))
	{
		$ERROR = $val['ERR'];
	}
	if(isset($val['COUNT']))
	{
		$_SESSION['countdomains'] = isset($val['COUNT']) ? $val['COUNT'] : $_SESSION['countdomains'];
	}
	else
	{
		$domain_id = isset($val['id']) ? $val['id'] : '';
		$domain_name = isset($val['email_check']) ? $val['email_check'] : '';
		$template->assign_block_vars('check', array(
				'ID' => $domain_id,
				'EMAIL_CHECKS' => $domain_name
				));
	}
}

// count how many emails are stored
$TOTALAUCTIONS = $_SESSION['countdomains'];
$PAGES = ($TOTALAUCTIONS == 0) ? 1 : ceil($TOTALAUCTIONS / $system->SETTINGS['perpage']);


// get pagenation
$PREV = intval($PAGE - 1);
$NEXT = intval($PAGE + 1);
if ($PAGES > 1)
{
	$LOW = $PAGE - 16;
	if ($LOW <= 0) $LOW = 1;
	$COUNTER = $LOW;
	while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 16))
	{
		$template->assign_block_vars('pages', array(
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/' . 'email_block.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

// checking the page and sorting the results
if (isset($sortpage))
{
	$setpage = $sortpage;
	$sort_a = '&SORT=ASC';
	$sort_z = '&SORT=DESC';
}
elseif (!isset($sortpage))
{
	$sort_a = '?SORT=ASC';
	$sort_z = '?SORT=DESC';

}
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/' . 'email_block.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
	'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] .  $system->SETTINGS['admin_folder'] . '/' . 'email_block.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
	'PAGES' => $PAGES,
	'ISPAGES' => (isset($setpage)),
	'SETPAGE' => $setpage,
	'SETSORTA' => $sort_a,
	'PAGENAME' => $MSG['3500_1015416'],
	'SETSORTZ' => $sort_z,
	'PAGETITLE' => $MSG['3500_1015416']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'check_blocks.tpl'
		));
$template->display('body');
include 'adminFooter.php';