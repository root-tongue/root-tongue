<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

 get_header(); ?>

 <div id="page" role="main">

 <?php do_action( 'foundationpress_before_content' ); ?>
 <?php while ( have_posts() ) : the_post(); ?>
     <header>
         <h1 class="entry-title"><?php the_title(); ?></h1>
     </header>
     <?php do_action( 'foundationpress_page_before_entry_content' ); ?>
     <?php if (is_page( 'watch-the-film' )){ ?>
	     <div class="entry-content watch-film">
	     	<div class="film-wrapper">
	        	<?php the_content(); ?>
	        </div> 
	     </div>
    <?php  } else { ?>
	     <div class="entry-content">
	         <?php the_content(); ?>
	     </div>

    <?php  } ?>
 
 <?php endwhile;?>

 <?php do_action( 'foundationpress_after_content' ); ?>

 </div>

 <?php get_footer(); ?>
