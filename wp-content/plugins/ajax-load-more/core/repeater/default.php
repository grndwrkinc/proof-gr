<?php 
	$imgSrc_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
	$imgSrc = $imgSrc_array[0];
	$postType = get_post_type();
	$page_taxonomy = get_object_taxonomies( $postType );
	$taxonomy_name = $page_taxonomy[0];
	$sources = get_the_terms( $post->ID, $taxonomy_name );
	$label = $sources[0]->name;

	//Set a string of all the classes to apply to the tile
	$classes = '';
	if(!strlen($imgSrc)) $classes = " no-image";

	//Set a string with an inline style declaration for tiles.
	$inlineImg = "";
	if(strlen($imgSrc)) $inlineImg = " style=\"background-image:url('" . $imgSrc . "');\"";
?>	
<div class="blog-item span_5 square">	
    <a href="<?php echo the_permalink(); ?>">
        <div class="blog-item-img <?php echo $classes; ?>"<?php echo $inlineImg; ?>>
        </div>
    	<div class="tile-inner">
            <h5><?php echo $label; ?></h5>
            <div class="tile-content">
                <h3><?php the_title(); ?></h3>
            </div>
        </div>
    </a>
</div>