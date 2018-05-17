	<?php
/*
Template Name: Home
*/
get_header(); ?>
<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); 

	if( ICL_LANGUAGE_CODE=='zh-hant' || ICL_LANGUAGE_CODE=='zh-hans' ){
		$continue_btn='繼續';
		$begin_btn='開始';
		$exlore_video_btn='探索影片';
			if( is_user_logged_in() ){
						$urlred='/zh-hant/videolist';
			} else{ $urlred='/zh-hant/sign-up-to-get-started';} 
		$goto_cg_btn='去創意作品集';
		$goto_cg_link='/zh-hant/community-gallery';
	}
	else{
		$continue_btn='CONTINUE';
		$begin_btn='BEGIN';
		$exlore_video_btn='explore videos';
		if( is_user_logged_in() ){
						$urlred='/videolist';
			} else{ $urlred='/sign-up-to-get-started';} 
		$goto_cg_btn='go to the community gallery';
		$goto_cg_link='/community-gallery';
	}
?>
	<section class="intro" role="main">
		<div id="intro">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" alt="Root Tongue">
		</div>
	</section>
	<section class="instructions instructions1" role="main">
		<div class="centered">
			<?php the_field( 'intro_content_screen_1' ); ?>

			<div class="rt-button" id="next"><?php echo $continue_btn;?></div>
		</div>
	</section>
	<section class="instructions instructions2" role="main">
		<div class="centered">
			<?php the_field( 'intro_content_screen_2' ); ?>
			<div class="rt-button" id="next"><?php echo $continue_btn;?></div>
		</div>
	</section>
	<section class="instructions instructions3" role="main">
		<div class="centered">
			<?php the_field( 'intro_content_screen_3' ); ?>
			<div class="rt-button" id="site_begin"><?php echo $begin_btn;?></div>
		</div>
	</section>

<link rel='stylesheet prefetch' href='<?php bloginfo('template_url');?>/assets/stylesheets/scr.css'>

<div id="fullpage">
	<section class="vertical-scrolling slide_1">
	<h1 class="sld_title"><?php the_field( 'intro_title_slide_1' ); ?></h1>
	<div class="sld_content">
		<?php the_field( 'intro_content_slide_1' ); ?>
	</div>
	<a href="#secondSection/1" class="icon-down_arrow">
		<img src="<?php bloginfo( 'template_url' );?>/assets/images/slide_down_arrow.png" alt="icon" />
	</a>
	</section>
	<section class="vertical-scrolling slide_2">
	<h1 class="sld_title"><?php the_field( 'intro_title_slide_2' ); ?></h1>
	<div class="sld_content">
	<?php the_field( 'intro_content_slide_2' ); ?>
	</div>
	<a href="#thirdSection/1" class="icon-down_arrow">
		<img src="<?php bloginfo('template_url');?>/assets/images/slide_down_arrow.png" alt="icon" />
	</a>
	</section>
	<section class="vertical-scrolling slide_3">
	<h1 class="sld_title"><?php the_field( 'intro_title_slide_3' ); ?></h1>
	<div class="sld_content">
		<?php the_field( 'intro_content_slide_3' ); ?>
	</div>
	<a href="#fourthSection/1" class="icon-down_arrow">
		<img src="<?php bloginfo('template_url');?>/assets/images/slide_down_arrow.png" alt="icon" />
	</a>
	</section>
	<section class="vertical-scrolling slide_4">
	<h1 class="sld_title"><?php the_field( 'intro_title_slide_4' ); ?></h1>
	<div class="sld_content">
	<?php the_field('intro_content_slide_4'); ?>
	</div>
	<div class="btns_hm">
		<a href="<?php echo $urlred;?>">
			<div class="rt-button cancel"><?php echo $exlore_video_btn; ?></div>
		</a>
		<a href="<?php echo $goto_cg_link;?>" class="bck_home"><?php echo $goto_cg_btn; ?></a>
	</div>
	</section>
</div>
<script src='<?php bloginfo( 'template_url' );?>/assets/javascript/custom/scr_ad.js'></script>
<script src='<?php bloginfo( 'template_url' );?>/assets/javascript/custom/scr.js'></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<?php endwhile;?>
<?php do_action( 'foundationpress_after_content' ); ?>

<script type="text/javascript">
	jQuery(document).ready(function($){
		jQuery( '.home' ).removeClass( 'fp-viewing-firstSection' );
			jQuery( '#site_begin' ).click(function(){
			jQuery( '#fullpage,#fp-nav' ).show();
			jQuery( '.home' ).addClass( 'fp-viewing-firstSection' );
			jQuery( '.intro,.instructions' ).hide();
		});
	});
</script>
<?php get_footer(); ?>
