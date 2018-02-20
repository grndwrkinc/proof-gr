<?php

// Create a custom taxonomy for Case Study Categories for the post type 'work'
function create_work_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Case Study Categories', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Case Study Category', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Case Study Categories', 'textdomain' ),
		'all_items'         => __( 'All Case Study Categories', 'textdomain' ),
		'parent_item'       => __( 'Parent Case Study Category', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Case Study Category:', 'textdomain' ),
		'edit_item'         => __( 'Edit Case Study Category', 'textdomain' ),
		'update_item'       => __( 'Update Case Study Category', 'textdomain' ),
		'add_new_item'      => __( 'Add New Case Study Category', 'textdomain' ),
		'new_item_name'     => __( 'New Case Study Category Name', 'textdomain' ),
		'menu_name'         => __( 'Case Study Category', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'case-studies' ),
	);

	register_taxonomy( 'case_categories', array( 'work' ), $args );
}
add_action( 'init', 'create_work_taxonomies', 0 );


// Create a custom taxonomy for Thinking Post Categories for the post type 'thinking'
function create_thinking_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Thinking Post Categories', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Thinking Post Category', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Thinking Post Categories', 'textdomain' ),
		'all_items'         => __( 'All Thinking Post Categories', 'textdomain' ),
		'parent_item'       => __( 'Parent Thinking Post Category', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Thinking Post Category:', 'textdomain' ),
		'edit_item'         => __( 'Edit Thinking Post Category', 'textdomain' ),
		'update_item'       => __( 'Update Thinking Post Category', 'textdomain' ),
		'add_new_item'      => __( 'Add New Thinking Post Category', 'textdomain' ),
		'new_item_name'     => __( 'New Thinking Post Category Name', 'textdomain' ),
		'menu_name'         => __( 'Thinking Post Category', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'meta_box_cb'       => false,
		'rewrite'           => array( 'slug' => 'thinking-post' ),
	);

	register_taxonomy( 'thinking_categories', array( 'thinking' ), $args );
}
add_action( 'init', 'create_thinking_taxonomies', 0 );

// Create a custom taxonomy for News Categories for the post type 'news'
function create_news_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'News Categories', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'News Category', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search News Categories', 'textdomain' ),
		'all_items'         => __( 'All News Categories', 'textdomain' ),
		'parent_item'       => __( 'Parent News Category', 'textdomain' ),
		'parent_item_colon' => __( 'Parent News Category:', 'textdomain' ),
		'edit_item'         => __( 'Edit News Category', 'textdomain' ),
		'update_item'       => __( 'Update News Category', 'textdomain' ),
		'add_new_item'      => __( 'Add New News Category', 'textdomain' ),
		'new_item_name'     => __( 'New News Category Name', 'textdomain' ),
		'menu_name'         => __( 'News Category', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'news-post' ),
	);

	register_taxonomy( 'news_categories', array( 'news' ), $args );
}
add_action( 'init', 'create_news_taxonomies', 0 );

//Create tag taxonomy for the post type 'thinking'
function create_tag_taxonomies() 
{
  // Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name' => _x( 'Tags', 'taxonomy general name' ),
    'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Tags' ),
    'popular_items' => __( 'Popular Tags' ),
    'all_items' => __( 'All Tags' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Tag' ), 
    'update_item' => __( 'Update Tag' ),
    'add_new_item' => __( 'Add New Tag' ),
    'new_item_name' => __( 'New Tag Name' ),
    'separate_items_with_commas' => __( 'Separate tags with commas' ),
    'add_or_remove_items' => __( 'Add or remove tags' ),
    'choose_from_most_used' => __( 'Choose from the most used tags' ),
    'menu_name' => __( 'Tags' ),
  ); 

  $args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'tag' ),
	);

	register_taxonomy( 'tags', array( 'thinking' ), $args );
}
add_action( 'init', 'create_tag_taxonomies', 0 );

//Create tag taxonomy for the post type 'micropost'
function create_socialtag_taxonomies() 
{
  // Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name' => _x( 'Social Tags', 'taxonomy general name' ),
    'singular_name' => _x( 'Social Tag', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Social Tags' ),
    'all_items' => __( 'All Social Tags' ),
    'edit_item' => __( 'Edit Social Tag' ), 
    'update_item' => __( 'Update Social Tag' ),
    'add_new_item' => __( 'Add New Social Tag' ),
    'new_item_name' => __( 'New Social Tag Name' ),
  ); 

  $args = array(
		'hierarchical'      => true,
		'public'			=> true,
		'labels'            => $labels
	);

	register_taxonomy( 'social-tags', array( 'micropost' ), $args );
}
add_action( 'init', 'create_socialtag_taxonomies', 0 );

// //Create tag taxonomy for the post type 'news' in the category 'new work'
// function create_newstag_taxonomies() 
// {
//   // Add new taxonomy, NOT hierarchical (like tags)
//   $labels = array(
//     'name' => _x( 'New Work Tags', 'taxonomy general name' ),
//     'singular_name' => _x( 'New Work Tag', 'taxonomy singular name' ),
//     'search_items' =>  __( 'Search New Work Tags' ),
//     'all_items' => __( 'All New Work Tags' ),
//     'edit_item' => __( 'Edit New Work Tag' ), 
//     'update_item' => __( 'Update New Work Tag' ),
//     'add_new_item' => __( 'Add New New Work Tag' ),
//     'new_item_name' => __( 'New New Work Tag Name' ),
//   ); 

//   $args = array(
// 		'hierarchical'      => true,
// 		'public'			=> true,
// 		'labels'            => $labels
// 	);

// 	register_taxonomy( 'news-tags', array( 'news' ), $args );
// }
// add_action( 'init', 'create_newstag_taxonomies', 0 );




