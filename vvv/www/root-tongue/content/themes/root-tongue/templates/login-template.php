<?php
/*
Template Name: Login Page
*/
get_header();
?>

<div class="wrapper">

	<?php 
login_with_ajax( array( 'template' => 'root-tongue' ) ); ?>
<?php get_footer() ?>