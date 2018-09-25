<?php
/*******************************************************************************
 *   copyright				: (C) 2014 - 2018 Pro-Auction-Script
 *   site					: https://www.pro-auction-script.com
 *   Script License			: https://www.pro-auction-script.com/contents.php?show=free_license
 *******************************************************************************/
define('InAdmin', 1);
include 'adminCommon.php';
$current_page = 'settings';

unset($ERROR);
$html = '';

// Create currencies array
$query = "SELECT id, valuta, symbol, ime FROM " . $DBPrefix . "rates ORDER BY 'ime'";
$db->direct_query($query);
if ($db->numrows() > 0)
{
	while ($row = $db->result())
	{
		$CURRENCIES[$row['id']] = $row['symbol'] . '&nbsp;' . $row['ime'] . '&nbsp;(' . $row['valuta'] . ')';
		$CURRENCIES_SYMBOLS[$row['id']] = $row['symbol'];
	}
}

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Data check
	if (empty($_POST['currency']))
	{
		$ERROR = $ERR['047'];
	}
	elseif (!empty($_POST['moneydecimals']) && !is_numeric($_POST['moneydecimals']))
	{
		$ERROR = $ERR['051'];
	}
	else
	{
		// Update database
		$system->writesetting("settings", "currency", $system->cleanvars($CURRENCIES_SYMBOLS[$_POST['currency']]), 'str');
		$system->writesetting("settings", "moneyformat", $_POST['moneyformat'], 'bool_int');
		$system->writesetting("settings", "moneydecimals", $_POST['moneydecimals'], 'bool_int');
		$system->writesetting("settings", "moneysymbol", $_POST['moneysymbol'], 'bool_int');

		$system->SETTINGS['currency'] = $CURRENCIES_SYMBOLS[$_POST['currency']];
		$ERROR = $MSG['553'];
	}
	//Adding new currency if the POST are set
	if (!empty($_POST['country']) && !empty($_POST['currency_type']) && !empty($_POST['currency_abbreviation']))
	{
		$query = "INSERT INTO " . $DBPrefix . "rates VALUES (NULL, :ime, :valuta, :symbol);";
		$params = array();
		$params[] = array(':ime', $_POST['country'], 'str');
		$params[] = array(':valuta', $_POST['currency_type'], 'str');
		$params[] = array(':symbol', $_POST['currency_abbreviation'], 'str');
		$db->query($query, $params);
		$ERROR = $MSG['3500_1015804'];
		unset($_POST['country']); unset($_POST['currency_type']); unset($_POST['currency_abbreviation']);
	}
}

$link = "javascript:window_open('" . $system->SETTINGS['siteurl'] . "converter.php','incre',650,250,30,30)";

foreach ($CURRENCIES_SYMBOLS as $k => $v)
{
	if ($v == $system->SETTINGS['currency'])
		$selectsetting = $k;
}
loadblock($MSG['5008'], '', generateSelect('currency', $CURRENCIES, $selectsetting));
loadblock('', $MSG['5138'], 'link', 'currenciesconverter', '', array($MSG['5010']));
loadblock($MSG['544'], '', 'batchstacked', 'moneyformat', $system->SETTINGS['moneyformat'], array($MSG['545'], $MSG['546']));
loadblock($MSG['548'], $MSG['547'], 'decimals', 'moneydecimals', $system->SETTINGS['moneydecimals']);
loadblock($MSG['549'], '', 'batchstacked', 'moneysymbol', $system->SETTINGS['moneysymbol'], array($MSG['550'], $MSG['551']));

loadblock($MSG['3500_1015798'], '', '', '', '', array(), true);
loadblock($MSG['014'], $MSG['3500_1015801'], 'text', 'country', (isset($_POST['country'])) ? $_POST['country'] : '');
loadblock($MSG['3500_1015799'], $MSG['3500_1015802'], 'text', 'currency_type', (isset($_POST['currency_type'])) ? $_POST['currency_type'] : '');
loadblock($MSG['3500_1015800'], $MSG['3500_1015803'], 'text', 'currency_abbreviation', (isset($_POST['currency_abbreviation'])) ? $_POST['currency_abbreviation'] : '');

$template->assign_vars(array(
	'ERROR' => (isset($ERROR)) ? $ERROR : '',
	'SITEURL' => $system->SETTINGS['siteurl'],
	'LINKURL' => $link,
	'OPTIONHTML' => $html,
	'TYPENAME' => $MSG['25_0008'],
	'PAGENAME' => '<a style="color:lime" href="https://www.pro-auction-script.com/wiki/doku.php?id=Pro-Auction-Script_currencies_settings" target="_blank">' . $MSG['5004'] . '</a>',
	'PAGETITLE' => $MSG['5004']
));
include 'adminHeader.php';
$template->set_filenames(array(
		'body' => 'adminpages.tpl'
		));
$template->display('body');
include 'adminFooter.php';