<?php

/**
*	Usefull code for get posts
*
**/

$args = array(
  	'numberposts' => -1 		// Do not limit the number of posts
	,'post-type'  => 'mrc_organiser'
);
 
$latest_posts = get_posts( $args );
