<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package typepress
 */

get_header(); ?>

       <?php 
        if ( is_front_page() && has_nav_menu('main_menu') ) {
            
            $menu_locations = get_nav_menu_locations();
            
            $menu = wp_get_nav_menu_object($menu_locations['main_menu']);
            
            if ( isset( $menu->name ) ) { 
                echo '<h2 class="main-menu-title">' . esc_html( $menu->name ) . '</h2>';
            }
            
            wp_nav_menu( 
                array( 
                    'theme_location' => 'main_menu', 
                    'menu_id' => 'main-menu',
                    'menu_class' => 'main-menu',
                    'depth' => 1,
                ) 
            );
          
        }
        ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
