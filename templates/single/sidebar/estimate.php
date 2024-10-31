<?php
/**
 * Template for displaying an Estimate widget for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/sidebar/estimate.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package    Private_Workrooms
 * @subpackage Private_Workrooms/templates/single/sidebar
 * @version 1.0.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


?>
<div class="pw_estimate <?php  echo ( !empty( $estimate_meta ) ) ? 'estimate_provided' : 'empty'; ?>">
	<?php
	if ( !empty( $estimate ) ) {

		if ( $order_status ) {
			echo '<div class="alert alert-small alert-success pw_etimate_status">' . esc_html__( 'Payment received', 'private-workrooms' ) . '</div>';
		} else {
			echo '<div class="alert alert-small alert-warning pw_etimate_status">' . esc_html__( 'Waiting for payment', 'private-workrooms' ) . '</div>';
		}
		echo '<img src="' . esc_url( PRIVATE_WORKROOMS_URL . '/public/img/invoice_bill_billing_invoice_bill_2-64.webp' ) . '">';
		echo sprintf( '<h6>%s</h6>', esc_html__( 'Current estimate', 'private-workrooms' ) );
		echo '<hr style="width:100px; border-style:dashed; border-color:#ccc">';

		echo sprintf( '<p style="padding:10px 30px; font-size:14px;"><i>%s</i></p>', $estimate[ 'title_single' ] );
		echo '<h3 style="color:#000">' . get_woocommerce_currency_symbol() . '' . $estimate[ 'price_single' ] . '</h3>';
		echo '<hr style="border-style:dashed; margin: 20px; border-color:#ccc">';

		if ( !$order_status ) {
			if ( $admin ) {
				echo sprintf( '<a href="#" data-post="' . $post->ID . '" class="pw_btn pw_submit_estimate">%s</a><a class="pw_misc_btn pw_remove_estimate" href="#">%s</a>', esc_html__( 'Update an estimate', 'private-workrooms' ), esc_html__( 'Remove', 'private-workrooms' ) );
			} else {
				echo sprintf( '<a href="#" data-post="' . $post->ID . '" class="pw_btn pw_pay_for_estimate">%s</a> <a href="#" data-payment_type="single" data-post="' . $post->ID . '" class="pw_misc_btn pw_view_estimate_details">%s</a>', esc_html__( 'Pay and proceed', 'private-workrooms' ), esc_html__( 'View details', 'private-workrooms' ) );
			}
		} else {
			echo sprintf( '<a href="#" data-post="' . $post->ID . '" class="pw_misc_btn pw_view_estimate_details">%s</a>', esc_html__( 'View details', 'private-workrooms' ) );
		}
	} else {
		echo sprintf( '<h6>%s</h6>', esc_html__( 'Current estimate', 'private-workrooms' ) );
		if ( !$admin ) {
			echo sprintf( '<i class="pw_empty_estimate_label">%s</i>', esc_html__( 'When the time comes and we will be ready to provide you with an estimate, it will appear here.', 'private-workrooms' ) );
		} else {
			echo sprintf( '<p class="pw_empty_estimate_label_for_admin">%s</p><a href="#" class="pw_btn pw_submit_estimate">%s</a>', esc_html__( 'Please submit an estimate if the consultation is over and you both are ready to proceed.', 'private-workrooms' ), esc_html__( 'Submit an estimate', 'private-workrooms' ) );
		}
	}

	?>
</div>
