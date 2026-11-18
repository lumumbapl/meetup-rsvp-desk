<?php
/**
 * Admin menu, assets and page rendering.
 *
 * @package MeetupRsvpDesk
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', 'mrd_register_menu' );
function mrd_register_menu(): void {
	add_menu_page(
		__( 'Meetup RSVP Desk', 'meetup-rsvp-desk' ),
		__( 'RSVP Desk', 'meetup-rsvp-desk' ),
		'manage_options',
		MRD_SLUG,
		'mrd_render_page',
		'dashicons-tickets-alt',
		58
	);
}

add_filter( 'plugin_action_links_' . plugin_basename( MRD_FILE ), 'mrd_action_links' );
function mrd_action_links( array $links ): array {
	array_unshift(
		$links,
		sprintf( '<a href="%s">%s</a>', esc_url( mrd_page_url() ), esc_html__( 'Open RSVP Desk', 'meetup-rsvp-desk' ) )
	);
	return $links;
}

add_action( 'admin_enqueue_scripts', 'mrd_enqueue_assets' );
function mrd_enqueue_assets( string $hook ): void {
	if ( 'toplevel_page_' . MRD_SLUG !== $hook ) {
		return;
	}

	wp_enqueue_style( 'mrd-admin', MRD_URL . 'assets/css/admin.css', array(), MRD_VERSION );
	wp_enqueue_script( 'mrd-admin', MRD_URL . 'assets/js/admin.js', array(), MRD_VERSION, true );
	wp_localize_script(
		'mrd-admin',
		'mrdConfig',
		array(
			'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
			'nonce'          => wp_create_nonce( 'mrd_check_in' ),
			'checkInLabel'   => __( 'Check in', 'meetup-rsvp-desk' ),
			'checkingLabel'  => __( 'Checking in...', 'meetup-rsvp-desk' ),
			'checkedInLabel' => __( 'Checked in', 'meetup-rsvp-desk' ),
		)
	);
}

function mrd_current_tab(): string {
	$tab = sanitize_key( wp_unslash( $_GET['tab'] ?? 'attendees' ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	return in_array( $tab, array( 'attendees', 'settings' ), true ) ? $tab : 'attendees';
}

function mrd_render_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$tab = mrd_current_tab();
	include MRD_DIR . 'views/page.php';
}

function mrd_render_notice(): void {
	$messages = array(
		'added'        => array( 'success', __( 'RSVP added.', 'meetup-rsvp-desk' ) ),
		'deleted'      => array( 'success', __( 'Attendee removed.', 'meetup-rsvp-desk' ) ),
		'saved'        => array( 'success', __( 'Settings saved.', 'meetup-rsvp-desk' ) ),
		'seeded'       => array( 'success', __( 'Sample attendees loaded.', 'meetup-rsvp-desk' ) ),
		'reset'        => array( 'success', __( 'Demo data reset.', 'meetup-rsvp-desk' ) ),
		'missing_name' => array( 'error', __( 'Please enter the attendee name.', 'meetup-rsvp-desk' ) ),
	);

	$key = sanitize_key( wp_unslash( $_GET['mrd_notice'] ?? '' ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! isset( $messages[ $key ] ) ) {
		return;
	}

	printf(
		'<div class="notice notice-%1$s is-dismissible"><p>%2$s</p></div>',
		esc_attr( $messages[ $key ][0] ),
		esc_html( $messages[ $key ][1] )
	);
}
