<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';

$theme_root = MAIN_PATH . 'themes/'; //theres no point repeatedly defining this

if (isset($_POST['action']) && $_POST['action'] == "update_logo") {
	if (isset($_FILES['logo']['tmp_name']) && !empty($_FILES['logo']['tmp_name'])) {
		// Handle logo upload
		$inf = GetImageSize ($_FILES['logo']['tmp_name']);
		if ($inf[2] < 1 || $inf[2] > 3) {
			$LOGOUPLOADED = false;
		}
		if (!empty($_FILES['logo']['tmp_name']) && $_FILES['logo']['tmp_name'] != "none") {
			if ($system->move_file($_FILES['logo']['tmp_name'], UPLOAD_PATH . 'logos/' . $_FILES['logo']['name'])) {
				$LOGOUPLOADED = true;
			} else {
				$LOGOUPLOADED = false;
			}
		}
	}
	if($LOGOUPLOADED)
	{
		$system->writesetting("settings", "logo", $_FILES['logo']['name'], 'str');
		$ERROR = $MSG['3500_1015670'];
	}
	else
	{
		$ERROR = $MSG['3500_1015671'];
	}
}
$logoURL = $system->SETTINGS['siteurl'] . UPLOAD_FOLDER . 'logos/' . $system->SETTINGS['logo'];


$theme_root = MAIN_PATH . 'themes/'; //theres no point repeatedly defining this
if (isset($_POST['action']) && $_POST['action'] == 'clear_cache')
{
	if (is_dir(MAIN_PATH . 'cache'))
	{
		$dir = opendir(MAIN_PATH . 'cache');
		while (($myfile = readdir($dir)) !== false)
		{
			if ($myfile != '.' && $myfile != '..' && $myfile != 'index.php')
			{
				unlink(MAIN_PATH . 'cache/' . $myfile);
			}
		}
		closedir($dir);
	}
	$ERROR = $MSG['30_0033'];
}

if (isset($_POST['action']) && $_POST['action'] == 'updateFront')
{
	if (is_dir($theme_root . '/' . $_POST['dtheme']) && !empty($_POST['dtheme']))
	{
		// Update database
		$system->writesetting("settings", "theme", $_POST['dtheme'], 'str');
		$ERROR = $MSG['26_0005'];
	}
	else
	{
		$ERROR = $ERR['068'];
	}
}
elseif (isset($_POST['action']) && $_POST['action'] == 'updateAdmin')
{
	if (is_dir($theme_root . '/' . $_POST['admin_theme']) && !empty($_POST['admin_theme']))
	{
		// Update database
		$system->writesetting("settings", "admin_theme", $_POST['admin_theme'], 'str');
		$ERROR = $MSG['26_000'];
	}
	else
	{
		$ERROR = $ERR['080'];
	}
}
elseif (isset($_POST['action']) && ($_POST['action'] == 'add' || $_POST['action'] == 'edit'))
{
	$filename = ($_POST['action'] == 'add') ? $_POST['new_filename'] : $_POST['filename'];
	$fh = fopen($theme_root . $_POST['theme'] . '/' . $filename, 'w') or die("can't open file " . $theme_root . $_POST['theme'] . '/' . $filename);
	fwrite($fh, $_POST['content']);
	fclose($fh);
}

$abg = $bg = '';
if (is_dir($theme_root))
{
	if ($dir = opendir($theme_root))
	{
		while (($atheme = readdir($dir)) !== false)
		{
			$theme_path = $theme_root . '/' . $atheme;
			$list_files = (isset($_GET['do']) && isset($_GET['theme']) && $_GET['do'] == 'listfiles' && $_GET['theme'] == $atheme);
			if ($atheme != 'CVS' && is_dir($theme_path) && substr($atheme, 0, 1) != '.')
			{
				$THEMES[$atheme] = $atheme;
				if (strstr($atheme, 'admin') === false)
				{
					$template->assign_block_vars('themes', array(
							'NAME' => $atheme,
							'B_CHECKED' => ($system->SETTINGS['theme'] == $atheme),
							'B_LISTFILES' => $list_files,
							'BG' => $bg
						));
					$bg = ($bg == '') ? 'class="bg"' : '';
				}
				else
				{
					$template->assign_block_vars('admin_themes', array(
							'NAME' => $atheme,
							'B_CHECKED' => ($system->SETTINGS['admin_theme'] == $atheme),
							'B_LISTFILES' => $list_files,
							'BG' => $abg
						));
					$abg = ($abg == '') ? 'class="bg"' : '';
				}
				if ($list_files)
				{
					// list files
					$handler = opendir($theme_path);
					// keep going until all files in directory have been read
					$files = array();
					while ($file = readdir($handler))
					{
						$extension = substr($file, strrpos($file, '.') + 1);
						if (in_array($extension, array('tpl', 'html', 'css')))
						{
							$files[] = $file;
						}
					}
					sort($files);
					for ($i = 0; $i < count($files); $i++)
					{
						if (strstr($atheme, 'admin') === false)
						{
							$template->assign_block_vars('themes.files', array(
									'FILE' => $files[$i]
									));
						}
						else
						{
							$template->assign_block_vars('admin_themes.files', array(
									'FILE' => $files[$i]
									));
						}
					}
				}
			}
		}
		closedir($dir);
	}
}
if(isset($_POST['action']) && $_POST['action'] == 'clear_cache')
{
	clearCache();
}

$edit_file = false;
if (isset($_POST['file']) && !empty($_POST['theme']))
{
	$theme_path = $theme_root . '/' . $_POST['theme'];
	if ($_POST['theme'] != 'CVS' && is_dir($theme_path) && substr($_POST['theme'], 0, 1) != '.')
	{
		$edit_file = true;
		$filename = $_POST['file'];
		$theme = $_POST['theme'];
		$filecontents = htmlentities(file_get_contents($theme_path . '/' . $filename));
	}
}
elseif (isset($_GET['do']) && $_GET['do'] == 'addfile')
{
	$edit_file = true;
	$theme = $_GET['theme'];
}

$template->assign_vars(array(
	'FILENAME' => isset($filename) ? $filename : '',
	'THEME' => isset($theme) ? $theme : '',
	'FILECONTENTS' => isset($filecontents) ? $filecontents : '',
	'B_EDIT_FILE' => $edit_file,
	'IMAGEURL' => $logoURL,
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'PAGENAME' => '<a href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_themes" target="_blank">' . $MSG['30_0031a'] . '</a>',
	'PAGETITLE' => $MSG['30_0031a']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'theme.tpl'
		));
$template->display('body');
include 'adminFooter.php';