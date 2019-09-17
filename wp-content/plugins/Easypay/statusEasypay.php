<?php 
require '../../../wp-config.php';

    $status = $_GET['status'];
    $orderRefNumber = $_GET ['orderRefNumber'];

    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
    if (!$con) {
        die('Could not connect: ' . mysqli_errno());    
    }     
    mysqli_select_db($con, DB_NAME);
	global $wpdb;
	$table_name = $wpdb->prefix . 'easypay_order';
	
    if ($status == '0000') {       
        $query = "UPDATE ".$table_name." SET easypay_order_status='success' WHERE easypay_order_id='".$orderRefNumber."'";
    } else if ($status == '0001') {
        $query = "UPDATE ".$table_name." SET easypay_order_status='failed' WHERE easypay_order_id='".$orderRefNumber."'";
		$order = wc_get_order($orderRefNumber);
		$order->update_status('failed');
    }

    try {
        mysqli_query($con, $query);
		wp_redirect( home_url() );
    } catch (Exception $ex) {            
        error_log($ex->getMessage());
    }  
