<?php
/**
 * Sidebar card: demo data tools.
 *
 * @package MeetupRsvpDesk
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="mrd-card">
	<div class="mrd-card-head">
		<svg width="16" height="16" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 3C7.58 3 4 4.79 4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7c0-2.21-3.58-4-8-4zm0 2c3.87 0 6 1.5 6 2s-2.13 2-6 2-6-1.5-6-2 2.13-2 6-2zm6 12c0 .5-2.13 2-6 2s-6-1.5-6-2v-2.23c1.61.78 3.72 1.23 6 1.23s4.39-.45 6-1.23V17zm0-5c0 .5-2.13 2-6 2s-6-1.5-6-2V9.77C7.61 10.55 9.72 11 12 11s4.39-.45 6-1.23V12z"/></svg>
		<h3><?php esc_html_e( 'Demo data', 'meetup-rsvp-desk' ); ?></h3>
	</div>
	<div class="mrd-card-body">
		<p class="mrd-help"><?php esc_html_e( 'Replace the list with 12 sample attendees, or wipe everything and start fresh.', 'meetup-rsvp-desk' ); ?></p>
		<div class="mrd-actions">
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="mrd_seed">
				<?php wp_nonce_field( 'mrd_seed' ); ?>
				<button type="submit" class="button mrd-btn-ghost"><?php esc_html_e( 'Load sample attendees', 'meetup-rsvp-desk' ); ?></button>
			</form>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="mrd_reset">
				<?php wp_nonce_field( 'mrd_reset' ); ?>
				<button type="submit" class="mrd-link-danger"><?php esc_html_e( 'Reset demo data', 'meetup-rsvp-desk' ); ?></button>
			</form>
		</div>
	</div>
</div>
