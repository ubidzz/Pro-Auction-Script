<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/


reset($LANGUAGES);
foreach ($LANGUAGES as $k => $v)
{
	include LANGUAGE_PATH . $k . '/messages.inc.php';
	include LANGUAGE_PATH . $k . '/categories.inc.php';

	$query = "SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id = -:pi";
	$params = array();
	$params[] = array(':pi', 1, 'int');
	$db->query($query, $params);
	$DATA = $db->result('cat_id');
	$query = "SELECT cat_id FROM " . $DBPrefix . "categories WHERE parent_id = :pi ORDER BY cat_name";
	$params = array();
	$params[] = array(':pi', $DATA, 'int');
	$db->query($query, $params);
	$output = '<select name="id">' . "\n";
	$output.= "\t" . '<option value="0">' . $MSG['277'] . '</option>' . "\n";
	$output.= "\t" . '<option value="0">----------------------</option>' . "\n";

	$num_rows = $db->numrows();

	$i = 0;
	while ($row = $db->result())
	{
		$category_id = $row['cat_id'];
		$cat_name = $category_names[$category_id];
		$output .= "\t" . '<option value="' . $category_id . '">' . $cat_name . '</option>' . "\n";
		$i++;
	}

	$output.= '</select>'."\n";

	$handle = fopen (LANGUAGE_PATH . $k . '/categories_select_box.inc.php', 'w');
	fputs($handle, $output);
	fclose($handle);
}
?>