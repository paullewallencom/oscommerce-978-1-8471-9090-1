<?php
/*
  $Id: synchronize_supplier_prices.php

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

include("includes/application_top.php");

echo 'synchronising currency exchange rate' . '<p>';
echo '**********************************************************' . '<br>';
$server_used = CURRENCY_SERVER_PRIMARY;

$currency_query = tep_db_query("select currencies_id, code, title from " . TABLE_CURRENCIES);
while ($currency = tep_db_fetch_array($currency_query)) {
	$quote_function = 'quote_' . CURRENCY_SERVER_PRIMARY . '_currency';
	$rate = $quote_function($currency['code']);

	if (empty($rate) && (tep_not_null(CURRENCY_SERVER_BACKUP))) {

		$quote_function = 'quote_' . CURRENCY_SERVER_BACKUP . '_currency';
		$rate = $quote_function($currency['code']);

		$server_used = CURRENCY_SERVER_BACKUP;
	}

	if (tep_not_null($rate)) {
		tep_db_query("update " . TABLE_CURRENCIES . " set value = '" . $rate . "', last_updated = now() where currencies_id = '" . (int)$currency['currencies_id'] . "'");

		echo 'successfully synchronised currency exchange rate via ' . $server_used . ' (' . $currency['title'] . ', ' . $currency['code'] . ', ' . $rate . ')<br>';
	} else {
		echo 'failed synchronising currency exchange rate via ' . $server_used . ' (' . $currency['title'] . ', ' . $currency['code'] . ', ' . $rate . ')<br>';
	}
}
echo '**********************************************************' . '<p>';

if (tep_not_null($rate)) {

	echo 'the following products will be synchronised:' . '<br>';
	echo '====================================================' . '<br>';

	require(DIR_WS_CLASSES . 'currencies.php');
	$currencies = new currencies();

	$query_test = tep_db_query("SELECT products_id, products_model, products_price, products_second_currency from products where products_second_currency > 0");
	while ($query = tep_db_fetch_array($query_test)) {
		$new_price = round($query['products_second_currency'] / $currencies->currencies[SECOND_CURRENCY]['value'], 4);

		$new_price_sql = "update products set products_price = " . $new_price . " where products_id = '" . $query['products_id'] . "'";

		tep_db_query($new_price_sql);

		echo $new_price_sql;
	}

	echo '====================================================' . '<p>';
	echo '<p>successfully finished synchronising' . '<p>';
} else {
	echo '<p>synchronising not possible at this date' . '<p>';
}
?>
<a href="javascript:history.back();">Back</a>
