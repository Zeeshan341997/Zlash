<?php
require '../../../wp-config.php';

    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
    if (!$con) {
        die('Could not connect: ' . mysqli_errno());    
    }     
    mysqli_select_db($con, DB_NAME);

    if (isset($_GET["url"])) {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $_GET["url"]); 
        $output=curl_exec($curl);
		global $wpdb;
		$table_name = $wpdb->prefix . 'easypay_order';

        if($output != null) {

			$orderRefNumber = substr($_GET['url'], strrpos($_GET['url'], '/') + 1);
            $query = "UPDATE ".$table_name." SET ipn_attr='".$output."' WHERE easypay_order_id='".$orderRefNumber."'";
            
			$order = wc_get_order($orderRefNumber);
			
			$jsonResponse = json_decode($output, true);
			if(isset($jsonResponse['transaction_status'])) {
				$transStatus = $jsonResponse['transaction_status'];
				if ($transStatus == 'DROPPED' || $transStatus == 'FAILED' || $transStatus == 'EXPIRED') {
					$order->update_status('failed');
				}
				if ($transStatus == 'PAID') {
					$order->update_status('completed');
				}
			}
			
			try {
                mysqli_query($con, $query);
				echo "Response is saved ";
            } catch (Exception $ex) {            
                error_log($ex->getMessage());
            }		          
        }
        curl_close($curl);
    }
    else {
            echo "Welcome!! Enter url to get data :";
    }



