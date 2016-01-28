// Global Nav - open & close menus
$('.nav-toggle').click(function () {
	$(this).toggleClass('open');
	$(this).next('#main-nav').toggleClass('open');
	$('ul.sub-menu').removeClass('open');
	$('.menu-item-has-children > a').removeClass('expanded')
});

$('.menu-item-has-children > a').click(function () {
	$(this).toggleClass('expanded')
	$(this).next('ul.sub-menu').toggleClass('open');
});

$('.show-modal').click(function (e) {
	e.preventDefault();
	$('.modal').show();
});
$('.modal .cancel').click(function (e) {
	$('.modal').hide();
});

// login form, forgot password form
$('form.lwa-form, form.lwa-remember, div.lwa-register form').on('submit', function (event) {
	//Stop event, add loading pic...
	event.preventDefault();
	var form = $(this);
	var ajaxFlag = form.find('.lwa-ajax');
	if (ajaxFlag.length == 0) {
		ajaxFlag = $('<input class="lwa-ajax" name="lwa" type="hidden" value="1" />');
		form.prepend(ajaxFlag);
	}
	//Make Ajax Call
	var form_action = form.attr('action');
	if (typeof LWA !== 'undefined') form_action = LWA.ajaxurl;
	$.ajax({
		type    : 'POST',
		url     : form_action,
		data    : form.serialize(),
		success : function (data) {
			if (data.result === true) {
				switch (data.action) {
					case 'login' :
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
								if (response.logout_url) {
									$('#logout-url').attr('href', response.logout_url);
								}
								$('.modal').hide();
								if (form.data('next') == 'submit') {
									$('#upload-form #submit-btn').trigger('click');
								} else {
									$('.login').hide();
									if (response.username) {
										$('.logout').show().find('#current-user').text(response.username);
										$('#not-you').show();
									}
								}
							}
						})
						break;
					case 'remember':
						var $lwaRemember = $('.lwa-remember');
						$('.lost-password-form-container .cta').text(data.message);
						$lwaRemember.hide();
						$('.lwa-form')
							.clone(true, true)
							.attr('id', 'user-login-2')
							.insertAfter($lwaRemember)
							.find('.login-form-container').show()
							.find('h1, #existing-user-message, .lost-password').remove();
						$('#user-login-2').find('#user_email')
							.attr('id', 'user-email-2')
							.val($('#remember-email').val());
						break;

				}
			}
		},
		error   : function () {
			lwaAjax({}, statusElement);
		},
		dataType: 'jsonp'
	});
});