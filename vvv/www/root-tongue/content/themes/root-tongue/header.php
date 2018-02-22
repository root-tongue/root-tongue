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
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/favicon.png" type="image/x-icon">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/apple-touch-icon-144x144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/apple-touch-icon-114x114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/apple-touch-icon-72x72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/apple-touch-icon-precomposed.png">
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
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
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-74127104-2', 'auto');
			ga('send', 'pageview');

		</script>
	</head>
	<body <?php body_class(); ?>>
	<?php do_action( 'foundationpress_after_body' ); ?>

	<div id="body-wrapper">

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
