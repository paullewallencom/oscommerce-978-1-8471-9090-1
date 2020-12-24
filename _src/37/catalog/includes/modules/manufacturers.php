<?php
/*
  $Id: manufacturers.php,v 1.00 2006/06/24 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- manufacturers //-->
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => TEXT_BOX_ALL_MANUFACTURERS);

  new contentBoxHeading($info_box_contents);
  $manufacturers_query = tep_db_query("select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image from " . TABLE_MANUFACTURERS . " m where manufacturers_name <> '' order by manufacturers_name");

  $row = 0;
  $col = 0;
  $info_box_contents = array();
  while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {

    $info_box_contents[$row][$col] = array('align' => 'center',
                                           'params' => 'class="smallText" width="33%" valign="middle"',
                                           'text' => '<a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $manufacturers['manufacturers_id']) . '">' . tep_image(DIR_WS_IMAGES . $manufacturers['manufacturers_image'], $manufacturers['manufacturers_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .'</a>');

    $col ++;
    if ($col > 2) {
      $col = 0;
      $row ++;
    }
  }

  new contentBox($info_box_contents);
?>
<!-- manufacturers_eof //-->
