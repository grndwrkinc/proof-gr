<?php 

/*
     *  Plugin Name: _GRNDWRK Social Feed
    *   Plugin URI: http://grndwrk.ca
    *   Description: Imports Instagram and Twitter feeds as posts
    *   Version: 1.1.1
    *   Author: GRNDWRK Inc.
    *   Author URI: http://grndwrk.ca
    *   License: GPL2
     *
    */

	// Define some contstants
	define( 'GWSF_VERSION', '1.1' );
	define( 'CPT_SP', 'socialpost');
	define( 'CPT_SP_NAME', 'Social Post');
	define( 'CPT_SP_TAX', 'source');
	define( 'CPT_SP_TAXNAME', 'Source');

	/**
	*  Instagram setup
	*  Access token generator: http://instagram.pixelunion.net/
	*/
	define( 'INSTAGRAM_ACCESS_TOKEN', '3537933538.1677ed0.f6b3277338d54f76b129ac35838a4d0c');

	/**
	*  Twitter setup
	*/
	require_once('TwitterAPIExchange.php');
	define( 'TWITTER_USER', 					 'environicspr');
	define( 'TWITTER_OAUTH_ACCESS_TOKEN', 		 '4318896195-9EbxYlEqZM2s31TPBCTMvVCHhsGFJadpIBROXxI');
	define( 'TWITTER_OAUTH_ACCESS_TOKEN_SECRET', 'li3SScEK3q3BEABKEXowGckyUH4014UGHeQjQuH0zoEJn');
	define( 'TWITTER_CONSUMER_KEY', 			 'jMwzM4yhZV8UYN90aRI2ANgGm');
	define( 'TWITTER_CONSUMER_SECRET', 			 'uxmDSKOCdcASDj7nwizYm4hGe4PhjxzeWpDrrMMJ8Z6BXTMhT9');

	


	/**************************************************
	 *
	 * Function: cwc_activate_plugin()
	 *
	 **************************************************/
	function gwsf_activate_plugin() {
		global $wp_rewrite;
		add_option( "gswf_version", GWSF_VERSION ); // Add to WP Option tbl

		//Flush rewrite rules
		gwsf_create_social_post_type();
		$wp_rewrite->flush_rules();

		//Schedule the cron jobs
		gwsf_schedule_instagram_feed_job();
		gwsf_schedule_twitter_feed_job();
	}


	/**************************************************
	 *
	 * Function: cwc_deactivate_plugin()
	 *
	 **************************************************/
	function gwsf_deactivate_plugin() {
		global $wpdb;

		// Get rid of the custom post type
		unregister_post_type(CPT_SP);

		// Clear out scheduled jobs
		wp_clear_scheduled_hook( 'gwsf_get_hourly_instagram_feed' );
		wp_clear_scheduled_hook( 'gwsf_get_hourly_twitter_feed' );

		// Clean up the database
		delete_option('instagram_min_id');
		delete_option('twitter_since_id');


		/* Delete all the social posts */
		$wpdb->query(
			$wpdb->prepare(
				"
				DELETE 
				FROM wp_posts
				WHERE post_type = %s
				",
				'socialpost'
			)
		);
		
		/* Delete the post meta */
		$wpdb->query(
				"
				DELETE pm
				FROM wp_postmeta pm
				LEFT JOIN wp_posts wp ON wp.ID = pm.post_id
				WHERE wp.ID IS NULL
				"
		);

		/* Delete all the terms */
		$wpdb->query(
			$wpdb->prepare(
				"
				DELETE
				FROM wp_terms
				WHERE slug LIKE %s
				",
				'source-%'
			)
		);

		/* Delete all the terms */
		$wpdb->query(
			$wpdb->prepare(
				"
				DELETE
				FROM wp_term_taxonomy
				WHERE taxonomy = %s
				",
				'source'
			)
		);
	}


	/**************************************************
	 *
	 * Function: gwsf_create_social_post_type()
	 *
	 **************************************************/
	function gwsf_create_social_post_type() {
		//Custom taxonomy
		register_taxonomy(CPT_SP_TAX, CPT_SP, array(
			'labels' => array(
				'name' => __(CPT_SP_TAXNAME.'s', 'environics'),
				'singular_name' => __(CPT_SP_TAXNAME, 'environics'),
				'all_items' => __('All ' . CPT_SP_TAXNAME, 'environics'),
				'edit_item' => __('Edit ' . CPT_SP_TAXNAME, 'environics'),
				'view_item' => __('View ' . CPT_SP_TAXNAME, 'environics'),
				'update_item' => __('Update ' . CPT_SP_TAXNAME, 'environics'),
				'add_new_item' => __('Add New ' . CPT_SP_TAXNAME, 'environics'),
				'new_item_name' => __('New ' . CPT_SP_TAXNAME . ' Name', 'environics'),
				'search_items' => __('Search ' . CPT_SP_TAXNAME, 'environics')
			),
			'public' => true,
			'hierarchical' => true
		));

		//Custom Post Type
		register_post_type(CPT_SP, // Register Custom Post Type
	        array(
	        'labels' => array(
	            'name' => __(CPT_SP_NAME.'s', 'environics'), // Rename these to suit
	            'singular_name' => __(CPT_SP_NAME, 'environics'),
	            'add_new' => __('Add New', 'environics'),
	            'add_new_item' => __('Add New ' . CPT_SP_NAME, 'environics'),
	            'edit' => __('Edit', 'environics'),
	            'edit_item' => __('Edit ' . CPT_SP_NAME, 'environics'),
	            'new_item' => __('New ' . CPT_SP_NAME, 'environics'),
	            'view' => __('View ' . CPT_SP_NAME, 'environics'),
	            'view_item' => __('View ' . CPT_SP_NAME, 'environics'),
	            'search_items' => __('Search ' . CPT_SP_NAME, 'environics'),
	            'not_found' => __('No ' . CPT_SP_NAME . 's found', 'environics'),
	            'not_found_in_trash' => __('No ' . CPT_SP_NAME . 's found in Trash', 'environics')
	        ),
	        'exclude_from_search' => true,
	        'show_ui' => false,
	        'public' => true,
	        'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
	        'has_archive' => false,
	        'taxonomies' => array(CPT_SP_TAX),
	        'supports' => array(
	            'title',
	            'editor'
	        ),
	        'can_export' => true, // Allows export in Tools > Export
	    ));	
	}


	/**************************************************
	 *
	 * Function: gwsf_schedule_instagram_feed_job() 
	 *
	 **************************************************/
	function gwsf_schedule_instagram_feed_job() {
		//Use wp_next_scheduled to check if the event is already scheduled
		$timestamp = wp_next_scheduled( 'gwsf_get_hourly_instagram_feed' );
		//If $timestamp == false schedule daily backups since it hasn't been done previously
		if( $timestamp == false ){
			//Schedule the event for right now, then to repeat hourly using the hook 'gwsf_get_hourly_instagram_feed'
			wp_schedule_event( time(), 'hourly', 'gwsf_get_hourly_instagram_feed' );
		}
	}

	/**************************************************
	 *
	 * Function: gwsf_get_instagram_feed()
	 *
	 * Hook our function , gwsf_get_instagram_feed(), 
	 * into the action gwsf_get_hourly_instagram_feed
	 *
	 **************************************************/
	add_action( 'gwsf_get_hourly_instagram_feed', 'gwsf_get_instagram_feed' );
	function gwsf_get_instagram_feed() {
		//Get the taxonomy, or set it if it does not exist
		$term = get_term_by('slug', 'source-instagram', CPT_SP_TAX);
	    if(!$term) $term = wp_insert_term('Instagram', CPT_SP_TAX, array('slug' => 'source-instagram'));

		$since_id = get_option('instagram_min_id', '');

	    $ch  = curl_init('https://api.instagram.com/v1/users/self/media/recent/?access_token=' . INSTAGRAM_ACCESS_TOKEN  . '&min_id=' . $since_id);	
	    
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$feed = json_decode(curl_exec($ch));
		curl_close($ch);
		$feedData = $feed->data;
		$feedData = array_reverse($feedData);

		if(isset($feed->pagination)) {
			update_option('instagram_min_id', $feedData[sizeof($feedData) - 1]->id);

			foreach ($feedData as $socialpost) {
				$userName 	 = $socialpost->caption->from->full_name;
				$link 		 = $socialpost->link;
				$postText 	 = $socialpost->caption->text;
				$createdTime = $socialpost->created_time;
				$socialPostID 	 = $socialpost->id;
				$photo 		 = getInstagramProper($socialpost->images->thumbnail->url);

				if(strcmp($socialPostID, $since_id) != 0) {
					$pid = wp_insert_post(array(
						'post_author' => 1,
						'post_title' => trim(preg_split('/!|\?|\.|,|\-/', substr($postText,0,200))[0]),
						'post_content' => $postText,
						'post_type' => CPT_SP,
						'post_status' => 'publish',
						'tax_input' => array(
							CPT_SP_TAX => array($term->slug)
						),
						'meta_input' => array(
							'user' => $userName,
							'link' => $link,
							'data_id' => $socialPostID,
							'created_time' => $createdTime,
							'post_thumb' => $photo,
						)
					));
					
					$wpsot = wp_set_object_terms($pid, 'source-instagram', CPT_SP_TAX, true);
					var_dump($wpsot);
				}
			}
		}
	}

	/**************************************************
	 *
	 * Function: gwsf_schedule_twitter_feed_job()
	 *
	 **************************************************/
	function gwsf_schedule_twitter_feed_job() {
		//Use wp_next_scheduled to check if the event is already scheduled
		$timestamp = wp_next_scheduled( 'gwsf_get_hourly_twitter_feed' );
		//If $timestamp == false schedule daily backups since it hasn't been done previously
		if( $timestamp == false ){
			//Schedule the event for right now, then to repeat hourly using the hook 'gwsf_get_hourly_twitter_feed'
			wp_schedule_event( time(), 'hourly', 'gwsf_get_hourly_twitter_feed' );
		}

		//gwsf_get_twitter_feed();
	}

	/**************************************************
	 *
	 * Function: gwsf_get_twitter_feed()
	 *
	 * Hook our function , gwsf_get_twitter_feed(), 
	 * into the action gwsf_get_hourly_twitter_feed
	 *
	 **************************************************/
	add_action( 'gwsf_get_hourly_twitter_feed', 'gwsf_get_twitter_feed' );
	function gwsf_get_twitter_feed() {
		//Get the taxonomy, or set it if it does not exist
		$term = get_term_by('slug', 'source-twitter', CPT_SP_TAX);
	    if(!$term) $term = wp_insert_term('Twitter', CPT_SP_TAX, array('slug' => 'source-twitter'));
		
	    $since_id = get_option('twitter_since_id', '');
		
		/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
		$settings = array(
		    'oauth_access_token' 		=> TWITTER_OAUTH_ACCESS_TOKEN,
		    'oauth_access_token_secret' => TWITTER_OAUTH_ACCESS_TOKEN_SECRET,
		    'consumer_key' 				=> TWITTER_CONSUMER_KEY,
		    'consumer_secret' 			=> TWITTER_CONSUMER_SECRET
		);
		
		$url 	= 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$method = 'GET';
		$query 	= '?screen_name='.TWITTER_USER.'&exclude_replies=true&include_rts=false';
		if($since_id != '') $query .= '&since_id=' . $since_id;
		
		$twttr 	= new TwitterAPIExchange($settings);
		$json 	= $twttr->setGetfield($query)
		             	->buildOauth($url, $method)
		             	->performRequest();

		$feedData 	= json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
		$feedData = array_reverse($feedData);
		
		//Set the since_id -- passed to the API call to retrieve results more recent than the since_id
		if(isset($feedData)){
			if(isset($feedData[sizeof($feedData) - 1]['id_str'])) {
				update_option('twitter_since_id', $feedData[sizeof($feedData) - 1]['id_str']);
			}

			foreach ($feedData as $socialpost) {
			    $userName 		= $socialpost['user']['name'];
				$link 		 	= 'https://twitter.com/' . $socialpost['user']['screen_name'] . '/status/' . $socialpost['id_str']; // Manually build the twitter link
				$postText		= $socialpost['text'];
			    $createdTime 	= strtotime($socialpost['created_at']);
			    $socialPostID 	= $socialpost['id_str'];
			    (isset($socialpost['entities']['media'])) ? $photo = $socialpost['entities']['media'][0]['media_url'] : $photo = "";

			    if(strcmp($socialPostID, $since_id) != 0) {
				    $pid = wp_insert_post(array(
						'post_author' => 1,
						'post_title' => $postText,
						'post_content' => $postText,
						'post_type' => CPT_SP,
						'post_status' => 'publish',
						'tax_input' => array(
							CPT_SP_TAX => array($term->slug)
						),
						'meta_input' => array(
							'user' => $userName,
							'link' => $link,
							'data_id' => $socialPostID,
							'created_time' => $createdTime,
							'post_thumb' => $photo,
						)
					));
					
					$wpsot = wp_set_object_terms($pid, 'source-twitter', CPT_SP_TAX, true);
				}
			}
		}
	}

	add_action( 'init', 'gwsf_create_social_post_type' );
	register_activation_hook( __FILE__, 'gwsf_activate_plugin' );
	register_deactivation_hook( __FILE__, 'gwsf_deactivate_plugin' );
 ?>