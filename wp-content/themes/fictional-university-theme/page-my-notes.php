<?php

if (!is_user_logged_in()) {
    wp_redirect(site_url('/'));
    exit();
}

$userNotes = new WP_Query([
    'post_type' => 'note',
    'posts_per_page' => -1,
    'author' => get_current_user_id(),
]);

get_header();

while (have_posts()):
    the_post();

    pageBanner();
    ?>

    <div class="container container--narrow page-section">
        
        <div class="create-note">
            <h2 class="headline headline--medium">Create New Note</h2>
            <input type="text" class="new-note-title" placeholder="Title">
            <textarea class="new-note-body" placeholder="Your note here..."></textarea>
            <span class="submit-note">Create Note</span>
            <span class="note-limit-message">Note limit reached</span>
        </div>
        
        <ul class="min-list link-list" id="my-notes">
            <?php
            while ($userNotes->have_posts()):
                $userNotes->the_post();
                ?>
                <li data-id="<?= get_the_ID() ?>">
                    <input type="text"
                       value="<?= str_replace('Private: ', '', esc_attr(get_the_title())); ?>" class="note-title-field" readonly>
                    <span class="edit-note"><i class="fa fa-pencil"></i> Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o"></i> Delete</span>
                    <textarea readonly class="note-body-field"><?= esc_textarea(get_the_content()) ?></textarea>

                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right"></i> Save</span>
                </li>
                <?php
            endwhile;
            ?>
        </ul>
    </div>
<?php
endwhile;

get_footer();
