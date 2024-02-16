<?php

/*
* Plugin name: Books Management System
* Plugin URI: https://example.com/books-management-system
* Description: This is a plugin to Manage all Books.
* Author: Sanjay Kumar
* Author URI: https://example.com/author-bio
* Version: 1.0
* Requires PHP: 7.2
* Requires at least: 6.2
*/

// Constants
define("BMS_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("BMS_PLUGIN_URL", plugin_dir_url(__FILE__));
define("BMS_PLUGIN_BASENMAE", plugin_basename(__FILE__));

include_once BMS_PLUGIN_PATH . 'class/BooksManagment.php';

$booksManagementObject = new BooksManagement();

register_activation_hook(__FILE__, array($booksManagementObject, "bmsCreateTable"));

register_deactivation_hook(__FILE__, array($booksManagementObject, "bmsDropTable"));