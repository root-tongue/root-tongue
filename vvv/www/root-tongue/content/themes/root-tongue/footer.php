<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */
?>
		</section>
	<!-- Close content wrapper -->
	<div class="diagonal"></div>
	</div>
<div id="warning-message">
	<h4>This website is best experienced in landscape mode. Please rotate your device.</h4>
</div>
<?php if( is_page( 'login' ) && is_user_logged_in() ){
	if( ICL_LANGUAGE_CODE=='en' ){
		wp_redirect( '/videolist' );
	} else {
		wp_redirect( '/zh-hant/videolist' );
	}
	exit;
}	?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#upload-form').on('submit', function (event) {
		event.preventDefault();
		jQuery('#loading.overlay-fullscreen').show();
		jQuery('.errors').remove();
		jQuery('#existing-user-message').hide();
		var video_file=jQuery('input[name="video"]');
		var image_file=jQuery('input[name="image"]');
		var video2_file=jQuery('input[name="video2"]');
		var audio_file=jQuery('input[name="audio"]');
		var thumbnail_file=jQuery('input[name="thumbnail"]');
		
		if(!video_file.val()){
			video_file.attr('disabled', true);
		}
		if(!image_file.val()){
			image_file.attr('disabled', true);
		}
		if(!video2_file.val()){
			video2_file.attr('disabled', true);
		}
		if(!audio_file.val()){
			audio_file.attr('disabled', true);
		}
		if(!thumbnail_file.val()){
			thumbnail_file.attr('disabled', true);
		}
		var formData = new FormData(this);

		formData.append('action', 'rt-submission');

		jQuery.ajax({
			url:'<?php echo admin_url("admin-ajax.php"); ?>',
			processData: false,
			contentType: false,
			method     : 'POST',
			data       : formData,
			dataType   : 'json',
			success    : function (response) {
				switch (response.next) {
					case 'login' :
						jQuery('#show-login-modal').trigger('click');
						jQuery('#existing-user-message').show();
						jQuery('#user_email').val(jQuery('#email').val());
						jQuery$('#user-login').data('next', 'submit');
						break;
					case 'success' :
						jQuery('#done.overlay-fullscreen').show();
						jQuery('body').addClass('done_wrp');
						jQuery('#view-upload').attr("href", response.submission);
						break;
					case 'fail' :
						showFormErrors(response.errors, '.login');
						var offset = jQuery('p.errors').offset().top - 65;
						jQuery('html, body').animate({ scrollTop: offset });
						break;
				}
				if (response.new_user_created == true) {
					jQuery('#new-user-message').show();
				}
				jQuery('#loading.overlay-fullscreen').hide();
			},
			error:function(result, status, err){
			}
		});
	return false;
});
	});
</script>
<?php wp_footer(); ?>
<?php do_action( 'foundationpress_before_closing_body' ); ?>
</body>
</html>