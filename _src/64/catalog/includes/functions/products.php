<?php
/*
  $Id: products.php,v 1.00 2006/07/25 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

////
// Sets the status of a product
  function tep_set_products_expiry_status($products_id, $status) {
    return tep_db_query("update " . TABLE_PRODUCTS . " set products_status = '" . $status . "', products_date_status_change = now() where products_id = '" . (int)$products_id . "'");
  }

////
// Auto expire products
  function tep_expire_products() {
    $products_query = tep_db_query("select products_id from " . TABLE_PRODUCTS . " where products_status = '1' and now() >= products_expires_date and products_expires_date > 0");
    if (tep_db_num_rows($products_query)) {
      while ($products = tep_db_fetch_array($products_query)) {
        tep_set_products_expiry_status($products['products_id'], '0');
      }
    }
  }
?>
