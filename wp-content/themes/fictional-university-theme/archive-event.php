<?php
get_header();

pageBanner([
    'title' => 'All Events',
    'subtitle' => 'See what all the events are',
]);

?>

	<div class="container container--narrow page-section">
		<?php
		while(have_posts()):
			the_post();
            get_template_part('template-parts/content', 'event');
        endwhile;

		echo paginate_links();

		?>

        <hr class="section-break">
        
        <p>
            Looking for past events?
            <a href="<?= site_url('/past-events') ?>">
                Click here!
            </a>
        </p>
	</div>

<?php
get_footer();
