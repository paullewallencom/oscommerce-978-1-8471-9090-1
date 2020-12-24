<?php
/*
  $Id: information_english_only.php,v 1.00 2006/06/12 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- information_english_only //-->
          <tr>
            <td>
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => 'Special news');

  new infoBoxHeading($info_box_contents, false, false);

  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'center',
  														 'text' => 'Free phone support<br>call XXXXXXXXXX');

  new infoBox($info_box_contents);
?>
            </td>
          </tr>
<!-- information_english_only_eof //-->
