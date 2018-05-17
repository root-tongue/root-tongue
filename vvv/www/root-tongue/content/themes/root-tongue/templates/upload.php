<?php
/*
Template Name: Upload
*/
$rt = rt_get_rt_obj();

get_header(); ?>
<div id="upload" role="main">
<?php 
	if( ICL_LANGUAGE_CODE=='zh-hant' || ICL_LANGUAGE_CODE=='zh-hans' ){
		$select_heading='選擇要上載的媒體類型';
		$video_title1='影片';
		$image_title1='影像';
		$audio_title1='聲音';
		$text_title1='文字';
		$login_title1='登錄';
		$title_title1='標題';
		$email_title1='電子郵件';
		$des_title1='描述';
		$lang_title1='語言';
		$country_title1='國家';
		$theme_title1='專題';
		$add_thubm_title1='添加縮略圖';
		$submit_title1='提交';
		$cancel_title1='取消';
		$your_media_posted_title1='您的媒體將張貼在創意作品集';
		$enter_text_here_title1='在此輸入文字…';
		$save_title1='保存';
		$urlred='/zh-hant/videolist';
		$c_gallery='/zh-hant/community-gallery';

	}
	else{
		$select_heading='Select the type of media to upload';
		$video_title1='VIDEO';
		$image_title1='IMAGE';
		$audio_title1='AUDIO';
		$text_title1='TEXT';
		$login_title1='Login';
		$title_title1='TITLE';
		$email_title1='EMAIL';
		$des_title1='DESCRIPTION';
		$lang_title1='LANGUAGE';
		$country_title1='COUNTRY';
		$theme_title1='Theme';
		$add_thubm_title1='ADD THUMBNAIL';
		$submit_title1='SUBMIT';
		$cancel_title1='CANCEL';
		$your_media_posted_title1='your media will be posted in the public community gallery';
		$enter_text_here_title1='Enter text here…';
		$save_title1='SAVE';
		$urlred='/videolist';
		$c_gallery='/community-gallery';
	}
?>
	<section class="upload" role="main">
		<form id="upload-form" action="" method="post" enctype="multipart/form-data">
			<h1><?php echo $select_heading; ?></h1>

			<div class="file-row">
				<div class="submission-type upload-button video" data-type="video" data-prompt="please upload or create a video"><?php echo $video_title1; ?>
					<input type="file" accept="video/*" capture="camcorder" name="video">
				</div>
				<div class="submission-type upload-button image" data-type="image"><?php echo $image_title1; ?>
					<input type="file" accept="image/*" capture="camera" name="image">
				</div>
				<?php
						$iPod	= stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
						$iPhone	= stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
						$iPad	= stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
						$Android	= stripos($_SERVER['HTTP_USER_AGENT'],"Android");
						$webOS	= stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

						if ( $iPod || $iPhone || $iPad || $Android || $webOS ) { ?>
						<div class="submission-type upload-button video" data-type="audio_video" data-prompt="please upload an audio file"><?php echo $audio_title1; ?>
						<input type="file" accept="video/*" capture="camcorder" name="video2">
						</div>
					<?php } else{ ?>
						<div class="submission-type upload-button audio" data-type="audio" data-prompt="please upload an audio file"><?php echo $audio_title1; ?>
						<input type="file" accept="audio/*" capture="microphone" name="audio">
						</div>
					<?php } ?>
				<div class="submission-type open-modal-textbox text" data-type="text" data-prompt="<?php echo $enter_text_here_title1; ?>"><?php echo $text_title1; ?></div>
				<input type="hidden" id="submissionType" name="submissionType" value="">
				<div class="modal" data-sumbission-type=''>
					<div class="overlay"></div>
					<div class="modal-content">
						<textarea placeholder=""></textarea>
						<div class="bottom">
							<div class="rt-button submit"><?php echo $save_title1; ?></div>
							<div class="rt-button cancel"><?php echo $cancel_title1; ?></div>
						</div>
					</div>
				</div>
			</div>
			<div class="login">
				<a id="show-login-modal" href="#"><?php echo $login_title1; ?> ></a>
			</div>
			<div class="logout lgndin">
				<span> <?php esc_attr_e('YOU ARE LOGGED IN AS','login-with-ajax'); ?> <span id="current-user"><?php echo wp_get_current_user()->display_name ?></span></span>
				<div id="not-you"><a href="javascript: void:(0)"><?php esc_attr_e('LOG OUT','login-with-ajax'); ?> <i class="fas fa-arrow-circle-right"></i></a></div>
			</div>
			<div class="input-row">
				<div class="col">
					<input type="text" name="title" id="title" placeholder="<?php echo $title_title1; ?>">					
					<?php if ( ! is_user_logged_in() ) : ?>
						<input type="text" name="email" id="email" placeholder="<?php echo $email_title1; ?>">
					<?php else : ?>
						<input type="text" name="email" id="email" readonly="readonly" placeholder="<?php echo $email_title1; ?>" value="<?php echo wp_get_current_user()->user_email ?>">
					<?php endif; ?>
					<textarea name="description" id="description" placeholder="<?php echo $des_title1; ?>"></textarea>
				</div>
				<div class="col">
					<input type="text" name="language" id="language" placeholder="<?php echo $lang_title1; ?>">
					<input type="text" name="country" id="country" placeholder="<?php echo $country_title1; ?>">
					<select name="theme" id="theme">
						<option value="" disabled selected><?php echo $theme_title1; ?></option>
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
						<span><?php echo $add_thubm_title1; ?></span>
					</div>

					<div class="submit-row">
				<?php wp_nonce_field( 'rt-submission' ); ?>
				<input type="hidden" name="question" value="<?php echo $_GET['q'] ?>">
				<input type="submit" id="submit-btn" value="<?php echo $submit_title1; ?>" class="rt-button">
				<a class="rt-button" onClick="history.go(-1)"><?php echo $cancel_title1; ?></a>
			</div>
				</div>
			</div>
			
			<div class="submit-row">
				<p class="yr_mda"><?php echo $your_media_posted_title1;?></p>
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
				<h2><?php esc_attr_e('LOADING','login-with-ajax'); ?></h2>
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
					<h1 class="large-title"><?php esc_attr_e('Done!','login-with-ajax'); ?></h1>
					<div class="subtitle">
						<?php the_content(); ?>
					</div>
					<div class="next-buttons">
						<a class="rt-button" id="view-upload" href="#"><?php esc_attr_e('VIEW UPLOAD','login-with-ajax'); ?></a>
						<a class="rt-button" href="<?php echo $c_gallery;?>"><?php esc_attr_e('GO TO GALLERY','login-with-ajax'); ?></a>
						<a class="rt-button" id="next-video" href="<?php echo $urlred;?>"><?php esc_attr_e('GO TO VIDEOS','login-with-ajax'); ?></a>
					</div>
					<div id="new-user-message" style="display: none"><?php esc_attr_e('We have also created you a username and password. Please check your email!','login-with-ajax'); ?></div>
				</section>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>

		</div>

	</div>
	<!-- end overlays -->

</div>
<?php if( isset( $_GET['q'] ) ) { 
	$en_id='';
	$zh_id='';
if( ICL_LANGUAGE_CODE=='en' ){
	$zh_id = icl_object_id($_GET['q'], 'question', false,'zh-hant');
	$en_id = icl_object_id($_GET['q'], 'question', false,'en');
} else {
	$zh_id = icl_object_id($_GET['q'], 'question', false,'zh-hant');
	$en_id = icl_object_id($_GET['q'], 'question', false,'en');
}
}
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		url_upload=jQuery('#langcode_en a').attr('href');
		jQuery('#langcode_en a').attr('href',url_upload+'?q=<?php echo $en_id; ?>');
		url_upload1=jQuery('#langcode_zh-hant a').attr('href');
		jQuery('#langcode_zh-hant a').attr('href',url_upload1+'?q=<?php echo $zh_id; ?>');
	});
</script>
<a href="<?php echo htmlspecialchars_decode(wp_logout_url()); ?>" id="logout-url"></a>
<?php get_footer(); ?>