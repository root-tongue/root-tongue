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
			$password1 = $wpdb->escape( trim($_POST['password1']) );
			$email = $wpdb->escape( trim($_POST['email']) );
			$username = $wpdb->escape( trim($_POST['email']) );
			if( $email == "" || $password1 == "" || $username == "") {
				$error= 'All Fields Are Required.';
			} else if( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
				$error= 'Invalid email address.';
			} else if( email_exists($email) ) {
				$error= 'Email already exist.';
			} else {
				$user_id = wp_insert_user( array ( 'first_name' => apply_filters( 'pre_user_first_name', '' ), 'last_name' => apply_filters( 'pre_user_last_name', '' ), 'user_pass' => apply_filters( 'pre_user_user_pass', $password1 ), 'user_login' => apply_filters( 'pre_user_user_login', $username ), 'user_email' => apply_filters( 'pre_user_user_email', $email ), 'role' => 'contributor' ) );
				if( is_wp_error($user_id) ) {
					$error= 'Error on user creation.';
				} else {
					do_action( 'user_register', $user_id );
					$success = 'You\'re successfully register';
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
			<h3 class="already_acc">ALREADY HAVE AN ACCOUNT? <a href="/login" class="under_line">SIGN IN</a>.</h3>
			<p><input type="text" value="" placeholder="Email" name="email" class="input_box" id="email" /></p>
			<p><input type="password" value="" name="password1" class="input_box" id="password1" placeholder="Password" /></p>
			<button type="submit" name="btnregister" class="button" >SIGN UP</button>
			<input type="hidden" name="action" value="register" />
			<div class="alignleft rgmsg_wrap"><p class="rg_msg"><?php if( $sucess != "" ) {	echo $sucess; } ?> <?php if( $error!= "" ) { echo '<span class="err">'.$error.'</span>'; } ?></p></div>
			<h3 class="sgnup_new"><a href="/videolist">NOT READY TO SIGN UP? <br>
			CONTINUE TO EXPLORE ROOT TONGUE <i class="fas fa-arrow-circle-right"></i></a></h3>
		</form>
	</div>
</div>
<?php get_footer() ?>