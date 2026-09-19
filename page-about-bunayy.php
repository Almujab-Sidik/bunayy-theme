<?php

/**
 * The About Bunayy page template.
 *
 * @package bunayy-theme
 */

get_header();

while (have_posts()) :
    the_post();

    $hero         = function_exists('get_field') ? (array) get_field('hero_section') : array();
    $bio          = function_exists('get_field') ? (array) get_field('bio_section') : array();
    $certificates = function_exists('get_field') ? (array) get_field('certificate_section') : array();
    $image_id     = static fn($image): int => (int) (is_array($image) ? ($image['ID'] ?? 0) : $image);
    $gallery      = (array) ($certificates['certificate'] ?? $certificates['certificcate'] ?? array());
?>

    <main id="primary" class="site-main about-page">
        <?php if ($hero) : ?>
            <section class="about-hero" aria-labelledby="about-hero-title">
                <?php
                $background_id = $image_id($hero['background_image'] ?? 0);
                if ($background_id) {
                    echo wp_get_attachment_image($background_id, 'full', false, array('class' => 'about-hero__background', 'fetchpriority' => 'high'));
                }
                ?>
                <div class="about-container about-hero__content">
                    <?php
                    $logo_id = $image_id($hero['logo'] ?? 0);
                    if ($logo_id) {
                        echo wp_get_attachment_image($logo_id, 'medium', false, array('class' => 'about-hero__logo'));
                    }
                    ?>
                    <h1 id="about-hero-title"><?php echo esc_html($hero['heading'] ?? ''); ?></h1>
                    <?php if (! empty($hero['description'])) : ?>
                        <p><?php echo esc_html($hero['description']); ?></p>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($bio) : ?>
            <section class="about-bio" aria-labelledby="about-bio-title">
                <div class="about-container about-bio__content">
                    <?php $bio_image_id = $image_id($bio['bio_image'] ?? 0); ?>
                    <?php if ($bio_image_id) : ?>
                        <figure class="about-bio__image">
                            <?php echo wp_get_attachment_image($bio_image_id, 'large'); ?>
                        </figure>
                    <?php endif; ?>
                    <header class="about-bio__header">
                        <h2 id="about-bio-title"><?php echo esc_html($bio['heading'] ?? ''); ?></h2>
                    </header>
                    <div class="about-bio__history"><?php echo wp_kses_post($bio['history'] ?? ''); ?></div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($certificates) : ?>
            <section class="about-certificates" aria-labelledby="about-certificates-title">
                <div class="about-container about-certificates__inner">
                    <h2 id="about-certificates-title" class="screen-reader-text"><?php esc_html_e('Legalitas Bunayy Kids Club', 'bunayy-theme'); ?></h2>
                    <?php if ($gallery) : ?>
                        <div class="about-certificates__gallery">
                            <?php foreach ($gallery as $certificate) : ?>
                                <?php $certificate_id = $image_id($certificate); ?>
                                <?php if ($certificate_id) : ?>
                                    <figure><?php echo wp_get_attachment_image($certificate_id, 'medium'); ?></figure>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (! empty($certificates['description_text'])) : ?>
                        <p class="about-certificates__description"><?php echo esc_html($certificates['description_text']); ?></p>
                    <?php endif; ?>

                    <?php if (! empty($certificates['no_certificate'])) : ?>
                        <div class="about-certificates__number"><?php echo wp_kses_post($certificates['no_certificate']); ?></div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>

<?php
endwhile;

get_footer();
