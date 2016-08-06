<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package typepress
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
    
<div id="page" class="site" style="">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'typepress' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
            
                <?php // display site icon or first letter of site title ?>
                <div class="site-logo"> 
                    <?php $site_title = get_bloginfo( 'name' ); ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"> 
                        <div class="screen-reader-text"> 
                            <?php printf( esc_html__( 'Go to home page of %1$s', 'typepress' ) ); ?>
                        </div>
                        <?php if ( has_site_icon() ) { 
                            $site_icon = esc_url( get_site_icon_url( 270 ) ); ?>
                            <img class="site-icon" src="<?php echo $site_icon; ?>" alt="" >
                        <?php } else { ?>
                            <div class="site-firstletter" aria-hidden="true"> 
                                <?php echo substr($site_title, 0, 1); ?>
                            </div>
                        <?php } ?>
                    </a>
                </div>
            
                <div class="site-branding">
			<?php //check to see if front page
			if ( is_front_page() ) { ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php
                                $description = get_bloginfo( 'description', 'display' );
                                if ( $description || is_customize_preview() ) { ?>
                                    <p class="site-description"><?php echo $description ?></p>
                                <?php } 
                        } elseif ( is_home() ) { //if blog page ? ?>
                                    <h1 class="site-title"><?php echo get_bloginfo( 'name' ); ?></h1>
                                    <?php 
                                    $posts_page = get_page( get_option( 'page_for_posts' ) );
                                     if ( isset($posts_page->post_content) ) { ?>
                                        <p class="site-description"><?php echo $posts_page->post_content; ?></p>
                                    <?php }                                                                      
                         } else { //not home or blog page ?>
                                    <h1 class="site-title"><?php echo get_the_title(); ?></h1>
			<?php } ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( '', 'typepress' ); ?></button>
			<?php wp_nav_menu( 
                                array( 
                                    'theme_location' => 'primary', 
                                    'menu_id' => 'primary-menu',
                                    'menu_class' => 'nav-menu',
                                    ) 
                                ); 
                        ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
       
        <div id="content" class="site-content">
