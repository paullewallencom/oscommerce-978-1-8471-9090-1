<?php
/*
  $Id: configuration.php,v 1.17 2003/07/09 01:18:53 hpdl Exp $

  Modified by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- configuration //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_CONFIGURATION,
                     'link'  => tep_href_link(FILENAME_CONFIGURATION, 'gID=1&selected_box=configuration'));

  if ($selected_box == 'configuration') {
//catalog area
    $cfg_groups = '';
    $sort = 'sort_order';//alternative: $sort = 'cgTitle';
    $configuration_groups_query = tep_db_query("select configuration_group_id as cgID, configuration_group_title as cgTitle from " . TABLE_CONFIGURATION_GROUP . " where visible = '1' and configuration_group_id < 10 order by " . $sort);
    while ($configuration_groups = tep_db_fetch_array($configuration_groups_query)) {
	  	$class = 'menuBoxContentLink';
    	if ($HTTP_GET_VARS['gID'] == $configuration_groups['cgID']) $class = 'menuBoxHighlight';
      $cfg_groups .= '<a href="' . tep_href_link(FILENAME_CONFIGURATION, 'gID=' . $configuration_groups['cgID'], 'NONSSL') . '" class="' . $class . '">' . $configuration_groups['cgTitle'] . '</a><br>';
    }
    $contents[] = array('text'  => $cfg_groups);
    $contents[] = array('text'  => tep_draw_separator());

//administrating site
    $cfg_groups = '';
    $sort = 'cgTitle';//alternative: $sort = 'sort_order';
    $configuration_groups_query = tep_db_query("select configuration_group_id as cgID, configuration_group_title as cgTitle from " . TABLE_CONFIGURATION_GROUP . " where visible = '1' and configuration_group_id >= 10 and configuration_group_id < 16 order by " . $sort);
    while ($configuration_groups = tep_db_fetch_array($configuration_groups_query)) {
	  	$class = 'menuBoxContentLink';
    	if ($HTTP_GET_VARS['gID'] == $configuration_groups['cgID']) $class = 'menuBoxHighlight';
      $cfg_groups .= '<a href="' . tep_href_link(FILENAME_CONFIGURATION, 'gID=' . $configuration_groups['cgID'], 'NONSSL') . '" class="' . $class . '">' . $configuration_groups['cgTitle'] . '</a><br>';
    }
    $contents[] = array('text'  => $cfg_groups);
    $contents[] = array('text'  => tep_draw_separator());

//new contributions
    $cfg_groups = '';
    $sort = 'cgTitle';//alternative: $sort = 'sort_order';
    $configuration_groups_query = tep_db_query("select configuration_group_id as cgID, configuration_group_title as cgTitle from " . TABLE_CONFIGURATION_GROUP . " where visible = '1' and configuration_group_id > 15 order by " . $sort);
    while ($configuration_groups = tep_db_fetch_array($configuration_groups_query)) {
	  	$class = 'menuBoxContentLink';
    	if ($HTTP_GET_VARS['gID'] == $configuration_groups['cgID']) $class = 'menuBoxHighlight';
      $cfg_groups .= '<a href="' . tep_href_link(FILENAME_CONFIGURATION, 'gID=' . $configuration_groups['cgID'], 'NONSSL') . '" class="' . $class . '">' . $configuration_groups['cgTitle'] . '</a><br>';
    }
    if ($cfg_groups == '') $cfg_groups = 'reserved for contributions';
    $contents[] = array('text'  => $cfg_groups);
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- configuration_eof //-->
