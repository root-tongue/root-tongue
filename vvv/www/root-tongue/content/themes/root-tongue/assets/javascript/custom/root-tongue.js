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
