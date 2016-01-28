<?php
namespace Root_Tongue\Abstracts;

abstract class Ajax_Handler extends Hooks {

	protected $action;
	protected $errors = array();
	protected $response = array();

	protected function hook() {
		if ( empty( $this->action ) ) {
			return;
		}
		$this->add_ajax_hook( $this->action, array( $this, 'handle' ) );
	}

	public function handle() {
		if ( $this->check_submission() ) {
			$this->process_request();
		} else {
			$this->response['next'] = 'fail';
		}
		$this->return_result();
	}

	protected function process_request() {}

	protected function check_submission() {
		if ( ! $this->check_ajax_referer( $this->action ) ) {
			$this->errors['top_level'] = __( 'There was a problem, please try again.', 'rt' );

			return false;
		}

		return true;
	}

	protected function check_ajax_referer( $action ) {
		return check_ajax_referer( $action, null, false );
	}


	protected function return_result() {
		$response           = $this->response;
		$response['errors'] = $this->errors;
		echo json_encode( $response );
		die();
	}
}