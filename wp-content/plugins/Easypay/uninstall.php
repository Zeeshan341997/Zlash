<?php
		
	if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		exit;
	}
	global $wpdb;
	$table_name = $wpdb->prefix . 'easypay_order';
	$sql = 'DROP TABLE IF EXISTS '.$table_name;
	$wpdb->query( $sql );
	wp_cache_flush();
?>