<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
include CONFIG_PATH . 'class_language_functions.php';
$langClass = new language();

$country = (isset($_GET['country'])) ? $_GET['country'] : '';
$pageType = (isset($_GET['emailtype'])) ? $_GET['emailtype'] : '';
$list_files = (isset($_GET['do']) && $_GET['do'] == 'listfiles') ? true : false;

if (isset($_POST['action']) && $_POST['action'] == 'edit' && isset($_POST['country']) && isset($_POST['filename']) && isset($_POST['content']) && isset($_POST['type']))
{
	$filename = $_POST['filename'];
	$fh = fopen(LANGUAGE_PATH . $security->decrypt($_POST['country']) . '/emails/' . $_POST['type'] . '/' . $filename, 'w');
	fwrite($fh, $system->checkEncoding(trim(str_replace('<p>﻿</p>', '', $_POST['content']))));
	fclose($fh);
}

if($country !='')
{
	$email_path = LANGUAGE_PATH . $security->decrypt($country) . '/emails/' . $pageType;
	if ($dir = opendir($email_path))
	{
		while (($emailFile = readdir($dir)) !== false)
		{
			if ($emailFile != 'CVS' && is_dir($email_path) && substr($emailFile, 0, 1) != '.')
			{
				if ($list_files)
				{
					$extension = substr($emailFile, strrpos($emailFile, '.') + 1);
					if (in_array($extension, array('php')))
					{
						$files[] = $emailFile;
					}
				}
			}
		}
		sort($files);
		closedir($dir);
		for ($i = 0; $i < count($files); $i++)
		{
			if(isset($_POST['file']) && $_POST['file'] == $files[$i])
			{
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$template->assign_block_vars('files', array(
				'FILE' => $files[$i],
				'SELECTED' => $selected
			));
		}

	}
}
$edit_file = false;
if (isset($_POST['file']) && isset($_POST['action']) && $_POST['action'] == 'updateEmail')
{
	$email_path = LANGUAGE_PATH . $security->decrypt($country) . '/emails/' . $pageType;
	if ($_POST['file'] != 'CVS' && is_dir($email_path) && substr($_POST['file'], 0, 1) != '.')
	{
		$edit_file = true;
		$filename = $_POST['file'];
		$filecontents = file_get_contents($email_path . '/' . $filename);
	}
}

// list of all language flags
foreach ($LANGUAGES as $lang => $value)
{
	$template->assign_block_vars('languages', array(
			'LANG' => $value,
			'B_DEFAULT' => ($lang == $system->SETTINGS['defaultlanguage']),
			'LANGS' => $security->encrypt($value)
		));
}

$template->assign_vars(array(
	'D_COUNTRY' => $country !='' ? $security->decrypt($country) : '',
	'COUNTRY' => $country,
	'B_COUNTRY' => $country !='' ? true : false,
	'B_EDIT_FILE' => $edit_file,
	'FILECONTENTS' => isset($filecontents) ? $pageType !='text' ? $CKEditor->editor('content', $filecontents) : htmlentities($filecontents) : '',
	'FILENAME' => isset($filename) ? $filename : '',
	'URL_PAGETYPE' => $pageType !='' ? '&emailtype=' . $pageType : '',
	'PAGETYPE' => $pageType !='' ? $pageType : '',
	'B_LISTFILES' => $list_files,
	'B_PAGETYPE' => $pageType !='text' ? true : false,
));

include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'translateemails.tpl'
		));
$template->display('body');
include 'adminFooter.php';