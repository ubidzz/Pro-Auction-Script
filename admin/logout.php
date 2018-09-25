<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';

if (isset($_SESSION['csrftoken'])) unset($_SESSION['csrftoken']);
if (isset($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_NUMBER'])) unset($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_NUMBER']);
if (isset($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_PASS'])) unset($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_PASS']);
if (isset($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_IN'])) unset($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_IN']);
if (isset($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_USER'])) unset($_SESSION[$system->SETTINGS['sessionsname'] . '_ADMIN_USER']);

?>
<script type="text/javascript">
parent.location.href = 'login.php';
</script>