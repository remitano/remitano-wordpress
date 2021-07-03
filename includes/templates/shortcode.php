<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$current_url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$redirect_url = $current_url;
if ( !empty( $atts['redirect-url'] ) ) {
    $redirect_url = $current_url;
}

?>

<div
  class="remitano-payment-btn"
  data-sandbox="<?php echo $options['enable_sandbox'] ? 'true' : 'false'; ?>"
  data-merchant-username="<?php echo $options['merchant_username']; ?>"
  data-coin-currency="<?php echo $options['default_coin_currency']; ?>"
  data-coin-amount="<?php echo $atts['amount']; ?>"
  data-description="<?php echo $atts['description']; ?>"
  data-cancelled-or-completed-callback-url="<?php echo $redirect_url; ?>"
>
  <input type="image" src="<?php echo REMI_PAYMENT_BUTTON_PLUGIN_URL . '/assets/images/' . $atts['button-style'] . '.png'; ?>" alt="Pay with Remitano" style="height: 48px">
</div>
