<?php
/**
 * This file adds the Landing template to the Javala Theme.
 *
 * @author Pixelcurb
 * @package Javala
 * @subpackage Customizations
*/

//* Add landing body class to the head
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

//* Run the Genesis loop
genesis();
