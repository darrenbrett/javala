<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'beautiful', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'beautiful' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Javala', 'beautiful' ) );
define( 'CHILD_THEME_URL', 'http://pixelcurb/themes/javala' );
define( 'CHILD_THEME_VERSION', '1.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'beautiful_enqueue_scripts_styles' );
function beautiful_enqueue_scripts_styles() {

	wp_enqueue_script( 'beautiful-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700|Raleway:400,500', array(), CHILD_THEME_VERSION );

}

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'default-text-color'     => '000000',
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
add_filter( 'body_class', 'beautiful_custom_body_class' );
function beautiful_custom_body_class( $classes ) {

	$classes[] = 'beautiful';
	return $classes;

}

//* Hook before header widget area above header
add_action( 'genesis_before_header', 'beautiful_before_header' );
function beautiful_before_header() {

	genesis_widget_area( 'before-header', array(
		'before' => '<div class="before-header" class="widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

//* Hook site header banner after header
add_action( 'genesis_after_header', 'beautiful_site_header_banner' );
function beautiful_site_header_banner() {

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
add_action( 'genesis_before_loop', 'beautiful_welcome_message' );
function beautiful_welcome_message() {

	if ( ! is_front_page() || get_query_var( 'paged' ) >= 2 )
		return;

	genesis_widget_area( 'promotions', array(
		'before' => '<div class="promotions" class="widget-area">',
		'after'  => '</div>',
	) );

}

//* Modify the WordPress read more link
add_filter( 'the_content_more_link', 'beautiful_read_more' );
function beautiful_read_more() {

	return '<a class="more-link" href="' . get_permalink() . '">' . __( 'Continue Reading', 'beautiful' ) . '</a>';

}

//* Modify the content limit read more link
add_action( 'genesis_before_loop', 'beautiful_more' );
function beautiful_more() {

	add_filter( 'get_the_content_more_link', 'beautiful_read_more' );

}

add_action( 'genesis_after_loop', 'beautiful_remove_more' );
function beautiful_remove_more() {

	remove_filter( 'get_the_content_more_link', 'beautiful_read_more' );

}

//* Remove entry meta in entry footer
add_action( 'genesis_before_entry', 'beautiful_remove_entry_meta' );
function beautiful_remove_entry_meta() {

	//* Remove if not single post
	if ( ! is_single() ) {
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
	}

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'beautiful_author_box_gravatar' );
function beautiful_author_box_gravatar( $size ) {

	return 180;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'beautiful_comments_gravatar' );
function beautiful_comments_gravatar( $args ) {
	$args['avatar_size'] = 100;
	return $args;
}

//* Hook split sidebar and bottom sidebar widget areas below primary sidebar
add_action( 'genesis_after_sidebar_widget_area', 'beautiful_extra_sidebars' );
function beautiful_extra_sidebars() {

	if ( is_active_sidebar( 'split-sidebar-left' ) || is_active_sidebar( 'split-sidebar-right' ) ) {

		echo '<div class="split-sidebars">';

			genesis_widget_area( 'split-sidebar-left', array(
				'before' => '<div class="split-sidebar-left" class="widget-area">',
				'after'  => '</div>',
			) );
			genesis_widget_area( 'split-sidebar-right', array(
				'before' => '<div class="split-sidebar-right" class="widget-area">',
				'after'  => '</div>',
			) );

		echo '</div>';

	}

	genesis_widget_area( 'bottom-sidebar', array(
		'before' => '<div class="bottom-sidebar" class="widget-area">',
		'after'  => '</div>',
	) );

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'beautiful_remove_comment_form_allowed_tags' );
function beautiful_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add new image size
add_image_size( 'promotion', 382, 282, TRUE );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'before-header',
	'name'        => __( 'Before Header', 'beautiful' ),
	'description' => __( 'This is the before header widget area.', 'beautiful' ),
) );
genesis_register_sidebar( array(
	'id'          => 'homepage-slideshow',
	'name'        => __( 'Homepage Slideshow', 'beautiful' ),
	'description' => __( 'This is the welmain homepage slideshow area.', 'beautiful' ),
) );
genesis_register_sidebar( array(
	'id'          => 'promotions',
	'name'        => __( 'Promotions', 'beautiful' ),
	'description' => __( 'This is the promotions widget area.', 'beautiful' ),
) );
genesis_register_sidebar( array(
	'id'          => 'split-sidebar-left',
	'name'        => __( 'Split Sidebar Left', 'beautiful' ),
	'description' => __( 'This is the left split sidebar widget area.', 'beautiful' ),
) );
genesis_register_sidebar( array(
	'id'          => 'split-sidebar-right',
	'name'        => __( 'Split Sidebar Right', 'beautiful' ),
	'description' => __( 'This is the right split sidebar widget area.', 'beautiful' ),
) );
genesis_register_sidebar( array(
	'id'          => 'bottom-sidebar',
	'name'        => __( 'Bottom Sidebar', 'beautiful' ),
	'description' => __( 'This is the bottom sidebar widget area.', 'beautiful' ),
) );

add_theme_support( 'genesis-connect-woocommerce' );

add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_reviews_tab', 98);
function sb_woo_remove_reviews_tab($tabs) {

 unset($tabs['reviews']);

 return $tabs;
}

remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'wpvkp_footer' );
function wpvkp_footer() {
    ?>
    <p><a href="http://cmsthemefactory.com">WordPress Coffee Shop Theme - &copy; 2016 by CMS Themefactory</a>. All Rights Reserved.</p>
    <?php
}
