<?php
/*
  $Id: also_purchased_products.php,v 1.21 2003/02/12 23:55:58 hpdl Exp $

  Modified by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  if (isset($HTTP_GET_VARS['products_id'])) {
		$orders_query_sql = "select p.products_id from " . TABLE_ORDERS_PRODUCTS . " opa, " . TABLE_ORDERS_PRODUCTS . " opb, " . TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p where opa.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and opa.orders_id = opb.orders_id and opb.products_id != '" . (int)$HTTP_GET_VARS['products_id'] . "' and opb.products_id = p.products_id and opb.orders_id = o.orders_id and p.products_image <> '' and p.products_status = '1' group by p.products_id order by o.date_purchased desc limit " . MAX_DISPLAY_ALSO_PURCHASED;		$orders_query = tep_db_query($orders_query_sql);
		$num_products_ordered = tep_db_num_rows($orders_query);

		//adding 0 to have at least one value for implode
		$prod_array[] = '0';
		while ($orders = tep_db_fetch_array($orders_query)) {
		 $prod_array[] = $orders['products_id'];
		}

		if ((sizeof($prod_array) - 1) < MAX_DISPLAY_ALSO_PURCHASED) {
		 $add_query_sql = "select p.products_id from " . TABLE_PRODUCTS . " p where p.products_status = '1' and p.products_id not in ('" . implode("', '", $prod_array) . "') and p.products_image <> '' order by rand() limit " . (MAX_DISPLAY_ALSO_PURCHASED - sizeof($prod_array) + 1);
		 $add_query = tep_db_query($add_query_sql);
		 while ($add = tep_db_fetch_array($add_query)) {
			$prod_array[] = $add['products_id'];
		 }
		}
		$orders_query = tep_db_query("select pd.products_name, p.products_image, p.products_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from  " . TABLE_PRODUCTS . " p left join  " . TABLE_SPECIALS . " s on p.products_id = s.products_id,  " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id in ('" . implode("', '", $prod_array) . "') limit " . MAX_DISPLAY_ALSO_PURCHASED);    
		$num_products_ordered = tep_db_num_rows($orders_query);
    if ($num_products_ordered >= MIN_DISPLAY_ALSO_PURCHASED) {
?>
<!-- also_purchased_products //-->
<?php
      $info_box_contents = array();
      $info_box_contents[] = array('text' => TEXT_ALSO_PURCHASED_PRODUCTS);

      new contentBoxHeading($info_box_contents);

      $row = 0;
      $col = 0;
      $info_box_contents = array();
      while ($orders = tep_db_fetch_array($orders_query)) {
        $orders['products_name'] = tep_get_products_name($orders['products_id']);
        $info_box_contents[$row][$col] = array('align' => 'center',
                                               'params' => 'class="smallText" width="33%" valign="top"',
                                               'text' => '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $orders['products_image'], $orders['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders['products_id']) . '">' . $orders['products_name'] . '</a>');

        $col ++;
        if ($col > 2) {
          $col = 0;
          $row ++;
        }
      }

      new contentBox($info_box_contents);
?>
<!-- also_purchased_products_eof //-->
<?php
  }
?>

