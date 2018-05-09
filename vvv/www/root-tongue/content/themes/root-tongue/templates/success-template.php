<?php  
/* 
Template Name: Success Page
*/
 

get_header();
?>
 <div class="success_message">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content();?>
	<?php endwhile;?>
</div>
<script type="text/javascript">
	$(document).on('ready',function(){
		$( '.success_message' ).on('click',function(){
			location.href="<?php echo get_site_url();?>/login";			
		});
		
	});
</script>

<?php get_footer() ?>