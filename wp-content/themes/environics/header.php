<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package environics
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'environics' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<?php $site_logo = get_field('site_logo', 'option'); ?>
			<a class="nav-item" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo $site_logo['url']; ?>" alt="<?php echo $site_logo['alt']; ?>"/></a>
			<div class="hamburger-outer-container">
				<div class="hamburger-container" tabindex="0" role="button" aria-label="Site menu">
					<p class="enter">M</p><p class="exit">E</p>
					<div class="hamburger">
						<div class="patty"></div>
					</div>
					<p class="enter">N</p><p class="exit">I</p>
					<p class="enter">U</p><p class="exit">T</p>
				</div>
			</div>
		</div><!-- .site-branding -->
		
		<nav id="site-navigation" class="main-navigation nav-container hide" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'environics' ); ?></button>
			<div class="menu-primary-container outer">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu' => 'Primary' ) ); ?>
				<div class="social-icons">
					<a href="<?php the_field('twitter_account', 'option'); ?>" target="_blank" alt="Twitter link" aria-label="Link to Environics Twitter account"><i class="fa fa-twitter" aria-hidden="true"></i></a>
					<a href="<?php the_field('facebook_account', 'option'); ?>" target="_blank" alt="Facebook link" aria-label="Link to Environics Facebook account"><i class="fa fa-facebook" aria-hidden="true"></i></a>
					<a href="<?php the_field('instagram_account', 'option'); ?>" target="_blank" alt="Instagram link" aria-label="Link to Environics Instagram account"><i class="fa fa-instagram" aria-hidden="true"></i></a>
					<a href="<?php the_field('youtube_account', 'option'); ?>" target="_blank" alt="Youtube link" aria-label="Link to Environics Youtube account"><i class="fa fa-youtube" aria-hidden="true"></i></a>
					<a href="<?php the_field('linkedin_account', 'option'); ?>" target="_blank" alt="LinkedIn link" aria-label="Link to Environics LinkedIn account"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
				</div>
			</div>
		</nav>

	</header><!-- #masthead -->

	<div class="site-content">
		
