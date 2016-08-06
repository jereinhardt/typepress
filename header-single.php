<?php
/**
 * The header for single posts
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
 
                <div class="site-logo"> 
                    <?php $site_title = get_bloginfo( 'name' ); ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"> 
                        <div class="screen-reader-text"> 
                            <?php printf( esc_html__( 'Go to home page of %1$s', 'typepress' ) ); ?>
                        </div>
                        <?php if ( has_custom_logo() ) { 
                            the_custom_logo();
                        } else { ?>
                            <div class="site-firstletter" aria-hidden="true"> 
                                <?php echo substr($site_title, 0, 1); ?>
                            </div>
                        <?php } ?>
                    </a>
                </div>
    
        <?php if ( has_post_thumbnail() ) { ?>
            <figure class="single-post-thumb"> 
                <?php the_post_thumbnail(); ?>
            </figure>
        <?php } ?>
    


    
<div id="page" class="site single-post-page" style="">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'typepress' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
            
                <?php // display site icon or first letter of site title ?>

            
                <div class="site-branding">
			
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
