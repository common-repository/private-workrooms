(function ($) {
	'use strict';
	'esversion: 6';

	$(document).ready(function () {
		var simplemde, comment, simplemde_estimate, pro_estimate;
		if (PW.pro) {
			var simplemde = new SimpleMDE({
				element: $("#pw_comment_content")[0],
				autoDownloadFontAwesome: true,
				hideIcons: ["guide", 'fullscreen', 'side-by-side'],
				spellChecker: true,
				status: false
			});
		}

		/* 
		 ** START @new_comment
		 ** Add new comment into a private workroom
		 */
		$("#pw_single_comment_form").submit(function (event) {
			if (PW.pro) {
				comment = simplemde.value();
				comment = simplemde.options.previewRender(comment);
			} else {
				comment = $('#pw_comment_content').val();
			}
			if (comment != '') {
				$.ajax({
					url: PW.ajaxurl,
					data: {
						'action': 'pw_public_ajax',
						'security': PW.ajaxnonce,
						//'post': $(this).attr('data-post'),
						'content': comment,
						'type': 'regular_comment',
						beforeSend: function () {
							$('#pw_submit_new_comment').replaceWith('<div class="circle-loader"><div class="checkmark draw"></div></div>');
						}
					},
					success: function ($id) {
						$('.circle-loader').toggleClass('load-complete');
						$('.checkmark').toggle();
						let url;
						setTimeout(function () {
							url = location.href.split("/");
							url.pop();
							url = url.join("/") + '#comment-' + $id;
							window.location.replace(url);
						}, 1000);
						

					},
					error: function (errorThrown) {
						console.log(errorThrown);
					}
				});
			} else {
				$('.pw_error.empty_comment').fadeTo("slow", 1, function () {
					setTimeout(function () {
						$('.pw_error.empty_comment').fadeTo("slow", 0)
					}, 2000);
				});

			}
			event.preventDefault();
		});
		/* 
		 ** END @new_comment
		 */


		$("body").on("click", ".pw_submit_estimate", function () {
			if ($('#pw_modal_holder.pw_estimate_modal').length) {
				$('#pw_modal_holder.pw_estimate_modal').show();
				$('#pw_modal_wrap').show();
			} else {
				$("body").append(PW.estimate);
				if (PW.pro) {
					var simplemde_estimate = new SimpleMDE({
						element: $("#message_estimate")[0],
						autoDownloadFontAwesome: true,
						hideIcons: ["guide", 'fullscreen', 'side-by-side'],
						spellChecker: true,
						status: false
					});
				}
			}
			modal_adjust();
			/* 
			 ** Provide @new_estimate
			 ** Add new estimate
			 */
			$(document).on('submit', '#pw_new_estimate_form', function () {
				$('#pw_new_estimate_form input').each(function(){
					if($(this).val() == ''){
						$(this).remove();
					}
					
				});
				if (PW.pro) {
					pro_estimate = simplemde_estimate.value();
					pro_estimate = simplemde_estimate.options.previewRender(pro_estimate);
				} else {
					pro_estimate = '';
				}
				$.ajax({
					url: PW.ajaxurl,
					data: {
						'action': 'pw_public_ajax',
						'security': PW.ajaxnonce,
						//'post': $(this).attr('data-post'),
						'content': $('#pw_new_estimate_form').serialize(),
						'type': 'new_estimate',
						'pro_estimate': pro_estimate,
						beforeSend: function () {
							$('#pw_submit_new_estimate').replaceWith('<div class="circle-loader"><div class="checkmark draw"></div></div>');
						}
					},
					success: function () {
						$('.circle-loader').toggleClass('load-complete');
						$('.checkmark').toggle();
						window.location.reload();
					},
					error: function (errorThrown) {
						console.log(errorThrown);
					}
				});

				event.preventDefault();
			});
			/* 
			 ** END @new_estimate
			 */
		});

		$("body").on("click", ".pw_view_estimate_details", function () {
			if ($('#pw_modal_holder.pw_estimate_modal').length) {
				$('#pw_modal_holder.pw_estimate_modal').show();
				$('#pw_modal_wrap').show();
			} else {
				$("body").append(PW.estimate);
			}
			modal_adjust();
		});
		
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

		/* 
		 ** Provide @new_estimate
		 ** Add new estimate
		 */
		$(document).on('click', '.pw_remove_estimate', function () {
			$.ajax({
				url: PW.ajaxurl,
				data: {
					'action': 'pw_public_ajax',
					'security': PW.ajaxnonce,
					'type': 'remove_estimate',
					beforeSend: function () {
						$('.pw_submit_estimate').remove();
						$('.pw_remove_estimate').replaceWith('<div class="circle-loader"><div class="checkmark draw"></div></div>');
					}
				},
				success: function () {
					$('.circle-loader').toggleClass('load-complete');
					$('.checkmark').toggle();
					window.location.reload();
				},
				error: function (errorThrown) {
					console.log(errorThrown);
				}
			});

			event.preventDefault();
		});
		/* 
		 ** END @new_estimate
		 */
		
		$("body").on("click", ".pw_pay_for_estimate", function () {
		var this_is = $(this);
			$.ajax({
				url: PW.ajaxurl,
				data: {
					'action': 'pw_public_ajax',
					'security': PW.ajaxnonce,
					'type': 'pay_for_estimate',
					'id': $(this).attr('data-post'),
					'stage': $(this).attr('data-stage'),
					beforeSend: function () {
						$('.pw_view_estimate_details').remove();
						this_is.replaceWith('<div class="circle-loader"><div class="checkmark draw"></div></div>');
					}
				},
				success: function (data) {
					let $return = JSON.parse(data);
					//$('.circle-loader').toggleClass('load-complete');
					//$('.checkmark').toggle();
					setTimeout(function () {
						var $url = $return.url+'?add-to-cart='+$return.id+'&quantity=1';
						window.location.replace( $url);
					}, 1000);
					//window.location.reload();
				},
				error: function (errorThrown) {
					console.log(errorThrown);
				}
			});

			event.preventDefault();
		});

	});

})(jQuery);
