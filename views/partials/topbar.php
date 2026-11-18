<?php
/**
 * Sticky branded top bar.
 *
 * @package MeetupRsvpDesk
 *
 * @var string $tab Current tab slug.
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="mrd-topbar">
	<div class="mrd-topbar-brand">
		<a href="<?php echo esc_url( mrd_page_url() ); ?>" class="mrd-topbar-home">
			<span class="mrd-topbar-icon" aria-hidden="true">
				<svg width="16" height="16" viewBox="0 0 24 24"><path fill="#fff" d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2.5a2.5 2.5 0 0 0 0 5V17a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2.5a2.5 2.5 0 0 0 0-5V7zm11 0v2h2V7h-2zm0 4v2h2v-2h-2zm0 4v2h2v-2h-2z"/></svg>
			</span>
			<span class="mrd-topbar-name"><?php esc_html_e( 'Meetup RSVP Desk', 'meetup-rsvp-desk' ); ?></span>
		</a>
		<span class="mrd-version-badge">v<?php echo esc_html( MRD_VERSION ); ?></span>
	</div>
	<nav class="mrd-topbar-links" aria-label="<?php esc_attr_e( 'Plugin links', 'meetup-rsvp-desk' ); ?>">
		<a href="<?php echo esc_url( mrd_page_url( array( 'tab' => 'attendees' ) ) ); ?>"><?php esc_html_e( 'Attendees', 'meetup-rsvp-desk' ); ?></a>
		<a href="<?php echo esc_url( mrd_page_url( array( 'tab' => 'settings' ) ) ); ?>"><?php esc_html_e( 'Settings', 'meetup-rsvp-desk' ); ?></a>
		<a href="https://lumumbas-blog.co.ke" target="_blank" rel="noopener"><?php esc_html_e( 'Lumumba\'s Blog', 'meetup-rsvp-desk' ); ?></a>
	</nav>
</div>
