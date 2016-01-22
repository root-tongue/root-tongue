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
				<a class="rt-button" href="/upload/?q=<?php echo get_the_ID() ?>">UPLOAD MEDIA</a>
				<a class="rt-button show-modal" id="show-later-modal" href="#">SUBMIT LATER</a>
				<a class="rt-button" href="#">WATCH NEXT VIDEO</a>
			</div>
			<div class="watch-again">
				<a onClick="history.go(-1)">Watch this video again</a>
			</div>
		</article>
	<?php endwhile;?>

	<?php do_action( 'foundationpress_after_content' ); ?>
	
	<div class="modal" id="submit-later">
		<div class="overlay"></div>
		<div class="modal-content">
			<h3>SUBMIT LATER</h3>
			<p>Praesent gravida blandit tellus et luctus</p>
			<form>
				<input type="text" id="email" placeholder="ENTER EMAIL">
				<div class="submit-row">
					<input type="submit" value="SUBMIT" class="rt-button">
					<div class="rt-button cancel">CANCEL</div>
				</div>
			</form>
		</div>
	</div>

</div>
<?php get_footer(); ?>
