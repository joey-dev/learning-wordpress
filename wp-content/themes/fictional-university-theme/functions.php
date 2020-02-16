<?php

function university_files() {
	wp_enqueue_script(
		'main-university-js',
		get_theme_file_uri('/js/scripts-bundled.js'),
		NULL,
		microtime(),
		true
	);

	wp_enqueue_style(
		'font-google',
		'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i'
	);
	wp_enqueue_style(
		'font-awesome',
		'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
	);
	wp_enqueue_style(
		'university_main_styles',
		get_stylesheet_uri(),
		NULL,
		microtime()
	);
}

add_action('wp_enqueue_scripts', 'university_files');

function university_features() {
//	register_nav_menu('headerMenuLocation', 'Header Menu Location');
//	register_nav_menu('footerLocation1', 'Footer Location 1');
//	register_nav_menu('footerLocation2', 'Footer Location 2');

	add_theme_support('title-tag');
}

//add_action('after_setup_theme', 'university_features');

function university_adjust_queries(WP_Query $query) {
    if ($query->is_main_query()) {
        if (!is_admin()) {
            university_adjust_queries_not_admin($query);
        } else {
            university_adjust_queries_is_admin($query);
        }
    }
}

function university_adjust_queries_not_admin(WP_Query $query) {
    switch (post_type_archive_title('', false)) {
        case 'Events':
            university_adjust_queries_not_admin_event($query);
            break;
        case 'Programs':
            university_adjust_queries_not_admin_program($query);
            break;
    }
}

function university_adjust_queries_is_admin(WP_Query $query) {

}

function university_adjust_queries_not_admin_event(WP_Query $query) {
    $dateToday = date('Ymd');

    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', [
        [
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $dateToday,
            'type' => 'numeric',
        ],
    ]);
}

function university_adjust_queries_not_admin_program(WP_Query $query) {
    $dateToday = date('Ymd');

    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
}

add_action('pre_get_posts', 'university_adjust_queries');
