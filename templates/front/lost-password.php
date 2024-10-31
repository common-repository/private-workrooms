<?php
/**
 * Template for displaying a Lost password form for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/front/lost-password.php.
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
<div id="pw_lost_password_form_holder">
	<h5 style="margin-bottom: 30px;"><?php esc_html_e('Password recovery','private-workrooms')?></h5>
	<div class="pw_alert" style=" display: none; margin-bottom: 20px;"></div>
	<form class="pw_standart_form pw_login_register_forms" id="pw_password_recovery_form" data-action="default">
		<div class="pw_form_block">
			<label class="pw_head_label"><?php esc_html_e('E-mail address','private-workrooms')?></label>
			<input name="user_login" required type="text" placeholder="<?php esc_html_e('E-mail','private-workrooms')?>">
		</div>
		<input id="pw_password_recovery" type="submit" class="pw_btn pw_btn_filled" value="<?php esc_html_e('Send Password','private-workrooms')?>">
		<a id="pw_account_login_part" href="#" class="pw_btn_inline pw_switch_part"><?php esc_html_e('Back to Authorization','private-workrooms')?></a>
	</form>
</div>