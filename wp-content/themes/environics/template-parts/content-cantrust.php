<div id="primary" class="content-area">
<?php
	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/content', 'singlehero' );
		?>

		<div class="text-container span_11">
			<?php the_content(); ?>
		</div>

<?php 
		if(have_rows('section_repeater')):
			while ( have_rows('section_repeater') ) : the_row(); 
				//determine if this is an image or video repeater
				$media = get_sub_field('media_type');
?>
		<div class="cantrust-container">
			<h3 class="span_4"><?php the_sub_field('section_title'); ?></h3>
			<?php if(get_sub_field('section_description')): ?>
				<p class="span_6"><?php the_sub_field('section_description'); ?></p>
			<?php endif; ?>
			<div class="span_11">
				<div class="media">
				<?php if($media == 'Video'): ?>
					<div class="video-wrapper" data-iframe='<?php the_sub_field('video_url'); ?>'></div>
				<?php endif; ?>
				<?php if($media == 'Slides'): ?>
					<?php the_sub_field('slides_deck'); ?>
				<?php endif; ?>
				<?php if($media == 'Image'): ?>
					<?php $image = get_sub_field('image'); ?>
					<img src="<?php echo $image['url']; ?>" alt="">
				<?php endif; ?>
				</div>
				<div class="links">
<?php 
			if(have_rows('related_links')):
				while ( have_rows('related_links') ) : the_row(); 
?>
					<p><a class="barr" href="<?php the_sub_field('link_url'); ?>" download><?php the_sub_field('link_text'); ?></a></p>
<?php endwhile;
	endif; ?>	
				</div>	
			</div>
		</div>

<?php endwhile;
	endif; ?>

		<div class="posts-container">	
<?php
			$relatedPosts = get_field('related_posts');

			if($relatedPosts) : foreach ($relatedPosts as $relatedPost) : 
				$postType = get_post_type($relatedPost);
				($postType == "news") ? $label = "Announcement" : $label = "Thinking";
				$imgSrc = get_the_post_thumbnail_url($relatedPost->ID);
				if(!strlen($imgSrc)) $classes = " no-image";
				if(strlen($imgSrc)) $classes = " ";
?>
			<div class="blog-item span_5 square">
				<a href="<?php echo get_permalink($relatedPost->ID); ?>">
					<div class="blog-item-img <?php echo $classes; ?>" style="background-image:url(<?php echo $imgSrc; ?>)">
						<div class="tile-inner">
							<h5><?php echo $label; ?></h5>
							<h4 class="barr"><?php echo get_the_title($relatedPost->ID); ?></h4>
							<a href="<?php echo get_permalink($relatedPost->ID); ?>" class="tile-link barr">See More</a>
						</div>
					</div>
				</a>
			</div>
			
<?php
		endforeach; endif;
?>
		</div>	
	<?php

	endwhile;
?>		
</div><!-- #primary -->
