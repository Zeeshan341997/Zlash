<?php

namespace WP_Shopify;

if (!defined('ABSPATH')) {
    exit();
}

use WP_Shopify\Options;
use WP_Shopify\Utils;
use WP_Shopify\Utils\Data as Utils_Data;

class Backend
{
   
   public $plugin_settings;

    public function __construct($plugin_settings)
   {
      $this->plugin_settings = $plugin_settings;
   }

    /*

     Checks for a valid admin page

     */
    public function is_valid_admin_page()
    {
        $screen = \get_current_screen();

        if (empty($screen)) {
            return false;
        }

        if (!is_admin()) {
            return false;
        }

        return $screen;
    }

    /*

     Checks for a valid admin page

     */
    public function get_screen_id()
    {
        $screen = $this->is_valid_admin_page();

        if (empty($screen)) {
            return false;
        }

        return $screen->id;
    }

    /*

     Checks for the correct admin page to load CSS

     */
    public function should_load_css()
    {
        if (!$this->is_valid_admin_page()) {
            return;
        }

        $screen_id = $this->get_screen_id();

        if ($this->is_admin_settings_page($screen_id) || $this->is_admin_posts_page($screen_id) || $this->is_admin_plugins_page($screen_id)) {
            return true;
        }

        return false;
    }

    public function is_plugin_specific_pages() {
      return $this->is_admin_settings_page($this->get_screen_id());
    }

    /*

     Checks for the correct admin page to load JS

     */
    public function should_load_js()
    {
        if (!$this->is_valid_admin_page()) {
            return;
        }

        $screen_id = $this->get_screen_id();

        // Might want to check these eventually
        // || $this->is_admin_posts_page($screen_id)

        if ($this->is_admin_settings_page($screen_id)) {
            return true;
        }

        return false;
    }

    /*

     Is wp posts page

     */
    public function is_admin_posts_page($current_admin_screen_id)
    {
        if ($current_admin_screen_id === WP_SHOPIFY_COLLECTIONS_POST_TYPE_SLUG || $current_admin_screen_id === WP_SHOPIFY_PRODUCTS_POST_TYPE_SLUG) {
            return true;
        }
    }

    /*

     Is wp nav menus page

     */
    public function is_admin_nav_page($current_admin_screen_id)
    {
        if ($current_admin_screen_id === 'nav-menus') {
            return true;
        }
    }

    /*

     Is wp plugins page

     */
    public function is_admin_plugins_page($current_admin_screen_id)
    {
        if ($current_admin_screen_id === 'plugins') {
            return true;
        }
    }

    /*

     Is plugin settings page

     */
    public function is_admin_settings_page($current_admin_screen_id = false)
    {

        if (strpos($current_admin_screen_id, 'wp-shopify') !== false) {
            return true;
        }
    }

    /*

     Admin styles

     */
    public function admin_styles()
    {
        if ($this->should_load_css()) {
            wp_enqueue_style('wp-color-picker');

            wp_enqueue_style('animate-css', WP_SHOPIFY_PLUGIN_URL . 'admin/css/vendor/animate.min.css', [], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/css/vendor/animate.min.css'));

            wp_enqueue_style('tooltipster-css', WP_SHOPIFY_PLUGIN_URL . 'admin/css/vendor/tooltipster.min.css', [], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/css/vendor/tooltipster.min.css'));

            wp_enqueue_style('chosen-css', WP_SHOPIFY_PLUGIN_URL . 'admin/css/vendor/chosen.min.css', [], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/css/vendor/chosen.min.css'));

            wp_enqueue_style('gutenberg-components-css', WP_SHOPIFY_PLUGIN_URL . 'dist/gutenberg-components.min.css', [], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'dist/gutenberg-components.min.css'));

            wp_enqueue_style(
                WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-styles-backend',
                WP_SHOPIFY_PLUGIN_URL . 'dist/admin.min.css',
                ['wp-color-picker', 'animate-css', 'tooltipster-css', 'chosen-css'],
                filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'dist/admin.min.css')
         );
        }
    }

    public function replace_rest_protocol() {

      if (is_ssl()) {
         return str_replace("http://", "https://", get_rest_url());
      }
      
      return get_rest_url();
      
    }

    /*

     Admin scripts

     */
    public function admin_scripts()
    {
        if ($this->should_load_js()) {
            wp_enqueue_script('jquery-ui-slider');

            wp_enqueue_script('promise-polyfill', WP_SHOPIFY_PLUGIN_URL . 'admin/js/vendor/es6-promise.auto.min.js', ['jquery'], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/js/vendor/es6-promise.auto.min.js'));

            wp_enqueue_script('tooltipster-js', WP_SHOPIFY_PLUGIN_URL . 'admin/js/vendor/jquery.tooltipster.min.js', ['jquery'], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/js/vendor/jquery.tooltipster.min.js'));

            wp_enqueue_script('validate-js', WP_SHOPIFY_PLUGIN_URL . 'admin/js/vendor/jquery.validate.min.js', ['jquery'], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/js/vendor/jquery.validate.min.js'));

            wp_enqueue_script('chosen-js', WP_SHOPIFY_PLUGIN_URL . 'admin/js/vendor/chosen.jquery.min.js', ['jquery'], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/js/vendor/chosen.jquery.min.js'));

            wp_enqueue_script('anime-js', WP_SHOPIFY_PLUGIN_URL . 'admin/js/vendor/anime.min.js', [], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/js/vendor/anime.min.js'));

            // Third-party libs first ...
            wp_enqueue_script(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-vendors-admin', WP_SHOPIFY_PLUGIN_URL . 'dist/vendors-admin.1785668e.min.js', []);

            // Commonly shared third-party libs second ...
            wp_enqueue_script(
                WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-vendors-common',
                WP_SHOPIFY_PLUGIN_URL . 'dist/vendors-admin-public.1785668e.min.js',
                []
            );

            wp_enqueue_script(
                WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-backend',
                WP_SHOPIFY_PLUGIN_URL . 'dist/admin.1785668e.min.js',
                ['jquery', 'promise-polyfill', 'tooltipster-js', 'validate-js', 'chosen-js', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-vendors-admin', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-vendors-common']
         );

            wp_localize_script(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-backend', WP_SHOPIFY_PLUGIN_NAME_JS, [
            'ajax' => __(admin_url('admin-ajax.php')),
            'pluginsPath' => __(plugins_url()),
            'siteUrl' => site_url(),
            'pluginsDirURL' => plugin_dir_url(dirname(__FILE__)),
            'nonce' => wp_create_nonce(WP_SHOPIFY_BACKEND_NONCE_ACTION),
            'nonce_api' => wp_create_nonce('wp_rest'),
            'selective_sync' => [
               'all' => $this->plugin_settings['general']->selective_sync_all,
               'products' => $this->plugin_settings['general']->selective_sync_products,
               'smart_collections' => $this->plugin_settings['general']->selective_sync_collections,
               'custom_collections' => $this->plugin_settings['general']->selective_sync_collections,
               'customers' => $this->plugin_settings['general']->selective_sync_customers,
               'orders' => $this->plugin_settings['general']->selective_sync_orders,
               'shop' => $this->plugin_settings['general']->selective_sync_shop
            ],
            'reconnectingWebhooks' => false,
            'hasConnection' => empty($this->plugin_settings['connection']) ? false : !empty($this->plugin_settings['connection']->storefront_access_token),
            'isSyncing' => false,
            'manuallyCanceled' => false,
            'isClearing' => false,
            'isDisconnecting' => false,
            'isConnecting' => false,
            'latestVersion' => WP_SHOPIFY_NEW_PLUGIN_VERSION,
            'latestVersionCombined' => str_replace('.', '', WP_SHOPIFY_NEW_PLUGIN_VERSION),
            'migrationNeeded' => Options::get('wp_shopify_migration_needed'),
            'itemsPerRequest' => $this->plugin_settings['general']->items_per_request,
            'maxItemsPerRequest' => WP_SHOPIFY_MAX_ITEMS_PER_REQUEST,
            'settings' => [
               'layoutAlignHeight' => Utils_Data::coerce($this->plugin_settings['general']->align_height, 'bool'),
               'colorAddToCart' => $this->plugin_settings['general']->add_to_cart_color,
               'colorVariant' => $this->plugin_settings['general']->variant_color,
               'colorCheckout' => $this->plugin_settings['general']->checkout_color,
               'colorCartCounter' => $this->plugin_settings['general']->cart_counter_color,
               'colorCartIcon' => $this->plugin_settings['general']->cart_icon_color,
               'colorCartIconFixed' => $this->plugin_settings['general']->cart_icon_fixed_color,
               'productsHeading' => $this->plugin_settings['general']->products_heading,
               'collectionsHeading' => $this->plugin_settings['general']->collections_heading,
               'relatedProductsHeading' => $this->plugin_settings['general']->related_products_heading,
               'productsHeadingToggle' => $this->plugin_settings['general']->products_heading_toggle,
               'collectionsHeadingToggle' => $this->plugin_settings['general']->collections_heading_toggle,
               'relatedProductsHeadingToggle' => $this->plugin_settings['general']->related_products_heading_toggle,
               'productsImagesSizingToggle' => $this->plugin_settings['general']->products_images_sizing_toggle,
               'productsImagesSizingWidth' => $this->plugin_settings['general']->products_images_sizing_width,
               'productsImagesSizingHeight' => $this->plugin_settings['general']->products_images_sizing_height,
               'productsImagesSizingCrop' => $this->plugin_settings['general']->products_images_sizing_crop,
               'productsImagesSizingScale' => $this->plugin_settings['general']->products_images_sizing_scale,

               'productsThumbnailImagesSizingToggle' => Utils_Data::coerce($this->plugin_settings['general']->products_thumbnail_images_sizing_toggle, 'bool'),
               'productsThumbnailImagesSizingWidth' => Utils_Data::coerce($this->plugin_settings['general']->products_thumbnail_images_sizing_width, 'int'),
               'productsThumbnailImagesSizingHeight' => Utils_Data::coerce($this->plugin_settings['general']->products_thumbnail_images_sizing_height, 'int'),
               'productsThumbnailImagesSizingCrop' => Utils_Data::coerce($this->plugin_settings['general']->products_thumbnail_images_sizing_crop, 'string'),
               'productsThumbnailImagesSizingScale' => Utils_Data::coerce($this->plugin_settings['general']->products_thumbnail_images_sizing_scale, 'int'),
               'productsImagesShowZoom' => Utils_Data::coerce($this->plugin_settings['general']->products_images_show_zoom, 'bool'),
               'collectionsImagesSizingToggle' => $this->plugin_settings['general']->collections_images_sizing_toggle,
               'collectionsImagesSizingWidth' => $this->plugin_settings['general']->collections_images_sizing_width,
               'collectionsImagesSizingHeight' => $this->plugin_settings['general']->collections_images_sizing_height,
               'collectionsImagesSizingCrop' => $this->plugin_settings['general']->collections_images_sizing_crop,
               'collectionsImagesSizingScale' => $this->plugin_settings['general']->collections_images_sizing_scale,
               'relatedProductsImagesSizingToggle' => $this->plugin_settings['general']->related_products_images_sizing_toggle,
               'relatedProductsImagesSizingWidth' => $this->plugin_settings['general']->related_products_images_sizing_width,
               'relatedProductsImagesSizingHeight' => $this->plugin_settings['general']->related_products_images_sizing_height,
               'relatedProductsImagesSizingCrop' => $this->plugin_settings['general']->related_products_images_sizing_crop,
               'relatedProductsImagesSizingScale' => $this->plugin_settings['general']->related_products_images_sizing_scale,
               'enableCustomCheckoutDomain' => $this->plugin_settings['general']->enable_custom_checkout_domain,
               'pricingCompareAt' => $this->plugin_settings['general']->products_compare_at,
               'enableCustomerAccounts' => Utils_Data::coerce($this->plugin_settings['general']->enable_customer_accounts, 'bool'),
               'enableCartNotes' => Utils_Data::coerce($this->plugin_settings['general']->enable_cart_notes, 'bool'),
               'cartNotesPlaceholder' => Utils_Data::coerce($this->plugin_settings['general']->cart_notes_placeholder, 'string'),
               'enableCartTerms' => Utils_Data::coerce($this->plugin_settings['general']->enable_cart_terms, 'bool'),
               'cartTerms' => Utils_Data::coerce($this->plugin_settings['general']->cart_terms_content, 'string'),
               'pricingShowPriceRange' => Utils_Data::coerce($this->plugin_settings['general']->products_show_price_range, 'bool'),
               'pricingCurrencyDisplayStyle' => Utils_Data::coerce($this->plugin_settings['general']->currency_display_style, 'string'),
               'checkoutButtonTarget' => Utils_Data::coerce($this->plugin_settings['general']->checkout_button_target, 'string'),
               'cartShowFixedCartTab' => Utils_Data::coerce($this->plugin_settings['general']->show_fixed_cart_tab, 'bool'),
               'cartIconFixedColor' => Utils_Data::coerce($this->plugin_settings['general']->cart_icon_fixed_color, 'string'),
               'cartCounterFixedColor' => Utils_Data::coerce($this->plugin_settings['general']->cart_counter_fixed_color, 'string'),
               'cartFixedBackgroundColor' => Utils_Data::coerce($this->plugin_settings['general']->cart_fixed_background_color, 'string'),
               'pricingLocalCurrencyToggle' => Utils_Data::coerce($this->plugin_settings['general']->pricing_local_currency_toggle, 'bool'),
               'pricingLocalCurrencyWithBase' => Utils_Data::coerce($this->plugin_settings['general']->pricing_local_currency_with_base, 'bool'),
               'synchronousSync' => Utils_Data::coerce($this->plugin_settings['general']->synchronous_sync, 'bool'),
               'isLiteSync' => Utils_Data::coerce($this->plugin_settings['general']->is_lite_sync, 'bool'),
               'isSyncingPosts' => Utils_Data::coerce($this->plugin_settings['general']->is_syncing_posts, 'bool'),
               'selectiveSyncAll' => Utils_Data::coerce($this->plugin_settings['general']->selective_sync_all, 'bool'),
               'selectiveSyncProducts' => Utils_Data::coerce($this->plugin_settings['general']->selective_sync_products, 'bool'),
               'selectiveSyncCollections' => Utils_Data::coerce($this->plugin_settings['general']->selective_sync_collections, 'bool'),
               'selectiveSyncCustomers' => Utils_Data::coerce($this->plugin_settings['general']->selective_sync_customers, 'bool'),
               'selectiveSyncOrders' => Utils_Data::coerce($this->plugin_settings['general']->selective_sync_orders, 'bool'),
               'disableDefaultPages' => Utils_Data::coerce($this->plugin_settings['general']->disable_default_pages, 'bool'),
               'searchBy' => Utils_Data::coerce($this->plugin_settings['general']->search_by, 'string'),
               'searchExactMatch' => Utils_Data::coerce($this->plugin_settings['general']->search_exact_match, 'bool'),
               'connection' => [
                  'saveConnectionOnly' => Utils_Data::coerce($this->plugin_settings['general']->save_connection_only, 'bool')
               ],
               'accountPageLogin' => Utils_Data::coerce($this->plugin_settings['general']->account_page_login, 'string'),
               'accountPageRegister' => Utils_Data::coerce($this->plugin_settings['general']->account_page_register, 'string'),
               'accountPageAccount' => Utils_Data::coerce($this->plugin_settings['general']->account_page_account, 'string'),
               'accountPageForgotPassword' => Utils_Data::coerce($this->plugin_settings['general']->account_page_forgot_password, 'string'),
               'accountPageSetPassword' => Utils_Data::coerce($this->plugin_settings['general']->account_page_set_password, 'string')
            ],
            'API' => [
               'namespace' => WP_SHOPIFY_SHOPIFY_API_NAMESPACE,
               'baseUrl' => site_url(),
               'urlPrefix' => rest_get_url_prefix(),
               'restUrl' => $this->replace_rest_protocol(),
               'nonce' => wp_create_nonce('wp_rest'),
               'isSSL' => is_ssl()
            ],
            'timers' => [
               'syncing' => false
            ],
            'pages' => get_pages(['post_type' => 'page', 'post_status' => 'publish', 'sort_order' => 'asc', 'sort_column' => 'post_title'])
         ]);
        }
    }

    /*

     Registering the admin menu into the WordPress Dashboard menu.
     Adding a settings page to the Settings menu.

     */
    public function add_dashboard_menus()
    {
        if (current_user_can('manage_options')) {
            
            $plugin_name = WP_SHOPIFY_PLUGIN_NAME_FULL;


            global $submenu;

            $icon_svg =
            'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDIzLjAuNCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAxMDAgMTAwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxMDAgMTAwOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTE4LjksMjYuOGM1LjIsMCw5LjksMi45LDEyLjMsNy42bDEwLDE5LjljMCwwLDQuMy02LjksOC40LTEzLjFsMC44LTEuMmwtNS43LTEyLjVjLTAuMi0wLjQsMC4xLTAuOCwwLjUtMC44aDEzCgkJYzUuNSwwLDEwLjQsMy4yLDEyLjYsOC4ybDguNSwxOS4ybDMuOC02LjFjMi40LTQsNS41LTkuMSw4LjEtMTIuOGwyLjItMy41Qzg2LjIsMTUsNjkuNSwzLjMsNTAuMiwzLjNjLTE3LjQsMC0zMi42LDkuNS00MC43LDIzLjUKCQlIMTguOXoiLz4KCTxwYXRoIGQ9Ik05NC42LDM1bC0yLjMsMy43bDAuMSwwbC0yNSw0MC4xYy0wLjUsMC42LTEuMywwLjgtMiwwLjRjLTAuNi0wLjQtMC44LTEuMy0wLjQtMS45bDQuNS03LjNjLTIuOSwwLjMtNS45LTEtNy4yLTRMNTEuOCw0MwoJCUwyOSw3OC43Yy0wLjIsMC4zLTAuNywwLjQtMSwwLjJsLTEtMC42Yy0wLjMtMC4yLTAuNC0wLjctMC4yLTFsNC41LTcuMmMtMi44LDAuMy01LjgtMS4xLTcuMS00bC0xNy0zNC44Yy0yLjYsNS44LTQsMTIuMi00LDE5CgkJYzAsMjYsMjEsNDcsNDcsNDdzNDctMjEsNDctNDdDOTcuMiw0NC45LDk2LjMsMzkuOCw5NC42LDM1eiIvPgo8L2c+Cjwvc3ZnPgo=';

            // Main menu
            add_menu_page(
                __($plugin_name, WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
                __($plugin_name, WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
                'manage_options',
                WP_SHOPIFY_PLUGIN_TEXT_DOMAIN,
                [$this, 'plugin_admin_page'],
                $icon_svg,
                null
         );

         // Submenu: Settings
         add_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, __('Settings', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), __('Settings', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'manage_options', 'wps-settings', [$this, 'plugin_admin_page']);

         // Submenu: Tools
         add_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, __('Tools', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), __('Tools', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'manage_options', 'wps-tools', [$this, 'plugin_admin_page']);

         if (!Utils_Data::coerce($this->plugin_settings['general']->is_lite_sync, 'bool') && Utils_Data::coerce($this->plugin_settings['general']->is_syncing_posts, 'bool')) {

            add_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, __('Products', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), __('Products', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'manage_options', 'edit.php?post_type=' . WP_SHOPIFY_PRODUCTS_POST_TYPE_SLUG, null);
         
            add_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, __('Collections', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), __('Collections', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'manage_options', 'edit.php?post_type=' . WP_SHOPIFY_COLLECTIONS_POST_TYPE_SLUG, null);

         }
         
         remove_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, WP_SHOPIFY_PLUGIN_TEXT_DOMAIN);

        }
    }

    /*

     Add settings action link to the plugins page.

     */
    public function add_action_links($links)
    {

        $settings_link = ['<a href="' . esc_url(admin_url('/admin.php?page=' . WP_SHOPIFY_PLUGIN_NAME) . '-settings') . '">' . esc_html__('Settings', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN) . '</a>'];
      
        return array_merge($settings_link, $links);
    }

    /*

     Render the settings page for this plugin.

     */
    public function plugin_admin_page()
    {
        include_once WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/partials/wps-admin-display.php';
    }

    /*

     Register / Update plugin options
     Currently only updating connection form

     */
    public function on_options_update()
    {
        register_setting(WP_SHOPIFY_SETTINGS_CONNECTION_OPTION_NAME, WP_SHOPIFY_SETTINGS_CONNECTION_OPTION_NAME, [$this, 'connection_form_validate']);
    }

    /*

     Validate connection form settings

     */
    public function connection_form_validate($input)
    {
        $valid = [];

        // Nonce
        $valid['nonce'] = isset($input['nonce']) && !empty($input['nonce']) ? sanitize_text_field($input['nonce']) : '';

        return $valid;
    }

    public function get_active_tab($GET)
    {
        if (isset($GET['activetab']) && $GET['activetab']) {
            $active_tab = $GET['activetab'];
        } else {
            $active_tab = 'tab-connect';
        }

        if ($GET['page'] === 'wps-tools') {
            $active_tab = 'tab-tools';
        }

        return $active_tab;
    }

    public function get_active_sub_tab($GET)
    {
        if (isset($GET['activesubnav']) && $GET['activesubnav']) {
            $active_sub_nav = $GET['activesubnav'];
        } else {
            $active_sub_nav = 'wps-admin-section-general'; // default sub nav
        }

        return $active_sub_nav;
    }
    

    /*

     Hooks

     */
    public function hooks()
    {

      add_action('admin_menu', [$this, 'add_dashboard_menus']);
      add_action('admin_enqueue_scripts', [$this, 'admin_styles']);
      add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
      add_filter('plugin_action_links_' . WP_SHOPIFY_BASENAME, [$this, 'add_action_links']);
      add_action('admin_init', [$this, 'on_options_update']);
     
    }

    /*

     Init

     */
    public function init()
    {
        $this->hooks();
    }
}