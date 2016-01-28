<?php
namespace Root_Tongue\Handlers;

class Submission extends \Root_Tongue\Abstracts\Ajax_Handler {

	protected $action = 'rt-submission';

	protected function check_submission() {
		if ( ! parent::check_submission() ) {
			return false;
		}
		//				$this->errors['top_level'] = __( 'Some required fields were missing.', 'rt' );
		return true;

	}

	private function prepare_submission() {
		$submission = new \stdClass();

		$submission->post_title   = $_REQUEST['title'];
		$submission->post_content = $_REQUEST['description'];
		$submission->post_type    = 'submission';
		$submission->post_status  = 'publish';
		$submission->tax_input    = array(
			'submission_type' => $_REQUEST['submissionType'],
			'language'        => $_REQUEST['language'],
			'country'         => $_REQUEST['country'],
			'theme'           => $_REQUEST['theme']
		);
		$submission->meta_input   = array(
			'video_url' => ! empty( $_REQUEST['video'] ) ? $_REQUEST['video'] : '',
			'audio_url' => ! empty( $_REQUEST['audio'] ) ? $_REQUEST['audio'] : '',
			'text'      => ! empty( $_REQUEST['text'] ) ? $_REQUEST['text'] : '',
		);

		return (array) $submission;

	}

	protected function process_request() {

		// check if someone entered an email that's already been registered
		// if so, first step is to make them log in
		if ( ! is_user_logged_in() && email_exists( $_REQUEST['email'] ) ) {
			$this->login_required();

			return;
		}

		// prepare & create the submission
		$submission = $this->prepare_submission();
		$new_post   = $this->create_submission_post( $submission );

		// if that failed, bail
		if ( is_wp_error( $new_post ) ) {
			$this->errors[] = $new_post->get_error_message();

			return;
		}

		// connect the submission to the question they were answering
		$question_id = $_REQUEST['question'];
		if ( $question_id ) {
			p2p_create_connection( 'submission_to_question', array(
				'from' => $new_post,
				'to'   => $question_id,
			) );
		}

		$this->response['new_user_created'] = false;

		// if the submitter is not logged in, we need to create a user for them
		if ( ! is_user_logged_in() ) {
			$new_user = $this->create_submission_author();

			// for some reason we couldn't create the user, delete the submission because
			// the whole process should fail, then bail
			if ( is_wp_error( $new_user ) ) {
				$this->errors[] = $new_user->get_error_message();
				wp_delete_post( $new_post );

				return;
			}

			// the user was successfully created, set them as the submission author
			$this->set_submission_author( $new_post, $new_user );

			// let the upload page know we created a new user
			$this->response['new_user_created'] = true;
		}

		// we got this far, ok to save uploads to the media library
		$image     = $this->save_media( 'image', $new_post );
		$thumbnail = $this->save_media( 'thumbnail', $new_post );

		// set the featured image
		if ( $image ) {
			set_post_thumbnail( $new_post, $image );
			update_post_meta( $new_post, 'image', $image );
		} elseif ( $thumbnail ) {
			set_post_thumbnail( $new_post, $thumbnail );
		}

		$this->response['next']       = 'success';
		$this->response['submission'] = get_permalink( $new_post );
	}

	private function login_required() {
		$this->response['next'] = 'login';
		$this->return_response();
	}

	private function create_submission_post( $submission ) {
		return wp_insert_post( $submission );
	}

	private function create_submission_author( $sign_in = true ) {
		$password = wp_generate_password( 12, true );
		$new_user = wp_insert_user( array(
			'user_login'   => $_REQUEST['email'],
			'user_email'   => $_REQUEST['email'],
			'user_pass'    => $password,
			'display_name' => explode( '@', $_REQUEST['email'] )[0],
			'role'         => 'contributor',
		) );
		if ( ! is_wp_error( $new_user ) ) {
			$user    = get_userdata( $new_user );
			$subject = apply_filters( 'rt_new_user_email_title', false );
			$message = apply_filters( 'rt_new_user_email_message', false, $user->user_login, $password );
			if ( $subject && $message ) {
				wp_mail( $user->user_email, $subject, $message );
			}
		}
		if ( $sign_in ) {
			wp_signon( array( 'user_login' => $_REQUEST['email'], 'user_password' => $password, 'remember' => true ) );
		}

		return $new_user;
	}

	private function set_submission_author( $post_id, $user_id ) {
		$post                = get_post( $post_id, ARRAY_A );
		$post['post_author'] = $user_id;
		wp_insert_post( $post );

	}

	private function save_media( $file, $post ) {
		if ( empty( $_FILES[ $file ] ) ) {
			return false;
		}
		if ( $_FILES[ $file ]['error'] == UPLOAD_ERR_OK ) {
			require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
			require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
			require_once( ABSPATH . "wp-admin" . '/includes/media.php' );
			$img_id = media_handle_upload( $file, $post );

			return $img_id;
		}

		return false;

	}

	private function return_response() {
		if ( ! empty( $this->errors ) ) {
			$this->response['next'] = 'fail';
		}
		parent::return_result();
	}

}