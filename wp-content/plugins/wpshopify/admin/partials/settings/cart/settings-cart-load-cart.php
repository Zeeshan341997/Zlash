<!--

Load cart

-->
<div class="wps-form-group wps-form-group-tight wps-form-group-align-top">

  <table class="form-table">

    <tbody>
      <tr valign="top">

        <th scope="row" class="titledesc">
          <?php esc_html_e( 'Load cart', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
          <span class="wps-help-tip" title="<?php esc_attr_e( 'When this is turned off, the default cart experience will not load. Useful if you plan on linking products to Shopify directly.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
        </th>

        <td class="forminp forminp-text">
          <input name="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>[wps_general_cart_loaded]" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_cart_loaded" type="checkbox" <?php echo $general->cart_loaded ? 'checked' : ''; ?>>
        </td>

      </tr>
    </tbody>

  </table>

</div>
