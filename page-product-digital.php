<?php
/**
 * The Product Digital page template.
 *
 * @package bunayy-theme
 */

get_header();

while ( have_posts() ) :
	the_post();

	$hero     = function_exists( 'get_field' ) ? (array) get_field( 'hero_section' ) : array();
	$about    = function_exists( 'get_field' ) ? (array) get_field( 'about_section' ) : array();
	$products = function_exists( 'get_field' ) ? (array) get_field( 'pricing_card' ) : array();
	$image_id = static fn( $image ): int => (int) ( is_array( $image ) ? ( $image['ID'] ?? 0 ) : $image );
	$hero_cta = $hero['url_cta'] ?? '';

	if ( 'pricing' === wp_parse_url( $hero_cta, PHP_URL_FRAGMENT ) ) {
		$hero_cta = '#digital-products';
	}
	?>

	<main id="primary" class="site-main digital-page">
		<?php if ( $hero ) : ?>
			<section class="digital-hero" aria-labelledby="digital-hero-title">
				<?php
				$hero_background_id = $image_id( $hero['background_image'] ?? 0 );
				if ( $hero_background_id ) {
					echo wp_get_attachment_image( $hero_background_id, 'full', false, array( 'class' => 'digital-hero__background', 'fetchpriority' => 'high' ) );
				}
				?>
				<div class="digital-container digital-hero__content">
					<?php
					$hero_logo_id = $image_id( $hero['logo'] ?? 0 );
					if ( $hero_logo_id ) {
						echo wp_get_attachment_image( $hero_logo_id, 'medium', false, array( 'class' => 'digital-hero__logo' ) );
					}
					?>
					<?php if ( ! empty( $hero['heading'] ) ) : ?>
						<h1 id="digital-hero-title"><?php echo esc_html( $hero['heading'] ); ?></h1>
					<?php endif; ?>
					<?php if ( ! empty( $hero['description'] ) ) : ?>
						<div class="digital-richtext digital-hero__description"><?php echo wp_kses_post( $hero['description'] ); ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $hero['label_cta'] ) && $hero_cta ) : ?>
						<a class="digital-button" href="<?php echo esc_url( $hero_cta ); ?>"><?php echo esc_html( $hero['label_cta'] ); ?> <span aria-hidden="true">→</span></a>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $about ) : ?>
			<section class="digital-section digital-about" aria-labelledby="digital-about-title">
				<div class="digital-container digital-about__content">
					<?php if ( ! empty( $about['heading'] ) ) : ?>
						<h2 id="digital-about-title"><?php echo esc_html( $about['heading'] ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $about['description'] ) ) : ?>
						<div class="digital-richtext"><?php echo wp_kses_post( $about['description'] ); ?></div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $products ) : ?>
			<section id="digital-products" class="digital-section digital-products" aria-label="Produk digital">
				<div class="digital-container digital-products__grid">
					<?php foreach ( $products as $product ) : ?>
						<article class="digital-product-card">
							<div class="digital-product-card__media">
								<?php
								$product_image_id = $image_id( $product['image_product'] ?? 0 );
								if ( $product_image_id ) {
									echo wp_get_attachment_image( $product_image_id, 'large', false, array( 'class' => 'digital-product-card__image', 'loading' => 'lazy' ) );
								}
								?>
								<?php if ( ! empty( $product['discount'] ) ) : ?>
									<span class="digital-product-card__discount"><?php echo esc_html( $product['discount'] ); ?></span>
								<?php endif; ?>
							</div>
							<div class="digital-product-card__body">
								<?php if ( ! empty( $product['heading'] ) ) : ?>
									<h2><?php echo esc_html( $product['heading'] ); ?></h2>
								<?php endif; ?>
								<?php if ( ! empty( $product['price_compare'] ) || ! empty( $product['price_sale'] ) ) : ?>
									<div class="digital-product-card__price">
										<?php if ( ! empty( $product['price_compare'] ) ) : ?>
											<del><?php echo esc_html( $product['price_compare'] ); ?></del>
										<?php endif; ?>
										<?php if ( ! empty( $product['price_sale'] ) ) : ?>
											<strong><?php echo esc_html( $product['price_sale'] ); ?></strong>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<?php if ( ! empty( $product['list_package'] ) ) : ?>
									<div class="digital-richtext digital-product-card__features"><?php echo wp_kses_post( $product['list_package'] ); ?></div>
								<?php endif; ?>
								<?php if ( ! empty( $product['label_cta'] ) && ! empty( $product['url_cta'] ) ) : ?>
									<a class="digital-button digital-product-card__button" href="<?php echo esc_url( $product['url_cta'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $product['label_cta'] ); ?> <span aria-hidden="true">→</span></a>
								<?php endif; ?>
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
