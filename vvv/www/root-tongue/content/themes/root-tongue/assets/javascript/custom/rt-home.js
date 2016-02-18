(function ($) {
	$(document).on('ready', function () {
		if ($('body.home').length) {
			if (typeof rt['firstVideoID'] != 'undefined' && typeof rt['videos'] != 'undefined') {
				var firstVideo = rt['videos'][rt['firstVideoID']];
				$('#enter-site').attr("href", firstVideo.link);
			}
			setTimeout(function () {
				$('body.home').addClass('show-intro');
			}, 5000);
			$('.instructions1 #next').click(function () {
				$('body.home').addClass('show-intro2');
			});
			$('.instructions2 #next').click(function () {
				$('body.home').addClass('show-intro3');
			});
			$('.instructions3 #next').click(function () {
				$('body.home').addClass('show-intro4');
			});
		}
	})
})(jQuery);
