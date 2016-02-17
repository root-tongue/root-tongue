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
		<h1>Among the approximately 6,000 languages in the world, an average of 2 languages disappear each month.</h1>

	</section>
	<section class="instructions instructions2" role="main">
		<p>Root Tongue enables you to explore the challenges of language endangerment and preservation by experiencing and sharing stories of language loss and revival.</p>
		<p>How it works:</p>
		<ul>
			<li><span>1</span>watch the videos</li>
			<li><span>2</span>after each video plays you will be asked a question</li>
			<li><span>3</span>respond with your stories in text, image, audio or video</li>
			<li><span>4</span>visit the community gallery to see and comment on other responses</li>
		</ul>
		<a href="" class="rt-button" id="enter-site">ENTER</a>
	</section>
<?php endwhile;?>
<?php do_action( 'foundationpress_after_content' ); ?>


<?php get_footer(); ?>
