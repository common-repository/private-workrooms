<?php
/**
 * Template for displaying a Comment form heading for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/comment-form-before.php.
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
<div class="pw_single_comment_form_title">
	<div class="d-flex justify-content-between align-items-center">
		<div class="d-flex justify-content-start align-items-center">
			<div class="line"></div>
			<h4><?php echo apply_filters('pw_comment_form_before_tilte', false) ?></h4>
		</div>
	</div>
</div>