<?php
get_header();

while(have_posts()):
	the_post();
    $relatedPrograms = get_field('related_programs');

    pageBanner();
    ?>

	<div class="container container--narrow page-section">
		<div class="metabox metabox--position-up metabox--with-home-link">
			<p>
				<a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('event') ?>">
					<i class="fa fa-home" aria-hidden="true"></i>
					Event Home
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
        if ($relatedPrograms):
            ?>
            <hr class="section-break">

            <h2 class="headline headline--medium">Related Program(s)</h2>
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
