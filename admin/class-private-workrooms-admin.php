<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Private_Workrooms
 * @subpackage Private_Workrooms/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Private_Workrooms
 * @subpackage Private_Workrooms/admin
 * @author     Private Workrooms
 */
class Private_Workrooms_Admin {

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
	 * @param      string    $private_workrooms       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $private_workrooms, $version ) {

		$this->private_workrooms = $private_workrooms;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->private_workrooms, plugin_dir_url( __FILE__ ) . 'css/private-workrooms-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->private_workrooms, plugin_dir_url( __FILE__ ) . 'js/private-workrooms-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_localize_script( $this->private_workrooms, 'PW', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'home'=> get_bloginfo('url'), 'ajaxnonce' => wp_create_nonce( "pw_nonce" )));
	}
	
	
	// ------------------
	// * Register a Custom Post Type
	// *
	// * @since    1.0.0
	// *
	public function pw_cpt() {
		
		register_post_type('private_workrooms', array(
			'label'  => null,
			'labels' => array(
				'name' => esc_html__( 'Workrooms', 'private-workrooms' ),
				'singular_name' => esc_html__( 'Workroom', 'private-workrooms' ),
				'new_item' => esc_html__( 'Add New Workroom', 'private-workrooms' ),
				'add_new_item' => esc_html__( 'Add New Workroom', 'private-workrooms' )
			),
			'description'         => '',
			'public'              => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_icon'           => 'dashicons-groups', 
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'supports'            => [ 'author','title', 'editor', 'comments','thumbnail','revisions' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'has_archive'         => false,
			'query_var'           => true,
			'rewrite' => array(
				'with_front' => false,
				'slug'       => 'workroom'
			)
		) );
		
	}
	
	
	
	// ------------------
	// * Rewrite permalinks, allow to use ID instead post title.
	// *
	// * @since    1.0.0
	// *
	public function pw_cpt_permalink( $post_link, $post = 0, $leavename ) {
		if ( $post->post_type == 'private_workrooms' ) {
			return home_url( '/workroom/' . $post->ID );
		} else {
			return $post_link;
		}
	}
	
	
	// ------------------
	// * Rewrite permalinks, allow to use ID instead post title.
	// *
	// * @since    1.0.0
	// *
	public function pw_cpt_rewrites_init() {
		add_rewrite_rule(
			'workroom/([0-9]+)?$',
			'index.php?post_type=private_workrooms&p=$matches[1]',
			'top' );
	}
	
	// ------------------
	// * Rewrite permalinks
	// *
	// * @since    1.0.0
	// *
	public function pw_flush_rewrite_rules() {
		Private_Workrooms_Admin::pw_cpt_rewrites_init();
		flush_rewrite_rules();
	}
	
	
	// ------------------
	// * Metabox for CPT.
	// *
	// * @since    1.0.0
	// *
	public function pw_extra_fields() {
		add_meta_box( 'pw_extra_fields', esc_html__( 'Workroom settings', 'private-workrooms' ), array( $this, 'pw_extra_fields_for_cpt'), 'private_workrooms', 'side', 'low' );
	}
		
	// ------------------
	// * Privacy Settings.
	// *
	// * @since    1.0.0
	// *
	public function pw_extra_fields_for_cpt($post ){
		echo '<div class="privacy_settings_fields">';
			echo '<h4>'.esc_html__( 'Customer', 'private-workrooms' ).'</h4>';
		echo '</div>';
	}
	
	
	// ------------------
	// * Save Extra Fields.
	// *
	// * @since    1.0.0
	// *
	public function pw_extra_fields_update( $post_id ){
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; 
		if ( !current_user_can('edit_post', $post_id) ) return false; 
		if( !isset($_POST['extra']) ) return false;	

		/* Deprecated
		
		$_POST['extra'] = array_map('trim', $_POST['extra']);
		foreach( $_POST['extra'] as $key=>$value ){
			if( empty($value) )	delete_post_meta($post_id, $key);
			update_post_meta($post_id, $key, $value);
		}
		*/
		return $post_id;
	}
	
	// ------------------
	// * Redirect after payment
	// *
	// * @since    1.0.0
	// *
	public function pw_go_back_after_payment($order_id){
		$order = wc_get_order( $order_id );
		$items = $order->get_items();
		foreach ( $items as $item ) {
			$product = $item->get_product(); 
			$product_sku = $product->get_sku();
			$product_id = $item->get_product_id();
			if (strpos($product_sku, 'pwrooms') !== false) {
				$order->update_meta_data( 'pwrooms', sanitize_text_field(str_replace("pwrooms_", "", $product_sku)) );
				$order->save();
				if ( $order->has_status( 'processing' ) ) {
					$product->delete(true);
					do_action( 'pw_new_system_comment', 'system', sanitize_text_field(str_replace("pwrooms_", "", $product_sku)), esc_html__('payment received','private-workrooms'), 'payment_recived' );
					wp_safe_redirect(home_url('/').'/workroom/'. sanitize_text_field(str_replace("pwrooms_", "", $product_sku)).'?cpage=latest');
					exit;
				}
			}
		}
		
	}
	
	public function pw_plugin_links( $links, $plugin_file, $plugin_data ) {
		if ( 'private-workrooms/private-workrooms.php' == $plugin_file ) {
			$slug = 'private-workrooms';

			$links[] = sprintf( '<a href="options-general.php?page=private-workrooms-settings" id="" title="%s">%s</a>',
				esc_attr( sprintf( __( 'Settings' ), $plugin_data[ 'Name' ] ) ),
				__( 'Settings' )
			);
		}

		return $links;
	}
	
	// ------------------
	// * New system comment
	// *
	// * @since    1.0.0
	// *
	public function pw_new_system_comment_function($type = 'system', $id, $comment, $part) {
		if($type){
			$commentdata = array(
				'comment_post_ID' => $id,
				'comment_author' => esc_html__('System','private-workrooms'),
				'comment_content' => $comment,
				'comment_type' => $type,
				'comment_author_email' => '',
				'user_ID' => '',
				'comment_approved' => 1
			);
			wp_insert_comment( $commentdata );
		}
	}
	
	// ------------------
	// * Ajax for an Admin area
	// *
	// * @since    1.0.0
	// *
	public function pw_admin_ajax(){
		if ( isset( $_REQUEST ) && check_ajax_referer( 'pw_nonce', 'security', false ) ) {
			if($_REQUEST['type'] ==  'pw_save_form'){
				$return[ 'status' ] = true;
				//echo $_REQUEST['content'];
				$data = json_decode(wp_unslash($_REQUEST['content']),true);
				foreach ($data as $key => $element){
					if(!isset($element['name']) ){
						$data[$key]['name'] = 'pw_'.md5(uniqid(rand(), true));
						$data[$data[$key]['name']] = $data[$key];
						unset($data[$key]);
					}else{
						$data[$key]['name'] = $data[$key]['name'];
						$data[$data[$key]['name']] = $data[$key];
						unset($data[$key]);
					}
				}
				if(!isset($data['message'])){
					$data['message']['default'] = 'true';
					$data['message']['type'] = 'textarea';
					$data['message']['name'] = 'message';
					$data['message']['label'] = esc_html__('Describe your project in as much detail as possible','private-workrooms');
					$data['message']['placeholder'] = '';
				}
				if(!isset($data['title'])){
					$data['title']['default'] = 'true';
					$data['title']['type'] = 'input';
					$data['title']['name'] = 'title';
					$data['title']['label'] = esc_html__('Create a title for your project','private-workrooms');
					$data['title']['placeholder'] = esc_html__('e.g. I need my WordPress website fixed','private-workrooms');
				}
				update_option( 'pw_form_json', $data );
			}elseif($_REQUEST['type'] ==  'pw_save_email'){
				$return[ 'status' ] = true;
				$data = json_decode(wp_unslash($_REQUEST['content']),true);
				update_option( 'pw_email_address', sanitize_email($data[0]['email']) );
			}elseif($_REQUEST['type'] ==  'pw_activate_license'){
				$data = json_decode(wp_unslash($_REQUEST['content']),true);
				$remote = wp_remote_get( add_query_arg( array(
					'license_check' => urlencode( $data[0]['pw_license'] ),
					'domain' =>  get_option( 'siteurl' )
				), 'https://pwrooms.com/pwrooms.php' ), array(
					'timeout' => 10,
					'headers' => array(
						'Accept' => 'application/json'
					) ) );
				//$return[ 'status' ] = true;
				if ( !is_wp_error( $remote ) && isset( $remote[ 'response' ][ 'code' ] ) && $remote[ 'response' ][ 'code' ] == 200 && !empty( $remote[ 'body' ] ) ) {
					$remote = json_decode( $remote[ 'body' ] );
					$return[ 'status' ] = $remote->status;
					$return[ 'content' ] = $remote->content;
					if($return[ 'status' ] == true){
						update_option( 'pw_license', sanitize_text_field($data[0]['pw_license']) );
					}else{
						update_option( 'pw_license', '' );
					}
				}
				
				//update_option( 'pw_email_address', $data[0]['email'] );
			}elseif($_REQUEST['type'] ==  'pw_check_for_updates'){
				delete_transient( 'private_workrooms_pro_updater' );
			}elseif($_REQUEST['type'] ==  'pw_welcome_message'){
				$return[ 'status' ] = true;
				update_option( 'pw_welcome', true );
			}
		} else {
			$return[ 'status' ] = false;
			$return[ 'content' ] = esc_html__('Security check failed!','private-workrooms');
		}
		echo json_encode( $return, JSON_UNESCAPED_SLASHES );
		wp_die();
		
	}
	
	
	public function pwr_is_activated( $plugin ) {
		if( $plugin == 'private-workrooms/private-workrooms.php' ) {
			exit( wp_redirect( admin_url( 'options-general.php?page=private-workrooms-settings' ) ) );
		}
	}
}