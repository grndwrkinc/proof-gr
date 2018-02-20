<?php
	// current address
	$oldurl = strtolower($_SERVER['REQUEST_URI']);

	// new redirect address
	$newurl = '';

	// old to new URL map
	$redir = array(
		'/practices/'    				 		 			 => '/capabilities/',
		'/practices/*'						 				 => '/capabilities/',
		'/expertise/'						 	 			 => '/capabilities/',
		'/expertise/*'       				 				 => '/capabilities/',
		'/expertise/environics-digital/'       				 => '/capabilities/',
		'/about/environics-communications-cantrust-index/'    => '/thinking/the-environics-communications-cantrust-index/',
		'/expertise/whitepapers/modern-moms/'  	  			 => '/thinking/modern-moms/',
		'/expertise/whitepapers/content-marketing/'    	  	 => '/thinking/content-marketing/',
		'/about/our-team/'   	  							 => '/about/',
		'/about/meet-the-ceo/'   	 	  					 => '/about/',
		'/about/careers/'      			 	 				 => '/work-with-us/',
		'/blog/' 	 									     => '/thinking/',
		'/category/trends-insights/' 				 	     => '/tag/trends/',
		'/category/agency-life/'					 	    	 => '/tag/agency-life/',
		'/category/career-tips/'			 	 				 => '/tag/career-tips/',
		'/category/client-counsel/'	     	 				 => '/tag/client-counsel/',
		'/blog/page/*'	 								     => '/thinking/',
		'/expertise/whitepapers/'			 	 			 => '/thinking/',
		'/thinkintegrated/'		 	 						 => '/',
		'/contact/*'			 	 							 => '/contact/',
		// '/ca'                        		 				 	 => '/'
	);
	
	while ((list($old, $new) = each($redir)) && !$newurl) {
		if (strpos($oldurl, $old) !== false) {
			$newurl = $new;
		}
	}

	// redirect
	if ($newurl != '') {

		header('HTTP/1.1 301 Moved Permanently');
		header("Location: $newurl");
		exit();

	}
?>