<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

$language = (isset($_GET['lang'])) ? $_GET['lang'] : 'EN';
$catscontrol = new MPTTcategories();

function search_cats($parent_id, $level)
{
	global $DBPrefix, $catscontrol;
	$catstr = '';
	$root = $catscontrol->get_virtual_root();
	$tree = $catscontrol->display_tree($root['left_id'], $root['right_id'], '|___');
	foreach ($tree as $k => $v)
	{
		$v = str_replace("'", "\'", $v);
		$catstr .= ",\n" . $k . " => '" . addslashes($v) . "'";
	}
	return $catstr;
}

function rebuild_cat_file($cats)
{
	global $language;
	$output = "<?php\n";
	$output.= "$" . "category_names = array(\n";

	$num_rows = count($cats);

	$i = 0;
	foreach ($cats as $k => $v)
	{
		$v = str_replace("'", "\'", $v);
		$output .= "$k => '$v'";
		$i++;
		if ($i < $num_rows)
			$output .= ",\n";
		else
			$output .= "\n";
	}

	$output .= ");\n\n";

	$output .= "$" . "category_plain = array(\n0 => ''";

	$output .= search_cats(0, 0);

	$output .= ");\n?>";

	$handle = fopen (LANGUAGE_PATH . $language . '/categories.inc.php', 'w');
	fputs($handle, $output);
	fclose($handle);
}

if (isset($_POST['categories']))
{
	rebuild_cat_file($_POST['categories']);
	include 'util_cc1.php';
}

include LANGUAGE_PATH . $language . '/categories.inc.php';

$query = "SELECT cat_id, cat_name FROM " . $DBPrefix . "categories ORDER BY cat_name";
$db->direct_query($query);
$bg = '';
while ($row = $db->result())
{
	// set category data
	$template->assign_block_vars('cats', array(
		'CAT_ID' => $row['cat_id'],
		'CAT_NAME' => $system->uncleanvars($row['cat_name']),
		'TRAN_CAT' => $category_names[$row['cat_id']],
		'BG' => $bg
	));
	$bg = ($bg == '') ? 'class="bg"' : '';
}
$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a style="color:lime" href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_categories_trans_table" target="_blank">' . $MSG['132'] . '</a>',
	'PAGETITLE' => $MSG['132']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'categoriestrans.tpl'
		));
$template->display('body');
include 'adminFooter.php';