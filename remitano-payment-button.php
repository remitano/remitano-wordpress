<?php
/**
 * Plugin Name: Remitano Payment Button
 * Plugin URI: https://developers.remitano.com
 * Description: Add Remitano Payment Button with shortcode in blog post and page
 * Version: 1.0.1
 * Author: Remitano
 * Author URI: https://remitano.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'REMI_PAYMENT_BUTTON_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'REMI_PAYMENT_BUTTON_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if ( ! class_exists( 'Remitano_Payment_Button' ) ) {
	 require_once(REMI_PAYMENT_BUTTON_PLUGIN_PATH . 'includes/class-remitano-payment-button.php');
}

add_action( 'init', 'remi_payment_button_init', 9 );

function remi_payment_button_init() {
	new Remitano_Payment_Button();

	$plugin = plugin_basename( __FILE__ );
	add_filter( "plugin_action_links_$plugin", 'remi_add_settings_link' );
}

function remi_add_settings_link( $links ) {
	$settings_link = '<a href="admin.php?page=remitano-payment-button">' . __( 'Settings' ) . '</a>';
	array_unshift( $links, $settings_link );

	return $links;
}
