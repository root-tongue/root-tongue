<?php
/**
 * The template for displaying single questions
 *
 */

get_header(); ?>

<div id="single-question" role="main" >

	<?php do_action( 'foundationpress_before_content' ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article class="main-content" <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			<div class="next-buttons">
				<a class="rt-button" href="/upload/">UPLOAD MEDIA</a>
				<a class="rt-button" href="#">SUBMIT LATER</a>
				<a class="rt-button" href="#">WATCH NEXT VIDEO</a>
			</div>
			<div class="watch-again">
				<a href="#">Watch this video again</a>
			</div>
		</article>
	<?php endwhile;?>

	<?php do_action( 'foundationpress_after_content' ); ?>
</div>
<?php get_footer(); ?>
