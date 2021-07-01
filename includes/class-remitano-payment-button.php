<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // exit if accessed directly.
}

class Remitano_Payment_Button {
	public function __construct() {
		$this->enqueue_remitano_js();
		$this->add_admin_options_page();
		$this->add_short_code();
	}

	public function enqueue_remitano_js() {
		wp_enqueue_script( 'remitano_payment_button', 'https://remitano.com/lib/payment-gateway/v1/checkout.js', null, null, false );
	}

	public function add_admin_options_page() {
		add_action( 'admin_menu', array( $this, 'options_page' ) );
	}

	public function options_page() {
		add_menu_page(
			'Remitano Payment Button',
			'Remitano Payment Button',
			'manage_options',
			'remitano-payment-button',
			array( $this, 'options_page_html' )
		);
	}

	public function options_page_html() {
		include REMI_PAYMENT_BUTTON_PLUGIN_PATH . 'templates/options-page.php';
	}

	public function add_short_code() {

	}

}
