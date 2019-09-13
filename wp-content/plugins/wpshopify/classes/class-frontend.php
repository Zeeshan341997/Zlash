<?php

namespace WP_Shopify;

use WP_Shopify\Utils;
use WP_Shopify\Options;
use WP_Shopify\Utils\Data;
use WP_Shopify\Utils\Server;

if (!defined('ABSPATH')) {
   exit();
}

class Frontend
{
   public $plugin_settings;

   /*

	Initialize the class and set its properties.

	*/
   public function __construct($plugin_settings)
   {
      $this->plugin_settings = $plugin_settings;
   }

   /*

	Public styles

	*/
   public function public_styles()
   {
      if (!is_admin()) {
         $styles_all = $this->plugin_settings['general']->styles_all;
         $styles_core = $this->plugin_settings['general']->styles_core;
         $styles_grid = $this->plugin_settings['general']->styles_grid;

         if ($styles_all) {
            wp_enqueue_style(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-styles-frontend-all', WP_SHOPIFY_PLUGIN_URL . 'dist/public.min.css', [], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'dist/public.min.css'), 'all');
         } else {

            if ($styles_core) {
               wp_enqueue_style(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-styles-frontend-core', WP_SHOPIFY_PLUGIN_URL . 'dist/core.min.css', [], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'dist/core.min.css'), 'all');
            }

            if ($styles_grid) {
               wp_enqueue_style(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-styles-frontend-grid', WP_SHOPIFY_PLUGIN_URL . 'dist/grid.min.css', [], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'dist/grid.min.css'), 'all');
            }
         }

      }
   }


   public function add_script_translations() {
      
      if (!Utils::is_wp_5()) {
         return;
      }

      wp_set_script_translations(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-frontend', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, null);

   }

   public function scripts_deps() {

      $deps = ['jquery', 'promise-polyfill', 'fetch-polyfill', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-vendors-admin-public', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-vendors-public'];

      if (Utils::is_wp_5()) {
         array_push($deps, 'wp-hooks');
      }

      return $deps;

   }

   public function isConnected() {
      
      if (empty($this->plugin_settings['connection'])) {
         return false;
      }

      if (empty($this->plugin_settings['connection']->storefront_access_token)) {
         return false;
      }
      
      return true;
   }

   public function getMyShopifyDomain() {

      if (empty($this->plugin_settings['connection'])) {
         return false;
      }      
      
      return Data::coerce($this->plugin_settings['connection']->domain, 'string');

   }

   public function getStorefrontAccessToken() {

      if (empty($this->plugin_settings['connection'])) {
         return '';
      }

      return Data::coerce($this->plugin_settings['connection']->storefront_access_token, 'string');
   
   }


   /*

	Public scripts

	*/
   public function public_scripts()
   {
      if (!is_admin()) {

         global $post;        
         global $wp_version;

         wp_enqueue_script('promise-polyfill', WP_SHOPIFY_PLUGIN_URL . 'public/js/vendor/es6-promise.auto.min.js', ['jquery'], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'public/js/vendor/es6-promise.auto.min.js'), true);

         wp_enqueue_script('fetch-polyfill', WP_SHOPIFY_PLUGIN_URL . 'public/js/vendor/fetch.umd.js', ['promise-polyfill'], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'public/js/vendor/fetch.umd.js'), true);

         // Commonly shared third-party libs first ...
         wp_enqueue_script(
            WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-vendors-admin-public',
            WP_SHOPIFY_PLUGIN_URL . 'dist/vendors-admin-public.1785668e.min.js',
            ['promise-polyfill', 'fetch-polyfill'],
            false,
            true
         );

         // Public third-party libs second ...
         wp_enqueue_script(
            WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-vendors-public',
            WP_SHOPIFY_PLUGIN_URL . 'dist/vendors-public.1785668e.min.js',
            ['promise-polyfill', 'fetch-polyfill'],
            false,
            true
         );

         wp_enqueue_script(
            WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-frontend',
            WP_SHOPIFY_PLUGIN_URL . 'dist/public.1785668e.min.js',
            $this->scripts_deps(),
            false,
            true
         );

         if (empty($this->plugin_settings['shop'])) {
            $currency = 'USD';

         } else {
            $currency = $this->plugin_settings['shop']->currency;
         }


         $this->add_script_translations();


         wp_localize_script(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-frontend', WP_SHOPIFY_PLUGIN_NAME_JS, [
            'ajax' => apply_filters('wps_admin_ajax_url', esc_url(Utils::convert_to_relative_url(admin_url('admin-ajax.php')))),
            'pluginsPath' => esc_url(plugins_url()),
            'pluginsDirURL' => plugin_dir_url(dirname(__FILE__)),
            'pluginsDistURL' => plugin_dir_url(dirname(__FILE__)) . 'dist/',
            'productsSlug' => $this->plugin_settings['general']->url_products,
            'is_connected' => $this->isConnected(),
            'post_id' => is_object($post) ? $post->ID : false,
            'nonce' => wp_create_nonce(WP_SHOPIFY_FRONTEND_NONCE_ACTION),
            'note_attributes' => '',
            'nonce_api' => wp_create_nonce('wp_rest'),
            'checkoutAttributes' => [],
            'hasCartTerms' => $this->plugin_settings['general']->enable_cart_terms,
            'misc' => [
               'cache_cleared' => Data::coerce(Options::get('wp_shopify_cache_cleared'), 'bool'),
               'wp_version' => Data::coerce($wp_version, 'string'),
               'plugin_version' => Data::coerce($this->plugin_settings['general']->plugin_version, 'string'),
               'is_mobile' => wp_is_mobile(),
               'isPro' => Data::coerce($this->plugin_settings['general']->is_pro, 'bool'),
               'isSSL' => is_ssl(),
               'isLoggedIn' => is_user_logged_in()
            ],
            'settings' => [
               'shop' => [],
               'customers' => [
                  'user' => [
                     'isLoggedIn' => is_user_logged_in(),
                     'id' => get_current_user_id()
                  ],
                  'dropzones' => [
                     'formLogin' => '#component-customers-login',
                     'formAccount' => '#component-customers-account',
                     'formForgotPassword' => '#component-customers-forgot-password',
                     'formSetPassword' => '#component-customers-set-password',
                     'formRegister' => '#component-customers-register'
                  ],
                  'isAccountPage' => is_page('account'),
                  'accountPageLogin' => Data::coerce($this->plugin_settings['general']->account_page_login, 'string'),
                  'accountPageRegister' => Data::coerce($this->plugin_settings['general']->account_page_register, 'string'),
                  'accountPageAccount' => Data::coerce($this->plugin_settings['general']->account_page_account, 'string'),
                  'accountPageForgotPassword' => Data::coerce($this->plugin_settings['general']->account_page_forgot_password, 'string'),
                  'accountPageSetPassword' => Data::coerce($this->plugin_settings['general']->account_page_set_password, 'string')
               ],
               'cart' => [
                  'showFixedCartIcon' => Data::coerce($this->plugin_settings['general']->show_fixed_cart_tab, 'bool'),
                  'cartLoaded' => Data::coerce($this->plugin_settings['general']->cart_loaded, 'bool'),
                  'enableCartTerms' => Data::coerce($this->plugin_settings['general']->enable_cart_terms, 'bool'),
                  'cartTermsContent' => Data::coerce($this->plugin_settings['general']->cart_terms_content, 'string'),
                  'enableCartNotes' => Data::coerce($this->plugin_settings['general']->enable_cart_notes, 'bool'),
                  'cartNotesPlaceholder' => Data::coerce($this->plugin_settings['general']->cart_notes_placeholder, 'string'),
                  'checkoutButtonColor' => Data::coerce($this->plugin_settings['general']->checkout_color, 'string'),
                  'cartIconColor' => Data::coerce($this->plugin_settings['general']->cart_icon_color, 'string'),
                  'colorCounter' => Data::coerce($this->plugin_settings['general']->cart_counter_color, 'string'),
                  'colorCartIconFixed' => Data::coerce($this->plugin_settings['general']->cart_icon_fixed_color, 'string'),
                  'colorCartCounterFixed' => Data::coerce($this->plugin_settings['general']->cart_counter_fixed_color, 'string'),
                  'colorCartBackgroundFixed' => Data::coerce($this->plugin_settings['general']->cart_fixed_background_color, 'string')
               ],
               'products' => [],
               'collections' => [],
               'hasCurrencyCode' => Data::coerce($this->plugin_settings['general']->price_with_currency, 'bool'),
               'enableCustomCheckoutDomain' => Data::coerce($this->plugin_settings['general']->enable_custom_checkout_domain, 'bool'),
               'myShopifyDomain' => $this->getMyShopifyDomain(),
               'urlProducts' => Utils::get_site_url() . '/' . Data::coerce($this->plugin_settings['general']->url_products, 'string'),
               'urlCollections' => Utils::get_site_url() . '/' . Data::coerce($this->plugin_settings['general']->url_collections, 'string'),
               'checkoutButtonTarget' => Data::coerce($this->plugin_settings['general']->checkout_button_target, 'string'),
               'itemsLinkToShopify' => Data::coerce($this->plugin_settings['general']->products_link_to_shopify, 'bool'),
               'disableDefaultPages' => Data::coerce($this->plugin_settings['general']->disable_default_pages, 'bool'),
               'isLiteSync' => Data::coerce($this->plugin_settings['general']->is_lite_sync, 'bool'),
               'isSyncingPosts' => Data::coerce($this->plugin_settings['general']->is_syncing_posts, 'bool'),
               'searchBy' => Data::coerce($this->plugin_settings['general']->search_by, 'string'),
               'searchExactMatch' => Data::coerce($this->plugin_settings['general']->search_exact_match, 'bool'),
               'pricing' => [
                  'baseCurrencyCode' => Data::coerce($currency, 'string'),
                  'enableLocalCurrency' => Data::coerce($this->plugin_settings['general']->pricing_local_currency_toggle, 'bool')
               ],
               'currentLocale' => Server::get_current_locale(),
               'hidePagination' => Data::coerce($this->plugin_settings['general']->hide_pagination, 'bool'),
               'layout' => [
                  'alignHeight' => Data::coerce($this->plugin_settings['general']->align_height, 'bool'),
                  'globalNoticesDropzone' => apply_filters('wps_global_notices_dropzone', false)
               ],
               'pricingCurrencyDisplayStyle' => Data::coerce($this->plugin_settings['general']->currency_display_style, 'string'),
               'productsImagesSizingToggle' => Data::coerce($this->plugin_settings['general']->products_images_sizing_toggle, 'bool'),
               'productsImagesSizingWidth' => Data::coerce($this->plugin_settings['general']->products_images_sizing_width, 'int'),
               'productsImagesSizingHeight' => Data::coerce($this->plugin_settings['general']->products_images_sizing_height, 'int'),
               'productsImagesSizingCrop' => Data::coerce($this->plugin_settings['general']->products_images_sizing_crop, 'string'),
               'productsImagesSizingScale' => Data::coerce($this->plugin_settings['general']->products_images_sizing_scale, 'int'),

               'productsThumbnailImagesSizingToggle' => Data::coerce($this->plugin_settings['general']->products_thumbnail_images_sizing_toggle, 'bool'),
               'productsThumbnailImagesSizingWidth' => Data::coerce($this->plugin_settings['general']->products_thumbnail_images_sizing_width, 'int'),
               'productsThumbnailImagesSizingHeight' => Data::coerce($this->plugin_settings['general']->products_thumbnail_images_sizing_height, 'int'),
               'productsThumbnailImagesSizingCrop' => Data::coerce($this->plugin_settings['general']->products_thumbnail_images_sizing_crop, 'string'),
               'productsThumbnailImagesSizingScale' => Data::coerce($this->plugin_settings['general']->products_thumbnail_images_sizing_scale, 'int'),

               'productsImagesShowZoom' => Data::coerce($this->plugin_settings['general']->products_images_show_zoom, 'bool'),
               'collectionsImagesSizingToggle' => Data::coerce($this->plugin_settings['general']->collections_images_sizing_toggle, 'bool'),
               'collectionsImagesSizingWidth' => Data::coerce($this->plugin_settings['general']->collections_images_sizing_width, 'int'),
               'collectionsImagesSizingHeight' => Data::coerce($this->plugin_settings['general']->collections_images_sizing_height, 'int'),
               'collectionsImagesSizingCrop' => Data::coerce($this->plugin_settings['general']->collections_images_sizing_crop, 'string'),
               'collectionsImagesSizingScale' => Data::coerce($this->plugin_settings['general']->collections_images_sizing_scale, 'int'),
               'relatedProductsImagesSizingToggle' => Data::coerce($this->plugin_settings['general']->related_products_images_sizing_toggle, 'bool'),
               'relatedProductsImagesSizingWidth' => Data::coerce($this->plugin_settings['general']->related_products_images_sizing_width, 'int'),
               'relatedProductsImagesSizingHeight' => Data::coerce($this->plugin_settings['general']->related_products_images_sizing_height, 'int'),
               'relatedProductsImagesSizingCrop' => Data::coerce($this->plugin_settings['general']->related_products_images_sizing_crop, 'string'),
               'relatedProductsImagesSizingScale' => Data::coerce($this->plugin_settings['general']->related_products_images_sizing_scale, 'int'),
               'textdomain' => WP_SHOPIFY_PLUGIN_TEXT_DOMAIN
            ],
            'API' => [
               'namespace' => WP_SHOPIFY_SHOPIFY_API_NAMESPACE,
               'baseUrl' => site_url(),
               'urlPrefix' => rest_get_url_prefix(),
               'restUrl' => get_rest_url(),
               'nonce' => wp_create_nonce('wp_rest')
            ],
            'storefront' => [
               'domain' => $this->getMyShopifyDomain(),
               'storefrontAccessToken' => $this->getStorefrontAccessToken()
            ]
            
         ]);

      }
   }

   public function css_body_class($classes)
   {
      $classes[] = 'wpshopify';

      return $classes;
   }

   /*

	Only hooks not meant for public consumption

	*/
   public function hooks()
   {
      add_action('wp_enqueue_scripts', [$this, 'public_styles']);
      add_action('wp_enqueue_scripts', [$this, 'public_scripts'], 1);
      add_filter('body_class', [$this, 'css_body_class']);

   }

   /*

	Init

	*/
   public function init()
   {
      $this->hooks();
   }
}
