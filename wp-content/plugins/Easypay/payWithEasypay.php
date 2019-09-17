<?php 
require '../../../wp-config.php';

    $storeId = get_option('storeId');
    $daysToExpire = get_option('daysToExpire');
	
    $live = get_option('live');
	$liveVal = $live['menu'];
	$easypayIndexPage = '';
	if ($liveVal == 'no') {
		$easypayIndexPage = 'https://easypaystg.easypaisa.com.pk/easypay/Index.jsf';
	} else {
		$easypayIndexPage = 'https://easypay.easypaisa.com.pk/easypay/Index.jsf';
	}

    $merchantConfirmPage = home_url().'/wp-content/plugins/Easypay/confirmEasypay.php';

	$options = get_option('autoRedirect');
	//$autoRedirect = checked( isset( $options['autoRedirectCb'] ) );
    $autoRedirect = checked( isset( $options['autoRedirectCb'] ),1,false );	
	if($autoRedirect) {
		$autoRedirect = 1;
	} else {
		$autoRedirect = 0;
	}	
	
    $orderId = $_GET['orderId'];
	if (strpos($_GET['amount'], '.') !== false) {
		$amount = $_GET['amount'];
	} else {
		$amount = sprintf("%0.1f",$_GET['amount']);
	}
	
	$custEmail = $_GET['custEmail'];
	$custCell = $_GET['custCell'];
	$hashKey = get_option('hashKey');
	date_default_timezone_set('Asia/Karachi');
	$expiryDate = '';
	$currentDate = new DateTime();
	if($daysToExpire != null) {
		$currentDate->modify('+'.$daysToExpire.'day');
		$expiryDate = $currentDate->format('Ymd His');
	}
	
	$paymentMethods = get_option('paymentMethod');
	$paymentMethodVal = $paymentMethods['methods'];
	
	$hashRequest = '';
	if(strlen($hashKey) > 0 && (strlen($hashKey) == 16 || strlen($hashKey) == 24 || strlen($hashKey) == 32 )) {
		// Create Parameter map
		$paramMap = array();
		$paramMap['amount']  = $amount ;
		$paramMap['autoRedirect']  = $autoRedirect ;
		if($custEmail != null && $custEmail != '') {
			$paramMap['emailAddr']  = $custEmail ;
		}
		if($expiryDate != null && $expiryDate != '') {
			$paramMap['expiryDate'] = $expiryDate;
		}
		if($custCell != null && $custCell != '') {
			$paramMap['mobileNum'] = $custCell;
		}
		$paramMap['orderRefNum']  = $orderId ;
		
		if($paymentMethodVal != null && $paymentMethodVal != '') {
			$paramMap['paymentMethod']  = $paymentMethodVal ;
		}		
		$paramMap['postBackURL'] = $merchantConfirmPage;
		$paramMap['storeId']  = $storeId ;
		
		//Creating string to be encoded
		$mapString = '';
		foreach ($paramMap as $key => $val) {
			$mapString .=  $key.'='.$val.'&';
		}
		$mapString  = substr($mapString , 0, -1);
		
		// Encrypting mapString
		function pkcs5_pad($text, $blocksize) {
			
			$pad = $blocksize - (strlen($text) % $blocksize);
			return $text . str_repeat(chr($pad), $pad);
			
		}

		$alg = MCRYPT_RIJNDAEL_128; // AES
		$mode = MCRYPT_MODE_ECB; // ECB

		$iv_size = mcrypt_get_iv_size($alg, $mode);
		$block_size = mcrypt_get_block_size($alg, $mode);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);	

		$mapString = pkcs5_pad($mapString, $block_size);
		$crypttext = mcrypt_encrypt($alg, $hashKey, $mapString, $mode, $iv);
		$hashRequest = base64_encode($crypttext);
	}
	
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
    if (!$con) {
            die('Could not connect: ' . mysqli_errno());    
    }     
    mysqli_select_db($con, DB_NAME);
	global $wpdb;
	$table_name = $wpdb->prefix . 'easypay_order';
	
    // mysql inserting an order with pending status
    $query = "INSERT INTO ".$table_name."( easypay_order_id, easypay_order_info, easypay_order_status, ipn_attr ) VALUES ('$orderId' ,'null',  'pending',  'null')";
    try {
        mysqli_query($con, $query);
    } catch (Exception $ex) {            
        error_log($ex->getMessage());
    }

?>

<form name="easypayform" method="post" action="<?php echo $easypayIndexPage ?>">
    <input name="storeId" value="<?php echo $storeId ?>" hidden = "true"/>
    <input name="amount" value="<?php echo $amount ?>" hidden = "true"/>
    <input name="postBackURL" value="<?php echo $merchantConfirmPage ?>" hidden = "true"/>
    <input name="orderRefNum" value="<?php echo $orderId ?>" hidden = "true"/>
	<?php if ($expiryDate != '' && $expiryDate != null) { ?>
		<input name="expiryDate" value="<?php echo $expiryDate ?>" hidden = "true"/>
	<?php } ?>	
	<input name="autoRedirect" value="<?php echo $autoRedirect ?>" hidden = "true"/>
	<input name="emailAddr" value="<?php echo $custEmail ?>" hidden = "true"/>
	<input name="mobileNum" value="<?php echo $custCell ?>" hidden = "true"/>
	<input name="merchantHashedReq" value="<?php echo $hashRequest ?>" hidden = "true"/>
	<input name="paymentMethod" value="<?php echo $paymentMethodVal ?>" hidden = "true"/>
</form>

<script data-cfasync="false" type="text/javascript">
    document.easypayform.submit();
</script>
