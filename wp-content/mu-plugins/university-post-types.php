<?php
function university_post_types() {
	register_post_type('event', [
	    'capability_type' => 'event',
		'map_meta_cap' => true,
		'supports' => [
			'title', 'editor', 'excerpt',
		],
		'labels' => [
			'name' => 'Events',
			'add_new_item' => 'Add New Event',
			'edit_item' => 'Edit Event',
			'all_items' => 'All Events',
			'singular_name' => 'Event',
		],
		'rewrite' => [
			'slug' => 'events',
		],
		'menu_icon' => 'dashicons-calendar',
		'has_archive' => true,
		'public' => true,
	]);

    register_post_type('program', [
        'supports' => [
            'title',
        ],
        'labels' => [
            'name' => 'Programs',
            'add_new_item' => 'Add New Program',
            'edit_item' => 'Edit Program',
            'all_items' => 'All Programs',
            'singular_name' => 'Program',
        ],
        'rewrite' => [
            'slug' => 'programs',
        ],
        'menu_icon' => 'dashicons-awards',
        'has_archive' => true,
        'public' => true,
    ]);

    register_post_type('professor', [
        'show_in_rest' => true,
        'supports' => [
            'title', 'editor', 'thumbnail',
        ],
        'labels' => [
            'name' => 'professors',
            'add_new_item' => 'Add New professor',
            'edit_item' => 'Edit professor',
            'all_items' => 'All professors',
            'singular_name' => 'professor',
        ],
        'menu_icon' => 'dashicons-welcome-learn-more',
        'public' => true,
    ]);

    register_post_type('note', [
        'show_in_rest' => true,
        'supports' => [
            'title', 'editor',
        ],
        'labels' => [
            'name' => 'Notes',
            'add_new_item' => 'Add New Note',
            'edit_item' => 'Edit Note',
            'all_items' => 'All Notes',
            'singular_name' => 'Note',
        ],
        'menu_icon' => 'dashicons-welcome-write-blog',
        'public' => false,
        'show_ui' => true,
        'capability_type' => 'note',
        'map_meta_cap' => true,
    ]);

    register_post_type('like', [
        'supports' => [
            'title',
        ],
        'labels' => [
            'name' => 'Likes',
            'add_new_item' => 'Add New Like',
            'edit_item' => 'Edit Like',
            'all_items' => 'All Likes',
            'singular_name' => 'Like',
        ],
        'menu_icon' => 'dashicons-heart',
        'public' => false,
        'show_ui' => true,
    ]);
}

add_action('init', 'university_post_types');
