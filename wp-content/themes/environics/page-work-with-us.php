<?php
get_header();

	/* Loop to get the job postings */
	$args = array('post_type' => 'jobs');
	$jobs = new WP_Query( $args );

	/* Loop to get recent Social Posts (Twitter, Insta, Micro Blog Posts) */
	$args2 = array(
		'post_type'		=> 'micropost',
		'posts_per_page' => 9,
		'orderby'   	=> 'meta_value_num',
		'meta_key'  	=> 'created_time',
		'order'   		=> 'DESC',
	);
	$socialposts = new WP_Query( $args2 );
?>

	<div id="content" class="content-area">

<?php 
	if(have_posts()) : while (have_posts()) : the_post();
		get_template_part( 'template-parts/content', 'hero' ); 
?>
		<div class="text-container span_7">
			<p><?php the_field('post_subheader'); ?></p>
		</div>

		<div class="perks-container">
<?php 			
			//DROPDOWN GALLERY
			if( have_rows('section_accordion') ):
				get_template_part('template-parts/component', 'dropdown');
			endif;
?>
		</div>
		<!-- <div class="block video-block"> -->
<?php 			
			// VIDEO
			//if(get_field('video')) :
			//	get_template_part('template-parts/component', 'video');
			//endif;
?>
		<!-- </div> -->

		<!-- JOBS -->
		<div class="jobs-container">
			<div class="text-container">
				<h2 class="span_6"><?php the_field('careers_title'); ?></h2>
			</div>
			<div class="jobs">
<?php 
			if( $jobs->have_posts() ): while( $jobs->have_posts() ) : $jobs->the_post();
?>			
				<a href="<?php the_permalink(); ?>" class="single-job span_7">
					<h5><?php the_field('job_location'); ?></h5>
					<h4 class="barr"><?php the_title(); ?></h4>
					<p><?php the_field('post_subheader'); ?></p>
				</a>
<?php 
				endwhile;
			endif;

		endwhile; // End of the page loop.
	endif; 

	wp_reset_postdata();
?>
			</div>
		</div>

		<div class="socialfeed-container">
			<div class="text-container">
				<h2 class="span_8"><?php the_field('culture_title'); ?></h2>
			</div>
		</div>
		<!-- MASONRY GALLERY -->
		<div class="block masonry">
			<div class="grid">
				<div class="grid-sizer"></div>
				<div class="gutter-sizer"></div>
				<?php echo do_shortcode('[ajax_load_more repeater="template_1" post_type="socialpost,micropost" scroll="false" posts_per_page="12" orderby="meta_value_num" meta_key="created_time" order="DESC" destroy_after="99" button_label="Load More"]'); ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
	</div>

	<!-- <div class="gradient"></div> -->

<?php
get_footer();
