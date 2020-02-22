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

    $professors = new WP_Query([
        'post_type' => 'professor',
        'meta_query' => [
            [
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"',
            ],
        ],
        'orderby' => 'title',
        'order' => 'ASC',
        'posts_per_page' => -1,
    ]);
    pageBanner();
    ?>

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
            the_field('main_body_content');
            ?>
        </div>

        <?php
        if ($professors->have_posts()):
            ?>

            <hr class="section-break">

            <h2 class="headline headline--medium">
                <?= get_the_title() ?> Professors
            </h2>
            <ul class="professor-cards">
                <?php
                while ($professors->have_posts()):
                    $professors->the_post();
                    ?>
                    <li class="professor-card__list-item">
                        <a class="professor-card" href="<?= get_the_permalink() ?>">
                            <img src="<?php the_post_thumbnail_url('professorLandscape') ?>" class="professor-card__image">
                            <span class="professor-card__name">
                                <?= get_the_title() ?>
                            </span>
                        </a>
                    </li>

                    <?php
                endwhile;;
                wp_reset_postdata();
            ?>
            </ul>
            <?php
        endif;

        if ($homepageEvents->have_posts()):
            ?>

            <hr class="section-break">

            <h2 class="headline headline--medium">
                Upcoming <?= get_the_title() ?> Events
            </h2>
            <?php
            while ($homepageEvents->have_posts()):
                $homepageEvents->the_post();
                get_template_part('template-parts/content', 'event');
            endwhile;;
            wp_reset_postdata();
        endif;
        ?>

    </div>

<?php
endwhile;

get_footer();
