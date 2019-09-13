<!--

Tab Content: Settings

-->

<div class="tab-content <?= $active_tab === 'tab-settings' ? 'tab-content-active' : '' ?>"
   data-tab-content="tab-settings">

   <ul class="subsubsub wps-submenu">

      <li>
         <a class="wps-sub-section-link <?= $active_sub_nav === 'wps-admin-section-general' ? 'current' : '' ?>"
            href="#!" data-sub-section="wps-admin-section-general" title="General"><?php echo __('General', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></a> |
      </li>

      <li>
         <a class="wps-sub-section-link <?= $active_sub_nav === 'wps-admin-section-syncing' ? 'current' : '' ?>"
            href="#!" data-sub-section="wps-admin-section-syncing" title="Syncing"><?php echo __('Syncing', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></a> |
      </li>

      <li>
         <a class="wps-sub-section-link <?= $active_sub_nav === 'wps-admin-section-pricing' ? 'current' : '' ?>"
            href="#!" data-sub-section="wps-admin-section-pricing" title="Pricing"><?php echo __('Pricing', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></a> |
      </li>

      <li>
         <a class="wps-sub-section-link <?= $active_sub_nav === 'wps-admin-section-layout' ? 'current' : '' ?>"
            href="#!" data-sub-section="wps-admin-section-layout" title="Layout"><?php echo __('Layout', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></a> |
      </li>

      <li>
         <a class="wps-sub-section-link <?= $active_sub_nav === 'wps-admin-section-products' ? 'current' : '' ?>"
            href="#!" data-sub-section="wps-admin-section-products" title="Products"><?php echo __('Products', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></a> |
      </li>

      <li>
         <a class="wps-sub-section-link <?= $active_sub_nav === 'wps-admin-section-collections'
         ? 'current'
         : '' ?>" href="#!" data-sub-section="wps-admin-section-collections" title="Collections"><?php echo __('Collections', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></a> |
      </li>

      <li>
         <a class="wps-sub-section-link <?= $active_sub_nav === 'wps-admin-section-cart' ? 'current' : '' ?>" href="#!"
            data-sub-section="wps-admin-section-cart" title="Cart"><?php echo __('Cart', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></a> |
      </li>
   
      <li>
         <a class="wps-sub-section-link <?= $active_sub_nav === 'wps-admin-section-checkout' ? 'current' : '' ?>"
            href="#!" data-sub-section="wps-admin-section-checkout" title="Checkout"><?php echo __('Checkout', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></a> |
      </li>

      <li>
         <a class="wps-sub-section-link <?= $active_sub_nav === 'wps-admin-section-plugin' ? 'current' : '' ?>"
            href="#!" data-sub-section="wps-admin-section-plugin" title="Plugin"><?php echo __('Plugin', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></a>
      </li>

   </ul>


   <form method="post" name="wps_settings_general" action="options.php" id="wps-settings" class="wps-admin-form">

      <!--

    General Settings

    -->
      <div class="wps-admin-sub-section <?= $active_sub_nav === 'wps-admin-section-general' ? 'is-active' : '' ?>"
         id="wps-admin-section-general">

         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-admin-settings"></span>
            <?php esc_html_e('General ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

          <?php
          
          require_once plugin_dir_path(__FILE__) . 'settings/general/settings-general-product-urls.php';
          require_once plugin_dir_path(__FILE__) . 'settings/general/settings-general-collections-urls.php';
          require_once plugin_dir_path(__FILE__) . 'settings/general/settings-general-disable-default-pages.php';
          require_once plugin_dir_path(__FILE__) . 'settings/general/settings-general-products-per-page.php';
          require_once plugin_dir_path(__FILE__) . 'settings/general/settings-general-link-products-to-shopify.php';
          
          ?>

         </div>

      </div>


      <!--

    Syncing

    -->
      <div class="wps-admin-sub-section <?= $active_sub_nav === 'wps-admin-section-syncing' ? 'is-active' : '' ?>"
         id="wps-admin-section-syncing">

         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-admin-generic"></span>
            <?php esc_html_e('Syncing ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php

               require_once plugin_dir_path(__FILE__) . 'settings/syncing/settings-syncing-items-per-request.php';
               require_once plugin_dir_path(__FILE__) . 'settings/syncing/settings-syncing-synchronous.php';
               require_once plugin_dir_path(__FILE__) . 'settings/syncing/settings-syncing-is-lite-sync.php';
               require_once plugin_dir_path(__FILE__) . 'settings/syncing/settings-syncing-is-syncing-posts.php';

               
            ?>

         </div>

         

      </div>


      <!--

    Pricing Settings

    -->
      <div class="wps-admin-sub-section <?= $active_sub_nav === 'wps-admin-section-pricing' ? 'is-active' : '' ?>"
         id="wps-admin-section-pricing">

         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-tag"></span> <?php esc_html_e('General', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
          require_once plugin_dir_path(__FILE__) . 'settings/pricing/settings-pricing-compare-at.php';
          require_once plugin_dir_path(__FILE__) . 'settings/pricing/settings-pricing-show-price-range.php';
          require_once plugin_dir_path(__FILE__) . 'settings/pricing/settings-pricing-pricing.php';
          ?>

         </div>

         <?php
?>

      </div>


      <!--

    Layout Settings

    -->
      <div class="wps-admin-sub-section <?= $active_sub_nav === 'wps-admin-section-layout' ? 'is-active' : '' ?>"
         id="wps-admin-section-layout">

         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-layout"></span>
            <?php esc_html_e('General Layout ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
          require_once plugin_dir_path(__FILE__) . 'settings/layout/settings-layout-show-breadcrumbs.php';
          require_once plugin_dir_path(__FILE__) . 'settings/layout/settings-layout-hide-pagination.php';
          require_once plugin_dir_path(__FILE__) . 'settings/layout/settings-layout-align-height.php';

// require_once plugin_dir_path( __FILE__ ) . 'settings/settings-pricing.php';
?>

         </div>

      </div>


      <!--

    Products Settings

    -->
      <div class="wps-admin-sub-section <?= $active_sub_nav === 'wps-admin-section-products' ? 'is-active' : '' ?>"
         id="wps-admin-section-products">

         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-art"></span> <?php esc_html_e('Colors ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
        require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-add-to-cart-button-color.php';
        require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-variant-button-color.php';
        ?>

         </div>

         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-format-aside"></span>
            <?php esc_html_e('Content ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
        require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-heading-toggle.php';
        require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-heading.php';
        ?>

         </div>


         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-format-image"></span>
            <?php esc_html_e('Featured Images ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
          require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-images-sizing-toggle.php';
          require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-images-sizing-width.php';
          require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-images-sizing-height.php';
          require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-images-sizing-crop.php';
          require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-images-sizing-scale.php';
          ?>

         </div>

         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-format-image"></span>
            <?php esc_html_e('Thumbnail Images ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
          require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-thumbnail-images-sizing-toggle.php';
          require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-thumbnail-images-sizing-width.php';
          require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-thumbnail-images-sizing-height.php';
          require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-thumbnail-images-sizing-crop.php';
          require_once plugin_dir_path(__FILE__) . 'settings/products/settings-products-thumbnail-images-sizing-scale.php';
          ?>

         </div>

      </div>


      <!--

    Collections Settings

    -->
      <div class="wps-admin-sub-section <?= $active_sub_nav === 'wps-admin-section-collections' ? 'is-active' : '' ?>"
         id="wps-admin-section-collections">

         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-format-aside"></span>
            <?php esc_html_e('Content ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
        require_once plugin_dir_path(__FILE__) . 'settings/collections/settings-collections-heading-toggle.php';
        require_once plugin_dir_path(__FILE__) . 'settings/collections/settings-collections-heading.php';
        ?>

         </div>


         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-format-image"></span>
            <?php esc_html_e('Images ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
          require_once plugin_dir_path(__FILE__) . 'settings/collections/settings-collections-images-sizing-toggle.php';
          require_once plugin_dir_path(__FILE__) . 'settings/collections/settings-collections-images-sizing-width.php';
          require_once plugin_dir_path(__FILE__) . 'settings/collections/settings-collections-images-sizing-height.php';
          require_once plugin_dir_path(__FILE__) . 'settings/collections/settings-collections-images-sizing-crop.php';
          require_once plugin_dir_path(__FILE__) . 'settings/collections/settings-collections-images-sizing-scale.php';
          ?>

         </div>

      </div>


      <!--

    Related Products

    -->
      <div
         class="wps-admin-sub-section <?= $active_sub_nav === 'wps-admin-section-related-products' ? 'is-active' : '' ?>"
         id="wps-admin-section-related-products">

         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-networking"></span>
            <?php esc_html_e('Related Products ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>


         <?php
      require_once plugin_dir_path(__FILE__) . 'settings/related-products/settings-related-products-show.php';
      require_once plugin_dir_path(__FILE__) . 'settings/related-products/settings-related-products-sort.php';
      require_once plugin_dir_path(__FILE__) . 'settings/related-products/settings-related-products-amount.php';
      ?>

         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-format-aside"></span>
            <?php esc_html_e('Content ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
        require_once plugin_dir_path(__FILE__) . 'settings/related-products/settings-related-products-heading-toggle.php';
        require_once plugin_dir_path(__FILE__) . 'settings/related-products/settings-related-products-heading.php';
        ?>

         </div>


         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-format-image"></span>
            <?php esc_html_e('Images ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
          require_once plugin_dir_path(__FILE__) . 'settings/related-products/settings-related-products-images-sizing-toggle.php';
          require_once plugin_dir_path(__FILE__) . 'settings/related-products/settings-related-products-images-sizing-width.php';
          require_once plugin_dir_path(__FILE__) . 'settings/related-products/settings-related-products-images-sizing-height.php';
          require_once plugin_dir_path(__FILE__) . 'settings/related-products/settings-related-products-images-sizing-crop.php';
          require_once plugin_dir_path(__FILE__) . 'settings/related-products/settings-related-products-images-sizing-scale.php';
          ?>

         </div>

      </div>


      <!--

    Cart Settings

    -->
      <div class="wps-admin-sub-section <?= $active_sub_nav === 'wps-admin-section-cart' ? 'is-active' : '' ?>"
         id="wps-admin-section-cart">

         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-cart"></span> <?php esc_html_e('Cart ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
          require_once plugin_dir_path(__FILE__) . 'settings/cart/settings-cart-load-cart.php';
          require_once plugin_dir_path(__FILE__) . 'settings/cart/settings-cart-show-fixed-cart-tab.php';
          ?>

         </div>

         


         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-art"></span> <?php esc_html_e('Colors ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
        require_once plugin_dir_path(__FILE__) . 'settings/cart/settings-cart-checkout-button-color.php';
        require_once plugin_dir_path(__FILE__) . 'settings/cart/settings-cart-icon-color.php';
        require_once plugin_dir_path(__FILE__) . 'settings/cart/settings-cart-counter-color.php';

        require_once plugin_dir_path(__FILE__) . 'settings/cart/settings-cart-icon-fixed-color.php';
        require_once plugin_dir_path(__FILE__) . 'settings/cart/settings-cart-counter-fixed-color.php';
        require_once plugin_dir_path(__FILE__) . 'settings/cart/settings-cart-fixed-background-color.php';
        ?>

         </div>

      </div>

   <!--

    Search Settings

    -->
    




<!--

    Customers Settings

    -->
          



      <!--

    Checkout Settings

    -->
      <div class="wps-admin-sub-section <?= $active_sub_nav === 'wps-admin-section-checkout' ? 'is-active' : '' ?>"
         id="wps-admin-section-checkout">

         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-cart"></span> <?php esc_html_e('Checkout ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
          require_once plugin_dir_path(__FILE__) . 'settings/checkout/settings-checkout-enable-custom-checkout-domain.php';
          require_once plugin_dir_path(__FILE__) . 'settings/checkout/settings-checkout-button-target.php';
          ?>

         </div>

      </div>


      <!--

    Assets Settings

    -->
      <div class="wps-admin-sub-section <?= $active_sub_nav === 'wps-admin-section-plugin' ? 'is-active' : '' ?>"
         id="wps-admin-section-plugin">

         <h2 class="wps-admin-section-heading">
            <span class="dashicons dashicons-admin-plugins"></span>
            <?php esc_html_e('Plugin ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
         </h2>

         <div class="wps-admin-section">

            <?php
          require_once plugin_dir_path(__FILE__) . 'settings/plugin/settings-plugin-load-styles.php';
          require_once plugin_dir_path(__FILE__) . 'settings/plugin/settings-plugin-beta-enable.php';
          ?>

         </div>

      </div>


      <!-- Nonce -->
      <input hidden type="text" class="regular-text" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME ?>_urls_nonce_id"
         name="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME ?>[wps_general_nonce]" value="<?php echo wp_create_nonce(
              uniqid()
); ?>" />


      <!-- Submit -->
      <div class="wps-button-group button-group button-group-ajax">
         <?php submit_button(esc_html__('Save WP Shopify Settings', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'primary', 'submitSettings', false, array()); ?>
         <div class="spinner"></div>
      </div>


   </form>

</div>