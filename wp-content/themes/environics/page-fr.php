<?php
	get_header();

	while ( have_posts() ) : the_post();
	get_template_part( 'template-parts/content', 'hero' ); 
?>
	<div class="text-container">
		<h2 class="span_5"><?php the_title(); ?></h2>
		<div class="span_11"><?php the_content(); ?></div>
	</div>

	<div class="vprop-container">
		<?php $image = get_field('vprop_hero'); ?>
		<div class="sub-hero" style="background-image: url('<?php echo $image['url']; ?>');">
			<h2><?php the_field('vprop_title') ?></h2>
		</div>
		<div class="text-container">
			<h4 class="span_5">
				<?php the_field('vprop_subtitle'); ?>
			</h4>
			<div class="span_10">
				<?php the_field('vprop_body'); ?>
				<p class="read-more barr"><a href="/capabilities/">Explore</a></p>
			</div>
	</div>

<?php 
	endwhile;
?>
	
<?php
get_footer();
