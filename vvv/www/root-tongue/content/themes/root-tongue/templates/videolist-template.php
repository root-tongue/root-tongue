<?php
/*
Template Name: Video List
*/
get_header(); 
if( ICL_LANGUAGE_CODE=='zh-hant' || ICL_LANGUAGE_CODE=='zh-hans' ){
		$cg_url='/zh-hans/community-gallery';
		$cg_btn_title='去創意作品集';
	}
	else{
		$cg_url='/community-gallery';
		$cg_btn_title='GO TO COMMUNITY GALLERY';
	}
?>
<div id="community-gallery" role="main">
	<?php query_posts( array( 'post_type' => 'video', 'posts_per_page' => -1 ,'orderby' => 'rand' ) ); ?>
	<?php get_template_part('parts/content-video') ?>
	<div class="go_cl"><a href="<?php echo $cg_url;?>"><?php echo $cg_btn_title;?></a></div>
</div>
<?php get_footer(); ?>