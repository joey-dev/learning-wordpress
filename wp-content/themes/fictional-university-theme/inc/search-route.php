<?php
add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch() {
    register_rest_route('university/v1', 'search', [
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'universitySearchResults',
    ]);
}

function universitySearchResults($data) {
    $mainQuery = new WP_Query([
        'post_type' => [
            'post',
            'page',
            'professor',
            'event',
            'program',
        ],
        's' => sanitize_text_field($data['term']),
    ]);

    $results = [
        'generalInfo' => [],
        'professors' => [],
        'programs' => [],
        'events' => [],
        'campuses' => [],
    ];

    while($mainQuery->have_posts()) {
        $mainQuery->the_post();

        if (get_post_type() === 'post' || get_post_type() === 'page') {
            $results['generalInfo'][] = [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'postType' => get_post_type(),
                'author_name' => get_the_author(),
            ];
        }

        if (get_post_type() === 'professor') {
            $results['professors'][] = [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professorLandscape'),
            ];
        }

        if (get_post_type() === 'event') {
            $eventDateTime = DateTime::createFromFormat('d/m/Y', get_field('event_date'));
            $eventDateMonth = $eventDateTime->format('M');
            $eventDateDay = $eventDateTime->format('d');

            $trimmedContent = wp_trim_words(
                get_the_content(),
                18
            );

            $results['events'][] = [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'month' => $eventDateMonth,
                'day' => $eventDateDay,
                'description' => has_excerpt() ? get_the_excerpt() : $trimmedContent,
            ];
        }

        if (get_post_type() === 'program') {
            $results['programs'][] = [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'id' => get_the_ID(),
            ];
        }

        if (get_post_type() === 'campuses') {
            $results['campuses'][] = [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
            ];
        }
    }

    if ($results['programs']) {
        $programsMetaQuery = [
            'relation' => 'OR',
        ];

        foreach ($results['programs'] as $program) {
            $programsMetaQuery[] = [
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . $program['id'] . '"',
            ];
        }

        $programRelationshipQuery = new WP_Query([
            'post_type' => ['professor', 'event'],
            'meta_query' => $programsMetaQuery,
        ]);

        while ($programRelationshipQuery->have_posts()) {
            $programRelationshipQuery->the_post();

            if (get_post_type() === 'professor') {
                $results['professors'][] = [
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url(0, 'professorLandscape'),
                ];
            }

            if (get_post_type() === 'event') {
                $eventDateTime = DateTime::createFromFormat('d/m/Y', get_field('event_date'));
                $eventDateMonth = $eventDateTime->format('M');
                $eventDateDay = $eventDateTime->format('d');

                $trimmedContent = wp_trim_words(
                    get_the_content(),
                    18
                );

                $results['events'][] = [
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'month' => $eventDateMonth,
                    'day' => $eventDateDay,
                    'description' => has_excerpt() ? get_the_excerpt() : $trimmedContent,
                ];
            }
        }

        $results['professors'] = array_values(
            array_unique($results['professors'], SORT_REGULAR)
        );

        $results['events'] = array_values(
            array_unique($results['events'], SORT_REGULAR)
        );
    }

    return $results;
}
