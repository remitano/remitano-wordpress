<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$current_url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$redirect_url = $current_url;
if ( !empty( $atts['redirect-url'] ) ) {
    $redirect_url = $atts['redirect-url'];
}

?>

<div
  class="remitano-payment-btn"
  data-sandbox="<?php echo esc_attr( $options['enable_sandbox'] ? 'true' : 'false' ); ?>"
  data-merchant-username="<?php echo esc_attr( $options['merchant_username'] ); ?>"
  <?php if ($options['currency'] == 'USDT'): ?>
    data-coin-currency="usdt"
    data-coin-amount="<?php echo esc_attr( $atts['amount'] ); ?>"
  <?php else: ?>
    data-fiat-currency="<?php echo esc_attr( $atts['currency'] ); ?>"
    data-fiat-amount="<?php echo esc_attr( $atts['amount'] ); ?>"
  <?php endif; ?>
  data-description="<?php echo esc_attr( $atts['description'] ); ?>"
  data-cancelled-or-completed-callback-url="<?php echo esc_url( $redirect_url ); ?>"
>
  <input type="image" src="<?php echo REMI_PAYMENT_BUTTON_PLUGIN_URL . '/assets/images/' . esc_attr( $atts['button-style'] ) . '.png'; ?>" alt="Pay with Remitano" style="height: 48px">
</div>
