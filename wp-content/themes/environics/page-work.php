<?php
	// Loop to get all the Work Posts
	$args1 = array( 
		'post_type' => array('work', 'news'),
		'posts_per_page' => 9,
		'tax_query' => array(
			array(
				'taxonomy' => 'news_categories',
				'field'    => 'slug',
				'terms'    => array('announcements', 'awards', 'new-hires'),
				'operator' => 'NOT IN',
			),
		),
	);
	$loop = new WP_Query( $args1 );

	// Loop to get the featured Work Post
	$args2 = array(
		'post_type'	 => 'work',
		'meta_query' => array(
	        array(
	            'key' => 'featured_post',
	            'value' => 'true',
	            'compare' => 'LIKE'
	        )
	    )
	);
	$featured = new WP_Query( $args2 );

	// Get the taxonomy associated with this post type, set the variable $taxonomy_name
	$page_taxonomy = get_object_taxonomies( 'work' );
	$taxonomy_name = $page_taxonomy[0];
				
	// Load in the content of the page. Using include instead of get_template_part so variables are preserved.
	include(locate_template('page.php'));
?>