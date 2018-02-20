<?php
	if( have_rows('section_accordion') ) :
?>

	<div class="dropdown-gallery">

<?php $count = 0;
	while ( have_rows('section_accordion') ) : the_row();
		$accordion_image = get_sub_field('accordion_image');
		$countclass = '';
		if ($count % 3 == 2) {
			$countclass = 'three';
		} elseif ($count % 3 == 1) {
			$countclass = 'two';
		} else {
			$countclass = 'one';
		};
?>
		<div class="dropdown-item span_4">
			<h5><?php the_sub_field('accordion_title'); ?></h5>
			<div class="dropdown-content">
				<div class="content-inner <?php echo $countclass; ?>">
					<h2><?php the_sub_field('accordion_title'); ?></h2>
					<div class="dropdown-flex">
					<?php if($accordion_image != false ): ?>
						<div class="span_4">
							<img src="<?php echo $accordion_image['url']; ?>" alt="<?php echo $accordion_image['alt']; ?>">
						</div>
						<div class="span_5">
							<div><?php the_sub_field('accordion_content'); ?></div>
						</div>
					<?php else: ?>
						<div class="span_6">
							<div><?php the_sub_field('accordion_content'); ?></div>
						</div>
					<?php endif; ?>
						
					</div>
				</div>
			</div>
		</div>
<?php 
	$count ++;
	endwhile; 
?>
	</div>
<?php
	endif;
?>