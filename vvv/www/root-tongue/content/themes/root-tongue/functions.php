<?php

require_once 'includes/post-types.php';

require_once 'includes/ux-json.php';

add_theme_support( 'post-thumbnails' );

/** Various clean up functions */
require_once( 'library/cleanup.php' );

/** Required for Foundation to work properly */
require_once( 'library/foundation.php' );

/** Register all navigation menus */
require_once( 'library/navigation.php' );

/** Add menu walkers for top-bar and off-canvas */
require_once( 'library/menu-walkers.php' );

/** Create widget areas in sidebar and footer */
require_once( 'library/widget-areas.php' );

/** Return entry meta information for posts */
require_once( 'library/entry-meta.php' );

/** Enqueue scripts */
require_once( 'library/enqueue-scripts.php' );

/** Add theme support */
require_once( 'library/theme-support.php' );

/** Add Nav Options to Customer */
require_once( 'library/custom-nav.php' );

/** If your site requires protocol relative url's for theme assets, uncomment the line below */

//require_once( 'library/protocol-relative-theme-assets.php' );


/** Register Menus */
add_action( 'init', 'rt_register_menu' );
function rt_register_menu() {
	register_nav_menu( 'main-nav', __( 'Main Nav' ) );
}

/** Hide admin bar for non admins */
add_action( 'after_setup_theme', 'rt_remove_admin_bar' );
function rt_remove_admin_bar() {
	if ( ! current_user_can( 'administrator' ) && ! is_admin() ) {
		show_admin_bar( false );
	}
}

function rt_last_seen_question_url() {
	$rt_obj = rt_get_rt_obj();
	if ( ! empty( $rt_obj->videosPlayed ) ) {
		return get_permalink( $rt_obj->videos[ end( $rt_obj->videosPlayed ) ]->question );
	} else {
		return get_permalink( reset($rt_obj->videos)->question );
	}

	return '';
}

/** Comments Template */
function rt_custom_comments( $comment, $args, $depth ) {
	?>
	<div id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="row">
				<div class="comment-meta">
                <span class="comment-author">
                    POSTED BY
	                <?php printf( __( '%s' ), sprintf( '<span class="commenter">%s</span>', get_comment_author_link() ) ); ?>,
                </span><!-- .comment-author --><span class="comment-metadata">
                    <time datetime="<?php comment_time( 'n/j/y' ); ?>">
	                    <?php printf( get_comment_date( 'n/j/y' ) ); ?>
                    </time>
                 </span><!-- .comment-metadata -->
					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
					<?php endif; ?>
				</div><!-- .comment-meta -->
				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->
			</div>
		</article><!-- .comment-body -->
	</div>
<?php } ?>


