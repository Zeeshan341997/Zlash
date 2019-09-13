<div class="wps-form-group wps-form-group-tight wps-form-group-align-top">

  <table class="form-table">
    <tbody>
      <tr valign="top">

        <th scope="row" class="titledesc">
          <?php esc_attr_e( 'Sync products by collection', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
        </th>

        <td class="forminp forminp-text wps-checkbox-wrapper <?= $has_connection ? 'wps-is-hidden' : ''; ?>" id="wps-sync-by-collections-checkbox-wrapper">
          <div class="notice notice-info inline">
            <p>You need to connect your Shopify store before using this feature.</p>
          </div>
        </td>

        <td class="forminp forminp-text wps-checkbox-wrapper <?= !$has_connection ? 'wps-is-hidden' : ''; ?>" id="wps-sync-by-collections-wrapper">

          <div class="spinner"></div>

          <select multiple="multiple" data-placeholder="Choose collections ..." multiple class="chosen-select wps-chosen" id="wps-sync-by-collections"></select>

        </td>

      </tr>

    </tbody>
  </table>

</div>
