<?php
/**
 * Template for displaying a Demo widget for Private Workrooms
 *
 * This template can be overridden by copying it to yourtheme/private_workrooms/sidebar/demo.php.
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
if ( !defined( 'WPINC' ) ) {
	die;
}
if($admin){
?>
<div class="demo">
	<p style="margin-bottom: 30px;"><strong><?php esc_html_e('Get Private Workrooms Pro!','private-workrooms')?></strong><br><i style="color:#999"><?php esc_html_e('This block is visible only to the administrator!','private-workrooms')?></i></p>
	<hr>
	<p><?php esc_html_e('PRO version, empowers you with more professional tools that speed up your workflow, and allows you to get more conversions and sales!','private-workrooms')?></p>
	<ul>
		<li><?php esc_html_e('✓ Form builder','private-workrooms')?></li>
		<li><?php esc_html_e('✓ Online / offline user statuses','private-workrooms')?></li>
		<li><?php esc_html_e('✓ Attachments vault','private-workrooms')?></li>
		<li><?php esc_html_e('✓ Markdown syntax','private-workrooms')?></li>
		<li><?php esc_html_e('✓ Multiple payments method','private-workrooms')?></li>
		<li><?php esc_html_e('✓ Email notifications','private-workrooms')?></li>
		<li><?php esc_html_e('✓ Dashboards','private-workrooms')?></li>
	</ul>
	<a href="https://pwrooms.com/pricing/" target="_blank" class="pw_btn"><?php esc_html_e('Compare FREE vs. PRO','private-workrooms')?></a>
</div>
<?php } ?>