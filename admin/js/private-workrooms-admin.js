(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(document).ready(function(){
		
		$( "body" ).on( "click", "#pw_check_for_updates", function() {
			var this_is = $('#pw_check_for_updates');
			$.ajax({
					url: PW.ajaxurl,
					data: {
						'action': 'pw_admin_ajax',
						'security': PW.ajaxnonce,
						type: 'pw_check_for_updates',
						beforeSend: function () {
							this_is.text('...');
						}
					},
					success: function (data) {
						let $return = JSON.parse(data)
							window.location.reload();
					},
					error: function (errorThrown) {
						console.log(errorThrown);
					}
				});
			event.preventDefault();
		});
		
		
		$( "#pw_settings_page" ).on( "click", ".pw_btn.do_ajax", function() {
			var action_type = $(this).attr('data-type');
			var submit_button;
			let data = [];
			
			if(action_type == 'pw_save_form'){
				$( "#form_drop .form_element" ).each(function() {
					if($( this ).attr('data-type') == 'select'){
						let options = [];
						$( this ).find('.pw_select_options input').each(function() {
							options.push($(this).val());
						});
						data.push({
							options: options,
							default: $( this ).attr('data-default'), 
							type:   $( this ).attr('data-type'), 
							name: $( this ).attr('data-name'), 
							label:  $( this ).find('input[name=label]').val(),
						});
					}else{
						data.push({
							default: $( this ).attr('data-default'), 
							type:   $( this ).attr('data-type'), 
							name: $( this ).attr('data-name'), 
							label:  $( this ).find('input[name=label]').val(),
							placeholder:  $( this ).find('input[name=placeholder]').val()
						});
					}

				});
				console.log(data);
				submit_button = $('#pw_save_form');
			}else if(action_type == 'pw_save_email'){
				submit_button = $('#pw_save_email');
				data.push({email:$('input[name=pw_email_address]').val()})
			}else if(action_type == 'pw_activate_license'){
				submit_button = $('#pw_activate_license');
				data.push({pw_license:$('input[name=pw_license]').val()})
			}else if(action_type == 'pw_welcome_message'){
				submit_button = $('#pw_welcome_message');
				//data.push({});
			}
			$.ajax({
					url: PW.ajaxurl,
					data: {
						'action': 'pw_admin_ajax',
						'security': PW.ajaxnonce,
						'content': JSON.stringify(data),
						type: action_type,
						beforeSend: function () {
							submit_button.replaceWith('<div class="circle-loader"><div class="checkmark draw"></div></div>');
						}
					},
					success: function (data) {
						let $return = JSON.parse(data)
						if ($return.status === true) {
							$('.circle-loader').toggleClass('load-complete');
							$('.checkmark').toggle();
							window.location.reload();
						} else {
							$('.circle-loader').replaceWith(submit_button);
							if(action_type == 'pw_activate_license'){
								$('.pw_licinse_notice').html($return.content).show();
							}
						}
						
						
					},
					error: function (errorThrown) {
						console.log(errorThrown);
					}
				});
			event.preventDefault();
			console.log(data);
		});
		
		
		
		$( "#form_drop" ).on( "click", ".form_element .block_head_title", function() {
			$(this).parents('.form_element').toggleClass('is_open');
		});
		$( "#form_drop" ).on( "click", ".form_element .block_head_remove", function() {
			$(this).parents('.form_element').remove();
		});
		
		
		
		$( "#form_drop" ).on("change paste keyup", "input[name=label]", function() {
			$(this).parents('.form_element').find('.block_head_title').text($(this).val());
		})
		
		$( "#form_drop" ).on( "click", ".pw_select_options .pw_remove_option", function() {
			$(this).parents('.pw_option').remove();
			event.preventDefault();
		});
		$( "#form_drop" ).on( "click", ".block_settings .pw_add_new_option", function() {
			$(this).parents('.block_settings').find('.pw_select_options').append('<div class="pw_option"><input type="text" value=""><div><a href="#" class="pw_remove_option">X</a></div></div>');
			event.preventDefault();
		});
		
		$( "#form_drop" ).sortable({
            connectWith: "#form_drag",
            cursor: "move",
			helper: "clone",
			update: function() {
				$("#form_drop > div").removeAttr('style');
			}
        });
		//jQuery( "#form_drop" ).droppable();
		$( "#form_drag #form_drag_misc > div" ).draggable({
			connectToSortable: "#form_drop",
			helper: "clone",
		}).disableSelection();
		
		$( "#form_drag #form_drag_default > div" ).draggable({
			connectToSortable: "#form_drop",
			helper: "clone",
		}).disableSelection()
      });
	
	
	jQuery( function() {
		
		//$( "#form_builder" ).disableSelection();
	} );

})( jQuery );
