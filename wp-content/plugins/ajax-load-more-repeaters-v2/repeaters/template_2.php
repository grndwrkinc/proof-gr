<?php
	/**
	 * Template 2: Home Page Masonry Gallery 
	 */
	$imgSrc_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
	$imgSrc = $imgSrc_array[0];
	$postType = get_post_type();
	($postType == 'news') ? $label = 'News' : $label = 'Blog';

	//Set a string of all the classes to apply to the tile
	$classes = "masonry-tile " . "source-".$postType;
	if(!strlen($imgSrc)) $classes .= " no-image";

	//Set a string with an inline style declaration for tiles.
	$inlineImg = "";
	if(strlen($imgSrc)) $inlineImg .= " style=\"background-image:url('" . $imgSrc . "');\"";
?>
	
	<a href="<?php the_permalink(); ?>">
		<div class="<?php echo $classes; ?>"<?php echo $inlineImg; ?>>
			<div class="tile-inner">
				<h5><?php echo $label; ?></h5>
				<div class="tile-content">
					<p><?php the_title(); ?></p>
				</div>
			</div>
		</div>
	</a>