<?php
/*
  $Id: pl_sorting.php,v 1.00 2006/06/24 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<?php
	$order_sql = '';

	if ( (!isset($HTTP_GET_VARS['sort'])) || (!ereg('[1-8][ad]', $HTTP_GET_VARS['sort'])) || (substr($HTTP_GET_VARS['sort'], 0, 1) > sizeof($column_list)) ) {
		for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
			if ($column_list[$i] == 'PRODUCT_LIST_NAME') {
				$HTTP_GET_VARS['sort'] = $i+1 . 'a';
				$order_sql .= " order by pd.products_name";
				break;
			}
		}
	} else {
		$sort_col = substr($HTTP_GET_VARS['sort'], 0 , 1);
		$sort_order = substr($HTTP_GET_VARS['sort'], 1);
		$order_sql .= ' order by ';
		switch ($column_list[$sort_col-1]) {
			case 'PRODUCT_LIST_MODEL':
				$order_sql .= "p.products_model " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
				break;
			case 'PRODUCT_LIST_NAME':
				$order_sql .= "pd.products_name " . ($sort_order == 'd' ? 'desc' : '');
				break;
			case 'PRODUCT_LIST_MANUFACTURER':
				$order_sql .= "m.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
				break;
			case 'PRODUCT_LIST_QUANTITY':
				$order_sql .= "p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
				break;
			case 'PRODUCT_LIST_IMAGE':
				$order_sql .= "pd.products_name";
				break;
			case 'PRODUCT_LIST_WEIGHT':
				$order_sql .= "p.products_weight " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
				break;
			case 'PRODUCT_LIST_PRICE':
				$order_sql .= "final_price " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
				break;
		}
	}
?>
