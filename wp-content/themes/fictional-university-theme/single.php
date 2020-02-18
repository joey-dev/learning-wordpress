<?php
get_header();

while(have_posts()):
	the_post();
	$authorPostLink = get_the_author_posts_link();
	$theTime = get_the_time('d-m-Y');
	$theCategoryList = get_the_category_list(', ');

    pageBanner();
	?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?= site_url('/blog') ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Blog Home
                </a>
                <span class="metabox__main">
                    <?=
                    "Posted by: $authorPostLink
                    on $theTime in $theCategoryList"
                    ?>
                </span>
            </p>
        </div>

        <div class="generic-content">
            <?php
            the_content();
            ?>
        </div>
    </div>

	<?php
endwhile;

get_footer();
