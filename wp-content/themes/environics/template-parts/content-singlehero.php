<?php
/**
 * Template part for displaying the hero image, title and subhead found on single pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package environics
 */
?>

<?php 
	$classes = "";
	$hero = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
		if(!strlen($hero)) $classes = " no-image";
		$classes .= " text-" . strtolower(get_field('title_colour_picker'));
?>


	<?php if ( !is_front_page() ) : ?>
		<div class="hero-container">
			<div class="sub-hero span_8 single-page<?php echo $classes; ?>" style="background-image:url(<?php echo $hero; ?>)"></div>
			<div class="span_8">
				<h2 id="content"><?php the_title(); ?></h2>
				<?php if(get_post_type() != 'work') : ?>
				<!-- <p><?php // the_field('post_subheader'); ?></p> -->
				<?php endif; ?>
				<?php get_template_part( 'template-parts/content', 'socialbuttons' ); ?>
			</div>
		</div>
	<?php endif; ?>


