<div class="pw_admin_block">
	<h3>License<br><small style="color: #999; font-size: 12px; font-weight: 400"><?php echo (in_array( 'private-workrooms-pro/private-workrooms-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )  ? 'PRO Version' : 'Free Version');?></small></h3>
	<div>
		<div class="pw_licinse_notice alert alert-danger">asd</div>
		<i><strong>Your license key provides access to updates and support.</strong></i>
		<br><br>
		<?php 
		if ( in_array( 'private-workrooms-pro/private-workrooms-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			echo '<input name="pw_license" class="pw_admin_input" value="'.get_option( 'pw_license' ).'"><br><br>';
			echo '<a href="#" id="pw_activate_license" data-type="pw_activate_license" class="pw_btn do_ajax">'.esc_html__('Activate my license','private-workrooms').'</a>';

		} else {?>
		Even by using the free version of the plugin, you will be able to go through all stages of cooperation with your client and receive payments. Enjoy! 🙂 <br><br>But the <a href="https://pwrooms.com/pricing/" target="_blank">PRO version</a> brings significant improvements and additional conveniences to this process.
		<ul>
			<li><?php esc_html_e('✓ Form builder','private-workrooms')?></li>
			<li><?php esc_html_e('✓ Online / offline user statuses','private-workrooms')?></li>
			<li><?php esc_html_e('✓ Attachments vault','private-workrooms')?></li>
			<li><?php esc_html_e('✓ Markdown syntax','private-workrooms')?></li>
			<li><?php esc_html_e('✓ Multiple payments method','private-workrooms')?></li>
			<li><?php esc_html_e('✓ Email notifications','private-workrooms')?></li>
			<li><?php esc_html_e('✓ Dashboards','private-workrooms')?></li>
		</ul>
		<a href="https://pwrooms.com/pricing/" target="_blank" data-type="pw_getpro_license" class="pw_btn"><?php esc_html_e('Get Pro','private-workrooms')?></a>
		<?php }	?>
	</div>
</div>