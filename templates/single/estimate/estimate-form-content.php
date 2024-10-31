<?php
/**
 * Template for displaying a Estimate Form for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/single/estimate/estimate-form-content.php.
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
<div class="d-flex justify-content-between">
	<input type="hidden" name="payment_type" value="pw_single_payment">
	<div class="flex-grow-1" style="margin-right: 15px;">
		<label class="pw_head_label"><?php esc_html_e('Name of service','private-workrooms')?></label>
		<input name="title_single" required type="text" placeholder="<?php esc_html_e('e.g. Website fixes','private-workrooms')?>" <?php echo ((isset($estimate['title_single']) && $estimate['title_single'] != '') ? 'value="'.$estimate['title_single'].'"' : '')?>>
	</div>
	<div class="ml-auto">
		<label class="pw_head_label"><?php esc_html_e('Price','private-workrooms')?> (<?php echo get_woocommerce_currency_symbol()?>)</label>
		<input name="price_single" required type="number" placeholder="<?php echo get_woocommerce_currency_symbol()?> <?php esc_html_e('99.99','private-workrooms')?>" <?php echo ((isset($estimate['price_single']) && $estimate['price_single'] != '') ? 'value="'.$estimate['price_single'].'"' : '')?>>
	</div>
</div>
<div class="pw_form_block">
	<label class="pw_head_label"><?php esc_html_e('Description','private-workrooms')?></label>
	<textarea name="message" id="message_estimate" rows="10"><?php echo ((isset($estimate['message']) && $estimate['message'] != '') ? $estimate['message'] : '')?></textarea>
</div>
<input type="submit" id="pw_submit_new_estimate" class="craete_new_room pw_btn" name="craete_new_room" value="<?php esc_html_e('Submit & Proceed','private-workrooms')?>">