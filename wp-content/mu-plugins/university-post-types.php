<?php
function university_post_types() {
	register_post_type('event', [
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
            'title', 'editor',
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
}

add_action('init', 'university_post_types');
