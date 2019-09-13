<!--

Tab Content: Connect

-->
<div class="tab-content <?php echo $active_tab === 'tab-connect' ? 'tab-content-active' : ''; ?> <?= $has_connection ? 'wps-connected' : ''; ?>" data-tab-content="tab-connect">

  <div class="wps-admin-section-heading-group wps-l-row wps-l-space-between">

    <h2 class="wps-admin-section-heading">
      <span class="dashicons dashicons-update"></span> <?php esc_html_e( 'Connect and Sync ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
    </h2>

    <h3 class="wps-status-heading wps-admin-section-heading">

      <?php if ($has_connection) { ?>
        <span class="wps-status is-connected"><?php esc_html_e('Connected', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?></span>
        <?php 
        
        if ($shop_name) { ?>
            <code class="wps-store-name"><?= $shop_name; ?></code>
         <?php }
        
        ?>

      <?php } else { ?>
        <span class="wps-status is-disconnected"><?php esc_html_e('Disconnected', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?></span>
      <?php } ?>

    </h3>

  </div>

  <div class="wps-admin-section">

    <p><?php printf(__('Enter your <a href="%s" target="_blank">Shopify private app credentials</a> below.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), esc_url('https://docs.wpshop.io/#/getting-started/syncing'));  ?></p>

    <form method="post" name="cleanup_options" action="options.php" id="wps-connect" class="wps-admin-form">

      <?php

        settings_fields(WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME);
        do_settings_sections(WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME);

         function maskValue($val){

            $mask_val =  str_repeat("*", strlen($val)-4) . substr($val, -4);

            return $mask_val;

         }
         
      ?>

      <!--

      API Key

      -->
      <div class="wps-form-group">

        <h4><?php esc_attr_e('API Key', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></h4>



        <input required <?= $has_connection ? 'disabled' : ''; ?> type="text" class="regular-text <?= $has_connection ? 'valid' : ''; ?>" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_api_key" name="api_key" value="<?php if(!empty($connection->api_key)) echo maskValue($connection->api_key); ?>" placeholder=""> <span class="wps-help-tip wps-help-tip-inline-no-position" title="<?php esc_attr_e( 'To generate an API key you must create a "Private App" within your Shopify account.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span><div class="wps-form-icon wps-animated"></div>

      </div>


      <!--

      Password

      -->
      <div class="wps-form-group">

        <h4><?php esc_attr_e('API Password', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></h4>

        <input required <?= $has_connection ? 'disabled' : ''; ?> type="text" class="regular-text <?= $has_connection ? 'valid' : ''; ?>" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_api_password" name="api_password" autocomplete="off" value="<?php if(!empty($connection->api_password)) echo maskValue($connection->api_password); ?>" placeholder=""> <span class="wps-help-tip wps-help-tip-inline-no-position" title="<?php esc_attr_e( 'To generate an API Password you must create a "Private App" within your Shopify account.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span> <div class="wps-form-icon wps-animated"></div>

      </div>


      <!--

      Shared Secret

      -->
      <div class="wps-form-group">

        <h4><?php esc_attr_e('Shared Secret', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></h4>

        <input required <?= $has_connection ? 'disabled' : ''; ?> type="text" class="regular-text <?= $has_connection ? 'valid' : ''; ?>" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_shared_secret" name="shared_secret" autocomplete="off" value="<?php if(!empty($connection->shared_secret)) echo maskValue($connection->shared_secret); ?>" placeholder=""> <span class="wps-help-tip wps-help-tip-inline-no-position" title="<?php esc_attr_e( 'To generate a Shared Secret you must create a "Private App" within your Shopify account. The Shared Secret is used to validate webhook requests and provide security for WP Shopify.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span> <div class="wps-form-icon wps-animated"></div>

      </div>


      <!--

      Storefront Access Token

      -->
      <div class="wps-form-group">

        <h4><?php esc_attr_e('Storefront Access Token', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></h4>

        <input required <?= $has_connection ? 'disabled' : ''; ?> type="text" class="regular-text <?= $has_connection ? 'valid' : ''; ?>" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_storefront_access_token" name="storefront_access_token" value="<?php if(!empty($connection->storefront_access_token)) echo maskValue($connection->storefront_access_token); ?>" placeholder=""> <span class="wps-help-tip wps-help-tip-inline-no-position" title="<?php esc_attr_e( 'To generate a Storefront Access Token you must create a "Private App" within your Shopify account. The Storefront Access Token is used to create the front-end cart experience.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span><div class="wps-form-icon wps-animated"></div>

      </div>

      <!--

      My Shopify Domain

      -->
      <div class="wps-form-group">

        <h4><?php esc_attr_e( 'Domain', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?></h4>
        <input required <?= $has_connection ? 'disabled' : ''; ?> type="text" class="regular-text <?= $has_connection ? 'valid' : ''; ?>" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_domain" name="domain" value="<?php if ( !empty($connection->domain) ) echo $connection->domain; ?>" placeholder="<?php esc_attr_e('shop.myshopify.com', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>" id="domain"> <span class="wps-help-tip wps-help-tip-inline" title="<?php esc_attr_e( 'example: yourshop.myshopify.com', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
        <div class="wps-form-icon wps-animated"></div>

      </div>


      <!-- Nonce -->
      <input hidden type="text" class="regular-text" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_nonce_id" name="nonce" value="<?php echo wp_create_nonce( 'connection-form' ); ?>"/>

      <!-- Submit -->
      <div class="wps-button-group button-group button-group-ajax">

        <?php if ($has_connection) { ?>
          <?php submit_button( esc_html__('Disconnect your Shopify store', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'primary large', 'submitDisconnect', false, array()); ?>

        <?php } else { ?>
          <?php submit_button( esc_html__('Connect your Shopify store', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'primary large', 'submitConnect', false, array()); ?>
        <?php } ?>

        <div class="spinner"></div>

      </div>

    </form>

  </div>

</div>
