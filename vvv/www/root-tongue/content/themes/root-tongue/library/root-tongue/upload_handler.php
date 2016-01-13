<?php
namespace Root_Tongue;

class Upload_Handler extends Abstracts\Hooks {

	private $errors = array();

	private function hook() {
		add_action( 'init', array( $this, 'handle_submission' ) );
	}

	public function handle_submission() {
		if ( wp_verify_nonce( 'rt-submission' ) ) {
			$submission = $this->prepare_submission();
			try {
				$this->create_submission_post();
			} catch (\Exception $e ) {
				$this->errors['top_level'] = $e->getMessage();
			}
		} else {
			$this->errors['top_level'] = __( 'There was a problem with your submission, please try again.', 'rt' );
		}
	}

	private function prepare_submission() {
		$submission = new \stdClass();

		$submission->post_title = $_REQUEST['title'];
		$submission->post_content = $_REQUEST['description'];
		$submission->post_type = 'submission';
		$submission->tax_input = array();
		$submission->meta_input = array();

		/**
		 *
		 *  * @param array $postarr {
		 *     An array of elements that make up a post to update or insert.
		 *
		 *     @type int    $ID                    The post ID. If equal to something other than 0,
		 *                                         the post with that ID will be updated. Default 0.
		 *     @type int    $post_author           The ID of the user who added the post. Default is
		 *                                         the current user ID.
		 *     @type string $post_date             The date of the post. Default is the current time.
		 *     @type string $post_date_gmt         The date of the post in the GMT timezone. Default is
		 *                                         the value of `$post_date`.
		 *     @type mixed  $post_content          The post content. Default empty.
		 *     @type string $post_content_filtered The filtered post content. Default empty.
		 *     @type string $post_title            The post title. Default empty.
		 *     @type string $post_excerpt          The post excerpt. Default empty.
		 *     @type string $post_status           The post status. Default 'draft'.
		 *     @type string $post_type             The post type. Default 'post'.
		 *     @type string $comment_status        Whether the post can accept comments. Accepts 'open' or 'closed'.
		 *                                         Default is the value of 'default_comment_status' option.
		 *     @type string $ping_status           Whether the post can accept pings. Accepts 'open' or 'closed'.
		 *                                         Default is the value of 'default_ping_status' option.
		 *     @type string $post_password         The password to access the post. Default empty.
		 *     @type string $post_name             The post name. Default is the sanitized post title.
		 *     @type string $to_ping               Space or carriage return-separated list of URLs to ping.
		 *                                         Default empty.
		 *     @type string $pinged                Space or carriage return-separated list of URLs that have
		 *                                         been pinged. Default empty.
		 *     @type string $post_modified         The date when the post was last modified. Default is
		 *                                         the current time.
		 *     @type string $post_modified_gmt     The date when the post was last modified in the GMT
		 *                                         timezone. Default is the current time.
		 *     @type int    $post_parent           Set this for the post it belongs to, if any. Default 0.
		 *     @type int    $menu_order            The order the post should be displayed in. Default 0.
		 *     @type string $post_mime_type        The mime type of the post. Default empty.
		 *     @type string $guid                  Global Unique ID for referencing the post. Default empty.
		 *     @type array  $tax_input             Array of taxonomy terms keyed by their taxonomy name. Default empty.
		 *     @type array  $meta_input            Array of post meta values keyed by their post meta key. Default empty.

		 */

	}

	private function create_submission_post() {

	}

	private function get_submission_type() {
		return $_REQUEST['submissionType'];
	}

	private function error_out()
	{
		$_SESSION['rt_submission_errors'] = $this->errors;
	}

}