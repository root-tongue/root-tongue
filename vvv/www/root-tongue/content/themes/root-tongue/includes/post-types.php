<?php

/**
 * Register post types using Extended CPTs (in mu-plugins)
 */
add_action( 'init', function() {

	register_extended_post_type( 'video', array(

		'menu_icon' => 'dashicons-editor-video',

		# Add some custom columns to the admin screen:
		'admin_cols' => array(
			'featured_image' => array(
				'title'          => __('Thumbnail', 'rt'),
				'featured_image' => 'thumbnail'
			),
			'title',
			'published' => array(
				'title'       => __('Published', 'rt'),
				'meta_key'    => 'published_date',
			),
		),

		# Add a dropdown filter to the admin screen:
		'admin_filters' => array(
		)

	));

	register_extended_post_type( 'question', array(

		'menu_icon' => 'dashicons-editor-help',

		# Add some custom columns to the admin screen:
		'admin_cols' => array(
			'title',
			'published' => array(
				'title'       => __('Published', 'rt'),
				'meta_key'    => 'published_date',
			),
		),

		# Add a dropdown filter to the admin screen:
		'admin_filters' => array(
		)

	));

	register_extended_post_type( 'submission', array(

		'menu_icon' => 'dashicons-format-status',

		'supports' => array('title', 'editor', 'author', 'thumbnail', 'comments'),

		'labels' => array(
			'featured_image' => __('Thumbnail', 'rt'),
			'set_featured_image' => __('Choose Thumbnail', 'rt'),
			'remove_featured_image' => __('Remove Thumbnail', 'rt'),
			'use_featured_image' => __('Use as Thumbnail', 'rt'),
		),

		# Add some custom columns to the admin screen:
		'admin_cols' => array(
			'title',
			'author',
			'type' => array(
				'title' => __('Type', 'rt'),
				'meta_key' => 'submission_type',
			),
			'theme' => array(
				'taxonomy' => 'theme'
			),
			'language' => array(
				'taxonomy' => 'language'
			),
			'country' => array(
				'taxonomy' => 'country'
			),
			'published' => array(
				'title'       => __('Published', 'rt'),
				'meta_key'    => 'published_date',
			),
		),

		# Add a dropdown filter to the admin screen:
		'admin_filters' => array(
			'theme' => array(
				'taxonomy' => 'theme'
			),
			'language' => array(
				'taxonomy' => 'language'
			),
			'country' => array(
				'taxonomy' => 'country'
			),
		)

	));

	$args = array( 'hierarchical' => false );
	register_extended_taxonomy( 'theme', 'submission', $args );
	register_extended_taxonomy( 'language', 'submission', $args );
	register_extended_taxonomy( 'country', 'submission', $args, array( 'plural' => 'Countries', 'singular' => 'Country' ) );
} );

/**
 * Remove default taxonomy metaboxes from submission post type
 */

add_action( 'admin_menu' , function() {
	remove_meta_box( 'themediv', 'submission', 'side' );
	remove_meta_box( 'languagediv', 'submission', 'side' );
	remove_meta_box( 'countrydiv', 'submission', 'side' );
} );

/**
 * Add posts-to-posts connection types
 */
add_action( 'p2p_init', function () {

	p2p_register_connection_type( array(
		'name' => 'video_to_question',
		'from' => 'video',
		'to' => 'question',
		'cardinality' => 'one-to-one',
		'admin_box' => array(
			'context' => 'advanced',
		),
		'title' => array(
			'from' => __( 'Question', 'rt' ),
			'to' => __( 'Video', 'rt' )
		),
		'from_labels' => array(
			'create' => __( 'Choose Video', 'rt' ),
		),
		'to_labels' => array(
			'create' => __( 'Choose Question', 'rt' ),
		),
	) );

} );