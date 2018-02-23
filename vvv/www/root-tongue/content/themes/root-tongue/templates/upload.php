<?php
/*
Template Name: Upload
*/
$rt = rt_get_rt_obj();

get_header(); ?>
<div id="upload" role="main">

	<section class="upload" role="main">
		<form id="upload-form" action="" method="post" enctype="multipart/form-data">
			<h1>Select the type of media to upload</h1>

			<div class="file-row">
				<div class="submission-type upload-button video" data-type="video" data-prompt="please upload or create a video">VIDEO
					<input type="file" accept="video/*" capture="camcorder" name="video">
				</div>
				<div class="submission-type upload-button image" data-type="image">IMAGE
					<input type="file" accept="image/*" capture="camera" name="image">
				</div>
				<div class="submission-type upload-button audio" data-type="audio" data-prompt="please upload an audio file">AUDIO
					<input type="file" accept="audio/*" capture="microphone" name="audio">
				</div>
				<div class="submission-type open-modal-textbox text" data-type="text" data-prompt="Enter text here...">TEXT</div>
				<input type="hidden" id="submissionType" name="submissionType" value="">
				<div class="modal" data-sumbission-type=''>
					<div class="overlay"></div>
					<div class="modal-content">
						<textarea placeholder=""></textarea>
						<div class="bottom">
							<div class="rt-button submit">SAVE</div>
							<div class="rt-button cancel">CANCEL</div>
						</div>
					</div>
				</div>
			</div>
			<div class="login">
				<a id="show-login-modal" href="#">LOGIN ></a>
			</div>
			<div class="logout lgndin">
				<span>YOU ARE LOGGED IN AS <span id="current-user"><?php echo wp_get_current_user()->display_name ?></span></span>
				<div id="not-you"><a href="javascript: void:(0)">LOG OUT <i class="fas fa-arrow-circle-right"></i></a></div>
			</div>
			<div class="input-row">
				<div class="col">
					<input type="text" name="title" id="title" placeholder="TITLE">					
					<?php if ( ! is_user_logged_in() ) : ?>
						<input type="text" name="email" id="email" placeholder="EMAIL">
					<?php else : ?>
						<input type="text" name="email" id="email" readonly="readonly" placeholder="EMAIL" value="<?php echo wp_get_current_user()->user_email ?>">
					<?php endif; ?>
					<textarea name="description" id="description" placeholder="DESCRIPTION (optional)"></textarea>
				</div>
				<div class="col">
					<input type="text" name="language" id="language" placeholder="LANGUAGE">
					<input type="text" name="country" id="country" placeholder="COUNTRY">
					<select name="theme" id="theme">
						<option value="" disabled selected>Theme</option>
						<?php
						$terms = get_terms( 'theme', [
							'hide_empty' => false,
						] );
						foreach ( $terms as $term ) {
							echo '<option value="' . $term->name . '">' . $term->name . '</option>';
						} ?>
					</select>
					<div class="upload-thumbnail" style="display:none;">
						<div class="upload-button">+
							<input type="file" name="thumbnail" id="thumbnail" accept="image/*">
						</div>
						<span>ADD THUMBNAIL</span>
					</div>

					<div class="submit-row">
				<?php wp_nonce_field( 'rt-submission' ); ?>
				<input type="hidden" name="question" value="<?php echo $_GET['q'] ?>">
				<input type="submit" id="submit-btn" value="SUBMIT" class="rt-button">
				<a class="rt-button" onClick="history.go(-1)">CANCEL</a>
			</div>
				</div>
			</div>
			
			<div class="submit-row">
				<p class="yr_mda">your media will be posted in the public community gallery</p>
			</div>

		</form>
	</section>
	<!-- The forms for logging in and for lost password -->
	<div class="modal" id="login-form">
		<div class="overlay"></div>
		<div class="modal-content">
			<?php login_with_ajax( array( 'template' => 'root-tongue' ) ); ?>
		</div>
	</div>
	<!-- The loading screen | shows on form submission -->
	<div class="overlay-fullscreen" id="loading">
		<div id="progress" role="main">
			<div class="loading-container">
				<h2>LOADING</h2>
				<div class="loader"></div>
			</div>
		</div>

	</div>
	<!-- The done screen | shows after successful form submission -->
	<div class="overlay-fullscreen" id="done">
		<div id="upload-complete" role="main">

			<?php $the_query = new WP_Query( 'pagename=upload-complete' ); ?>
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<section class="upload-complete" role="main">
					<h1 class="large-title">Done!</h1>
					<div class="subtitle">
						<?php the_content(); ?>
					</div>
					<div class="next-buttons">
						<a class="rt-button" id="view-upload" href="#">VIEW UPLOAD</a>
						<a class="rt-button" href="/community-gallery">GO TO GALLERY</a>
						<a class="rt-button" id="next-video" href="/videolist">GO TO VIDEOS</a>
					</div>
					<div id="new-user-message" style="display: none">We have also created you a username and password. Please check your email!</div>
				</section>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>

		</div>

	</div>
	<!-- end overlays -->

</div>
<a href="<?php echo htmlspecialchars_decode(wp_logout_url()); ?>" id="logout-url"></a>
<?php get_footer(); ?>
