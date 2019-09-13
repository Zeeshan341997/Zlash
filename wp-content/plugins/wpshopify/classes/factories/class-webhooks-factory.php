<?php

namespace WP_Shopify\Factories;

use WP_Shopify\Webhooks;
use WP_Shopify\Factories;

if (!defined('ABSPATH')) {
	exit;
}

class Webhooks_Factory {

	protected static $instantiated = null;

	public static function build() {

		if (is_null(self::$instantiated)) {

			self::$instantiated = new Webhooks(
				Factories\DB\Settings_Connection_Factory::build(),
				Factories\DB\Settings_General_Factory::build()
			);

		}

		return self::$instantiated;

	}

}
