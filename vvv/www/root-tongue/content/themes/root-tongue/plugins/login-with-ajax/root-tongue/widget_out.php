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
			<div id="existing-user-message" class="cta"><?php esc_attr_e('Your email address is associated with an existing account. Please enter your password to log in.','login-with-ajax'); ?></div>
			<input type="text" name="log" placeholder="<?php esc_attr_e('email','login-with-ajax'); ?>" id="user_email">
			<input type="password" name="pwd" placeholder="<?php esc_attr_e('Password','login-with-ajax'); ?>" id="user_password">
			<?php do_action( 'login_form' ); ?>
			<div class="button-row">
				<input type="submit" name="wp-submit" value="<?php esc_attr_e('Log In','login-with-ajax'); ?>" class="rt-button">
				<div class="rt-button cancel"><?php esc_attr_e('Cancel','login-with-ajax'); ?></div>
				<input type="hidden" name="lwa_profile_link" value="<?php echo esc_attr( $lwa_data['profile_link'] ); ?>" />
				<input type="hidden" name="login-with-ajax" value="login" />
				<?php if ( ! empty( $lwa_data['redirect'] ) ): ?>
					<input type="hidden" name="redirect_to" value="<?php echo esc_url( $lwa_data['redirect'] ); ?>" />
				<?php endif; ?>
				<input name="rememberme" type="hidden" class="lwa-rememberme" value="forever" />
			</div>
			<div class="lost-password">
				<?php esc_attr_e('Lost your password?','login-with-ajax'); ?>
			</div>
		</div>
	</form>
</div>
<?php if ( ! empty( $lwa_data['remember'] ) ): ?>
	<div class="lost-password-form-container">
		<h1><?php esc_attr_e('RESET PASSWORD','login-with-ajax'); ?></h1>
		<div class="cta"><?php esc_attr_e('Please enter your email address. You will receive a link to create a new password via email.','login-with-ajax'); ?></div>
		<form class="lwa-remember" action="<?php echo esc_attr( LoginWithAjax::$url_remember ) ?>" method="post" id="lost-password">
			<input type="text" name="user_login" id="remember-email" class="lwa-user-remember" placeholder="<?php esc_attr_e('EMAIL ADDRESS','login-with-ajax'); ?>" value="" />
			<div class="button-row">
				<input type="submit" value="<?php esc_attr_e('SUBMIT','login-with-ajax'); ?>" class="rt-button">
				<div class="rt-button cancel"><?php esc_attr_e('Cancel','login-with-ajax'); ?></div>
			</div>
			<?php do_action( 'lostpassword_form' ); ?>
			<input type="hidden" name="login-with-ajax" value="remember" />
		</form>
	</div>
<?php endif; ?>