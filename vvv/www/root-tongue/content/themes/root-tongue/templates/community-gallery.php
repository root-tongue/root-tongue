<?php
/*
Template Name: Community Gallery
*/

get_header(); ?>
<div id="community-gallery" role="main">

	<?php do_action( 'foundationpress_before_content' ); ?>
	<section class="community-gallery" role="main">
		<header id="gallery-top">
			<div class="gallery-title">Community Gallery</div>
			<div class="gallery-filter">
				<div class="dropdown theme">
					<div class="toggle-list">THEME</div>
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
					<div class="toggle-list">LANGUAGE</div>
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
					<div class="toggle-list">COUNTRY</div>
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
		  query_posts( array( 'post_type' => 'submission'  ) );
		  if ( have_posts() ) : while ( have_posts() ) : the_post();
		?>

				<?php $type = get_field('type'); 
					switch ($type) {

				    case "Image":?>
					<?php $image = get_field('image'); ?>
					<div class="grid <?php echo $type; ?>" style="background-image:url(<?php echo $image['url']; ?>);">
						<a href="<?php the_permalink(); ?>">
							<span>I</span>
						</a>
					</div>
				     <?php  break;

				    case "Video":?>
					<?php $video = get_field('video_url'); ?>
					<div class="grid <?php echo $type; ?>" data-video-url="<?php echo $video; ?>">
						<a href="<?php the_permalink(); ?>">
							<span>V</span>
						</a>
					</div>
				     <?php  break;

				    case "Audio":?>
					<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );
					$url = $thumb['0']; ?>
					<div class="grid <?php echo $type; ?>" style="background-image:url(<?php echo $url; ?>);">
						<a href="<?php the_permalink(); ?>">
							<span>A</span>
						</a>
					</div>
				     <?php  break;

				    case "Text":?>
					<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );
					$url = $thumb['0']; ?>
					<div class="grid <?php echo $type; ?>" style="background-image:url(<?php echo $url; ?>);">
						<a href="<?php the_permalink(); ?>">
							<span>T</span>
						</a>
					</div>
				     <?php  break;
				    
				    default:
				        echo "There is no media to show";
				}
				?>

		<?php endwhile; endif; wp_reset_query(); ?>
			
		</section>
		<section id="bottom-key">
			<div class="key"><span>V</span> = VIDEO</div>
			<div class="key"><span>I</span> = IMAGE</div>
			<div class="key"><span>A</span> = AUDIO</div>
			<div class="key"><span>T</span> = TEXT</div>
		</section>

	</section>
	<?php do_action( 'foundationpress_after_content' ); ?>

</div>

<?php get_footer(); ?>