<?php
function register_news_custom_fields() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = 'news_';

    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
        'id'            => 'news_configurator',
        'title'         => __( 'Olive Noire News Configurator', 'cmb2' ),
        'object_types'  => array( 'news' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );



    $cmb->add_field( array(
        'name'       => __( 'Subtitle', 'cmb2' ),
        'desc'       => __( 'Sous-Titre', 'cmb2' ),
        'id'         => $prefix . 'subtitle',
        'type'       => 'text',
    ) );

    $cmb->add_field( array(
        'name' => __( 'Lien vers', 'cmb2' ),
        'id'   => $prefix . 'link',
        'type' => 'link_picker',
        // 'repeatable' => true,
        'split_values' => true  // default is false
    ) );

    $cmb->add_field( array(
        'name' => 'Mettre à la une',
        'desc' => 'Faire de cette news la une',
        'id'   => $prefix . 'une',
        'type' => 'checkbox',
    ) );

    $cmb->add_field( array(
        'name'       => __( 'Image', 'cmb2' ),
        'desc'       => __( 'Choisir une image (de bonne qualité, please)', 'cmb2' ),
        'id'         => $prefix . 'caption',
        'type'       => 'file',
        'options' => array(
            'url' => false, // Hide the text input for the url
        ),
        'column' => array(
            'position' => 1,
            'name'     => 'Image',
        ),
        'preview_size' => 'small', // Image size to use when previewing in the admin.
    ) );




}

add_action( 'cmb2_admin_init', 'register_news_custom_fields' );
