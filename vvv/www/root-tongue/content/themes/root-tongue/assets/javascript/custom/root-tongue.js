// Global Nav - open & close menus
$('.nav-toggle').click(function(){
	$(this).toggleClass('open');
	$(this).next('#main-nav').toggleClass('open');
	$('ul.sub-menu').removeClass('open');
	$('.menu-item-has-children > a').removeClass('expanded')
})
$('.menu-item-has-children > a').click(function(){
	$(this).toggleClass('expanded')
	$(this).next('ul.sub-menu').toggleClass('open');
});

// Upload Media Page - set type of media
$('#upload-form .submission-type').click(function(){
	$(this).addClass('active');
	$(this).siblings().removeClass('active');
	var type = $(this).attr('data-type');
	$('input#submissionType').val(type);
	if(type == 'audio' || type == 'text') {
		$('.upload-thumbnail').show();
	} else {
		$('.upload-thumbnail').hide();		
	}
});

// Upload Media Page - launch textbox modal
$('#upload-form .open-modal-textbox').click(function(){
	var placeholder = $(this).attr('data-prompt');
	var inputType = $(this).attr('data-type');
	var modal = $(this).nextAll('.modal');
	var currentType = modal.attr('data-sumbission-type');
	if(inputType != currentType){
		modal.find('textarea').val('');
	}
	modal.find('textarea').attr('placeholder', placeholder);
	modal.find('textarea').attr('name', inputType);
	modal.attr('data-sumbission-type', inputType);
	modal.show();	
});
$('#upload-form .modal .submit').click(function(){
	$('.modal').hide();
});
$('#upload-form .modal .cancel').click(function(){
	$('.modal textarea').val('');
	$('.modal').hide();
});

$('#upload-form').on('submit', function( event ){
	event.preventDefault();
	$('#loading.overlay-fullscreen').show();
	var formData = new FormData(this);
	if (typeof $('#thumbnail')[0].files[0] != 'undefined') {
		formData.append('thumbnail', $('#thumbnail')[0].files[0]);
	}
	formData.append('action', 'rt_submission');
	$.ajax('/wp-admin/admin-ajax.php', {
		processData: false,
		contentType: false,
		method: 'POST',
		data: formData,
		dataType: 'json',
		success: function(response){
			switch (response.next) {
				case 'login' :
					$('#show-login-modal').trigger('click');
					break;
				case 'success' :
					$('#done.overlay-fullscreen').show();
					$('#view-upload').attr("href", response.submission);
					//window.location.href = response.submission;
					break;
			}
		}
	});
	return false;
})

// Upload Media Page - show uploaded thumbnail file name
$('input#thumbnail').change( function(){
    var path = $(this).val();
	var filename = path.replace(/^.*\\/, "");
    $('.upload-thumbnail span').text(filename);
});

// Upload Media Page - show login form modal
$('#show-login-modal').click(function(e){
	e.preventDefault();
	$('#login-form.modal').show();
});
$('.lost-password').click(function(){
	$('.login-form-container').hide();
	$('.lost-password-form-container').show();
});
$('.lost-password-form-container .cancel').click(function(){
	$('.login-form-container').show();
	$('.lost-password-form-container').hide();
});

// Question Template - launch submit later modal
$('.show-modal').click(function(e){
	e.preventDefault();
	$('.modal').show();
});
$('.modal .cancel').click(function(e){
	$('.modal').hide();
});

// Gallery Page filters
$('.toggle-list').click(function(){
	$(this).next('.menu').slideToggle('fast');
	$(this).toggleClass('open');
	$(this).parent().siblings('.dropdown').find('.toggle-list').removeClass('open');
	$(this).parent().siblings('.dropdown').find('.menu').slideUp('fast');
});

// Gallery Page Video Thumbnails						

$( window ).load(function() {
	if ($('.grid.Video').length > 0) { 
		$('.grid.Video').each(function(){
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
			        id: RegExp.$6
			    };
			}
			
			function getVideoThumbnail(url) {
			    var videoObj = parseVideo(url);
			    if (videoObj.type == 'youtube') {
			        	var imageUrl = 'http://img.youtube.com/vi/' + videoObj.id + '/0.jpg';
			        	if (!(imageUrl == null)){
							$this.css('background-image', 'url("' + imageUrl + '")');			        		
			        	}
			    } else if (videoObj.type == 'vimeo') {
			        $.get('http://vimeo.com/api/v2/video/' + videoObj.id + '.json', function(data) {
			            var imageUrl = data[0].thumbnail_large;
			        	if (!(imageUrl == null)){
							$this.css('background-image', 'url("' + imageUrl + '")');
						}
			        });
			    }
			}			
			
			getVideoThumbnail(video);
		
		});
	}
});

