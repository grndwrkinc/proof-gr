<div class="block related-posts <?php if( get_post_type() == 'thinking'){ if($category == 'Insight') { echo "bg-pattern-white"; }} ?>">
	<div class="container">
		<?php while ( $related_posts->have_posts() ) : $related_posts->the_post();
				global $post; 
				$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
				$feat_image = $feat_image_array[0];
				if(strlen($feat_image)) {
					$classes = "";
				} else {
					$classes = 'no-image';
				};
				$post_type = get_post_type();
				$page_taxonomy = get_object_taxonomies( $post_type );
				$taxonomy_name = $page_taxonomy[0];
				$page_category = get_the_terms( $post->ID, $taxonomy_name ); 
				$label = get_field('client');?>

		<div class="post <?php echo $classes; ?>" style="background-image:url(<?php echo $feat_image; ?>)">
			<a href="<?php echo the_permalink(); ?>">
				<div class="inner">
					<h5><?php echo $label ?></h5>
					<h3><?php echo the_title(); ?></h3>
				</div>
			</a>
		</div>
<?php endwhile; // End of the related posts loop.?>
	</div>
</div>

<?php wp_reset_postdata(); ?>