<?php
/**
 * Template for displaying a Estimate Details for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/single/estimate/estimate-details.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package    Private_Workrooms
 * @subpackage Private_Workrooms/templates/single/estimate
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="d-flex justify-content-start align-items-center">
	<div class="text-center"  style=" margin-right: 20px;">
		<img src="<?php echo esc_url( PRIVATE_WORKROOMS_URL . '/public/img/tag_sale_coupon_price_tag-64.webp' );?>">
	</div>
	<div>
		<?php if($estimate['payment_type'] == 'pw_single_payment'){?>
		<h6 style="margin-bottom: 3px; color:#000"><?php echo $estimate['title_single'];?></h6>
		<p style="margin-bottom: 0"><strong style="color:#61ce70"><?php echo get_woocommerce_currency_symbol().' '.$estimate['price_single'];?></strong></p>
		<?php }else{
			$stage_count = 0;
			$estimate_total = 0;
			foreach ( $estimate[ 'payment_stages' ] as $stage ) {
				$estimate_total = $estimate_total + $stage[ 'price' ];
				$stage_count++;
			}?>
			<h6 style="margin-bottom: 3px; color:#000"><?php echo $estimate['title_multiple'];?></h6>
			<p style="margin-bottom: 0"><strong style="color:#61ce70"><?php echo get_woocommerce_currency_symbol().' '.$estimate_total;?></strong> <small class="payment_dvided">Amount of invoices: <?php echo $stage_count;?></small></p>
		<?php }?>
	</div>
</div>
<hr>
<?php echo '<div style="padding:20px">'.($estimate['pro_estimate'] ? $estimate['pro_estimate'] : $estimate['message']).'</div>'; ?>	