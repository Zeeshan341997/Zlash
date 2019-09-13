<?php

namespace WP_Shopify\Factories\API\Misc;

defined('ABSPATH') ?: die;

use WP_Shopify\Factories;
use WP_Shopify\API;

class Routes_Factory {

	protected static $instantiated = null;

	public static function build() {

		if (is_null(self::$instantiated)) {

			self::$instantiated = new API\Misc\Routes(
				Factories\Routes_Factory::build()
			);

		}

		return self::$instantiated;

	}

}
