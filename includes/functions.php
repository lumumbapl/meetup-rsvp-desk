<?php
/**
 * Data and utility helpers.
 *
 * @package MeetupRsvpDesk
 */

defined( 'ABSPATH' ) || exit;

function mrd_get_attendees(): array {
	$attendees = get_option( 'mrd_attendees', array() );
	return is_array( $attendees ) ? array_values( $attendees ) : array();
}

function mrd_save_attendees( array $attendees ): void {
	update_option( 'mrd_attendees', array_values( $attendees ), false );
}

function mrd_ticket_types(): array {
	return array(
		'general' => __( 'General', 'meetup-rsvp-desk' ),
		'student' => __( 'Student', 'meetup-rsvp-desk' ),
		'speaker' => __( 'Speaker', 'meetup-rsvp-desk' ),
	);
}

function mrd_event_name(): string {
	$name = (string) get_option( 'mrd_event_name', '' );
	return '' !== $name ? $name : __( 'WordPress Nairobi Meetup', 'meetup-rsvp-desk' );
}

function mrd_initials( string $name ): string {
	$parts   = preg_split( '/\s+/', trim( $name ) );
	$letters = '';

	foreach ( array_slice( (array) $parts, 0, 2 ) as $part ) {
		$letters .= mb_substr( $part, 0, 1 );
	}

	return mb_strtoupper( $letters );
}

function mrd_page_url( array $args = array() ): string {
	return add_query_arg( $args, admin_url( 'admin.php?page=' . MRD_SLUG ) );
}

function mrd_redirect( string $notice, string $tab = 'attendees' ): void {
	wp_safe_redirect(
		mrd_page_url(
			array(
				'tab'        => $tab,
				'mrd_notice' => $notice,
			)
		)
	);
	exit;
}

function mrd_guard( string $action ): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to do that.', 'meetup-rsvp-desk' ), 403 );
	}
	check_admin_referer( $action );
}
