<?php
get_header(); 
?>
	<div id="primary" class="content-area page-author">
		<div class="hero" style="background-image:url('/wp-content/uploads/2016/08/0.1-capabilities_0d.jpg')">
			<h1><?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name; ?></h1>
		</div>
		<div class="text-container span_7">
			<p>See what else we have to say about <?php echo $term->name; ?></p>
		</div>
<?php 
	if ( have_posts() ) : ?>
		
		<div class="post-overview">
			<a href="javascript:window.history.back();" class="back-button">Back to article</a>
		</div>
			<!-- Gallery of Posts -->
		<div class="archive-container">
<?php 
		echo do_shortcode('[ajax_load_more repeater="template_5" preloaded="true" preloaded_amount="10" post_type="thinking" taxonomy="tags" taxonomy_terms="'.$term->name.'" taxonomy_operator="IN" scroll="false" posts_per_page="4" destroy_after="99" button_label="See More"]');
?>
		</div>
<?php 
	endif;
?>
	</div><!-- end #primary -->

<?php
get_footer();
