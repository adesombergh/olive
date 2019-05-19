<?php
function register_release_custom_fields() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = 'release_';

    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
        'id'            => 'release_configurator',
        'title'         => __( 'Olive Noire Release Configurator', 'cmb2' ),
        'object_types'  => array( 'release' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );


	$cmb->add_field( array(
		'name'    => __( 'Artistes', 'yourtextdomain' ),
		'id'      => $prefix. 'artists',
		'type'    => 'custom_attached_posts',
		'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
		'options' => array(
			'show_thumbnails' => false, // Show thumbnails on the left
			'filter_boxes'    => false, // Show a text box for filtering the results
			'query_args'      => array(
				'posts_per_page' => 3,
				'post_type'      => 'artist',
			), // override the get_posts args
        ),
        'attributes'  => array(
            'required'    => 'required',
            'data-validation' => 'required',
        ),
    ) );

    $cmb->add_field( array(
        'name'    => 'Pochette',
		'id'      => $prefix. 'pochette',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => false, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Ajouter Pochette' // Change upload button text. Default: "Add or Upload File"
        ),
        // query_args are passed to wp.media's library query.
        'query_args' => array(
            'type' => array(
            	'image/gif',
            	'image/jpeg',
            	'image/png',
            ),
        ),
        'preview_size' => 'small', // Image size to use when previewing in the admin.
        'column' => array(
            'position' => 1,
            'name'     => 'Pochette',
        ),
        'attributes'  => array(
            'required'    => 'required',
            'data-validation' => 'required',
        ),

    ) );

    $cmb->add_field( array(
        'name'    => 'Index',
		'id'      => $prefix. 'index',
        'type'    => 'text',
    ));
    $cmb->add_field( array(
        'name'    => 'Date',
		'id'      => $prefix. 'date',
        'type'    => 'text_date',
        'date_format'   => 'd/m/Y',
    ));
    $cmb->add_field( array(
        'name'    => 'Formats',
		'id'      => $prefix. 'formats',
        'type'    => 'text',

    ));
    $cmb->add_field( array(
        'name'    => 'Texte',
		'id'      => $prefix. 'texte',
        'type'    => 'textarea',
    ));
    $cmb->add_field( array(
        'name'          => 'Tracks',
		'id'            => $prefix. 'tracks',
        'type'          => 'text',
        'repeatable'    => true
    ));



    $socials = $cmb->add_field( array(
        'id'   => $prefix . 'purchase',
        'name' => __( 'Purchase Links', 'cmb2' ),
        'type'        => 'group',
        'repeatable'  => true,
        'options'     => array(
            'group_title'   => __( 'Purchase Links', 'cmb2' ),
            'add_button'    => __( 'Add link', 'cmb2' ),
            'remove_button' => __( 'Remove link', 'cmb2' ),
            'sortable'      => true, // beta
        ),
    ) );

    // Id's for group's fields only need to be unique for the group. Prefix is not needed.
    $cmb->add_group_field( $socials, array(
        'name' => 'Titre',
        'id'   =>  'title',
        'type' => 'text',
    ) );

    // URL text field
    $cmb->add_group_field( $socials, array(
        'name' => __( 'Lien vers', 'cmb2' ),
        'id'   => 'url',
        'type' => 'text_url',
        'protocols' => array('http', 'https'), // Array of allowed protocols
    ) );

    $cmb->add_field( array(
        'name' => 'Extras',
        'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
        'id'   => $prefix . 'extras',
        'type' => 'oembed',
        'repeatable'  => true,
    ) );

}

add_action( 'cmb2_admin_init', 'register_release_custom_fields' );
