<?php
/**
 * Template for displaying a Login/Registration form for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/front/login-form.php.
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
<div id="pw_login_form_holder" class="pw_form_part">
	<div class="pw_form_block">
		<label class="pw_head_label"><?php esc_html_e('Username or E-mail address','private-workrooms')?></label>
		<input name="user_login" required type="text" placeholder="<?php esc_html_e('Username','private-workrooms')?>">
		<label class="pw_head_label"><?php esc_html_e('Password','private-workrooms')?></label>
		<input name="user_password" required type="password" placeholder="********">
		<input type="checkbox" name="remember" value="true" checked="checked">
		<label name="remember" class="pw_checkbox_label"><?php esc_html_e('Remember me','private-workrooms')?></label>
	</div>
	<input id="pw_submit_new_room_submit" type="submit" class="pw_btn" value="<?php esc_html_e('Authorize & Proceed','private-workrooms')?>">
</div>

<div id="pw_registration_form_holder" style="display: none;"  class="pw_form_part">
	<div class="pw_form_block">
		<div class="pw_flex pw_2_in_row">
			<div>
				<label class="pw_head_label"><?php esc_html_e('Login','private-workrooms')?></label>
				<input name="login" disabled='disabled' required type="text" placeholder="<?php esc_html_e('Login','private-workrooms')?>">
			</div>
			<div>
				<label class="pw_head_label"><?php esc_html_e('E-mail Address','private-workrooms')?></label>
				<input name="email" required disabled='disabled' type="email" placeholder="<?php esc_html_e('e-mail','private-workrooms')?>">
			</div>
		</div>
	</div>
	<input id="pw_submit_new_room_submit_register" disabled='disabled' class="pw_btn" type="submit" value="<?php esc_html_e('Register & Proceed','private-workrooms')?>">
</div>