<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'javala', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'javala' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Javala', 'javala' ) );
define( 'CHILD_THEME_URL', 'http://cmsthemefactory.com/themes/javala/' );
define( 'CHILD_THEME_VERSION', '1.1' );

add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
wp_enqueue_style( 'dashicons' );
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'javala_enqueue_scripts_styles' );
function javala_enqueue_scripts_styles() {

	wp_enqueue_script( 'javala-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700|Raleway:400,500', array(), CHILD_THEME_VERSION );

}

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'default-text-color'     => 'ffffff',
	'header-selector'        => '.site-title a',
	'header-text'            => false,
	'height'                 => 120,
	'width'                  => 320,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Unregister secondary sidebar 
add_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );

//* Add custom body class to the head
add_filter( 'body_class', 'javala_custom_body_class' );
function javala_custom_body_class( $classes ) {

	$classes[] = 'javala';
	return $classes;

}

//* Hook site header banner after header
add_action( 'genesis_after_header', 'javala_site_header_banner' );
function javala_site_header_banner() {

	if ( ! get_background_image() )
		return;

	echo '<div class="site-header-banner"></div>';

}

//* Hook site header banner after header
add_action( 'genesis_after_header', 'homepage_slideshow' );
function homepage_slideshow() {
	
		if ( ! is_front_page() )
		return;
	
	genesis_widget_area( 'homepage-slideshow', array(
		'before' => '<div class="homepage-slideshow" class="widget-area">',
		'after'  => '</div>',
	) );

}

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_after_header', 'genesis_do_subnav', 15 );


//* Hook welcome message widget area before content
add_action( 'genesis_before_loop', 'javala_welcome_message' );
function javala_welcome_message() {

	if ( ! is_front_page() || get_query_var( 'paged' ) >= 2 )
		return;

	genesis_widget_area( 'promotions', array(
		'before' => '<div class="promotions" class="widget-area">',
		'after'  => '</div>',
	) );

}

//* Create Specials custom post type
add_action( 'init', 'javala_specials_post_type' );
function javala_specials_post_type() {

	register_post_type( 'specials',
		array(
			'labels' => array(
				'name'          => __( 'Specials', 'javala' ),
				'singular_name' => __( 'Special', 'javala' ),
			),
			'has_archive'  => true,
			'hierarchical' => false,
			'menu_icon'   => 'dashicons-tag',
			'public'       => true,
			'rewrite'      => array( 'slug' => 'specials', 'with_front' => false ),
			'supports'     => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-seo', 'genesis-cpt-archives-settings' ),
			'taxonomies'   => array( 'specials-type' ),

		)
	);
	
}

//* Add Specials Type Taxonomy to columns
add_filter( 'manage_taxonomies_for_specials_columns', 'javala_specials_columns' );
function javala_specials_columns( $taxonomies ) {

    $taxonomies[] = 'specials-type';
    return $taxonomies;

}

//* Change the number of specials items to be displayed (props Bill Erickson)
add_action( 'pre_get_posts', 'javala_specials_items' );
function javala_specials_items( $query ) {

	if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'specials' ) ) {
		$query->set( 'posts_per_page', '12' );
	}

}

//* Customize Specials post info and post meta
add_filter( 'genesis_post_info', 'javala_specials_post_info_meta' );
add_filter( 'genesis_post_meta', 'javala_specials_post_info_meta' );
function javala_specials_post_info_meta( $output ) {

     if( 'specials' == get_post_type() )
        return '';

    return $output;

}

//* Remove featured image support from Specials custom post type
function remove_featured_image_specials() {
	remove_theme_support( 'post-thumbnails', array( 'specials' ) );
}
add_action( 'admin_menu', 'remove_featured_image_specials' );

//* Modify the WordPress read more link
add_filter( 'the_content_more_link', 'javala_read_more' );
function javala_read_more() {
	return '<a class="more-link" href="' . get_permalink() . '">' . __( 'Continue Reading', 'javala' ) . '</a>';
}

//* Modify the content limit read more link
add_action( 'genesis_before_loop', 'javala_more' );
function javala_more() {
	add_filter( 'get_the_content_more_link', 'javala_read_more' );
}

add_action( 'genesis_after_loop', 'javala_remove_more' );
function javala_remove_more() {
	remove_filter( 'get_the_content_more_link', 'javala_read_more' );
}

//* Remove entry meta in entry footer
add_action( 'genesis_before_entry', 'javala_remove_entry_meta' );
function javala_remove_entry_meta() {
	
//* Remove if not single post
	if ( ! is_single() ) {
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
	}

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'javala_author_box_gravatar' );
function javala_author_box_gravatar( $size ) {
	return 180;
}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'javala_comments_gravatar' );
function javala_comments_gravatar( $args ) {
	$args['avatar_size'] = 100;
	return $args;
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'javala_remove_comment_form_allowed_tags' );
function javala_remove_comment_form_allowed_tags( $defaults ) {
	$defaults['comment_notes_after'] = '';
	return $defaults;
}

//* Add new image size
add_image_size( 'promotion', 382, 282, TRUE );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'homepage-slideshow',
	'name'        => __( 'Homepage Slideshow', 'javala' ),
	'description' => __( 'This is the main homepage slideshow area.', 'javala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'promotions',
	'name'        => __( 'Promotions', 'javala' ),
	'description' => __( 'This is the promotions widget area.', 'javala' ),
) );

remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'dbk_footer' );
function dbk_footer() {
    ?>
    <p><a href="http://cmsthemefactory.com">WordPress Coffee Shop Theme - &copy; 2016 by CMS Themefactory</a>. All Rights Reserved.</p>
    <?php
}

add_theme_support( 'genesis-connect-woocommerce' );

add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_reviews_tab', 98);
function sb_woo_remove_reviews_tab($tabs) {
 unset($tabs['reviews']);
 return $tabs;
}