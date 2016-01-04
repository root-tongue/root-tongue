<?php
/*
Template Name: Home
*/
get_header(); ?>


<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
<section class="intro" role="main">
	<div id="intro">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/RTlogo.svg" alt="Root Tongue">
	</div>
</section>
<?php endwhile;?>
<?php do_action( 'foundationpress_after_content' ); ?>


<?php get_footer(); ?>
