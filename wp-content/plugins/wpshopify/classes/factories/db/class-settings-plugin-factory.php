<?php

namespace WP_Shopify\Factories\DB;

if (!defined('ABSPATH')) {
	exit;
}

use WP_Shopify\DB;

class Settings_Plugin_Factory {

	protected static $settings = [];

	public static function build() {

		if (empty(self::$settings)) {

         $general = new DB\Settings_General();
         $connection = new DB\Settings_Connection();
         $license = new DB\Settings_License();
         $syncing = new DB\Settings_Syncing();
         $shop = new DB\Shop();

         $general_rows = $general->table_exists($general->table_name) ? $general->get_all_rows() : false;
         $connection_rows = $connection->table_exists($connection->table_name) ? $connection->get_all_rows() : false;
         $license_rows = $license->table_exists($license->table_name) ? $license->get_all_rows() : false;
         $shop_rows = $shop->table_exists($shop->table_name) ? $shop->get_all_rows() : false;
         $syncing_rows = $syncing->table_exists($syncing->table_name) ? $syncing->get_all_rows() : false;

         self::$settings['general'] = !empty($general_rows) ? $general_rows[0] : false;
         self::$settings['connection'] = !empty($connection_rows) ? $connection_rows[0] : false;
         self::$settings['license'] = !empty($license_rows) ? $license_rows[0] : false;
         self::$settings['syncing'] = !empty($syncing_rows) ? $syncing_rows[0] : false;
         self::$settings['shop'] = !empty($shop_rows) ? $shop_rows[0] : false;

		}

		return self::$settings;

	}

}
