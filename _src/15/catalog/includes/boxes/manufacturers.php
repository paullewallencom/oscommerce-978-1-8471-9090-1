<?php
/*
  $Id: manufacturers.php,v 1.00 2006/06/12 00:00:00 mm Exp $

  Modified by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name, manufacturers_image from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
  if ($number_of_rows = tep_db_num_rows($manufacturers_query)) {
?>
<!-- manufacturers //-->
          <tr>
            <td>
<?php
    $info_box_contents = array();
    $info_box_contents[] = array('text' => BOX_HEADING_MANUFACTURERS);

    new infoBoxHeading($info_box_contents, false, false);

		$manufacturers_list = '';
		while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {

			$manufacturers_list .= '<a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $manufacturers['manufacturers_id']) . '">' . tep_image(DIR_WS_IMAGES . $manufacturers['manufacturers_image'], $manufacturers['manufacturers_name'], SMALL_IMAGE_WIDTH) . '</a><br>';
		}

		$manufacturers_list = substr($manufacturers_list, 0, -4);

		$info_box_contents = array();
		$info_box_contents[] = array('align' => 'center',
																 'text' => $manufacturers_list);

    new infoBox($info_box_contents);
?>
            </td>
          </tr>
<!-- manufacturers_eof //-->
<?php
  }
?>
