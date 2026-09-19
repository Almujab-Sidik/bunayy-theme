<?php

$theme    = dirname( __DIR__ );
$template = file_get_contents( $theme . '/page-kids-event-and-space.php' );
$css      = file_get_contents( $theme . '/css/kids-event-and-space.css' );
$script   = file_get_contents( $theme . '/js/kids-event-and-space.js' );

foreach ( array( 'event_sections', 'hero_section', 'package_event', 'sewa_venue', 'partner_collaboration' ) as $marker ) {
	if ( ! str_contains( $template, $marker ) ) {
		throw new RuntimeException( "Missing template marker: {$marker}" );
	}
}

foreach ( array( '.event-hero', '.event-package-grid', '.event-venue', '.event-collaboration' ) as $marker ) {
	if ( ! str_contains( $css, $marker ) ) {
		throw new RuntimeException( "Missing CSS marker: {$marker}" );
	}
}

foreach ( array( 'event-lightbox', 'showModal' ) as $marker ) {
	if ( ! str_contains( $template . $script, $marker ) ) {
		throw new RuntimeException( "Missing lightbox marker: {$marker}" );
	}
}

echo "Kids Event & Space template check passed.\n";
