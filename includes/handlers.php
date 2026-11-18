<?php
/**
 * Form (admin-post) and AJAX handlers.
 *
 * @package MeetupRsvpDesk
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_post_mrd_add_attendee', 'mrd_handle_add_attendee' );
function mrd_handle_add_attendee(): void {
	mrd_guard( 'mrd_add_attendee' );

	$name = sanitize_text_field( $_POST['attendee_name'] ?? '' );
	if ( '' === $name ) {
		mrd_redirect( 'missing_name' );
	}

	$ticket = sanitize_key( wp_unslash( $_POST['ticket_type'] ?? 'general' ) );
	if ( ! array_key_exists( $ticket, mrd_ticket_types() ) ) {
		$ticket = 'general';
	}

	$attendees   = mrd_get_attendees();
	$attendees[] = array(
		'name'       => $name,
		'email'      => sanitize_email( wp_unslash( $_POST['attendee_email'] ?? '' ) ),
		'ticket'     => $ticket,
		'volunteer'  => (bool) $_POST['volunteer'],
		'checked_in' => false,
	);

	mrd_save_attendees( $attendees );
	mrd_redirect( 'added' );
}

add_action( 'admin_post_mrd_delete_attendee', 'mrd_handle_delete_attendee' );
function mrd_handle_delete_attendee(): void {
	mrd_guard( 'mrd_delete_attendee' );

	if ( ! isset( $_GET['row'] ) ) {
		mrd_redirect( 'deleted' );
	}

	$row       = absint( wp_unslash( $_GET['row'] ) );
	$attendees = mrd_get_attendees();

	if ( isset( $attendees[ $row ] ) ) {
		unset( $attendees[ $row ] );
		mrd_save_attendees( $attendees );
	}

	mrd_redirect( 'deleted' );
}

add_action( 'admin_post_mrd_save_settings', 'mrd_handle_save_settings' );
function mrd_handle_save_settings(): void {
	mrd_guard( 'mrd_save_settings' );

	update_option( 'mrd_event_name', sanitize_text_field( wp_unslash( $_POST['event_name'] ?? '' ) ) );
	update_option( 'mrd_capacity', absint( wp_unslash( $_POST['capacity'] ?? 50 ) ) );

	mrd_redirect( 'saved', 'settings' );
}

add_action( 'admin_post_mrd_seed', 'mrd_handle_seed' );
function mrd_handle_seed(): void {
	mrd_guard( 'mrd_seed' );

	$people = array(
		array( 'Wanjiru Kamau', 'wanjiru@example.com', 'general', true ),
		array( 'Brian Otieno', 'brian@example.com', 'speaker', false ),
		array( 'Fatuma Hassan', 'fatuma@example.com', 'student', true ),
		array( 'Kiprop Kibet', '', 'general', false ),
		array( 'Achieng Odhiambo', 'achieng@example.com', 'student', true ),
		array( 'Mohamed Abdi', 'mohamed@example.com', 'general', false ),
		array( 'Njeri Wambui', 'njeri@example.com', 'speaker', true ),
		array( 'Kevin Mutua', '', 'general', false ),
		array( 'Halima Juma', 'halima@example.com', 'student', false ),
		array( 'Daniel Kiplagat', 'daniel@example.com', 'general', true ),
		array( 'Grace Akinyi', 'grace@example.com', 'speaker', false ),
		array( 'Peter Njoroge', 'peter@example.com', 'general', false ),
	);

	$attendees = array();
	foreach ( $people as $person ) {
		$attendees[] = array(
			'name'       => $person[0],
			'email'      => $person[1],
			'ticket'     => $person[2],
			'volunteer'  => $person[3],
			'checked_in' => false,
		);
	}

	mrd_save_attendees( $attendees );
	mrd_redirect( 'seeded' );
}

add_action( 'admin_post_mrd_reset', 'mrd_handle_reset' );
function mrd_handle_reset(): void {
	mrd_guard( 'mrd_reset' );

	delete_option( 'mrd_attendees' );
	delete_option( 'mrd_capacity' );
	delete_option( 'mrd_event_name' );

	mrd_redirect( 'reset' );
}

add_action( 'wp_ajax_mrd_check_in', 'mrd_ajax_check_in' );
function mrd_ajax_check_in(): void {
	check_ajax_referer( 'mrd_check_in', 'nonce' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => __( 'Forbidden.', 'meetup-rsvp-desk' ) ), 403 );
	}

	$index     = absint( wp_unslash( $_POST['attendee'] ?? '' ) );
	$attendees = mrd_get_attendees();

	if ( ! isset( $attendees[ $index ] ) ) {
		wp_send_json_error( array( 'message' => __( 'Attendee not found.', 'meetup-rsvp-desk' ) ), 404 );
	}

	$attendees[ $index ]['checked_in'] = true;
	mrd_save_attendees( $attendees );

	wp_send_json_success( array( 'name' => $attendees[ $index ]['name'] ) );
}
