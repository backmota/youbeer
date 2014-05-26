<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
 */

/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign
$prefix = 'tf_';

global $meta_boxes;

$meta_boxes = array();


/* ----------------------------------------------------- */
// Showcase Metabox
/* ----------------------------------------------------- */
$meta_boxes[] = array(
	'id' => 'showcase_info',
	'title' => 'Showcase Information',
	'pages' => array( 'tf_showcase' ),
	'context' => 'normal',

	'fields' => array(
		
		array(
			'name'		=> 'Link Description',
			'desc'		=> 'Link Description (will be shown on showcase details page)',
			'id'		=> $prefix . 'scasedescription',
			'type'		=> 'textarea',
			'std'		=> "",
			'cols'		=> "40",
			'rows'		=> "1"
		),
	
		// TEXT
		array(
			'name'		=> 'Showcase link',
			'id'		=> $prefix . 'sclink',
			'desc'		=> 'URL to website if available (Do not forget the http://)',
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> ''
		),
	)
);

/* ----------------------------------------------------- */
// Showcase Gallery Metabox
/* ----------------------------------------------------- */
$meta_boxes[] = array(
	'id'		=> 'showcase_images',
	'title'		=> 'Showcase Images',
	'pages' => array( 'tf_showcase' ),
	'context' => 'normal',

	'fields'	=> array(
		array(
			'name'	=> 'Showcase Images',
			'desc'	=> 'Upload up to 20 images and they will be shown in a slideshow. Alternative one image is also ok',
			'id'	=> $prefix . 'scasescreenshot',
			'type'	=> 'plupload_image',
			'max_file_uploads' => 20,
		)
		
	)
);

/* ----------------------------------------------------- */
// Showcase Video Metabox
/* ----------------------------------------------------- */
$meta_boxes[] = array(
	'id'		=> 'showcase_video',
	'title'		=> 'Showcase Video',
	'pages' 	=> array( 'tf_showcase' ),
	'context' => 'normal',

	'fields'	=> array(
		array(
			'name'		=> 'Video Source',
			'id'		=> $prefix . 'source',
			'type'		=> 'select',
			'options'	=> array(
				'youtube'		=> 'Youtube',
				'vimeo'			=> 'Vimeo'
			),
			'multiple'	=> false,
			'std'		=> array( 'no' )
		),
		array(
			'name'	=> 'Video URL or Self Hosted Embed Code',
			'id'	=> $prefix . 'embed',
			'desc'	=> 'Copy the ID of the video (E.g. http://www.youtube.com/watch?v=<strong>Sv6dMFF_yts</strong>) you want to show.',
			'type' 	=> 'textarea',
			'std' 	=> "",
			'cols' 	=> "40",
			'rows' 	=> "8"
		)
	)
);

/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function tf_register_meta_boxes()
{
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'tf_register_meta_boxes' );