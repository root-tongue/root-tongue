<?php

namespace Root_Tongue;

class Bootstrap
{
	private static $inited = false;
	private static $classes = array();

	public static function init()
	{
		if ( self::$inited )
		{
			return;
		}
		self::init_hooks();
		self::$inited = true;
	}

	private static function init_hooks()
	{
		add_action( 'init', array( __CLASS__, 'init_classes' ) );
	}

	public static function init_classes()
	{
		self::$classes['upload_handler'] = new Upload_Handler();
	}

	public static function autoloader( $class_name )
	{
		$classes_dir = WP_CONTENT_DIR . 'mu-plugins' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR;
		$class_file  = strtolower( str_replace( array( '_', '\\' ), array( '-', DIRECTORY_SEPARATOR ), $class_name ) . '.php' );
		if ( file_exists( $classes_dir . $class_file ) ) {
			require_once $classes_dir . $class_file;
		}
	}

}

Bootstrap::init();