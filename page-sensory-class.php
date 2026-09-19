<?php
/**
 * The Sensory Class page template.
 *
 * @package bunayy-theme
 */

get_header();

while ( have_posts() ) :
	the_post();

	$hero      = function_exists( 'get_field' ) ? (array) get_field( 'hero_section' ) : array();
	$about     = function_exists( 'get_field' ) ? (array) get_field( 'about_section' ) : array();
	$benefits  = function_exists( 'get_field' ) ? (array) get_field( 'benefit_section' ) : array();
	$programs  = function_exists( 'get_field' ) ? (array) get_field( 'program_section' ) : array();
	$users     = function_exists( 'get_field' ) ? (array) get_field( 'user_section' ) : array();
	$timeline  = function_exists( 'get_field' ) ? (array) get_field( 'timeline_section' ) : array();
	$advantage = function_exists( 'get_field' ) ? (array) get_field( 'advantage_section' ) : array();
	$teachers  = function_exists( 'get_field' ) ? (array) get_field( 'teacher_section' ) : array();
	$pricing   = function_exists( 'get_field' ) ? (array) get_field( 'pricing_section' ) : array();
	$sharing   = function_exists( 'get_field' ) ? (array) get_field( 'sharing_section' ) : array();
	$image_id  = static fn( $image ): int => (int) ( is_array( $image ) ? ( $image['ID'] ?? 0 ) : $image );
	$hero_cta  = $hero['url_cta'] ?? '';

	if ( 'pricing-section' === wp_parse_url( $hero_cta, PHP_URL_FRAGMENT ) ) {
		$hero_cta = '#pricing-section';
	}
	?>

	<main id="primary" class="site-main sensory-page">
		<?php if ( $hero ) : ?>
			<section class="sensory-hero" aria-labelledby="sensory-hero-title">
				<?php
				$hero_background_id = $image_id( $hero['background_image'] ?? 0 );
				if ( $hero_background_id ) {
					echo wp_get_attachment_image( $hero_background_id, 'full', false, array( 'class' => 'sensory-hero__background', 'fetchpriority' => 'high' ) );
				}
				?>
				<div class="sensory-container sensory-hero__content">
					<?php
					$hero_logo_id = $image_id( $hero['logo'] ?? 0 );
					if ( $hero_logo_id ) {
						echo wp_get_attachment_image( $hero_logo_id, 'medium', false, array( 'class' => 'sensory-hero__logo' ) );
					}
					?>
					<h1 id="sensory-hero-title"><?php echo esc_html( $hero['heading'] ?? '' ); ?></h1>
					<?php if ( ! empty( $hero['description'] ) ) : ?>
						<div class="sensory-richtext sensory-hero__description"><?php echo wp_kses_post( $hero['description'] ); ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $hero['label_cta'] ) && $hero_cta ) : ?>
						<a class="sensory-button sensory-button--primary" href="<?php echo esc_url( $hero_cta ); ?>"><?php echo esc_html( $hero['label_cta'] ); ?> <span aria-hidden="true">→</span></a>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $about ) : ?>
			<section class="sensory-section sensory-about" aria-labelledby="sensory-about-title">
				<div class="sensory-container sensory-copy sensory-copy--center">
					<h2 id="sensory-about-title"><?php echo esc_html( $about['heading'] ?? '' ); ?></h2>
					<?php if ( ! empty( $about['description'] ) ) : ?>
						<div class="sensory-richtext"><?php echo wp_kses_post( $about['description'] ); ?></div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $benefits ) : ?>
			<section class="sensory-section sensory-benefits" aria-labelledby="sensory-benefits-title">
				<div class="sensory-container sensory-benefits__layout">
					<?php
					$benefit_image_id = $image_id( $benefits['benefit_image'] ?? ( $benefits[''] ?? 0 ) );
					if ( $benefit_image_id ) {
						echo wp_get_attachment_image( $benefit_image_id, 'large', false, array( 'class' => 'sensory-benefits__image', 'loading' => 'lazy' ) );
					}
					?>
					<div class="sensory-benefits__content">
						<h2 id="sensory-benefits-title"><?php echo esc_html( $benefits['heading_benefit'] ?? '' ); ?></h2>
						<?php if ( ! empty( $benefits['list_benefit'] ) ) : ?>
							<div class="sensory-benefits__list">
								<?php foreach ( $benefits['list_benefit'] as $benefit ) : ?>
									<article class="sensory-benefit-card">
										<h3><?php echo esc_html( $benefit['heading'] ?? '' ); ?></h3>
										<?php if ( ! empty( $benefit['description'] ) ) : ?>
											<div class="sensory-richtext"><?php echo wp_kses_post( $benefit['description'] ); ?></div>
										<?php endif; ?>
									</article>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $programs ) : ?>
			<section class="sensory-section sensory-programs" aria-labelledby="sensory-programs-title">
				<?php
				$program_background_id = $image_id( $programs['background_image'] ?? 0 );
				if ( $program_background_id ) {
					echo wp_get_attachment_image( $program_background_id, 'full', false, array( 'class' => 'sensory-programs__background', 'loading' => 'lazy', 'alt' => '' ) );
				}
				?>
				<div class="sensory-container">
					<h2 id="sensory-programs-title"><?php echo esc_html( $programs['heading'] ?? '' ); ?></h2>
					<?php if ( ! empty( $programs['list_program'] ) ) : ?>
						<div class="sensory-programs__grid">
							<?php foreach ( $programs['list_program'] as $program ) : ?>
								<article class="sensory-program-card">
									<?php
									$program_image_id = $image_id( $program['card_image'] ?? 0 );
									if ( $program_image_id ) {
										echo wp_get_attachment_image( $program_image_id, 'thumbnail', false, array( 'class' => 'sensory-program-card__icon', 'loading' => 'lazy' ) );
									}
									?>
									<h3><?php echo esc_html( $program['heading_card'] ?? '' ); ?></h3>
									<?php if ( ! empty( $program['description_card'] ) ) : ?>
										<div class="sensory-richtext"><?php echo wp_kses_post( $program['description_card'] ); ?></div>
									<?php endif; ?>
								</article>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $users ) : ?>
			<section class="sensory-section sensory-users" aria-labelledby="sensory-users-title">
				<div class="sensory-container">
					<h2 id="sensory-users-title"><?php echo esc_html( $users['heading'] ?? '' ); ?></h2>
					<?php if ( ! empty( $users['user_card'] ) ) : ?>
						<div class="sensory-users__grid">
							<?php foreach ( $users['user_card'] as $user ) : ?>
								<article class="sensory-user-card">
									<?php
									$user_image_id = $image_id( $user['user_card_image'] ?? 0 );
									if ( $user_image_id ) {
										echo wp_get_attachment_image( $user_image_id, 'large', false, array( 'class' => 'sensory-user-card__image', 'loading' => 'lazy' ) );
									}
									?>
									<div class="sensory-user-card__body">
										<h3><?php echo esc_html( $user['user_card_heading'] ?? '' ); ?></h3>
										<?php if ( ! empty( $user['user_card_description'] ) ) : ?>
											<div class="sensory-richtext"><?php echo wp_kses_post( $user['user_card_description'] ); ?></div>
										<?php endif; ?>
									</div>
								</article>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $timeline ) : ?>
			<section class="sensory-section sensory-timeline" aria-labelledby="sensory-timeline-title">
				<div class="sensory-container sensory-timeline__panel">
					<div class="sensory-copy sensory-copy--center">
						<h2 id="sensory-timeline-title"><?php echo esc_html( $timeline['heading'] ?? '' ); ?></h2>
						<?php if ( ! empty( $timeline['description'] ) ) : ?>
							<div class="sensory-richtext"><?php echo wp_kses_post( $timeline['description'] ); ?></div>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $timeline['timeline_list'] ) ) : ?>
						<ol class="sensory-timeline__list">
							<?php foreach ( $timeline['timeline_list'] as $index => $item ) : ?>
								<li class="sensory-timeline__item">
									<span class="sensory-timeline__number"><?php echo esc_html( $index + 1 ); ?></span>
									<h3><?php echo esc_html( $item['heading'] ?? '' ); ?></h3>
									<?php if ( $index < count( $timeline['timeline_list'] ) - 1 ) : ?>
										<svg class="sensory-timeline__arrow" viewBox="0 0 48 24" aria-hidden="true" focusable="false">
											<path d="M3 12h37M31 4l9 8-9 8" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
										</svg>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ol>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $sharing ) : ?>
			<section class="sensory-section sensory-sharing" aria-labelledby="sensory-sharing-title">
				<div class="sensory-container">
					<div class="sensory-copy sensory-copy--center">
						<h2 id="sensory-sharing-title"><?php echo esc_html( $sharing['heading'] ?? '' ); ?></h2>
						<?php if ( ! empty( $sharing['description'] ) ) : ?>
							<div class="sensory-richtext"><?php echo wp_kses_post( $sharing['description'] ); ?></div>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $sharing['gallery'] ) ) : ?>
						<div class="sensory-sharing__gallery">
							<?php foreach ( $sharing['gallery'] as $gallery_image ) : ?>
								<?php
								$gallery_image_id = $image_id( $gallery_image );
								if ( $gallery_image_id ) {
									echo wp_get_attachment_image( $gallery_image_id, 'medium_large', false, array( 'class' => 'sensory-sharing__image', 'loading' => 'lazy' ) );
								}
								?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $advantage ) : ?>
			<section class="sensory-section sensory-advantage" aria-labelledby="sensory-advantage-title">
				<div class="sensory-container sensory-advantage__layout">
					<?php
					$advantage_image_id = $image_id( $advantage['banner'] ?? 0 );
					if ( $advantage_image_id ) {
						echo wp_get_attachment_image( $advantage_image_id, 'large', false, array( 'class' => 'sensory-advantage__image', 'loading' => 'lazy' ) );
					}
					?>
					<div class="sensory-advantage__content">
						<h2 id="sensory-advantage-title"><?php echo esc_html( $advantage['heading'] ?? '' ); ?></h2>
						<?php if ( ! empty( $advantage['description'] ) ) : ?>
							<div class="sensory-richtext"><?php echo wp_kses_post( $advantage['description'] ); ?></div>
						<?php endif; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $teachers ) : ?>
			<section class="sensory-section sensory-teachers" aria-labelledby="sensory-teachers-title">
				<div class="sensory-container">
					<div class="sensory-copy sensory-copy--center">
						<h2 id="sensory-teachers-title"><?php echo esc_html( $teachers['heading'] ?? '' ); ?></h2>
						<?php if ( ! empty( $teachers['description'] ) ) : ?>
							<div class="sensory-richtext"><?php echo wp_kses_post( $teachers['description'] ); ?></div>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $teachers['teacher_card_item'] ) ) : ?>
						<div class="sensory-teachers__grid">
							<?php foreach ( $teachers['teacher_card_item'] as $teacher ) : ?>
								<article class="sensory-teacher-card">
									<?php
									$teacher_image_id = $image_id( $teacher['teacher_image'] ?? 0 );
									if ( $teacher_image_id ) {
										echo wp_get_attachment_image( $teacher_image_id, 'medium_large', false, array( 'class' => 'sensory-teacher-card__image', 'loading' => 'lazy' ) );
									}
									?>
									<div class="sensory-teacher-card__body">
										<h3><?php echo esc_html( $teacher['teacher_name'] ?? '' ); ?></h3>
										<?php if ( ! empty( $teacher['teacher_bio'] ) ) : ?>
											<div class="sensory-richtext"><?php echo wp_kses_post( $teacher['teacher_bio'] ); ?></div>
										<?php endif; ?>
									</div>
								</article>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $pricing ) : ?>
			<section id="pricing-section" class="sensory-section sensory-pricing" aria-labelledby="sensory-pricing-title">
				<?php
				$pricing_background_id = $image_id( $pricing['background_image'] ?? 0 );
				if ( $pricing_background_id ) {
					echo wp_get_attachment_image( $pricing_background_id, 'full', false, array( 'class' => 'sensory-pricing__background', 'loading' => 'lazy', 'alt' => '' ) );
				}
				?>
				<div class="sensory-container sensory-pricing__content">
					<div class="sensory-copy sensory-copy--center">
						<h2 id="sensory-pricing-title"><?php echo esc_html( $pricing['heading'] ?? '' ); ?></h2>
						<?php if ( ! empty( $pricing['description'] ) ) : ?>
							<div class="sensory-richtext"><?php echo wp_kses_post( $pricing['description'] ); ?></div>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $pricing['pricing_card'] ) ) : ?>
						<?php $price_card = (array) $pricing['pricing_card']; ?>
						<article class="sensory-price-card">
							<h3><?php echo esc_html( $price_card['heading_card'] ?? '' ); ?></h3>
							<div class="sensory-price-card__body">
								<?php if ( ! empty( $price_card['pricing_compare'] ) ) : ?>
									<del><?php echo esc_html( $price_card['pricing_compare'] ); ?></del>
								<?php endif; ?>
								<?php if ( ! empty( $price_card['pricing_discount'] ) ) : ?>
									<p class="sensory-price-card__price"><?php echo esc_html( $price_card['pricing_discount'] ); ?></p>
								<?php endif; ?>
								<?php if ( ! empty( $price_card['discount_label'] ) ) : ?>
									<p class="sensory-price-card__discount"><?php echo esc_html( $price_card['discount_label'] ); ?></p>
								<?php endif; ?>
								<?php if ( ! empty( $price_card['list_package'] ) ) : ?>
									<div class="sensory-richtext sensory-price-card__list"><?php echo wp_kses_post( $price_card['list_package'] ); ?></div>
								<?php endif; ?>
								<?php if ( ! empty( $price_card['label_cta'] ) && ! empty( $price_card['url_cta'] ) ) : ?>
									<a class="sensory-button sensory-button--primary" href="<?php echo esc_url( $price_card['url_cta'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $price_card['label_cta'] ); ?> <span aria-hidden="true">→</span></a>
								<?php endif; ?>
							</div>
						</article>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>
	</main>

	<?php
endwhile;

get_footer();
