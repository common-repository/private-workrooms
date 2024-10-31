<?php
/**
 * Template for displaying a form elements for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/new_room_form.php.
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
<div class="pw_form_block">
	<label class="pw_head_label"><?php esc_html_e('Create a title for your project','private-workrooms')?></label>
	<input name="title" type="text" required placeholder="<?php esc_html_e('e.g. I need my WordPress website fixed','private-workrooms')?>">
</div>
<div class="pw_form_block">
	<label class="pw_head_label"><?php esc_html_e('Describe your project in as much detail as possible','private-workrooms')?></label>
	<textarea name="message" rows="5" required></textarea>
</div>