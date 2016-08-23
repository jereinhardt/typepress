<?php
/**
 * typepress functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package typepress
 */

if ( ! function_exists( 'typepress_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function typepress_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on typepress, use a find and replace
	 * to change 'typepress' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'typepress', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
        
            /*
            * add aditional sizes for featured images
            */
        
          set_post_thumbnail_size(800, 345, true);
          add_image_size('long', 900, 220, array('center','center'));
          add_image_size('menu-thumb', 800, 533);
          add_image_size('typeress-small-thumb-square', 300, 300, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'typepress' ),
                'main_menu' => esc_html__( 'Main Menu', 'typepress' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'typepress_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
        
        add_editor_style( array(
            'inc/editor-style.css',
        ) );
}
endif;
add_action( 'after_setup_theme', 'typepress_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function typepress_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'typepress_content_width', 640 );
}
add_action( 'after_setup_theme', 'typepress_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function typepress_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'typepress' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'typepress' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

//only include these extra menues if the user has the CPCM plugin installed
if ( class_exists('CPCM_Manager') ) {
    add_action( 'after_setup_theme', 'add_custom_menus' );
    /**
     * Register Menus for each page that has a custom menu 
     *
     */
    function add_custom_menus() {

        $menus = array();

        $args = array(
            'meta_key' => 'has_custom_menu',
            'meta_value' => '1',
            'offset' => 0,
            'post_type' => 'page',
            'post_status' => 'publish'
        );

        $pages = get_pages( $args );
        foreach ( $pages as $page ) {
            $menu_name  = $page->post_title;
            $menu_id = str_replace(" ", "_", trim( strtolower($page->post_title) ) );      
            $menus[$menu_id] = esc_html__( $menu_name, 'typepress' );
        }

        register_nav_menus( $menus );

    }
}

/**
 * Used on page.php to get any registered custom menus
 */

function get_custom_menu( ) {
    global $post;
    $has_custom_menu = get_post_meta($post->ID, 'has_custom_menu', true);
    $menu_id = str_replace( " ", "_", trim( strtolower( $post->post_title ) ) );
    if ( $has_custom_menu && has_nav_menu( $menu_id ) ) { 
        wp_nav_menu( 
            array( 
                'theme_location' => $menu_id, 
                'menu_id' => $menu_id,
                'menu_class' => 'custom-menu',
            ) 
        );      
    }
    
}
add_action( 'widgets_init', 'typepress_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function typepress_scripts() {
    
//        wp_enqueue_style( 'typepress-local-fonts', get_template_directory_uri() . '/fonts/custom-fonts.css' );

	wp_enqueue_style( 'typepress-style', get_stylesheet_uri() );
        
        wp_enqueue_style( 'typepress-fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );       
        //HEADER FONTS
        //Old standard TT
        wp_enqueue_style( 'typepress-fonts-old-standard', 'https://fonts.googleapis.com/css?family=Old+Standard+TT:400,400italic,700' );      
        //BODY FONTS 
        //Frank Ruhl Libre
        wp_enqueue_style( 'typepress-fonts-etc', "https://fonts.googleapis.com/css?family=Frank+Ruhl+Libre:300,400,700" );
        
	wp_enqueue_script( 'typepress-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'typepress-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
        
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'typepress_scripts' );

/**
 * Create Functionality that allows users custom menu locations on certain pages
 * then add those custom menue locations to the theme
 */
add_action( 'add_meta_boxes', 'add_custom_menu_checkbox' );
function add_custom_menu_checkbox() {
	add_meta_box('custom_menu','Typepress Theme Options', 'custom_menu_callback', 'page');
}
function custom_menu_callback( $post ) {
	global $post;
	$isFeatured=get_post_meta( $post->ID, 'has_custom_menu', true );
?>
	
	<input type="checkbox" name="has_custom_menu" value="1" <?php echo (($isFeatured=='1') ? 'checked="checked"': '');?>/> Create a custom menu for this page
        <?php if ( !class_exists('CPCM_Manager') ): ?> 
            <br />This feature will only work if the <a target="_blank" href="https://wordpress.org/plugins/category-posts-in-custom-menu/">Category Posts in Custom Menu</a> plugin is installed.
        <?php endif; ?>
<?php
}

if ( class_exists('CPCM_Manager') ):
    add_action('save_post', 'save_page_with_custom_menu'); 
endif;
function save_page_with_custom_menu($post_id){ 
    if ( isset($_POST['has_custom_menu']) ) {
	update_post_meta( $post_id, 'has_custom_menu', $_POST['has_custom_menu']);
    } else {
        update_post_meta( $post_id, 'has_custom_menu', 0);
    }
}

//Outputs a continued reading button for index content with excerpts
function typepress_excerpt_more( $post ) {
    $link = get_permalink( $post->ID );
    $out  = "<p>";
    $out .= '<a href="' . $link . '" class="more-link">';
    $out .= "Continued Here...";
    $out .= "</a></p>";
    return $out;
}


class Menu_With_Description extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        
        if ( !isset($item->title) ) {
           return;
        }
        
        global $wp_query;
        
        $indent = ($depth) ? str_repeat("t", $depth) : "";
        
        $class_names = $value = "";
        
        $classes = empty( $item->classes ) ? array() : (array)$item->classes;
        
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter($classes), $item ) );
        
        $class_names = ' class="' . esc_attr( $class_names ) . '"';
        
        $output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names .'>';
        
        
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr( $item->target ) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr( $item->url ) . '"' : '';
        
        //get user defined attributes for thumbnail images
        $attr_defaults = array( 'class' => 'nav_thumb', 'alt' => esc_attr( $item->attr_title ), 'title' => esc_attr( $item->attr_title ) );
        $attr = isset( $args->thumbnail_attr ) ? $args->thumbnail_attr : '';
        $attr = wp_parse_args( $attr, $attr_defaults );
        
        $item_output = $args->before;
        
        //menu link output 
//        $item_output .= '<a class="list-item-title"' . $attributes . '>';    
//        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '<a class="list-item-link"' . $attributes . '>';    
        $item_output .= '<h4 class="list-item-title">' . apply_filters( 'the_title', $item->title, $item->ID ) . "</h4>";

        //thumbnail image output 
//        $item_output .= ( isset( $args->thumbnail_link ) && $args->thumbnail_link ) ? '<a' . $attributes . '>' : '';
        $item_output .= apply_filters( 'menu_item_thumbnail' , ( isset( $args->thumbnail ) && $args->thumbnail ) ? get_the_post_thumbnail( $item->object_id , ( isset( $args->thumbnail_size ) ) ? $args->thumbnail_size : 'menu-thumb' , $attr ) : '' , $item , $args , $depth );
//        $item_output .= ( isset( $args->thumbnail_link ) && $args->thumbnail_link ) ? '</a>' :'';
        
        // menu description output based on depth
        $item_output .= ( $args->desc_depth >= $depth ) ? '<p class="item-description">' . $item->description . '</p>' : '';

        // close menu link anchor
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );

    }
}

add_filter( 'wp_nav_menu_args' , 'my_add_menu_descriptions' );
function my_add_menu_descriptions( $args ) {
    if ( $args['theme_location'] == 'main_menu' ) {
        $args['walker'] = new Menu_With_Description;
        $args['desc_depth'] = 0;
        $args['thumbnail'] = true;
        $args['thumbnail_link'] = true;
        $args['thumbnail_size'] = 'menu-thumb';
        $args['thumbnail_attt'] = array( 'class' => 'nav_thumb my_thumb' , 'alt' => 'test' , 'title' => 'test' );
    } 
    
    return $args;
}



function wpb_mce_buttons_2($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'wpb_mce_buttons_2');

function my_mce_before_init_insert_formats( $init_array ) {
    // Define the style_formats array
    $style_formats = array( 
        // Each array child is a format with it's own settings
        array( 
            'title' => 'Character Name', 
            'block' => 'p', 
            'classes' => 'character-name',
            'wrapper' => false,
        ),
        array( 
            'title' => 'Dialogue', 
            'block' => 'p', 
            'classes' => 'dialogue',
            'wrapper' => false,
        ),
        array( 
            'title' => 'Stage Direction', 
            'block' => 'p', 
            'classes' => 'direction',
            'wrapper' => false,
        ),
        array( 
            'title' => 'Poem Stanza', 
            'block' => 'div', 
            'classes' => 'stanza',
            'wrapper' => true,
        ),
        array(
            'title' => 'Prose Paragraph',
            'block' => 'p',
            'classes' => 'prose-para',
            'wrapper' => false,
        ),
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats ); 
    
    return $init_array;

}

// Attach callback to 'tiny_mce_before_init'
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
