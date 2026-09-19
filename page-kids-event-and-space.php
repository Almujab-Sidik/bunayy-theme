<?php
/**
 * Template Name: Kids Event & Space
 *
 * @package bunayy-theme
 */

get_header();

while ( have_posts() ) :
	the_post();

	$sections = function_exists( 'get_field' ) ? (array) get_field( 'event_sections' ) : array();
	$image_id = static fn( $image ): int => (int) ( is_array( $image ) ? ( $image['ID'] ?? 0 ) : $image );
	?>

	<main id="primary" class="site-main event-page">
		<?php foreach ( $sections as $section ) : ?>
			<?php $layout = $section['acf_fc_layout'] ?? ''; ?>

			<?php if ( 'hero_section' === $layout ) : ?>
				<section class="event-hero" aria-labelledby="event-hero-title">
					<?php
					$background_id = $image_id( $section['background_image'] ?? 0 );
					if ( $background_id ) {
						echo wp_get_attachment_image( $background_id, 'full', false, array( 'class' => 'event-hero__background', 'fetchpriority' => 'high' ) );
					}
					?>
					<div class="event-container event-hero__content">
						<?php
						$logo_id = $image_id( $section['logo'] ?? 0 );
						if ( $logo_id ) {
							echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'class' => 'event-hero__logo' ) );
						}
						?>
						<?php if ( ! empty( $section['heading'] ) ) : ?>
							<h1 id="event-hero-title"><?php echo esc_html( $section['heading'] ); ?></h1>
						<?php endif; ?>
						<?php if ( ! empty( $section['description'] ) ) : ?>
							<div class="event-richtext event-hero__description"><?php echo wp_kses_post( $section['description'] ); ?></div>
						<?php endif; ?>
						<?php if ( ! empty( $section['buttons'] ) ) : ?>
							<div class="event-actions">
								<?php foreach ( $section['buttons'] as $button ) : ?>
									<?php if ( ! empty( $button['label'] ) && ! empty( $button['url'] ) ) : ?>
										<a class="event-button event-button--<?php echo esc_attr( sanitize_html_class( $button['style'] ?? 'primary' ) ); ?>" href="<?php echo esc_url( $button['url'] ); ?>"><?php echo esc_html( $button['label'] ); ?></a>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</section>

			<?php elseif ( 'package_event' === $layout ) : ?>
				<?php $section_id = sanitize_title( $section['section_id'] ?? '' ); ?>
				<section<?php echo $section_id ? ' id="' . esc_attr( $section_id ) . '"' : ''; ?> class="event-section event-packages">
					<div class="event-container">
						<header class="event-heading">
							<?php if ( ! empty( $section['heading'] ) ) : ?>
								<h2><?php echo esc_html( $section['heading'] ); ?></h2>
							<?php endif; ?>
							<?php if ( ! empty( $section['subheading'] ) ) : ?>
								<div class="event-richtext"><?php echo wp_kses_post( $section['subheading'] ); ?></div>
							<?php endif; ?>
						</header>

						<?php if ( ! empty( $section['packages'] ) ) : ?>
							<div class="event-package-grid">
								<?php foreach ( $section['packages'] as $package ) : ?>
									<?php $card_style = sanitize_html_class( $package['card_style'] ?? 'green' ); ?>
									<article class="event-package-card event-package-card--<?php echo esc_attr( $card_style ); ?>">
										<header class="event-package-card__header">
											<?php if ( ! empty( $package['package_name'] ) ) : ?>
												<h3>
													<?php if ( ! empty( $package['package_icon'] ) ) : ?>
														<img class="event-package-card__icon" src="<?php echo esc_url( $package['package_icon'] ); ?>" alt="">
													<?php endif; ?>
													<span><?php echo esc_html( $package['package_name'] ); ?></span>
												</h3>
											<?php endif; ?>
											<?php if ( ! empty( $package['tagline'] ) ) : ?>
												<p><?php echo esc_html( $package['tagline'] ); ?></p>
											<?php endif; ?>
										</header>
										<div class="event-package-card__body">
											<?php if ( ! empty( $package['duration'] ) ) : ?>
												<p class="event-package-card__duration"><?php echo esc_html( $package['duration'] ); ?></p>
											<?php endif; ?>
											<?php if ( ! empty( $package['description'] ) ) : ?>
												<div class="event-richtext event-package-card__description"><?php echo wp_kses_post( $package['description'] ); ?></div>
											<?php endif; ?>
											<?php if ( ! empty( $package['label_cta'] ) && ! empty( $package['url_cta'] ) ) : ?>
												<a class="event-button event-button--primary event-package-card__button" href="<?php echo esc_url( $package['url_cta'] ); ?>"><?php echo esc_html( $package['label_cta'] ); ?></a>
											<?php endif; ?>
										</div>
									</article>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $section['cta_label'] ) && ! empty( $section['cta_url'] ) ) : ?>
							<div class="event-section__action"><a class="event-button event-button--primary" href="<?php echo esc_url( $section['cta_url'] ); ?>"><?php echo esc_html( $section['cta_label'] ); ?></a></div>
						<?php endif; ?>
					</div>
				</section>

			<?php elseif ( 'sewa_venue' === $layout ) : ?>
				<?php $section_id = sanitize_title( $section['section_id'] ?? '' ); ?>
				<section<?php echo $section_id ? ' id="' . esc_attr( $section_id ) . '"' : ''; ?> class="event-section event-venue">
					<?php
					$venue_background_id = $image_id( $section['background_image'] ?? 0 );
					if ( $venue_background_id ) {
						echo wp_get_attachment_image( $venue_background_id, 'full', false, array( 'class' => 'event-venue__background', 'loading' => 'lazy', 'alt' => '' ) );
					}
					?>
					<div class="event-container">
						<header class="event-heading">
							<?php if ( ! empty( $section['heading'] ) ) : ?>
								<h2><?php echo esc_html( $section['heading'] ); ?></h2>
							<?php endif; ?>
							<?php if ( ! empty( $section['description'] ) ) : ?>
								<div class="event-richtext"><?php echo wp_kses_post( $section['description'] ); ?></div>
							<?php endif; ?>
						</header>
						<?php if ( ! empty( $section['label_cta'] ) && ! empty( $section['url_cta'] ) ) : ?>
							<div class="event-section__action"><a class="event-button event-button--primary" href="<?php echo esc_url( $section['url_cta'] ); ?>"><?php echo esc_html( $section['label_cta'] ); ?></a></div>
						<?php endif; ?>
						<?php if ( ! empty( $section['venue_gallery'] ) ) : ?>
							<div class="event-venue__gallery">
								<?php foreach ( $section['venue_gallery'] as $image ) : ?>
									<?php
									$gallery_image_id = $image_id( $image );
									if ( $gallery_image_id ) {
										$full_image = wp_get_attachment_image_url( $gallery_image_id, 'full' );
										$alt        = get_post_meta( $gallery_image_id, '_wp_attachment_image_alt', true );
										?>
										<button class="event-gallery__trigger" type="button" data-event-lightbox-src="<?php echo esc_url( $full_image ); ?>" data-event-lightbox-alt="<?php echo esc_attr( $alt ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Perbesar gambar %s', 'bunayy-theme' ), $alt ?: __( 'galeri venue', 'bunayy-theme' ) ) ); ?>" aria-haspopup="dialog">
											<?php echo wp_get_attachment_image( $gallery_image_id, 'medium_large', false, array( 'class' => 'event-venue__image', 'loading' => 'lazy' ) ); ?>
										</button>
										<?php
									}
									?>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</section>

			<?php elseif ( 'partner_collaboration' === $layout ) : ?>
				<?php
				$partner_image_id     = $image_id( $section['partner_image'] ?? 0 );
				$partner_logo_id      = $image_id( $section['partner_logo'] ?? 0 );
				$certificate_image_id = $image_id( $section['certificate_image'] ?? 0 );
				?>
				<section class="event-section event-collaboration">
					<div class="event-container event-collaboration__layout">
						<?php if ( $partner_image_id || $partner_logo_id || $certificate_image_id ) : ?>
							<div class="event-collaboration__media">
								<?php
								if ( $partner_image_id ) {
									echo wp_get_attachment_image( $partner_image_id, 'large', false, array( 'class' => 'event-collaboration__portrait', 'loading' => 'lazy' ) );
								}
								if ( $certificate_image_id ) {
									echo wp_get_attachment_image( $certificate_image_id, 'medium_large', false, array( 'class' => 'event-collaboration__certificate', 'loading' => 'lazy' ) );
								}
								if ( $partner_logo_id ) {
									echo wp_get_attachment_image( $partner_logo_id, 'medium', false, array( 'class' => 'event-collaboration__logo', 'loading' => 'lazy' ) );
								}
								?>
							</div>
						<?php endif; ?>
						<div class="event-collaboration__content">
							<?php if ( ! empty( $section['heading'] ) || ! empty( $section['highlight_text'] ) ) : ?>
								<h2><span><?php echo esc_html( $section['highlight_text'] ?? '' ); ?></span> <?php echo esc_html( $section['heading'] ?? '' ); ?></h2>
							<?php endif; ?>
							<?php if ( ! empty( $section['description'] ) ) : ?>
								<div class="event-richtext"><?php echo wp_kses_post( $section['description'] ); ?></div>
							<?php endif; ?>
							<?php if ( ! empty( $section['closing_text'] ) ) : ?>
								<p class="event-collaboration__closing"><?php echo esc_html( $section['closing_text'] ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $section['product_gallery'] ) ) : ?>
								<div class="event-collaboration__gallery">
									<?php foreach ( $section['product_gallery'] as $image ) : ?>
										<?php
										$product_image_id = $image_id( $image );
										if ( $product_image_id ) {
											$full_image = wp_get_attachment_image_url( $product_image_id, 'full' );
											$alt        = get_post_meta( $product_image_id, '_wp_attachment_image_alt', true );
											?>
											<button class="event-gallery__trigger" type="button" data-event-lightbox-src="<?php echo esc_url( $full_image ); ?>" data-event-lightbox-alt="<?php echo esc_attr( $alt ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Perbesar gambar %s', 'bunayy-theme' ), $alt ?: __( 'produk kolaborasi', 'bunayy-theme' ) ) ); ?>" aria-haspopup="dialog">
												<?php echo wp_get_attachment_image( $product_image_id, 'medium', false, array( 'class' => 'event-collaboration__product', 'loading' => 'lazy' ) ); ?>
											</button>
											<?php
										}
										?>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							<?php if ( ! empty( $section['cta_label'] ) && ! empty( $section['cta_url'] ) ) : ?>
								<a class="event-button event-button--primary" href="<?php echo esc_url( $section['cta_url'] ); ?>"><?php echo esc_html( $section['cta_label'] ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				</section>
			<?php endif; ?>
		<?php endforeach; ?>

		<dialog class="event-lightbox" id="event-lightbox" aria-label="<?php esc_attr_e( 'Pratinjau gambar', 'bunayy-theme' ); ?>">
			<form method="dialog"><button class="event-lightbox__close" aria-label="<?php esc_attr_e( 'Tutup gambar', 'bunayy-theme' ); ?>">&times;</button></form>
			<img class="event-lightbox__image" src="" alt="">
		</dialog>
	</main>

	<?php
endwhile;

get_footer();
