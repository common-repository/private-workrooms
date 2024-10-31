<?php 
/**
 * Template for displaying a list of comments for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/comments.php.
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

<li id="comment-<?php echo $comment->comment_ID ?>" class="comment-type_<?php echo $comment->comment_type ?>">
	<?php if ($comment->comment_type =='regular' ){?>
	<div class="emp"></div>
	<div class="comment-author vcard">
		<div class="comment-meta">
			<img class="pw_avatar pw_post_author_avatar" src="<?php echo get_avatar_url( $comment->comment_author_email,array('size'=>'40')) ?>">
			<div>
				<div><?php echo $comment->comment_author.' / '.date_i18n( get_option('date_format').' '.get_option('time_format'), strtotime( $comment->comment_date ) ) ?></div>
			</div>

		</div>
	</div>
	<div class="comment-content"><?php echo $comment->comment_content ?></div>
	<?php }else{?>
	<div class="comment-author vcard">
		<div class="comment-meta">
			<div class="pw_avatar pw_post_author_avatar pw_post_author_avatar_system text-center">!</div>
			<div>
				<div><?php echo date_i18n( get_option('date_format').' '.get_option('time_format'), strtotime( $comment->comment_date ) ) ?> / <?php echo $comment->comment_content ?></div>
			</div>

		</div>
	</div>
	<div class="comment-content"></div>
	<?php }?>
</li>