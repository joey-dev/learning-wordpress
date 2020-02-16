<?php
get_header();

?>
	<div class="page-banner">
		<div class="page-banner__bg-image" style="background-image: url(<?= get_theme_file_uri('images/ocean.jpg') ?>);"></div>
		<div class="page-banner__content container container--narrow">
			<h1 class="page-banner__title">Past Events</h1>
			<div class="page-banner__intro">
				<p>See what all the past events are</p>
			</div>
		</div>
	</div>

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
			$eventDateTime = DateTime::createFromFormat('d/m/Y', get_field('event_date'));
			$eventDateMonth = $eventDateTime->format('M');
			$eventDateDay = $eventDateTime->format('d');
			?>

			<div class="event-summary">
				<a class="event-summary__date t-center" href="<?= get_the_permalink(); ?>">
					<span class="event-summary__month">
						<?= $eventDateMonth ?>
					</span>
					<span class="event-summary__day">
						<?= $eventDateDay ?>
					</span>
				</a>
				<div class="event-summary__content">
					<h5 class="event-summary__title headline headline--tiny">
						<a href="<?= get_the_permalink(); ?>">
							<?= get_the_title(); ?>
						</a>
					</h5>
					<p>
						<?= wp_trim_words(
							get_the_content(),
							25
						) ?>
						<a href="<?= get_the_permalink(); ?>" class="nu gray">
							Learn more
						</a>
					</p>
				</div>
			</div>

		<?php
		endwhile;

		echo paginate_links([
            'total' => $pastEvents->max_num_pages
        ]);

		?>
	</div>

<?php
get_footer();
