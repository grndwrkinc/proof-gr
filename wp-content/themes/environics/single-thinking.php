<?php
get_header();
?>

<?php 
	$tags = get_the_terms($post->ID, 'tags');
	$tagMatched = false;
	if($tags != false) {
		foreach ($tags as $tag) {
			if(strcmp(strtolower($tag->name),"cantrust") == 0) {
				$tagMatched = true;
			}
		}
	}

	if(has_term('Report', 'thinking_categories', $post->ID) && $tagMatched) {
		get_template_part('template-parts/content', 'cantrust'); 
	}
	else {
		get_template_part('template-parts/content', 'thinking');
	}
?>

	
<?php
get_footer();
