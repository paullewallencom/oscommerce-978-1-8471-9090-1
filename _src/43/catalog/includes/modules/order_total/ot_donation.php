<?php
/*
  $Id: ot_donation.php,v 1.00 2006/07/05 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class ot_donation {
    var $title, $output;

    function ot_donation() {
      $this->code = 'ot_donation';
      $this->title = MODULE_ORDER_TOTAL_DONATION_TITLE;
      $this->description = MODULE_ORDER_TOTAL_DONATION_DESCRIPTION;
      $this->enabled = ((MODULE_ORDER_TOTAL_DONATION_STATUS == 'true') ? true : false);
      $this->sort_order = MODULE_ORDER_TOTAL_DONATION_SORT_ORDER;

      $this->output = array();

      if ($this->enabled == true) {
        global $donation;
        if ($donation == '') {
          $this->enabled = false;
        }
      }
    }


    function process() {
      global $order, $currencies, $donation;
      
      $order->info['total'] += $donation;

	    $this->output[] = array('title' => $this->title . ':',
                              'text' => $currencies->format($donation, true, $order->info['currency'], $order->info['currency_value']),
                              'value' => $donation);
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_DONATION_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }

      return $this->_check;
    }

    function keys() {
      return array('MODULE_ORDER_TOTAL_DONATION_STATUS', 'MODULE_ORDER_TOTAL_DONATION_SORT_ORDER');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display Donation', 'MODULE_ORDER_TOTAL_DONATION_STATUS', 'true', 'Do you want to display the donation amount?', '6', '1','tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ORDER_TOTAL_DONATION_SORT_ORDER', '40', 'Sort order of display.', '6', '2', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }
?>
