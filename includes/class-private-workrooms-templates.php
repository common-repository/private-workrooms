<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Private_Workrooms
 * @subpackage Private_Workrooms/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Private_Workrooms
 * @subpackage Private_Workrooms/public
 * @author     Private Workrooms
 */
class Private_Workrooms_Templates {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $private_workrooms    The ID of this plugin.
	 */
	private $private_workrooms;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $private_workrooms       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $private_workrooms, $version ) {

		$this->private_workrooms = $private_workrooms;
		$this->version = $version;

	}


	// ------------------
	// * Search for templates
	// *
	// * @since    1.0.0
	// *
	static function pw_search_template( $folder, $template ) {
		if ( file_exists( PRIVATE_WORKROOMS_TEMPLATES_PATH_THEME . $folder . '/' . $template . '.php' ) ) {
			return PRIVATE_WORKROOMS_TEMPLATES_PATH_THEME . $folder . '/' . $template . '.php';
		} elseif ( ( class_exists( 'Private_Workrooms_Pro' ) ) && file_exists( WP_PLUGIN_DIR . '/private-workrooms-pro/templates/' . $folder . '/' . $template . '.php' ) ) {
			return WP_PLUGIN_DIR . '/private-workrooms-pro/templates/' . $folder . '/' . $template . '.php';
		} elseif ( file_exists( PRIVATE_WORKROOMS_TEMPLATES_PATH . $folder . '/' . $template . '.php' ) ) {
			return PRIVATE_WORKROOMS_TEMPLATES_PATH . $folder . '/' . $template . '.php';
		} else {
			return PRIVATE_WORKROOMS_TEMPLATES_PATH . 'single/silence.php';
		}
	}

	// ------------------
	// * Loading template to display single pages
	// *
	// * @since    1.0.0
	// *
	public function pw_cpt_template( $single ) {
		global $post;
		/* Checks for single template by post type */
		if ( isset($post->post_type) && $post->post_type == 'private_workrooms' ) {
			return $this->pw_search_template( 'single', 'single-private_workroom' );
		}
		return $single;
	}


	// ------------------
	// * Modal template
	// *
	// * @since    1.0.0
	// *
	public function pw_modal_function( $placement ) {
		ob_start();
		require self::pw_search_template( 'front', 'modal' );
		return ob_get_clean();
	}
	
	// ------------------
	// * Estimate template
	// *
	// * @since    1.0.0
	// *
	public function pw_modal_estimate_function( $placement ) {
		ob_start();
		require self::pw_search_template( 'single', 'estimate' );
		return ob_get_clean();
	}
	
	
	// ------------------
	// * Checkout template
	// *
	// * @since    1.0.0
	// *
	public function pw_modal_checkout_function( $placement ) {
		ob_start();
		require self::pw_search_template( 'single', 'checkout' );
		return ob_get_clean();
	}

	// ------------------
	// * Comment list template
	// *
	// * @since    1.0.0
	// *
	static function pw_comment( $comment, $args, $depth ) {
		ob_start();
		require self::pw_search_template( 'single', 'comments' );
		echo ob_get_clean();
	}


	// ------------------
	// * Comment form template
	// *
	// * @since    1.0.0
	// *
	public function pw_comment_form_function() {
		ob_start();
		require $this->pw_search_template( 'single', 'comment-form' );
		echo ob_get_clean();
	}


	// ------------------
	// * Before comment form template
	// *
	// * @since    1.0.0
	// *
	public function pw_comment_form_before_function() {
		ob_start();
		require $this->pw_search_template( 'single', 'comment-form-before' );
		echo ob_get_clean();
	}

	// ------------------
	// * Comment form title template
	// *
	// * @since    1.0.0
	// *
	public function pw_comment_form_before_tilte_function( $title ) {
		if ( $title == '' ) {
			return esc_html__( 'Write a reply', 'private-workrooms' );
		} else {
			return $title;
		}
	}
	
	// ------------------
	// * Before markdow syntax
	// *
	// * @since    1.0.0
	// *
	public function pw_comment_form_before_md_syntax_function() {
		$output = '';
		$filter = apply_filters( 'pw_comment_form_before_md_syntax_args', $args = false );
		if ( $filter[ 'show' ] ) {
			$output .= '<div style="position: relative; flex-grow: 1"><div class="md_syntax">';
			$output .= $filter[ 'title' ];
			$output .= '</div></div>';
		}
		echo $output;
	}

	// ------------------
	// * Markdown syntax template
	// *
	// * @since    1.0.0
	// *
	public function pw_comment_form_before_md_syntax_args_function( $defaults ) {
		$defaults[ 'show' ] = true;
		$defaults[ 'title' ] = __( 'Markdown syntax', 'private-workrooms' );
		return $defaults;
	}
	
	
	// ------------------
	// * Estimate form templates
	// *
	// * @since    1.0.0
	// *
	public function pw_estimate_form_before_function($estimate) {
		ob_start();
		require $this->pw_search_template( 'single/estimate', 'estimate-form-before' );
		echo ob_get_clean();
	}
	public function pw_estimate_form_content_function($estimate) {
		ob_start();
		require $this->pw_search_template( 'single/estimate', 'estimate-form-content' );
		echo ob_get_clean();
	}
	public function pw_estimate_form_function($estimate) {
		ob_start();
		require $this->pw_search_template( 'single/estimate', 'estimate-form' );
		echo ob_get_clean();
	}
	public function pw_estimate_form_after_function($estimate) {
		ob_start();
		require $this->pw_search_template( 'single/estimate', 'estimate-form-after' );
		echo ob_get_clean();
	}
	public function pw_estimate_details_function($estimate) {
		ob_start();
		require $this->pw_search_template( 'single/estimate', 'estimate-details' );
		echo ob_get_clean();
	}
	

	
	
	// ------------------
	// * Login template
	// *
	// * @since    1.0.0
	// *
	public function pw_login_form_function() {
		if ( $this->pw_search_template( 'front', 'login-form' ) ) {
			ob_start();
			require $this->pw_search_template( 'front', 'login-form' );
			echo ob_get_clean();
		}
	}
	
	// ------------------
	// * Modal template
	// *
	// * @since    1.0.0
	// *
	public function pw_before_modal_content_function() {
		if ( $this->pw_search_template( 'front', 'before-modal-content' ) ) {
			ob_start();
			require $this->pw_search_template( 'front', 'before-modal-content' );
			echo ob_get_clean();
		}
	}
	
	// ------------------
	// * Sidebar template
	// *
	// * @since    1.0.0
	// *
	public function pw_sidebar_function() {
		ob_start();
		require $this->pw_search_template( 'single', 'sidebar' );
		echo ob_get_clean();
	}
	
	// ------------------
	// * My-account template parts
	// *
	// * @since    1.0.0
	// *
	public function pw_get_account_part($part) {
		ob_start();
		require $this->pw_search_template( 'front/my-account', $part );
		echo ob_get_clean();
	}
	
	// ------------------
	// * Sidebar template parts
	// *
	// * @since    1.0.0
	// *
	public function pw_workroom_sidebar_part_function($part) {
		global $post;
		$order_status = false;
		$admin = Private_Workrooms::who_am_i();
		$logged_in_users = get_transient( 'online_status' );
		$users_here = array();
		$author_id = $post->post_author;
		$users_here[] = get_the_author_meta('user_email',$author_id);
		$comments = get_comments( array( 'post_id' => $post->ID ) );
		foreach ( $comments as $comment ) {
			if ( !in_array( $comment->comment_author_email, $users_here ) && ( $comment->comment_type == 'regular' ) ) {
				$users_here[] = $comment->comment_author_email;
			}
		}
		$estimate_meta = get_post_meta( $post->ID, 'estimate' );
		if($estimate_meta ){
			$estimate = $estimate_meta[0];
		}
		$orders = wc_get_orders( array(
			'limit'        => -1, // Query all orders
			'orderby'      => 'date',
			'order'        => 'DESC',
			'meta_key'     => 'pwrooms', // The postmeta key field
			'meta_value' => $post->ID, // The comparison argument
		));
		$payments = array();
		foreach ($orders as $order){
			$order_status = $order->get_status();
			$items = $order->get_items();
			foreach($items as $item){
				$payments[$item->get_name()] = $order->get_status() ;
			}
		}
		ob_start();
		require $this->pw_search_template( 'single/sidebar', $part );
		echo ob_get_clean();
	}
	
	
	// ------------------
	// * Form template parts for admin area
	// *
	// * @since    1.0.0
	// *
	public function pw_form_part_function($part, $element){
		ob_start();
		require $this->pw_search_template( 'admin/form/', $part );
		echo ob_get_clean();
	}
	
	// ------------------
	// * New room form template
	// *
	// * @since    1.0.0
	// *
	public function pw_new_room_form_function(){
		ob_start();
		require $this->pw_search_template( 'single/', 'new_room_form' );
		echo ob_get_clean();
	}
	
	// ------------------
	// * Form template parts for new room
	// *
	// * @since    1.0.0
	// *
	public function pw_display_new_room_form_part_function($part, $element){
		ob_start();
		require $this->pw_search_template( 'front/form/', $part );
		echo ob_get_clean();
	}
	
	// ------------------
	// * Templates for the default meta
	// *
	// * @since    1.0.0
	// *
	public function pw_workrooms_default_meta_function(){
		global $post;
		$client = get_user_by( 'id', $post->post_author );
		ob_start();
		require $this->pw_search_template( 'single/meta/', 'default' );
		echo ob_get_clean();
	}
	
	// ------------------
	// * Templates for the extra meta
	// *
	// * @since    1.0.0
	// *
	public function pw_workrooms_extra_meta_function(){
		global $post;
		ob_start();
		require $this->pw_search_template( 'single/meta/', 'extra' );
		echo ob_get_clean();
	}
	
	// ------------------
	// * Lost password template
	// *
	// * @since    1.0.0
	// *
	public function pw_lost_password_function(){
		ob_start();
		require $this->pw_search_template( 'front/', 'lost-password' );
		echo ob_get_clean();
	}
	// ------------------
	// * Lost password template
	// *
	// * @since    1.0.0
	// *
	public function pw_admin_page_part_function($part){
		ob_start();
		require $this->pw_search_template( 'admin/settings', $part );
		echo ob_get_clean();
	}
	
}