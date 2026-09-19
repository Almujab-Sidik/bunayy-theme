<?php

/**
 * The Educators page template.
 *
 * @package bunayy-theme
 */

get_header();

while (have_posts()) :
    the_post();

    $hero     = function_exists('get_field') ? (array) get_field('hero_section') : array();
    $team     = function_exists('get_field') ? (array) get_field('team_section') : array();
    $cards    = function_exists('get_field') ? (array) get_field('card_section') : array();
    $image_id = static fn($image): int => (int) (is_array($image) ? ($image['ID'] ?? 0) : $image);
?>

    <main id="primary" class="site-main educators-page">
        <?php if ($hero) : ?>
            <section class="educators-hero" aria-labelledby="educators-hero-title">
                <?php
                $background_id = $image_id($hero['background_image'] ?? 0);
                if ($background_id) {
                    echo wp_get_attachment_image($background_id, 'full', false, array('class' => 'educators-hero__background', 'fetchpriority' => 'high'));
                }
                ?>
                <div class="educators-container educators-hero__content">
                    <?php
                    $logo_id = $image_id($hero['logo'] ?? 0);
                    if ($logo_id) {
                        echo wp_get_attachment_image($logo_id, 'medium', false, array('class' => 'educators-hero__logo'));
                    }
                    ?>
                    <h1 id="educators-hero-title"><?php echo esc_html($hero['heading'] ?? ''); ?></h1>
                    <?php if (! empty($hero['description'])) : ?>
                        <p><?php echo esc_html($hero['description']); ?></p>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($team) : ?>
            <section class="educators-team" aria-labelledby="educators-team-title">
                <div class="educators-container educators-team__inner">
                    <?php
                    $team_image_id = $image_id($team['team_image'] ?? 0);
                    if ($team_image_id) {
                        echo wp_get_attachment_image($team_image_id, 'large', false, array('class' => 'educators-team__image'));
                    }
                    ?>
                    <h2 id="educators-team-title"><?php echo esc_html($team['heading'] ?? ''); ?></h2>
                    <?php if (! empty($team['description'])) : ?>
                        <p><?php echo esc_html($team['description']); ?></p>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (! empty($cards['team_card'])) : ?>
            <section class="educators-cards" aria-label="<?php esc_attr_e('Tim edukator Bunayy Kids Club', 'bunayy-theme'); ?>">
                <div class="educators-container educators-cards__grid">
                    <?php foreach ($cards['team_card'] as $educator) : ?>
                        <article class="educator-card">
                            <?php
                            $photo_id = $image_id($educator['educator_photo'] ?? 0);
                            if ($photo_id) {
                                echo wp_get_attachment_image($photo_id, 'large', false, array('class' => 'educator-card__photo'));
                            }
                            ?>
                            <div class="educator-card__body">
                                <?php if (! empty($educator['educator_occupation'])) : ?>
                                    <p class="educator-card__occupation"><?php echo esc_html($educator['educator_occupation']); ?></p>
                                <?php endif; ?>
                                <div class="educator-card__bottom-content">
                                    <?php if (! empty($educator['educator_bio'])) : ?>
                                        <h3><?php echo esc_html($educator['educator_name'] ?? ''); ?></h3>
                                        <p class="educator-card__bio"><?php echo nl2br(esc_html($educator['educator_bio'])); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>

<?php
endwhile;

get_footer();
