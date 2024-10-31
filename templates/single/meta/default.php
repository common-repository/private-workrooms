<?php
/**
 * Template for displaying a Workroom default meta for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/meta/default.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package    Private_Workrooms
 * @subpackage Private_Workrooms/templates/single/meta
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="pw_single_meta"> <span><?php esc_html_e('Date:','private-workrooms')?> </span><?php the_date(); ?></div>
<div class="pw_single_meta"> <span><?php esc_html_e('Client:','private-workrooms')?> </span><?php echo $client->display_name ?> </div>