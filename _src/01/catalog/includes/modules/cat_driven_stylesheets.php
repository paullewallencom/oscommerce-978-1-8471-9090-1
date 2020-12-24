<?php
/*
  $Id: cat_driven_stylesheets.php,v 1.00 2006/06/05 00:00:00 mm Exp $

  Module written by Monika Mathé
  http://www.monikamathe.com

  Module Copyright (c) 2006 Monika Mathé

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

    switch ($stylesheet_test) {
      case '1':
      $stylesheet_add = 'hardware';
      break;
      case '2':
      $stylesheet_add = 'software';
      break;
      case '3':
      $stylesheet_add = 'dvd';
      break;
    default:
      $stylesheet_add = '';
      break;
   }
?>
