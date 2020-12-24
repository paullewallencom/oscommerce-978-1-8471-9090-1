<?php
/*
  $Id: order_total.php,v 1.4 2003/02/11 00:04:53 hpdl Exp $

  Modified by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class order_total {
    var $modules;

// class constructor
    function order_total() {
      global $language;

      if (defined('MODULE_ORDER_TOTAL_INSTALLED') && tep_not_null(MODULE_ORDER_TOTAL_INSTALLED)) {
        $this->modules = explode(';', MODULE_ORDER_TOTAL_INSTALLED);

        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          include(DIR_WS_LANGUAGES . $language . '/modules/order_total/' . $value);
          include(DIR_WS_MODULES . 'order_total/' . $value);

          $class = substr($value, 0, strrpos($value, '.'));
          $GLOBALS[$class] = new $class;
        }
      }
    }

    function donation_selection() {
      global $customer_id, $currencies, $language, $donation, $messageStack;
      $selection_string = '';

//the header of the box
				$selection_string .= '<tr>' . "\n";
				$selection_string .= '<td><table border="0" width="100%" cellspacing="0" cellpadding="2">' . "\n";
				$selection_string .= '<tr>' . "\n";
				$selection_string .= '<td class="main"><b>' . TEXT_ENTER_DONATION_HEADER . '</b></td>' . "\n";
				$selection_string .= '</tr>' . "\n";
				$selection_string .= '</table></td>' . "\n";
				$selection_string .= '</tr>' . "\n";
				$selection_string .= '<tr>' . "\n";
				$selection_string .= '<td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">' . "\n";
				$selection_string .= '<tr class="infoBoxContents">' . "\n";
				$selection_string .= '<td><table border="0" width="100%" cellspacing="0" cellpadding="2">' . "\n";

//the infotext in the box
				$selection_string .= '<tr>' . "\n";
				$selection_string .= '<td colspan="2" width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="2">' . "\n";
				$selection_string .= '<tr>' . "\n";
				$selection_string .= '<td width="10">' . tep_draw_separator('pixel_trans.gif', '10', '1') . '</td>' . "\n";
				$selection_string .= '<td class="main" align="left">' . tep_image(DIR_WS_ICONS . 'donation.gif', STORE_NAME) . '</td>' . "\n";
				$selection_string .= '<td class="main" align="right">'. "\n";
				$selection_string .= TEXT_ENTER_DONATION_INFO . "\n";
				$selection_string .= '<p>$ ' . tep_draw_input_field('dollar', '', 'size="5" maxlength="10"') . ' . ' .  tep_draw_input_field('cent', '', 'size="2" maxlength="2"')  . "\n";
				
				$selection_string .= '</td>' . "\n";
				$selection_string .= '<td width="10">' . tep_draw_separator('pixel_trans.gif', '10', '1') . '</td>' . "\n";
				$selection_string .= '</tr>' . "\n";
				$selection_string .= '</table></td>' . "\n";
				$selection_string .= '</tr>' . "\n";

//the footer of the box
				$selection_string .= '</table></td>' . "\n";
				$selection_string .= '</tr>' . "\n";
				$selection_string .= '</table></td>' . "\n";
				$selection_string .= '</tr>' . "\n";
    return $selection_string;
    }


    function process() {
      $order_total_array = array();
      if (is_array($this->modules)) {
        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          if ($GLOBALS[$class]->enabled) {
            $GLOBALS[$class]->process();

            for ($i=0, $n=sizeof($GLOBALS[$class]->output); $i<$n; $i++) {
              if (tep_not_null($GLOBALS[$class]->output[$i]['title']) && tep_not_null($GLOBALS[$class]->output[$i]['text'])) {
                $order_total_array[] = array('code' => $GLOBALS[$class]->code,
                                             'title' => $GLOBALS[$class]->output[$i]['title'],
                                             'text' => $GLOBALS[$class]->output[$i]['text'],
                                             'value' => $GLOBALS[$class]->output[$i]['value'],
                                             'sort_order' => $GLOBALS[$class]->sort_order);
              }
            }
          }
        }
      }

      return $order_total_array;
    }

    function output() {
      $output_string = '';
      if (is_array($this->modules)) {
        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          if ($GLOBALS[$class]->enabled) {
            $size = sizeof($GLOBALS[$class]->output);
            for ($i=0; $i<$size; $i++) {
              $output_string .= '              <tr>' . "\n" .
                                '                <td align="right" class="main">' . $GLOBALS[$class]->output[$i]['title'] . '</td>' . "\n" .
                                '                <td align="right" class="main">' . $GLOBALS[$class]->output[$i]['text'] . '</td>' . "\n" .
                                '              </tr>';
            }
          }
        }
      }

      return $output_string;
    }
  }
?>
