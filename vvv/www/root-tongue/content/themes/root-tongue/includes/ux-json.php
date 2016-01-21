<?php

if ( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', function () {
		$rt         = new stdClass();
		$rt->videos = array();
		$videos     = get_posts( array( 'post_type' => 'video', 'posts_per_page' => - 1 ) );
		foreach ( $videos as $i => $video ) {
			$rt->videos[ $i ]       = new stdClass();
			$rt->videos[ $i ]->link = get_permalink( $video );
			$connected_question     = new WP_Query( array(
				'connected_type'      => 'video_to_question',
				'connected_items'     => $video->ID,
				'connected_direction' => 'from',
			) );
			if ( $connected_question->have_posts() ) {
				$rt->videos[ $i ]->question       = $connected_question->post;
				$rt->videos[ $i ]->question->link = get_permalink( $connected_question->post->ID );
			}

			if ( $video->ID == get_the_ID() ) {
				$rt->current_video = $i;
			}
		}
		wp_localize_script( 'foundation', 'rt',(array) $rt );
	}, 100 );
}