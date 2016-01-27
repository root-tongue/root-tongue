<?php
/**
 * The template for displaying single videos
 *
 */

get_header(); ?>

<div id="single-video" role="main" >

	<?php do_action( 'foundationpress_before_content' ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php 
		$url = get_field('video_url');
		?>
		<script type="text/javascript">
			var videoFinished = function(){
				var videosPlayed = Cookies.getJSON('videosPlayed') || [];
				videosPlayed.push(rt['currentVideo']);
				Cookies.set('videosPlayed', videosPlayed);
				if ( rt.lastVideo == true) {
					// if it's the last video, show the "you've watched all videos" link
					$('.modal').show();
				} else {
					// otherwise go to the next video
					location.href=rt['questions'][rt['videos'][rt['currentVideo']].question].link;
				}

			};
			$(document).on('ready', function(){
			    $.okvideo({
				    source: '<?php echo $url; ?>',
      				autoplay: 0,
      				controls: 1,
      				loop: 0,
				    onFinish: videoFinished,
				    onFinished: videoFinished
				});
			});
		</script>
	<?php endwhile;?>

	<?php do_action( 'foundationpress_after_content' ); ?>

	<div class="modal" id="viewed-all">
		<div class="overlay"></div>
		<div class="modal-content">
			<p>YOU HAVE VIEWED ALL THE VIDEOS, NOW IT'S YOUR TURN TO SHARE A STORY.</p>
			<div class="button-row">
				<a href="/upload/?q=<?php echo is_singular('question') ? get_the_ID() : rt_get_rt_obj()->videos[get_the_ID()]->question; ?>" class="rt-button">SHARE STORY</a>
			</div>
			<div class="button-row">
				<a href="/community-gallery" class="rt-button">GO TO COMMUNITY GALLERY</a>
			</div>
		</div>
	</div>

</div>
<?php get_footer(); ?>
