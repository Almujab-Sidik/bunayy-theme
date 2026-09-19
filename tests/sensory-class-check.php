<?php
/**
 * Run with: php tests/sensory-class-check.php [base-url]
 */

$base = rtrim( $argv[1] ?? 'http://bunayy.test', '/' );
$html = file_get_contents( $base . '/sensory-class/' );

$markers = array(
	'id="sensory-hero-title"',
	'id="sensory-programs-title"',
	'class="sensory-timeline__list"',
	'class="sensory-timeline__arrow"',
	'id="pricing-section"',
);

if ( false === $html ) {
	throw new RuntimeException( 'Sensory Class page could not be loaded.' );
}

foreach ( $markers as $marker ) {
	if ( ! str_contains( $html, $marker ) ) {
		throw new RuntimeException( "Missing page marker: {$marker}" );
	}
}

if ( 5 !== substr_count( $html, 'class="sensory-timeline__arrow"' ) ) {
	throw new RuntimeException( 'Timeline arrows do not match the six configured steps.' );
}

echo "Sensory Class check passed.\n";
