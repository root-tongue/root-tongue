// Global Nav - open & close menus
$('.nav-toggle').click(function () {
	$(this).toggleClass('open');
	$(this).next('#main-nav').toggleClass('open');
	$('ul.sub-menu').removeClass('open');
	$('.menu-item-has-children > a').removeClass('expanded')
})
$('.menu-item-has-children > a').click(function () {
	$(this).toggleClass('expanded')
	$(this).next('ul.sub-menu').toggleClass('open');
});

// Upload Media Page - set type of media
$('#upload-form .submission-type').click(function () {
	$(this).addClass('active');
	$(this).siblings().removeClass('active');
	var type = $(this).attr('data-type');
	$('input#submissionType').val(type);
	if (type == 'audio' || type == 'text') {
		$('.upload-thumbnail').show();
	} else {
		$('.upload-thumbnail').hide();
	}
});

// Upload Media Page - launch textbox modal
$('#upload-form .open-modal-textbox').click(function () {
	var placeholder = $(this).attr('data-prompt');
	var inputType = $(this).attr('data-type');
	var modal = $(this).nextAll('.modal');
	var currentType = modal.attr('data-sumbission-type');
	if (inputType != currentType) {
		modal.find('textarea').val('');
	}
	modal.find('textarea').attr('placeholder', placeholder);
	modal.find('textarea').attr('name', inputType);
	modal.attr('data-sumbission-type', inputType);
	modal.show();
});
$('#upload-form .modal .submit').click(function () {
	$('.modal').hide();
});
$('#upload-form .modal .cancel').click(function () {
	$('.modal textarea').val('');
	$('.modal').hide();
});

$('#upload-form').on('submit', function (event) {
	event.preventDefault();
	$('#loading.overlay-fullscreen').show();
	$('.errors').remove();
	$('#existing-user-message').hide();
	var formData = new FormData(this);
	formData.append('action', 'rt_submission');
	$.ajax('/wp-admin/admin-ajax.php', {
		processData: false,
		contentType: false,
		method     : 'POST',
		data       : formData,
		dataType   : 'json',
		success    : function (response) {
			switch (response.next) {
				case 'login' :
					$('#show-login-modal').trigger('click');
					$('#existing-user-message').show();
					$('#user_email').val($('#email').val());
					$('#user-login').data('next', 'submit');
					break;
				case 'success' :
					$('#done.overlay-fullscreen').show();
					$('#view-upload').attr("href", response.submission);
					break;
				case 'fail' :
					var $ul_errors = $('<ul class="errors"/>');
					$.each(response.errors, function (i, error) {
						$ul_errors.append('<li>' + error + '</li>');
					})
					$ul_errors.insertBefore('.login');
			}
			if (response.new_user_created == true) {
				$('#new-user-message').show();
			}
			$('#loading.overlay-fullscreen').hide();
		}
	});
	return false;
});

$('#not-you').on('click', function () {
	$.get($('#logout-url').attr('href'), function () {
		$('#email').val('').prop('disabled', false);
		$('#not-you').hide();
		$('.logout').hide();
		$('.login').show();
		$('#wpadminbar').remove();
		$('body').removeClass('logged-in');
		$('style').remove();
		$.ajax('/wp-admin/admin-ajax.php', {
			method : 'POST',
			data   : {
				action: 'rt_newnonce'
			},
			dataType   : 'json',
			success: function (response) {
				if (response.new_nonce) {
					$('#_wpnonce').val(response.new_nonce);
				}
			}
		})
	});
})

// login form, forgot password form
$('form.lwa-form, form.lwa-remember, div.lwa-register form').on('submit', function(event){
	//Stop event, add loading pic...
	event.preventDefault();
	var form = $(this);
	var ajaxFlag = form.find('.lwa-ajax');
	if( ajaxFlag.length == 0 ){
		ajaxFlag = $('<input class="lwa-ajax" name="lwa" type="hidden" value="1" />');
		form.prepend(ajaxFlag);
	}
	//Make Ajax Call
	var form_action = form.attr('action');
	if( typeof LWA !== 'undefined' ) form_action = LWA.ajaxurl;
	$.ajax({
		type : 'POST',
		url : form_action,
		data : form.serialize(),
		success : function(data){
			if (data.result === true) {
				switch (data.action) {
					case 'login' :
						$.ajax('/wp-admin/admin-ajax.php', {
							method : 'POST',
							data   : {
								action: 'rt_newnonce'
							},
							dataType   : 'json',
							success: function (response) {
								if (response.new_nonce) {
									$('#_wpnonce').val(response.new_nonce);
								}
								if (response.logout_url) {
									$('#logout-url').attr('href', response.logout_url);
								}
								$('.modal').hide();
								if (form.data('next') == 'submit') {
									$('#upload-form #submit-btn').trigger('click');
								} else {
									$('.login').hide();
									if ( response.username) {
										$('.logout').show().find('#current-user').text(response.username);
										$('#not-you').show();
									}
								}
							}
						})
						break;
					case 'remember':
						$('.lost-password-form-container .cta').text(data.message);
						$('.lwa-remember').hide();
						$('.lwa-form')
							.clone(true, true)
							.attr('id', 'user-login-2')
							.insertAfter($('.lwa-remember'))
							.find('.login-form-container').show()
							.find('h1, #existing-user-message, .lost-password').remove();
						$('#user-login-2').find('#user_email')
							.attr('id', 'user-email-2')
							.val($('#remember-email').val());
						break;

				}
			}
		},
		error : function(){ lwaAjax({}, statusElement); },
		dataType : 'jsonp'
	});
	//trigger event
});



// Upload Media Page - show uploaded thumbnail file name
$('input#thumbnail').change(function () {
	var path = $(this).val();
	var filename = path.replace(/^.*\\/, "");
	$('.upload-thumbnail span').text(filename);
});

// Upload Media Page - show login form modal
$('#show-login-modal').click(function (e) {
	e.preventDefault();
	$('#login-form.modal').show();
});
$('.lost-password').click(function () {
	$('.login-form-container').hide();
	$('.lost-password-form-container').show();
});
$('.lost-password-form-container .cancel').click(function () {
	$('.login-form-container').show();
	$('.lost-password-form-container').hide();
});

// Question Template - launch submit later modal
$('.show-modal').click(function (e) {
	e.preventDefault();
	$('.modal').show();
});
$('.modal .cancel').click(function (e) {
	$('.modal').hide();
});

// Gallery Page filters
$('.toggle-list').click(function () {
	$(this).next('.menu').slideToggle('fast');
	$(this).toggleClass('open');
	$(this).parent().siblings('.dropdown').find('.toggle-list').removeClass('open');
	$(this).parent().siblings('.dropdown').find('.menu').slideUp('fast');
});

// Gallery Page Video Thumbnails						

$(window).load(function () {
	if ($('.grid.video').length > 0) {
		$('.grid.video').each(function () {
			var $this = $(this);
			var video = $this.attr('data-video-url');

			function parseVideo(url) {
				url.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

				if (RegExp.$3.indexOf('youtu') > -1) {
					var type = 'youtube';
				} else if (RegExp.$3.indexOf('vimeo') > -1) {
					var type = 'vimeo';
				}

				return {
					type: type,
					id  : RegExp.$6
				};
			}

			function getVideoThumbnail(url) {
				var videoObj = parseVideo(url);
				if (videoObj.type == 'youtube') {
					var imageUrl = 'http://img.youtube.com/vi/' + videoObj.id + '/0.jpg';
					if (!(imageUrl == null)) {
						$this.css('background-image', 'url("' + imageUrl + '")');
					}
				} else if (videoObj.type == 'vimeo') {
					$.get('http://vimeo.com/api/v2/video/' + videoObj.id + '.json', function (data) {
						var imageUrl = data[0].thumbnail_large;
						if (!(imageUrl == null)) {
							$this.css('background-image', 'url("' + imageUrl + '")');
						}
					});
				}
			}

			getVideoThumbnail(video);

		});
	}
});