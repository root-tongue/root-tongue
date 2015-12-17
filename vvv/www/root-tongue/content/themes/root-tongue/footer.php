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
		<!--<div id="footer-container">
			<footer id="footer">
				<?php do_action( 'foundationpress_before_footer' ); ?>
				<?php do_action( 'foundationpress_after_footer' ); ?>
			</footer>
		</div>-->

		<?php do_action( 'foundationpress_layout_end' ); ?>
	<?php if ( ! get_theme_mod( 'wpt_mobile_menu_layout' ) || get_theme_mod( 'wpt_mobile_menu_layout' ) == 'offcanvas' ) : ?>
		</div><!-- Close off-canvas wrapper inner -->
	</div><!-- Close off-canvas wrapper -->

	<?php if ( ! get_theme_mod( 'wpt_mobile_menu_layout' ) || get_theme_mod( 'wpt_mobile_menu_layout' ) == 'offcanvas' ) : ?>
	<!-- Close off-canvas content wrapper -->
	</div>
	<?php endif; ?>
	
	<?php endif; ?>

<?php wp_footer(); ?>
<?php do_action( 'foundationpress_before_closing_body' ); ?>
<script type='text/javascript' id="__bs_script__">//<![CDATA[
    document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.2.10.0.js'><\/script>".replace("HOST", location.hostname));
//]]></script>
</body>

</html>
