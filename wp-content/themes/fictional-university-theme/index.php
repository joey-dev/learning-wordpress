<?php
get_header();

pageBanner([
    'title' => ' Welcome to our blog!',
    'subtitle' => 'Keep up with out loatest news.',
]);
?>

<div class="container container--narrow page-section">
    <?php
    while(have_posts()):
        the_post();
        $authorPostLink = get_the_author_posts_link();
        $theTime = get_the_time('d-m-Y');
	    $theCategoryList = get_the_category_list(', ');
        ?>
        <div class="post-item">
            <h2 class="headline headline--medium headline--post-title">
                <a href="<?php the_permalink(); ?>">
                    <?php
                    the_title();
                    ?>
                </a>
            </h2>
            <div class="metabox">
                <p>
                    <?=
                    "Posted by: $authorPostLink
                    on $theTime in $theCategoryList"
                    ?>

                </p>
            </div>
            <div class="generic-content">
                <?php the_excerpt(); ?>
                <p>
                    <a href="<?php the_permalink(); ?>" class="btn btn--blue">
                        Continue reading &raquo;
                    </a>
                </p>
            </div>
        </div>
        <?php
    endwhile;

    echo paginate_links();

    ?>
</div>

<?php
get_footer();
