<?php

add_action('rest_api_init', 'university_like_routes');

function university_like_routes() {
    register_rest_route('university/v1', 'manageLike', [
        'methods' => 'POST',
        'callback' => 'createLike',
    ]);

    register_rest_route('university/v1', 'manageLike', [
        'methods' => 'DELETE',
        'callback' => 'deleteLike',
    ]);
}

function createLike($data) {
    if (!is_user_logged_in()) {
        exit('not logged in');
    }

    $professorId = sanitize_text_field($data['professorId']);

    $existsQuery = new WP_Query([
        'author' => get_current_user_id(),
        'post_type' => 'like',
        'meta_query' => [
            [
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => $professorId,
            ],
        ],
    ]);

    if ($existsQuery->found_posts > 0 || get_post_type($professorId) !== 'professor') {
        exit('invalid professor id');
    }

    return wp_insert_post([
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title' => 'create post test 2',
        'meta_input' => [
            'liked_professor_id' => $professorId,
        ],
    ]);
}

function deleteLike($data) {
    $likeId = sanitize_text_field($data['like']);

    if (get_current_user_id() === (int) get_post_field('post_author', $likeId)) {
        wp_delete_post($likeId, true);
        return 'completed';
    }

    exit('no permissions');
}
