<?php
/**
 * Template for displaying a Workroom Details widget for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/sidebar/details.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package    Private_Workrooms
 * @subpackage Private_Workrooms/templates/single/sidebar
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="pw_workroom_details">
	<div class="d-flex justify-content-between align-items-center pw_workroom_details_header">
		<div class="pw_workroom_title"><strong><?php echo sprintf( esc_html__( 'Workroom #%s', 'private-workrooms' ), $post->ID); ?></strong></div>
		<?php
		if ( count( $users_here ) > 1 ) {
			if(!empty( $estimate ) ){
				if($order_status == 'processing'){
					echo '<div class="alert alert-small alert-success">' . esc_html__( 'Processing', 'private-workrooms' ) . '</div>';
				}elseif($order_status == 'completed'){
					echo '<div class="alert alert-small alert-warning">' . esc_html__( 'Completed', 'private-workrooms' ) . '</div>';
				}else{
					echo '<div class="alert alert-small alert-info">' . esc_html__( 'Estimate Provided', 'private-workrooms' ) . '</div>';	
				}
			} else{
				echo '<div class="alert alert-small alert-info">' . esc_html__( 'In Progress', 'private-workrooms' ) . '</div>';
			}
		} else {
			echo '<div class="alert alert-small alert-warning">' .esc_html__( 'Pending for reply', 'private-workrooms' ) . '</div>';
		};
		?>
	</div>
	<?php
	// get the user activity the list


	if ( count( $users_here ) > 1 || $admin ) {
		echo esc_html__('You speak with:','private-workrooms').'<br><br>';
	} else {
		echo '<i>'.esc_html__('We will review the information you provide and will reply shortly. Thank you for understanding.','private-workrooms').'</i><br><br>';
	};
	echo '<ul class="pw_talking_with">';
	foreach ( $users_here as $user ) {
		$user = get_user_by( 'email', $user );
		if ( get_current_user_id() != $user->ID ) {
			echo '<li>
			<div class="d-flex justify-content-start align-items-center">
				<div style="margin-right:15px;">
				<img class="pw_avatar pw_small_avatar" src="' . get_avatar_url( $user->ID ) . '">
				</div>
				<div>
				<strong>' . $user->display_name . '</strong>
				</div>
			</div>
			</li>';
		}
	}
	echo '</ul>';
	foreach ( $users_here as $user ) {
		$user = get_user_by( 'email', $user );
		if ( (get_current_user_id() != $user->ID) && ($user->user_email == 'dummy-client@pwrooms.com') && $admin ) {
			echo '<div style="margin-top:20px;" class="alert alert-info"><strong>Notice!</strong><br>This Workroom was created by the website administrator, so Dummy Client was assigned as post author!<br><br> If you would like to see how everything works on the client-side please log in by using:<br><br> Username: <strong>dummyclient</strong><br>Password: <strong><a target="blank" href="'.get_admin_url().'user-edit.php?user_id='.$user->ID.'">Set password</a></strong>  </div>';
		}
	}
	?>
</div>