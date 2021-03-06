<?php
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
                View program &raquo;
            </a>
        </p>
    </div>
</div>