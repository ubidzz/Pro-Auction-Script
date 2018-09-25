<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include INCLUDE_PATH . 'functions_rebuild.php';
unset($ERROR);
function delete_countries($column)
{
	global $DBPrefix, $system, $db;

	// we use a single SQL query to quickly do ALL our deletes
		$query = "DELETE FROM " . $DBPrefix . "countries WHERE ";
		$params = array();
		// if this is the first country being deleted it don't
		// precede it with an " or " in the SQL string
		for ($i = 0; $i < count($column); $i++)
		{
			if ($i > 0)
			{
				$query .= " OR ";
			}
			$query .= "country = :" . $i . " ";
			$params[] = array(':' . $i,  stripslashes($system->cleanvars($column[$i])), 'str');
		}
		$db->query($query, $params);
}

function update_countries($old_column, $new_column)
{
	global $DBPrefix, $db, $system;
	
	$query = "UPDATE " . $DBPrefix . "countries SET country = :c WHERE country = :wc";
	$params = array();
	$params[] = array(':c', stripslashes($system->cleanvars($new_column)), 'str');
	$params[] = array(':wc', stripslashes($system->cleanvars($old_column)), 'str');
	$db->query($query, $params);
}
function new_countries($column)
{
	global $DBPrefix, $db, $system;
	
	$query = "INSERT INTO " . $DBPrefix . "countries (country) VALUES (:c)";
	$params = array();
	$params[] = array(':c', stripslashes($system->cleanvars($column)), 'str');
	$db->query($query, $params);
}

if (isset($_POST['act']))
{
	// remove any countries that need to be
	if (isset($_POST['delete']) && count($_POST['delete']) > 0)
	{
		delete_countries($_POST['delete']);
	}

	//update countries with new names
	for ($i = 0; $i < count($_POST['old_countries']); $i++)
	{
		$old = $_POST['old_countries'][$i];
		$new = $_POST['new_countries'][$i];
		if ($old != $new)
		{
			update_countries($old, $new);
		}
	}

	// If a new country was added, insert it into database
	$add = $_POST['add_new_countries'][(count($_POST['add_new_countries']) - 1)];
	if (!empty($add))
	{
		new_countries($add);
	}
	rebuild_html_file('countries');
	$ERROR = $MSG['1028'];
}

include INCLUDE_PATH . 'countries.inc.php';

$i = 1;
while ($i < count($countries))
{
	$j = $i - 1;
	// check if the country is being used by a user
	$query = "SELECT id FROM " . $DBPrefix . "users WHERE country = :c LIMIT :l";
	$params = array();
	$params[] = array(':c', $countries[$i], 'str');
	$params[] = array(':l', 1, 'int');
	$db->query($query, $params);
	$USEDINUSERS = $db->numrows('id');
	
	$template->assign_block_vars('countries', array(
			'COUNTRY' => $countries[$i],
			'SELECTBOX' => ($USEDINUSERS == 0) ? '<input id="delete" type="checkbox" name="delete[]" value="' . $countries[$i] . '">' : '<img src="../images/nodelete.gif" alt="You cannot delete this">'
			));
	$i++;
}
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => $MSG['081'],
	'PAGETITLE' => $MSG['081']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'countries.tpl'
		));
$template->display('body');
include 'adminFooter.php';