<?php
get_header();
?>
	<div id="primary" class="content-area">
<?php
	while ( have_posts() ) : the_post();
?>
		<div class="hero-container">
			<h2 class="span_8"><?php the_title(); ?></h2>
			<div class="text-container">
				<div class="span_3">
					<a href="#applyhere">
						<p class="barr">Apply now</p>
					</a> 
					<?php get_template_part( 'template-parts/content', 'socialbuttons' ); ?>
				</div>
				<div class="span_10">
					<h5><?php the_field('post_subheader'); ?></h5>
					<p><?php the_field('job_location'); ?> / <?php echo the_date(); ?></p>
				</div>
			</div>
		</div>
<?php 
		get_template_part( 'template-parts/content', get_post_format() );

?>

	<div class="form-container">
		<div id="applyhere" class="block container application-form">
			<?php echo do_shortcode('[formidable id=9 title=true description=true]'); ?>
		</div>
	</div>

<?php
	endwhile; // End of the loop. 
?>
	</div><!-- #primary -->

<?php
get_footer();
