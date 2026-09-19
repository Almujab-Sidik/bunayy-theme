<?php
/**
 * Contact form fields, storage, and dashboard display.
 *
 * @package bunayy-theme
 */

/**
 * Return the contact form schema.
 *
 * Add future fields here; the form, validation, storage, and dashboard detail
 * will use the same definition automatically.
 *
 * @return array<string, array<string, mixed>>
 */
function bunayy_contact_form_fields() {
	return array(
		'name'    => array(
			'label'        => __( 'Nama', 'bunayy-theme' ),
			'type'         => 'text',
			'placeholder'  => __( 'Nama Anda', 'bunayy-theme' ),
			'autocomplete' => 'name',
			'required'     => true,
		),
		'email'   => array(
			'label'        => __( 'Email Anda', 'bunayy-theme' ),
			'type'         => 'email',
			'placeholder'  => __( 'Alamat Email Anda', 'bunayy-theme' ),
			'autocomplete' => 'email',
			'required'     => true,
		),
		'message' => array(
			'label'       => __( 'Pesan', 'bunayy-theme' ),
			'type'        => 'textarea',
			'placeholder' => __( 'Tuliskan pesan yang ingin disampaikan', 'bunayy-theme' ),
			'required'    => true,
		),
	);
}

/**
 * Register private messages shown only in the WordPress dashboard.
 */
function bunayy_register_contact_message_post_type() {
	register_post_type(
		'contact_message',
		array(
			'labels'       => array(
				'name'          => __( 'Pesan Kontak', 'bunayy-theme' ),
				'singular_name' => __( 'Pesan Kontak', 'bunayy-theme' ),
				'menu_name'     => __( 'Pesan Kontak', 'bunayy-theme' ),
				'edit_item'     => __( 'Lihat Pesan', 'bunayy-theme' ),
				'not_found'     => __( 'Belum ada pesan.', 'bunayy-theme' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'menu_icon'    => 'dashicons-email-alt2',
			'supports'     => array( 'title' ),
			'capabilities' => array(
				'create_posts' => 'do_not_allow',
			),
			'map_meta_cap' => true,
		)
	);
}
add_action( 'init', 'bunayy_register_contact_message_post_type' );

/**
 * Add the read-only message detail box.
 */
function bunayy_contact_message_meta_boxes() {
	add_meta_box(
		'bunayy-contact-message',
		__( 'Detail Pesan', 'bunayy-theme' ),
		'bunayy_render_contact_message_meta_box',
		'contact_message',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_contact_message', 'bunayy_contact_message_meta_boxes' );

/**
 * Render saved form values in the dashboard.
 *
 * @param WP_Post $post Current message.
 */
function bunayy_render_contact_message_meta_box( $post ) {
	echo '<table class="widefat striped"><tbody>';

	foreach ( bunayy_contact_form_fields() as $field_name => $field ) {
		$value = get_post_meta( $post->ID, '_bunayy_contact_' . $field_name, true );

		echo '<tr>';
		echo '<th scope="row" style="width:180px">' . esc_html( $field['label'] ) . '</th>';
		echo '<td>' . nl2br( esc_html( $value ) ) . '</td>';
		echo '</tr>';
	}

	echo '</tbody></table>';
}

/**
 * Redirect back to the contact page with a result status.
 *
 * @param string $status Result status.
 */
function bunayy_contact_redirect( $status ) {
	$referer = wp_get_referer() ?: home_url( '/contact-us/' );
	$url     = add_query_arg( 'contact_status', $status, remove_query_arg( 'contact_status', $referer ) );

	wp_safe_redirect( $url . '#contact-form' );
	exit;
}

/**
 * Email a saved contact message to the Bunayy administrator.
 *
 * @param array<string, string> $values Sanitized form values.
 * @return bool
 */
function bunayy_send_contact_email( $values ) {
	$lines = array();

	foreach ( bunayy_contact_form_fields() as $field_name => $field ) {
		$lines[] = $field['label'] . ':';
		$lines[] = $values[ $field_name ] ?? '-';
		$lines[] = '';
	}

	$subject = sprintf(
		/* translators: %s: Sender name. */
		__( '[Bunayy] Pesan baru dari %s', 'bunayy-theme' ),
		$values['name'] ?? __( 'pengunjung website', 'bunayy-theme' )
	);
	$headers = array();

	if ( ! empty( $values['email'] ) && is_email( $values['email'] ) ) {
		$headers[] = 'Reply-To: ' . $values['email'];
	}

	return wp_mail( 'admin@bunayy.com', $subject, implode( "\n", $lines ), $headers );
}

/**
 * Validate and save a public contact form submission.
 */
function bunayy_handle_contact_form() {
	if (
		! isset( $_POST['bunayy_contact_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bunayy_contact_nonce'] ) ), 'bunayy_submit_contact' )
	) {
		bunayy_contact_redirect( 'error' );
	}

	// Honeypot: accept silently so bots do not learn how they were blocked.
	if ( ! empty( $_POST['contact_website'] ) ) {
		bunayy_contact_redirect( 'success' );
	}

	$posted = isset( $_POST['bunayy_contact'] ) && is_array( $_POST['bunayy_contact'] )
		? wp_unslash( $_POST['bunayy_contact'] )
		: array();
	$values = array();

	foreach ( bunayy_contact_form_fields() as $field_name => $field ) {
		$raw = $posted[ $field_name ] ?? '';

		if ( 'email' === $field['type'] ) {
			$value = sanitize_email( $raw );
		} elseif ( 'textarea' === $field['type'] ) {
			$value = sanitize_textarea_field( $raw );
		} else {
			$value = sanitize_text_field( $raw );
		}

		if ( ! empty( $field['required'] ) && '' === $value ) {
			bunayy_contact_redirect( 'error' );
		}

		if ( 'email' === $field['type'] && ! is_email( $value ) ) {
			bunayy_contact_redirect( 'error' );
		}

		$values[ $field_name ] = $value;
	}

	$meta_input = array();
	foreach ( $values as $field_name => $value ) {
		$meta_input[ '_bunayy_contact_' . $field_name ] = $value;
	}

	$message_id = wp_insert_post(
		array(
			'post_type'   => 'contact_message',
			'post_status' => 'publish',
			'post_title'  => sprintf(
				/* translators: 1: Sender name, 2: message date. */
				__( '%1$s — %2$s', 'bunayy-theme' ),
				$values['name'] ?? __( 'Pesan baru', 'bunayy-theme' ),
				current_time( 'd M Y, H:i' )
			),
			'meta_input'  => $meta_input,
		),
		true
	);

	if ( is_wp_error( $message_id ) ) {
		bunayy_contact_redirect( 'error' );
	}

	$email_sent = bunayy_send_contact_email( $values );
	update_post_meta( $message_id, '_bunayy_contact_email_sent', $email_sent ? '1' : '0' );

	bunayy_contact_redirect( 'success' );
}
add_action( 'admin_post_nopriv_bunayy_submit_contact', 'bunayy_handle_contact_form' );
add_action( 'admin_post_bunayy_submit_contact', 'bunayy_handle_contact_form' );
