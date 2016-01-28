<?php
namespace Root_Tongue\Abstracts;

abstract class Hooks {

	function __construct() {
		$this->hook();
	}

	protected function hook() {}
	protected function unhook() {}
}