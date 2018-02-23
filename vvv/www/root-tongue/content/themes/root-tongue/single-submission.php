<?php
/**
 * The template for displaying single submissions
 *
 */

get_header(); ?>

<div id="single-submission" role="main">

	<?php do_action( 'foundationpress_before_content' ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article class="main-content" <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<div class="left">
				<?php
				$terms = get_the_terms( $post->ID, 'submission_type' );
				if ( ! empty( $terms ) ) {
					$type = $terms[0]->name;
					switch ( $type ) {
						case "image":
							?>
							<div class="media-holder">
								<?php if ( has_post_thumbnail() ) :?>
								<div class="img_arrow" id="img_enlarge"><a href="<?php the_post_thumbnail_url('full'); ?>" data-lightbox="example-1"><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/img_arrow.png"></a></div>
								<?php 
									the_post_thumbnail();
								endif; ?>
							</div>
							<?php break;
						case "video":
							?>
							<div class="media-holder">
								<?php $video = get_field( 'video_url' );
								if ( ! empty( $video ) ): ?>
									<div class="videoWrapper">
										<?php echo do_shortcode( '[video]'.$video.'[/video]' ); ?>
									</div>
								<?php endif; ?>
							</div>
							<?php break;
						case "audio":
							?>
							<div class="media-holder">
								<?php if ( has_post_thumbnail() ) :
									the_post_thumbnail();
								else :
									?><img src="http://fakeimg.pl/1400x800/?text=Audio&font=bebas"><?php
								endif; ?>
								<?php $audio = get_field( 'audio_url' );
								if ( ! empty( $audio ) ): ?>
									<div class="audioWrapper">
										<?php echo do_shortcode( '[audio]'.$audio.'[/audio]' ); ?>
									</div>
								<?php endif; ?>
							</div>
							<?php break;
						case "text":
							?>
							<div class="media-holder">
								<?php $text = get_field( 'text' );
								if ( ! empty( $text ) ): ?>
									<p class="text"><?php echo $text; ?></p>
								<?php endif; ?>
							</div>
							<?php break;
						default:
							echo "There is no media to show";
							break;
					}
				}
				?>
				<div class="description">
					<?php $description = get_the_content();
					if ( ! empty( $description ) ) :
						?>
						<?php the_content(); ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="right">
				<div class="type_trm">
					<?php
			$terms = get_the_terms( get_the_ID(), 'submission_type' );
			if ( !empty( $terms ) ) {
				$type =  $terms[0]->name;

				switch ($type) {
					case "image":
					?>
					<div class="green_clr"><span><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/image_icon.png"></span> PHOTOS
					<h1 class="submission-title"><?php the_title(); ?></h1>
					</div>
					<?php
					break;
					case "video":
					?>
					<div class="yellow_clr"><span><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/video_icon.png"></span> VIDEO
					<h1 class="submission-title"><?php the_title(); ?></h1>
					</div>
					<?php
					break;
					case "audio":
					?>
					<div class="prl_clr"><span><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/audio_icon.png"></span> AUDIO
					<h1 class="submission-title"><?php the_title(); ?></h1>
					</div>
					<?php
					break;
					case "text":
					?>
					<div class="blue_clr"><span><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/text_icon.png"></span> TEXT
					<h1 class="submission-title"><?php the_title(); ?></h1>
					</div>
					<?php
					break;
					default:
							echo " ";
							break;
					}
				}
							?>
				</div>
				
				<div class="meta user">
					<span class="data-label">BY</span>
					<span class="data"><?php the_author(); ?></span>
				</div>
				<div class="meta theme">
					<span class="data-label">theme</span>
					<span class="data">

					<?php
					$themes = get_the_terms( $post->ID, 'theme' );

					if ( $themes && ! is_wp_error( $themes ) ) :

						$theme_names = array();

						foreach ( $themes as $theme ) {
							$theme_names[] = $theme->name;
						}

						$theme_list = join( ", ", $theme_names );
						?>

						<?php echo $theme_list; ?>

					<?php endif; ?>

					 </span>
				</div>
				<div class="meta language">
					<span class="data-label">language</span>
					<span class="data">
					<?php
					$languages = get_the_terms( $post->ID, 'language' );

					if ( $languages && ! is_wp_error( $languages ) ) :

						$language_names = array();

						foreach ( $languages as $language ) {
							$language_names[] = $language->name;
						}

						$language_list = join( ", ", $language_names );
						?>

						<?php echo $language_list; ?>

					<?php endif; ?>
					</span>
				</div>
				<div class="meta country">
					<span class="data-label">country</span>
					<span class="data">
					<?php
					$countries = get_the_terms( $post->ID, 'country' );

					if ( $countries && ! is_wp_error( $countries ) ) :

						$country_names = array();

						foreach ( $countries as $country ) {
							$country_names[] = $country->name;
						}

						$country_list = join( ", ", $country_names );
						?>

						<?php echo $country_list; ?>

					<?php endif; ?>
					</span>
				</div>
				
				<div class="button-row">
					<?php if ( is_user_logged_in() ) : ?>
						<a class="rt-button show-modal" href="#">POST A COMMENT</a>
					<?php else : ?>
					
						<a class="rt-button" href="#" id="show-login-modal">POST A COMMENT</a>
						<div class="modal" id="login-form">
						<div class="overlay"></div>
						<div class="modal-content">
							<p class="lhead">LOG IN TO POST A COMMENT.</p>
							<?php login_with_ajax( array( 'template' => 'root-tongue' ) ); ?>
						</div>
					</div>
						<!--<div class="modal" id="login-form">
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
						</div>-->
					<?php endif; ?>
					<a class="rt-button" href="/community-gallery/">BACK TO GALLERY</a>
				</div>
				<?php comments_template(); ?>
			</div>
		</article>
	<?php endwhile; ?>
	<?php do_action( 'foundationpress_after_content' ); ?>
</div>
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ;?>/assets/stylesheets/lightbox.min.css">
	<script src="<?php echo get_stylesheet_directory_uri() ;?>/assets/javascript/custom/lightbox-plus-jquery.min.js"></script>
<?php get_footer(); ?>
