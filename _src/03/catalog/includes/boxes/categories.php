<?php
/*
 $Id: categories.php,v 1.25 2003/07/09 01:13:58 hpdl Exp $

	Modified by Monika Mathé
	http://www.monikamathe.com

	Module Copyright (c) 2006 Monika Mathé

 osCommerce, Open Source E-Commerce Solutions
 http://www.oscommerce.com

 Copyright (c) 2003 osCommerce

 Released under the GNU General Public License
*/

 function tep_show_category($counter) {
   global $tree, $categories_string, $cPath_array;

   if ($tree[$counter]['parent'] == 0) {
     $cPath_new = 'cPath=' . $counter;
   } else {
     $cPath_new = 'cPath=' . $tree[$counter]['path'];
   }

   for ($i=0; $i<$tree[$counter]['level']; $i++) {
     $categories_string .= '<a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">';
   }

   if (isset($cPath_array) && in_array($counter, $cPath_array)) {
   	 for ($i=0; $i<$tree[$counter]['level']; $i++) {
       $categories_string .= '<b>';
     }
   }

// display category name
   $categories_string .= $tree[$counter]['name'];

   if (isset($cPath_array) && in_array($counter, $cPath_array)) {
     for ($i=0; $i<$tree[$counter]['level']; $i++) {
       $categories_string .= '</b>';
     }
   }

   if (!$tree[$counter]['parent'] == 0) {
    $categories_string .= '</a><br>';
   }

   if ($tree[$counter]['next_id'] != false) {
     tep_show_category($tree[$counter]['next_id']);
   }
 }
?>
<!-- categories //-->
         <tr>
           <td>
<?php
 $info_box_contents = array();
 $info_box_contents[] = array('text' => BOX_HEADING_CATEGORIES);

 if (isset($cPath) && tep_not_null($cPath) && tep_has_category_subcategories($cPath)) {
	 new infoBoxHeading($info_box_contents, true, false);

	 $categories_string = '';
	 $tree = array();

	 $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and c.categories_id = '" . $cPath . "' and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
	 while ($categories = tep_db_fetch_array($categories_query))  {

		 if (isset($parent_id)) {
			 $tree[$parent_id]['next_id'] = $categories['categories_id'];
		 }

		 $parent_id = $categories['categories_id'];

		 if (!isset($first_element)) {
			 $first_element = $categories['categories_id'];
		 }
	 }

	 //------------------------
	 if (tep_not_null($cPath)) {
		 $new_path = '';
		 reset($cPath_array);
		 while (list($key, $value) = each($cPath_array)) {
			 unset($parent_id);
			 unset($first_id);
			 $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$value . "' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
			 if (tep_db_num_rows($categories_query)) {
				 $new_path .= $value;
				 while ($row = tep_db_fetch_array($categories_query)) {
					 $tree[$row['categories_id']] = array('name' => $row['categories_name'],
																								'parent' => $row['parent_id'],
																								'level' => $key+1,
																								'path' => $new_path . '_' . $row['categories_id'],
																								'next_id' => false);

					 if (isset($parent_id)) {
						 $tree[$parent_id]['next_id'] = $row['categories_id'];
					 }

					 $parent_id = $row['categories_id'];

					 if (!isset($first_id)) {
						 $first_id = $row['categories_id'];
					 }

					 $last_id = $row['categories_id'];
				 }
				 $tree[$last_id]['next_id'] = $tree[$value]['next_id'];
				 $tree[$value]['next_id'] = $first_id;
				 $new_path .= '_';
			 } else {
				 break;
			 }
		 }
	 }
	 tep_show_category($first_element); 

	 $info_box_contents = array();
	 $info_box_contents[] = array('text' => $categories_string);

	 new infoBox($info_box_contents);
 }
?>
           </td>
         </tr>
<!-- categories_eof //-->
