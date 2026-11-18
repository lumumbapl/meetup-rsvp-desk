<?php
/**
 * Attendees tab.
 *
 * @package MeetupRsvpDesk
 */

defined( 'ABSPATH' ) || exit;

$attendees  = mrd_get_attendees();
$types      = mrd_ticket_types();
$capacity   = (int) get_option( 'mrd_capacity', 50 );
$taken      = count( $attendees );
$percent    = (int) round( $taken / $capacity * 100 );
$checked_in = count( array_filter( array_column( $attendees, 'checked_in' ) ) );
$volunteers = count( array_filter( array_column( $attendees, 'volunteer' ) ) );
?>
<div class="mrd-grid">

	<div class="mrd-main">

		<div class="mrd-card mrd-stats">
			<div class="mrd-stat">
				<span class="mrd-stat__label"><?php esc_html_e( 'Seats taken', 'meetup-rsvp-desk' ); ?></span>
				<span class="mrd-stat__number"><?php echo esc_html( $taken ); ?><small> / <?php echo esc_html( $capacity ); ?></small></span>
				<progress class="mrd-progress" max="100" value="<?php echo esc_attr( min( 100, $percent ) ); ?>"><?php echo esc_html( $percent ); ?>%</progress>
				<span class="mrd-stat__hint">
					<?php
					/* translators: %d: percentage of capacity */
					echo esc_html( sprintf( __( '%d%% of venue capacity', 'meetup-rsvp-desk' ), $percent ) );
					?>
				</span>
			</div>
			<div class="mrd-stat">
				<span class="mrd-stat__label"><?php esc_html_e( 'Checked in', 'meetup-rsvp-desk' ); ?></span>
				<span class="mrd-stat__number" data-mrd-stat="checked-in"><?php echo esc_html( $checked_in ); ?></span>
				<span class="mrd-stat__hint">
					<?php
					/* translators: %d: number of RSVPs */
					echo esc_html( sprintf( _n( 'of %d RSVP', 'of %d RSVPs', $taken, 'meetup-rsvp-desk' ), $taken ) );
					?>
				</span>
			</div>
			<div class="mrd-stat">
				<span class="mrd-stat__label"><?php esc_html_e( 'Volunteers', 'meetup-rsvp-desk' ); ?></span>
				<span class="mrd-stat__number"><?php echo esc_html( $volunteers ); ?></span>
				<span class="mrd-stat__hint"><?php esc_html_e( 'helping on the day', 'meetup-rsvp-desk' ); ?></span>
			</div>
		</div>

		<div class="mrd-card">
			<div class="mrd-card-head">
				<svg width="16" height="16" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
				<h3><?php esc_html_e( 'RSVPs', 'meetup-rsvp-desk' ); ?></h3>
				<span class="mrd-count"><?php echo esc_html( $taken ); ?></span>
			</div>

			<?php if ( empty( $attendees ) ) : ?>
				<div class="mrd-empty">
					<svg width="40" height="40" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2.5a2.5 2.5 0 0 0 0 5V17a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2.5a2.5 2.5 0 0 0 0-5V7z"/></svg>
					<h4><?php esc_html_e( 'No RSVPs yet', 'meetup-rsvp-desk' ); ?></h4>
					<p><?php esc_html_e( 'Add your first attendee using the form, or load some sample data to explore.', 'meetup-rsvp-desk' ); ?></p>
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<input type="hidden" name="action" value="mrd_seed">
						<?php wp_nonce_field( 'mrd_seed' ); ?>
						<button type="submit" class="button button-primary"><?php esc_html_e( 'Load sample attendees', 'meetup-rsvp-desk' ); ?></button>
					</form>
				</div>
			<?php else : ?>
				<table class="mrd-table">
					<thead>
						<tr>
							<th scope="col" class="mrd-col-num">#</th>
							<th scope="col"><?php esc_html_e( 'Attendee', 'meetup-rsvp-desk' ); ?></th>
							<th scope="col"><?php esc_html_e( 'Ticket', 'meetup-rsvp-desk' ); ?></th>
							<th scope="col"><?php esc_html_e( 'Volunteer', 'meetup-rsvp-desk' ); ?></th>
							<th scope="col"><?php esc_html_e( 'Status', 'meetup-rsvp-desk' ); ?></th>
							<th scope="col" class="mrd-col-actions"><span class="screen-reader-text"><?php esc_html_e( 'Actions', 'meetup-rsvp-desk' ); ?></span></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $attendees as $index => $attendee ) : ?>
							<?php
							$number     = $index + 1;
							$is_in      = ! empty( $attendee['checked_in'] );
							$delete_url = wp_nonce_url(
								add_query_arg(
									array(
										'action' => 'mrd_delete_attendee',
										'row'    => $number,
									),
									admin_url( 'admin-post.php' )
								),
								'mrd_delete_attendee'
							);
							?>
							<tr class="<?php echo $is_in ? 'is-checked-in' : ''; ?>">
								<td class="mrd-col-num"><?php echo esc_html( $number ); ?></td>
								<td>
									<div class="mrd-person">
										<span class="mrd-avatar" aria-hidden="true"><?php echo esc_html( mrd_initials( $attendee['name'] ) ); ?></span>
										<span class="mrd-person__text">
											<span class="mrd-person__name"><?php echo esc_html( $attendee['name'] ); ?></span>
											<span class="mrd-person__email"><?php echo esc_html( $attendee['email'] ?: __( 'No email', 'meetup-rsvp-desk' ) ); ?></span>
										</span>
									</div>
								</td>
								<td><span class="mrd-pill mrd-pill--<?php echo esc_attr( $attendee['ticket'] ); ?>"><?php echo esc_html( $types[ $attendee['ticket'] ] ?? $attendee['ticket'] ); ?></span></td>
								<td>
									<?php if ( ! empty( $attendee['volunteer'] ) ) : ?>
										<span class="mrd-pill mrd-pill--volunteer"><?php esc_html_e( 'Yes', 'meetup-rsvp-desk' ); ?></span>
									<?php else : ?>
										<span class="mrd-muted">-</span>
									<?php endif; ?>
								</td>
								<td>
									<?php if ( $is_in ) : ?>
										<span class="mrd-badge-success"><?php esc_html_e( 'Checked in', 'meetup-rsvp-desk' ); ?></span>
									<?php else : ?>
										<button type="button" class="button mrd-btn-ghost mrd-checkin" data-attendee="<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Check in', 'meetup-rsvp-desk' ); ?></button>
									<?php endif; ?>
								</td>
								<td class="mrd-col-actions"><a href="<?php echo esc_url( $delete_url ); ?>" class="mrd-link-danger mrd-remove"><?php esc_html_e( 'Remove', 'meetup-rsvp-desk' ); ?></a></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>

	</div>

	<aside class="mrd-sidebar">

		<div class="mrd-card">
			<div class="mrd-card-head">
				<svg width="16" height="16" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
				<h3><?php esc_html_e( 'Add an RSVP', 'meetup-rsvp-desk' ); ?></h3>
			</div>
			<div class="mrd-card-body">
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="mrd-form">
					<input type="hidden" name="action" value="mrd_add_attendee">
					<?php wp_nonce_field( 'mrd_add_attendee' ); ?>

					<div class="mrd-field">
						<label for="mrd-name"><?php esc_html_e( 'Name', 'meetup-rsvp-desk' ); ?> <span class="mrd-required" aria-hidden="true">*</span></label>
						<input type="text" id="mrd-name" name="attendee_name" class="mrd-input" autocomplete="off" required>
					</div>

					<div class="mrd-field">
						<label for="mrd-email"><?php esc_html_e( 'Email', 'meetup-rsvp-desk' ); ?></label>
						<input type="email" id="mrd-email" name="attendee_email" class="mrd-input" autocomplete="off">
					</div>

					<div class="mrd-field">
						<label for="mrd-ticket"><?php esc_html_e( 'Ticket type', 'meetup-rsvp-desk' ); ?></label>
						<select id="mrd-ticket" name="ticket_type" class="mrd-select">
							<?php foreach ( $types as $value => $label ) : ?>
								<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="mrd-field">
						<label class="mrd-toggle">
							<input type="checkbox" name="volunteer" value="1">
							<span class="mrd-toggle__track" aria-hidden="true"></span>
							<span class="mrd-toggle__label"><?php esc_html_e( 'Wants to volunteer on the day', 'meetup-rsvp-desk' ); ?></span>
						</label>
					</div>

					<button type="submit" class="button button-primary mrd-btn-block"><?php esc_html_e( 'Add RSVP', 'meetup-rsvp-desk' ); ?></button>
				</form>
			</div>
		</div>

		<?php include MRD_DIR . 'views/partials/demo-tools.php'; ?>

	</aside>

</div>
