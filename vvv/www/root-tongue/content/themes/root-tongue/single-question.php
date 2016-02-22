<?php
/**
 * The template for displaying single questions
 *
 */

get_header();
$rt = rt_get_rt_obj();

?>

<div id="single-question" role="main">

	<?php do_action( 'foundationpress_before_content' ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article class="main-content" <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			<div class="next-buttons">
				<a class="rt-button" href="/upload/?q=<?php echo get_the_ID() ?>">UPLOAD RESPONSE</a>
				<a class="rt-button" id="show-later-modal" href="#">SUBMIT LATER</a>
				<?php if ( ! $rt->lastVideo ) : ?>
				<a class="rt-button" href="<?php echo $rt->nextVideo->link ?>">WATCH NEXT VIDEO</a>
				<?php else : ?>
				<a class="rt-button" id="last-question-continue" href="#">CONTINUE</a>
				<?php endif; ?>
			</div>
			<div class="watch-again">
				<a onClick="history.go(-1)">Watch this video again</a>
			</div>
		</article>
	<?php endwhile; ?>

	<?php do_action( 'foundationpress_after_content' ); ?>

	<div class="modal" id="submit-later">
		<div class="overlay"></div>
		<div class="modal-content">
			<h3>SUBMIT LATER</h3>
			<h4>Need more time? Enter your email and we'll send you a link so you can come back later.</h4>
			<form id="submit-later-form">
				<input type="text" id="email" name="email" placeholder="ENTER EMAIL" value="<?php echo wp_get_current_user()->user_email ?>">
				<div class="submit-row">
					<?php wp_nonce_field( 'rt-submit_later' ) ?>
					<input type="hidden" name="question" value="<?php echo get_the_ID() ?>">
					<input type="submit" value="SUBMIT" class="rt-button">
					<input type="hidden" name="action" value="rt-submit_later">
					<div class="rt-button cancel">CANCEL</div>
				</div>
			</form>
			<div id="submit-later-success">
				<h4>Your perspective makes us better.</h4>
					<p>We have sent you an email so you can share later. Thanks!</p>
				<div class="submit-row">
					<div class="rt-button cancel">CLOSE</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="viewed-all">
		<div class="overlay"></div>
		<div class="modal-content">
			<p>YOU HAVE VIEWED ALL THE VIDEOS, NOW IT'S YOUR TURN TO SHARE A STORY.</p>
			<div class="button-row">
				<a href="/upload/?q=<?php echo is_singular('question') ? get_the_ID() : rt_get_rt_obj()->videos[get_the_ID()]->question; ?>" class="rt-button">SHARE STORY</a>
			</div>
			<div class="button-row">
				<a href="/community-gallery" class="rt-button">GO TO COMMUNITY GALLERY</a>
			</div>
		</div>
	</div>

</div>
<?php get_footer(); ?>
