<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 *
 * @package    Private_Workrooms
 * @subpackage Private_Workrooms/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.a
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Private_Workrooms
 * @subpackage Private_Workrooms/includes
 * @author     Private Workrooms
 */
class Private_Workrooms {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Private_Workrooms_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $private_workrooms    The string used to uniquely identify this plugin.
	 */
	protected $private_workrooms;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PRIVATE_WORKROOMS_VERSION' ) ) {
			$this->version = PRIVATE_WORKROOMS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->private_workrooms = 'private-workrooms';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_templates_hooks();
		
		add_shortcode('pwr_get_quote', array($this, 'pwr_get_quote_function'));

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Private_Workrooms_Loader. Orchestrates the hooks of the plugin.
	 * - Private_Workrooms_i18n. Defines internationalization functionality.
	 * - Private_Workrooms_Admin. Defines all hooks for the admin area.
	 * - Private_Workrooms_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-private-workrooms-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-private-workrooms-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-private-workrooms-admin.php';

		/**
		 * The class responsible for defining options page.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/private-workrooms-admin-display.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-private-workrooms-public.php';

		/**
		 * The class responsible for templates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-private-workrooms-templates.php';

		$this->loader = new Private_Workrooms_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Private_Workrooms_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Private_Workrooms_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Private_Workrooms_Admin( $this->get_private_workrooms(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		//Register CPT
		$this->loader->add_action( 'init', $plugin_admin, 'pw_cpt' );
		$this->loader->add_action( 'init', $plugin_admin, 'pw_flush_rewrite_rules' );
		
		
		$this->loader->add_action( 'admin_init', $plugin_admin, 'pw_extra_fields',1 );
		$this->loader->add_action( 'save_post', $plugin_admin, 'pw_extra_fields_update', 0);


		$this->loader->add_action( 'init', $plugin_admin, 'pw_cpt_rewrites_init' );
		$this->loader->add_filter( 'post_type_link', $plugin_admin, 'pw_cpt_permalink', 1, 3 );
		
		$this->loader->add_action( 'woocommerce_thankyou', $plugin_admin, 'pw_go_back_after_payment');
		$this->loader->add_action( 'pw_new_system_comment', $plugin_admin, 'pw_new_system_comment_function', 10, 4 );
		
		$this->loader->add_action( 'wp_ajax_pw_admin_ajax', $plugin_admin, 'pw_admin_ajax' );
		
		$this->loader->add_filter( 'plugin_row_meta', $plugin_admin, 'pw_plugin_links', 20, 4  );
		
		$this->loader->add_action( 'activated_plugin', $plugin_admin, 'pwr_is_activated' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Private_Workrooms_Public( $this->get_private_workrooms(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_ajax_pw_public_ajax', $plugin_public, 'pw_public_ajax' );
		$this->loader->add_action( 'wp_ajax_nopriv_pw_front_ajax', $plugin_public, 'pw_front_ajax' );
		$this->loader->add_action( 'wp_ajax_pw_front_ajax', $plugin_public, 'pw_front_ajax' );
		
		if(!class_exists( 'Private_Workrooms_Pro' )){
			$this->loader->add_action( 'pw_sidebar', $plugin_public, 'pro_features_function', 20 );
		}
		
		$this->loader->add_filter( 'pre_get_document_title', $plugin_public, 'wp_title_restrict',20,2 );
	}


	/**
	 * Register all of the hooks related to the templates
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_templates_hooks() {

		$plugin_templates = new Private_Workrooms_Templates( $this->get_private_workrooms(), $this->get_version() );

		$this->loader->add_filter( 'template_include', $plugin_templates, 'pw_cpt_template', 10, 1 );
		
		
		
		$this->loader->add_filter( 'pw_modal', $plugin_templates, 'pw_modal_function', 10, 1 );
		$this->loader->add_filter( 'pw_modal_estimate', $plugin_templates, 'pw_modal_estimate_function', 10, 1 );
		$this->loader->add_filter( 'pw_modal_checkout', $plugin_templates, 'pw_modal_checkout_function', 10, 1 );
		$this->loader->add_filter( 'pw_comment_form', $plugin_templates, 'pw_comment_form_function', 10, 1 );
		$this->loader->add_action( 'pw_comment_form_before', $plugin_templates, 'pw_comment_form_before_function', 10, 1 );
		$this->loader->add_filter( 'pw_comment_form_before_tilte', $plugin_templates, 'pw_comment_form_before_tilte_function', 10, 1 );
		$this->loader->add_action( 'pw_comment_form_before_md_syntax', $plugin_templates, 'pw_comment_form_before_md_syntax_function', 10, 1 );
		$this->loader->add_action( 'pw_comment_form_before_md_syntax_args', $plugin_templates, 'pw_comment_form_before_md_syntax_args_function', 10, 1 );

		$this->loader->add_filter( 'pw_before_modal_content', $plugin_templates, 'pw_before_modal_content_function', 10, 1 );
		$this->loader->add_filter( 'pw_login_form', $plugin_templates, 'pw_login_form_function', 10, 1 );
		$this->loader->add_action( 'pw_lost_password', $plugin_templates, 'pw_lost_password_function', 10, 0 );
		
		$this->loader->add_filter( 'pw_sidebar', $plugin_templates, 'pw_sidebar_function', 10, 1 );
		$this->loader->add_filter( 'pw_workroom_sidebar_part', $plugin_templates, 'pw_workroom_sidebar_part_function', 10, 1 );
		
		
		
		$this->loader->add_action( 'pw_estimate_form_before', $plugin_templates, 'pw_estimate_form_before_function', 10, 1 );
		$this->loader->add_action( 'pw_estimate_form', $plugin_templates, 'pw_estimate_form_function', 10, 1 );
		$this->loader->add_action( 'pw_estimate_form_content', $plugin_templates, 'pw_estimate_form_content_function', 10, 1 );
		$this->loader->add_action( 'pw_estimate_form_after', $plugin_templates, 'pw_estimate_form_after_function', 10, 1 );
		$this->loader->add_action( 'pw_estimate_details', $plugin_templates, 'pw_estimate_details_function', 10, 1 );
		
		
		$this->loader->add_action( 'pw_form_part', $plugin_templates, 'pw_form_part_function', 10, 2 );
		
		$this->loader->add_action( 'pw_new_room_form', $plugin_templates, 'pw_new_room_form_function', 10, 1 );
		$this->loader->add_action( 'pw_display_new_room_form_part', $plugin_templates, 'pw_display_new_room_form_part_function', 10, 2 );
		
		$this->loader->add_action( 'pw_workrooms_default_meta', $plugin_templates, 'pw_workrooms_default_meta_function', 10, 0 );
		$this->loader->add_action( 'pw_workrooms_extra_meta', $plugin_templates, 'pw_workrooms_extra_meta_function', 10, 0 );
		
		$this->loader->add_action( 'pw_admin_page_part', $plugin_templates, 'pw_admin_page_part_function', 10, 1 );
		
		
		

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_private_workrooms() {
		return $this->private_workrooms;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Private_Workrooms_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}


	/**
	 * Get current user role.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	static function who_am_i() {
		if ( is_user_logged_in() ) {
			$user = wp_get_current_user();
			$roles = ( $user->roles[ 0 ] == 'administrator' ) ? true : false;

			return $roles; // This returns an array
			// Use this to return a single value
			// return $roles[0];
		} else {
			return array();
		}
	}
	
	/**
	 * Shortcode to create new workroom.
	 *
	 * @since     1.0.1
	 * @return    string    <a> tag.
	 */
	function pwr_get_quote_function($atts = array()){
		 extract(shortcode_atts(array(
		 'text' => 'Get quote'
		), $atts));
		return '<a href="#" class="pw_btn pw_room">'.$text.'</a>';
	}
	
	
	
	
}