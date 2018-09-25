<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/licenses/free
 *******************************************************************************/
define('InProAuctionScript', 1);
define('MAIN_PATH', getmainpath());
// SQL handler, class and connect to db
define('DATABASE_PATH', '../includes/database/');
include DATABASE_PATH . 'Database.php';
include DATABASE_PATH . 'DatabasePDO.php';
$db = new DatabasePDO();

if(file_exists('../includes/config/config.inc.php'))
{
	@include MAIN_PATH . 'includes/config/config.inc.php';
	$db->connect($DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix, 'utf-8');
}

if(isset($_POST['siteName']))
{
	$_SESSION['siteName'] = $_POST['siteName'];
}else{
	$_SESSION['siteName'];
}

function getSettings()
{
	global $db, $DBPrefix;
	
	if($db) {
		$query = "SELECT * FROM " . $DBPrefix . "settings";
		$db->direct_query($query);
		while ($data = $db->fetch())
		{
			$str[$data['fieldname']] = $data['value'];
		}
	}
	return $str;
}
function getmainpath()
{
	$path = getcwd();
	$path = str_replace('install', '', $path);
	return $path;
}

function installNewDB()
{
	global $db, $DBPrefix;
	
	$siteURL = urldecode($_GET['URL']);
	$siteName = $_SESSION['siteName'];
	$siteEmail = $_GET['EMail'];
	include MAIN_PATH . 'install/sql/dump.inc.php';
	$countDB = @count($query);
	for ($i = 0; $i < $countDB; $i++)
	{
		$db->direct_query($query[$i]);
	}
	return array('imported' => $i, 'total' => $countDB);
}

function getdomainpath()
{
	$path = dirname($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	if (strlen($path) < 12)
	{
		$path = dirname($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
	}
	$path = str_replace('install', '', $path);
	return $path;
}

function makeconfigfile($contents, $main_path)
{
	$filename = $main_path . 'includes/config/config.inc.php';
	$altfilename = $main_path . 'includes/config/config.inc.php.new';

	if (!file_exists($filename))
	{
		if (file_exists($altfilename))
		{
			rename($altfilename, $filename);
		}
		else
		{
			touch($filename);
		}
	}

	@chmod($filename, 0777);

	if (is_writable($filename))
	{
		if (!$handle = fopen($filename, 'w')) 
		{
			$return = false;
		}
		else
		{
			if (fwrite($handle, $contents) === false)
			{
				$return = false;
			}
			else
			{
				$return = true;
			}
		}
		fclose($handle);
	}
	else
	{
		$return = false;
	}

	return $return;
}
function is_https()
{
	if($_SERVER['HTTPS'] == 'off') $bool = 'n';
	if($_SERVER['HTTPS'] == 'on') $bool = 'y';
	return $bool;
}
function get_href()
{
	if($_SERVER['HTTPS'] == 'on')
	{
		return 'https://';
	}else{
		return 'http://';
	}	
}
function print_header($update)
{
	if ($update)
	{
		global $_SESSION;
		if (!isset($_SESSION['oldversion']))
		{
			$_SESSION['oldversion'] = installed_version();
		}
		
		return '<link rel="stylesheet" type="text/css" href="' . get_href() . getdomainpath() . '/themes/default/css/bootstrap.min1.css">
		<script type="text/javascript" src="' . get_href() . getdomainpath() . '/js/jquery.js"></script><div class="container-fluid">
		<h1 align="center">Pro-Auction-Script Updater ' . $_SESSION['oldversion'] . ' to ' . new_version() . '</h1>';
	}
	else
	{
		return '<link rel="stylesheet" type="text/css" href="' . get_href() . getdomainpath() . '/themes/default/css/bootstrap.min1.css">
		<script type="text/javascript" src="' . get_href() . getdomainpath() . '/js/jquery.js"></script><div class="container-fluid">
		<h1 align="center">Pro-Auction-Script Installer ' . new_version() . '</h1>';
	}
}

function new_version()
{
	$string = file_get_contents('thisversion.txt') or die('error');
	return $string;
}

function settings_array()
{
	return getSettings();
}

function installed_version()
{
	global $db, $DBPrefix;
	
	if($DBPrefix !='') 
	{
		if (!$db)
		{		
			$version = 'Failed to connect to the database';
		}else{
			$str = getSettings();
			$version = $str['version'];
		}
	}else{
		$version = new_version();
	}
	return $version;
}


function check_installation()
{
	$str = getSettings();
	$settings_version = count($str['version']) == 1 ? $str['version'] : false;
	if($settings_version != new_version())
	{
		return true;
	}
	else
	{
		return false;
	}
}

function deleteInstallFolder($str) 
{
	//deleting all the install files and directories
	if (is_file($str)) 
	{
		return @unlink($str);
	}
	elseif (is_dir($str)) 
	{
		$trim_str = rtrim($str,'/');
		$scan = glob($trim_str . '/*');
		foreach($scan as $index=>$path) 
		{
			deleteInstallFolder($path);
		}
		return @rmdir($str);
	}
}

function UpdateDB()
{
	global $db, $DBPrefix;
	
	$myversion = installed_version();
	$settings = getSettings();
	$siteName = $settings['sitename'];
	$siteURL = $settings['siteurl'];
	
	@include 'sql/updatedump.inc.php';
	$countDB = @count($query);
	$arraydata = array();
	for ($i = 0; $i < $countDB; $i++)
	{
		$db->direct_query($query[$i]);
		$arraydata[] = $query[$i];
	}
	echo '<div class="span12 well">
				<div id="message"></div>
				<div class="progress">
					<div id="progress-bar" class="progress-bar progress-bar-success progress-bar-striped active" style="width:0%"><div id="finishedPercent"></div></div>
				</div>
				<div id="log"></div>
			</div>
			<script type="text/javascript">
			var width = 0;
			var nIntervId;
			var counter = 0;
			var newHTML = [];

			window.onload = function()
			{ 
			    nIntervId = setInterval(updatemessage, ' . $countDB . ');
			}
			
			function updatemessage() 
			{
				width = width > 100 ? 100 : width + ' . round(100 / $countDB) . ';  
			    document.getElementById("progress-bar").style.width = width + "%"; 
			    document.getElementById("finishedPercent").innerHTML= "Updating Database: " + width + "% finished...";
			    var newVersion = "' . new_version() .'";
			    var installedVersion = "' . installed_version() . '";
			    				
			    if(width == 100)
			    {
			   		if(newVersion == installedVersion)
			   		{
			        	document.getElementById("message").innerHTML = "<h4>COMPLETE!</h4>Now to <b><a href=\"?step=3\">step 3</a></b> or view the database log.";
			        	document.getElementById("message").className = "alert alert-success";
			        	clearInterval(nIntervId);
			    	}else{
			       		document.getElementById("message").innerHTML = "<h4>ERROR!</h4>The database didn\'t update please try <b><a href=\"?step=2\">step 2</a></b> again.";
			       		document.getElementById("message").className = "alert alert-error";
			       		clearInterval(nIntervId);
			    	}
				}
				counter++;
				DBlog();
			}
			
			newHTML.push("<br /><h3>Database Log</h3><hr /><b>The Database log displays what tables that are being edited</b><hr />");
			function DBlog() 
			{
				var array = ' . json_encode($arraydata). ';
			    for (var i = 0; i < array.length; i++) {
			    	if(counter - 1 == [i]){
				    	newHTML.push("<div><b>Database:</b> " + array[i] + "</div>");
				    }
				}
				document.getElementById("log").innerHTML = newHTML.join("");
			}
  			</script>';
}

function show_config_table($fresh = true)
{
	$data = '<form name="form1" method="post" action="?step=1">';
	$data .= '<table class="table table-striped table-bordered table-condensed">';
	$data .= '<tr>';
	$data .= '	<td colspan="3"><b>Server Details:</b></td>';
	$data .= '</tr>';
	$data .= '<tr>';
	$data .= '	<td width="13%">URL</td>';
	$data .= '	<td width="25%">';
	$data .= '	  <input type="text" class="form-control" name="URL" id="textfield" value="' . getdomainpath() . '">';
	$data .= '	</td>';
	$data .= '	<td rowspan="2">';
	$data .= '	  The url &amp; location of the Pro-Auction-Script installation on your server. It\'s usually best to leave these as they are.<br>';
	$data .= '	  Also if your running on windows at the end of the <b>Doument Root</b> there should be a \\\\ (double backslash)';
	$data .= '	</td>';
	$data .= '  </tr>';
	$data .= '  <tr>';
	$data .= '	<td>Doument Root</td>';
	$data .= '	<td>';
	$data .= '	  <input class="form-control" type="text" name="mainpath" id="textfield" value="' . MAIN_PATH . '">';
	$data .= '	</td>';
	$data .= '</tr>';
	if ($fresh)
	{
		$data .= '<tr>';
		$data .= '	<td>Site Name</td>';
		$data .= '	<td><input class="form-control" type="text" name="siteName" id="textfield"></td>';
		$data .= '	<td>The name of your website (Required for adding the site name to the FAQs)</td>';
		$data .= '	<tr>';
		$data .= '<tr>';
		$data .= '	<td>Email Address</td>';
		$data .= '	<td>';
		$data .= '	  <input class="form-control" type="text" name="EMail" id="textfield">';
		$data .= '	</td>';
		$data .= '	<td>The admin email address</td>';
		$data .= '</tr>';
	}
	$data .= '<tr>';
	$data .= '	<td>Database Host</td>';
	$data .= '	<td>';
	$data .= '	  <input class="form-control" type="text" name="DBHost" id="textfield" value="localhost">';
	$data .= '	</td>';
	$data .= '	<td>The location of your MySQL database in most cases its just localhost</td>';
	$data .= '  </tr>';
	$data .= '  <tr>';
	$data .= '	<td>Database Username</td>';
	$data .= '	<td>';
	$data .= '	  <input class="form-control" type="text" name="DBUser" id="textfield">';
	$data .= '	</td>';
	$data .= '	<td rowspan="3">The username, password and database name of the database your installing Pro-Auction-Script on</td>';
	$data .= '  </tr>';
	$data .= '  <tr>';
	$data .= '	<td>Database Password</td>';
	$data .= '	<td>';
	$data .= '	  <input class="form-control" type="text" name="DBPass" id="textfield">';
	$data .= '	</td>';
	$data .= '  </tr>';
	$data .= '  <tr>';
	$data .= '	<td>Database Name</td>';
	$data .= '	<td>';
	$data .= '	  <input class="form-control" type="text" name="DBName" id="textfield">';
	$data .= '	</td>';
	$data .= '  </tr>';
	$data .= '  <tr>';
	$data .= '	<td>Database Prefix</td>';
	$data .= '	<td>';
	$data .= '	  <input class="form-control" type="text" name="DBPrefix" id="textfield" value="ProAuction_">';
	$data .= '	</td>';
	$data .= '	<td>the prefix of the Pro-Auction-Script tables in the database, used so you can install multiple scripts in the same database without issues.</td>';
	$data .= '</tr>';
	if ($fresh)
	{
		$data .= '<tr>';
		$data .= '	<td>Import Default Categories</td>';
		$data .= '	<td>';
		$data .= '	  <input type="checkbox" name="importcats" id="checkbox" checked="checked">';
		$data .= '	</td>';
		$data .= '	<td>Leaving this checked is recommened. But you make want to uncheck it if your auction site is a specalist niche and will need custom catergories.</td>';
		$data .= '</tr>';
	}

	if ($fresh)
	{
		$data .= '<tr>';
		$data .= '	<td colspan="3"><b>File Checks:</b></td>';
		$data .= '</tr>';
		$directories = array(
			'cache/',
			'uploaded/',
			'uploaded/auctions/',
			'uploaded/auctions/temps/',
			'uploaded/avatar/',
			'uploaded/banners/',
			'uploaded/cache/',
			'uploaded/items/',
			'uploaded/logos/',
			'uploaded/logos/favicon/',
			'uploaded/logos/watermarks/',
			'uploaded/temps/'
			);

		umask(0);

		$passed = true;
		foreach ($directories as $dir)
		{
			$exists = $write = false;

			// Try to create the directory if it does not exist
			if (!file_exists(MAIN_PATH . $dir))
			{
				if($dir == 'uploaded/items/')
				{
					@mkdir(MAIN_PATH . $dir, 0700);
					@chmod(MAIN_PATH . $dir, 0700);
				}
				else
				{
					@mkdir(MAIN_PATH . $dir, 0755);
					@chmod(MAIN_PATH . $dir, 0755);
				}
			}
			else
			{
				if($dir == 'uploaded/items/')
				{
					@chmod(MAIN_PATH . $dir, 0700);
				}
				else
				{
					@chmod(MAIN_PATH . $dir, 0755);
				}
			}
			// Now really check
			if (file_exists(MAIN_PATH . $dir) && is_dir(MAIN_PATH . $dir))
			{
				$exists = true;
			}

			// Now check if it is writable by storing a simple file
			$fp = @fopen(MAIN_PATH . $dir . 'test_lock', 'wb');
			if ($fp !== false)
			{
				$write = true;
			}
			@fclose($fp);

			@unlink(MAIN_PATH . $dir . 'test_lock');

			if (!$exists || !$write)
			{
				$passed = false;
			}

			$data .= '<tr ><td colspan="2">' . $dir . ':</td><td colspan="3">';
			$data .= ($exists) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
			$data .= ($write) ? ', <strong style="color:green">Writable</strong>' : (($exists) ? ', <strong style="color:red">Unwritable</strong>' : '');
			$data .= '</tr>';
		}

		//check config file exists and is writable
		$write = $exists = true;
		if (file_exists(MAIN_PATH . 'includes/config/config.inc.php'))
		{
			if (!@is_writable(MAIN_PATH . 'includes/config/config.inc.php'))
			{
				$write = false;
			}
		}
		elseif (file_exists(MAIN_PATH . 'includes/config/config.inc.php.new'))
		{
			if (!@is_writable(MAIN_PATH . 'includes/config/config.inc.php.new'))
			{
				$write = false;
			}
		}
		else
		{
			$write = $exists = false;
		}

		if (!$exists || !$write)
		{
			$passed = false;
		}

		$data .= '<tr><td colspan="2">includes/config/config.inc.php.new:</td><td colspan="2">';
		$data .= ($exists) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= ($write) ? ', <strong style="color:green">Writable</strong>' : (($exists) ? ', <strong style="color:red">Unwritable</strong>' : '');
		$data .= '</tr>';

		$directories = array(
			'includes/countries.inc.php',
			'includes/currencies.php',
			'includes/membertypes.inc.php',
			'language/EN/categories.inc.php',
			'language/EN/categories_select_box.inc.php'
			);

		foreach ($directories as $dir)
		{
			$write = $exists = true;
			if (file_exists(MAIN_PATH . $dir))
			{
				if (!@is_writable(MAIN_PATH . $dir))
				{
					$write = false;
				}
			}
			else
			{
				$write = $exists = false;
			}

			if (!$exists || !$write)
			{
				$passed = false;
			}

			$data .= '<tr><td colspan="2">' . $dir . ':</td><td colspan="2">';
			$data .= ($exists) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
			$data .= ($write) ? ', <strong style="color:green">Writable</strong>' : (($exists) ? ', <strong style="color:red">Unwritable</strong>' : '');
			$data .= '</tr>';
		}
		
		$data .= '<tr><td colspan="2">PHP Version must be higher than 5.4.x:</td><td colspan="2">';
		$data .= (phpversion() > '5.4.0') ? '<strong style="color:green">' . phpversion() . '</strong>' : '<strong style="color:red">' . phpversion() . '</strong>';
		$data .= '</tr>';

		$data .= '<tr><td colspan="2">GD Support:</td><td>';
		$data .= (extension_loaded('gd') && function_exists('gd_info')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';
		
		$gdinfo = gd_info();
		$data .= '<tr><td colspan="2">FreeType Support:</td><td colspan="2">';
		$data .= ($gdinfo['FreeType Support']) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';

		$data .= '<tr><td colspan="2">BC Math Support:</td><td colspan="2">';
		$data .= (extension_loaded('bcmath')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';
		
		$data .= '<tr><td colspan="2">PHP Data Objects (PDO) Support:</td><td colspan="2">';
		$data .= (extension_loaded('pdo')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';
		
		$data .= '<tr><td colspan="2">Hash Hmac Support Support:</td><td colspan="2">';
		$data .= (function_exists('hash_hmac')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';
		
		$data .= '<tr><td colspan="2">MBString Support:</td><td colspan="2">';
		$data .= (extension_loaded('mbstring')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';
		
		$data .= '<tr><td colspan="2">Mcrypt Encrypt Support:</td><td colspan="2">';
		$data .= (function_exists('mcrypt_encrypt')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';
		
		$data .= '<tr><td colspan="2">OpenSSL Support:</td><td colspan="2">';
		$data .= (extension_loaded('openssl')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';
				
		$data .= '<tr><td colspan="2">allow_url_fopen Support:</td><td>';
		$data .= (ini_get('allow_url_fopen')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';
		
		$data .= '<tr><td colspan="2">PHP mod_eader:</td><td>';
		$data .= (function_exists('getallheaders')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';

		$data .= '<tr><td colspan="2">fopen Support:</td><td>';
		$data .= (function_exists('fopen')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';
		
		$data .= '<tr><td colspan="2">fread Support:</td><td>';
		$data .= (function_exists('fread')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';

		$data .= '<tr><td colspan="2">file_get_contents Support:</td><td>';
		$data .= (function_exists('file_get_contents')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';
		
		$data .= '<tr><td colspan="2">curl Support:</td><td>';
		$data .= (function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec') && function_exists('curl_close')) ? '<strong style="color:green">Found</strong>' : '<strong style="color:red">Not Found</strong>';
		$data .= '</tr>';
	}

	if ($fresh && $passed || !$fresh)
	{
		$data .= '<tr><td colspan="3"><button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> install</button></td></tr>';
	}
	$data .= '</table>';
	$data .= '</form>';
	
	return $data;
}

function search_cats($parent_id, $level)
{
	global $DBPrefix, $catscontrol;
	$root = $catscontrol->get_virtual_root();
	$tree = $catscontrol->display_tree($root['left_id'], $root['right_id'], '|___');
	foreach ($tree as $k => $v)
	{
		$catstr .= ",\n" . $k . " => '" . $v . "'";
	}
	return $catstr;
}

function rebuild_cat_file()
{
	global $system, $DBPrefix, $db;
	$query = "SELECT cat_id, cat_name, parent_id FROM " . $DBPrefix . "categories ORDER BY cat_name";
	$db->direct_query($query);
	$cats = array();
	while ($catarr = $db->fetch())
	{
		$cats[$catarr['cat_id']] = $catarr['cat_name'];
		$allcats[] = $catarr;
	}
	$output = "<?php\n";
	$output.= "$" . "category_names = array(\n";
	$num_rows = count($cats);
	$i = 0;
	foreach ($cats as $k => $v)
	{
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
	$handle = fopen (MAIN_PATH . 'language/' . $system->SETTINGS['defaultlanguage'] . '/categories.inc.php', 'w');
	fputs($handle, $output);
}
?>