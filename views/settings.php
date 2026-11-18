<?php
/**
 * Settings tab.
 *
 * @package MeetupRsvpDesk
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="mrd-grid">

	<div class="mrd-main">
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="mrd_save_settings">
			<?php wp_nonce_field( 'mrd_save_settings' ); ?>

			<div class="mrd-section">
				<div class="mrd-section-label"><?php esc_html_e( 'Event details', 'meetup-rsvp-desk' ); ?></div>
				<table class="form-table mrd-form-table" role="presentation">
					<tr>
						<th scope="row"><label for="mrd-event-name"><?php esc_html_e( 'Event name', 'meetup-rsvp-desk' ); ?></label></th>
						<td>
							<input type="text" id="mrd-event-name" name="event_name" class="mrd-input mrd-input--wide" value="<?php echo esc_attr( get_option( 'mrd_event_name', '' ) ); ?>" placeholder="<?php esc_attr_e( 'WordPress Nairobi Meetup', 'meetup-rsvp-desk' ); ?>">
							<p class="description"><?php esc_html_e( 'Shown as the page title on the RSVP Desk.', 'meetup-rsvp-desk' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="mrd-capacity"><?php esc_html_e( 'Venue capacity', 'meetup-rsvp-desk' ); ?></label></th>
						<td>
							<input type="number" id="mrd-capacity" name="capacity" class="mrd-input mrd-input--small" min="0" value="<?php echo esc_attr( get_option( 'mrd_capacity', 50 ) ); ?>">
							<p class="description"><?php esc_html_e( 'Maximum number of seats. Set to 0 for unlimited seats.', 'meetup-rsvp-desk' ); ?></p>
						</td>
					</tr>
				</table>
			</div>

			<button type="submit" class="button button-primary"><?php esc_html_e( 'Save settings', 'meetup-rsvp-desk' ); ?></button>
		</form>
	</div>

	<aside class="mrd-sidebar">

		<div class="mrd-card">
			<div class="mrd-card-head">
				<svg width="16" height="16" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
				<h3><?php esc_html_e( 'About', 'meetup-rsvp-desk' ); ?></h3>
			</div>
			<div class="mrd-card-body">
				<p class="mrd-help"><?php esc_html_e( 'RSVP Desk keeps your meetup guest list in one place. Add RSVPs ahead of time, then use the Check in button at the door.', 'meetup-rsvp-desk' ); ?></p>
			</div>
		</div>

		<?php include MRD_DIR . 'views/partials/demo-tools.php'; ?>

	</aside>

</div>
