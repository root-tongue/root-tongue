<?php
/*
Template Name: Upload
*/

get_header(); ?>
<div id="upload" role="main">

	<?php do_action( 'foundationpress_before_content' ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<section class="upload" role="main">
		<form id="upload-form">
			<h1>Select the type of media to upload</h1>

			<div class="file-row">
				<div class="submission-type open-modal-textbox video" data-type="video" data-prompt="please enter a Youtube or Vimeo URL" >VIDEO
				</div>
				<div class="submission-type upload-button image" data-type="image" >IMAGE
					<input type="file" name="image">		
				</div>
				<div class="submission-type open-modal-textbox audio" data-type="audio" data-prompt="please enter a Soundcloud URL" >AUDIO</div>
				<div class="submission-type open-modal-textbox text" data-type="text" data-prompt="Enter text here..." >TEXT</div>
  				<input type="hidden" id="submissionType" name="submissionType" value="">
  				<div class="modal" data-sumbission-type=''>
  					<div class="overlay"></div>
  					<div class="modal-content">
	  					<textarea placeholder=""></textarea>
	  					<div class="bottom">
	  						<div class="rt-button submit">SUBMIT</div>
	  						<div class="rt-button cancel">CANCEL</div>
	  					</div>
  					</div>
  				</div>
			</div>
			<div class="login">
				<a href="/login">LOGIN ></a>
			</div>
			<div class="input-row">
				<div class="col">
					<input type="text" id="title" placeholder="TITLE">
					<input type="text" id="country" placeholder="COUNTRY">
					<input type="text" id="email" placeholder="EMAIL">
					<textarea id="description" placeholder="DESCRIPTION"></textarea>
				</div>
				<div class="col">
					<input type="text" id="language" placeholder="LANGUAGE">
					  <select id="theme">
					    <option value="theme1">THEME1</option>
					    <option value="theme2">THEME2</option>
					  </select>
					  <div class="upload-thumbnail" style="display:none;">
					  	<div class="upload-button">+
						  	<input type="file" id="thumbnail" accept="image/*">
					  	</div>
					  	<span>ADD THUMBNAIL</span>
					  </div>
				</div>
			</div>
			<div class="submit-row">
				<input type="submit" value="SUBMIT" class="rt-button">
				<a class="rt-button" onClick="history.go(-1)">CANCEL</a>
			</div>
		</form>
	</section>
	<?php endwhile;?>
	<?php do_action( 'foundationpress_after_content' ); ?>

</div>

<?php get_footer(); ?>
