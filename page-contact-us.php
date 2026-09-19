<?php

/**
 * The Contact Us page template.
 *
 * @package bunayy-theme
 */

get_header();

while (have_posts()) :
    the_post();

    $hero           = function_exists('get_field') ? (array) get_field('hero_section') : array();
    $contact_detail = function_exists('get_field') ? (array) get_field('contact_detail') : array();
    $form_heading   = function_exists('get_field') ? get_field('contact_heading_form') : '';
    $form_description   = function_exists('get_field') ? get_field('contact_description_form') : '';
    $form_image     = function_exists('get_field') ? get_field('contact_image_form') : 0;
    $form_fields    = bunayy_contact_form_fields();
    $image_id       = static fn($image): int => (int) (is_array($image) ? ($image['ID'] ?? 0) : $image);
    $status         = isset($_GET['contact_status']) ? sanitize_key(wp_unslash($_GET['contact_status'])) : '';
?>

    <main id="primary" class="site-main contact-page">
        <?php if ($hero) : ?>
            <section class="contact-hero" aria-labelledby="contact-hero-title">
                <?php
                $background_id = $image_id($hero['background_image'] ?? 0);
                if ($background_id) {
                    echo wp_get_attachment_image($background_id, 'full', false, array('class' => 'contact-hero__background', 'fetchpriority' => 'high'));
                }
                ?>
                <div class="contact-container contact-hero__content">
                    <?php
                    $logo_id = $image_id($hero['logo'] ?? 0);
                    if ($logo_id) {
                        echo wp_get_attachment_image($logo_id, 'medium', false, array('class' => 'contact-hero__logo'));
                    }
                    ?>
                    <h1 id="contact-hero-title"><?php echo esc_html($hero['heading'] ?? ''); ?></h1>
                    <?php if (! empty($hero['description'])) : ?>
                        <p><?php echo nl2br(esc_html($hero['description'])); ?></p>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <section id="contact-form" class="contact-form-section" aria-labelledby="contact-form-title">
            <div class="contact-container">

                <?php if (! empty($contact_detail['card_detail_contact'])) : ?>
                    <div class="contact-details" aria-label="<?php esc_attr_e('Informasi kontak Bunayy Kids Club', 'bunayy-theme'); ?>">
                        <div class="contact-details__grid">
                            <?php foreach ($contact_detail['card_detail_contact'] as $detail) : ?>
                                <article class="contact-detail-card">
                                    <?php if (! empty($detail['contact_icon'])) : ?>
                                        <div class="contact-detail-card__icon" aria-hidden="true">
                                            <?php if (filter_var($detail['contact_icon'], FILTER_VALIDATE_URL)) : ?>
                                                <img src="<?php echo esc_url($detail['contact_icon']); ?>" alt="" loading="lazy">
                                            <?php else : ?>
                                                <span class="<?php echo esc_attr($detail['contact_icon']); ?>"></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <h3><?php echo esc_html($detail['heading'] ?? ''); ?></h3>
                                    <?php if (! empty($detail['description'])) : ?>
                                        <div class="contact-detail-card__description"><?php echo wp_kses_post($detail['description']); ?></div>
                                    <?php endif; ?>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>


                <div class="contact-form-section__layout">
                    <?php
                    $form_image_id = $image_id($form_image);
                    if ($form_image_id) :
                    ?>
                        <figure class="contact-form-section__media">
                            <?php echo wp_get_attachment_image($form_image_id, 'large', false, array('class' => 'contact-form-section__image', 'loading' => 'lazy')); ?>
                        </figure>
                    <?php endif; ?>

                    <div class="contact-form-card">
                        <div class="contact-form-card__intro">
                            <h2 id="contact-form-title"><?php echo esc_html($form_heading ?: __('Kirimkan Pesan Kepada Kami', 'bunayy-theme')); ?></h2>
                            <?php if ($form_description) : ?>
                                <p><?php echo esc_html($form_description); ?></p>
                            <?php endif; ?>
                        </div>

                        <?php if ('success' === $status) : ?>
                            <p class="contact-form-notice contact-form-notice--success" role="status"><?php esc_html_e('Terima kasih. Pesan Anda sudah kami terima.', 'bunayy-theme'); ?></p>
                        <?php elseif ('error' === $status) : ?>
                            <p class="contact-form-notice contact-form-notice--error" role="alert"><?php esc_html_e('Pesan belum terkirim. Mohon periksa kembali semua kolom.', 'bunayy-theme'); ?></p>
                        <?php endif; ?>

                        <form class="contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                            <input type="hidden" name="action" value="bunayy_submit_contact">
                            <?php wp_nonce_field('bunayy_submit_contact', 'bunayy_contact_nonce'); ?>

                            <div class="contact-form__honeypot" aria-hidden="true">
                                <label for="contact-website"><?php esc_html_e('Website', 'bunayy-theme'); ?></label>
                                <input id="contact-website" name="contact_website" type="text" tabindex="-1" autocomplete="off">
                            </div>

                            <?php foreach ($form_fields as $field_name => $field) : ?>
                                <div class="contact-form__field">
                                    <label for="contact-<?php echo esc_attr($field_name); ?>">
                                        <?php echo esc_html($field['label']); ?><?php if (! empty($field['required'])) : ?><span aria-hidden="true">*</span><?php endif; ?>
                                    </label>

                                    <?php if ('textarea' === $field['type']) : ?>
                                        <textarea id="contact-<?php echo esc_attr($field_name); ?>" name="bunayy_contact[<?php echo esc_attr($field_name); ?>]" rows="5" placeholder="<?php echo esc_attr($field['placeholder'] ?? ''); ?>" <?php echo ! empty($field['required']) ? ' required' : ''; ?>></textarea>
                                    <?php else : ?>
                                        <input id="contact-<?php echo esc_attr($field_name); ?>" name="bunayy_contact[<?php echo esc_attr($field_name); ?>]" type="<?php echo esc_attr($field['type']); ?>" placeholder="<?php echo esc_attr($field['placeholder'] ?? ''); ?>" autocomplete="<?php echo esc_attr($field['autocomplete'] ?? 'off'); ?>" <?php echo ! empty($field['required']) ? ' required' : ''; ?>>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>

                            <button class="contact-form__submit" type="submit"><?php esc_html_e('Kirim Pesan', 'bunayy-theme'); ?> <span aria-hidden="true">→</span></button>
                        </form>
                    </div>
                </div>


            </div>
        </section>
    </main>

<?php
endwhile;

get_footer();
