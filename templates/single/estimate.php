<?php
/**
 * Template for displaying a Estimate for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/estimate.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package    Private_Workrooms
 * @subpackage Private_Workrooms/templates/single
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php
global $current_user, $post;
$estimate = array();
$estimate_meta = get_post_meta( $post->ID, 'estimate' );
$estimate = $estimate_meta[0];
if ( !empty( $estimate_meta ) ) {
	parse_str( $estimate_meta[ 0 ], $estimate );
	$estimate[ 'pro_estimate' ] = get_post_meta( $post->ID, 'pro_estimate' );
	$estimate[ 'pro_estimate' ] = $estimate[ 'pro_estimate' ][ 0 ];
};
?>
<div id="pw_modal_wrap">
	<div id="pw_modal_holder" class="pw_estimate_modal  <?php echo ( is_user_logged_in() ) ? "pw_logged_in" : "pw_logged_out"; ?> <?php echo (is_single()) ? "pw_room" : "pw_not_room" ?> <?php echo ($current_user->ID == $post->post_author) ? 'chosen_one' : 'not_chosen_one' ?>">
		<div class="pw_e_close pw_modal_close"></div>
		<div class="pw_modal_content_e text-left ">
			<div class="pw_modal_content_content_real text-left ">
			<div id="pw_modal_close" class="pw_modal_close">&#215;</div>
			<?php
			if ( ( $current_user->ID != $post->post_author ) ) {

				// Before estimate form
				do_action( 'pw_estimate_form_before', $estimate );

				// Form
				do_action( 'pw_estimate_form', $estimate );

				// After estimate form
				do_action( 'pw_estimate_form_after', $estimate );

			} else {

				// Estimate details
				do_action( 'pw_estimate_details', $estimate );

			}
			?>
		</div>		
		</div>
	</div>
</div>