<?php
get_header();

pageBanner([
    'title' => 'Past Events',
    'subtitle' => 'See what all the past events are',
]);
?>

	<div class="container container--narrow page-section">
		<?php
        $dateToday = date('Ymd');
        $pastEvents = new WP_Query([
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'meta_query' => [
                [
                    'key' => 'event_date',
                    'compare' => '<',
                    'value' => $dateToday,
                    'type' => 'numeric',
                ],
            ],
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'paged' => get_query_var('paged', 1),
        ]);

		while($pastEvents->have_posts()):
            $pastEvents->the_post();
            get_template_part('template-parts/content', 'event');
        endwhile;

		echo paginate_links([
            'total' => $pastEvents->max_num_pages
        ]);

		?>
	</div>

<?php
get_footer();
