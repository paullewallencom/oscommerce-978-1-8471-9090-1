<?php
/*
  $Id: donation.php,v 1.00 2006/07/05 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<tr>
  <td class="main"><b><?php echo TEXT_ENTER_DONATION_HEADER; ?></b></td>
</tr>
<tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
</tr>
<tr>
  <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
      <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td class="main"><?php echo tep_image(DIR_WS_ICONS . 'donation.gif', STORE_NAME); ?></td>
        <td class="main" align="right">
         <?php echo $currencies->format($donation); ?><br>
         <?php echo TEXT_ENTER_YOUR_DONATION; ?><br>
			   <?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?>
			  </td>
       </tr>
      </table></td>
    </tr>
  </table></td>
</tr>
<tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
</tr>
