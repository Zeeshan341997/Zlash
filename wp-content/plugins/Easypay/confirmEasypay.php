<?php

require '../../../wp-config.php';
$merchantStatusPage = home_url().'/wp-content/plugins/Easypay/statusEasypay.php';


$easypayConfirmPage = '';
$live = get_option('live');
$liveVal = $live['menu'];
if ($liveVal == 'no') {
	$easypayConfirmPage = 'https://easypaystg.easypaisa.com.pk/easypay/Confirm.jsf';
} else {
	$easypayConfirmPage = 'https://easypay.easypaisa.com.pk/easypay/Confirm.jsf';
}
?>

<form name="easypayconfirmform" action="<?php echo $easypayConfirmPage ?>" method="POST">
    <input name="auth_token" value="<?php echo $_GET['auth_token'] ?>" hidden = "true"/>
    <input name="postBackURL" value="<?php echo $merchantStatusPage ?>" hidden = "true"/>	
</form>

<script data-cfasync="false" type="text/javascript">
    document.easypayconfirmform.submit();
</script>