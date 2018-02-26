<?php
/**
 * Template part for displaying the hero image, title and subhead found on top-level pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package environics
 */
?>

<?php 
	$hero = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	//Home Page Hero (Background video)
	if ( is_front_page() || is_page ('fr') ) : 
?>
	<div class="hero" style="background-image: url('<?php echo $hero; ?>')">
		<!-- svg content goes here -->
		<img src="/wp-content/themes/environics/assets/images/ProofStrategiesLogo-white.svg" alt="Proof Strategies">
	</div>
<?php 

	//Default Hero (No video)
	else :
		$hero = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		if(!strlen($hero)) $classes = " no-image";
?>
	<div class="hero" style="background-image:url(<?php echo $hero; ?>)">
		<h1><?php the_title(); ?></h1>
	</div>
<?php 
	endif;
?>
