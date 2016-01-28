<?php
namespace Root_Tongue\Abstracts;

abstract class Hooks {

	function __construct() {
		$this->hook();
	}

	protected function hook() {
	}

	protected function unhook() {
	}

	protected function add_ajax_hook( $action, $function, $nopriv = true, $admin = true ) {
		if ( $nopriv ) {
			add_action( "wp_ajax_nopriv_$action", $function );
		}
		if ( $admin ) {
			add_action( "wp_ajax_$action", $function );
		}
	}
}