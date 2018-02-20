<?php
/* The template for all pages that feature a gallery of links (Thinking, News, Work) */
get_header(); 
?>
	<div id="content" class="content-area">
		
<?php
	

	if( have_rows('featured_post') ):
		$count = count( get_field('featured_post') ); //Count the repeater fields to determine if we need two column layout ?>

		 <div class="hero-container <?php if ($count >= 2) {echo "double-featured"; } ?>">
		    
<?php 	while ( have_rows('featured_post') ) : the_row();
			$post_object = get_sub_field('featured_post_object');
			if($post_object) {
				$subtitle = get_field('post_subheader', $post_object->ID); //Fetch the subtitle field from the featured post
			} 

			$hero = wp_get_attachment_url( get_post_thumbnail_id($post_object->ID) );
			if(!strlen($hero)) $classes = " no-image"; //If no featured hero is found, give div a class of no-image
			// var_dump($post_object);
?>
				<div class="span_8">
					<div class="sub-hero <?php echo $classes; ?> <?php //if ($count >= 2) {echo "double-featured"; } ?>" style="background-image:url(<?php echo $hero; ?>)">
						<h1><a class="btn barr" href="<?php echo get_permalink($post_object->ID); ?>"><?php echo $post_object->post_title; ?></a></h1>
					</div>
					<p class="span_5"><?php echo $subtitle; ?></p>
					<a class="btn barr" href="<?php echo get_permalink($post_object->ID); ?>">Read the full story</a>
				</div>
<?php 
		$classes = "";
		endwhile;
		
	else :
		while ( have_posts() ) : the_post();
			$hero = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
	   		if(!strlen($hero)) $classes = " no-image"; 
	   		$classes .= " text-" . strtolower(get_field('title_colour_picker'));
?>
			<div class="hero <?php echo $classes; ?>" style="background-image: url(<?php echo $hero; ?>)" >
				<h1><?php the_title(); ?></h1>
			</div>
			<div class="text-container span_7">
				<?php the_field('post_subheader'); ?>
<?php 
		endwhile; 
	endif; 
?>
		</div>
	</div>

<?php
	//Set up the variables for the data attributes to attached to the filter buttons
	if($loop->have_posts()) : while ( $loop->have_posts() ) : $loop->the_post();		
		$postType = get_post_type();

		$termsArray = get_terms( array(
			'parent' => 0,
			'taxonomy' => $taxonomy_name,
			'hide_empty' => false
		) );
		$postsPerPage="12";
		$scroll="false";
		$destroyAfter="99";
		$buttonLabel="Load More";
		$repeater="default";
		$terms = "";
		foreach ($termsArray as $term) { $terms .= $term->slug . ", "; }
		$taxonomyTerms = $terms = rtrim($terms, ", ");

		if (is_page('work')) {
			$postType = "work,news";
			$taxonomy = "news_categories:case_categories";
			$taxonomyTerms = "new-work:".$terms;
			$taxonomyOperator="IN:IN";
			$taxonomyRelation="OR";
			$repeater="template_3";
		}
		if (is_page('thinking')) {
			$taxonomy = "thinking_categories";
		}
		if (is_page('news')) {
			$taxonomy = "news_categories";
		}
	endwhile; endif;
?>

	<div class="sub-nav-container">
		<!-- Sub-nav with all of the custom taxonomy terms -->
		<ul class="sub-nav"><li class="all active"><a href="#" data-repeater="<?php echo $repeater; ?>" data-post-type="<?php echo $postType; ?>" data-posts-per-page="<?php echo $postsPerPage; ?>" data-scroll="<?php echo $scroll; ?>" data-destroy-after="<?php echo $destroyAfter; ?>" data-button-label="<?php echo $buttonLabel; ?>" <?php if (is_page('work') || is_page('thinking') || is_page('news')) : ?>data-taxonomy="<?php echo $taxonomy; ?>" data-taxonomy-terms="<?php echo $taxonomyTerms; ?>"<?php endif; ?> <?php if (is_page('work')) : ?>data-taxonomy-operator="<?php echo $taxonomyOperator; ?>" data-taxonomy-relation="<?php echo $taxonomyRelation; ?>"<?php endif; ?>>All</a><span class="divider">|</span></li><?php 
				if ( ! empty( $termsArray ) && ! is_wp_error( $termsArray ) ){
				    foreach ( $termsArray as $term ) {
	
				    	$name = str_replace(" ", "&nbsp;", $term->name);

				    	if (is_page('work')) {
				    		$taxonomyTerm = $term->slug.":".$term->slug;
				    	}
				    	if (is_page('thinking') || is_page('news')) {
				    		$taxonomyTerm = $term->slug;

							if($term->slug != "new-work") {
								$name .= "s";
							}
				    	} ?><li class="<?php echo $term->slug; ?>"><a href="#" data-repeater="<?php echo $repeater; ?>" data-post-type="<?php echo $postType; ?>" data-posts-per-page="<?php echo $postsPerPage; ?>" data-scroll="<?php echo $scroll; ?>" data-destroy-after="<?php echo $destroyAfter; ?>" data-button-label="<?php echo $buttonLabel; ?>" <?php if (is_page('work') || is_page('thinking') || is_page('news')) : ?>data-taxonomy="<?php echo $taxonomy; ?>" data-taxonomy-terms="<?php echo $taxonomyTerm; ?>"<?php endif; if (is_page('work')) : ?> data-taxonomy-operator="<?php echo $taxonomyOperator; ?>" data-taxonomy-relation="<?php echo $taxonomyRelation; ?>"<?php endif; ?>><?php echo $name; ?></a><span class="divider">|</span></li><?php
				    }
				}
		?></ul>
	</div> <!-- end sub nav -->

	

<?php
	if($loop->have_posts()) : 
?>
	<!-- Gallery of Posts -->
	<div class="posts-container grid">
<?php 
				if (is_page('work')) {
					echo do_shortcode('[ajax_load_more transition="fade" transition_speed="100" repeater="'.$repeater.'" post_type="'.$postType.'" posts_per_page="'.$postsPerPage.'" scroll="'.$scroll.'" destroy_after="'.$destroyAfter.'" button_label="'.$buttonLabel.'"  taxonomy="'.$taxonomy.'" taxonomy_terms="'.$taxonomyTerms.'" taxonomy_operator="'.$taxonomyOperator.'" taxonomy_relation="'.$taxonomyRelation.'"]');
				}					
				else {
					echo do_shortcode('[ajax_load_more transition="fade" transition_speed="100" repeater="'.$repeater.'" post_type="'.$postType.'" posts_per_page="'.$postsPerPage.'" scroll="'.$scroll.'" destroy_after="'.$destroyAfter.'" button_label="'.$buttonLabel.'"]');
				}
?>
	<!-- </div> -->
</div>
<?php
	endif;
get_footer();
