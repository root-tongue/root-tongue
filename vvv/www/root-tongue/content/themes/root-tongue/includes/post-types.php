<?php
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

		# Add some custom columns to the admin screen:
		'admin_cols' => array(
			'title',
			'author',
			'type' => array(
				'title' => 'Type',
				'meta_key' => 'submission_type',
			),
			'theme' => array(
				'title' => 'Theme',
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

	register_extended_taxonomy( 'theme', 'submission' );
	register_extended_taxonomy( 'language', 'submission' );
	register_extended_taxonomy( 'country', 'submission' );


} );