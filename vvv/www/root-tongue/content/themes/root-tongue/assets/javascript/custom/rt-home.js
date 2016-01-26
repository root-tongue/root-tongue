(function ($) {
	$(document).on('ready', function () {
		if ($('body.home').length) {
			setTimeout(function () {
				if (typeof rt['videos'] != 'undefined' && rt['videos'].length) {
					window.location.href = rt['videos'][0].link;
				}
			}, 5000);
		}
	})
})(jQuery);