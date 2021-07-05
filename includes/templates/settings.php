<div class="wrap">
    <h2>Remitano Payment  button</h2>
    <p></p>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php
            settings_fields( 'remitano_payment_button_option_group' );
            do_settings_sections( 'remitano-payment-button-admin' );
            submit_button();
        ?>
    </form>
    <h2>Instruction</h2>
    <p>You can use the following short code in anywhere of your website:</p>
    <p><code>[remitano-payment-button amount="123" description="your payment description"]</code></p>
    <h3>Extra variables</h3>
    <p>You can add some extra variables to customize the payment button shortcode:</p>
    <ol>
        <li><code>button-style</code>: We will use the default setting you set above or you can override it for a particular button, accept values are: <code>long-purple</code>, <code>short-purple</code>, <code>long-white</code>, <code>short-white</code>.</li>
        <li><code>redirect-url</code>: By default we will go back to the previous page after the user finish paying in Remitano (success or cancelled), you can change to another link if needed.</li>
    </ol>
    <p>eg: <pre>[remitano-payment-button amount="123" description="SEO service" button-style="long-white" redirect-url="https://yourwebsite.com/thankyou"]</pre></p>
</div>
