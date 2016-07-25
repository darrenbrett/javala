<?php
/**
 * This file adds the Landing template to the Javala Theme.
 *
 * @author Darren King
 * @package Javala
 * @subpackage Customizations
*/

/*
Template Name: Home
*/

//* Add landing body class to the head
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

//* Run the Genesis loop
genesis();
