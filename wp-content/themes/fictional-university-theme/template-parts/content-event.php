<?php
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