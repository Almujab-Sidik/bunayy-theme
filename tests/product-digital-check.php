<?php

$url  = $argv[1] ?? 'http://bunayy.test/product-digital/';
$html = @file_get_contents( $url );

if ( false === $html ) {
	throw new RuntimeException( "Cannot load {$url}" );
}

foreach ( array( 'digital-hero', 'digital-about', 'digital-product-card', 'id="digital-products"', 'product-digital.css' ) as $marker ) {
	if ( ! str_contains( $html, $marker ) ) {
		throw new RuntimeException( "Missing marker: {$marker}" );
	}
}

echo "Product Digital page check passed.\n";
