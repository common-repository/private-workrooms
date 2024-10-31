<?php 
/**
 * Template for displaying a comment form for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/comment-form.php.
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
<form name="pw_single_comment_form" class="pw_standart_form" id="pw_single_comment_form">
	<div class="pw_single_comment_form_md">
		<textarea rows="10" name="pw_comment_content" id="pw_comment_content"></textarea>
	</div>
	<input id="pw_submit_new_comment" type="submit" class="pw_btn" value="<?php esc_html_e('Post Comment','private-workrooms')?>">
	<span class="pw_error empty_comment alert alert-warning">&#128577; <?php esc_html_e("Comment can't be empty",'private-workrooms')?></span> 
</form>