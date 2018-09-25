<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/


if (!defined('InProAuctionScript')) exit('Access denied');

function rebuild_table_file($table)
{
	global $DBPrefix, $system, $db;
	
	switch($table)
	{
		case 'membertypes':
			$output_filename = INCLUDE_PATH . 'membertypes.inc.php';
			$field_name = array('id', 'feedbacks', 'icon');
			$sort_field = 1;
			$array_name = 'membertypes';
			$output = '<?php' . "\n";
			$output.= '$' . $array_name . ' = array(' . "\n";
		break;
	}

	$query = "SELECT " . join(',', $field_name) . " FROM " . $DBPrefix . "" . $table . " ORDER BY " .$field_name[$sort_field] . ";";
	$params = array();
	$params[] = array(':au_id', $id, 'int');
	$db->query($query, $params);
	$num_rows = $db->numrows();

	$i = 0;
	while ($row = $db->result())
	{
		$output .= '\'' . $row[$field_name[0]] . '\' => array(' . "\n";
		$field_count = count($field_name);
		$j = 0;
		foreach ($field_name as $field)
		{
			$output .= '\'' . $field . '\' => \'' . $row[$field] . '\'';
			$j++;
			if ($j < $field_count)
				$output .= ', ';
			else
				$output .= ')';
		}
		$i++;
		if ($i < $num_rows)
			$output .= ',' . "\n";
		else
			$output .= "\n";
	}

	$output .= ');' . "\n" . '?>';

	$handle = fopen($output_filename, 'w');
	fputs($handle, $output);
	fclose($handle);
}

function rebuild_html_file($table)
{
	global $DBPrefix, $system, $db;
	switch($table)
	{
		case 'countries':
			$output_filename = INCLUDE_PATH . 'countries.inc.php';
			$field_name = 'country';
			$array_name = 'countries';
		break;
	}

	$query = "SELECT " . $field_name . " FROM " . $DBPrefix . $table . " ORDER BY " . $field_name . ";";
	$params = array();
	$params[] = array(':au_id', $id, 'int');
	$db->query($query, $params);
	$num_rows = $db->numrows();

	$output = '<?php' . "\n";
	$output.= '$' . $array_name . ' = array(\'\', ' . "\n";

	$i = 0;
	while ($row = $db->result())
	{
		$output .= '\'' . $row[$field_name] . '\'';
		$i++;
		if ($i < $num_rows)
			$output .= ',' . "\n";
		else
			$output .= "\n";
	}

	$output .= ');' . "\n" . '?>';

	$handle = fopen($output_filename, 'w');
	fputs($handle, $output);
	fclose($handle);
}
?>