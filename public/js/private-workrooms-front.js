(function ($) {
	'use strict';
	'esversion: 6';

	$(document).ready(function () {
		
		function modal_adjust(){
			var window_h = $(window).height();
			var modal_h = $('.pw_modal_content_content_real').outerHeight();
			if((modal_h - window_h) > -200) {
				$('#pw_modal_holder').height(modal_h + 200 );
			}else{
				$('#pw_modal_holder').height(window_h);
			}
			$('body').addClass('pw_modal');
		}
		
		$(document).on('click', '#login_register_switch ul li', function () {
			$('#login_register_switch ul li').removeClass('pw_active');
			$(this).addClass('pw_active');
			$('#pw_new_room_form .pw_form_part').hide().find('input').attr('disabled', 'disabled');
			$('#pw_new_room_form').find('#' + $(this).attr('data-tab')).show().find('input').removeAttr('disabled');
			$(this).parents('#pw_modal_holder').find('#pw_new_room_form').attr('data-action', $(this).attr('data-action'));
			$('#pw_new_room_form .pw_alert').hide();
		});
		
		
		if ((PW.room) && (!PW.user || !PW.chosen_one)) {
			$('#pw_modal_bg').removeClass('pw_modal_close');
		}
		$("body").on("click", ".pw_modal_close", function () {
			if ((PW.room) && (!PW.user || !PW.chosen_one)) {
				window.location.href = PW.home;
			} else {
				if ($('#pw_password_reset_success').length > 0){
					window.location.href = PW.my_account;
				}else{
					$(this).closest('#pw_modal_wrap').hide();
					$('body').removeClass('pw_modal');
					
				}
			}
			
		});

		$("body").on("click", "#pw_room, a.pw_room, li.pw_room a, .elementor-element.pw_room a.elementor-button-link", function () {
			if ($('#pw_modal_wrap').length) {
				$('#pw_modal_wrap').show();
			} else {
				$("body").append(PW.modal);
			}
			modal_adjust();
			event.preventDefault();
		});

		/* 
		 ** START @new_room
		 ** Create new private workroom
		 */
		//alert(PW.user);
		$(document).on('submit', '#pw_new_room_form', function () {
			var type;
			var $submit_button = $('#pw_submit_new_room_submit');
			if (!PW.user) {
				type = 'need_to_login';
			} else {
				type = 'new_room';
			}
			if($(this).attr('data-action') == 'registration'){
				type = 'need_to_register';
				var $submit_button = $('#pw_submit_new_room_submit_register');
			}
			
			$.ajax({
				url: PW.ajaxurl,
				data: {
					'action': 'pw_front_ajax',
					'security': PW.ajaxnonce,
					'content': $(this).serialize(),
					'type': type,
					beforeSend: function () {
						$submit_button.replaceWith('<div class="circle-loader"><div class="checkmark draw"></div></div>');
					}
				},
				success: function (data) {
					switch (type) {
						case 'need_to_login':
						case 'need_to_register':
							{
								let $return = JSON.parse(data)
								if ($return.status == true) {
									$('.circle-loader').toggleClass('load-complete');
									$('.checkmark').toggle();
									if (!PW.user && PW.room) {
										location.reload();
									} else {
										setTimeout(function () {
											if ($('#login_register_switch').length) {
												$('#login_register_switch').fadeTo('fast', 0);
											}
											$('#pw_modal_wrap .pw_modal_content_content_real').fadeTo('fast', 0, function () {
												$('#pw_modal_wrap').replaceWith($return.content);
												$('#pw_modal_wrap .pw_modal_content_content_real').css('opacity', 0).fadeTo('fast', 1);
											});
										}, 1000);
										PW.user = true;
									}
								} else {
									$('.circle-loader').replaceWith($submit_button);
									$('#pw_new_room_form .pw_alert').removeClass('pw_alert_info pw_alert_error').addClass('pw_alert_error').html($return.content).show();
								}
								break;
							}
						case 'new_room':
							{
								window.location.replace(data);
								break;
							}
					}
				},
				error: function (errorThrown) {
					console.log(errorThrown);
				}
			});
			event.preventDefault();
		});
		/* 
		 ** END @new_room
		 */

		


	});

})(jQuery);
