<?php
/**
 * Template for displaying a Login/Registration tabs for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/front/before-modal-content.php.
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

<?php if ( !is_user_logged_in() ) { ?>
<div id="login_register_switch">
	<ul>
		<li data-tab="pw_login_form_holder" data-action="default" class="pw_active"><?php esc_html_e('Authorization','private-workrooms')?></li><li data-tab="pw_registration_form_holder" data-action="registration"><?php esc_html_e('Create an account','private-workrooms')?></li>
	</ul>
</div>
<?php }?>