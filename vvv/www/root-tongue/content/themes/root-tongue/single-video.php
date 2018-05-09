<?php
/**
 * The template for displaying single videos
 *
 */

get_header(); ?>
<div id="single-video" role="main" >
	<?php do_action( 'foundationpress_before_content' ); ?>
	<?php while ( have_posts() ) : the_post(); 
		if( ICL_LANGUAGE_CODE=='zh-hant' || ICL_LANGUAGE_CODE=='zh-hans' ){
		$continue_to_video_btn='繼續觀看視頻';
		$back_to_video_list_btn='回到視頻列表';
		$urlred='/zh-hant/videolist';
	}
	else{
		$continue_to_video_btn='continue to video';
		$back_to_video_list_btn='Back to video list';
		$urlred='/videolist';
	}
	?>
		<?php 
		$url = get_field('video_url');
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript">
			var videoFinished = function(){
				var videosPlayed = Cookies.getJSON('videosPlayed') || [];
				videosPlayed.push(rt['currentVideo']);
				Cookies.set('videosPlayed', videosPlayed);
				location.href=rt['questions'][rt['videos'][rt['currentVideo']].question].link;
			};
			$(document).on('ready', function(){
			    $.okvideo({
				    source: '<?php echo $url; ?>',
      				autoplay: 0,
      				controls: 1,
      				loop: 0,
				    volume: 80,
				    color:'#d0dc28',
				    onFinish: videoFinished,
				    onFinished: videoFinished
				});
				$('#cls_video').on('click',function(){
					location.href=rt['questions'][rt['videos'][rt['currentVideo']].question].link;
				});
			});
		</script>
		<div class="cls_video" id="cls_video" ><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/close_icon.png" alt="close" ></div>
	<?php endwhile;?>
	<?php do_action( 'foundationpress_after_content' ); ?>
	<?php $intro = get_field( "intro_text" );
	if( $intro ) {?>
	<div class="modal" id="video-intro">
		<div class="overlay"></div>
		<div class="modal-content">
			<div class="intro-text">
			<p><?php echo $intro;?></p>
				<div class="button-row">
					<div class="rt-button cancel"><?php echo $continue_to_video_btn; ?></div>
					<div class="bck_to_list"><a href="<?php echo $urlred; ?>" ><?php echo $back_to_video_list_btn; ?></a></div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<?php get_footer(); ?>
