<?php

namespace WP_Shopify;

use WP_Shopify\Utils;
use WP_Shopify\Messages;

if (!defined('ABSPATH')) {
	exit;
}


class Webhooks {

	private $DB_Settings_Connection;
	private $DB_Settings_General;


	public function __construct($DB_Settings_Connection, $DB_Settings_General) {

		$this->DB_Settings_Connection 	= $DB_Settings_Connection;
		$this->DB_Settings_General 			= $DB_Settings_General;

	}




}
