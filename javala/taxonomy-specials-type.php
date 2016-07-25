<?php
/**
 * This file adds the Specials type taxonomy archive template to the Javala theme.
 *
 * @author Darren King
 * @package Javala
 * @subpackage Customizations
 */

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 5 );

//* Remove the post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

//* Remove the post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

//* Add specials body class to the head
add_filter( 'body_class', 'javala_add_specials_body_class' );
function javala_add_specials_body_class( $classes ) {

   $classes[] = 'javala-specials';
   return $classes;
   
}

//* Remove the post meta function
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

genesis();
