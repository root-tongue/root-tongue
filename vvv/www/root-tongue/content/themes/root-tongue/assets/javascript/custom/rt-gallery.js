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