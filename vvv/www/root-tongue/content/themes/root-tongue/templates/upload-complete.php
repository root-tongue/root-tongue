<?php
/*
Template Name: Upload Complete
*/

get_header(); ?>
<div id="upload-complete" role="main">

	<?php do_action( 'foundationpress_before_content' ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<section class="upload-complete" role="main">
			<h1 class="large-title">Done</h1>
			<div class="subtitle">
				<?php the_content(); ?>
			</div>
			<div class="next-buttons">
				<a class="rt-button" href="#">VIEW UPLOAD</a>
				<a class="rt-button" href="/community-gallery">COMMUNITY GALLERY</a>
				<a class="rt-button" href="#">NEXT VIDEO</a>
			</div>

	</section>
	<?php endwhile;?>
	<?php do_action( 'foundationpress_after_content' ); ?>

</div>

<?php get_footer(); ?>
