<?php

use WP_Shopify\Utils;

?>

<div class="wps-form-group wps-form-group-tight">

  <table class="form-table">
    <tbody>
      <tr valign="top">

        <th scope="row" class="titledesc">
          <?php esc_html_e( 'Webhooks domain', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
          <span class="wps-help-tip" title="<?php esc_attr_e( 'Useful during local development for testing Shopify webhooks. Change this to a proxy domain using something like ngrok; e.g. https://270f231b.ngrok.io', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
        </th>

        <td class="forminp forminp-text">
          <input required type="text" class="regular-text" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_url_webhooks" name="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>[wps_general_webhooks_products]" value="<?php if(!empty($general->url_webhooks)) echo $general->url_webhooks; ?>" placeholder="<?php esc_attr_e( Utils::get_site_url(), WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>">
        </td>

      </tr>
    </tbody>
  </table>

</div>
