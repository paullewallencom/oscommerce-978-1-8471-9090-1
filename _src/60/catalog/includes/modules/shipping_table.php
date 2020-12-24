<?php
/*
  $Id: shipping_table.php,v 1.00 2006/07/20 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
if (MODULE_SHIPPING_TABLE_STATUS === 'True') {

	$prices = tep_db_query("SELECT * FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_SHIPPING_TABLE_COST'");
	$price = tep_db_fetch_array($prices);

	$price_text .= '<table border="0" cellspacing="0" cellpadding="10">';			 
	$price_text .= '<tr>';
	$parameters_price = split("[,]", $price['configuration_value']);
	$first_row ='';
	$second_row ='';
	$last_price=NULL;
	for($i=0; isset($parameters_price[$i]); $i++){
		$pair_prices = split("[:]",$parameters_price[$i]);

		if(!isset($pair_prices[0])){
			$price_text .= '<b>Error: </b>: ' . $price['configuration_value'];
			break;	
		}

		if(NULL == $last_price){
			$first=false;			
		}
		$first_row .= '<td class="infoboxHeading" align="center">' . TEXT_UP_TO . '<br>' . (MODULE_SHIPPING_TABLE_MODE == 'weight' ? $pair_prices[0] . 'lb' : $currencies->format($pair_prices[0])) .'</td>';

		$last_price = $pair_prices[0];
		if(!isset($pair_prices[1])){
			$price_text .= '<b>Error: no price:</b> ' . $price['configuration_value'];
			break;	
		}
		$second_row .= '<td class="infoboxContents" align="center" height="20">' .  $currencies->format($pair_prices[1] + MODULE_SHIPPING_TABLE_HANDLING) . '</td>';
	}
	$price_text .=  $first_row . "\n</tr>\n<tr>\n" . $second_row . "</tr>\n";	
	$price_text .= "</table>\n";

	// load the text defines
  include(DIR_WS_LANGUAGES . $language . '/modules/shipping/table.php');

	if ((int)MODULE_SHIPPING_TABLE_ZONE > 0) {
		$check_query = tep_db_query("select geo_zone_name from " . TABLE_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_TABLE_ZONE . "'");
		$check = tep_db_fetch_array($check_query);
		$table_zone = $check['geo_zone_name'];
	}
?>

	<tr>
		<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
	</tr>
	<tr>
		<td><table align="center" border="0" cellspacing="1" cellpadding="0" class="infoBox">
			<tr class="infoBoxContents">
				<td><table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td><?php echo $price_text; ?></td>
					</tr>
				</table></td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
			<tr>
				<td class="main" align="center"><?php echo MODULE_SHIPPING_TABLE_TEXT_TITLE . TEXT_SHIPPING_TABLE . '<br><b>' . $table_zone . '</b>'; ?></td>
			</tr>
		</table></td>
	</tr>
<?php
	}
?>
