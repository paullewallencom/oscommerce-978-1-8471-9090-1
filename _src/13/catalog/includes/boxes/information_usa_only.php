<?php
/*
  $Id: information_usa_only.php,v 1.00 2006/06/12 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- information_usa_only //-->
          <tr>
            <td>
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => BOX_HEADING_USA);

  new infoBoxHeading($info_box_contents, false, false);

  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'center',
  														 'text' => '<a href="' . tep_href_link(FILENAME_SHIPPING) . '">' . sprintf(BOX_USA_SHIPPING_TEXT, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) . '</a>');

  new infoBox($info_box_contents);
?>
            </td>
          </tr>
<!-- information_usa_only_eof //-->
