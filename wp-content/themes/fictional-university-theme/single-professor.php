<?php
get_header();

while(have_posts()):
    the_post();
    $relatedPrograms = get_field('related_programs');

    pageBanner();
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
