<?php
/*
Template Name: Community Gallery
*/

get_header(); ?>
<div id="community-gallery" role="main">
	<?php query_posts( array( 'post_type' => 'submission', 'posts_per_page' => -1 ,'orderby' => 'date') ); ?>

	<?php get_template_part( 'parts/content-gallery' ) ?>

</div>

<?php get_footer(); ?>
