<?php
get_header();

$parentId = wp_get_post_parent_id(
	get_the_ID()
);

$findChildrenOf = $parentId ?: get_the_ID();

while(have_posts()):
	the_post();

    pageBanner([
        'title' => 'testing title',
    ]);
	?>

    <div class="container container--narrow page-section">
        <?php
        if ($parentId):
        ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?= get_permalink($parentId) ?>">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        Back to <?= get_the_title($parentId) ?>
                    </a>
                    <span class="metabox__main">
                        <?php the_title() ?>
                    </span>
                </p>
            </div>
        <?php
        endif;
        ?>

        <?php
        $hasChild = get_pages([
            'child_of' => get_the_ID(),
        ]);

        if ($parentId || $hasChild):
            ?>
            <div class="page-links">
                <h2 class="page-links__title">
                    <a href="<?= get_permalink($findChildrenOf) ?>">
                        <?= get_the_title($findChildrenOf) ?>
                    </a>
                </h2>
                <ul class="min-list">
                    <?php
                    wp_list_pages([
                        'title_li' => NULL,
                        'child_of' => $findChildrenOf,
                        'sort_column' => 'menu_order',
                    ]);
                    ?>
                </ul>
            </div>
            <?php
        endif;
        ?>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>
    </div>
	<?php
endwhile;

get_footer();
