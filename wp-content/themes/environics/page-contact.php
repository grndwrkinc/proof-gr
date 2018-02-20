<?php
get_header();
?>

	<div id="content" class="content-area">

<?php 
	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/content', 'hero' );

		$location = get_field('map');
		$lat = $location['lat'];
		$lng = $location['lng'];

		if( !empty($location) ): 
?>

		<div class="acf-map">
			<div class="marker" data-lat="<?php echo $lat; ?>" data-lng="<?php echo $lng; ?>">
				<h5>Environics PR</h5>
				<p class="address"><?php echo $location['address']; ?></p>
			</div>
		</div>
<?php endif; ?>

		<div class="locations-container">

<?php 		if(have_rows('offices')): while(have_rows('offices')): the_row();
			$cityscape = get_sub_field('office_image');
?>
			<div class="single-location">
				<div class="location-text span_8">
					<h2><?php the_sub_field('city_name'); ?></h2>
					<div class="address"><?php the_sub_field('additional_info'); ?></div>
				</div>
				<div class="location-img span_7">
					<img src="<?php echo $cityscape; ?>" alt="">
				</div>
			</div>
<?php 			
		endwhile; endif;
?>
		</div> <!-- end container -->
<?php 
	endwhile; // End of the loop.
?>
	</div><!-- #primary -->

<?php
get_footer();
