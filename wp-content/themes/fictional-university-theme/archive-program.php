<?php
get_header();

pageBanner([
    'title' => 'All Programs',
    'subtitle' => 'See what all the programs are',
]);
?>

	<div class="container container--narrow page-section">
        <ul class="link-list min-list">
		<?php
            while(have_posts()):
                the_post();
                ?>

                <li>
                    <a href="<?php the_permalink(); ?>">
                        <?= get_the_title() ?>
                    </a>
                </li>

                <?php
            endwhile;

            echo paginate_links();

            ?>
        </ul>
	</div>

<?php
get_footer();
