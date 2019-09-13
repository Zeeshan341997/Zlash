<!--

Tab Content: Tools

-->
<div class="tab-content <?php echo $active_tab === 'tab-tools' ? 'tab-content-active' : ''; ?>" data-tab-content="tab-tools">

  <h3 class="wps-admin-section-heading"><span class="dashicons dashicons-admin-tools"></span> <?php esc_html_e('Tools', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></h3>

  <div class="wps-admin-section">

    <h3><?php esc_attr_e('Resync Shopify', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?> <span class="wps-help-tip wps-help-tip-inline" title="<?php esc_attr_e("Note: To fix syncing issues you may want to ensure that 'Items per request' is set to 25 and 'Synchronous Requests' turned on. Also be aware that resyncing does not delete the custom post types or any custom fields you\'ve added."); ?>"></span></h3>
    <p><?php esc_attr_e('Manually resync your Shopify data.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></p>

    <div class="wps-button-group button-group button-group-ajax <?= $has_connection ? 'wps-is-active' : 'wps-is-not-active'; ?>">

      <?php

      if ($has_connection) {

        $props = array(
          'id'        => 'wps-button-sync'
        );

      } else {

        $props = array(
          'disabled'  => 'disabled',
          'id'        => 'wps-button-sync'
        );

      }

      submit_button(esc_html__('Resync Shopify data', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'primary', 'submitSettings', false, $props); ?>

      <div class="spinner"></div>

    </div>

  </div>


  <div class="wps-admin-section">

    <h3><?php esc_html_e('Clear Cache', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></h3>
    <p><?php esc_html_e('If you\'re noticing various changes not appearing, try clearing the WP Shopify transient cache here.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></p>

    <div class="wps-button-group button-group button-group-ajax wps-is-active">

      <?php

      $props = array(
        'id' => 'wps-button-clear-cache'
      );

      submit_button(esc_html__('Clear WP Shopify Cache', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'primary', 'submitSettings', false, $props); ?>

      <div class="spinner"></div>

    </div>

  </div>


  <div class="wps-admin-section">

    <h3><?php esc_html_e('Remove all synced data', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></h3>
    <p><?php esc_html_e('This will remove all WP Shopify data from WordPress. Nothing will be changed in Shopify. Useful for removing any lingering data without reinstalling the plugin. (Note: this can take up to 60 seconds and will delete product posts and any active webhooks).', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></p>

    <div class="wps-button-group button-group button-group-ajax wps-is-active">

      <?php

      $props = array(
        'id' => 'wps-button-clear-all-data'
      );

      submit_button(esc_html__('Remove all synced data from WordPress', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'primary', 'submitSettings', false, $props); ?>

      <div class="spinner"></div>

    </div>

  </div>

  


</div>
