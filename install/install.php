<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: http://www.Pro-Auction-Script.com
 *******************************************************************************/

session_start();
define('InInstaller', 1);
include 'functions.php';

define('MAIN_PATH', getmainpath());
$newversion = new_version();
$_SESSION['old_version'] = print_header(true);
echo print_header(false);

$step = (isset($_GET['step'])) ? $_GET['step'] : 0;
switch($step)
{
	case 10: // Only used by Softaculous to install the u-Auctions Pro-Auction-Script
		$dataCount = installNewDB();
		if ($dataCount['imported'] < $dataCount['total'])
		{
			echo '<div class="well span9">
				<p>Failed to install the database please try again</p>
				</div>
			';
		}
		else
		{
			$sql_dir = $main_path . 'install/sql';
			$install_dir = $main_path . 'install';
			if (is_dir($sql_dir))
			{
				if ($dir = opendir($sql_dir))
				{
					while (($file = readdir($dir)) !== false)
					{
						if (!is_dir($sql_dir . '/' . $file))
						unlink($sql_dir . '/' . $file);
					}
					closedir($dir);
				}
			}
			if (is_dir($install_dir))
			{
				if ($dir = opendir($install_dir))
				{
					while (($file = readdir($dir)) !== false)
					{
						if (!is_dir($install_dir . '/' . $file))
						unlink($install_dir . '/' . $file);
					}
					closedir($dir);
				}
			}
			if (is_dir($sql_dir)) rmdir($sql_dir);
			if (is_dir($install_dir)) rmdir($install_dir);
			echo '<div class="well span9">
			<p>' . $updateing . '</p>
			<p>Installation complete.</p>
				<p>What do I do now?</p>
				<ul>
					<li>Your Pro-Auction-Script password salt: <span style="color: #FF0000; font-weight:bold;">' . $_SESSION['hash'] . '</span> You should make note of this random code, it is used to secure your users passwords. It is stored in your config file if you accidently delete this file and don\'t have this code all your users will have to reset their passwords</li>
					<li>Finally set-up your admin account <a href="http://' . $_GET['URL'] . 'admin/" style="font-weight:bold;">here</a></li>
					<li>Maybe check out our <a href="https://u-auctions.com/forum/">support forum</a></li>
				</ul></div>';
		}

	break;
	case 2:

		$countDB = installNewDB();
		echo '<div class="span12">
				<div class="well">
					<div id="message"></div>
					<div class="progress">
						<div id="progress-bar" class="progress-bar progress-bar-success progress-bar-striped active" style="width:0%"><div id="finishedPercent"></div></div>
					</div>
					<div id="completed"></div>
				</div>
			</div>
			<script type="text/javascript">
			var width = 0;
			var nIntervId;

			window.onload = function()
			{ 
			    nIntervId = setInterval(updatemessages, ' . round($countDB['total']) . ');
			}
			
			function updatemessages() 
			{
			    var newVersion = "' . new_version() .'";
			    var installedVersion = "' . installed_version() . '";
			    
				progressing();				
			    if(width == 100)
			    {
			   		if(newVersion == installedVersion)
			   		{
			   			completed();
			    	}else{
			       		failed();
			    	}
				}
			}	
			
			function progressing() 
			{
				width = width > 100 ? 100 : width + 20;  
			    document.getElementById("progress-bar").style.width = width + "%"; 
			    document.getElementById("finishedPercent").innerHTML= "Installing Database: " + width + "% finished...";
			    if(width == 100){
			    	clearInterval(nIntervId);
			    }
			}
			
			function completed() 
			{
				document.getElementById("message").innerHTML = "<h4>COMPLETE!</h4><p>What do I do now?</p><ul><li>Your ProAuctionScript password salt: <span style=\"color: #FF0000; font-weight:bold;\">' . $_SESSION['hash'] . '</span> You should make note of this random code, it is used to secure your users passwords. It is stored in your config file if you accidently delete this file and don\'t have this code all your users will have to reset their passwords</li><li>Finally set-up your admin account <a href=\"http://' . getdomainpath() . 'admin\" style=\"font-weight:bold;\">here</a></li><li>Maybe check out our <a href=\"https://Pro-Auction-Script.com/forum\" target=\"_blank\">support forum</a></li></ul>";		
			    document.getElementById("message").className = "alert alert-success";
			}
			
			function failed() 
			{
				document.getElementById("message").innerHTML = "<h4>ERROR!</h4>The database didn\'t update please try <b><a href=\"?step=2\">step 2</a></b> again.";
			    document.getElementById("message").className = "alert alert-error";
			}
  		</script>';
  		if($countDB['imported'] == $countDB['total'])
		{
			deleteInstallFolder(MAIN_PATH . 'install');
		}
	break;
	case 1:
		$connection_parameters = array('DBHost', 'DBUser', 'DBName');
		$invalid_parameters = false;
		foreach($connection_parameters as $parameter_name)
		{
		   if (!isset($_POST[$parameter_name]) || empty($_POST[$parameter_name]))
		   {
		      $invalid_parameters = true;
		   }
		}

		if (!$db->connect($_POST['DBHost'], $_POST['DBUser'], $_POST['DBPass'], $_POST['DBName'], $_POST['DBPrefix']))
		{
			$invalid_parameters = true;
		}

		if ($invalid_parameters)
		{
			$info = '<div class="alert alert-error span12"><b>Waning! Couldn\'t connect to the database.</b></div>
			<div class="span12 well well-sm">
				<p>What do I do now?</p>
				<p>Please <a href="javascript:void(0)" onclick="window.history.back();">return to step 1</a> and verify that...</p>
				<ol>
					
					<li>\'Database Host\' is correct.</li>
					<li>\'Database Username\' is correct and that the specified user can access the database.</li>
					<li>\'Database Password\' is correct.</li>
					<li>\'Database Name\' is correct and the specified database exists.</li>
				</ol></div>';
		}else{
			$cats = (isset($_POST['importcats'])) ? 1 : 0;
			$path = str_replace('\\', '\\\\', $_POST['mainpath']);
			$hash = md5(microtime() . rand(0,50));
			$_SESSION['hash'] = $hash;
			// generate config file
			$content = '<?php' . "\n";
			$content .= '$DbHost	 = "' . $_POST['DBHost'] . '";' . "\n";
			$content .= '$DbDatabase = "' . $_POST['DBName'] . '";' . "\n";
			$content .= '$DbUser	 = "' . $_POST['DBUser'] . '";' . "\n";
			$content .= '$DbPassword = "' . $_POST['DBPass'] . '";' . "\n";
			$content .= '$DBPrefix	= "' . $_POST['DBPrefix'] . '";' . "\n";
			$content .= '$main_path = "' . $path . '";' . "\n";
			$content .= '$MD5_PREFIX = "' . $hash . '";' . "\n";
			$content .= '?>';
			$output = makeconfigfile($content, $path);
			if ($output)
			{
				$info = '<div class="well span9">
				<b>Step 1:</b> Writing config file...<br><br>
				Complete, now to <b><a href="?step=2&URL=' . urlencode($_POST['URL']) . '&EMail=' . $_POST['EMail'] . '&cats=' . $cats . '&n=1">step 2</a></b>
				</div>';
			}
			else
			{	
				$info = '<div class="well span9">
				<b>Step 1:</b> Writing config file...<br><br>
				Pro-Auction-Script could not automatically create the config file, please could you enter the following into config.inc.php (this file is located in the includes/config/ directory)
				<p><textarea style="width:500px; height:500px;">'.$content.'</textarea></p>
				<p>Once you\'ve done this, you can continue to <b><a href="?step=2&URL=' . urlencode($_POST['URL']) . '&EMail=' . $_POST['EMail'] . '&cats=' . $cats . '&n=1">step 2</a></b><p>
				</div>';
			}
		}
		echo $info;
	break;	
	default:
		if (file_exists('../includes/config/config.inc.php'))
		{
			$info = '<div class="well span9">
			<p>You appear to already have an installation on Pro-Auction-Script running would you like to do a <a href="update.php" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-cog"></span> upgrade instead?</a></p>
			</div>';
			echo $info;
		}
		echo show_config_table(true);
	break;

}
?>