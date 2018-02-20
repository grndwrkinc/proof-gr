

<?php 

$infographic = get_sub_field('image');

if( !empty($infographic) ): ?>
	<div class="infographic-image fa fa-eye">
		<a href="#" class="infographicShow"><img class="infographic_image" src="<?php echo $infographic['url']; ?>" alt="<?php echo $infographic['alt']; ?>"> </a>
	</div>


<!-- Modal popup with video -->
<div class="modal">
	<div class="close" tabindex="0" role="button"></div>
	<div class="infographic-wrapper"><img src="<?php echo $infographic['url']; ?>" alt="<?php echo $infographic['alt']; ?>"></div>
</div>
<?php endif; ?>