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
			$(function(){
			    $.okvideo({
				    source: '<?php echo $url; ?>',
      				autoplay: false,
      				controls: true,
      				loop: false,
				    onFinished: function(){
				        location.href='/about' // @todo: grab url of next question
				        //$('.modal').show(); @todo: do this if it's the last video
				    }
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
				<a href="/upload" class="rt-button">SHARE STORY</a>
			</div>
			<div class="button-row">
				<a href="/community-gallery" class="rt-button">GO TO COMMUNITY GALLERY</a>
			</div>
		</div>
	</div>

</div>
<?php get_footer(); ?>
