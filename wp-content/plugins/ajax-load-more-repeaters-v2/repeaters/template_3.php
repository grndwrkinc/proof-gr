<?php 
	/**
	 * Template 3: Masonry Gallery for Work page
	 */
	$imgSrc_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
	$title = get_post(get_post_thumbnail_id($post_object->ID))->post_title;
	$imgSrc = $imgSrc_array[0];
	$label = get_field("client");
	$postType = get_post_type();
	$termsArray = get_the_terms( $post->ID, 'case_categories' );
	$terms = "";
	foreach ($termsArray as $term) {
		$terms .= $term->slug . " ";
	}

	if($postType == "news") {
		$label = "New Work";
	}
	else {
		if(get_field("client")) {
			$label = get_field("client");
		}
		else {
			$label = "Case Study";
		}
	}

	//Set a string of all the classes to apply to the tile
	$classes = "blog-item span_5 square " . "source-".$postType;
	if(!strlen($imgSrc)) $classes .= " no-image";

	//Set a string with an inline style declaration for tiles with images.
	$inlineImg = "";
	if(strlen($imgSrc)) $inlineImg = " style=\"background-image:url('" . $imgSrc . "');\"";
?>
	<div class="featured span_5">
    	<div class="img-container">
    		<a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo $title; ?>">
				<div class="featured-img square" <?php echo $inlineImg; ?>></div>
    		</a>
    	</div>
		<div class="featured-text">
			<h5>Featured Work</h5>
			<h4><a href="<?php echo get_permalink($post->ID); ?>"><?php echo the_title(); ?></a></h4>
			<p class="item-text"><?php echo get_field('post_subheader', $post->ID); ?></p>
			<p class="read-more barr"><a href="<?php echo get_permalink($post->ID); ?>">See Work</a></p>
		</div>
	</div>