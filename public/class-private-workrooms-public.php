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
class Private_Workrooms_Public {

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
		add_shortcode( 'pw-button', array( $this, 'pw_button' ) );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Private_Workrooms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Private_Workrooms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( is_single() && get_post_type() == 'private_workrooms' ) {
			wp_enqueue_style( $this->private_workrooms, plugin_dir_url( __FILE__ ) . 'css/private-workrooms-public.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ).'css/bootstrap.min.css', array(), '4.3.1', 'all' );
		}
		wp_enqueue_style( $this->private_workrooms . '-front', plugin_dir_url( __FILE__ ) . 'css/private-workrooms-front.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Private_Workrooms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Private_Workrooms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $current_user, $post;
		if ( is_single() && get_post_type() == 'private_workrooms' && is_user_logged_in() && (current_user_can('administrator') || ($current_user->ID == $post->post_author)) ) {
			wp_enqueue_script( $this->private_workrooms, plugin_dir_url( __FILE__ ) . 'js/private-workrooms-public.js', array( 'jquery' ), $this->version, false );
			wp_localize_script( $this->private_workrooms, 'PW', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'ajaxnonce' => wp_create_nonce( "pw_nonce" ), 'pro' => ( class_exists( 'Private_Workrooms_Pro' ) ) ? true : false ) );
		}
		wp_enqueue_script( $this->private_workrooms . '-front', plugin_dir_url( __FILE__ ) . 'js/private-workrooms-front.js', array( 'jquery' ), $this->version, false );
		$pw_modal = apply_filters( 'pw_modal', array('type'=>'') );
		$pw_estimate = apply_filters( 'pw_modal_estimate', array('type'=>'') );
		$pw_checkout = apply_filters( 'pw_modal_checkout', array('type'=>'') );
		$room = (is_single() && get_post_type() == 'private_workrooms') ? true : false;
		$my_account = get_permalink( get_option('woocommerce_myaccount_page_id') );
		$chosen_one = ( is_single() && get_post_type() == 'private_workrooms' && is_user_logged_in() && (current_user_can('administrator') || ($current_user->ID == $post->post_author)) ) ? true :false;
		wp_localize_script( $this->private_workrooms . '-front', 'PW', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),'my_account'=>$my_account, 'home'=> get_bloginfo('url'), 'user' => is_user_logged_in(), 'chosen_one'=>$chosen_one, 'room'=>$room, 'modal' => $pw_modal, 'checkout' => $pw_checkout, 'estimate' => $pw_estimate, 'ajaxnonce' => wp_create_nonce( "pw_nonce" ), 'pro' => ( class_exists( 'Private_Workrooms_Pro' ) ) ? true : false ) );

	}

	/**
	 * Public Ajax requests.
	 *
	 * @since    1.0.0
	 */
	
	public function pw_public_ajax() {
		$allowed_tags = array(
			'a' => array(
				'class' => array(),
				'href'  => array(),
				'rel'   => array(),
				'title' => array(),
			),
			'abbr' => array(
				'title' => array(),
			),
			'b' => array(),
			'br' => array(),
			'blockquote' => array(
				'cite'  => array(),
			),
			'cite' => array(
				'title' => array(),
			),
			'code' => array(),
			'del' => array(
				'datetime' => array(),
				'title' => array(),
			),
			'dd' => array(),
			'div' => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'dl' => array(),
			'dt' => array(),
			'em' => array(),
			'h1' => array(),
			'h2' => array(),
			'h3' => array(),
			'h4' => array(),
			'h5' => array(),
			'h6' => array(),
			'i' => array(),
			'img' => array(
				'alt'    => array(),
				'class'  => array(),
				'height' => array(),
				'src'    => array(),
				'width'  => array(),
			),
			'li' => array(
				'class' => array(),
			),
			'ol' => array(
				'class' => array(),
			),
			'p' => array(
				'class' => array(),
			),
			'q' => array(
				'cite' => array(),
				'title' => array(),
			),
			'span' => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'strike' => array(),
			'strong' => array(),
			'ul' => array(
				'class' => array(),
			),
		);
		
		$allowed_html = $allowed_tags;
		check_ajax_referer( 'pw_nonce', 'security' );
		$post_id = url_to_postid( wp_get_referer() );
		$current_user = wp_get_current_user();
		if ( isset( $_REQUEST ) ) {
			$type = $_REQUEST[ 'type' ];

			if ( $type == 'regular_comment' ) {
				$commentdata = array(
					'comment_post_ID' => $post_id,
					'comment_author' => $current_user->display_name,
					'comment_content' =>  wp_kses($_REQUEST[ 'content' ],$allowed_html),
					'comment_type' => 'regular',
					'comment_author_email' => $current_user->user_email,
					'user_ID' => $current_user->ID,
					'comment_approved' => 1
				);

				$id = wp_insert_comment( $commentdata );
				echo $id;
				do_action( 'pw_new_system_comment', false , $post_id, $_REQUEST[ 'content' ], 'new_comment' );
			}elseif($type == 'new_estimate' ){
				parse_str( $_REQUEST[ 'content' ], $estimate );
				$estimate_meta = array();
				foreach ($estimate as $key => $value){
					if($key == 'payment_stages'){
						foreach($value as $pay_key => $pay_value ){
							$estimate_meta['payment_stages'][$pay_key]['title'] = sanitize_text_field($pay_value['title']);
							$estimate_meta['payment_stages'][$pay_key]['price'] = sanitize_text_field($pay_value['price']);
						}
					}else{
						$estimate_meta[$key] = sanitize_text_field($value);
					}
				}
				update_post_meta( $post_id, 'estimate', $estimate_meta );
				update_post_meta( $post_id, 'pro_estimate',wp_kses($_REQUEST[ 'pro_estimate' ],$allowed_html) );
				do_action( 'pw_new_system_comment', 'system', $post_id, esc_html__('estimate provided','private-workrooms'), 'new_estimate' );
			}elseif($type == 'remove_estimate'){
				update_post_meta( $post_id, 'estimate', '' );
				update_post_meta( $post_id, 'pro_estimate', '' );
				do_action( 'pw_new_system_comment', 'system', $post_id, esc_html__('estimate deleted','private-workrooms'), false );
			}elseif($type == 'pay_for_estimate'){
				$post = get_post( $_REQUEST['id'] );
				$estimate_meta = get_post_meta( $post->ID, 'estimate' );
				$estimate = $estimate_meta[0];
				
				if($estimate['payment_type'] == 'pw_single_payment'){
					$service = get_page_by_title('#'.$post->ID.' - '.$estimate['title_single'] , OBJECT, 'product');
					if ( FALSE == get_post_status( $service->ID ) ) {
						$product_id = wp_insert_post(array(
							'post_title' => '#'.$post->ID.' - '.$estimate['title_single'] ,
							'post_type' => 'product',
							'post_status' => 'publish'
						));
						wp_set_object_terms( $product_id, 'simple', 'product_type' );
						update_post_meta( $product_id, '_visibility', 'visible' );
						update_post_meta( $product_id, '_stock_status', 'instock');
						update_post_meta( $product_id, '_virtual', 'yes' );
						update_post_meta( $product_id, '_sku', 'pwrooms_'.$post->ID );
						update_post_meta( $product_id, '_purchase_note', ''  );
						update_post_meta( $product_id, '_price', sanitize_text_field($estimate['price_single']) );
						update_post_meta( $product_id, '_regular_price', sanitize_text_field($estimate['price_single']) );
					}else{
						$product_id = $service->ID;
					}
				}else if($estimate['payment_type'] == 'pw_multiple_payment'){
					$service = get_page_by_title('#'.$post->ID.' - '.$estimate[ 'payment_stages' ][$_REQUEST[ 'stage' ] - 1]['title'] , OBJECT, 'product');
					if ( FALSE == get_post_status( $service->ID ) ) {
						$product_id = wp_insert_post(array(
							'post_title' => '#'.$post->ID.' - '.$estimate[ 'payment_stages' ][$_REQUEST[ 'stage' ] - 1]['title'] ,
							'post_type' => 'product',
							'post_status' => 'publish'
						));
						wp_set_object_terms( $product_id, 'simple', 'product_type' );
						update_post_meta( $product_id, '_visibility', 'visible' );
						update_post_meta( $product_id, '_stock_status', 'instock');
						update_post_meta( $product_id, '_virtual', 'yes' );
						update_post_meta( $product_id, '_sku', 'pwrooms_'.$post->ID );
						update_post_meta( $product_id, '_purchase_note', ''  );
						update_post_meta( $product_id, '_price', sanitize_text_field($estimate[ 'payment_stages' ][$_REQUEST[ 'stage' ] - 1]['price']) );
						update_post_meta( $product_id, '_regular_price', sanitize_text_field($estimate[ 'payment_stages' ][$_REQUEST[ 'stage' ] - 1]['price']) );
					}else{
						$product_id = $service->ID;
					}
				}
				$chekout = array('url' => wc_get_checkout_url(),'id' => $product_id);
				WC()->cart->empty_cart();
				echo json_encode( $chekout );
			};

		}
		
		wp_die();
	}


	/**
	 * Front Ajax requests.
	 *
	 * @since    1.0.0
	 */
	public function pw_front_ajax() {
		if ( isset( $_REQUEST ) ) {
			$type = $_REQUEST[ 'type' ];
			if ( $type == 'need_to_login' ) {
				if ( check_ajax_referer( 'pw_nonce', 'security', false ) ) {
					$creds = array();
					parse_str( $_REQUEST[ 'content' ], $creds );
					$user = wp_signon( $creds, false );

					$return = array();
					if ( is_wp_error( $user ) ) {
						$return[ 'status' ] = false;
						$return[ 'content' ] = $user->get_error_message();
					} else {
						wp_clear_auth_cookie();
						clean_user_cache( $user->ID );
						wp_set_current_user( $user->ID );
						wp_set_auth_cookie( $user->ID );
						update_user_caches( $user );

						$return[ 'status' ] = true;
						$return[ 'content' ] = apply_filters( 'pw_modal', array('type'=>false) );
					}
					echo json_encode( $return );
				} else {
					$return[ 'status' ] = false;
					$return[ 'content' ] = esc_html__('Security check failed!','private-workrooms');
					echo json_encode( $return );
				};
			} elseif ( ($type == 'need_to_register')) {
				$creds = array();
				$return = array();
				parse_str( $_REQUEST[ 'content' ], $creds );

				$user = username_exists( sanitize_text_field($creds[ 'login' ]) );
				if ( !$user && false == email_exists( sanitize_email($creds[ 'email' ]) ) ) {
					$random_password = wp_generate_password( $length = 8, $include_standard_special_chars = true );
					$user_data = array(
						'user_login' => sanitize_text_field($creds[ 'login' ]),
						'user_email' => sanitize_email($creds[ 'email' ]),
						'user_pass' => $random_password,
						'display_name' => sanitize_text_field($creds[ 'login' ]),
						'role' => 'subscriber'
					);

					$user = wp_insert_user( $user_data );
					if ( is_wp_error( $user ) ) {
						$return[ 'status' ] = false;
						$return[ 'content' ] = $user->get_error_message();
					} else {
						wp_clear_auth_cookie();
						clean_user_cache( $user );
						wp_set_current_user( $user );
						wp_set_auth_cookie( $user );
						update_user_caches( get_user_by( 'id', $user ) );
						$return[ 'status' ] = true;
						$return[ 'content' ] = apply_filters( 'pw_modal', array('type'=>false) );
					}
				} else {
					$return[ 'status' ] = false;
					$return[ 'content' ] = esc_html__( 'User already exists.', 'textdomain' );
				}
				echo json_encode( $return );
				do_action( 'pw_new_system_comment', false, false, $random_password, 'registration' );
				
			} elseif ( ($type == 'new_room') && is_user_logged_in() ) {
				$room = array();
				parse_str( $_REQUEST[ 'content' ], $room );
				if( current_user_can('editor') || current_user_can('administrator') ) { 
					$email = 'dummy-client@pwrooms.com';
					$exists = email_exists( $email  );
					if ( $exists ) {
						$dummy = get_user_by( 'email', $email );
						$user_id = $dummy->ID;
					} else {
						$random_password = wp_generate_password( $length = 8, $include_standard_special_chars = true );
						$user_data = array(
							'user_login' => 'dummyclient',
							'user_email' => $email,
							'user_pass' => $random_password,
							'display_name' => 'Dummy Client',
							'role' => 'subscriber'
						);
						$user = wp_insert_user( $user_data );
						$user_id = $user;
					}
				}else{
					$user_id = get_current_user_id();
				}
				
				$room[ 'title' ] = sanitize_text_field( $room[ 'title' ] );
				$room[ 'message' ] = sanitize_textarea_field( $room[ 'message' ] );
				// Create post object
				$new_room = array(
					'post_title' => wp_strip_all_tags( $room[ 'title' ] ),
					'post_content' => wp_strip_all_tags( $room[ 'message' ] ),
					'post_status' => 'publish',
					'post_author' => $user_id,
					'post_type' => 'private_workrooms',
				);

				// Insert the post into the database
				$new_room = wp_insert_post( $new_room );
				unset($room[ 'title' ]);
				unset($room[ 'message' ]);
				$room_meta = array();
				foreach ($room  as $key => $value){
					$room_meta[$key] = sanitize_text_field($value);
				}
				update_post_meta( $new_room , 'pw_form', $room_meta );

				echo get_permalink( $new_room );
				do_action( 'pw_new_system_comment', false , $new_room, false, 'new_room' );
			} elseif ( ($type == 'new_user')  ) {
				if ( isset( $_REQUEST ) && check_ajax_referer( 'pw_nonce', 'security', false ) ) {

					$creds = array();
					$return = array();
					parse_str( $_REQUEST[ 'content' ], $creds );

					$user = username_exists( $creds[ 'login' ] );
					if ( !$user && false == email_exists( $creds[ 'email' ] ) ) {
						$random_password = wp_generate_password( $length = 8, $include_standard_special_chars = true );
						$user_data = array(
							'user_login' => $creds[ 'login' ],
							'user_email' => $creds[ 'email' ],
							'user_pass' => $random_password,
							'display_name' => $creds[ 'login' ],
							'role' => 'subscriber'
						);

						$user = wp_insert_user( $user_data );
						if ( is_wp_error( $user ) ) {
							$return[ 'status' ] = false;
							$return[ 'content' ] = $user->get_error_message();
						} else {
							wp_clear_auth_cookie();
							clean_user_cache( $user );
							wp_set_current_user( $user );
							wp_set_auth_cookie( $user );
							update_user_caches( get_user_by( 'id', $user ) );
							$return[ 'status' ] = true;
							$return[ 'content' ] = apply_filters( 'pw_modal', array('type'=>false) );
						}
					} else {
						$return[ 'status' ] = false;
						$return[ 'content' ] = esc_html__( 'User already exists.', 'private-workrooms' );
					}

				} else {
					$return[ 'status' ] = false;
					$return[ 'content' ] = esc_html__('Security check failed!','private-workrooms');
				}
				echo json_encode( $return );
				do_action( 'pw_new_system_comment', false, false, $random_password, 'registration' );
				
			}
		}
		wp_die();
	}

	/**
	 * New room button.
	 *
	 * @since    1.0.0
	 */
	public function pw_button() {
		echo '<a id="pw_create_room" class="pw_create_room" style="display:inline-block; margin:0 auto; background:#61ce70; color:#fff; padding:10px" href="#">'.esc_html__('Get quote','private-workrooms').'</a>';
	}
	
	/**
	 * Sidebar demo.
	 *
	 * @since    1.0.0
	 */
	public function pro_features_function(){
		apply_filters( 'pw_workroom_sidebar_part', 'demo' );
	}
	
	/**
	 * Hide workroom title.
	 *
	 * @since    1.0.0
	 */
	public function wp_title_restrict($title){
		global $current_user, $post;
		if(is_singular('private_workrooms') && !current_user_can( 'administrator' )){
			if(!is_user_logged_in() || !($current_user->ID == $post->post_author)){
				
				$title = esc_html__('Private Workroom','private-workrooms').' #'.$post->ID;
			}
		}
		return $title;
	}
}