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
	// add category
	if ($_POST['action'] == $MSG['5204'])
	{
		if (empty($_POST['cat_name'][$system->SETTINGS['defaultlanguage']]))
		{
			$ERROR = $ERR['047'];
		}
		else
		{
			$query = "INSERT INTO " . $DBPrefix . "faqscategories values (NULL, :c)";
			$params = array();
			$params[] = array(':c', $_POST['cat_name'][$system->SETTINGS['defaultlanguage']], 'str');
			$db->query($query, $params);
			$id = $db->lastInsertId();
			reset($LANGUAGES);
			foreach ($LANGUAGES as $k => $v)
			{
				$query = "INSERT INTO " . $DBPrefix . "faqscat_translated VALUES (:i, :l, :c)";
				$params = array();
				$params[] = array(':i', $id, 'int');
				$params[] = array(':l', $k, 'str');
				$params[] = array(':c', $_POST['cat_name'][$k], 'str');
				$db->query($query, $params);
			}
			header('location: ' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/faqscategories.php');
			exit;
		}
	}

	// Delete categories
	if ($_POST['action'] == $MSG['030'] && isset($_POST['delete']) && is_array($_POST['delete']))
	{
		foreach ($_POST['delete'] as $k => $v)
		{
			if ($v == 'delete')
			{
				$query = "SELECT id FROM " . $DBPrefix . "faqs WHERE category = :i";
				$params = array();
				$params[] = array(':i', $k, 'int');
				$db->query($query, $params);
				$ids = '0';
				while ($row = $db->result('id'))
				{
					$ids .= ',' . $row;
				}
				
				$query = "DELETE FROM " . $DBPrefix . "faqs WHERE category = :i";
				$params = array();
				$params[] = array(':i', $k, 'int');
				$db->query($query, $params);

				$query = "DELETE FROM " . $DBPrefix . "faqs_translated WHERE faq_id IN (:i)";
				$params = array();
				$params[] = array(':i', $ids, 'int');
				$db->query($query, $params);
			}
			else
			{
				$move = explode(':', $v);
				$query = "UPDATE " . $DBPrefix . "faqs SET category = :c WHERE category = :cg";
				$params = array();
				$params[] = array(':c', $move[1], 'int');
				$params[] = array(':cg', $k, 'int');
				$db->query($query, $params);
			}
			$query = "DELETE FROM " . $DBPrefix . "faqscategories WHERE id = :i";
			$params = array();
			$params[] = array(':i', $k, 'int');
			$db->query($query, $params);

			$query = "DELETE FROM " . $DBPrefix . "faqscat_translated WHERE id = :i";
			$params = array();
			$params[] = array(':i', $k, 'int');
			$db->query($query, $params);
			header('location: ' . $system->SETTINGS['siteurl'] . $system->SETTINGS['admin_folder'] . '/faqscategories.php');
			exit;
		}
	}

	// delete check
	if ($_POST['action'] == $MSG['008'] && isset($_POST['delete']) && is_array($_POST['delete']))
	{
		// get cats FAQs can be moved to
		$delete = implode(',', $_POST['delete']);
		$query = "SELECT category, id FROM " . $DBPrefix . "faqscategories WHERE id NOT IN (:i)";
		$params = array();
		$params[] = array(':i', $delete, 'int');
		$db->query($query, $params);

		$move = '';
		while ($row = $db->result())
		{
			$move .= '<option value="move:' . $row['id'] . '">' . $MSG['840'] . $row['category'] . '</option>';
		}
		// Get data from the database
		$query = "SELECT COUNT(f.id) as COUNT, c.category, c.id FROM " . $DBPrefix . "faqscategories c
					LEFT JOIN " . $DBPrefix . "faqs f ON ( f.category = c.id ) 
					WHERE c.id IN (:i) GROUP BY c.id ORDER BY category";
		$params = array();
		$params[] = array(':i', $delete, 'int');
		$db->query($query, $params);

		$message = $MSG['839'] . '<table cellpadding="0" cellspacing="0">';
		$names = array();
		$counter = 0;
		while ($row = $db->result())
		{
			$names[] = $row['category'] . '<input type="hidden" name="delete[' . $row['id'] . ']" value="delete">';
			if ($row['COUNT'] > 0)
			{
				$message .= '<tr>';
				$message .= '<td>' . $row['category'] . '</td><td>';
				$message .= '<select name="delete[' . $row['id'] . ']">';
				$message .= '<option value="delete">' . $MSG['008'] . '</option>';
				$message .= $move;
				$message .= '</select>';
				$message .= '</td>';
				$message .= '</tr>';
				$counter++;
			}
		}
		$message .= '</table>';
		// build message
		$template->assign_vars(array(
				'ERROR' => (isset($ERROR)) ? $ERROR : '',
				'ID' => '',
				'MESSAGE' => (($counter > 0) ? $message : '') . '<p>' . $MSG['838'] . implode(', ', $names) . '</p>',
				'TYPE' => 1
				));
		include 'adminHeader.php';
		$template->set_filenames(array(
				'body' => 'confirm.tpl'
				));
		$template->display('body');
		include 'adminFooter.php';
		exit;
	}
}

// Get data from the database
$query = "SELECT COUNT(f.id) as COUNT, c.category, c.id FROM " . $DBPrefix . "faqscategories c
			LEFT JOIN " . $DBPrefix . "faqs f ON ( f.category = c.id )
			GROUP BY c.id ORDER BY :o";
$params = array();
$params[] = array(':o', 'category', 'str');
$db->query($query, $params);

$bg = '';
while ($row = $db->result())
{
	$template->assign_block_vars('cats', array(
			'ID' => $row['id'],
			'CATEGORY' => $row['category'],
			'FAQSTXT' => sprintf($MSG['837'], $row['COUNT']),
			'FAQS' => $row['COUNT'],
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

foreach ($LANGUAGES as $k => $v)
{
	$template->assign_block_vars('lang', array(
			'LANG' => $k,
			'B_NODEFAULT' => ($k != $system->SETTINGS['defaultlanguage'])
			));
}

$template->assign_vars(array(
	'B_ADDCAT' => (isset($_GET['do']) && $_GET['do'] == 'add'),
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['5230'],
	'PAGETITLE' => $MSG['5230']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'faqscategories.tpl'
		));
$template->display('body');
include 'adminFooter.php';