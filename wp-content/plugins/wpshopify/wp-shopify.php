<?php

/*

Plugin Name:         WP Shopify
Plugin URI:          https://wpshop.io
Description:         Sell and build custom Shopify experiences on WordPress.
Version:             2.0.14
Author:              WP Shopify
Author URI:          https://wpshop.io
License:             GPL-2.0+
License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain:         wpshopify
Domain Path:         /languages
Requires at least:   4.7
Requires PHP:        5.6

*/

global $wp_version;

if ( !function_exists('version_compare') || version_compare(PHP_VERSION, '5.6.0', '<' )) {
	wp_die( __("Sorry, WP Shopify requires PHP version 5.6 or higher. Please look through <a href=\"https://docs.wpshop.io/#/getting-started/requirements\" target=\"_blank\">our requirements</a> page to learn more. Often times you can simply ask your webhost to upgrade for you. <br><br><a href=" . admin_url('plugins.php') . " class=\"button button-primary\">Back to plugins</a>.", 'wpshopify') );
}

if ( version_compare($wp_version, '4.7', '<' )) {
	wp_die( __("Sorry, WP Shopify requires WordPress version 4.7 or higher. Please look through <a href=\"https://docs.wpshop.io/#/getting-started/requirements\" target=\"_blank\">our requirements</a> page to learn more. Often times you can simply ask your webhost to upgrade for you. <br><br><a href=" . admin_url('plugins.php') . " class=\"button button-primary\">Back to plugins</a>.", 'wpshopify') );
}

// If this file is called directly, abort.
defined('WPINC') ?: die;

// If this file is called directly, abort.
defined('ABSPATH') ?: die;


/*

Autoload everything

*/
require_once plugin_dir_path(__FILE__) . 'lib/autoloader.php'; // Our autoloader
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php'; // Composer autoloader


/*

Used for both free / pro versions

*/
if (!defined('WP_SHOPIFY_BASENAME')) {
   define('WP_SHOPIFY_BASENAME', plugin_basename(__FILE__));
}

if (!defined('WP_SHOPIFY_ROOT_FILE_PATH')) {
   define('WP_SHOPIFY_ROOT_FILE_PATH', __FILE__);
}


/*

Bootstrap everything

*/
use WP_Shopify\Bootstrap;


if ( !function_exists("WP_Shopify_Bootstrap") ) {

	function WP_Shopify_Bootstrap() {
		return Bootstrap::run();
	}

}

/*

Performs the plugin bootstrap

*/
WP_Shopify_Bootstrap();


/*

Adds hooks which run on both plugin activation and deactivation.
The actions here are added during Activator->init() and Deactivator-init().

*/
register_activation_hook(__FILE__, function($network_wide) {
   do_action('wps_on_plugin_activate', $network_wide);
});

register_deactivation_hook(__FILE__, function() {
	do_action('wps_on_plugin_deactivate');
});