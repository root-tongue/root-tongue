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
		return get_permalink( reset( $rt_obj->videos )->question );
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
					<span class="comment-metadata">
                    <time datetime="<?php comment_time( 'F j, Y' ); ?>">
	                    <?php printf( get_comment_date( 'F j, Y' ) ); ?>
                    </time>
                 </span><!-- .comment-metadata -->
                <span class="comment-author">
                    POSTED BY
	                <?php printf( __( '%s' ), sprintf( '<span class="commenter">%s</span>', get_comment_author_link() ) ); ?>
                </span><!-- .comment-author -->
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
<?php }
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
		if( get_post_meta( get_the_ID() ,'bg_type',true )=='green' ){
			$classes[] = 'green_bg';
		}
		if( get_post_meta( get_the_ID() ,'bg_type',true )=='white' ){
			$classes[] = 'white_bg';
		}
		if( get_post_type( get_the_ID() ) == 'question' ){
			$classes[] = 'white_bg';
		}
	}
	return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );
add_action('init', 'do_output_buffer');
function do_output_buffer() {
		ob_start();
}
function add_theme_caps() {
    // gets the administrator role
	$admins = get_role( 'administrator' );

	$admins->add_cap( 'create_submission' );
	$admins->add_cap( 'edit_submission' );
	$admins->add_cap( 'edit_submissions' );
	$admins->add_cap( 'edit_other_submissions' );
	$admins->add_cap( 'publish_submissions' );
	$admins->add_cap( 'read_submission' );
	$admins->add_cap( 'read_private_submissions' );
	$admins->add_cap( 'delete_submission' );
	$admins->add_cap( 'delete_published_submissions' );
	$admins->add_cap( 'edit_published_submissions' );

	$contributors = get_role( 'contributor' );
	$contributors->remove_cap( 'create_submission' );
	$contributors->add_cap( 'edit_submission' );
	$contributors->add_cap( 'edit_submissions' );
	$contributors->remove_cap( 'edit_other_submissions' );
	$contributors->remove_cap( 'publish_submissions' );
	$contributors->add_cap( 'read_submission' );
	$contributors->remove_cap( 'read_private_submissions' );
	$contributors->add_cap( 'delete_submission' );
	$contributors->add_cap( 'delete_published_submissions' );
	$contributors->add_cap( 'edit_published_submissions' );
	$contributors->remove_cap( 'create_submission' );
	$contributors->add_cap( 'edit_posts' );

}
add_action( 'admin_init', 'add_theme_caps');
function remove_menus(){
	// get current login user's role
	$roles = wp_get_current_user()->roles;

	// test role
	if( !in_array( 'contributor',$roles ) ){
		return;
	}
	remove_menu_page( 'edit-comments.php' ); //Comments
	remove_menu_page( 'tools.php' ); //Tools
	remove_menu_page( 'edit.php' ); // Pages
	@add_menu_page( 'edit.php?post_type=submission' ); // submission
}
add_action( 'admin_menu', 'remove_menus' , 100 );
function wpse245372_admin_user_css() {
	$user = wp_get_current_user();
	if ( in_array( 'contributor', (array) $user->roles ) ) {
		echo '
		<style> .updated.error,.user-language-wrap,#postbox-container-2{display:none;}
		</style>';
	}
}
add_action( 'admin_head', 'wpse245372_admin_user_css' );