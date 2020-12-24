<?php
/*
  $Id: giftwrapping.php,v 1.00 2006/07/04 00:00:00 mm Exp $

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
		<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
			<tr>
				<td class="main"><b><?php echo TABLE_HEADING_GIFTWRAPPING; ?></b></td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
			<tr class="infoBoxContents">
				<td><table border="0" width="100%" cellspacing="1" cellpadding="2">
					<tr>
						<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
							<tr>
								<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
								<td width="20" valign="top"><?php echo tep_draw_checkbox_field('giftwrap','1', ($giftwrap == '1' ? true : false)); ?></td>
								<td class="main">
									<?php echo sprintf(TEXT_WANT_GIFTWRAP,$currencies->format(tep_get_giftwrapping_cost())); ?>
								</td>              
							</tr>
						</table></td>
					</tr>
					<tr>
						<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
							<tr>
								<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
								<td class="main" width="50%" valign="top"><b><?php echo TEXT_CHOOSE_GIFTCARD_METHOD; ?></b></td>
								<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
							</tr>
						</table></td>
					</tr>
					<tr>
						<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
							<tr>
<?php
			$paperchoice = split("[,]" , MODULE_GIFTWRAPPING_PAPER);
			$size = sizeof($paperchoice);
			$rows = 0;
			for ($i=0, $n=$size; $i<$n; $i++) {
				$rows++;
				echo '<td>' . tep_draw_separator('pixel_trans.gif', '10', '1') . '</td><td width="20" valign="top">' . tep_draw_radio_field('giftwrapping_method',$paperchoice[$i] , $i==0? true : false) . '</td><td valign="top" class="main">' . $paperchoice[$i] . '</td>' . "\n";
				if ((($rows / 2) == floor($rows / 2)) && ($rows != $n)) {
					echo '</tr>' . "\n";
					echo '<tr>' . "\n";
				}
			}
?>
						</table></td>
					</tr>
					<tr>
						<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
							<tr>
								<td class="main"><?php echo TEXT_CARD_GIFTWRAPPING; ?></td>
							</tr>
							<tr>
								<td><?php echo tep_draw_textarea_field('giftcard', 'soft', '', '', '','style="width:100%; height:70px;"'); ?></td>
							</tr>
						</table></td>
					</tr>
				</table></td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
	</tr>

