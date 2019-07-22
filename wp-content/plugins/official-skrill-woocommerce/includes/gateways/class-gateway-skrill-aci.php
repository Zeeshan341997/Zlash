<?php
/**
 * Skrill Cash / Invoice
 *
 * This gateway is used for Skrill Cash / Invoice.
 * Copyright (c) Skrill
 *
 * @class       Gateway_Skrill_ACI
 * @extends     Skrill_Payment_Gateway
 * @package     Skrill/Classes
 * @located at  /includes/gateways
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Gateway_Skrill_ACI
 */
class Gateway_Skrill_ACI extends Skrill_Payment_Gateway {

	/**
	 * Id
	 *
	 * @var string
	 */
	public $id = 'skrill_aci';

	/**
	 * Payment method logo
	 *
	 * @var string
	 */
	public $payment_method_logo = 'red-link.png,pago-facil.png,boleto-bancario.png,servi-pag.png,efecty.png,davivienda.png,exito.png,banco-de-occidente.png,carulla.png,edeq.png,surtimax.png,bancomer_m.png,oxxo.png,banamex.png,santander.png,red-pagos.png';

	/**
	 * Payment method
	 *
	 * @var string
	 */
	public $payment_method = 'ACI';

	/**
	 * Payment brand
	 *
	 * @var string
	 */
	public $payment_brand = 'ACI';

	/**
	 * Allowed countries
	 *
	 * @var array
	 */
	protected $allowed_countries = array( 'ARG', 'BRA', 'CHL', 'CHN', 'COL', 'MEX', 'PER', 'URY' );

	/**
	 * Payment method description
	 *
	 * @var string
	 */
	public $payment_method_description = 'Argentina, Brazil, Chile, China, Columbia, Mexico, Peru, Uruguay';

	/**
	 * Get payment title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Cash/invoice', 'wc-skrill' );
	}
}

$obj = new Gateway_Skrill_ACI();
