<?php

namespace Root_Tongue;

class Bootstrap {
	private static $inited = false;
	private static $classes = array();

	public static function init() {
		if ( self::$inited ) {
			return;
		}
		self::init_hooks();
		self::$inited = true;
	}

	private static function init_hooks() {
		add_action( 'init', array( __CLASS__, 'init_classes' ) );
	}

	public static function init_classes() {
		self::$classes['submission_handler'] = new Handlers\Submission();
		self::$classes['new_nonce_handler'] = new Handlers\New_Nonce();
		self::$classes['submit_later_handler'] = new Handlers\Submit_Later();
		self::$classes['email_messages'] = new Email_Messages();
	}

	public static function autoloader( $class_name ) {
		$classes_dir = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'mu-plugins' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR;
		$class_file  = strtolower( str_replace( array( '_', '\\' ), array( '-', DIRECTORY_SEPARATOR ), $class_name ) . '.php' );
		if ( file_exists( $classes_dir . $class_file ) ) {
			require_once $classes_dir . $class_file;
		}
	}

}

Bootstrap::init();