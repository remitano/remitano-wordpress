<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // exit if accessed directly.
}

class Remitano_Payment_Button {
	private $remitano_payment_button_options;

	public function __construct() {
		wp_enqueue_script( 'remitano_payment_button', REMI_PAYMENT_BUTTON_PLUGIN_URL . '/assets/javascripts/remitano-payment-button.js' , null, null, true );
		add_action( 'admin_menu', array( $this, 'remitano_payment_button_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'remitano_payment_button_page_init' ) );
		add_shortcode( 'remitano-payment-button', array( $this, 'payment_button_shortcode' ) );
	}

	public function payment_button_shortcode($atts) {
		$options = get_option( 'remitano_payment_button_options');
		$atts = shortcode_atts( array(
			'button-style' => $options['default_button_style'],
			'redirect-url' => '',
			'currency' => $options['default_currency'],
			'amount' => "0",
			'description' => "",
		), $atts, 'payment_button_atts' );

		ob_start();
		include 'templates/shortcode.php';
		$output = ob_get_clean();

		return $output;
	}

	public function remitano_payment_button_add_plugin_page() {
		add_menu_page(
			'Remitano Payment Button',
			'Remitano Payment Button',
			'manage_options',
			'remitano-payment-button',
			array( $this, 'remitano_payment_button_create_admin_page' ), // function
			'dashicons-admin-generic',
			81
		);
	}

	public function remitano_payment_button_create_admin_page() {
		$this->remitano_payment_button_options = get_option( 'remitano_payment_button_options' );
		include 'templates/settings.php';
	}

	public function remitano_payment_button_page_init() {
		register_setting(
			'remitano_payment_button_option_group', // option_group
			'remitano_payment_button_options', // option_name
			array( $this, 'remitano_payment_button_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'remitano_payment_button_setting_section', // id
			'Settings', // title
			array( $this, 'remitano_payment_button_section_info' ), // callback
			'remitano-payment-button-admin' // page
		);

		add_settings_field(
			'merchant_username', // id
			'Your Merchant username', // title
			array( $this, 'merchant_username_callback' ), // callback
			'remitano-payment-button-admin', // page
			'remitano_payment_button_setting_section' // section
		);

		add_settings_field(
			'enable_sandbox', // id
			'Enable Sandbox Mode', // title
			array( $this, 'enable_sandbox_callback' ), // callback
			'remitano-payment-button-admin', // page
			'remitano_payment_button_setting_section' // section
		);

		add_settings_field(
			'default_button_style', // id
			'Default Button Style', // title
			array( $this, 'default_button_style_callback' ), // callback
			'remitano-payment-button-admin', // page
			'remitano_payment_button_setting_section' // section
		);

		add_settings_field(
			'default_currency', // id
			'Default Currency', // title
			array( $this, 'default_currency_callback' ), // callback
			'remitano-payment-button-admin', // page
			'remitano_payment_button_setting_section' // section
		);
	}

	public function remitano_payment_button_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['merchant_username'] ) ) {
			$sanitary_values['merchant_username'] = sanitize_text_field( $input['merchant_username'] );
		}

		if ( isset( $input['enable_sandbox'] ) ) {
			$sanitary_values['enable_sandbox'] = $input['enable_sandbox'];
		}

		if ( isset( $input['default_button_style'] ) ) {
			$sanitary_values['default_button_style'] = $input['default_button_style'];
		}

		if ( isset( $input['default_currency'] ) ) {
			$sanitary_values['default_currency'] = $input['default_currency'];
		}

		return $sanitary_values;
	}

	public function remitano_payment_button_section_info() {

	}

	public function merchant_username_callback() {
		printf(
			'<input class="regular-text" type="text" name="remitano_payment_button_options[merchant_username]" id="merchant_username" value="%s">',
			isset( $this->remitano_payment_button_options['merchant_username'] ) ? esc_attr( $this->remitano_payment_button_options['merchant_username']) : ''
		);
	}

	public function enable_sandbox_callback() {
		printf(
			'<input type="checkbox" name="remitano_payment_button_options[enable_sandbox]" id="enable_sandbox" value="enable_sandbox" %s> <label for="enable_sandbox">Check if you are testing your payment button in sandbox mode with https://remidemo.com.</label>',
			( isset( $this->remitano_payment_button_options['enable_sandbox'] ) && $this->remitano_payment_button_options['enable_sandbox'] === 'enable_sandbox' ) ? 'checked' : ''
		);
	}

	public function default_button_style_callback() {
		?> <select name="remitano_payment_button_options[default_button_style]" id="default_button_style">
			<?php $selected = (isset( $this->remitano_payment_button_options['default_button_style'] ) && $this->remitano_payment_button_options['default_button_style'] === 'long-purple') ? 'selected' : '' ; ?>
			<option value="long-purple" <?php echo esc_attr( $selected ); ?>>Long Purple</option>
			<?php $selected = (isset( $this->remitano_payment_button_options['default_button_style'] ) && $this->remitano_payment_button_options['default_button_style'] === 'short-purple') ? 'selected' : '' ; ?>
			<option value="short-purple" <?php echo esc_attr( $selected ); ?>>Short Purple</option>
			<?php $selected = (isset( $this->remitano_payment_button_options['default_button_style'] ) && $this->remitano_payment_button_options['default_button_style'] === 'long-white') ? 'selected' : '' ; ?>
			<option value="long-white" <?php echo esc_attr( $selected ); ?>> Long White</option>
			<?php $selected = (isset( $this->remitano_payment_button_options['default_button_style'] ) && $this->remitano_payment_button_options['default_button_style'] === 'short-white') ? 'selected' : '' ; ?>
			<option value="short-white" <?php echo esc_attr( $selected ); ?>> Short White</option>
		</select> <?php
	}

	public function default_currency_callback() {
		?> <select name="remitano_payment_button_options[default_currency]" id="default_currency">
			<?php 
				$currencies = array("USDT", "AED", "ARS", "AUD", "BND", "BOB", "BRL", "BYN", "CAD", "CDF", "CFA", "CHF", "CNY", "COP",
					  "DKK", "DZD", "EUR", "GBP", "GHS", "HKD", "IDR", "ILS", "INR", "JPY", "KES", "KRW", "LAK",
					  "MMK", "MXN", "MYR", "NAD", "NGN", "NOK", "NPR", "NZD", "OMR", "PEN", "PHP", "PKR", "PLN",
					  "QAR", "RUB", "RWF", "SEK", "SGD", "THB", "TRY", "TWD", "TZS", "UAH", "UGX", "USD", "VES",
					  "VND", "XAF", "ZAR", "ZMW");
				foreach ($currencies as $currency):
					$selected = (isset( $this->remitano_payment_button_options['default_currency'] ) && $this->remitano_payment_button_options['default_currency'] === $currency) ? 'selected' : '' ;
			?>
					<option value="<?php echo esc_attr( $currency ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_attr( $currency ); ?></option>
			<?php endforeach; ?>
		</select> <?php
	}
}
