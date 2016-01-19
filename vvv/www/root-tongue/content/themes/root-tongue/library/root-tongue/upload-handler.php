<?php
namespace Root_Tongue;

class Upload_Handler extends Abstracts\Hooks {

	private $errors = array();
	private $response = array();

	protected function hook() {
		add_action( 'wp_ajax_nopriv_rt_submission', array( $this, 'handle_submission' ) );
		add_action( 'wp_ajax_rt_submission', array( $this, 'handle_submission' ) );
	}

	public function handle_submission() {
		if ( check_ajax_referer( 'rt-submission' ) ) {
			if ( ! $this->check_submission() ) {
				$this->errors['top_level'] = __( 'Some required fields were missing.', 'rt' );

				return false;
			}
			$this->do_submit();
		} else {
			$this->errors['top_level'] = __( 'There was a problem with your submission, please try again.', 'rt' );
		}
		$this->return_response();
	}

	private function check_submission() {
		return true;
	}

	private function prepare_submission() {
		$submission = new \stdClass();

		$submission->post_title   = $_REQUEST['title'];
		$submission->post_content = $_REQUEST['description'];
		$submission->post_type    = 'submission';
		$submission->tax_input    = array(
			'language' => $_REQUEST['language'],
			'country'  => $_REQUEST['country'],
			'theme'    => $_REQUEST['theme']
		);
		$submission->meta_input   = array();

		return $submission;

	}

	private function do_submit() {
		if ( email_exists( $_REQUEST['email'] ) ) {
			$this->login_required();

			return;
		}

		$new_user = wp_insert_user( array(
			'user_login'   => $_REQUEST['email'],
			'user_email'   => $_REQUEST['email'],
			'user_pass'    => wp_generate_password( 12, true ),
			'display_name' => explode( '@', $_REQUEST['email'] )[0],
		) );

		if ( is_wp_error( $new_user ) ) {
			return false;
		}

		$submission = $this->prepare_submission();
		$new_post   = $this->create_submission_post( $submission );

		if ( ! empty( $_REQUEST['thumbnail'] ) ) {
			if ( $_FILES['thumbnail']['error'] !== UPLOAD_ERR_OK ) {
				require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
				require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
				require_once( ABSPATH . "wp-admin" . '/includes/media.php' );
				$img_id = media_handle_upload( 'thumbnail', $new_post );
				set_post_thumbnail( $new_post, $img_id );
			}
		}

	}

	private function login_required() {
		$this->response['next'] = 'login';
		$this->return_response();
	}

	private function create_submission_post( $submission ) {
		return wp_insert_post( $submission );
	}

	private function get_submission_type() {
		return $_REQUEST['submissionType'];
	}

	private function return_response() {
		$response = $this->response;
		$response['errors'] = $this->errors;
		echo json_encode( $response );
		die();
	}

}