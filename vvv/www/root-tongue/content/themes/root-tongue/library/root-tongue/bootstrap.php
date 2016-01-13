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
		add_action( 'plugins_loaded', array( __CLASS__, 'init_classes' ) );
	}

	public static function init_classes()
	{
		self::$classes['upload_handler'] = new Upload_Handler();
	}

	public static function autoloader( $class_name )
	{
		$classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
		$class_file  = str_replace( array('_', '\\'), array('-', '/'), $class_name ) . '.php';
		if ( file_exists( strtolower( $classes_dir . $class_file ) ) ) {
			require_once strtolower ($classes_dir . $class_file);
		}
	}

}

Bootstrap::init();