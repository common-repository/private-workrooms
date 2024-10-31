<?php
/**
 * Template for displaying a Workroom for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/single-private_workroom.php.
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

// * Bootstrap 4.0.0 loaded
// *
// * @since    1.0.0
// *


$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$comments_per_page = 5;
( !isset($_GET[ 'show' ]) || !is_numeric ($_GET[ 'show' ]) ) ? $_GET[ 'show' ] = 'latest': $_GET[ 'show' ] = sanitize_text_field(intval($_GET[ 'show' ]));
( $_GET[ 'show' ] == 'latest' ) ? $_GET[ 'show' ] = ceil( get_comments_number( $post->ID ) / $comments_per_page ): $_GET[ 'show' ] =  sanitize_text_field(intval($_GET[ 'show' ]));

$client = get_user_by( 'id', $post->post_author );
get_header(); ?>
<?php
if ( !current_user_can( 'administrator' ) && ( !is_user_logged_in() || ( $current_user->ID != $post->post_author ) ) ) {
	echo apply_filters( 'pw_modal', array('type' => 'single_workroom') );
} else {
	wp_reset_query();
?>
<div class="container_holder">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="d-flex justify-content-between align-items-center">
					<div class="d-flex justify-content-between align-items-center"> <img class="pw_avatar pw_main_avatar pw_post_author_avatar" src="<?php echo get_avatar_url( $client->ID,array('size'=>'80'));?>">
						<div>
							<h3 class="pw_single_title">
								<?php the_title(); ?>
							</h3>
							<div class="pw_single_meta_holder d-flex">
								<div class="d-flex justify-content-start">
									<?php
										apply_filters( 'pw_workrooms_default_meta', false );
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pw_single_holder">
					<div class="pw_single_description">
						<?php the_content(); ?>
					</div>
					<?php
						apply_filters( 'pw_workrooms_extra_meta', false );
					?>
				</div>
				<div id="private_comments" class="pw_comment_notice notice-info <?php echo (get_comments_number($post->ID) == 0) ? 'pw_no_comments' : '' ; ?>">
					<span>
					<?php
					$count = ceil( get_comments_number( $post->ID ) / $comments_per_page );
					if ( $_GET[ 'show' ] == $count ) {
						if ( get_comments_number( $post->ID ) == 0 ) {
							printf( esc_html__( 'No comments yet', 'private-workrooms' ), $count );
						} else {
							printf( esc_html__( 'Most recent comments', 'private-workrooms' ), $count );
						}
					} else {
						printf( esc_html( _n( 'Conversation just started', 'Page %s / %s', sanitize_text_field(intval($_GET[ 'show' ])), 'private-workrooms' ) ), sanitize_text_field(intval($_GET[ 'show' ])), $count );
					}
					?>
					</span>
				</div>
				<div class="consultation_comments_list">
					<ul class="comments-list">
						<?php
						//Display the list of comments
						wp_list_comments( array(
							'per_page' => $comments_per_page, //Allow comment pagination
							'reverse_top_level' => false, //Show the oldest comments at the top of the list
							'reply_text' => false,
							'paged' => $paged,
							'page' => ( intval($_GET[ 'show' ]) > 1 ) ? intval($_GET[ 'show' ]) : false,
							'avatar_size' => 40,
							'callback' => 'Private_Workrooms_Templates::pw_comment'
						) );
						?>
					</ul>
					<?php if (ceil(get_comments_number($post->ID)/$comments_per_page)>1) {?>
					<div class="work_room_navigation">
						<nav>
							<?php
							paginate_comments_links( array(
								'base' => add_query_arg( 'show', '%#%' ),
								'format' => '',
								'total' => ceil( get_comments_number( $post->ID ) / $comments_per_page ),
								'current' => sanitize_text_field(intval($_GET[ 'show' ])),
								'echo' => true,
								'add_fragment' => '#private_comments',
								'prev_text' => '←',
								'next_text' => '→'
							) );
							?>
						</nav>
					</div>
					<?php } ?>
					<div class="after_pagination"></div>
				</div>
				<div class="pw_single_comment_form">
					<?php

					// Comment form title
					do_action( 'pw_comment_form_before', false );

					// Comment form
					do_action( 'pw_comment_form', false );

					?>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="pw_sidebar">
					<?php
					
					// Sidebar
					apply_filters( 'pw_sidebar', false );

					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }; wp_reset_query(); wp_reset_postdata(); get_footer(); ?>