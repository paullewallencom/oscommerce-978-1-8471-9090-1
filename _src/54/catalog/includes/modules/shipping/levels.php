<?php
/*
  $Id: levels.php,v 1.00 2006/07/09 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class levels {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function levels() {
      global $order;

      $this->code = 'levels';
      $this->title = MODULE_SHIPPING_LEVELS_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_LEVELS_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_LEVELS_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_LEVELS_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_LEVELS_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_LEVELS_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_LEVELS_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
        while ($check = tep_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }

// class methods
    function quote($method = '') {
      global $order, $total_count, $cart;

			$cost = 0;
	    $count_level1 = 0;
	    $count_level2 = 0;

			$level2_array = explode(',' , MODULE_SHIPPING_LEVELS_PRODUCTS);

			$products = $cart->get_products();
			for ($i=0, $n=sizeof($products); $i<$n; $i++) {
				if (in_array(tep_get_prid($products[$i]['id']), $level2_array)) {
					$count_level2 += $products[$i]['quantity'];
				}	else {
					$count_level1 += $products[$i]['quantity'];
				}
			}

			$cost_level1 = MODULE_SHIPPING_LEVELS_COST * $count_level1;
			$cost_level2 = MODULE_SHIPPING_LEVELS_COST2 * $count_level2;
			$cost = $cost_level1 + $cost_level2;

      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_LEVELS_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_LEVELS_TEXT_WAY,
                                                     'cost' => $cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_LEVELS_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Levels Shipping', 'MODULE_SHIPPING_LEVELS_STATUS', 'True', 'Do you want to offer per levels rate shipping?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Shipping Cost', 'MODULE_SHIPPING_LEVELS_COST', '2.50', 'The shipping cost will be multiplied by the number of items in an order that uses this shipping method.', '6', '0', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Product IDs Exception', 'MODULE_SHIPPING_LEVELS_PRODUCTS', '', 'Comma separated list of products to use the exception rate fee.', '6', '0', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Shipping Cost Exception Products', 'MODULE_SHIPPING_LEVELS_COST2', '10', 'The alternative shipping cost for products belonging into the exception group will be multiplied by the number of items in an order that uses this shipping method.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Handling Fee', 'MODULE_SHIPPING_LEVELS_HANDLING', '0', 'Handling fee for this shipping method.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Tax Class', 'MODULE_SHIPPING_LEVELS_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Shipping Zone', 'MODULE_SHIPPING_LEVELS_ZONE', '0', 'If a zone is selected, only enable this shipping method for that zone.', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_LEVELS_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_LEVELS_STATUS', 'MODULE_SHIPPING_LEVELS_COST', 'MODULE_SHIPPING_LEVELS_PRODUCTS', 'MODULE_SHIPPING_LEVELS_COST2', 'MODULE_SHIPPING_LEVELS_HANDLING', 'MODULE_SHIPPING_LEVELS_TAX_CLASS', 'MODULE_SHIPPING_LEVELS_ZONE', 'MODULE_SHIPPING_LEVELS_SORT_ORDER');
    }
  }
?>
