<?php
/**
 * Plugin Name: Private Workrooms
 * Plugin URI:  https://wordpress.org/plugins/private-workrooms/
 * Description: Sell services to your clients and get paid directly on your website!
 * Version:     1.0.7
 * Author:      Private Workrooms Team
 * Author URI:  https://pwrooms.com/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: private-workrooms
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'private_workrooms_register_required_plugins' );
function private_workrooms_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(


		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'WooCommerce',
			'slug'      => 'woocommerce',
			'required'  => true,
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'private-workrooms',     // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'private-workrooms-settings', // Menu slug.
		'parent_slug'  => 'options-general.php',            // Parent menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'private-workrooms' ),
			'menu_title'                      => __( 'Install Plugins', 'private-workrooms' ),
			'installing'                      => __( 'Installing Plugin: %s', 'private-workrooms' ),
			'updating'                        => __( 'Updating Plugin: %s', 'private-workrooms' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'private-workrooms' ),
			'notice_can_install_required'     => _n_noop(
				'You are almost ready to start selling your services! %1$s is required!',
				'Private Workrooms requires: %1$s',
				'private-workrooms'
			),
			'notice_can_activate_required'    => _n_noop(
				'You are almost ready to start selling your services! %1$s is required!',
				'You are almost ready to start selling your services! %1$s is required!',
				'private-workrooms'
			),
		)
		
	);

	tgmpa( $plugins, $config );
}



/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Update it as you release new versions.
 */
define( 'PRIVATE_WORKROOMS_VERSION', '1.0.6' );

/**
 * Plugin path.
 * Start at version 1.0.0
 */
define('PRIVATE_WORKROOMS_PLUGIN_PATH', plugin_dir_path( __FILE__ ));

/**
 * Plugin URL.
 * Start at version 1.0.0
 */
define('PRIVATE_WORKROOMS_URL', plugins_url( '', __FILE__ ));

/**
 * Templates path [Default].
 * Start at version 1.0.0
 */
define('PRIVATE_WORKROOMS_TEMPLATES_PATH', plugin_dir_path( __FILE__ ).'templates/');

/**
 * Templates path [Theme].
 * Start at version 1.0.0
 */
define('PRIVATE_WORKROOMS_TEMPLATES_PATH_THEME', get_stylesheet_directory().'/private-workrooms/');
 

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-private-workrooms-activator.php
 */
function activate_private_workrooms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-private-workrooms-activator.php';
	Private_Workrooms_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-private-workrooms-deactivator.php
 */
function deactivate_private_workrooms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-private-workrooms-deactivator.php';
	Private_Workrooms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_private_workrooms' );
register_deactivation_hook( __FILE__, 'deactivate_private_workrooms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-private-workrooms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 * @last update    1.0.3
 */
function run_private_workrooms() {
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )) {
		$plugin = new Private_Workrooms();
		$plugin->run();
	}
}
run_private_workrooms();