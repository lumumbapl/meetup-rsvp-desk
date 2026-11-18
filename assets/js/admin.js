/**
 * Meetup RSVP Desk: admin behaviour.
 */
( function () {
	'use strict';

	const config = window.mrdConfig || {};

	function bumpCheckedInStat() {
		const stat = document.querySelector( '[data-mrd-stat="checked-in"]' );
		if ( stat ) {
			stat.textContent = String( Number( stat.textContent ) + 1 );
		}
	}

	async function sendCheckIn( button, attendeeId ) {
		button.disabled = true;
		button.textContent = config.checkingLabel;

		const body = new FormData();
		body.append( 'action', 'mrd_check_in' );
		body.append( 'nonce', config.nonce );
		body.append( 'attendee', attendeeId );

		try {
			const response = await fetch( config.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				body,
			} );
			const result = await response.json();

			if ( ! result.success ) {
				throw new Error( result.data?.message || 'Check-in failed' );
			}

			const badge = document.createElement( 'span' );
			badge.className = 'mrd-badge-success';
			badge.textContent = config.checkedInLabel;

			button.closest( 'tr' ).classList.add( 'is-checked-in' );
			button.replaceWith( badge );
			bumpCheckedInStat();
		} catch ( error ) {
			console.error( '[RSVP Desk]', error );
			button.disabled = false;
			button.textContent = config.checkInLabel;
		}
	}

	function onCheckInClick( event ) {
		const button = event.currentTarget;
		const attendeeId = button.dataset.attendeeId.trim();

		sendCheckIn( button, attendeeId );
	}

	document.querySelectorAll( '.mrd-checkin' ).forEach( ( button ) => {
		button.addEventListener( 'click', onCheckInClick );
	} );
} )();
