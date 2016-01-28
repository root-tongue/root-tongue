<?php
namespace Root_Tongue\Handlers;

class Submit_Later extends \Root_Tongue\Abstracts\Ajax_Handler {

	protected $action = 'rt-submit_later';

	protected function check_submission() {
		if ( ! parent::check_submission() ) {
			return false;
		}
		$valid_email = is_email( $_POST['email'] );
		if ( ! $valid_email ) {
			$this->errors[] = __( 'The email address you entered is not valid.', 'rt' );
		}

		$question       = get_post( $_POST['question'] );
		$valid_question = ! empty( $question );

		if ( ! $valid_question ) {
			$this->errors[] = __( 'Sorry, we can\'t figure out what question you want to come back to', 'rt' );
		}

		return $valid_email && $valid_question;
	}

	protected function process_request() {
		$subject = apply_filters( 'rt_submit_later_title', false );
		$message = apply_filters( 'rt_submit_later_message', false, get_permalink( $_POST['question'] ) );
		if ( wp_mail( $_POST['email'], $subject, $message ) ) {
			$this->response['next'] = 'success';
		} else {
			$this->errors[]         = __( 'We were unable to email you. Try again?', 'rt' );
			$this->response['next'] = 'fail';
		}
	}

	protected function return_result() {
		if ( count( $this->errors ) == 1 ) {
			$this->errors = array( 'top_level' => current( $this->errors ) );
		}
		parent::return_result();
	}

}
