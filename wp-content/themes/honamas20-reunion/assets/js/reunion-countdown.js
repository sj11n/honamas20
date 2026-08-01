document.querySelectorAll( '[data-countdown-target]' ).forEach( (countdown) => {
	const target = new Date( countdown.dataset.countdownTarget ).getTime();
	const units = {
		days: countdown.querySelector( '[data-countdown-days]' ),
		hours: countdown.querySelector( '[data-countdown-hours]' ),
		minutes: countdown.querySelector( '[data-countdown-minutes]' ),
		seconds: countdown.querySelector( '[data-countdown-seconds]' ),
	};

	const update = () => {
		const remaining = Math.max( 0, target - Date.now() );
		const seconds = Math.floor( remaining / 1000 );
		const values = {
			days: Math.floor( seconds / 86400 ),
			hours: Math.floor( ( seconds % 86400 ) / 3600 ),
			minutes: Math.floor( ( seconds % 3600 ) / 60 ),
			seconds: seconds % 60,
		};

		Object.entries( values ).forEach( ( [ key, value ] ) => {
			units[ key ].textContent = String( value ).padStart( 2, '0' );
		} );

		return remaining > 0;
	};

	if ( update() ) {
		const interval = window.setInterval( () => {
			if ( ! update() ) {
				window.clearInterval( interval );
			}
		}, 1000 );
	}
} );
