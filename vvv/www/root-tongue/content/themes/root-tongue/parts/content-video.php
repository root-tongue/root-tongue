<?php do_action( 'foundationpress_before_content' ); ?>

<section class="video-list">
		<?php while ( have_posts() ) : the_post(); ?>
		<?php
				$url =get_field('video_url');
				$id = explode('/',$url);
				$width = '100%';
				$height = '200px';
			?>
		<div class="grid video_item">
			<a href="<?php echo get_permalink(get_the_ID());?>">
				<div class="img_bx"><img src="https://img.youtube.com/vi/<?php echo $id[3] ?>/hqdefault.jpg">
					<span class="pl_icon"><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/play_icon.png"></span>
				</div>
				<div class="video_details">
					<h2><?php the_title()?></h2>
					<span class="v_duration"><?php the_field('video_duration'); ?></span>
				</div>
			</a>
		</div>
	<?php endwhile;?>

		<?php  wp_reset_query(); ?>

	</section>


<?php do_action( 'foundationpress_after_content' ); ?>
