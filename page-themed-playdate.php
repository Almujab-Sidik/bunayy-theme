<?php
/**
 * The Themed Playdate page template.
 *
 * @package bunayy-theme
 */

get_header();

while ( have_posts() ) :
	the_post();

	$hero      = function_exists( 'get_field' ) ? (array) get_field( 'hero_section' ) : array();
	$about     = function_exists( 'get_field' ) ? (array) get_field( 'about_section' ) : array();
	$sharing   = function_exists( 'get_field' ) ? (array) get_field( 'sharing_section' ) : array();
	$benefits  = function_exists( 'get_field' ) ? (array) get_field( 'benefit_section' ) : array();
	$programs  = function_exists( 'get_field' ) ? (array) get_field( 'program_section' ) : array();
	$users     = function_exists( 'get_field' ) ? (array) get_field( 'user_section' ) : array();
	$schedule  = function_exists( 'get_field' ) ? (array) get_field( 'schedule_section' ) : array();
	$advantage = function_exists( 'get_field' ) ? (array) get_field( 'advantage_section' ) : array();
	$teachers  = function_exists( 'get_field' ) ? (array) get_field( 'teacher_section' ) : array();
	$pricing   = function_exists( 'get_field' ) ? (array) get_field( 'pricing_section' ) : array();
	$image_id  = static fn( $image ): int => (int) ( is_array( $image ) ? ( $image['ID'] ?? 0 ) : $image );
	$has_value = static fn( $value ): bool => '' !== trim( (string) $value ) && '-' !== trim( (string) $value );
	$hero_cta     = $hero['url_cta'] ?? '';
	$schedule_cta = $schedule['url_cta'] ?? '';

	if ( 'pricing' === wp_parse_url( $hero_cta, PHP_URL_FRAGMENT ) ) {
		$hero_cta = '#pricing';
	}

	if ( 'pricing' === wp_parse_url( $schedule_cta, PHP_URL_FRAGMENT ) ) {
		$schedule_cta = '#pricing';
	}
	?>

	<main id="primary" class="site-main playdate-page">
		<?php if ( $hero ) : ?>
			<section class="playdate-hero" aria-labelledby="playdate-hero-title">
				<?php
				$hero_background_id = $image_id( $hero['background_image'] ?? 0 );
				if ( $hero_background_id ) {
					echo wp_get_attachment_image( $hero_background_id, 'full', false, array( 'class' => 'playdate-hero__background', 'fetchpriority' => 'high' ) );
				}
				?>
				<div class="playdate-container playdate-hero__content">
					<?php
					$hero_logo_id = $image_id( $hero['logo'] ?? 0 );
					if ( $hero_logo_id ) {
						echo wp_get_attachment_image( $hero_logo_id, 'medium', false, array( 'class' => 'playdate-hero__logo' ) );
					}
					?>
					<?php if ( ! empty( $hero['heading'] ) ) : ?>
						<h1 id="playdate-hero-title"><?php echo esc_html( $hero['heading'] ); ?></h1>
					<?php endif; ?>
					<?php if ( ! empty( $hero['description'] ) ) : ?>
						<div class="playdate-richtext playdate-hero__description"><?php echo wp_kses_post( $hero['description'] ); ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $hero['label_cta'] ) && $hero_cta ) : ?>
						<a class="playdate-button" href="<?php echo esc_url( $hero_cta ); ?>"><?php echo esc_html( $hero['label_cta'] ); ?> <span aria-hidden="true">→</span></a>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $about ) : ?>
			<section class="playdate-section playdate-about" aria-labelledby="playdate-about-title">
				<div class="playdate-container playdate-copy playdate-copy--center">
					<?php if ( ! empty( $about['heading'] ) ) : ?>
						<h2 id="playdate-about-title"><?php echo esc_html( $about['heading'] ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $about['description'] ) ) : ?>
						<div class="playdate-richtext"><?php echo wp_kses_post( $about['description'] ); ?></div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $sharing ) : ?>
			<section class="playdate-section playdate-sharing" aria-labelledby="playdate-sharing-title">
				<div class="playdate-container">
					<div class="playdate-copy playdate-copy--center">
						<?php if ( ! empty( $sharing['heading'] ) ) : ?>
							<h2 id="playdate-sharing-title"><?php echo esc_html( $sharing['heading'] ); ?></h2>
						<?php endif; ?>
						<?php if ( ! empty( $sharing['description'] ) ) : ?>
							<div class="playdate-richtext"><?php echo wp_kses_post( $sharing['description'] ); ?></div>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $sharing['gallery'] ) ) : ?>
						<div class="playdate-theme-grid">
							<?php foreach ( $sharing['gallery'] as $theme ) : ?>
								<article class="playdate-theme-card">
									<?php
									$theme_image_id = $image_id( $theme['theme_image'] ?? 0 );
									if ( $theme_image_id ) {
										echo wp_get_attachment_image( $theme_image_id, 'medium_large', false, array( 'class' => 'playdate-theme-card__image', 'loading' => 'lazy' ) );
									}
									?>
									<?php if ( ! empty( $theme['theme_name'] ) ) : ?>
										<h3><?php echo esc_html( $theme['theme_name'] ); ?></h3>
									<?php endif; ?>
								</article>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $benefits ) : ?>
			<section class="playdate-section playdate-benefits" aria-labelledby="playdate-benefits-title">
				<div class="playdate-container playdate-benefits__layout">
					<?php
					$benefit_image_id = $image_id( $benefits['benefit_image'] ?? ( $benefits[''] ?? 0 ) );
					if ( $benefit_image_id ) {
						echo wp_get_attachment_image( $benefit_image_id, 'large', false, array( 'class' => 'playdate-benefits__image', 'loading' => 'lazy' ) );
					}
					?>
					<div>
						<?php if ( ! empty( $benefits['heading_benefit'] ) ) : ?>
							<h2 id="playdate-benefits-title"><?php echo esc_html( $benefits['heading_benefit'] ); ?></h2>
						<?php endif; ?>
						<?php if ( ! empty( $benefits['list_benefit'] ) ) : ?>
							<div class="playdate-benefit-list">
								<?php foreach ( $benefits['list_benefit'] as $benefit ) : ?>
									<article class="playdate-benefit-card">
										<?php if ( ! empty( $benefit['heading'] ) ) : ?>
											<h3><?php echo esc_html( $benefit['heading'] ); ?></h3>
										<?php endif; ?>
										<?php if ( ! empty( $benefit['description'] ) ) : ?>
											<div class="playdate-richtext"><?php echo wp_kses_post( $benefit['description'] ); ?></div>
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
			<section class="playdate-section playdate-programs" aria-labelledby="playdate-programs-title">
				<?php
				$program_background_id = $image_id( $programs['background_image'] ?? 0 );
				if ( $program_background_id ) {
					echo wp_get_attachment_image( $program_background_id, 'full', false, array( 'class' => 'playdate-programs__background', 'loading' => 'lazy', 'alt' => '' ) );
				}
				?>
				<div class="playdate-container playdate-programs__layout">
					<div>
						<?php if ( ! empty( $programs['heading'] ) ) : ?>
							<h2 id="playdate-programs-title"><?php echo esc_html( $programs['heading'] ); ?></h2>
						<?php endif; ?>
						<?php if ( ! empty( $programs['list_program'] ) ) : ?>
							<div class="playdate-program-list">
								<?php foreach ( $programs['list_program'] as $program ) : ?>
									<article class="playdate-program-card">
										<?php
										$program_image_id = $image_id( $program['card_image'] ?? 0 );
										if ( $program_image_id ) {
											echo wp_get_attachment_image( $program_image_id, 'thumbnail', false, array( 'class' => 'playdate-program-card__icon', 'loading' => 'lazy' ) );
										}
										?>
										<div>
											<?php if ( ! empty( $program['heading_card'] ) ) : ?>
												<h3><?php echo esc_html( $program['heading_card'] ); ?></h3>
											<?php endif; ?>
											<?php if ( ! empty( $program['description_card'] ) ) : ?>
												<div class="playdate-richtext"><?php echo wp_kses_post( $program['description_card'] ); ?></div>
											<?php endif; ?>
										</div>
									</article>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
					<?php
					$program_banner_id = $image_id( $programs['banner'] ?? 0 );
					if ( $program_banner_id ) {
						echo wp_get_attachment_image( $program_banner_id, 'large', false, array( 'class' => 'playdate-programs__banner', 'loading' => 'lazy' ) );
					}
					?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $users ) : ?>
			<section class="playdate-section playdate-users" aria-labelledby="playdate-users-title">
				<div class="playdate-container playdate-copy playdate-copy--center">
					<?php if ( ! empty( $users['heading'] ) ) : ?>
						<h2 id="playdate-users-title"><?php echo esc_html( $users['heading'] ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $users['description'] ) ) : ?>
						<div class="playdate-richtext"><?php echo wp_kses_post( $users['description'] ); ?></div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $advantage ) : ?>
			<section class="playdate-section playdate-advantage" aria-labelledby="playdate-advantage-title">
				<div class="playdate-container playdate-advantage__layout">
					<?php
					$advantage_banner_id = $image_id( $advantage['banner'] ?? 0 );
					if ( $advantage_banner_id ) {
						echo wp_get_attachment_image( $advantage_banner_id, 'large', false, array( 'class' => 'playdate-advantage__image', 'loading' => 'lazy' ) );
					}
					?>
					<div>
						<?php if ( ! empty( $advantage['heading'] ) ) : ?>
							<h2 id="playdate-advantage-title"><?php echo esc_html( $advantage['heading'] ); ?></h2>
						<?php endif; ?>
						<?php if ( ! empty( $advantage['description'] ) ) : ?>
							<div class="playdate-richtext"><?php echo wp_kses_post( $advantage['description'] ); ?></div>
						<?php endif; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $schedule ) : ?>
			<section class="playdate-section playdate-schedule" aria-labelledby="playdate-schedule-title">
				<div class="playdate-container playdate-schedule__panel">
					<div class="playdate-copy playdate-copy--center">
						<?php if ( ! empty( $schedule['heading'] ) ) : ?>
							<h2 id="playdate-schedule-title"><?php echo esc_html( $schedule['heading'] ); ?></h2>
						<?php endif; ?>
						<?php if ( ! empty( $schedule['description'] ) ) : ?>
							<div class="playdate-richtext"><?php echo wp_kses_post( $schedule['description'] ); ?></div>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $schedule['schedule_gallery'] ) ) : ?>
						<div class="playdate-schedule__gallery">
							<?php foreach ( $schedule['schedule_gallery'] as $schedule_image ) : ?>
								<?php
								$schedule_image_id = $image_id( $schedule_image );
								if ( $schedule_image_id ) {
									echo wp_get_attachment_image( $schedule_image_id, 'medium', false, array( 'class' => 'playdate-schedule__image', 'loading' => 'lazy' ) );
								}
								?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $schedule['ending_text'] ) ) : ?>
						<div class="playdate-richtext playdate-schedule__ending"><?php echo wp_kses_post( $schedule['ending_text'] ); ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $schedule['label_cta'] ) && $schedule_cta ) : ?>
						<a class="playdate-button" href="<?php echo esc_url( $schedule_cta ); ?>"><?php echo esc_html( $schedule['label_cta'] ); ?> <span aria-hidden="true">→</span></a>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $teachers ) : ?>
			<section class="playdate-section playdate-teachers" aria-labelledby="playdate-teachers-title">
				<div class="playdate-container">
					<div class="playdate-copy playdate-copy--center">
						<?php if ( ! empty( $teachers['heading'] ) ) : ?>
							<h2 id="playdate-teachers-title"><?php echo esc_html( $teachers['heading'] ); ?></h2>
						<?php endif; ?>
						<?php if ( ! empty( $teachers['description'] ) ) : ?>
							<div class="playdate-richtext"><?php echo wp_kses_post( $teachers['description'] ); ?></div>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $teachers['teacher_card_item'] ) ) : ?>
						<div class="playdate-teacher-grid">
							<?php foreach ( $teachers['teacher_card_item'] as $teacher ) : ?>
								<article class="playdate-teacher-card">
									<?php
									$teacher_image_id = $image_id( $teacher['teacher_image'] ?? 0 );
									if ( $teacher_image_id ) {
										echo wp_get_attachment_image( $teacher_image_id, 'medium_large', false, array( 'class' => 'playdate-teacher-card__image', 'loading' => 'lazy' ) );
									}
									?>
									<div class="playdate-teacher-card__body">
										<?php if ( ! empty( $teacher['teacher_name'] ) ) : ?>
											<h3><?php echo esc_html( $teacher['teacher_name'] ); ?></h3>
										<?php endif; ?>
										<?php if ( ! empty( $teacher['teacher_bio'] ) ) : ?>
											<div class="playdate-richtext"><?php echo wp_kses_post( $teacher['teacher_bio'] ); ?></div>
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
			<section id="pricing" class="playdate-section playdate-pricing" aria-labelledby="playdate-pricing-title">
				<?php
				$pricing_background_id = $image_id( $pricing['background_image'] ?? 0 );
				if ( $pricing_background_id ) {
					echo wp_get_attachment_image( $pricing_background_id, 'full', false, array( 'class' => 'playdate-pricing__background', 'loading' => 'lazy', 'alt' => '' ) );
				}
				$price_card = (array) ( $pricing['pricing_card'] ?? array() );
				?>
				<div class="playdate-container playdate-pricing__content">
					<div class="playdate-copy playdate-copy--center">
						<?php if ( ! empty( $pricing['heading'] ) ) : ?>
							<h2 id="playdate-pricing-title"><?php echo esc_html( $pricing['heading'] ); ?></h2>
						<?php endif; ?>
						<?php if ( ! empty( $pricing['description'] ) ) : ?>
							<div class="playdate-richtext"><?php echo wp_kses_post( $pricing['description'] ); ?></div>
						<?php endif; ?>
					</div>
					<?php if ( $price_card ) : ?>
						<div class="playdate-price-card">
							<?php if ( $has_value( $price_card['heading_card'] ?? '' ) ) : ?>
								<h3><?php echo esc_html( $price_card['heading_card'] ); ?></h3>
							<?php endif; ?>
							<?php if ( $has_value( $price_card['pricing_compare'] ?? '' ) ) : ?>
								<del><?php echo esc_html( $price_card['pricing_compare'] ); ?></del>
							<?php endif; ?>
							<?php if ( $has_value( $price_card['pricing_discount'] ?? '' ) ) : ?>
								<strong class="playdate-price-card__price"><?php echo esc_html( $price_card['pricing_discount'] ); ?></strong>
							<?php endif; ?>
							<?php if ( $has_value( $price_card['discount_label'] ?? '' ) ) : ?>
								<span class="playdate-price-card__label"><?php echo esc_html( $price_card['discount_label'] ); ?></span>
							<?php endif; ?>
							<?php if ( $has_value( $price_card['list_package'] ?? '' ) ) : ?>
								<div class="playdate-richtext playdate-price-card__features"><?php echo wp_kses_post( $price_card['list_package'] ); ?></div>
							<?php endif; ?>
							<?php if ( ! empty( $price_card['label_cta'] ) && ! empty( $price_card['url_cta'] ) ) : ?>
								<a class="playdate-button" href="<?php echo esc_url( $price_card['url_cta'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $price_card['label_cta'] ); ?> <span aria-hidden="true">→</span></a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>
	</main>

	<?php
endwhile;

get_footer();
