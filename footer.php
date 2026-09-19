<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bunayy-theme
 */

$bunayy_footer = array_fill_keys(
    array(
        'footer_heading',
        'footer_address_heading',
        'footer_address',
        'footer_contact_heading',
        'footer_whatsapp',
        'footer_whatsapp_label',
        'footer_whatsapp_name',
        'footer_whatsapp_url',
        'footer_email',
        'footer_ig_label',
        'footer_ig_url',
        'footer_hours',
        'footer_map_button_label',
        'footer_map_url',
        'footer_map_embed_url',
        'footer_map_title',
        'footer_logo',
        'footer_copyright_owner',
        'footer_copyright_suffix',
    ),
    ''
);

$bunayy_footer_ids = get_posts(
    array(
        'post_type'      => 'footer',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    )
);

if ($bunayy_footer_ids && function_exists('get_fields')) {
    $bunayy_footer = array_merge($bunayy_footer, (array) get_fields($bunayy_footer_ids[0]));
}

?>

<footer id="colophon" class="site-footer">
    <section class="site-footer__contact" aria-labelledby="footer-contact-title">
        <div class="site-footer__grid">
            <div class="site-footer__details">
                <h2 id="footer-contact-title"><?php echo nl2br(esc_html($bunayy_footer['footer_heading'])); ?></h2>

                <div class="site-footer__group">
                    <h3><?php echo esc_html($bunayy_footer['footer_address_heading']); ?></h3>
                    <address><?php echo nl2br(esc_html($bunayy_footer['footer_address'])); ?></address>
                </div>

                <div class="site-footer__group">
                    <h3><?php echo esc_html($bunayy_footer['footer_contact_heading']); ?></h3>
                    <p><strong>WhatsApp:</strong> <a href="<?php echo esc_url($bunayy_footer['footer_whatsapp_url']); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp <?php echo esc_attr($bunayy_footer['footer_whatsapp']); ?>"><?php echo esc_html($bunayy_footer['footer_whatsapp_label']); ?></a> (<?php echo esc_html($bunayy_footer['footer_whatsapp_name']); ?>)<br>
                        <strong>Email:</strong> <a href="<?php echo esc_url('mailto:' . sanitize_email($bunayy_footer['footer_email'])); ?>"><?php echo esc_html($bunayy_footer['footer_email']); ?></a><br>
                        <strong>Instagram:</strong> <a href="<?php echo esc_url($bunayy_footer['footer_ig_url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($bunayy_footer['footer_ig_label']); ?></a><br>
                        <span>Jam Operasional: <?php echo esc_html($bunayy_footer['footer_hours']); ?></span>
                    </p>
                </div>
            </div>

            <div class="site-footer__map">
                <a class="site-footer__map-link" href="<?php echo esc_url($bunayy_footer['footer_map_url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($bunayy_footer['footer_map_button_label']); ?> <span aria-hidden="true">↗</span></a>
                <iframe src="<?php echo esc_url($bunayy_footer['footer_map_embed_url']); ?>" title="<?php echo esc_attr($bunayy_footer['footer_map_title']); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
            </div>
        </div>
    </section>

    <div class="site-footer__bottom">
        <?php if ($bunayy_footer['footer_logo']) : ?>
            <a class="site-footer__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                <?php echo wp_get_attachment_image((int) $bunayy_footer['footer_logo'], 'full', false, array('alt' => '')); ?>
            </a>
        <?php endif; ?>
        <p>&copy; <?php echo esc_html(wp_date('Y')); ?> <?php echo esc_html($bunayy_footer['footer_copyright_owner']); ?>. <?php echo esc_html($bunayy_footer['footer_copyright_suffix']); ?></p>
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>
