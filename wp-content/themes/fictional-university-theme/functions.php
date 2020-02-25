<?php
require get_theme_file_path('inc/search-route.php');

function university_custom_rest() {
    register_rest_field('post', 'author_name', [
        'get_callback' => function() {
            return get_the_author();
        }
    ]);
}

add_action('rest_api_init', 'university_custom_rest');

function pageBanner($inputArguments = []) {
    $pageBannerImage = get_field('page_banner_background_image');

    $arguments['title'] = get_the_title();
    $arguments['subtitle'] = get_field('page_banner_subtitle');;
    $arguments['photo'] = $pageBannerImage ?
        $pageBannerImage['sizes']['pageBanner'] :
        get_theme_file_uri('/images/ocean.jpg');

    $outputArguments = array_merge($arguments, $inputArguments);
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image"
             style="background-image: url(<?= $outputArguments['photo'] ?>);"
        ></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title">
                <?= $outputArguments['title'] ?>
            </h1>
            <div class="page-banner__intro">
                <p>
                    <?= $outputArguments['subtitle'] ?>
                </p>
            </div>
        </div>
    </div>
    <?php
}

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

    wp_localize_script('main-university-js', 'universityData', [
        'root_url' => get_site_url(),
    ]);
}

add_action('wp_enqueue_scripts', 'university_files');

function university_features() {
//	register_nav_menu('headerMenuLocation', 'Header Menu Location');
//	register_nav_menu('footerLocation1', 'Footer Location 1');
//	register_nav_menu('footerLocation2', 'Footer Location 2');

	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_image_size('professorLandscape', 400, 260, true);
	add_image_size('professorPortrait', 480, 650, true);
	add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');

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

add_action('admin_init', 'redirect_subs_to_frontend');

function redirect_subs_to_frontend() {
    $user = wp_get_current_user();

    if (count($user->roles) === 1 && $user->roles[0] === 'subscriber') {
        wp_redirect(site_url('/'));
        exit();
    }
}

add_action('wp_loaded', 'no_subs_admin_bar');

function no_subs_admin_bar() {
    $user = wp_get_current_user();

    if (count($user->roles) === 1 && $user->roles[0] === 'subscriber') {
        show_admin_bar(false);
    }
}

add_filter('login_headerurl', 'our_header_url');

function our_header_url() {
    return site_url('/');
}

add_action('login_enqueue_scripts', 'login_scc');

function login_scc() {
    wp_enqueue_style(
        'university_main_styles',
        get_stylesheet_uri()
    );

    wp_enqueue_style(
        'font-google',
        'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i'
    );
}

add_filter('login_headertitle', 'login_title');

function login_title() {
    return get_bloginfo('name');
}