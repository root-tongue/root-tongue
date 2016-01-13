<?php
/*
Template Name: Upload
*/

get_header(); ?>
<div id="upload" role="main">

	<?php do_action( 'foundationpress_before_content' ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<section class="upload" role="main">
		<form id="upload-form" action="" method="post" enctype="multipart/form-data">
			<h1>Select the type of media to upload</h1>

			<div class="file-row">
				<div class="submission-type open-modal-textbox video" data-type="video" data-prompt="please enter a Youtube or Vimeo URL" >VIDEO
				</div>
				<div class="submission-type upload-button image" data-type="image" >IMAGE
					<input type="file" name="image">		
				</div>
				<div class="submission-type open-modal-textbox audio" data-type="audio" data-prompt="please enter a Soundcloud URL" >AUDIO</div>
				<div class="submission-type open-modal-textbox text" data-type="text" data-prompt="Enter text here..." >TEXT</div>
  				<input type="hidden" id="submissionType" name="submissionType" value="">
  				<div class="modal" data-sumbission-type=''>
  					<div class="overlay"></div>
  					<div class="modal-content">
	  					<textarea placeholder=""></textarea>
	  					<div class="bottom">
	  						<div class="rt-button submit">SUBMIT</div>
	  						<div class="rt-button cancel">CANCEL</div>
	  					</div>
  					</div>
  				</div>
			</div>
			<div class="login">
				<a id="show-login-modal" href="#">LOGIN ></a>
			</div>
			<div class="input-row">
				<div class="col">
					<input type="text" name="title" id="title" placeholder="TITLE">
					<input type="text" name="country" id="country" placeholder="COUNTRY &nbsp;(separate countries with a comma)">
					<input type="text" name="email" id="email" placeholder="EMAIL">
					<textarea name="description" id="description" placeholder="DESCRIPTION"></textarea>
				</div>
				<div class="col">
					<input type="text" name="language" id="language" placeholder="LANGUAGE &nbsp;(separate languages with a comma)">
					  <select name="theme" id="theme">
					    <option value="theme1">THEME1</option>
					    <option value="theme2">THEME2</option>
					  </select>
					  <div class="upload-thumbnail" style="display:none;">
					  	<div class="upload-button">+
						  	<input type="file" name="thumbnail" id="thumbnail" accept="image/*">
					  	</div>
					  	<span>ADD THUMBNAIL</span>
					  </div>
				</div>
			</div>
			<div class="submit-row">
				<?php wp_nonce_field('rt-submission'); ?>
				<input type="submit" id="submit" value="SUBMIT" class="rt-button">
				<a class="rt-button" onClick="history.go(-1)">CANCEL</a>
			</div>

		</form>
	</section>
	<!-- The forms for logging in and for lost password -->
	<div class="modal" id="login-form">
		<div class="overlay"></div>
		<div class="modal-content">
			<div class="login-form-container">
				<h1>LOGIN</h1>
				<form id="user-login" action="">
					<input type="text" placeholder="EMAIL ADDRESS" id="user_email">
					<input type="password" placeholder="PASSWORD" id="user_password">
					<div class="button-row">
						<input type="submit" value="LOGIN" class="rt-button">
							<div class="rt-button cancel">CANCEL</div>
					</div>
					<div class="lost-password">
						Lost your password?
					</div>
				</form>
			</div>
			<div class="lost-password-form-container">
				<h1>RESET PASSWORD</h1>
				<div class="cta">Please enter your email address. You will receive a link to create a new password via email.</div>
				<form id="lost-password" action="">
					<input type="text" placeholder="EMAIL ADDRESS" id="user_email">
					<div class="button-row">
						<input type="submit" value="SUBMIT" class="rt-button">
							<div class="rt-button cancel">CANCEL</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- The form for registered email detected -->
	<div class="modal" id="registered-email-login-form">
		<div class="overlay"></div>
		<div class="modal-content">
			<div class="login-form-container">
				<h1>LOGIN</h1>
				<div class="cta">Your email address is associated with an existing account. Please enter your password to log in.</div>
				<form id="user-login" action="">
					<input type="password" placeholder="PASSWORD" id="user_password">
					<div class="button-row">
						<input type="submit" value="LOGIN" class="rt-button">
							<div class="rt-button cancel">CANCEL</div>
					</div>
					<div class="lost-password">
						Lost your password?
					</div>
				</form>
			</div>
			<div class="lost-password-form-container">
				<h1>RESET PASSWORD</h1>
				<div class="cta">Please enter your email address. You will receive a link to create a new password via email.</div>
				<form id="lost-password" action="">
					<input type="text" placeholder="EMAIL ADDRESS" id="user_email">
					<div class="button-row">
						<input type="submit" value="SUBMIT" class="rt-button">
							<div class="rt-button cancel">CANCEL</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php endwhile;?>
	<?php do_action( 'foundationpress_after_content' ); ?>

</div>

<?php get_footer(); ?>
