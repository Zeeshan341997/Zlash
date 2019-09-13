<?php

namespace WP_Shopify\Factories\Render\Cart;

if (!defined('ABSPATH')) {
   exit();
}

use WP_Shopify\Render\Cart;
use WP_Shopify\Factories;

class Cart_Factory
{
   protected static $instantiated = null;

   public static function build()
   {
      if (is_null(self::$instantiated)) {
         self::$instantiated = new Cart(
            Factories\Render\Templates_Factory::build(), 
            Factories\Render\Data_Factory::build(),
            Factories\Render\Cart\Defaults_Factory::build()
         );
      }

      return self::$instantiated;
   }
}
