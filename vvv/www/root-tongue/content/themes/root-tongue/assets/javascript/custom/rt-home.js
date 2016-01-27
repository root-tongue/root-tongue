(function ($) {
	$(document).on('ready', function () {
		if ($('body.home').length) {
			setTimeout(function () {
				if (typeof rt['firstVideoID'] != 'undefined' && typeof rt['videos'] != 'undefined') {
					var firstVideo = rt['videos'][rt['firstVideoID']];
					window.location.href = firstVideo.link;
				}
			}, 5000);
		}
	})
})(jQuery);