<?php
/**
 * The template for displaying single submissions
 *
 */

get_header(); ?>

<div id="single-submission" role="main" >

	<?php do_action( 'foundationpress_before_content' ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article class="main-content" <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<div class="left">
				<?php $type = get_field('type'); 
					switch ($type) {

				    case "Image":?>
					<div class="media-holder">
						<?php $image = get_field('image');
						if( !empty($image) ): ?>
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
						<?php endif; ?>
					</div>
				     <?php  break;

				    case "Video":?>
					<div class="media-holder">
						<?php $video = get_field('video_url');
						if( !empty($video) ): ?>
						<div  class="videoWrapper">
						<?php echo wp_oembed_get($video, ''); ?>
						</div>
						<?php endif; ?>
					</div>
				     <?php  break;

				    case "Audio":?>
					<div class="media-holder">
						<?php $audio = get_field('audio_url');
						if( !empty($audio) ): ?>
						<div  class="audioWrapper">
						<?php echo wp_oembed_get($audio, ''); ?>
						</div>
						<?php endif; ?>
					</div>
				     <?php  break;

				    case "Text":?>
					<div class="media-holder">
						<?php $text = get_field('text');
						if( !empty($text) ): ?>
						<p class="text"><?php echo $text; ?></p>
						<?php endif; ?>
					</div>
				     <?php  break;
				    
				    default:
				        echo "There is no media to show";
				}
				?>
			</div>
			<div class="right">
				<h1 class="submission-title"><?php the_title(); ?></h1>
				<div class="meta user">
					<span class="data-label">BY</span>
					<span class="data"><?php the_author();?></span>
				</div>
				<div class="meta theme">
					<span class="data-label">theme</span>
					<span class="data">
					<?php $terms = get_terms( 'theme' );
					 if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					    echo $terms[0]->name;
					}?>
					 </span>
				</div>
				<div class="meta language">
					<span class="data-label">language</span>
					<span class="data">
					<?php $terms = get_terms( 'language' );
					 if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					    echo $terms[0]->name;
					}?>
					</span>
				</div>
				<div class="meta country">
					<span class="data-label">country</span>
					<span class="data">
					<?php $terms = get_terms( 'country' );
					 if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					    echo $terms[0]->name;
					}?>
					</span>
				</div>
				<div class="description">
					<div class="description-label">description</div>
					<?php the_content(); ?>
				</div>
				<div class="button-row">
				<?php if ( is_user_logged_in() ) : ?>
					<a class="rt-button show-modal" href="#">POST A COMMENT</a>
				<?php else : ?>
					<a class="rt-button" id="show-login-modal" href="#">LOG IN TO COMMENT</a>
					
					<div class="modal" id="login-form">
						<div class="overlay"></div>
						<div class="modal-content">
							<div class="login-form-container">
								<h1>LOGIN</h1>
								<form id="user-login" action="">
									<input type="text" placeholder="EMAIL ADDRESS" id="user_email">
									<input type="password" placeholder="PASSWORD" id="user_password">
									<div class="button-row">
										<input type="submit" value="LOGIN" class="rt-button">
											<div class="rt-button cancel">CANCEL</div>
									</div>
									<div class="lost-password">
										Lost your password?
									</div>
								</form>
							</div>
							<div class="lost-password-form-container">
								<h1>RESET PASSWORD</h1>
								<div class="cta">Please enter your email address. You will receive a link to create a new password via email.</div>
								<form id="lost-password" action="">
									<input type="text" placeholder="EMAIL ADDRESS" id="user_email">
									<div class="button-row">
										<input type="submit" value="SUBMIT" class="rt-button">
											<div class="rt-button cancel">CANCEL</div>
									</div>
								</form>
							</div>
						</div>
					</div>

				<?php endif; ?>
					<a class="rt-button" href="/community-gallery">RETURN TO THE GALLERY</a>
				</div>
				
				<?php comments_template(); ?> 

			</div>
		</article>
	<?php endwhile;?>

	<?php do_action( 'foundationpress_after_content' ); ?>
	
</div>
<?php get_footer(); ?>
