<?php
namespace Root_Tongue;

class Email_Messages extends Abstracts\Hooks {

	protected function hook() {
		add_filter( 'retrieve_password_title', array( $this, 'retrieve_password_title' ) );
		add_filter( 'retrieve_password_message', array( $this, 'retrieve_password_message' ), 10, 3 );
		add_filter( 'rt_new_user_email_title', array( $this, 'new_user_email_title' ) );
		add_filter( 'rt_new_user_email_message', array( $this, 'new_user_email_message' ), 10, 3 );
		add_filter( 'rt_submit_later_title', array( $this, 'submit_later_title' ) );
		add_filter( 'rt_submit_later_message', array( $this, 'submit_later_message' ), 10, 2 );
	}

	public function retrieve_password_title( $title ) {
		return __( 'Root Tongue: Password Reset', 'rt' );
	}

	public function retrieve_password_message( $message, $key, $user_login ) {

		// Assemble the URL for resetting the password
		$reset_url = add_query_arg( array(
			'action' => 'rp',
			'key'    => $key,
			'login'  => rawurlencode( $user_login )
		), wp_login_url() );

		// Create and return the message
		$message = sprintf( __( "You have requested that your Root Tongue password be reset for the following account:

Username: %s

If this was a mistake, just ignore this email and no action will be taken.
To reset your password, go to the following address:
%s

All the best,
The Root Tongue Team
", 'rt' ), $user_login, $reset_url );

		return $message;

	}

	public function new_user_email_title() {
		return __( 'Root Tongue: Registration Information', 'rt' );
	}

	public function new_user_email_message( $message, $username, $password ) {
		return sprintf( __( "
Thank you for registering for Root Tongue! We very happy to have you here. Here is your username and password:

username: %s
password: %s

Please keep this login info for future reference.

All the best,
The Root Tongue Team", 'rt' ), $username, $password );

	}

	public function submit_later_title( $title ) {
		return __( 'Root Tongue: Come Back Later', 'rt' );
	}

	public function submit_later_message( $message, $link ) {
		return sprintf( __( "
You requested to come back to Root Tongue and participate later. Here is the link to return to where you left off:

%s

Thanks for viewing and sharing,
The Root Tongue Team
", 'rt' ), $link );

	}
}