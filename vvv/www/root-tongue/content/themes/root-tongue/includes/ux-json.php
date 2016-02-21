<?php

if ( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', function () {
		$rt = rt_get_rt_obj();
		wp_localize_script( 'foundation', 'rt', (array) $rt );
	}, 100 );
}

function rt_get_rt_obj() {
	$rt               = new stdClass();
	$rt->videos       = array();
	$rt->questions    = array();
	$rt->lastVideo    = false;
	$rt->firstVideoID = null;
	$rt->nextVideo    = null;
	$rt->videosPlayed = array();

	if ( ! empty( $_COOKIE['videosPlayed'] ) ) {
		$rt->videosPlayed = json_decode( stripslashes( urldecode( $_COOKIE['videosPlayed'] ) ) );
	}

	$videos    = get_posts( array(
		'post_type'      => 'video',
		'posts_per_page' => - 1,
		'orderby'        => 'menu_order'
	) );
	$questions = get_posts( array(
		'post_type'      => 'question',
		'posts_per_page' => - 1,
	) );

	foreach ( $videos as $i => $video ) {
		if ( $i == 0 ) {
			$rt->firstVideoID = $video->ID;
		}
		$rt->videos[ $video->ID ]       = new stdClass();
		$rt->videos[ $video->ID ]->link = get_permalink( $video );
		$connected_question             = new WP_Query( array(
			'connected_type'      => 'video_to_question',
			'connected_items'     => $video->ID,
			'connected_direction' => 'from',
		) );
		if ( $connected_question->have_posts() ) {
			$rt->videos[ $video->ID ]->question = $connected_question->post->ID;
		}

		if ( $video->ID == get_the_ID() ) {
			$rt->currentVideo = $video->ID;
		}
	}

	foreach ( $questions as $question ) {
		$rt->questions[ $question->ID ]       = new stdClass();
		$rt->questions[ $question->ID ]->link = get_permalink( $question->ID );
		foreach ( $rt->videos as $video_id => $video ) {
			if ( ! empty( $video->question ) && $video->question == $question->ID ) {
				$rt->questions[ $question->ID ]->video = $video_id;
			}
		}
	}

	// find out the current video ID
	if ( empty( $rt->currentVideo ) ) {
		if ( is_singular( 'question' ) ) {
			$rt->currentVideo = $rt->questions[ get_the_ID() ]->video;
		} elseif ( is_page_template( 'templates/upload.php' ) && ! empty( $_REQUEST['q'] ) ) {
			$rt->currentVideo = $rt->questions[ $_REQUEST['q'] ]->video;
		} else {
			// default
			$rt->currentVideo = $rt->firstVideoID;
		}
	}

	// find the unwatched videos
	$videos_played    = array_merge( $rt->videosPlayed, array( $rt->currentVideo ) );
	$all_videos       = array_keys( $rt->videos );
	$unwatched_videos = array_values( array_diff( $all_videos, $videos_played ) );

	// find out if we've watched all the other videos, if so, then this is the last one
	if ( empty( $unwatched_videos ) ) {
		$rt->lastVideo = true;
	}

	// get an array of video IDs in the same order as the array of video objects
	$videos = array_keys( $rt->videos );

	// find the position of that video in the array of video IDs
	$current_video_id = array_search( $rt->currentVideo, $videos );

	// if there is another video ID after that, that's the next video
	if ( array_key_exists( $current_video_id + 1, $videos ) ) {
		$next_video_id = $videos[ $current_video_id + 1 ];
		$rt->nextVideo = $rt->videos[ $next_video_id ];
	} elseif ( ! empty( $unwatched_videos ) ) {
		// if someone is watching videos out of order, then there might be some unwatched videos
		$rt->nextVideo = $rt->videos[ $unwatched_videos[0] ];
	} else {
		// otherwise reset the videos back to the first one
		$rt->nextVideo = $rt->videos[ $rt->firstVideoID ];
	}

	return $rt;
}