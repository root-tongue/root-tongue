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

// Upload Media Page - show uploaded thumbnail file name
$('input#thumbnail').change(function () {
	var path = $(this).val();
	var filename = path.replace(/^.*\\/, "");
	$('.upload-thumbnail span').text(filename);
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

$(document).on('click', '#user-login-2 .cancel', function () {
	$('#user-login-2').remove();
	$('.login-form-container').show();
	$('.lost-password-form-container').hide();
} );

$('#upload-form').on('submit', function (event) {
	event.preventDefault();
	$('#loading.overlay-fullscreen').show();
	$('.errors').remove();
	$('#existing-user-message').hide();
	var formData = new FormData(this);
	formData.append('action', 'rt-submission');
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
					showFormErrors(response.errors, '.login');
					var offset = $('p.errors').offset().top - 65;
					$('html, body').animate({ scrollTop: offset });
					break;
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
		$('#email').val('').prop('readonly', false);
		$('#not-you').hide();
		$('.logout').hide();
		$('.login').show();
		$('#wpadminbar').remove();
		$('body').removeClass('logged-in');
		$('style').remove();
		$.ajax('/wp-admin/admin-ajax.php', {
			method  : 'POST',
			data    : {
				action   : 'rt-new_nonce',
				nonce_for: 'rt-submission'
			},
			dataType: 'json',
			success : function (response) {
				if (response.new_nonce) {
					$('#_wpnonce').val(response.new_nonce);
				}
			}
		});
	});
})
