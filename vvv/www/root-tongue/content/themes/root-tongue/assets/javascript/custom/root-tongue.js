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

// Upload Media Page - show uploaded thumbnail file name
$('input#thumbnail').change( function(){
    var path = $(this).val();
	var filename = path.replace(/^.*\\/, "");
    $('.upload-thumbnail span').text(filename);
});

// Question Template - launch submit later modal
$('#show-later-modal').click(function(e){
	e.preventDefault();
	$('#submit-later').show();
});
$('#submit-later .cancel').click(function(e){
	$('#submit-later').hide();
});
