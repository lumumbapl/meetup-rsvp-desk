<?php
/**
 * Page footer.
 *
 * @package MeetupRsvpDesk
 */

defined( 'ABSPATH' ) || exit;
?>
<footer class="mrd-page-footer">
	<p class="mrd-page-footer__brand">
		<?php esc_html_e( 'Made with', 'meetup-rsvp-desk' ); ?>
		<svg width="14" height="14" viewBox="0 0 24 24" aria-label="<?php esc_attr_e( 'love', 'meetup-rsvp-desk' ); ?>" role="img"><path fill="currentColor" d="M12 21.35 10.55 20C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
		<?php esc_html_e( 'by', 'meetup-rsvp-desk' ); ?>
		<a href="https://lumumbas-blog.co.ke" target="_blank" rel="noopener">Patrick Lumumba</a>
	</p>
	<p class="mrd-page-footer__links">
		<a href="https://lumumbas-blog.co.ke" target="_blank" rel="noopener"><?php esc_html_e( 'Blog', 'meetup-rsvp-desk' ); ?></a>
		<span class="mrd-sep" aria-hidden="true">|</span>
		<a href="https://wordpress.org/support/" target="_blank" rel="noopener"><?php esc_html_e( 'Support', 'meetup-rsvp-desk' ); ?></a>
	</p>
</footer>
