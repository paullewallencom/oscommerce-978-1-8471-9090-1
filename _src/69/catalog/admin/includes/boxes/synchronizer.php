<?php
/*
  $Id: synchronizer.php,v 1.00 2006/07/20 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- synchronizer //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => 'Synchronizer',
                     'link'  => tep_href_link('synchronize_supplier_prices.php', 'selected_box=synchronizer'));

  if ($selected_box == 'synchronizer') {
    $contents[] = array('text'  => '');
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- synchronizer_eof //-->
