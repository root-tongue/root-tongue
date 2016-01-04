<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/favicon.png" type="image/x-icon">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/apple-touch-icon-144x144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/apple-touch-icon-114x114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/apple-touch-icon-72x72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/apple-touch-icon-precomposed.png">
		<!--
		/**
		 * @license
		 * MyFonts Webfont Build ID 3136849, 2015-12-06T18:01:54-0500
		 * 
		 * The fonts listed in this notice are subject to the End User License
		 * Agreement(s) entered into by the website owner. All other parties are 
		 * explicitly restricted from using the Licensed Webfonts(s).
		 * 
		 * You may obtain a valid license at the URLs below.
		 * 
		 * Webfont: FuturaBT-Book by Bitstream
		 * URL: http://www.myfonts.com/fonts/bitstream/futura/book/
		 * Copyright: Copyright 1990-2003 Bitstream Inc. All rights reserved.
		 * Licensed pageviews: 10,000
		 * 
		 * Webfont: FuturaBT-Bold by Bitstream
		 * URL: http://www.myfonts.com/fonts/bitstream/futura/bold/
		 * Copyright: Copyright 1990-2003 Bitstream Inc. All rights reserved.
		 * Licensed pageviews: 10,000
		 * 
		 * Webfont: FuturaBT-MediumCondensed by Bitstream
		 * URL: http://www.myfonts.com/fonts/bitstream/futura/medium-condensed/
		 * Copyright: Copyright 1990-2003 Bitstream Inc. All rights reserved.
		 * Licensed pageviews: 10,000
		 * 
		 * Webfont: TandelleRg-Regular by Typodermic
		 * URL: http://www.myfonts.com/fonts/typodermic/tandelle/regular/
		 * Copyright: (c) 2005-2010 Typodermic Fonts. This font is not freely distributable.
		 * Visit typodermic.com for more info.
		 * Licensed pageviews: 20,000
		 * 
		 * 
		 * License: http://www.myfonts.com/viewlicense?type=web&buildid=3136849
		 * 
		 * © 2015 MyFonts Inc
		*/
		-->
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
	<?php do_action( 'foundationpress_after_body' ); ?>

	<?php if ( ! get_theme_mod( 'wpt_mobile_menu_layout' ) || get_theme_mod( 'wpt_mobile_menu_layout' ) == 'offcanvas' ) : ?>
	<div class="off-canvas-wrapper">
		<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
		<?php get_template_part( 'parts/mobile-off-canvas' ); ?>
	<?php endif; ?>

	<?php do_action( 'foundationpress_layout_start' ); ?>

	<header id="masthead" class="site-header" role="banner">
		<nav id="site-navigation" class="main-navigation top-bar" role="navigation">
			<div class="top-bar-left">
					<a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</div>
			<div class="top-bar-right">
				<div class="nav-toggle">
					<span class="menu-label">MENU</span> 
					<span class="menu-icon">
					</span>
				</div>
				<nav id="main-nav">
					<?php wp_nav_menu( array( 'theme_location' => 'main-nav' ) ); ?>
				</nav>
			</div>
		</nav>
	</header>

	<section class="container">
		<?php do_action( 'foundationpress_after_header' ); ?>
