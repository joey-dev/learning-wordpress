<?php
get_header();

pageBanner([
    'title' => ' Search results',
    'subtitle' => 'you searched for &ldquo;' . get_search_query() . '&rdquo;.',
]);
?>

    <div class="container container--narrow page-section">
        <?php
        get_search_form();
        if (have_posts()) {
            while(have_posts()) {
                the_post();

                get_template_part('template-parts/content', get_post_type());

            }
        } else {
            ?>
            <h2 class="headline headline--small-plus">
                No results found.
            </h2>
            <?php
        }
        echo paginate_links();

        ?>
    </div>

<?php
get_footer();
