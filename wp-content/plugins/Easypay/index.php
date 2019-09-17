<?php
/*
Plugin Name: Easypay
Plugin URI: https://easypay.easypaisa.com.pk
Description: Pay via Easypay
Version: 0.1
Author: Systems Limited
Author URI: https://www.systemsltd.com/
*/

add_action("admin_init", "display_easypay_panel_fields");
add_action("admin_menu", "add_easypay_menu_item");
add_action('plugins_loaded', 'init_pay_via_easypay');
register_activation_hook( __FILE__, 'create_table' ); // Creates the table as soon as plugin is acitavted

function create_table() {

	global $wpdb;
	$table_name = $wpdb->prefix . 'easypay_order';
	
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$sql = "CREATE TABLE  ".$table_name." (
			`easypay_id` int(11) NOT NULL AUTO_INCREMENT,
			`easypay_order_id` varchar(50) NOT NULL,
			`easypay_order_info` varchar(50) DEFAULT NULL,
			`easypay_order_status` varchar(50) DEFAULT NULL,
			`ipn_attr` varchar(500) DEFAULT NULL, 
			PRIMARY KEY (`easypay_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42;";
		
		$wpdb->query($sql);
	}
}
function checkout_settings_page() {
    ?>
        <div class="wrap">
        <h1>Easypay</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields("section");
                do_settings_sections("easypay-options");      
                submit_button(); 
            ?>          
        </form>
        </div>
    <?php
}

function add_easypay_menu_item() {
    add_menu_page("Easypay Panel", "Easypay Panel", "manage_options", "easypay-panel", "checkout_settings_page", null, 99);
}

function display_storeId_element() {
    ?>
    	<input type="text" name="storeId" id="storeId" value="<?php echo get_option('storeId') ?>" />
    <?php
}

function display_daysToExpire_element() {
    ?>
    	<input type="text" name="daysToExpire" id="daysToExpire" value="<?php echo get_option('daysToExpire') ?>" />
    <?php
}

function display_autoRedirect_element() {
    ?>			
    	<?php $options = get_option('autoRedirect');?>
		<input type="checkbox" name="autoRedirect[autoRedirectCb]" id="autoRedirect" value= "1" <?php checked( isset( $options['autoRedirectCb'])); ?> />		
    <?php	
}

function display_hashKey_element() {
    ?>
    	<input type="text" name="hashKey" id="hashKey" value="<?php echo get_option('hashKey') ?>" />
    <?php
}

function display_paymentMethod_element() {
	?>
		<?php $options = get_option('paymentMethod');?>
		<select name="paymentMethod[methods]" id="paymentMethod" >
		  <option value="">All</option>
		  <option value="CC_PAYMENT_METHOD" <?php if ( 'CC_PAYMENT_METHOD' == $options['methods'] ) echo 'selected="selected"'; ?>>Credit Card</option>
		  <option value="MA_PAYMENT_METHOD" <?php if ( 'MA_PAYMENT_METHOD' == $options['methods'] ) echo 'selected="selected"'; ?>>Mobile Account</option>
		  <option value="OTC_PAYMENT_METHOD" <?php if ( 'OTC_PAYMENT_METHOD' == $options['methods'] ) echo 'selected="selected"'; ?>>Over the counter</option>
		</select>
	<?php
}

function display_live_element() {
	?>
		<?php $list = get_option('live');?>
		<select name="live[menu]" id="live" >
		  <option value="no" <?php if ( 'no' == $list['menu'] ) echo 'selected="selected"'; ?>>No</option>
		  <option value="yes"<?php if ( 'yes' == $list['menu'] ) echo 'selected="selected"'; ?>>Yes</option>
		</select>
	<?php
}


function display_easypay_panel_fields() {
	
    add_settings_section("section", "Update Settings", null, "easypay-options");	
    add_settings_field("storeId", "Store Id :", "display_storeId_element", "easypay-options", "section");
    add_settings_field("daysToExpire", "Merchant's Token Expiry Days :", "display_daysToExpire_element", "easypay-options", "section");
	add_settings_field("autoRedirect", "Auto Re-direct :", "display_autoRedirect_element", "easypay-options", "section");
	add_settings_field("hashKey", "Hash Key :", "display_hashKey_element", "easypay-options", "section");
	add_settings_field("paymentMethod", "Payment Method :", "display_paymentMethod_element", "easypay-options", "section");
	add_settings_field("live", "Live :", "display_live_element", "easypay-options", "section");
	

    register_setting("section", "storeId");
    register_setting("section", "daysToExpire");
	register_setting("section", "autoRedirect");
	register_setting("section", "hashKey");
	register_setting("section", "paymentMethod");
	register_setting("section", "live");
	
}
    
function init_pay_via_easypay() {

	class Easypay_Payment_Gateway extends WC_Payment_Gateway {

        public function __construct() {
            $this->id = 'easypay';
            $this->has_fields = true;
            $this->method_title = 'Pay via Easypay';
            $this->method_description = 'Easypay payment method by Telenor Easypaisa';

            $this->init_form_fields();
            $this->init_settings();

           $this->title = 'Pay via Easypay';
		   //$this->title = $this->settings['title'];
           $this->description = 'Pay via Easypay';
		   //$this->description = $this->settings['description'];
		   add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( &$this, 'process_admin_options' ) );
			
        }

        function init_form_fields() {
						
            $this -> form_fields = array(
                'enabled' => array(
                    'title' => __('Enable/Disable', 'easypay_payment_gateway'),
                    'type' => 'checkbox',
                    'label' => __('Enable Easypay Payment Module.', 'easypay_payment_gateway'),
                    'default' => 'yes'
                ),
                'title' => array(
                    'title' => __('Title', 'easypay_payment_gateway'),
                    'type' => 'text',
                    'description' => __( 'This controls the title which the user sees during checkout.', 'easypay_payment_gateway' ),
                    'default' => __( 'Pay via Easypay', 'easypay_payment_gateway' ),
                    'desc_tip' => true,
                )
            );
        }
	
        public function payment_fields() {			
            ?>
                <label><?php echo __( 'Pay via Easypay', 'easypay_payment_gateway') ?></label>
            <?php  
        } 
                
        /*Get Easypay Icon*/
        public function get_icon() {
            $icon = '';
            if ( $url = $this->get_payment_method_image_url() ) {
                $icon .= '<img src="'.esc_url( $url ).'" alt="'.esc_attr('easypay').'" />';
            }

            return apply_filters( 'woocommerce_easypay_icon', $icon, $this->id );
        }

        public function get_payment_method_image_url() {
            return  WC_HTTPS::force_https_url( plugins_url( 'images/easy-pay-logo.png' , __FILE__ ) ); 
        }
        /*Get Easypay Icon*/

        function admin_options() {
            ?>
            <h2><?php _e('Your plugin name','easypay'); ?></h2>
            <table class="form-table">
            <?php $this->generate_settings_html(); ?>
            </table> <?php
        }

        function process_payment($order_id) {
            global $woocommerce;
			
            $order = new WC_Order($order_id);
            $order->update_status('on-hold', __( 'Awaiting cheque payment', 'woocommerce' ));
            $order->reduce_order_stock();
            $totalamount = $woocommerce->cart->total;
			$custEmail = $order->billing_email;
			$custCell =  $order->billing_phone;
			//$testAmt = floatval( preg_replace( '#[^\d.]#', '', $woocommerce->cart->get_cart_total() ) );
			$woocommerce->cart->empty_cart();
            return $this->receipt_page($order_id, $totalamount, $custEmail, $custCell);
        }

        function receipt_page($order_id, $totalamount, $custEmail, $custCell) {

			$homeUrl = home_url();
			return array('result' => 'success', 
							  'redirect' => $homeUrl.'/wp-content/plugins/Easypay/payWithEasypay.php?orderId='.$order_id.'&amount='.$totalamount.'&custEmail='.$custEmail.'&custCell='.$custCell);

        }
    }

    function register_easypay_pg($methods) {
        $methods[] = 'Easypay_Payment_Gateway';
        return $methods;
    }

    add_filter('woocommerce_payment_gateways', 'register_easypay_pg');
}