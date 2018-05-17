<?php
/**
 * The template for displaying single questions
 *
 */

get_header();
$rt = rt_get_rt_obj();
if( ICL_LANGUAGE_CODE=='zh-hant' || ICL_LANGUAGE_CODE=='zh-hans'){
		$upload_response_btn='上載回應';
		$submit_later_btn='稍後提交';
		$back_to_video_list_btn='回到影片列表';
		$urlred='/zh-hant/videolist';
		$upload_url='/zh-hant/upload';
		$cg_url='/zh-hant/community-gallery';
		$cg_btn_title='去創意作品集';
	}
	else{
		$upload_response_btn='UPLOAD RESPONSE';
		$submit_later_btn='SUBMIT LATER';
		$back_to_video_list_btn='BACK TO VIDEO LIST';
		$urlred='/videolist';
		$upload_url='/upload';
		$cg_url='/community-gallery';
		$cg_btn_title='GO TO COMMUNITY GALLERY';
	}
?>

<div id="single-question" role="main">

	<?php do_action( 'foundationpress_before_content' ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article class="main-content" <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			<div class="next-buttons">
				<a class="rt-button" href="<?php echo $upload_url;?>/?q=<?php echo get_the_ID() ?>"><?php echo $upload_response_btn;?></a>
				<a class="rt-button" id="show-later-modal" href="#"><?php echo $submit_later_btn;?></a>
				<a class="rt-button" href="<?php echo $urlred;?>"><?php echo $back_to_video_list_btn;?></a>
				<?php /* if ( ! $rt->lastVideo ) : ?>
				<a class="rt-button" href="<?php echo $rt->nextVideo->link ?>">WATCH NEXT VIDEO</a>
				<?php else : ?>
				<a class="rt-button" id="last-question-continue" href="#">CONTINUE</a>
				<?php endif; */?>
			</div>
			<!--<div class="watch-again">
				<a onClick="history.go(-1)">Watch this video again</a>
			</div>-->
		</article>
	<?php endwhile; ?>

	<?php do_action( 'foundationpress_after_content' ); ?>

	<div class="modal" id="submit-later">
		<div class="overlay"></div>
		<div class="modal-content smt_later">					
			<form id="submit-later-form">
				<p> <?php esc_attr_e('Need more time?','login-with-ajax'); ?> </p>
				<p> <?php esc_attr_e('Enter your email address and we\'ll send you','login-with-ajax'); ?></p>
				<p> <?php esc_attr_e('a link so you can come back later.','login-with-ajax'); ?></p>	
				<input type="text" id="email" name="email" placeholder="<?php esc_attr_e('ENTER EMAIL','login-with-ajax'); ?>" value="<?php echo wp_get_current_user()->user_email ?>">
				<div class="submit-row">
					<?php wp_nonce_field( 'rt-submit_later' ) ?>
					<input type="hidden" name="question" value="<?php echo get_the_ID() ?>">
					<input type="submit" value="<?php esc_attr_e('SUBMIT','login-with-ajax'); ?>" class="rt-button">
					<input type="hidden" name="action" value="rt-submit_later">
					<div class="rt-button cancel"><?php esc_attr_e('CANCEL','login-with-ajax'); ?></div>
				</div>
			</form>
			<div id="submit-later-success">
				<h1><?php esc_attr_e('THANK YOU!','login-with-ajax'); ?></h1>
				<p><?php esc_attr_e('Your perspective makes us better.','login-with-ajax'); ?></p>
					<p><?php esc_attr_e('We have sent you an email so you can share later.','login-with-ajax'); ?></p>
					<p>&nbsp;</p>
				<div class="submit-row">
					<div class="rt-button cancel"><?php esc_attr_e('CLOSE','login-with-ajax'); ?></div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="viewed-all">
		<div class="overlay"></div>
		<div class="modal-content">
			<p><?php esc_attr_e('YOU HAVE VIEWED ALL THE VIDEOS, NOW IT\'S YOUR TURN TO SHARE A STORY.','login-with-ajax'); ?></p>
			<div class="button-row">
				<a href="<?php echo $upload_url;?>/?q=<?php echo is_singular('question') ? get_the_ID() : rt_get_rt_obj()->videos[get_the_ID()]->question; ?>" class="rt-button"><?php esc_attr_e('SHARE STORY','login-with-ajax'); ?></a>
			</div>
			<div class="button-row">
				<a href="<?php echo $cg_url;?>" class="rt-button"><?php echo $cg_btn_titlel; ?></a>
			</div>
		</div>
	</div>

</div>
<?php get_footer(); ?>
