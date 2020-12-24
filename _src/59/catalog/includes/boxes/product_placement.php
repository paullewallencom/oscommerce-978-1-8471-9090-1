<?php
/*
  $Id: product_placement.php,v 1.00 2006/07/14 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

	$banner_group = '120x120';
  if ($banner = tep_banner_exists('dynamic', $banner_group)) {
?>
<!--product_placement //-->
          <tr>
            <td><?php echo tep_display_banner('static', $banner, true);?></td>
          </tr>
<!-- product_placement _eof //-->
<?php
  }
?>
