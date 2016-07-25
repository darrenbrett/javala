<?php

//* javala Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'javala_theme_defaults' );
function javala_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 4;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'prev-next';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

//* javala Theme Setup
add_action( 'after_switch_theme', 'javala_theme_setting_defaults' );
function javala_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 4,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'prev-next',
			'site_layout'               => 'content-sidebar',
		) );
		
	} else {
		
		_genesis_update_settings( array(
			'blog_cat_num'              => 4,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'prev-next',
			'site_layout'               => 'content-sidebar',
		) );
		
	}

	update_option( 'posts_per_page', 4 );

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'javala_social_default_styles' );
function javala_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#594642',
		'background_color_hover' => '#7e645f',
		'border_radius'          => 3,
		'icon_color'             => '#f1f1f1',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 36,
	);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}