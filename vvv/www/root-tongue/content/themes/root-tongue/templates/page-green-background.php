<?php
/*
Template Name: Page with Chartreuse Background
*/

 get_header(); ?>

 <div id="page" role="main">

 <?php do_action( 'foundationpress_before_content' ); ?>
 <?php while ( have_posts() ) : the_post(); ?>
     <header>
         <h1 class="entry-title"><?php the_title(); ?></h1>
     </header>
     <?php do_action( 'foundationpress_page_before_entry_content' ); ?>
     <div class="entry-content">
         <?php the_content(); ?>
     </div>
 <?php endwhile;?>

 <?php do_action( 'foundationpress_after_content' ); ?>

 </div>

 <?php get_footer(); ?>
