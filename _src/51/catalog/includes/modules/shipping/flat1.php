<?php
/*
  $Id: flat.php,v 1.40 2003/02/05 22:41:52 hpdl Exp $
  cloned as
  $Id: flat1.php,v 1.00 2006/07/08 00:00:00 mm Exp $

  Modified by Monika Math�
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Math�
  
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class flat1 {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function flat1() {
      global $order;

      $this->code = 'flat1';
      $this->title = MODULE_SHIPPING_FLAT1_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_FLAT1_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_FLAT1_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_FLAT1_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_FLAT1_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_FLAT1_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_FLAT1_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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

			if (is_object($order)) {
			// hide this module if cart total > 0
				if ($this->enabled == true) {
					global $cart;
					if ($cart->show_total() > 0.00) {
						$this->enabled = false;
					}
				}
			}
    }

// class methods
    function quote($method = '') {
      global $order;

      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_FLAT1_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_FLAT1_TEXT_WAY,
                                                     'cost' => MODULE_SHIPPING_FLAT1_COST)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FLAT1_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
    	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable FREE shipping for FREE items', 'MODULE_SHIPPING_FLAT1_STATUS', 'True', 'Do you want to offer FREE shipping for FREE items?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Shipping Cost', 'MODULE_SHIPPING_FLAT1_COST', '5.00', 'The shipping cost for all orders using this shipping method.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Tax Class', 'MODULE_SHIPPING_FLAT1_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Shipping Zone', 'MODULE_SHIPPING_FLAT1_ZONE', '0', 'If a zone is selected, only enable this shipping method for that zone.', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_FLAT1_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_FLAT1_STATUS', 'MODULE_SHIPPING_FLAT1_COST', 'MODULE_SHIPPING_FLAT1_TAX_CLASS', 'MODULE_SHIPPING_FLAT1_ZONE', 'MODULE_SHIPPING_FLAT1_SORT_ORDER');
    }
  }
?>
