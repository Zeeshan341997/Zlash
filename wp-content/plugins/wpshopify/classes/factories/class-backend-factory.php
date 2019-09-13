<?php

namespace WP_Shopify\Factories;

use WP_Shopify\Backend;
use WP_Shopify\Factories;

if (!defined('ABSPATH')) {
	exit;
}

class Backend_Factory {

	protected static $instantiated = null;

	public static function build($plugin_settings = false) {

      if (!$plugin_settings) {
         $plugin_settings = Factories\DB\Settings_Plugin_Factory::build();
      }

		if (is_null(self::$instantiated)) {

         $Backend = new Backend($plugin_settings);

         self::$instantiated = $Backend;

		}

		return self::$instantiated;

	}

}
