<?php
get_header();
	/*Loop to get all the Team Members */
	$args = array( 'post_type' => 'team_members',
				   'order' => 'ASC',
				   'posts_per_page'=> -1,
				   'orderby' => 'menu_order');
	$loop = new WP_Query( $args );

	/* Loop to find out if any job postings exist */
	$args2 = array( 
		'post_type' => 'jobs',
		'posts_per_page' => 1 
		);

	$jobsloop = new WP_Query( $args2 ); 
?>

	<div id="primary" class="content-area">
<?php 
	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/content', 'hero' );
?>

	<div class="text-container span_8">
		<?php the_content(); ?>
	</div>

	<!-- CLIENTS -->
	<div class="clients-container">
		<div class="text-container">
			<h2 class="span_6"><?php the_field('clients_header'); ?></h2>
			<div class="span_10"><?php the_field('clients_message'); ?></div>
		</div>
		<div class="clients-gallery">
			<?php
				$clientimages = get_field('client_logos');
				if( $clientimages ): ?>
		        <?php foreach( $clientimages as $clientimage ): ?>
		            <div class="clients-item span_5">
	                     <img src="<?php echo $clientimage['sizes']['medium']; ?>" alt="<?php echo $clientimage['alt']; ?>" />
		            </div>
		        <?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
	<!-- // .clients-container  -->

	<!-- LEADERSHIP TEAM -->
	<div class="team-container">
		<div class="text-container">
			<h2 class="span_6"><?php the_field('ceo_header'); ?></h2>
			<div class="span_10"><?php the_field('ceo_message'); ?></div>
		</div>
		<div class="dropdown-gallery">
<?php 
		// Loop to find all team members
		$loop_count = 0;
		while ( $loop->have_posts() ) : $loop->the_post();
			
			$main_photo = get_field('photo_professional');
?>
			<div class="dropdown-item span_5" tabindex="0" role="button" aria-label="A team member">
				<img src="<?php echo $main_photo['url']; ?>" alt="<?php echo $main_photo['alt']; ?>">
				<h5><?php the_title(); ?></h5>
				<p class="role"><?php the_field('team_member_role'); ?></p>

				<article class="dropdown-content">
					<div class="dropdown-inner">
						<div class="social-share span_5">
<?php 
						// Check if each social media link exists. If yes, add list item w href and icon.
						$linkedin = get_field('linkedin_link');
						$twitter = get_field('twitter_link');
						$medium = get_field('medium_link');
						$instagram = get_field('instagram_link');
						$spotify = get_field('spotify_link');
?>
							<ul> 
<?php 				
						if( !empty($linkedin) ) { ?>
								<li><a href="<?php echo $linkedin; ?>" target="_blank" alt="Linkedin Link" aria-label="Link to Linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li> 	<?php 				
						}
						if( !empty($twitter) ) { ?>
								<li><a href="<?php echo $twitter; ?>" target="_blank" alt="Twitter link" aria-label="Link to twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li> 	<?php 				
						}
						if( !empty($medium) ) { ?>
								<li><a href="<?php echo $medium; ?>" target="_blank" alt="Medium link" aria-label="Link to Medium"><i class="fa  fa-medium" aria-hidden="true"></i></a></li> 		<?php 				
						}
						if( !empty($instagram) ) { ?>
								<li><a href="<?php echo $instagram; ?>" target="_blank" alt="Instagram link" aria-label="Link to Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li><?php 				
						}
						if( !empty($spotify) ) { ?>
								<li><a href="<?php echo $spotify; ?>" target="_blank" alt="Spotify link" aria-label="Link to Spotify"><i class="fa fa-spotify" aria-hidden="true"></i></a></li> 	<?php 				
						}
?>	
							</ul>						
						</div>
						<div class="bio span_10">
							<?php the_content(); ?>
						</div>
					</div>
				</article>
			</div><!-- // .team-member  -->
<?php 
		$loop_count ++;
		endwhile; 
		wp_reset_postdata();
?>

		</div><!-- // .team-gallery  -->
	</div><!-- // .team-wrapper  -->

	<!-- GALLERY -->
	<div class="gallery-container">
		<div class="text-container">
			<h2 class="span_6"><?php the_field('gallery_header'); ?></h2>
			<div class="span_10"><?php the_field('gallery_message'); ?></div>
		</div><!-- //.text-container -->

		<div class="photo-gallery">
			<?php
				$galleryimages = get_field('photo_gallery');
				if( $galleryimages ): ?>
		        <?php foreach( $galleryimages as $galleryimage ): ?>
	                <img src="<?php echo $galleryimage['sizes']['large']; ?>" alt="<?php echo $galleryimage['alt']; ?>" />
		        <?php endforeach; ?>
			<?php endif; ?>
		</div><!-- //.photo-gallery -->
		<p class="captions">&nbsp;</p>

	</div><!-- //.gallery-container -->

			
<?php endwhile; // End of the page loop. ?>
	</div>
</div>

<?php
get_footer();
