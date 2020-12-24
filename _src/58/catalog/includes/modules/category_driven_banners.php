<?php
/*
  $Id: category_driven_banners.php,v 1.00 2006/07/14 00:00:00 mm Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

 $banner_exists = false;
 $banner_code = $current_category_id;
 $groupname = '468x60_';
 $groupname_default = '468x50';

 if ($banner = tep_banner_exists('dynamic', $groupname . $banner_code)) {
  $banner_exists = true;  
 } else {
	 if (isset($HTTP_GET_VARS['products_id'])) {
	 	$cPath = tep_get_product_path($HTTP_GET_VARS['products_id']);
	 } elseif (isset($HTTP_GET_VARS['cPath'])) {
	 	$cPath = substr(tep_get_path($current_category_id), 6);
	 }
   $cat_array = array_reverse(explode('_', $cPath));
 	 $n = sizeof($cat_array);
   for ($i=0; $i<$n; $i++) {
		if ($banner = tep_banner_exists('dynamic', $groupname . $cat_array[$i])) {
		 $banner_exists = true;  
		 break;
		}
	 }
 } 

 if ($banner_exists == false) {
  if ($banner = tep_banner_exists('dynamic', $groupname_default)) {
   $banner_exists = true;  
  }
 }

 if ($banner_exists == true) {    
    echo '<td align="center" height="70">' . tep_display_banner('static', $banner) . '</td>';
 }
?>
