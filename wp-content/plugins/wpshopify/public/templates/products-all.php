<?php

defined('ABSPATH') ?: die;

get_header('wpshopify');

$Products = WP_Shopify\Factories\Render\Products\Products_Factory::build();
$Settings = WP_Shopify\Factories\DB\Settings_General_Factory::build();

?>

<section class="wps-container">
   <?= do_action('wps_breadcrumbs') ?>

   <div class="wps-products-all">
      
      <?php if ($Settings->get_col_value('products_heading_toggle')) { ?>
         <h1 class="wps-heading"><?= $Settings->get_col_value('products_heading'); ?></h1>
      <?php }

      $Products->products(); ?>

   </div>

</section>

<?php

get_footer('wpshopify');