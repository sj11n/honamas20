( function () {
	if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches || ! ( 'IntersectionObserver' in window ) ) {
		return;
	}

	var targets = document.querySelectorAll(
		'.honamas-display-h2, .honamas-milestone, .honamas-honour, .honamas-statement__text, .honamas-story-origin .wp-block-column, .honamas-team-start__panel, .honamas-team-start__image'
	);

	var observer = new IntersectionObserver(
		function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'is-in' );
					observer.unobserve( entry.target );
				}
			} );
		},
		{ rootMargin: '0px 0px -8% 0px', threshold: 0.08 }
	);

	targets.forEach( function ( target, index ) {
		target.classList.add( 'is-reveal' );
		target.style.transitionDelay = ( index % 3 ) * 60 + 'ms';
		observer.observe( target );
	} );
} )();
