<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/licenses/free
 *******************************************************************************/
 
$step = (isset($_GET['step'])) ? $_GET['step'] : 0;
define('InInstaller', 1);
include 'functions.php';
define('MAIN_PATH', getmainpath());

/*
how new updater will work
in package config.inc.php will be named config.inc.php.new so it cannot be overwritten
1. check for config.inc.php
2. if config file missing ask for details
3. with database details check theres actually an installation of ProAuctionScript if not show link to make fresh install
	- if there is but no config write config file
4. collect query needed to run for version in use
5. update langauge files
*/

if ($step == 0)
{
	if (!file_exists(MAIN_PATH . 'includes/config/config.inc.php'))
	{
		$newversion = new_version();
		$myversion = installed_version();
		echo print_header(true);
		echo show_config_table(false);
	}
	else
	{
		$check = check_installation();
		$newversion = new_version();
		$header = print_header(true);
		if (!$check)
		{
			$info = 'It seems that you don\'t currently have a version of ProAuctionScript installed we recommend that you do a <b><a href="install.php">fresh install</a></b> or you may already have version ' . $newversion . ' installed!';
		}
		else
		{
			$info = 'Now to <b><a href="?step=2">step 1</a></b>';
		}
		echo $header;
		echo '<div class="well span12">' . $info . '</div>';
	}
}
if ($step == 1)
{
	$toecho = '<p><b>Step 1:</b> Writing the config file...</p>';
	$toecho .= '<p>As you are missing your old random security code all your users will have to reset their passwords after this update</p>';
	$path = (!get_magic_quotes_gpc()) ? str_replace('\\', '\\\\', $_POST['mainpath']) : $_POST['mainpath'];
	// generate config file
	$content = '<?php' . "\n";
	$content .= '$DbHost	 = "' . $_POST['DBHost'] . '";' . "\n";
	$content .= '$DbDatabase = "' . $_POST['DBName'] . '";' . "\n";
	$content .= '$DbUser	 = "' . $_POST['DBUser'] . '";' . "\n";
	$content .= '$DbPassword = "' . $_POST['DBPass'] . '";' . "\n";
	$content .= '$DBPrefix	= "' . $_POST['DBPrefix'] . '";' . "\n";
	$content .= 'MAIN_PATH . 	= "' . $path . '";' . "\n";
	$content .= '$MD5_PREFIX = "' . md5(microtime() . rand(0,50)) . '";' . "\n";
	$content .= '?>';
	$output = makeconfigfile($content, $path);	if ($output)
	{
		$check = check_installation();
		$newversion = new_version();
		$myversion = installed_version();
		echo print_header(true);
		echo $toecho;
		if (!$check)
		{
			echo 'It seems you don\'t currently have a version of ProAuctionScript installed we recommend you do a <b><a href="install.php">fresh install</a></b>';
		}
		else
		{
			echo 'Complete, now to <b><a href="?step=2">step 2</a></b>';
		}
	}
	else
	{
		$newversion = new_version();
		$myversion = installed_version();
		echo print_header(true);
		echo $toecho;
		echo 'ProAuctionScript could not automatically create the config file, please could you enter the following into config.inc.php (this file is located in the inclues/config/ directory)';
		echo '<p><textarea style="width:500px; height:500px;">' . $content . '</textarea></p>';
		echo 'Once you\'ve done this, you can continue to <b><a href="?step=2">step 2</a></b>';
	}
}
if ($step == 2)
{
	$check = check_installation();
	echo print_header(true);
	if (!$check)
	{
		echo 'It seems you don\'t currently have a version of ProAuctionScript installed we recommend you do a <b><a href="install.php">fresh install</a></b>';
		exit;
	}
	UpdateDB();
}
if ($step == 3)
{
	echo print_header(true);
	if (check_installation())
	{
		echo 'It seems you don\'t currently have a version of ProAuctionScript installed we recommend you do a <b><a href="install.php">fresh install</a></b>';
		exit;
	}
	$settings = settings_array();
	echo '
	<div class="well span12">
		<div class="alert alert-success"><h4>Installation Complete!</h4>Your Pro-Auction-Script script is now running version ' . installed_version() . '</div>
		<p><b>What do I do now?</b></p>
		<ul>
			<li>If you would like to use the builtin upgrade Pro-Auction-Script script feature from the AdminCP please visit the <a href="https://www.pro-auction-script.com/my_account" target="_blank">Pro-Auction-Script website -> Login -> Edit Account</a> page and generate a API Key and then go to your AdminCP -> Tools -> Upgrade Pro-Auction-Script Script page and enter your API key.</li>
			<li><a href="http://' . $settings['siteurl'] . $settings['admin_folder'] . '/login.php" style="font-weight:bold;">Click Here</a> to login to the admin area</li>
			<li>Maybe check out our <a href="http://Pro-Auction-Script.com" target="_blank">support forum</a></li>
		</ul>
	</div>';
	deleteInstallFolder(MAIN_PATH . 'install');
}
?>