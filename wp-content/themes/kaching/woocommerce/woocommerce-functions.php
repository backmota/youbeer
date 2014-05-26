<?php

// Layout meta box
function woo_metaboxes_add( $woo_metaboxes ) {

	global $post;

	// Check for post type = post
	if ( get_post_type() == "product" ) {

		$url = get_template_directory_uri() . '/functions/images/';

		$woo_metaboxes[] = array ( "name" => "_layout",
			"std" => "normal",
			"label" => "Layout",
			"type" => "images",
			"desc" => "Select the layout you want on this specific post/page.",
			"options" => array(
				'layout-default' => $url . 'layout-off.png',
				'layout-full' => get_template_directory_uri() . '/functions/images/' . '1c.png',
				'layout-left-content' => get_template_directory_uri() . '/functions/images/' . '2cl.png',
				'layout-right-content' => get_template_directory_uri() . '/functions/images/' . '2cr.png' ) );

	}

	return $woo_metaboxes;

}