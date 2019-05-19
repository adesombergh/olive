<?php
function register_artist_custom_fields() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = 'artist_';

    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
        'id'            => 'artist_configurator',
        'title'         => __( 'Olive Noire Artist Configurator', 'cmb2' ),
        'object_types'  => array( 'artist' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );


    $cmb->add_field( array(
        'name'       => __( 'Email', 'cmb2' ),
        'desc'       => __( 'Adresse mail de l\'artiste', 'cmb2' ),
        'id'         => $prefix . 'email',
        'type'       => 'text_email',
        'attributes' => array(
            'required' => 'required',
            'data-validation' => 'required',
        ),
    ) );

    $cmb->add_field( array(
        'name'       => __( 'Contenu Principal', 'cmb2' ),
        'id'         => $prefix . 'zone1',
        'type'       => 'wysiwyg',
    ) );

    $cmb->add_field( array(
        'name'       => __( 'Contenu Secondaire', 'cmb2' ),
        'id'         => $prefix . 'zone2',
        'type'       => 'wysiwyg',
    ) );


    $socials = $cmb->add_field( array(
        'id'   => $prefix . 'socials',
        'name'       => __( 'Réseaux Sociaux', 'cmb2' ),
        'type'        => 'group',
        'repeatable'  => true,
        'options'     => array(
            'group_title'   => __( 'Liens vers un réseau social', 'cmb2' ),
            'add_button'    => __( 'Ajouter Réseau', 'cmb2' ),
            'remove_button' => __( 'Supprimer Réseau', 'cmb2' ),
            'sortable'      => true, // beta
        ),
    ) );

    // Id's for group's fields only need to be unique for the group. Prefix is not needed.
    $cmb->add_group_field( $socials, array(
        'name' => 'Titre du lien',
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



    $shows = $cmb->add_field( array(
        'id'   => $prefix . 'shows',
        'type'        => 'group',
        'name'       => __( 'Concerts', 'cmb2' ),
        'repeatable'  => true,
        'options'     => array(
            'group_title'   => __( 'Concert', 'cmb2' ),
            'add_button'    => __( 'Ajouter Concert', 'cmb2' ),
            'remove_button' => __( 'Supprimer Concert', 'cmb2' ),
            'sortable'      => true, // beta
        ),
    ) );

    // Id's for group's fields only need to be unique for the group. Prefix is not needed.
    $cmb->add_group_field( $shows, array(
        'name' => 'Où?',
        'id'   =>  'where',
        'type' => 'text',
    ) );

    // URL text field
    $cmb->add_group_field( $shows, array(
        'name'          => 'Quand?',
        'id'            => 'when',
        'type'          => 'text_date',
        'date_format'   => 'd/m/Y'
    ) );

    $cmb->add_field( array(
        'name' => 'Extras',
        'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
        'id'   => $prefix . 'extras',
        'type' => 'oembed',
        'repeatable'  => true,
    ) );



}

add_action( 'cmb2_admin_init', 'register_artist_custom_fields' );
