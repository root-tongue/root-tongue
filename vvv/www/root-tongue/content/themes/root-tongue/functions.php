<?php

require_once 'includes/post-types.php';

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

function register_my_menu() {
  register_nav_menu('main-nav',__( 'Main Nav' ));
}
add_action( 'init', 'register_my_menu' );

?>