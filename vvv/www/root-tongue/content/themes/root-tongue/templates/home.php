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
	<section class="instructions instructions1" role="main">
		<div class="centered">
			<?php the_field('intro_content_screen_1'); ?>
			<div class="rt-button" id="next">NEXT</div>
		</div>
	</section>
	<section class="instructions instructions2" role="main">
		<div class="centered">
			<?php the_field('intro_content_screen_2'); ?>
			<div class="rt-button" id="next">NEXT</div>
		</div>
	</section>
	<section class="instructions instructions3" role="main">
		<div class="centered">
			<?php the_field('intro_content_screen_3'); ?>
			<div class="rt-button" id="next">NEXT</div>
		</div>
	</section>
	<section class="instructions instructions4" role="main">
		<div class="how-it-works">
			<?php the_field('intro_content_screen_4'); ?>
			<a href="" class="rt-button" id="enter-site">BEGIN</a>
		</div>
	</section>
<?php endwhile;?>
<?php do_action( 'foundationpress_after_content' ); ?>


<?php get_footer(); ?>
