<?php
get_header();

while (have_posts()):
    the_post();
    $relatedPrograms = get_field('related_programs');

    pageBanner();

    $likeCount = new WP_Query([
        'post_type' => 'like',
        'meta_query' => [
            [
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => get_the_ID(),
            ],
        ],
    ]);

    $totalLikes = $likeCount->found_posts;

    $existsStatus = 'no';

    if (is_user_logged_in()) {

        $existsQuery = new WP_Query([
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => [
                [
                    'key' => 'liked_professor_id',
                    'compare' => '=',
                    'value' => get_the_ID(),
                ],
            ],
        ]);

        if ($existsQuery->found_posts) {
            $existsStatus = 'yes';
        }
    }

    ?>

    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="row group">
                <div class="one-third">
                    <?php
                    the_post_thumbnail('professorPortrait');
                    ?>
                </div>
                <div class="two-third">
                    <span class="like-box" data-professor="<?= get_the_ID(); ?>" data-exists="<?= $existsStatus ?>" data-like="<?= $existsQuery->posts[0]->ID; ?>">
                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                        <span class="like-count"><?= $totalLikes ?></span>
                    </span>
                    <?php
                    the_content();
                    ?>
                </div>
            </div>
        </div>

        <?php
        if (isset($relatedPrograms)):
            ?>
            <hr class="section-break">

            <h2 class="headline headline--medium">Subject(s) taught</h2>
            <ul class="link-list min-list">
                <?php
                foreach ($relatedPrograms as $relatedProgram):
                    ?>
                    <li>
                        <a href="<?= get_the_permalink($relatedProgram) ?>">
                            <?= get_the_title($relatedProgram) ?>
                        </a>
                    </li>
                <?php
                endForeach;
                ?>
            </ul>
        <?php
        endif;
        ?>
    </div>

<?php
endwhile;

get_footer();
