<?php
get_header();
?>
	
	<div class="text-container">
		<h1><?php the_title(); ?></h1>
	</div>

	<div class="text-container">

		<?php if(have_posts()) : while (have_posts()) : the_post(); ?>
		<?php the_content(); ?>
		<?php 
			endwhile; 
			endif; // End of the loop.
		?>

	</div>

<?php
get_footer();
