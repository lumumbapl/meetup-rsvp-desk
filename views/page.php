<?php
/**
 * Admin page shell: topbar, header, tabs, content, footer.
 *
 * @package MeetupRsvpDesk
 *
 * @var string $tab Current tab slug.
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="wrap mrd-wrap">

	<?php include MRD_DIR . 'views/partials/topbar.php'; ?>

	<header class="mrd-page-header">
		<h1 class="mrd-page-title"><?php echo esc_html( mrd_event_name() ); ?></h1>
		<p class="mrd-page-subtitle"><?php esc_html_e( 'Track RSVPs and check people in on the day.', 'meetup-rsvp-desk' ); ?></p>
	</header>

	<hr class="wp-header-end">

	<?php mrd_render_notice(); ?>

	<nav class="mrd-tabs" aria-label="<?php esc_attr_e( 'RSVP Desk sections', 'meetup-rsvp-desk' ); ?>">
		<a href="<?php echo esc_url( mrd_page_url( array( 'tab' => 'attendees' ) ) ); ?>" class="mrd-tab <?php echo 'attendees' === $tab ? 'is-active' : ''; ?>" <?php echo 'attendees' === $tab ? 'aria-current="page"' : ''; ?>><?php esc_html_e( 'Attendees', 'meetup-rsvp-desk' ); ?></a>
		<a href="<?php echo esc_url( mrd_page_url( array( 'tab' => 'settings' ) ) ); ?>" class="mrd-tab <?php echo 'settings' === $tab ? 'is-active' : ''; ?>" <?php echo 'settings' === $tab ? 'aria-current="page"' : ''; ?>><?php esc_html_e( 'Settings', 'meetup-rsvp-desk' ); ?></a>
	</nav>

	<?php include MRD_DIR . 'views/' . ( 'settings' === $tab ? 'settings.php' : 'attendees.php' ); ?>

	<?php include MRD_DIR . 'views/partials/footer.php'; ?>

</div>
