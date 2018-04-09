<?php do_action( 'foundationpress_before_content' ); ?>
<section class="community-gallery" role="main">
	<header id="gallery-top">
		<div class="gallery-title"><?php esc_attr_e('Community Gallery','login-with-ajax'); ?></div>
		<div class="gallery-filter">
			<div class="dropdown theme">
				<div class="toggle-list"><?php esc_attr_e('THEME','login-with-ajax'); ?></div>
				<div class="menu">
					<?php $terms = get_terms( 'theme' );
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
						echo '<ul>';
						foreach ( $terms as $term ) {
							echo '<li><a href="'. get_term_link( $term ).'">'  . $term->name . '</a></li>';
						}
						echo '</ul>';
					} ?>
				</div>
			</div>
			<div class="dropdown language">
				<div class="toggle-list"><?php esc_attr_e('LANGUAGE','login-with-ajax'); ?></div>
				<div class="menu">
					<?php $terms = get_terms( 'language' );
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
						echo '<ul>';
						foreach ( $terms as $term ) {
							echo '<li><a href="'. get_term_link( $term ).'">'  . $term->name . '</a></li>';
						}
						echo '</ul>';
					} ?>
				</div>
			</div>
			<div class="dropdown country">
				<div class="toggle-list"><?php esc_attr_e('COUNTRY','login-with-ajax'); ?></div>
				<div class="menu">
					<?php $terms = get_terms( 'country' );
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
						echo '<ul>';
						foreach ( $terms as $term ) {
							echo '<li><a href="'. get_term_link( $term ).'">'  . $term->name . '</a></li>';
						}
						echo '</ul>';
					} ?>
				</div>
			</div>
		</div>
	</header>
	<section class="gallery-list">
		<?php
		if ( have_posts() ) : while ( have_posts() ) : the_post();
			?>

			<?php
			$terms = get_the_terms( $post->ID, 'submission_type' );
			if ( !empty( $terms ) ) {
				$type =  $terms[0]->name;
				switch ($type) {
					case "image":?>
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );
						$url = $thumb['0']; ?>
						<div class="grid <?php echo $type; ?>" style="background-image:url(<?php echo $url; ?>);">
							<a href="<?php the_permalink(); ?>">
								<span><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/image_icon.png"></span>
							</a>
						</div>
						<?php
						break;
					case "video":?>
						<?php 
							if(get_field('audio_url')!=''){
								$video = get_field('audio_url');
								$icon_v='audio_icon.png';?>
								<div class="grid <?php echo $type; ?>" data-video-url="<?php echo $video; ?>" style="background-color:rgba(208, 220, 40, 0.9);">
									<div class="no_thumb_title"><?php the_title();?></div>
									<a href="<?php the_permalink(); ?>">
										<span><img src="<?php echo get_stylesheet_directory_uri().'/assets/images/'.$icon_v;?>"></span>
									</a>
								</div>
							<?php } else {
								$video = get_field('video_url');
								$icon_v='video_icon.png';
								?>
								<div class="grid <?php echo $type; ?>" data-video-url="<?php echo $video; ?>">
									<a href="<?php the_permalink(); ?>">
										<span><img src="<?php echo get_stylesheet_directory_uri().'/assets/images/'.$icon_v;?>"></span>
									</a>
								</div>
							<?php } ?>
						<?php  break;
					case "audio":?>
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID));
						if ( $thumb ) {
							$url = $thumb[0];?>
							<div class="grid <?php echo $type; ?>" style="background-image:url(<?php echo $url; ?>);">
							<a href="<?php the_permalink(); ?>">
								<span><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/audio_icon.png"></span>
							</a>
						</div>
						<?php } else { ?>						
						<div class="grid <?php echo $type; ?>" style="background-color:rgba(208, 220, 40, 0.9);">
							<div class="no_thumb_title"><?php the_title();?></div>
							<a href="<?php the_permalink(); ?>">
								<span><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/audio_icon.png"></span>
							</a>
						</div>
						<?php }  break;

					case "text":?>
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID));
						if ( $thumb ) {
							$url = $thumb[0];?>
							<div class="grid <?php echo $type; ?>" style="background-image:url(<?php echo $url; ?>);">
							<a href="<?php the_permalink(); ?>">
								<span><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/text_icon.png"></span>
							</a>
						</div>
						<?php } else {
							?>
							<div class="grid <?php echo $type; ?>" style="background-color:rgba(208, 220, 40, 0.9);">
							<div class="no_thumb_title"><?php the_title();?></div>
							<a href="<?php the_permalink(); ?>">
								<span><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/text_icon.png"></span>
							</a>
						</div>
						<?php } ?>
						
						<?php  break;

					default:

				} //end switch

			} //end if
			?>

		<?php endwhile; endif; wp_reset_query(); ?>

	</section>
	

</section>
<?php do_action( 'foundationpress_after_content' ); ?>
