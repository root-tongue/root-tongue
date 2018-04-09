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
	wp_redirect( '/videolist' );
	exit;
}	?>
<?php wp_footer(); ?>
<?php do_action( 'foundationpress_before_closing_body' ); ?>

</body>
</html>
