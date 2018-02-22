<?php
/*
Template Name: Video List
*/
get_header(); ?>
<div id="community-gallery" role="main">
	<?php query_posts( array( 'post_type' => 'video', 'posts_per_page' => -1 ,'orderby' => 'rand' ) ); ?>
	<?php get_template_part('parts/content-video') ?>
	<div class="go_cl"><a href="/community-gallery">GO TO COMMUNITY GALLERY</a></div>
</div>
<?php get_footer(); ?>