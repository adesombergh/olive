<?php

/*
 * This file is part of OlivePress.
 *
 * (c) Aldebaran Desombergh <aldebaran.desombergh@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * Plugin Name: Olive
 * Description: A theme support plugin for OlivePress.
 * Author: Aldebaran Desombergh
 * Author URI: https://desombergh.be
 * Version: 1
 * Plugin URI: https://desombergh.be
 */

declare (strict_types = 1);

add_action('after_setup_theme', function () {
    // Bootstraping
    require_once (__DIR__ . '/src/custom-post-types.php');
    require_once (__DIR__ . '/src/custom-fields-artist.php');
    require_once (__DIR__ . '/src/custom-fields-news.php');
    require_once (__DIR__ . '/src/custom-fields-release.php');
    require_once (__DIR__ . '/src/custom-fields-user.php');
}, 100);



/**
 * Role and Capabilities Management
 */
function cloneRole()
{
    //Removing unnecessary default roles
    $undo_roles = array(
        'author',
        'contributor',
        'subscriber',
        'editor'
    );
    foreach ($undo_roles as $role_to_undo) {
        if (null!==get_role($role_to_undo)){
            remove_role($role_to_undo);
        }
    }

    //Adding a 'artiste' role with all editor caps
    if (null===get_role('artiste')) {
        add_role(
            'artiste',
            'Artiste',
            array(
                'delete_others_pages' => true, 'delete_others_posts' => true, 'delete_pages' => true, 'delete_posts' => true, 'delete_private_pages' => true, 'delete_private_posts' => true, 'delete_published_pages' => true, 'delete_published_posts' => true, 'edit_others_pages' => true, 'edit_others_posts' => true, 'edit_pages' => true, 'edit_posts' => true, 'edit_private_pages' => true, 'edit_private_posts' => true, 'edit_published_pages' => true, 'edit_published_posts' => true, 'manage_categories' => true, 'manage_links' => true, 'moderate_comments' => true, 'publish_pages' => true, 'publish_posts' => true, 'read' => true, 'read_private_pages' => true, 'read_private_posts' => true, 'unfiltered_html' => true, 'upload_files' => true
            )
        );
    }

}
add_action('init', 'cloneRole');



/**
 * Remove Default Post Editor
 */
function init_remove_support()
{
    remove_post_type_support('artist', 'editor');
    remove_post_type_support('news', 'editor');
    remove_post_type_support('release', 'editor');
}
add_action('init', 'init_remove_support', 100);







/**
 * Removes the 'At a Glance' useless widget
 */
function remove_dashboard_meta()
{
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
}
add_action('admin_init', 'remove_dashboard_meta');


/**
 * Remove Unused / Restricted Admin Page Links
 */
function custom_menu_page_removing()
{
    remove_menu_page('edit.php?post_type=page');
    remove_menu_page('edit.php');
    remove_menu_page('tools.php');
    remove_menu_page('themes.php');
    remove_menu_page('options-general.php');
    global $user_ID;
    if (current_user_can('artiste')) {
        remove_menu_page('edit.php?post_type=news');
        remove_menu_page('edit.php?post_type=release');
        remove_menu_page('post-new.php?post_type=artist');
        remove_menu_page('profile.php');
    }
}
add_action('admin_menu', 'custom_menu_page_removing');



/**
 * Deny access to restricted pages
 */
function restrict_admin_with_redirect() {
	$restrictions = array(
		'edit.php?post_type=release',
		'edit.php?post_type=page',
        'edit.php?post_type=news',
        'tools.php',
        'profile.php'
	);
	foreach ( $restrictions as $restriction ) {
		if ( current_user_can( 'artiste' ) && last(explode('/',$_SERVER['REQUEST_URI'])) == $restriction ) {
			wp_redirect( admin_url() );
			exit;
		}
	}
}
add_action( 'admin_init', 'restrict_admin_with_redirect' );



/**
 * Filters Artist pages shown in list to those the user may edit
 */
function posts_for_current_author($query) {
    global $pagenow;
    if( 'edit.php' != $pagenow || !$query->is_admin )
        return $query;

    if( $query->query['post_type'] == 'artist' && !current_user_can( 'administrator' ) ) {
        global $user_ID;

        $query->set('post__in',get_user_meta($user_ID,'user_artist_access',1));
    }
    return $query;
}
add_filter('pre_get_posts', 'posts_for_current_author');



/**
 * Remove Image Metabox
 */
function remove_image_box() {
	remove_meta_box( 'postimagediv',array('artist','release','news'),'side' );
}
add_action('do_meta_boxes', 'remove_image_box');

/**
 * Remove Admin From Users List
 */
add_action('pre_user_query','yoursite_pre_user_query');
function yoursite_pre_user_query($user_search) {
    global $wpdb;
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'admin'",$user_search->query_where);
}
