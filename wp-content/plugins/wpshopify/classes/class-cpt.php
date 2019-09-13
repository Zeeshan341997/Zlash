<?php

namespace WP_Shopify;

use WP_Shopify\Utils;
use WP_Shopify\Utils\Data as Utils_Data;
use WP_Shopify\Transients;

if (!defined('ABSPATH')) {
	exit;
}


class CPT {

	private $plugin_settings;
	private $DB_Products;
	private $DB_Collections_Custom;
	private $DB_Collections_Smart;
	private $DB_Collects;
	private $DB_Tags;


	/*

	Initialize the class and set its properties.

	*/
	public function __construct($plugin_settings, $DB_Products, $DB_Collections_Custom, $DB_Collections_Smart, $DB_Collects, $DB_Tags) {

		$this->plugin_settings						= $plugin_settings;
		$this->DB_Products										= $DB_Products;
		$this->DB_Collections_Custom					= $DB_Collections_Custom;
		$this->DB_Collections_Smart						= $DB_Collections_Smart;
		$this->DB_Collects										= $DB_Collects;
		$this->DB_Tags												= $DB_Tags;

	}


	public static function add_meta_to_cpt($posts) {

		return array_map(function($post) {

			$post->post_meta = get_post_meta($post->ID);

			return $post;

		}, $posts);

	}


	public static function get_post_name($data) {

		if ( !empty($data->product->post_name) ) {
			$post_name = $data->product->post_name;

		} else {
			$post_name = $data->product->handle;
		}

		return $post_name;

	}


	public static function get_all_posts($post_type) {

		return get_posts([
			'posts_per_page' 		=> -1,
			'post_type' 				=> $post_type,
			'nopaging' 					=> true
		]);

	}


	public static function get_all_posts_by_type($post_type) {
		return self::add_meta_to_cpt( self::get_all_posts($post_type) );
	}

	public static function get_all_posts_compressed($post_type) {
		return self::truncate_post_data( self::get_all_posts($post_type) );
	}

	public static function only_id_and_post_name($post) {

		return [
			'ID'					=> $post->ID,
			'post_name'		=> $post->post_name
		];

	}

	public static function truncate_post_data($posts) {
		return array_map([__CLASS__, 'only_id_and_post_name'], $posts);
   }
   
   
   public function has_archive() {

      if (empty($this->plugin_settings['general']) || !isset($this->plugin_settings['general']->disable_default_pages)) {
         return false;
      }

      return !Utils_Data::coerce($this->plugin_settings['general']->disable_default_pages, 'bool');

   }


	/*

	CPT: Products

	*/
	public function post_type_products() {

		if (post_type_exists(WP_SHOPIFY_PRODUCTS_POST_TYPE_SLUG)) {
			return;
      }

      $products_slug = $this->plugin_settings['general']->url_products;

		// If falsey or not an object ...
		if (!$products_slug) {
			$permalink = 'products';

		} else {
			$permalink = $products_slug;
		}

		$labels = [
			'name'                => _x('Products', 'Post Type General Name', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'singular_name'       => _x('Product', 'Post Type Singular Name', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'menu_name'           => __('Products', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'parent_item_colon'   => __('Parent Item:', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'new_item'            => __('Add New Product', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'edit_item'           => __('Edit Product', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'not_found'           => __('No Products found', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'not_found_in_trash'  => __('No Products found in trash', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN)
		];

		$args = [
			'label'               => __('Products', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'description'         => __('Custom Post Type for Products', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'labels'              => $labels,
			'supports'            => array('title', 'page-attributes', 'editor', 'custom-fields', 'comments', 'thumbnail'),
			'taxonomies'					=> ['category'],
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'menu_position'       => 100,
			'menu_icon'           => 'dashicons-megaphone',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => $this->has_archive(),
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'rewrite'             => [
				'slug' => $permalink
			],
			'capabilities' => [
			  'create_posts' => false
			],
			'map_meta_cap' => true
      ];
      
		register_post_type(WP_SHOPIFY_PRODUCTS_POST_TYPE_SLUG, apply_filters('wps_register_products_args', $args));
      
   }
   
   /*

	CPT: Orders

	*/
	// public function post_type_orders() {

	// 	if (post_type_exists(WP_SHOPIFY_ORDERS_POST_TYPE_SLUG)) {
	// 		return;
   //    }

	// 	$labels = [
	// 		'name'                => _x('Orders', 'Post Type General Name', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
	// 		'singular_name'       => _x('Order', 'Post Type Singular Name', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
	// 		'menu_name'           => __('Orders', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
	// 		'parent_item_colon'   => __('Parent Item:', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
	// 		'new_item'            => __('Add New Order', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
	// 		'edit_item'           => __('Edit Order', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
	// 		'not_found'           => __('No Orders found', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
	// 		'not_found_in_trash'  => __('No Orders found in trash', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN)
	// 	];

	// 	$args = [
	// 		'label'               => __('Orders', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
	// 		'description'         => __('Custom Post Type for Orders', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
	// 		'labels'              => $labels,
	// 		'supports'            => array('title', 'page-attributes', 'editor', 'custom-fields', 'comments', 'thumbnail'),
	// 		'taxonomies'					=> ['category'],
	// 		'hierarchical'        => false,
	// 		'public'              => true,
	// 		'show_ui'             => true,
	// 		'show_in_menu'        => false,
	// 		'menu_position'       => 100,
	// 		'menu_icon'           => 'dashicons-megaphone',
	// 		'show_in_admin_bar'   => true,
	// 		'show_in_nav_menus'   => true,
	// 		'can_export'          => true,
	// 		'has_archive'         => !Utils_Data::coerce($this->plugin_settings['general']->disable_default_pages, 'bool'),
	// 		'exclude_from_search' => false,
	// 		'publicly_queryable'  => true,
	// 		'capability_type'     => 'post',
	// 		'rewrite'             => [
	// 			'slug' => 'orders'
	// 		],
	// 		'capabilities' => [
	// 		  'create_posts' => false
	// 		],
	// 		'map_meta_cap' => true
   //    ];
      
	// 	register_post_type(WP_SHOPIFY_ORDERS_POST_TYPE_SLUG, apply_filters('wps_register_orders_args', $args));

	// }


	/*

	CPT: Collections

	*/
	public function post_type_collections() {

		if ( post_type_exists(WP_SHOPIFY_COLLECTIONS_POST_TYPE_SLUG) ) {
			return;
		}

		$collections_slug = $this->plugin_settings['general']->url_collections;

		// If falsey or not an object ...
		if (!$collections_slug) {
			$permalink = 'collections';

		} else {
			$permalink = $collections_slug;
		}


		$labels = [
			'name'                => _x('Collections', 'Post Type General Name', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'singular_name'       => _x('Collection', 'Post Type Singular Name', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'menu_name'           => __('Collections', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'parent_item_colon'   => __('Parent Item:', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'new_item'            => __('Add New Collection', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'edit_item'           => __('Edit Collection', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'not_found'           => __('No Collections found', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'not_found_in_trash'  => __('No Collections found in trash', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN)
      ];

		$args = [
			'label'               => __('Collections', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'description'         => __('Custom Post Type for Collections', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
			'labels'              => $labels,
			'supports'            => array('title', 'page-attributes', 'editor', 'custom-fields', 'comments', 'thumbnail'),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'menu_position'       => 100,
			'menu_icon'           => 'dashicons-megaphone',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'rewrite'             => [
				'slug' => $permalink
			],
			'capabilities' => [
			  'create_posts' => false
			],
			'map_meta_cap' => true
      ];

		register_post_type(WP_SHOPIFY_COLLECTIONS_POST_TYPE_SLUG, apply_filters('wps_register_collections_args', $args));

	}


	/*

	Find Latest Menu Order

	*/
	public static function wps_find_latest_menu_order($type) {

		global $post;

		$args = array(
			'post_type'       => 'wps_' . $type,
			'posts_per_page'  => 1,
		);

		$posts = get_posts($args);

		if (is_array($posts) && empty($posts)) {
			return 1;

		} else {
			return $posts[0]->menu_order + 1;
		}

	}


	/*

	$product_or_collection = Array

	*/
	public static function find_existing_post_id($product_or_collection) {

		if (is_array($product_or_collection) && !empty($product_or_collection)) {

			$product_or_collection = Utils::get_first_array_item($product_or_collection);

			return $product_or_collection->ID;

		} else {
			return false;

		}

	}


	/*

	Returns an array containing only products / collections that match the passed in ID.

	*/
	public static function find_only_existing_posts($existing_items, $item_id, $post_type = '') {

		return array_filter($existing_items, function($existing_item) use ($item_id, $post_type) {

			if (isset($existing_item->post_meta[$post_type . '_id']) && is_array($existing_item->post_meta[$post_type . '_id'])) {
				return $existing_item->post_meta[$post_type . '_id'][0] == $item_id;
			}

		});

	}


	/*

	Adds the post ID if one exists. Used for building the product / collections model

	*/
	public static function set_post_id_if_exists($model, $existing_post_id) {

		if (!empty($existing_post_id)) {
			$model['ID'] = $existing_post_id;
		}

		return $model;

	}


	/*

	Post exists

	*/
	public static function post_exists_by_handle($posts, $post_handle) {
		return in_array($post_handle, array_column($posts, 'post_name'));
	}


	/*

	At this point the $savedCollections contains only collection IDs that are NEW.
	We need to now create the proper collects row connection

	*/
	public function add_collects_to_post($saved_collections, $product) {

		$insertion_results = [];

		foreach ($saved_collections as $new_saved_collection_id => $value) {

			$product_id = (int) $product->product_id;
			$number_string_1 = (int) substr(strval($new_saved_collection_id), 0, -4);
			$number_string_2 = (int) substr(strval($product_id), 0, -4);

			$collect = [
				'collect_id'           => $number_string_1 . $number_string_2 . 1111,
				'product_id'           => $product->product_id,
				'collection_id'        => $new_saved_collection_id,
				'featured'             => '',
				'position'             => '',
				'sort_value'           => '',
				'created_at'           => date_i18n( 'Y-m-d H:i:s' ),
				'updated_at'           => date_i18n( 'Y-m-d H:i:s' )
			];

			// Inserts any new collects
			$insertion_results[] = $this->DB_Collects->insert_collect($collect);

		}

		return $insertion_results;

	}


	/*

	At this point the $savedCollections contains only collection IDs that are NEW.
	We need to now create the proper collects row connection

	*/
	public function add_tags_to_post($saved_tags, $product) {

		$insertion_results = [];

		foreach ($saved_tags as $saved_tag => $saved_tag_value) {

			$product_id = (int) $product->product_id;
			$numberString1 = (int) ord($saved_tag);
			$numberString2 = (int) substr(strval($product_id), 0, -4);

			$product->id = $product->product_id;

			$final_tags_to_add = $this->DB_Tags->add_tag_id_to_tag( $this->DB_Tags->construct_tag_model($saved_tag, $product, $product->post_id) );

			// Inserts any new tags
			$insertion_results[] = $this->DB_Tags->insert_tag( $final_tags_to_add );

		}

		return $insertion_results;

	}



	/*

	Removing collects row from post

	*/
	public function remove_collects_from_post($collects_to_remove) {

		$removalResult = [];

		foreach ($collects_to_remove as $collect_id) {
			$removalResult[] = $this->DB_Collects->delete_rows_in($this->DB_Collects->lookup_key, $collect_id);
		}

		return $removalResult;

	}


	/*

	Removing tags row from post

	*/
	public function remove_tags_from_post($tags_to_remove) {

		$removalResult = [];

		foreach ($tags_to_remove as $key => $tag_id) {

			$removalResult[] = $this->DB_Tags->delete_rows_in($this->DB_Tags->lookup_key, $tag_id);

		}

		return $removalResult;

	}

	/*

	Creating array of collects to potentially remove

	*/
	public function find_items_to_add($current_items, $saved_items) {

		foreach ($current_items as $key => $current_item) {

			if (isset($current_item->collection_id) && $current_item->collection_id) {

				if (isset($saved_items[$current_item->collection_id])) {
					unset($saved_items[$current_item->collection_id]);
				}

			}

			if (isset($current_item->tag) && $current_item->tag) {
				if (isset($saved_items[$current_item->tag])) {
					unset($saved_items[$current_item->tag]);
				}

			}

		}

		return $saved_items;

	}



	public function found_item_to_remove($current_item_id, $saved_items) {
		return in_array($current_item_id, $saved_items, true);
	}


	/*

	Creating array of collects to potentially remove

	*/
	public function find_items_to_remove($current_items, $saved_items) {

		$current_items_orig = Utils::convert_to_assoc_array($current_items);
		$current_items_to_remove = [];


		foreach ($current_items_orig as $current_item) {

			// Collects
			if ( !empty($current_item['collection_id']) ) {

				if ( !$this->found_item_to_remove($current_item['collection_id'], $saved_items) ) {
					$current_items_to_remove[] = $current_item['collect_id'];
				}

			}

			// Tags
			if ( !empty($current_item['tag_id']) ) {

				if ( !$this->found_item_to_remove($current_item['tag_id'], $saved_items) ) {
					$current_items_to_remove[] = $current_item['tag_id'];
				}

			}

		}


		return $current_items_to_remove;

	}

   
	/*

	Find the WP Post ID of the product being updated

	*/
	public static function find_existing_post_id_from_collection($existing_collections, $collection) {

		$found_post = self::find_only_existing_posts($existing_collections, $collection->{WP_SHOPIFY_SHOPIFY_PAYLOAD_KEY}, 'collection');
		$found_post_id = self::find_existing_post_id($found_post);

		return $found_post_id;

	}


	/*

	Find the WP Post ID of the product being updated

	*/
	public static function find_existing_post_id_from_product($existing_products, $product) {

		$product_id = Utils::find_product_id($product);

		$found_post = self::find_only_existing_posts($existing_products, $product_id, 'product');
		$found_post_id = self::find_existing_post_id($found_post);

		return $found_post_id;

	}


	public static function num_of_posts($type) {
		return Utils_Data::add_totals( array_values( get_object_vars( wp_count_posts($type) ) ) );
	}


	/*

	Checks whether any posts of a given type exist or not

	*/
	public static function posts_exist($type) {

		if (self::num_of_posts($type) > 0) {
			return true;

		} else {
			return false;
		}

	}










	function get_shopify_featured_image() {

	}

	function has_existing_featured_image() {

	}



	function wp_get_attachment_image_attributes_filter($attr, $attachment, $size) {

		global $post;

		$media = get_attached_media('image', $post->ID);
		$post_type = get_post_type($post->ID);


		if ($post_type !== 'wps_products' && $post_type !== 'wps_collections') {
			return $attr;
		}

		return $attr;

	}


	public function post_thumbnail_html_filter($html, $post_ID, $post_thumbnail_id, $size, $attr) {

		if (!empty($html)) {
			return $html;
		}

		$post_type = get_post_type($post_ID);

		if ($post_type !== 'wps_products' && $post_type !== 'wps_collections') {
			return $html;
		}

	}


	/*

	Grabs the current author ID

	*/
	public static function return_author_id() {

		if (get_current_user_id() === 0) {
			$author_id = 1;

		} else {
			$author_id = get_current_user_id();
		}

		return intval($author_id);

	}


	/*

	Responsible for assigning a post_id to a post

	*/
	public static function set_post_id($post, $post_id) {

		$post->post_id = $post_id;

		return $post;

	}


	public static function get_all_posts_truncated($post_type, $inclusions) {
		return Utils::lessen_array_by( CPT::get_all_posts($post_type), $inclusions);
	}





	public static function add_props($item, $props) {

		foreach ($props as $key => $value) {
			$item->{$key} = $value;
		}

		return $item;

	}

	public static function add_props_to_items($items, $props) {

		return array_map(function ($item) use ($props) {
	    return self::add_props($item, $props);
		}, $items);

	}



	/*

	Hooks

	*/
	public function hooks() {

		add_action('init', [$this, 'post_type_products']);
		add_action('init', [$this, 'post_type_collections']);

	}


	/*

	Register

	*/
	public function init() {
		$this->hooks();
	}


}
