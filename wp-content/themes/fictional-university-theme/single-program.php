<?php
get_header();

while(have_posts()):
    the_post();
    $dateToday = date('Ymd');
    $homepageEvents = new WP_Query([
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'meta_query' => [
            [
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $dateToday,
                'type' => 'numeric',
            ],
            [
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"',
            ],
        ],
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'posts_per_page' => 2,
    ]);
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?= get_theme_file_uri('images/ocean.jpg') ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title">
                <?= get_the_title() ?>
            </h1>
            <div class="page-banner__intro">
                <p>
                    DONT FORGET
                </p>
            </div>
        </div>
    </div>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('program') ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    All Programs
                </a>
                <span class="metabox__main">
                    <?= get_the_title(); ?>
                </span>
            </p>
        </div>

        <div class="generic-content">
            <?php
            the_content();
            ?>
        </div>

        <?php
        if ($homepageEvents->have_posts()):
            ?>

            <hr class="section-break">

            <h2 class="headline headline--medium">
                Upcoming <?= get_the_title() ?> Events
            </h2>
            <?php
            while ($homepageEvents->have_posts()):
                $homepageEvents->the_post();
                $trimmedContent = wp_trim_words(
                    get_the_content(),
                    18
                );

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
                            <?= has_excerpt() ? get_the_excerpt() : $trimmedContent ?>
                            <a href="<?= get_the_permalink(); ?>" class="nu gray">
                                Learn more
                            </a>
                        </p>
                    </div>
                </div>

            <?php
            endwhile;;
            wp_reset_postdata();
        endif;
        ?>

    </div>

<?php
endwhile;

get_footer();
