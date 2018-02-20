<?php
	(get_field("video_image")) ? $videoImage = get_field("video_image") : $videoImage = get_sub_field("video_image");
	(get_field("video")) ? $videoSrc = get_field("video") : $videoSrc = get_sub_field("video");
?>
<div class="video-wrapper" data-iframe='<?php echo $videoSrc; ?>'></div>
<!-- <div class="video-image">
	<img src="<?php //echo $videoImage; ?>" alt=""/>
	<a href="#" class="videoPlay" aria-label="play button"><i class="fa fa-play" aria-hidden="true"></i></a>
</div>

Modal popup with video
<div class="modal">
	<div class="close" tabindex="0" role="button">
		<div class="nav-bar"></div>
	</div>
	<div class="video-wrapper" data-iframe='<?php //echo $videoSrc; ?>'></div>
</div> -->