<?php
/**
 * Enqueue all styles and scripts
 *
 * Learn more about enqueue_script: {@link https://codex.wordpress.org/Function_Reference/wp_enqueue_script}
 * Learn more about enqueue_style: {@link https://codex.wordpress.org/Function_Reference/wp_enqueue_style }
 *
 * @package    WordPress
 * @subpackage FoundationPress
 * @since      FoundationPress 1.0.0
 */

if ( ! function_exists( 'foundationpress_scripts' ) ) :
	function foundationpress_scripts() {

		// Enqueue the main Stylesheet.
		wp_enqueue_style( 'main-stylesheet', get_stylesheet_directory_uri() . '/assets/stylesheets/foundation.css' );

		// Deregister the jquery version bundled with WordPress.
		//wp_deregister_script( 'jquery' );
		wp_deregister_style( 'login-with-ajax' );

		// CDN hosted jQuery placed in the header, as some plugins require that jQuery is loaded in the header.
		//wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js', array(), '2.1.0', false );

		wp_enqueue_script( 'js-cookie', get_template_directory_uri() . '/assets/javascript/vendor/js.cookie.js', array( 'foundation' ), array(), true );
		wp_enqueue_script( 'ok-video', get_template_directory_uri() . '/assets/javascript/vendor/okvideo.js', array(
			'jquery',
			'foundation'
		), '2.3.2', true );

		// If you'd like to cherry-pick the foundation components you need in your project, head over to Gruntfile.js and see lines 124-142.
		// It's a good idea to do this, performance-wise. No need to load everything if you're just going to use the grid anyway, you know :)
		wp_enqueue_script( 'foundation', get_template_directory_uri() . '/assets/javascript/foundation.js', array(
			'jquery',
		), '2.0.0', true );
			wp_enqueue_script( 'jquery-cookie-new', '//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js', array('jquery'), '1.4.1', true );


		// Add the comment-reply library on pages where it is necessary
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}

	add_action( 'wp_enqueue_scripts', 'foundationpress_scripts' );

endif;

?>
