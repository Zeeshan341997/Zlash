<?php 

use WP_Shopify\Utils;

?>

<div class="wps-form-group wps-form-group-tight">

  <table class="form-table">
    <tbody>
      <tr valign="top">
        <th scope="row" class="titledesc">
          <?php esc_html_e( 'Products URL', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
          <span class="wps-help-tip" title="<?php esc_attr_e('Determines the default products page slug. Your permalinks must be set to "Post name" for this URL to work. You can set this by going to `Settings -> Permalinks`.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
        </th>
        <td class="forminp forminp-text">
          <code><?= Utils::get_site_url(); ?>/</code>
          <input required type="text" class="regular-text code" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_url_products" name="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>[wps_general_url_products]" value="<?php if(!empty($general->url_products)) echo $general->url_products; ?>" placeholder="<?php esc_attr_e( 'products', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>">
        </td>
      </tr>
    </tbody>
  </table>

</div>
