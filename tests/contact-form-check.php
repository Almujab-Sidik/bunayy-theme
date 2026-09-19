<?php
/**
 * Run with: php tests/contact-form-check.php [base-url]
 */

$base = rtrim( $argv[1] ?? 'http://bunayy.test', '/' );
$html = file_get_contents( $base . '/contact-us/' );

if (
	false === $html ||
	! str_contains( $html, 'name="bunayy_contact[name]"' ) ||
	! str_contains( $html, 'name="bunayy_contact[email]"' ) ||
	! str_contains( $html, 'name="bunayy_contact[message]"' ) ||
	1 !== preg_match( '/name="bunayy_contact_nonce" value="([^"]+)"/', $html, $match )
) {
	throw new RuntimeException( 'Contact form fields were not rendered.' );
}

$context = stream_context_create(
	array(
		'http' => array(
			'method'        => 'POST',
			'header'        => "Content-Type: application/x-www-form-urlencoded\r\nReferer: {$base}/contact-us/",
			'content'       => http_build_query(
				array(
					'action'               => 'bunayy_submit_contact',
					'bunayy_contact_nonce' => $match[1],
					'bunayy_contact'       => array( 'name' => '', 'email' => 'invalid', 'message' => '' ),
				)
			),
			'follow_location' => 0,
			'ignore_errors' => true,
		),
	)
);

file_get_contents( $base . '/wp-admin/admin-post.php', false, $context );
if ( ! str_contains( implode( "\n", $http_response_header ?? array() ), 'contact_status=error' ) ) {
	throw new RuntimeException( 'Invalid form submission was not rejected.' );
}

require dirname( __DIR__, 4 ) . '/wp-load.php';

$mail = array();
add_filter(
	'pre_wp_mail',
	static function ( $return, $attributes ) use ( &$mail ) {
		$mail = $attributes;
		return true;
	},
	10,
	2
);

$sent = bunayy_send_contact_email(
	array(
		'name'    => 'Bunayy Test',
		'email'   => 'visitor@example.com',
		'message' => 'Test message',
	)
);

if (
	! $sent ||
	'admin@bunayy.com' !== $mail['to'] ||
	! in_array( 'Reply-To: visitor@example.com', $mail['headers'], true )
) {
	throw new RuntimeException( 'Contact email was not prepared correctly.' );
}

echo "Contact form check passed.\n";
