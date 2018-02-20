<?php
get_header(); 
?>
<div id="primary" class="content-area">
<?php 
	if(have_posts()) : while (have_posts()) : the_post();
		get_template_part( 'template-parts/content', 'hero' );
?>
	<div class="text-container">
		<h2 class="span_6"><?php the_field('post_subheader'); ?></h2>
		<div class="span_10"><?php the_content(); ?></div>
	</div>
	
	<?php
		if( have_rows('capability_repeater_content') ):
	    	while ( have_rows('capability_repeater_content') ) : the_row();
	    		$title = get_sub_field('capability_title');
	?>
	<?php $image = get_sub_field('capability_image');
		  $hash = preg_replace("/[^a-zA-Z]+/", "", get_sub_field('capability_title'));
		  $hash = strtolower($hash);
	 ?>
	<div id="<?php echo $hash; ?>" class="capabilities-container">
		<div class="hero-container">
			<div class="sub-hero span_10" style="background-image: url('<?php echo $image['url']; ?>');">
				<h3><?php the_sub_field('capability_title'); ?></h3>
			</div>
			<p class="span_5">
				<?php the_sub_field('capability_description'); ?>
			</p>
		</div>
		
		<div class="dropdown-gallery">
	<?php if( have_rows('capability_category') ):
			$count = 0;
	    	while ( have_rows('capability_category') ) : the_row(); 
	    		$countclass = '';
				if ($count % 3 == 2) {
					$countclass = 'three';
				} elseif ($count % 3 == 1) {
					$countclass = 'two';
				} else {
					$countclass = 'one';
				};
	?>

			<div class="dropdown-item span_4">
				<h5><?php if( get_sub_field('title') ){ the_sub_field('title'); } ?></h5>
				<div class="dropdown-content">	
					<p class="<?php 
					echo $countclass; ?>"><?php if( get_sub_field('description') ){ the_sub_field('description'); } ?></p>
				</div>
			</div>
	<?php 
		$count ++;
		endwhile; //End of capability category loop
	endif; ?>
		</div>
		<p class="linkout"><?php the_sub_field('external_link'); ?></p>
	</div>
	<?php 
		endwhile; // End of capabilities repeater loop
		endif; 
	?>

<?php 
	endwhile; 
	endif; // End of the loop.
?>
	</div><!-- #primary -->

<?php
get_footer();
