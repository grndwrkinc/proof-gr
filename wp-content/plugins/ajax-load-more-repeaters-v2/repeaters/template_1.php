<?php
	/**
	 * Template 1: Work With Us Masonry Gallery 
	 */

	$postID	= get_the_ID();	
	$source = wp_get_post_terms($postID, 'source', array("fields" => "all"))[0];
	if(!sizeof($source)) {
		$slug = "source-micropost";
		$label = "Culture";
	}
	else {
		$slug = $source->slug;
		$label = $source->name;
	}
	$postMeta = get_post_meta($postID);
	$postLink = $postMeta['link'][0];
	$imgSrc = $postMeta['post_thumb'][0];
	if($slug == "source-micropost") {
		$imgSrc = get_the_post_thumbnail_url($postID);
	}

	//Set a string of all the classes to apply to the tile
	$classes = "masonry-tile " . $slug;
	if(!strlen($imgSrc)) $classes .= " no-image";

	$inlineImg = $imgSrc;
?>

<?php
	//Hyperlink the tile to the source URL if it's not a micropost. Microposts don't have pages to link to
	if($slug != "source-micropost") { 
?>
	<a href="<?php echo $postLink; ?>" target="_blank"><?php } ?>
		<div class="<?php echo $classes; ?>">
        <?php if(isset($imgSrc)) { ?>
        <img src="<?php echo $imgSrc; ?>"/>
   		<?php } ?>
			<div class="tile-inner">
				<h5><?php echo $label; ?></h5>
				<div class="tile-content barr">
					<?php if($slug == "source-twitter") the_content(); ?>
					<?php if($slug == "source-micropost") { ?><p><?php the_title(); ?></p><?php } ?>
				</div>
			</div>
		</div>
<?php
	//Close the anchor
	if($slug != "source-micropost") {
?>
	</a>
<?php } ?>