<?php
/**
 * environics functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package environics
 */

if ( ! function_exists( 'environics_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function environics_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on environics, use a find and replace
	 * to change 'environics' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'environics', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'environics' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'environics_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'environics_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function environics_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'environics_content_width', 640 );
}
add_action( 'after_setup_theme', 'environics_content_width', 0 );

/* INCREASE UPLOAD FILE SIZE */

@ini_set( 'upload_max_size' , '10M' );
@ini_set( 'post_max_size', '10M');
@ini_set( 'max_execution_time', '300' );
 
/* CUSTOM TAXONOMIES */

// Load in files that contain custom taxonomies and custom post types
function custom_taxonomies() {
    // Here we load from our includes directory
    locate_template( array( 'inc/taxonomies.php' ), true, true );
}
add_action( 'after_setup_theme', 'custom_taxonomies' );

/* Allow SVG file upload */
function cc_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

// ACF Google Maps add API key
function my_acf_google_map_api( $api ){	
	$api['key'] = 'AIzaSyBFjS94A96ckf7ORh6XGSeMZSumZyX7liY';
	return $api;	
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

function my_acf_init() {
	
	acf_update_setting('google_api_key', 'AIzaSyBFjS94A96ckf7ORh6XGSeMZSumZyX7liY');
}

add_action('acf/init', 'my_acf_init');

/* ACF activate options page */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();	
}

/* Add custom comments output callback function, gets called in wp_list_comments */
function environics_comment( $comment, $args, $depth ){
        $GLOBALS['comment'] = $comment; ?>
    <li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>

    <div class="media-body">
	    <?php printf( '<h4 class="media-heading">%s</h4>', get_comment_author_link() ); ?>
	    <div class="comment-metadata">
	        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
	            <time datetime="<?php comment_time( 'c' ); ?>">
	                <?php printf( _x( '%1$s', '1: date' ), get_comment_date() ); ?>
	            </time>
	        </a>
	    </div><!-- .comment-metadata -->

	    <?php if ( '0' == $comment->comment_approved ) : ?>
	    <p class="comment-awaiting-moderation label label-info"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
	    <?php endif; ?>             

	    <?php
	        comment_reply_link( array_merge( $args, array(
	            'add_below' => 'div-comment',
	            'depth'     => $depth,
	            'max_depth' => $args['max_depth'],
	            'before'    => '<div class="reply-link">',
	            'after'     => '</div>'
	        ) ) );  
	    ?>
    </div>  
    <div class="comment-content">
         <?php comment_text(); ?>
    </div>
<?php
}

/* Add custom taxonomies and custom post types counts to dashboard */
function my_add_cpt_to_dashboard() {
  // Custom post types counts
  $post_types = get_post_types( array( '_builtin' => false ), 'objects' );
  foreach ( $post_types as $post_type ) {
    if($post_type->show_in_menu==false) {
      continue;
    }
    $num_posts = wp_count_posts( $post_type->name );
    $num = number_format_i18n( $num_posts->publish );
    $text = _n( $post_type->labels->singular_name, $post_type->labels->name, $num_posts->publish );
    if ( current_user_can( 'edit_posts' ) ) {
        $output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . ' ' . $text . '</a>';
    }
    echo '<li class="page-count ' . $post_type->name . '-count">' . $output . '</td>';
  }
}
add_action( 'dashboard_glance_items', 'my_add_cpt_to_dashboard' );

// /* Remove Posts from sidebar menu */
function remove_menus () {
global $menu;
	$restricted = array(__('Posts'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'remove_menus');

// Custom Shortcodes 

 // Add Shortcode
function custom_images( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'id' => '',
		), $atts )
	);

	$image_array = explode(", ", $id);

	// Code
	// return '
	$output = '
	</div><!-- close text -->
	</div><!-- close container-->
	</div>
	<div class="block bg-pattern-purple">
		<div class="container images">';

	foreach ($image_array as $image_id) {
		$image_attributes = wp_get_attachment_image($attachment_id = $image_id, 'full');
		$output .= '<div class="image">' . $image_attributes . '</div>';
	}
		
	$output .= '
		</div>
	</div>
	<div class="block text">
    	<div class="container">
    		<div class="page-text">';

    return $output;
}
add_shortcode( 'image_min', 'custom_images' );

//Custom Comments form

function disable_comment_url($fields) { 
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields','disable_comment_url');

function remove_comments_title( $defaults ){
    $defaults= array(
    	'title_reply' => 'Add a comment',
    	'comment_notes_before' => '',
    	'class_form' => 'container comment-container',
    	'label_submit' => 'Submit',
    	'comment_field' => '<p class="comment-form-comment"><textarea name="comment" id="comment" title="comment" cols="45" rows="8" aria-required="true" placeholder="Comment goes here"></textarea></p>',
    	);
   
    return $defaults;
}
add_filter( 'comment_form_defaults', 'remove_comments_title' );

//Alter the name and email fields in Comments

function alter_comment_form_fields($fields){

	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	if ($req == 1) {
		$aria_req = 'true';
	};

    $fields['author'] = '<p class="comment-form-author">' . '<label for="author">' . __( '' ) . '</label><input id="author" name="author" type="text" placeholder="Name" value="" size="30" aria-req="' . $aria_req . '" /></p>';
    $fields['email'] = '<p class="comment-form-email"><label for="email"></label> <input id="email" name="email" type="email" placeholder="Email" value="" size="30" maxlength="100" aria-describedby="email-notes"  aria-req="' . $aria_req . '" ></p>';  
    return $fields;
}

add_filter('comment_form_default_fields','alter_comment_form_fields');


// Remove wysiwyg editor from Micro Blog Posts
add_action('init', 'init_remove_support',100);
function init_remove_support(){
    $post_type = 'micropost';
    remove_post_type_support( $post_type, 'editor');
}

// Remove dropzone from Apply Form
add_filter( 'frm_load_dropzone', '__return_false' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function environics_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'environics' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'environics' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'environics_widgets_init' );

//Disable WordPress canonical URL guessing for /ca only, redirect to home page
function redirect_ca_to_homepage( $redirect_url ) {

	$host = "http://$_SERVER[HTTP_HOST]";
	$requested_uri = "$_SERVER[REQUEST_URI]";
	$temp = explode("?", $requested_uri);
	$uri_string = $temp[0];
	
    if ( $uri_string == "/ca/" ) {
    	return "$host/";
    }
        
    else {
    	return $redirect_url;
    }
    
}
add_filter( 'redirect_canonical', 'redirect_ca_to_homepage' );

/**
 * Enqueue scripts and styles.
 */
function environics_scripts() {
	//Screen stylesheet
	wp_enqueue_style( 'environics-style', 'http://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/environics/assets/css/style.css', array(), '1.1' );

	//Print stylesheet
	wp_enqueue_style( 'environics-print-style', 'http://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/environics/assets/css/print.css', null, null, 'print' );

	//Fonts 
	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Lora');
	wp_enqueue_script( 'web-fonts', '//fast.fonts.net/jsapi/bdf699ec-1a4b-4755-9b43-cfa1c3085ec2.js"');
	wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('flickity-css', '//unpkg.com/flickity@2.0/dist/flickity.css', array(), null);

	//Deregister Wordpress baked-in JQuery and load from CDN
	wp_deregister_script('jquery');
   	wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js", false, null);
   	wp_enqueue_script('jquery');

	wp_enqueue_script( 'environics-navigation', 'http://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/environics/assets/js/navigation.js', array(), '20151215', true  );

	//FluidVids
	wp_enqueue_script( 'fluidvids', 'http://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/environics/assets/js/fluidvids/dist/fluidvids.min.js', array(), '2.4.1', true);

	//Flickity
	wp_enqueue_script( 'flickity-js', 'https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js', array('jquery'), null, true);

	//Masonry
	wp_deregister_script('masonry');
	wp_enqueue_script( 'imagesloaded', 'https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js', array(), '4.1', true);
	wp_enqueue_script( 'masonry', 'https://unpkg.com/masonry-layout@4.1/dist/masonry.pkgd.min.js', array('imagesloaded'), null, true);

	wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );	

	wp_enqueue_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBFjS94A96ckf7ORh6XGSeMZSumZyX7liY', array(), '3', true );

	wp_enqueue_script( 'google-map-init', 'http://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/environics/assets/js/google-maps.js', array('google-map', 'jquery'), '0.1', true );

	wp_enqueue_script( 'environics-scripts', 'http://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/environics/assets/js/scripts-min.js', array(), '2.4.1', true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'environics_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Function: get_string_between($string, $start, $end)
 * Return the resulting string between to given strings
 * Source:	http://www.justin-cook.com/wp/2006/03/31/php-parse-a-string-between-two-strings/
 **/
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

/**
 * Function: getInstagramProper($sourceURL)
 * Get the full size, uncropped, proper aspect ratio image;
 **/
function getInstagramProper($sourceURL) {
	$urlPart = get_string_between($sourceURL, "/e35/", "?ig_cache_key");
	
	if($urlPart[0] == "c") {
		$junk = "";
		
		for($i=0; $i<strlen($urlPart); $i++) {
			$junk .= $urlPart[$i];
			if($urlPart[$i] == "/") break;
		}
		$urlPart = substr($urlPart, strlen($junk));
	}

	return "https://scontent.cdninstagram.com/t51.2885-15/e35/" . $urlPart;
}
	
/**
 * Function: add_slug_body_class( $classes )
 * Adds a class to the body tag with the format: .page-{slug}
 * Source: http://www.wpbeginner.com/wp-themes/how-to-add-page-slug-in-body-class-of-your-wordpress-themes/
 **/
function add_slug_body_class( $classes ) {
	global $post;
	if(isset($post)) {
		$tags = get_the_terms($post->ID, 'tags');
		$taglist = array();
		if(is_array($tags)){
			foreach ($tags as $tag) {
				$tag_name = $tag->name;
				array_push($taglist, $tag_name);
			}
		}
		if ( isset( $post ) ) {
			$classes[] = $post->post_type . '-' . $post->post_name;
			foreach ($taglist as $singletag) {
				$classes[] .= $post->post_type . '-' . strtolower($singletag);
			}
		}
		return $classes;
	}
	
}
add_filter( 'body_class', 'add_slug_body_class' );


/**
 * Function: environics_add_micropost_created_date( $post_id, $post, $update )
 * Adds a meta key of created_time to a micropost post type
 * Source: http://www.wpbeginner.com/wp-themes/how-to-add-page-slug-in-body-class-of-your-wordpress-themes/
 **/
function environics_add_micropost_created_date( $post_id, $post, $update ) {
	if (get_post_type($post) == 'micropost') {
		$created_time = get_post_time('U', false, $post);
		add_post_meta($post_id, 'created_time', $created_time, true);
		wp_insert_term('Culture', 'source', array('slug' => 'source-micropost'));
		// wp_set_object_terms( $post_id, 'Culture', 'source-micropost', true);

	}
}
add_action( 'wp_insert_post', 'environics_add_micropost_created_date', 10, 3 );