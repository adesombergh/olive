<?php
add_action('init', function() {

	register_extended_post_type('release',
        [
            'menu_icon' => 'dashicons-album',

            # Add the post type to the site's main RSS feed:
            'show_in_feed' => true,
            'quick_edit' => false,
            # Show all posts on the post type archive:
            'archive' => [
                'nopaging' => true,
            ],

            // # Add some custom columns to the admin screen:
            'admin_cols' => [
            	'release_index' => [
                    'title'          => 'Index',
                    'meta_key'       => 'release_index',
                ],
                'release_date' => [
                    'title'          => 'Sortie',
                    'meta_key'       => 'release_date',
                ],
                'release_formats' => [
                    'title'          => 'Formats',
                    'meta_key'       => 'release_formats',
            	],
            ],

        ], [

		# Override the base names used for labels:
		'singular'  => 'Release',
		'plural'    => 'Releases',
        'slug'      => 'release',

        ]
    );

	register_extended_post_type('artist',
        [
            'menu_icon' => 'dashicons-art',

            # Add the post type to the site's main RSS feed:
            'show_in_feed' => true,
            'quick_edit' => false,

            # Show all posts on the post type archive:
            'archive' => [
                'nopaging' => true,
            ],

            // # Add some custom columns to the admin screen:
            'admin_cols' => [
            	'artist_email' => [
            		'title'       => 'Email',
            		'meta_key'    => 'artist_email'
            	],
            ],


        ], [

		# Override the base names used for labels:
		'singular'  => 'Artist',
		'plural'    => 'Artists',
        'slug'      => 'artist',

        ]
    );


	register_extended_post_type('news',
        [
            'menu_icon' => 'dashicons-megaphone',

            # Add the post type to the site's main RSS feed:
            'show_in_feed' => true,
            'quick_edit' => false,

            # Show all posts on the post type archive:
            'archive' => [
                'nopaging' => true,
            ],

            // # Add some custom columns to the admin screen:
            'admin_cols' => [
            	'news_subtitle' => [
            		'title'       => 'Sous-Titre',
            		'meta_key'    => 'news_subtitle'
                ],
                'news_link' => [
            		'title'       => 'Link',
            		'meta_key'    => 'news_link_url'
                ],
                'last_modified' => array(
                    'title'      => 'Publié le',
                    'post_field' => 'post_date',
                ),
            ],
        ], [

		# Override the base names used for labels:
		'singular'  => 'News',
		'plural'    => 'News',
        'slug'      => 'news',

        ]
    );


});
