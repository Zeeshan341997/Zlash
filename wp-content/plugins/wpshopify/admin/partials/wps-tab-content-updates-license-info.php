<!--

License Info

-->
<div class="postbox wps-postbox-license-info <?= $DB_Settings_License->has_license_key($license) ? '' : 'wps-is-hidden'; ?>" id="wps-license-info">

  <div class="spinner"></div>

  <h3><?php esc_html_e('License Details', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?></h3>

  <table class="form-table wps-is-hidden">

    <tr valign="top" class="alternate">

      <td scope="row">
        <label for="tablecell">
          <?php esc_html_e('Status', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
        </label>
      </td>

      <td class="wps-col wps-col-license-status"></td>

    </tr>

    <tr valign="top">

      <td scope="row">
        <label for="tablecell">
          <?php esc_html_e('Name', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
        </label>
      </td>

      <td class="wps-col wps-col-license-name">
        <?php printf(esc_html__('%s', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), $DB_Settings_License->get_license_customer_name($license)); ?>
      </td>

    </tr>

    <tr valign="top" class="alternate">

      <td scope="row">
        <label for="tablecell">
          <?php esc_html_e('Email', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
        </label>
      </td>

      <td class="wps-col wps-col-license-email">
        <?php printf(esc_html__('%s', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), $DB_Settings_License->get_license_customer_email($license)); ?>
      </td>

    </tr>

    <tr valign="top">

      <td scope="row">
        <label for="tablecell">
          <?php esc_html_e('Expires on', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
        </label>
      </td>

      <td class="wps-col wps-col-license-expire">

        <?php

        $expiration = $DB_Settings_License->get_license_expiration( $license );

        if ( $DB_Settings_License->license_expires($expiration) ) {
          echo $DB_Settings_License->format_license_expiration_date($expiration);

        } else {
          esc_html_e('Never expires', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN);
        }

        ?>

      </td>

    </tr>

    <tr valign="top" class="alternate">

      <td scope="row">
        <label for="tablecell">
          <?php esc_html_e('Activation count', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
        </label>
      </td>

      <td class="wps-col wps-col-license-limit">

        <?php

        printf( esc_html__('%1$d / %2$d', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), $DB_Settings_License->get_license_site_count($license), $DB_Settings_License->get_license_limit( $license ));

        ?>

        <?php if ( $DB_Settings_License->is_local($license) ) { ?>
          <small class="wps-table-supporting">
            <?php esc_html_e('(Activations on dev environments don\'t add to total)', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
          </small>
        <?php } ?>

      </td>

    </tr>


    <tr valign="top" class="alternate">

      <td scope="row">
        <label for="tablecell">
          <?php esc_html_e('Activations left', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN); ?>
        </label>
      </td>

      <td class="wps-col wps-col-license-activations-left"></td>

    </tr>

  </table>

</div>
