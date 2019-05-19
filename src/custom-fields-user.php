<?php

function yourprefix_register_user_profile_metabox()
{
    $prefix = 'user_';
    /**
     * Metabox for the user profile screen
     */
    $cmb = new_cmb2_box(array(
        'id' => $prefix . 'configurator',
        'title' => __('User Profile Metabox', 'cmb2'), // Doesn't output for user boxes
        'object_types' => array('user'), // Tells CMB2 to use user_meta vs post_meta
        'show_names' => true,
        'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
    ));

    $cmb->add_field( array(
        'name'          => 'Accès à quelles pages d\'artiste?',
        'id'            => $prefix . 'artist_access',
        'type'          => 'custom_attached_posts',
        'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
		'options' => array(
			'show_thumbnails' => false, // Show thumbnails on the left
			'filter_boxes'    => false, // Show a text box for filtering the results
			'query_args'      => array(
				'posts_per_page' => 3,
				'post_type'      => 'artist',
			), // override the get_posts args
        ),
    ));

}
add_action('cmb2_admin_init', 'yourprefix_register_user_profile_metabox');
