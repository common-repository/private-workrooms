<?php if(!get_option('pw_welcome')) {?>
<div class="pw_admin_block_popup">
	<div class="pw_admin_block_popup_content">
		<h1 style="font-size: 44px; line-height: 34px;">🎉<br><small style="color: #999; font-size: 18px; font-weight: 400">Hooray!</small></h1>
		<p style="font-size: 16px;">Just drop a shortcode somewhere on your site and your customers will be able to hire you!</p><br>
		<p><span style="font-size: 18px; padding: 10px; background: #f1f1f1">[pwr_get_quote text="Hire us!"]</span></p><br><br>
		<a href="#" data-type="pw_welcome_message" id="pw_welcome_message" class="pw_btn do_ajax">I'm understood, thank you</a>
	</div>
</div>
<?php } ?>