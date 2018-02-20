<?php
/*
Plugin Name: Ajax Load More: Preloaded
Plugin URI: http://connekthq.com/plugins/ajax-load-more/preloaded/
Description: Ajax Load More extension to preload content before making Ajax requests to your server.
Author: Darren Cooney
Twitter: @KaptonKaos
Author URI: http://connekthq.com
Version: 1.2.1
License: GPL
Copyright: Darren Cooney & Connekt Media
*/


define('ALM_PRELOADED_PATH', plugin_dir_path(__FILE__));
define('ALM_PRELOADED_URL', plugins_url('', __FILE__));
define('ALM_PRELOADED_VERSION', '1.2.1');
define('ALM_PRELOADED_RELEASE', 'July 9, 2015');



/*
*  alm_preload_install
*  Install the Preloaded add-on
*
*  @since 1.0
*/

register_activation_hook( __FILE__, 'alm_preloaded_install' );
function alm_preloaded_install() {   
   if(!is_plugin_active('ajax-load-more/ajax-load-more.php')){	//if Ajax Load More is activated
   	die('You must install and activate <a href="https://wordpress.org/plugins/ajax-load-more/">Ajax Load More</a> before installing the Ajax Load More Preloaded add-on.');
	}	
}



if( !class_exists('ALMPreloadedPosts') ):
   class ALMPreloadedPosts{	   
   	function __construct(){		
   		 
   		add_action( 'alm_preload_installed', array(&$this, 'alm_is_preloaded_installed') );	
   	   add_filter( 'alm_preload_args', array(&$this, 'alm_preloaded_args' ), 10, 1 );	
   	   add_filter( 'alm_preload_inc', array(&$this, 'alm_preloaded_inc' ), 10, 5 );	
   		add_action( 'alm_preloaded_settings', array(&$this, 'alm_preloaded_settings' ));	
   	   
   	}   	   	
   	
   	
   	
   	/*
   	*  alm_preload_args
   	*  Build the preload query $args
   	*
   	*  @since 1.0
   	*/
   	
   	function alm_preloaded_args($a){	
   	   
      	$posts_per_page = $a['posts_per_page'];
      	$post_type = explode(",", $a['post_type']);  
      	$post_format = (isset($a['post_format'])) ? $a['post_format'] : '';
   		$category = (isset($a['category'])) ? $a['category'] : '';
   		$category__not_in = (isset($a['category__not_in'])) ? $a['category__not_in'] : '';
   		$tag = (isset($a['tag'])) ? $a['tag'] : '';
   		$tag__not_in = (isset($a['tag__not_in'])) ? $a['tag__not_in'] : '';
   		
   		// Taxonomy
   		$taxonomy = (isset($a['taxonomy'])) ? $a['taxonomy'] : '';
   		$taxonomy_terms = (isset($a['taxonomy_terms'])) ? $a['taxonomy_terms'] : '';
   		$taxonomy_operator = $a['taxonomy_operator'];
   		if(empty($taxonomy_operator))$taxonomy_operator = 'IN';
   		
   		// Custom Fields
   		$meta_key = (isset($a['meta_key'])) ? $a['meta_key'] : '';
   		$meta_value = (isset($a['meta_value'])) ? $a['meta_value'] : '';
   		$meta_compare = $a['meta_compare'];
   		if($meta_compare == '') $meta_compare = 'IN'; 
   		$meta_relation = $a['meta_relation'];
   		if($meta_relation == '') $meta_relation = 'AND';
   		
   		$s = (isset($a['search'])) ? $a['search'] : '';   		
   		$custom_args = (isset($a['custom_args'])) ? $a['custom_args'] : '';
   		$author_id = (isset($a['author'])) ? $a['author'] : '';		
   		
   		// Ordering
   		$order = (isset($a['order'])) ? $a['order'] : 'DESC';
   		$orderby = (isset($a['orderby'])) ? $a['orderby'] : 'date';
   		
   		// Exclude, Offset, Status
   		$post__in = (isset($a['post__in'])) ? $a['post__in'] : '';	
   		$exclude = (isset($a['exclude'])) ? $a['exclude'] : '';	
   		$offset = (isset($a['offset'])) ? $a['offset'] : 0;
   		$post_status = $a['post_status'];
   		if($post_status == '') $post_status = 'publish';
   		
      	// $args
   		$args = array(
   			'post_type' => $post_type,
   			'posts_per_page' => $posts_per_page,
   			'offset' => $offset,
   			'order' => $order,
   			'orderby' => $orderby,		
   			'post_status' => $post_status,		
   			'ignore_sticky_posts' => false,
   		);	
   		
   		// Post Format & taxonomy
   		if(!empty($post_format) || !empty($taxonomy)){	
   		   $args['tax_query'] = array(			
   				'relation' => 'AND',
   		      alm_get_tax_query($post_format, $taxonomy, $taxonomy_terms, $taxonomy_operator)
   		   );
   	   }	
   	   
   	   // Category
   		if(!empty($category)){
   			$args['category_name'] = $category;
   		}
         
         // Category Not In
   		if(!empty($category__not_in)){
   		   $exclude_cats = explode(",",$category__not_in);
   			$args['category__not_in'] = $exclude_cats;
   		}
         
         // Tag
   		if(!empty($tag)){
   			$args['tag'] = $tag;
   		} 		 
         
         // Tag Not In
   		if(!empty($tag__not_in)){
   		   $exclude_tags = explode(",",$tag__not_in);
   			$args['tag__not_in'] = $exclude_tags;
   		}
   	    
   	   // Date (not using date_query as there was issue with year/month archives)
   		if(!empty($year)){
      		$args['year'] = $year;
   	   } 
   	   if(!empty($month)){
      		$args['monthnum'] = $month;
   	   }  
   	   if(!empty($day)){
      		$args['day'] = $day;
   	   }	
   	   
   	   // Meta Query
   		if(!empty($meta_key) && !empty($meta_value)){
      		
      		// Parse multiple meta query    
            $total = count(explode(":", $meta_key)); // Total meta_query objects
            $meta_keys = explode(":", $meta_key); // convert to array
            $meta_value = explode(":", $meta_value); // convert to array
            $meta_compare = explode(":", $meta_compare); // convert to array
            
            if($total == 1){
      			$args['meta_query'] = array(
      			   alm_get_meta_query($meta_keys[0], $meta_value[0], $meta_compare[0]),
      			);
   			}
   			if($total == 2){
      			$args['meta_query'] = array(
         			'relation' => $meta_relation,
      			   alm_get_meta_query($meta_keys[0], $meta_value[0], $meta_compare[0]),	
      			   alm_get_meta_query($meta_keys[1], $meta_value[1], $meta_compare[1]),		
      			);
   			}
   			if($total == 3){
      			$args['meta_query'] = array(
         			'relation' => $meta_relation,
      			   alm_get_meta_query($meta_keys[0], $meta_value[0], $meta_compare[0]),	
      			   alm_get_meta_query($meta_keys[1], $meta_value[1], $meta_compare[1]),	
      			   alm_get_meta_query($meta_keys[2], $meta_value[2], $meta_compare[2]),		
      			);
   			}
   			if($total == 4){
      			$args['meta_query'] = array(
         			'relation' => $meta_relation,
      			   alm_get_meta_query($meta_keys[0], $meta_value[0], $meta_compare[0]),	
      			   alm_get_meta_query($meta_keys[1], $meta_value[1], $meta_compare[1]),	
      			   alm_get_meta_query($meta_keys[2], $meta_value[2], $meta_compare[2]),	
      			   alm_get_meta_query($meta_keys[3], $meta_value[3], $meta_compare[3]),		
      			);
   			}
   			
   	   }
   	   
         // Meta_key, used for ordering by meta value
         if(!empty($meta_key)){
	         $meta_key_single = explode(":", $meta_key);
            $args['meta_key'] = $meta_key_single[0];
         }
         
         // Author
   		if(!empty($author_id)){
   			$args['author'] = $author_id;
   		}
         
         // Search Term
   		if(!empty($s)){
   			$args['s'] = $s;
   		}  
   		
   		// Custom Args         
   		if(!empty($custom_args)){
   			$custom_args_array = explode(";",$custom_args); // Split the $custom_args at ','
   			foreach($custom_args_array as $argument){ // Loop each $argument  
      			  
      			$argument = preg_replace('/\s+/', '', $argument); // Remove all whitespace 	      				
   			   $argument = explode(":",$argument);  // Split the $argument at ':' 
   			   $argument_arr = explode(",", $argument[1]);  // explode $argument[1] at ','
   			   if(sizeof($argument_arr) > 1){
   			      $args[$argument[0]] = $argument_arr;
   			   }else{
   			      $args[$argument[0]] = $argument[1];      			   
   			   }
   			   
   			}
   		} 
         
         // Include posts
   		if(!empty($post__in)){
   			$post__in = explode(",",$post__in);
   			$args['post__in'] = $post__in;
   		}     	   
         
   		// Exclude posts
   		if(!empty($exclude)){
   			$exclude = explode(",",$exclude);
   			$args['post__not_in'] = $exclude;
   		}
   		
         // Language
   		if(!empty($lang)){
   			$args['lang'] = $lang;
   		}	
   		
   	   return $args;
      }
   	
   	
   	
   	/*
   	*  alm_preload_inc
   	*  Get the preloaded post include file
   	*
   	*  @since 1.0
   	*/
   	
   	function alm_preloaded_inc($repeater, $preload_type, $alm_found_posts, $alm_page, $alm_item){
	   	ob_start(); // As seen here - http://stackoverflow.com/a/1288634/921927
			$file = alm_get_current_repeater($repeater, $preload_type);
			include($file);
			$return = ob_get_contents();
			ob_end_clean();
			return $return;
	   }	
	    	
   	
   	
   	/*
   	*  alm_is_preload_installed
   	*  an empty function to determine if preload is true.
   	*
   	*  @since 1.0
   	*/
   	
   	function alm_is_preloaded_installed(){
   	   //Empty return
   	}	
   	
   	
   	
   	/*
   	*  alm_preloaded_settings
   	*  Create the Preloaded settings panel.
   	*
   	*  @since 1.2
   	*/
   	
   	function alm_preloaded_settings(){
      	register_setting(
      		'alm_preloaded_license', 
      		'alm_preloaded_license_key', 
      		'alm_preloaded_sanitize_license'
      	);
   	}
   	
   }   
   
   
   
   /*
   *  alm_preloaded_sanitize_license
   *  Sanitize our license activation
   *
   *  @since 1.0.0
   */
   
   function alm_preloaded_sanitize_license( $new ) {
   	$old = get_option( 'alm_preloaded_license_key' );
   	if( $old && $old != $new ) {
   		delete_option( 'alm_preloaded_license_status' ); // new license has been entered, so must reactivate
   	}
   	return $new;
   }
   
   
   
   /*
   *  alm_preloaded_activate_license
   *  Activate the license
   *
   *  @since 1.0.0
   */
   
   function alm_preloaded_activate_license() {
   
   	// listen for our activate button to be clicked
   	if( isset( $_POST['alm_preloaded_license_activate'] ) ) {
   
   		// run a quick security check 
   	 	if( ! check_admin_referer( 'alm_preloaded_license_nonce', 'alm_preloaded_license_nonce' ) ) 	
   			return; // get out if we didn't click the Activate button
   
   		// retrieve the license from the database
   		$license = trim( get_option( 'alm_preloaded_license_key' ) );
   
   		// data to send in our API request
   		$api_params = array( 
   			'edd_action'=> 'activate_license', 
   			'license' 	=> $license, 
   			'item_id'   => ALM_PRELOADED_ITEM_NAME, // the name of our product in EDD
   			'url'       => home_url()
   		);
   		
   		// Call the custom API.
   		$response = wp_remote_get( add_query_arg( $api_params, ALM_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );
   
   		// make sure the response came back okay
   		if ( is_wp_error( $response ) )
   			return false;
   
   		// decode the license data
   		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
   		
   		// $license_data->license will be either "valid" or "invalid"
   
   		update_option( 'alm_preloaded_license_status', $license_data->license );
   
   	}
   }
   add_action('admin_init', 'alm_preloaded_activate_license');
   
   
   
   /*
   *  alm_preloaded_deactivate_license
   *  Deactivate license
   *
   *  @since 1.0.0
   */
   
   function alm_preloaded_deactivate_license() {
   
   	// listen for our activate button to be clicked
   	if( isset( $_POST['alm_preloaded_license_deactivate'] ) ) {
   
   		// run a quick security check 
   	 	if( ! check_admin_referer( 'alm_preloaded_license_nonce', 'alm_preloaded_license_nonce' ) ) 	
   			return; // get out if we didn't click the Activate button
   
   		// retrieve the license from the database
   		$license = trim( get_option( 'alm_preloaded_license_key' ) );
   			
   
   		// data to send in our API request
   		$api_params = array( 
   			'edd_action'=> 'deactivate_license', 
   			'license' 	=> $license, 
   			'item_id'   => ALM_PRELOADED_ITEM_NAME, // the name of our product in EDD
   			'url'       => home_url()
   		);
   		
   		// Call the custom API.
   		$response = wp_remote_get( add_query_arg( $api_params, ALM_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );
   
   		// make sure the response came back okay
   		if ( is_wp_error( $response ) )
   			return false;
   
   		// decode the license data
   		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
   		
   		// $license_data->license will be either "deactivated" or "failed"
   		if( $license_data->license == 'deactivated' )
   			delete_option( 'alm_preloaded_license_status' );
   
   	}
   }
   add_action('admin_init', 'alm_preloaded_deactivate_license');	
   	
   	
   /*
   *  ALMPRELOAD
   *  The main function responsible for returning Ajax Load More PRELOAD.
   *
   *  @since 1.0
   */	
   
   function ALMPreloadedPosts(){
   	global $alm_preloaded_posts;
   
   	if( !isset($alm_preloaded_posts) ){
   		$alm_preloaded_posts = new ALMPreloadedPosts();
   	}
   
   	return $alm_preloaded_posts;
   }
   
   // initialize
   ALMPreloadedPosts();

endif; // class_exists check



/* Software Licensing */

define('ALM_PRELOADED_ITEM_NAME', '4293' ); // EDD CONSTANT - Item Name
if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	include( dirname( __FILE__ ) . '/vendor/EDD_SL_Plugin_Updater.php' );
}

function alm_preloaded_plugin_updater() {	
	$license_key = trim( get_option( 'alm_preloaded_license_key' ) ); // retrieve our license key from the DB
	$edd_updater = new EDD_SL_Plugin_Updater( ALM_STORE_URL, __FILE__, array( 
			'version' 	=> ALM_PRELOADED_VERSION,
			'license' 	=> $license_key,
			'item_id'   => ALM_PRELOADED_ITEM_NAME,
			'author' 	=> 'Darren Cooney'
		)
	);
}
add_action( 'admin_init', 'alm_preloaded_plugin_updater', 0 );	

/* End Software Licensing */
