<?php  
/* 
Template Name: Sign up
*/
the_post();
get_header();
?><div id="page" role="main">
	<header>
		<h1 class="entry-title"><?php the_title();?></h1>
	</header>
	<div class="entry-content">
	<?php
	$error= '';
	$success = ''; 
	global $wpdb, $PasswordHash, $current_user, $user_ID; 
		if( isset( $_POST['action'] ) && $_POST['action'] == 'register' ) {
			$password1 = $_POST['password1'];
			$email = $_POST['email1'];
			$username = $_POST['email1'];
			if( $email == "" || $password1 == "" || $username == "") {
				$error= __('All Fields Are Required.','login-with-ajax');
			} else if( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
				$error= __('Invalid email address.','login-with-ajax');
			} else if( email_exists($email) ) {
				$error= __('Email already exist.','login-with-ajax');
			} else {
				$new_user = wp_insert_user( array(
						'user_login'   => $email,
						'user_email'   => $username,
						'user_pass'    => $password1,
						'display_name' => explode( '@', $email )[0],
						'role'         => 'contributor',
					) );
				if( is_wp_error($new_user) ) {
					$error= __('Error on user creation.','login-with-ajax');
				} 
				else {
						$user    = get_userdata( $new_user );
						$subject = apply_filters( 'rt_new_user_email_title', false );
						$message = apply_filters( 'rt_new_user_email_message', false, $email, $password1 );
						if ( $subject && $message ) {
							wp_mail( $email, $subject, $message );
						}

					do_action( 'user_register', $new_user);
					$success =  __('You are successfully register','login-with-ajax');
				}
			}
		}
		?><!--display error/success message-->
		<div id="message">
			<?php 
				if(! empty($err) ) :
					echo '<p class="error">'.$err.'';
				endif;
			?>
			<?php 
				if(! empty($success) ) :
					echo '<p class="error">'.$success.'';
					wp_redirect( '/success' , 301 ); exit;
				endif;
			?>
		</div>
		<form method="post" class="sng_frm">
			<h3 class="already_acc"> <?php esc_attr_e('ALREADY HAVE AN ACCOUNT?','login-with-ajax'); ?> <a href="<?php echo get_home_url(); ?>/login" class="under_line"><?php esc_attr_e('SIGN IN','login-with-ajax'); ?></a>.</h3>
			<p><input type="text" value="" placeholder="<?php esc_attr_e('email','login-with-ajax'); ?>" name="email1" class="input_box" id="email" /></p>
			<p><input type="password" value="" name="password1" class="input_box" id="password1" placeholder="<?php esc_attr_e('Password','login-with-ajax'); ?>" /></p>
			<button type="submit" name="btnregister" class="button" ><?php esc_attr_e('SIGN UP','login-with-ajax'); ?></button>
			<input type="hidden" name="action" value="register" />
			<div class="alignleft rgmsg_wrap"><p class="rg_msg"><?php if( $success != "" ) {	echo $success; } ?> <?php if( $error!= "" ) { echo '<span class="err">'.$error.'</span>'; } ?></p></div>
			<h3 class="sgnup_new"><a href="<?php echo get_home_url(); ?>/videolist"><?php esc_attr_e('NOT READY TO SIGN UP?','login-with-ajax'); ?> <br>
			<?php esc_attr_e('CONTINUE TO EXPLORE ROOT TONGUE','login-with-ajax'); ?> <i class="fas fa-arrow-circle-right"></i></a></h3>
		</form>
	</div>
	<div style="clear: both;"></div>
</div>
<?php get_footer() ?>