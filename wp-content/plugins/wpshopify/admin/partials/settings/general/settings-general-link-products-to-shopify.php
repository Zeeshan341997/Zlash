<!--

Load cart

-->
<div class="wps-form-group wps-form-group-align-top">

  <table class="form-table">

    <tbody>
      <tr valign="top">

        <th scope="row" class="titledesc">
          <?php esc_html_e( 'Products link to Shopify', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
          <span class="wps-help-tip" title="<?php esc_attr_e( 'When this is enabled, products will not link to WP Shopify product single pages. Instead they\'ll link back to the product detail page on Shopify. Toggling this on/off will require you to clear the WP Shopify cache. You can do this from within Tools - Clear Transients. Will not work when Shopify store is password protected, if product is not assigned to the Online Store sales channel, or if using the Shopify Lite plan.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
        </th>

        <td class="forminp forminp-text">
          <input name="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>[wps_general_products_link_to_shopify]" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_products_link_to_shopify" type="checkbox" <?php echo $general->products_link_to_shopify ? 'checked' : ''; ?>>
        </td>

      </tr>
    </tbody>

  </table>

</div>
