<?php
/*
  $Id: ot_giftwrapping.php,v 1.00 2006/07/04 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class ot_giftwrapping {
    var $title, $output;

    function ot_giftwrapping() {
      $this->code = 'ot_giftwrapping';
      $this->title = MODULE_ORDER_TOTAL_GIFTWRAPPING_TITLE;
      $this->description = MODULE_ORDER_TOTAL_GIFTWRAPPING_DESCRIPTION;
      $this->enabled = ((MODULE_ORDER_TOTAL_GIFTWRAPPING_STATUS == 'true') ? true : false);
      $this->tax_class = MODULE_ORDER_TOTAL_GIFTWRAPPING_TAX_CLASS;
      $this->sort_order = MODULE_ORDER_TOTAL_GIFTWRAPPING_SORT_ORDER;

      $this->output = array();

      if ($this->enabled == true) {
        global $giftwrapping_method;
        if ($giftwrapping_method == '') {
          $this->enabled = false;
        }
      }
    }

    function process() {
      global $order, $currencies;

      $giftwrapping_cost = tep_get_giftwrapping_cost();

      if (tep_not_null($order->info['giftwrapping_method'])) {

        $order->info['total'] += $giftwrapping_cost;

        if ($this->tax_class > 0) {
          $giftwrapping_tax_description = tep_get_tax_description($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
					$giftwrapping_tax = tep_get_tax_rate(MODULE_ORDER_TOTAL_GIFTWRAPPING_TAX_CLASS, $order->delivery['country']['id'], $order->delivery['zone_id']);

          $order->info['tax'] += tep_calculate_tax($giftwrapping_cost, $giftwrapping_tax);
          $order->info['tax_groups']["$giftwrapping_tax_description"] += tep_calculate_tax($giftwrapping_cost, $giftwrapping_tax);
          $order->info['total'] += tep_calculate_tax($giftwrapping_cost, $giftwrapping_tax);
        }

      }
			$this->output[] = array('title' => $order->info['giftwrapping_method'] . ':',
															'text' => $currencies->format($giftwrapping_cost, true, $order->info['currency'], $order->info['currency_value']),
															'value' => $giftwrapping_cost);
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_GIFTWRAPPING_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }

      return $this->_check;
    }

    function keys() {
      return array('MODULE_ORDER_TOTAL_GIFTWRAPPING_STATUS', 'MODULE_ORDER_TOTAL_GIFTWRAPPING_SORT_ORDER', 'MODULE_ORDER_TOTAL_GIFTWRAPPING_COST', 'MODULE_ORDER_TOTAL_GIFTWRAPPING_TAX_CLASS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display Giftwrapping', 'MODULE_ORDER_TOTAL_GIFTWRAPPING_STATUS', 'true', 'Do you want to display the order giftwrapping cost?', '6', '1','tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ORDER_TOTAL_GIFTWRAPPING_SORT_ORDER', '2', 'Sort order of display.', '6', '2', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, date_added) values ('Giftwrapping surcharge', 'MODULE_ORDER_TOTAL_GIFTWRAPPING_COST', '5', 'Surcharge for giftwrapping.', '6', '4', 'currencies->format', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Tax Class', 'MODULE_ORDER_TOTAL_GIFTWRAPPING_TAX_CLASS', '0', 'Use the following tax class on the giftwrapping fee.', '6', '5', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }
?>
