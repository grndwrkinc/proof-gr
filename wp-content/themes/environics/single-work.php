<?php
get_header(); 

	$current = array( $post->ID );
	$args = array( 'post_type' => 'work', 'posts_per_page' => 3, 'post__not_in' => $current);
	$related_posts = new WP_Query( $args );	
?>

	<div id="primary" class="content-area">
<?php 
	while ( have_posts() ) : the_post(); 

	$classes = "";
	$hero = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
		if(!strlen($hero)) $classes = " no-image";
		$classes .= " text-" . strtolower(get_field('title_colour_picker'));
?>
		<div class="hero-container">
			<div class="span_11">
				<h2 id="content"><?php the_title(); ?></h2>
			</div>
			<div class="sub-hero single-page<?php echo $classes; ?>" style="background-image:url(<?php echo $hero; ?>)"></div>
			<?php //get_template_part( 'template-parts/content', 'socialbuttons' ); ?>
		</div>
		<div class="post-overview">
			<p>
				<span><?php the_field('client'); ?></span>
				<span><?php 
					$case_category = get_the_terms($post->ID, 'case_categories');
					$out = array();
					foreach ($case_category as $category) {
						array_push($out, $category->name);
				}
				echo implode(', ', $out);
				?></span>
				<span><?php the_field('team')?></span>
				<span><?php the_field('year')?></span>
			</p>
		</div>

		<!-- Lead paragraph -->
		<div class="text-container span_11">
			<?php the_content(); ?>
		</div>

<?php 
		##########################
		## Flexible Content Fields
		## - check if the flexible content field has rows of data

		if(have_rows('flexible_content')): while(have_rows("flexible_content")): the_row();

			// layout: Text
			if(get_row_layout() == "text_block"):
?>
			<?php $indent = get_sub_field('text_indent');
			$indentclass = '';
			if( $indent && in_array('yes', $indent) ): 
				$indentclass = 'indent';
			 endif; ?>
				<div class="text-container span_10 <?php echo $indentclass; ?>">
				<?php if(get_sub_field('text_title')): ?>
					<h4><?php the_sub_field("text_title"); ?></h4>
				<?php endif; ?>
					<?php the_sub_field("text_content"); ?>
				</div>

<?php 		// layout: Video 
			elseif(get_row_layout() == "video_block"):
?>
				<!-- <div class="block bg-pattern-purple video-block"> -->
				<div class="video-container">
					<?php get_template_part('template-parts/component', 'video'); ?>
				</div>
<?php 
			// layout: Image
			elseif(get_row_layout() == "image_block"): 
?>				
				<div class="image-container images">
					<?php while(the_repeater_field('images')): $image_block_img = get_sub_field("image"); ?>
						<div class="image"><img src="<?php echo $image_block_img['url']; ?>" alt=""/></div>
					<?php endwhile; ?>
				</div>

<?php 
			// layout: Quote 
			elseif(get_row_layout() == "quote_block"): 
?>
				<div class="quote-container">
					<p class="text span_11"><?php the_sub_field("quote_text"); ?></p>
					<p class="source"><?php the_sub_field("quote_source"); ?></p>
				</div>

<?php 
			// layout: Awards + Press
			elseif(get_row_layout() == "awards_block"):
?>
				<div class="press-container">
					<?php $has_press = get_sub_field('press_true'); ?>
					<?php $has_awards = get_sub_field('awards_true'); ?>
					<?php if($has_press == 'Yes') : ?>
					<h4>Press</h4>
					<div class="items-container">
						<?php if(have_rows('press')): while(have_rows('press')): the_row(); ?>
						<div class="span_5">
							<h5 class="barr"><?php the_sub_field('press_name'); ?></h5>
							<p class="press-title"><a href="<?php the_sub_field('press_link'); ?>" target="_blank"><?php the_sub_field('press_text'); ?></a></p>
						</div>
					<?php endwhile; endif; ?>
					</div>
					<?php endif; ?>	
					<?php if($has_awards == 'Yes') : ?>
					<h4>Awards</h4>
					<?php if(have_rows('awards')): while(have_rows('awards')): the_row(); ?>
					<div class="span_5">
						<h5 class="barr"><?php the_sub_field('award_name'); ?></h5>
						<p class="press-title"><a href="<?php the_sub_field('award_link'); ?>" target="_blank"><?php the_sub_field('award_text'); ?></a></p>
					</div>
					<?php endwhile; endif; ?>
					<?php endif; ?>	
				</div>			
<?php 
			endif; 
		endwhile; 
	endif; 
endwhile; // End of the loop.
?>
	</div><!-- #primary -->

	<div class="featured-container">
		<div class="featured-wrapper">
<?php while ( $related_posts->have_posts() ) : $related_posts->the_post();
				global $post; 
				$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
				$feat_image = $feat_image_array[0];
				if(strlen($feat_image)) {
					$classes = "";
				} else {
					$classes = 'no-image';
				};
				$post_type = get_post_type();
				$page_taxonomy = get_object_taxonomies( $post_type );
				$taxonomy_name = $page_taxonomy[0];
				$page_category = get_the_terms( $post->ID, $taxonomy_name ); 
				$label = get_field('client');?>
	
			<div class="featured span_5">
				<div class="img-container">
					<a href="<?php echo get_permalink($post->ID); ?>" class="">
						<div class="featured-img square" style="background-image: url('<?php echo $feat_image; ?>')">
						</div>
					</a>
				</div>
				<div class="featured-text">
					<h5>Featured Work</h5>
					<h4><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></h4>
					<p class="item-text"><?php the_field('post_subheader'); ?></p>
					<p class="read-more barr"><a href="<?php echo get_permalink($post->ID); ?>">See Work</a></p>
				</div>
			</div>

<?php endwhile; // End of the related posts loop.?>

<?php wp_reset_postdata(); ?>

		</div>
	</div>

<?php
get_footer();
