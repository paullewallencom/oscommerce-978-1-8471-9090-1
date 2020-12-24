<?php
/*
  $Id: photo_link.php,v 1.00 2006/06/11 01:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- photo_link //-->
          <tr>
            <td>
<?php
  $info_box_contents = array();

  $info_box_contents[] = array('align' => 'center',
                               'text' => '<a href="' . tep_href_link(FILENAME_CONTACT_US) . '">' . tep_image(DIR_WS_IMAGES . 'monika.jpg', 'Contact Monika Mathé', SMALL_IMAGE_WIDTH, '') . '</a>');

  new infoBox($info_box_contents);
?>
            </td>
          </tr>
<!-- photo_link_eof //-->
