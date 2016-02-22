<?php
namespace Root_Tongue\Handlers;

class Submission extends \Root_Tongue\Abstracts\Ajax_Handler {

	protected $action = 'rt-submission';

	protected function check_submission() {
		if ( ! parent::check_submission() ) {
			return false;
		}

		$submission_type = $_REQUEST['submissionType'];

		// check required fields in form
		$required_fields = array(
			'title'    => 'Title',
			'country'  => 'Country',
			'email'    => 'Email',
			'language' => 'Language',
			'theme'    => 'Theme',
		);
		foreach ( $required_fields as $key => $required_field ) {
			if ( empty( $_REQUEST[ $key ] ) ) {
				$this->errors['top_level'] = __( 'Some required fields were missing.', 'rt' );
				$this->errors[]            = "$required_field is required.";
			}
		}

		// check there is a media selected
		if ( empty( $submission_type ) ) {
			$this->errors['top_level'] = __( 'Some required fields were missing.', 'rt' );
			$this->errors[]            = __( 'You must upload at least one type of media using the 4 buttons at the top.', 'rt' );
		}

		// check specific media selected was entered
		if ( $submission_type != 'image' && ! empty( $submission_type ) && empty( $_REQUEST[ $submission_type ] ) ) {
			$this->errors['top_level'] = __( 'Some required fields were missing.', 'rt' );
			$this->errors[]            = sprintf( __( 'You did not enter any %s.', 'rt' ), $submission_type );
		}

		// special check for image 
		if ( $submission_type == 'image' && empty( $_FILES['image']['name'] ) ) {
			$this->errors['top_level'] = __( 'Some required fields were missing.', 'rt' );
			$this->errors[]            = __( 'You did not select an image.', 'rt' );
		}

		// check the video url is youtube or vimeo
		if ( ! empty( $_REQUEST['video'] ) && $submission_type == 'video' ) {
			$regexp = '/^https?:\/\/(youtube.com|youtu.be|vimeo.com)\/(.*)$/';
			if ( ! preg_match( $regexp, $_REQUEST['video'] ) ) {
				$video_error = __( 'Your video URL must come from <a href="http://youtube.com" target="_blank">Youtube</a> or <a href="http://vimeo.com" target="_blank">Vimeo</a>', 'rt' );
				if ( ! empty( $this->errors['top_level'] ) ) {
					$this->errors[] = $video_error;
				} else {
					$this->errors['top_level'] = $video_error;
				}
			}
		}

		// check the audio url is soundcloud
		if ( ! empty( $_REQUEST['audio'] ) && $submission_type == 'audio' ) {
			$regexp = '/^https?:\/\/(soundcloud.com|snd.sc)\/(.*)$/';
			if ( ! preg_match( $regexp, $_REQUEST['audio'] ) ) {
				$audio_error = __( 'Your audio URL must come from <a href="http://soundcloud.com" target="_blank">SoundCloud</a>', 'rt' );
				if ( ! empty( $this->errors['top_level'] ) ) {
					$this->errors[] = $audio_error;
				} else {
					$this->errors['top_level'] = $audio_error;
				}
			}
		}

		// check the email address entered was valid
		if ( ! empty( $_POST['email'] ) && ! is_email( $_POST['email'] ) ) {
			$email_error = __( 'The email address you entered is not valid.', 'rt' );
			if ( ! empty( $this->errors['top_level'] ) ) {
				$this->errors[] = $email_error;
			} else {
				$this->errors['top_level'] = $email_error;
			}
		}

		// check the uploaded files are ok
		foreach ( array( 'image', 'thumbnail' ) as $file ) {
			if ( $file == 'image' && $submission_type != 'image' ) {
				continue;
			}
			if ( ! empty( $_FILES[ $file ]['name'] ) && $_FILES[ $file ]['error'] != UPLOAD_ERR_OK ) {
				if ( $_FILES[ $file ]['error'] == UPLOAD_ERR_INI_SIZE || $_FILES[ $file ]['error'] == UPLOAD_ERR_FORM_SIZE ) {
					$file_error = sprintf( __( 'The %s you uploaded is too large. The limit is %s.', 'rt' ), $file, esc_html( size_format( wp_max_upload_size() ) ) );
				} else {
					$file_error = sprintf( __( 'An error occurred while saving your %s. Please try again.', 'rt' ), $file );
				}
				if ( ! empty( $this->errors['top_level'] ) ) {
					$this->errors[] = $file_error;
				} else {
					$this->errors['top_level'] = $file_error;
				}
			}
		}

		if ( ! empty( $this->errors['top_level'] ) ) {
			return false;
		}

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
			'video_url' => ! empty( $_REQUEST['video'] ) && $_REQUEST['submissionType'] == 'video' ? $_REQUEST['video'] : '',
			'audio_url' => ! empty( $_REQUEST['audio'] ) && $_REQUEST['submissionType'] == 'audio' ? $_REQUEST['audio'] : '',
			'text'      => ! empty( $_REQUEST['text'] ) && $_REQUEST['submissionType'] == 'text' ? $_REQUEST['text'] : '',
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
		if ( ! is_user_logged_in() ) {
			wp_set_current_user( 1 );
			$log_user_out = true;
		}
		$submission = $this->prepare_submission();
		$new_post   = $this->create_submission_post( $submission );
		if ( ! empty( $log_user_out ) ) {
			wp_set_current_user( 0 );
		}

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
		if ( $_REQUEST['submissionType'] == 'image' ) {
			$image = $this->save_media( 'image', $new_post );
		}

		if ( in_array( $_REQUEST['submissionType'], array( 'audio', 'text' ) ) ) {
			$thumbnail = $this->save_media( 'thumbnail', $new_post );
		}

		// set the featured image
		if ( ! empty( $image ) ) {
			set_post_thumbnail( $new_post, $image );
			update_post_meta( $new_post, 'image', $image );
		} elseif ( ! empty( $thumbnail ) ) {
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