<?php
/**
 * The front page template.
 *
 * @package bunayy-theme
 */

get_header();

$hero         = function_exists( 'get_field' ) ? (array) get_field( 'hero_section' ) : array();
$programs     = function_exists( 'get_field' ) ? (array) get_field( 'hero_programs' ) : array();
$benefits     = function_exists( 'get_field' ) ? (array) get_field( 'hero_benefit' ) : array();
$testimonials = function_exists( 'get_field' ) ? (array) get_field( 'hero_testimonial' ) : array();
$faq          = function_exists( 'get_field' ) ? (array) get_field( 'hero_faq' ) : array();
$cta          = function_exists( 'get_field' ) ? (array) get_field( 'hero_cta' ) : array();

$image_id = static fn( $image ): int => (int) ( is_array( $image ) ? ( $image['ID'] ?? 0 ) : $image );
?>

<main id="primary" class="site-main home-page">
	<?php if ( $hero ) : ?>
		<?php
		$hero_desktop_id = $image_id( $hero['image_desktop'] ?? 0 );
		$hero_mobile_id  = $image_id( $hero['image_mobile'] ?? 0 );
		$hero_desktop    = wp_get_attachment_image_url( $hero_desktop_id, 'full' );
		$hero_mobile     = wp_get_attachment_image_url( $hero_mobile_id, 'full' );
		?>
		<section class="home-hero" aria-labelledby="home-hero-title">
			<?php if ( $hero_desktop ) : ?>
				<picture class="home-hero__media" aria-hidden="true">
					<?php if ( $hero_mobile ) : ?>
						<source media="(max-width: 47.99em)" srcset="<?php echo esc_url( $hero_mobile ); ?>">
					<?php endif; ?>
					<img src="<?php echo esc_url( $hero_desktop ); ?>" alt="" width="1440" height="960" fetchpriority="high">
				</picture>
			<?php endif; ?>

			<div class="home-container home-hero__inner">
				<div class="home-hero__content">
					<?php if ( ! empty( $hero['badge'] ) ) : ?>
						<p class="home-hero__eyebrow"><?php echo esc_html( $hero['badge'] ); ?></p>
					<?php endif; ?>
					<h1 id="home-hero-title"><?php echo esc_html( $hero['heading'] ?? '' ); ?></h1>
					<div class="home-hero__description"><?php echo wp_kses_post( $hero['sub_heading'] ?? '' ); ?></div>
					<?php if ( ! empty( $hero['label_button_cta'] ) && ! empty( $hero['link_cta_'] ) ) : ?>
						<a class="home-button" href="<?php echo esc_url( $hero['link_cta_'] ); ?>"><?php echo esc_html( $hero['label_button_cta'] ); ?> <span aria-hidden="true">→</span></a>
					<?php endif; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $programs ) : ?>
		<section class="home-section home-programs" aria-labelledby="home-programs-title">
			<div class="home-container">
				<header class="home-section__header">
					<h2 id="home-programs-title"><?php echo esc_html( $programs['heading'] ?? '' ); ?></h2>
					<?php if ( ! empty( $programs['description'] ) ) : ?>
						<p><?php echo esc_html( $programs['description'] ); ?></p>
					<?php endif; ?>
				</header>

				<?php if ( ! empty( $programs['card_programs'] ) ) : ?>
					<div class="home-programs__grid">
						<?php foreach ( $programs['card_programs'] as $program ) : ?>
							<article class="home-program-card">
								<?php
								$program_image_id = $image_id( $program['banner_program'] ?? 0 );
								if ( $program_image_id ) {
									echo wp_get_attachment_image( $program_image_id, 'large', false, array( 'class' => 'home-program-card__image' ) );
								}
								?>
								<div class="home-program-card__body">
									<h3><?php echo esc_html( $program['heading_program'] ?? '' ); ?></h3>
									<p><?php echo esc_html( $program['description_program'] ?? '' ); ?></p>
									<?php if ( ! empty( $program['label_cta'] ) && ! empty( $program['url_cta'] ) ) : ?>
										<a class="home-button home-program-card__button" href="<?php echo esc_url( $program['url_cta'] ); ?>"><?php echo esc_html( $program['label_cta'] ); ?> <span aria-hidden="true">→</span></a>
									<?php endif; ?>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $benefits ) : ?>
		<?php
		$benefit_background = wp_get_attachment_image_url( $image_id( $benefits['background_image'] ?? 0 ), 'full' );
		$benefit_banner_id  = $image_id( $benefits['banner_benefit'] ?? 0 );
		?>
		<section class="home-section home-benefits" aria-labelledby="home-benefits-title"<?php echo $benefit_background ? ' style="background-image:url(' . esc_url( $benefit_background ) . ')"' : ''; ?>>
			<div class="home-container home-benefits__grid">
				<?php if ( $benefit_banner_id ) : ?>
					<div class="home-benefits__media">
						<?php echo wp_get_attachment_image( $benefit_banner_id, 'large', false, array( 'class' => 'home-benefits__image' ) ); ?>
					</div>
				<?php endif; ?>
				<div class="home-benefits__content">
					<h2 id="home-benefits-title"><?php echo esc_html( $benefits['heading'] ?? '' ); ?></h2>
					<?php if ( ! empty( $benefits['list_benefit'] ) ) : ?>
						<div class="home-benefits__list">
							<?php foreach ( $benefits['list_benefit'] as $benefit ) : ?>
								<article>
									<h3><?php echo esc_html( $benefit['heading_list_benefit'] ?? '' ); ?></h3>
									<p><?php echo esc_html( $benefit['description_list_benefit'] ?? '' ); ?></p>
								</article>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $testimonials ) : ?>
		<section class="home-section home-testimonials" aria-labelledby="home-testimonials-title">
			<div class="home-container">
				<header class="home-section__header">
					<h2 id="home-testimonials-title"><?php echo esc_html( $testimonials['heading'] ?? '' ); ?></h2>
				</header>
				<?php if ( ! empty( $testimonials['testimonial'] ) ) : ?>
					<div class="home-testimonials__grid">
						<?php foreach ( $testimonials['testimonial'] as $testimonial ) : ?>
							<article class="home-testimonial-card">
								<p class="home-testimonial-card__rating" aria-label="<?php echo esc_attr( $testimonial['rating'] ?? '' ); ?>"><?php echo esc_html( $testimonial['rating'] ?? '' ); ?></p>
								<blockquote><?php echo esc_html( $testimonial['content'] ?? '' ); ?></blockquote>
								<div class="home-testimonial-card__person">
									<?php
									$profile_id = $image_id( $testimonial['profile'] ?? 0 );
									if ( $profile_id ) {
										echo wp_get_attachment_image( $profile_id, 'thumbnail', false, array( 'class' => 'home-testimonial-card__avatar' ) );
									}
									?>
									<div>
										<strong><?php echo esc_html( $testimonial['profile_detail'] ?? '' ); ?></strong>
										<?php if ( ! empty( $testimonial['nick_name'] ) ) : ?>
											<span><?php echo esc_html( $testimonial['nick_name'] ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $faq ) : ?>
		<section class="home-section home-faq" aria-labelledby="home-faq-title">
			<div class="home-container home-faq__grid">
				<header class="home-faq__intro">
					<h2 id="home-faq-title"><?php echo esc_html( $faq['heading'] ?? '' ); ?></h2>
					<div><?php echo wp_kses_post( $faq['description'] ?? '' ); ?></div>
				</header>
				<?php if ( ! empty( $faq['faq'] ) ) : ?>
					<div class="home-faq__items">
						<?php foreach ( $faq['faq'] as $index => $item ) : ?>
							<details<?php echo 0 === $index ? ' open' : ''; ?>>
								<summary><?php echo esc_html( $item['question'] ?? '' ); ?><span aria-hidden="true"></span></summary>
								<div class="home-faq__answer"><?php echo wp_kses_post( $item['answer'] ?? '' ); ?></div>
							</details>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $cta ) : ?>
		<?php $cta_background = wp_get_attachment_image_url( $image_id( $cta['background'] ?? 0 ), 'full' ); ?>
		<section class="home-section home-cta">
			<div class="home-container">
				<div class="home-cta__box"<?php echo $cta_background ? ' style="background-image:url(' . esc_url( $cta_background ) . ')"' : ''; ?>>
					<h2><?php echo esc_html( $cta['heading'] ?? '' ); ?></h2>
					<?php if ( ! empty( $cta['description'] ) ) : ?>
						<p><?php echo esc_html( $cta['description'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $cta['label_cta'] ) && ! empty( $cta['url_cta'] ) ) : ?>
						<a class="home-button home-button--light" href="<?php echo esc_url( $cta['url_cta'] ); ?>"><?php echo esc_html( $cta['label_cta'] ); ?> <span aria-hidden="true">→</span></a>
					<?php endif; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>
</main>

<?php
get_footer();
