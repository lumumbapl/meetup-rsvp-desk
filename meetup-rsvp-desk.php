<?php
/**
 * Plugin Name:       Meetup RSVP Desk
 * Description:       Collect RSVPs and check in attendees at your local WordPress meetup.
 * Version:           0.4.0
 * Requires at least: 6.2
 * Requires PHP:      8.0
 * Author:            Patrick Lumumba
 * Author URI:        https://lumumbas-blog.co.ke
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       meetup-rsvp-desk
 *
 * @package MeetupRsvpDesk
 */

defined( 'ABSPATH' ) || exit;

define( 'MRD_VERSION', '0.4.0' );
define( 'MRD_FILE', __FILE__ );
define( 'MRD_DIR', plugin_dir_path( __FILE__ ) );
define( 'MRD_URL', plugin_dir_url( __FILE__ ) );
define( 'MRD_SLUG', 'meetup-rsvp-desk' );

require_once MRD_DIR . 'includes/functions.php';

if ( is_admin() ) {
	require_once MRD_DIR . 'includes/admin.php';
	require_once MRD_DIR . 'includes/handlers.php';
}
