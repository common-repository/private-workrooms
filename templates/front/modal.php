<?php
/**
 * Template for displaying a Modal Window form for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/front/modal.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package    Private_Workrooms
 * @subpackage Private_Workrooms/templates/front
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php
global $current_user, $post, $check_password_reset_key;
?>
<div id="pw_modal_wrap">
	<div id="pw_modal_holder" class="<?php echo ( is_user_logged_in() ) ? "pw_logged_in" : "pw_logged_out"; ?> <?php echo (is_singular('private_workrooms')) ? "pw_room" : "pw_not_room" ?> <?php echo (($current_user->ID == $post->post_author) || (current_user_can( 'administrator' )) ) ? 'chosen_one' : 'not_chosen_one' ?>">
		<div class="pw_e_close pw_modal_close"></div>
		<div class="pw_modal_content_e text-left ">
			
			<?php (($placement['type'] == 'single_workroom') || ($placement['type'] == 'password_recovery') ) ? : do_action('pw_before_modal_content', false);?>
			<div class="pw_modal_content_content_real text-left ">
				<div id="pw_modal_close" class="pw_modal_close">&#215;</div>
				<?php if($placement['type'] == 'password_recovery'){
					echo '<h4 id="pw_password_reset_success" class="pw_modal_headeing">' . __( 'Password Recovery', 'private-workrooms' ) . '</h4>';
					echo '<p class="pw_modal_description">'.sanitize_email($_GET['lostpassword']).'</p>';
					echo '<p class="">' .$placement['message'] . '</p>';
				}else{?>
				<?php 
					if(is_user_logged_in()){
						if (is_singular('private_workrooms')){
							if(($current_user->ID == $post->post_author) || current_user_can( 'administrator' )){
								echo '<h4 class="pw_modal_headeing">' . esc_html__( 'Start a project', 'private-workrooms' ) . '</h4>';
								echo '<p class="pw_modal_description">' . esc_html__( 'Free estimate | No obligation to hire | 100% risk-free', 'private-workrooms' ) . '</p>';
							}else{
								echo '<h4 class="pw_modal_headeing">' . esc_html__( 'Access denied', 'private-workrooms' ) . '</h4>';
								echo '<p class="pw_modal_description">' . esc_html__( "Unfortunately, you don't have access to view this workroom!", 'private-workrooms' ) . '</p>';
								echo '<a href="'.get_bloginfo('url').'" class="pw_btn">'.esc_html__( 'Go Home', 'private-workrooms' ).'<a/>';
							}
						}else{
							echo '<h4 class="pw_modal_headeing">' . esc_html__( 'Start a project', 'private-workrooms' ) . '</h4>';
							echo '<p class="pw_modal_description">' . esc_html__( 'Free estimate | No obligation to hire | 100% risk-free', 'private-workrooms' ) . '</p>';
						}
					}else{
						if (is_singular('private_workrooms')){
							echo '<h4 class="pw_modal_headeing">' . esc_html__( 'Access restricted', 'private-workrooms' ) . '</h4>';
							echo '<p class="pw_modal_description">' . esc_html__( 'You must be logged in to view this private workroom', 'private-workrooms' ) . '</p>';
						}else{
							echo '<h4 class="pw_modal_headeing">' . esc_html__( 'Start a project', 'private-workrooms' ) . '</h4>';
							echo '<p class="pw_modal_description">' . esc_html__( 'Free estimate | No obligation to hire | 100% risk-free', 'private-workrooms' ) . '</p>';
						}
					}	
				?>
				<form id="pw_new_room_form" class="pw_standart_form" data-action="default">
					<div class="pw_new_room_form">
						<?php 
						if ( !is_user_logged_in() ) {
							echo '<div class="pw_alert pw_alert_info" style="display: none;"></div>';
							do_action( 'pw_login_form', false );
						} elseif((isset($post->post_author) && $current_user->ID == $post->post_author) || !is_singular('private_workrooms') || current_user_can( 'administrator' ) ) { 
							apply_filters( 'pw_new_room_form', false );
							echo '<input type="submit" id="pw_submit_new_room_submit" class="craete_new_room pw_btn" name="craete_new_room" value="' . esc_html__( 'Submit & Proceed', 'private-workrooms' ) . '">';
						 }?>
					</div>
				</form>
			<?php } ?>
			</div>
		</div>
	</div>
</div>
