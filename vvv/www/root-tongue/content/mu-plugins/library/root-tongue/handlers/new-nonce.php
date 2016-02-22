<?php
namespace Root_Tongue\Handlers;

class New_Nonce extends \Root_Tongue\Abstracts\Ajax_Handler {

	protected $action = 'rt-new_nonce';

	protected function process_request() {
		if ( empty( $_POST['nonce_for'] ) ) {
			return;
		}
		$this->response['new_nonce']  = wp_create_nonce( $_POST['nonce_for'] );
		$this->response['username']   = wp_get_current_user()->display_name;
		$this->response['email']   = wp_get_current_user()->user_email;
		$this->response['logout_url'] = htmlspecialchars_decode( wp_logout_url() );
	}

	protected function check_ajax_referer( $action ) {
		return true;
	}

}
