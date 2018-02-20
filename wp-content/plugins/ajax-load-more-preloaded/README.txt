=== Ajax Load More: Preloaded ===

Contributors: dcooney
Author: Darren Cooney
Author URI: http://connekthq.com/
Plugin URI: http://connekthq.com/ajax-load-more/preloaded/
Requires at least: 3.6.1
Tested up to: 4.1
Stable tag: trunk
Homepage: http://connekthq.com/ajax-load-more/preloaded/
Version: 1.2.1


== Copyright ==
Copyright 2015 Darren Cooney

This software is NOT to be distributed, but can be INCLUDED in WP themes: Premium or Contracted.
This software is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.


== Description ==

= Quickly and easily preload an initial set of posts before completing any Ajax requests to the server with the Ajax Load More Preloaded add-on! =

The Preloaded add-on will render content to the screen faster and allow you to cache the initial result set which can greatly reduce load times and stress on your server.

http://connekthq.com/plugins/ajax-load-more/preloaded/

== Installation ==

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `ajax-load-more-preloaded.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `ajax-load-more-preloaded.zip`.
2. Extract the `ajax-load-more-preloaded` directory to your computer.
3. Upload the `ajax-load-more-preloaded` directory to the `/wp-content/plugins/` directory.
4. Ensure Ajax Load More is installed prior to activating the plugin.
5. Activate the plugin in the WP plugin dashboard.



== Changelog ==

= 1.2.1 =
* FIX - Fixed issue for querying by meta_key - users are not required to enter a meta_value to query by meta_key.
* FIX - Fixed issue where meta_key and meta_value were unable to pull shortcode values from core ALM.


= 1.2 =
* UPDATE - Updating plugin update script. Users are now required to input a license key to receive updates directly within the WP Admin. Please contact us for information regarding legacy license keys.
* NEW - Added multiple meta query functionality to the shortcode builder - users can now query by up to 4 custom fields.
* FIX - Fixed bug with the 'custom_args' parameter that was blocking arrays from being passed. Please check the documentation for the updated 'custom_args' syntax for multiple values.


= 1.1.1 =
* Adding 'custom_args' parameter.


= 1.1 =
* Adding 'post__in' parameter.


= 1.0 =
* Initial Release.
