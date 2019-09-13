<?php

namespace WP_Shopify\Factories\API\Options;

if (!defined('ABSPATH')) {
   exit();
}

use WP_Shopify\API;
use WP_Shopify\Factories;

class Components_Factory
{
   protected static $instantiated = null;

   public static function build()
   {
      if (is_null(self::$instantiated)) {
         self::$instantiated = new API\Options\Components();
      }

      return self::$instantiated;
   }
}
