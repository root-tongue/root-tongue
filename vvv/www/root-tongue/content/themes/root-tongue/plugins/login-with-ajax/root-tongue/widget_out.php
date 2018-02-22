<?php

/*

 * This is the page users will see logged out. 

 * You can edit this, but for upgrade safety you should copy and modify this file into your template folder.

 * The location from within your template folder is plugins/login-with-ajax/ (create these directories if they don't exist)

*/

?>
<div class="lwa lwa-root-tongue"><?php //class must be here, and if this is a template, class name should be that of template directory ?>
	<form class="lwa-form" action="<?php echo esc_attr( LoginWithAjax::$url_login ); ?>" method="post" id="user-login">
		<span class="lwa-status"></span>
		<div class="login-form-container">
			<div id="existing-user-message" class="cta">Your email address is associated with an existing account. Please enter your password to log in.</div>
			<input type="text" name="log" placeholder="EMAIL" id="user_email">
			<input type="password" name="pwd" placeholder="PASSWORD" id="user_password">
			<?php do_action( 'login_form' ); ?>
			<div class="button-row">
				<input type="submit" name="wp-submit" value="LOGIN" class="rt-button">
				<div class="rt-button cancel">CANCEL</div>
				<input type="hidden" name="lwa_profile_link" value="<?php echo esc_attr( $lwa_data['profile_link'] ); ?>" />
				<input type="hidden" name="login-with-ajax" value="login" />
				<?php if ( ! empty( $lwa_data['redirect'] ) ): ?>
					<input type="hidden" name="redirect_to" value="<?php echo esc_url( $lwa_data['redirect'] ); ?>" />
				<?php endif; ?>
				<input name="rememberme" type="hidden" class="lwa-rememberme" value="forever" />
			</div>
			<div class="lost-password">
				Lost your password?
			</div>
		</div>
	</form>
</div>
<?php if ( ! empty( $lwa_data['remember'] ) ): ?>
	<div class="lost-password-form-container">
		<h1>RESET PASSWORD</h1>
		<div class="cta">Please enter your email address. You will receive a link to create a new password via email.</div>
		<form class="lwa-remember" action="<?php echo esc_attr( LoginWithAjax::$url_remember ) ?>" method="post" id="lost-password">
			<input type="text" name="user_login" id="remember-email" class="lwa-user-remember" placeholder="EMAIL ADDRESS" value="" />
			<div class="button-row">
				<input type="submit" value="SUBMIT" class="rt-button">
				<div class="rt-button cancel">CANCEL</div>
			</div>
			<?php do_action( 'lostpassword_form' ); ?>
			<input type="hidden" name="login-with-ajax" value="remember" />
		</form>
	</div>
<?php endif; ?>