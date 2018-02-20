<!-- Get the title and replace spaces with 20% for twitter share URL -->
<?php $title = get_the_title(); 
	  $spaces = ' ';
	  $websafe= '%20';
	  $newtitle = str_replace($spaces, $websafe, $title);

	  // Get the site title for the linked in share URL
	  $blog_title = get_bloginfo();
	  $newblog_title = str_replace($spaces, $websafe, $blog_title);
?>

<div class="social-share">
	<ul>
		<li id="fbShare"><a rel="nofollow" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" title="Share this on Facebook" target="_blank" class="socialShareLink" aria-label="Link to Environics Facebook account"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>

		<li id="twitterShare"><a rel="nofollow" href="http://twitter.com/home?status=<?php echo $newtitle; ?>%20<?php echo get_permalink(); ?> (via @environicspr)" target="_blank" title="Tweet this" class="socialShareLink" aria-label="Link to Environics Twitter account"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>

		<li id="linkedinShare"><a rel="nofollow" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(); ?>&title=<?php echo $newtitle; ?>&summary=&source=<?php echo $newblog_title; ?>" target="_blank" title="Share this on LinkedIn" class="socialShareLink" aria-label="Link to Environics LinkedIn account"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
		
		<li id="mailShare"><a href="mailto:?subject=<?php echo $title; ?>%20-%20Environics%20Communicatons&body=<?php echo get_permalink();?>" aria-label="Link to send an email about this post"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>
	</ul>
</div>