<?php
/*
  $Id: flexible.php,v 1.00 2006/07/08 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class flexible {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function flexible() {
      global $order;

      $this->code = 'flexible';
      $this->title = MODULE_SHIPPING_FLEXIBLE_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_FLEXIBLE_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_FLEXIBLE_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_FLEXIBLE_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_FLEXIBLE_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_FLEXIBLE_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_FLEXIBLE_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
      global $order, $cart;

      $order_total = $cart->show_total();

      $table_cost = split("[:,]" , MODULE_SHIPPING_FLEXIBLE_COST);
      $size = sizeof($table_cost);
      for ($i=0, $n=$size; $i<$n; $i+=2) {
				if ($order_total <= $table_cost[$i]) {

					if ((strpos($table_cost[$i+1],'%')) && (strpos($table_cost[$i+1],'+'))) {
						$shipping = before('+',$table_cost[$i+1]) + $order_total * (after('+',$table_cost[$i+1])/100);
					} elseif (strpos($table_cost[$i+1],'%')) {
						$shipping = $order_total * ($table_cost[$i+1]/100);
					} else {
						$shipping = $table_cost[$i+1];
					}

					break;
				}
      }

      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_FLEXIBLE_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_FLEXIBLE_TEXT_WAY,
                                                     'cost' => $shipping + MODULE_SHIPPING_FLEXIBLE_HANDLING)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FLEXIBLE_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Table Method', 'MODULE_SHIPPING_FLEXIBLE_STATUS', 'True', 'Do you want to offer flexible rate shipping?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Shipping Table', 'MODULE_SHIPPING_FLEXIBLE_COST', '25:8.50,50:5.50,10000:0.00', 'The shipping cost is based on the total cost or weight of items. Example: 25:8.50,50:5.50,etc.. Up to 25 charge 8.50, from there to 50 charge 5.50, etc', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Handling Fee', 'MODULE_SHIPPING_FLEXIBLE_HANDLING', '0', 'Handling fee for this shipping method.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Tax Class', 'MODULE_SHIPPING_FLEXIBLE_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Shipping Zone', 'MODULE_SHIPPING_FLEXIBLE_ZONE', '0', 'If a zone is selected, only enable this shipping method for that zone.', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_FLEXIBLE_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_FLEXIBLE_STATUS', 'MODULE_SHIPPING_FLEXIBLE_COST', 'MODULE_SHIPPING_FLEXIBLE_HANDLING', 'MODULE_SHIPPING_FLEXIBLE_TAX_CLASS', 'MODULE_SHIPPING_FLEXIBLE_ZONE', 'MODULE_SHIPPING_FLEXIBLE_SORT_ORDER');
    }
  }
?>
