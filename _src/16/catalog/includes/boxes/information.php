<?php
/*
  $Id: information.php,v 1.6 2003/02/10 22:31:00 hpdl Exp $

  Modified by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- information //-->
          <tr>
            <td class="matting">
							<table class="tableborder" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td>
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => BOX_HEADING_INFORMATION);

  new infoBoxHeading($info_box_contents, false, false);

  $info_box_contents = array();
  $info_box_contents[] = array('text' => '<a href="' . tep_href_link(FILENAME_SHIPPING) . '">' . BOX_INFORMATION_SHIPPING . '</a><br>' .
                                         '<a href="' . tep_href_link(FILENAME_PRIVACY) . '">' . BOX_INFORMATION_PRIVACY . '</a><br>' .
                                         '<a href="' . tep_href_link(FILENAME_CONDITIONS) . '">' . BOX_INFORMATION_CONDITIONS . '</a><br>' .
                                         '<a href="' . tep_href_link(FILENAME_CONTACT_US) . '">' . BOX_INFORMATION_CONTACT . '</a>');

  new infoBox($info_box_contents);
?>
            			</td>
            		</tr>
            	</table>
            </td>
          </tr>
					<tr><td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td></tr>
<!-- information_eof //-->
