<?php

use WP_Shopify\Utils;

?>

<div class="wps-form-group wps-form-group-tight">

  <table class="form-table">
    <tbody>
      <tr valign="top">
        <th scope="row" class="titledesc">
          <?php esc_html_e( 'Collections URL', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
          <span class="wps-help-tip" title="<?php esc_attr_e('Determines the default collections page slug. Your permalinks must be set to "Post name" for this URL to work. You can set this by going to `Settings -> Permalinks`.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
        </th>
        <td class="forminp forminp-text">
          <code><?= Utils::get_site_url(); ?>/</code>
          <input required type="text" class="regular-text code" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_url_collections" name="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>[wps_general_url_collections]" value="<?php if(!empty($general->url_collections)) echo $general->url_collections; ?>" placeholder="<?php esc_attr_e( 'collections', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>">
        </td>
      </tr>
    </tbody>
  </table>

</div>
