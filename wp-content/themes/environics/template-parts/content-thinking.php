	<div id="primary" class="content-area">
<?php
	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/content', 'singlehero' );
?>				
		<div class="post-overview thinking-page-details container <?php the_ID(); ?>">
			<p><span><?php the_author_posts_link(); ?></span><span class="divider">|</span><span><?php the_terms($post->ID, 'tags'); ?></span><span><?php echo the_date(); ?></span></p>
		</div>
<?php 
		$thinking_category  = get_the_terms( $post->ID, 'thinking_categories' );
		$category = $thinking_category[0]->name;

		get_template_part( 'template-parts/content', get_post_format() ); 

		if ($category == 'Report' || $category == 'Whitepaper'): 
?>
		<div class="download-container">
<?php
		$report_type = get_field('report_selector');
			if ($report_type == 'Download'):
			$report = get_field('download_file'); 
?>
			

			<!-- <div class="download-modal"> -->
				<div class="report-form">
					<?php echo do_shortcode('[frm-set-get report_url="' . $report . '"][formidable id=11 title=true description=true]'); ?>
				</div>
			<!-- </div> -->
<?php 
			elseif ($report_type == 'Link'):
		
?>
			<a href="<?php the_field('link_url'); ?>" target="_blank">
				<button class="download"><?php the_field('link_text'); ?></button>
			</a>
			<hr />
<?php 
			endif; 
?>
		
		</div>
<?php
		endif; 

		if ($category == 'Insight') {
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
	endwhile; // End of the loop.

	$current = array( $post->ID );
	$args = array( 'post_type' => 'thinking', 'posts_per_page' => 3, 'post__not_in' => $current);
	$related_posts = new WP_Query( $args ); 

	//include(locate_template('related-posts.php'));
?>
	</div><!-- #primary -->