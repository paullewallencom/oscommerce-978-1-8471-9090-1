<?php
/*
  $Id: languages.php,v 1.15 2003/06/09 22:10:48 hpdl Exp $

  Modified by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- languages //-->
          <tr>
            <td class="matting">
							<table class="tableborder" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td>
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => BOX_HEADING_LANGUAGES);

  new infoBoxHeading($info_box_contents, false, false);

  if (!isset($lng) || (isset($lng) && !is_object($lng))) {
    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language;
  }

  $languages_string = '';
  reset($lng->catalog_languages);
  while (list($key, $value) = each($lng->catalog_languages)) {
    $languages_string .= ' <a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('language', 'currency')) . 'language=' . $key, $request_type) . '">' . tep_image(DIR_WS_LANGUAGES .  $value['directory'] . '/images/' . $value['image'], $value['name']) . '</a> ';
  }

  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'center',
                               'text' => $languages_string);

  new infoBox($info_box_contents);
?>
            			</td>
            		</tr>
            	</table>
            </td>
          </tr>
					<tr><td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td></tr>
<!-- languages_eof //-->
