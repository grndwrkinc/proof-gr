<?php

/*Loop to get all the Thinking Posts */
	$args1 = array( 'post_type' => 'thinking');
	$loop = new WP_Query( $args1 );

/* Loop to get the featured Thinking Post */
	$args2 = array(
		'post_type'		=> 'thinking',
		'meta_query' => array(
	        array(
	            'key' => 'featured_post',
	            'value' => 'true',
	            'compare' => 'LIKE',
	            'posts_per_page' => 2,
	        )
	    )
	);
	$featured = new WP_Query( $args2 );

// Get the taxonomy associated with this post type, set the variable $taxonomy_name
	
	$page_taxonomy = get_object_taxonomies( 'thinking' );
	$taxonomy_name = $page_taxonomy[0];

/* Load in the content of the page. Using include instead of get_template_part so variables are preserved. */
include(locate_template('page.php'));
?>