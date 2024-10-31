<?php global $wp_version,$woocommerce;?>
<div class="pw_admin_block">
	<h3>System status</h3>
	<div>
		<ul style="margin-top: 0">
			<li><?php echo (version_compare(phpversion(), '5.6.0', '>=') ? '✓': 'x' ).esc_html__(' PHP Version 5.6.0+','private-workrooms')?></li>
			<li><?php echo (version_compare($wp_version, '4.1.0', '>=') ? '✓': 'x' ).esc_html__(' WordPress Version 4.1.0+','private-workrooms')?></li>
			<li><?php echo (version_compare($woocommerce->version, '4.0.0', '>=') ? '✓': 'x' ).' <a href="/wp-admin/plugin-install.php?tab=plugin-information&plugin=woocommerce">WooCommerce</a> Version 4.0.0+'?></li>
			<li><?php echo (get_option( 'woocommerce_myaccount_page_id' )? '✓' : 'x').esc_html__(' My Account Page','private-workrooms')?></li>
			<li><?php echo (get_option( 'woocommerce_checkout_page_id' )? '✓' : 'x').esc_html__(' Checkout Page','private-workrooms')?></li>
		</ul>
		<strong>Quick Start:</strong><br>
		Just drop a shortcode somewhere on your site and your customers will be able to hire you!<br><br><strong >[pwr_get_quote text="Hire us!"]</strong><br><br><a target="_blank" href="https://pwrooms.com/complete-guide-getting-started-with-private-workrooms/">Read Documentation</a>
	</div>
</div>