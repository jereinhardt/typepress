<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package typepress
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else : 
                    if ( has_post_thumbnail() ): ?>
                        <figure class="content-post-thumb"> 
                            <?php the_post_thumbnail( 'long' ); ?>
                        </figure> <?php
                     endif;
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );                  
                endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php typepress_header_meta(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
                if ( !is_single() && has_excerpt()) {
                        the_excerpt();
                        echo typepress_excerpt_more($post);
                } else {
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continued Here... %s', 'typepress' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'typepress' ),
				'after'  => '</div>',
			) );
                }
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
