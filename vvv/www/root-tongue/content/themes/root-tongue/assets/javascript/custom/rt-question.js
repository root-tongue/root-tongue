$('#submit-later').on('submit', function (e) {
	e.preventDefault();
	var data = $('#submit-later-form').serializeObject();
	$.ajax('/wp-admin/admin-ajax.php', {
		method  : 'POST',
		data    : data,
		dataType: 'json',
		success : function (response) {
			switch (response.next) {
				case 'success' :
					$('#submit-later-form').hide();
					$('#submit-later h4:first').hide();
					$('#submit-later-success').show();
					break;
				case 'fail' :
					showFormErrors(response.errors, '#submit-later-form');
					break;
			}

		}
	})
});

$('#show-later-modal').click(function (e) {
	e.preventDefault();
	$('#submit-later').show();
});

$('#submit-later .cancel').on('click', function () {
	$('.errors').remove();
})

$('#submit-later-success .cancel').on('click', function(){
	$('#submit-later-success').hide();
	$('#submit-later-form').show();
	$('#submit-later p:first').show();
})

$('#last-question-continue').on('click', function(){
	$('#viewed-all').show();
	return false;
})