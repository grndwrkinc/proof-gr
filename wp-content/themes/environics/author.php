<?php
get_header('author');

$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$author_ID = $curauth->ID;
$args = array(
	'posts_per_page' => '9',
	'post_type' => 'thinking',
	'author' => $author_ID
);
query_posts( $args );

?>
	<div id="primary" class="content-area page-author">
		<div class="hero-container">
<?php
		// Retrieve the post's author ID
		$user_id = $curauth->ID;
		// Get the full size image URL using the author ID
		$imgURL = get_cupp_meta($user_id, 'full');
		$classes = 'no-image';
		if(strlen($imgURL)) :
			$classes = '';
?>
			<div class="sub-hero span_8 single-page<?php echo $classes; ?>" style="background-image:url(<?php echo $imgURL; ?>)"></div>
<?php						
		endif;
?>
			<div class="span_8">
				<h2><?php echo $curauth->display_name; ?></h2>
			</div>
		</div>
<?php 		
		if ( get_the_author_meta('description', $author_ID)) : 
?>
		<div class="text-container span_11">
			<p><?php the_author_meta( 'description', $author_ID ); ?></p>
		</div>
<?php 		
		endif; 
?>

<?php 
		if ( have_posts() ) :
?>
		<div class="post-overview">
			<a href="javascript:window.history.back();" class="back-button">Back to article</a>
		</div>
		<!-- Gallery of Posts -->
		<div class="archive-container">
<?php 
			echo do_shortcode('[ajax_load_more repeater="template_5" preloaded="true" post_type="thinking, news" author="' . $author_ID . '" scroll="false" posts_per_page="4" destroy_after="99" button_label="See More"]');
?>
		</div>
<?php
		else:
?>
		<div class="post-overview">
			<a href="javascript:window.history.back();" class="back-button">Back to article</a>
		</div>
		<div class="archive-container">
			<div class="tiles-item">
				<p><?php echo $curauth->display_name; ?> has not written any articles yet.</p>
			</div>
		</div>

<?php 
		endif;
?>

	</div><!-- #primary -->

<?php
get_footer();
