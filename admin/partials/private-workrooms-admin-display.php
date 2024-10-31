<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Private_Workrooms
 * @subpackage Private_Workrooms/admin/partials
 */


class PW_Settings {
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
	}


	/**
	 * Add options page
	 */
	public function add_plugin_page() {
			add_options_page(
            'Private Workrooms',
            'Private Workrooms',
            'edit_posts',
            'private-workrooms-settings',
           array( $this, 'create_admin_page' )
        );
	}
	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		// Set class property


		?>
<div id="pw_settings_page">
	<div id="pw_settings_page_head">
		<div class="pw_settings_page_head_status"> <img style="width: 250px;" src="<?php echo plugin_dir_url( __FILE__ ).'img/Private-Workroom-Logo.png'?>">
			<?php
			global $wp_version, $woocommerce;
			$alert[ 'class' ] = 'alert-danger';
			$alert[ 'message' ] = 'Issues were found';
			$alert[ 'icon' ] = 'x';
			if ( version_compare( phpversion(), '5.6.0', '>=' ) &&
				version_compare( $wp_version, '4.1.0', '>=' ) &&
				version_compare( $woocommerce->version, '4.0.0', '>=' ) &&
				get_option( 'woocommerce_myaccount_page_id' ) &&
				get_option( 'woocommerce_checkout_page_id' )
			) {
				$alert[ 'class' ] = 'alert-info';
				$alert[ 'icon' ] = '✓';
				$alert[ 'message' ] = 'Your website is ready to sell services!';
			}
			?>
			<div>
				<div class="alert alert-in-line <?php echo $alert['class']; ?>"><strong><?php echo $alert['icon']; ?></strong> <span style="margin-left: 10px;"><?php echo $alert['message']; ?></span></div>
			</div>
		</div>
		<ul>
			<li class="is_active"><a href="#">Home</a></li>
			<li><a target="_blank" href="https://pwrooms.com/complete-guide-getting-started-with-private-workrooms/">Documentation</a></li>
		</ul>
		<div id="pw_general">
			<?php
			apply_filters( 'pw_admin_page_part', 'welcome' );
			apply_filters( 'pw_admin_page_part', 'license' );
			if ( in_array( 'private-workrooms-pro/private-workrooms-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				apply_filters( 'pw_admin_page_part', 'form_builder' );
				apply_filters( 'pw_admin_page_part', 'emails' );
			} else {}
			apply_filters( 'pw_admin_page_part', 'status' );
			?>
		</div>
	</div>
</div>
<?php
}


}

if ( is_admin() )
	$my_settings_page = new PW_Settings();
