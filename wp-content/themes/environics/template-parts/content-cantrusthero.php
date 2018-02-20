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
	// $hero = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
	$hero = "";
		if(!strlen($hero)) $classes = " no-image";
		$classes .= " text-" . strtolower(get_field('title_colour_picker'));
?>


	<?php if ( !is_front_page() ) : ?>
		<div class="hero single-page cantrust-header<?php echo $classes; ?>" style="background-image:url(<?php echo $hero; ?>)">
			<div class="container">
				<?php 
					$logo = get_field('logo');
						if( !empty($logo) ): ?>
							<img class="cantrust-logo" src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" />
				<?php endif; ?>
				<h1 id="content"><?php the_title(); ?></h1>
			</div>
		</div>
	<?php endif; ?>