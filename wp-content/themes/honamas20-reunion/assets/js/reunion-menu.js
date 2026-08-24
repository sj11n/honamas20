( () => {
	let menu = document.querySelector( '[data-reunion-mobile-menu]' );
	let toggles = document.querySelectorAll( '[data-reunion-menu-toggle]' );

	if ( ! menu ) {
		const headerInner = document.querySelector( '.honamas-site-header > .wp-block-group' );
		const navigation = document.querySelector( '.honamas-site-header .wp-block-navigation' );
		const navLinks = navigation ? [ ...navigation.querySelectorAll( '.wp-block-navigation-item__content' ) ] : [];

		if ( headerInner && navLinks.length ) {
			const button = document.createElement( 'button' );
			button.className = 'reunion-mobile-menu-button';
			button.type = 'button';
			button.setAttribute( 'aria-controls', 'reunion-mobile-menu' );
			button.setAttribute( 'aria-expanded', 'false' );
			button.setAttribute( 'data-reunion-menu-toggle', '' );
			button.innerHTML = '<span>Menü</span>';

			menu = document.createElement( 'nav' );
			menu.id = 'reunion-mobile-menu';
			menu.className = 'reunion-mobile-menu';
			menu.setAttribute( 'aria-label', 'Mobile Navigation' );
			menu.setAttribute( 'aria-hidden', 'true' );
			menu.setAttribute( 'data-reunion-mobile-menu', '' );
			menu.innerHTML = '<div class="reunion-mobile-menu__bar"><a class="reunion-mobile-menu__home" href="/reunion/20years/">HONAMAS | 20</a><button class="reunion-mobile-menu__close" type="button" aria-label="Menü schließen" data-reunion-menu-toggle></button></div><div class="reunion-mobile-menu__inner"></div>';

			const menuInner = menu.querySelector( '.reunion-mobile-menu__inner' );
			navLinks.forEach( ( link ) => {
				const mobileLink = document.createElement( 'a' );
				mobileLink.href = link.href;
				mobileLink.textContent = link.textContent.trim();
				menuInner.append( mobileLink );
			} );

			headerInner.append( button, menu );
			toggles = document.querySelectorAll( '[data-reunion-menu-toggle]' );
		}
	}

	if ( ! menu || ! toggles.length ) {
		return;
	}

	document.querySelectorAll( '.wp-block-navigation-item__content, .reunion-mobile-menu__inner a' ).forEach( ( link ) => {
		if ( link.textContent.trim() === 'Aktuelles' ) {
			link.textContent = 'News & Updates';
		}
	} );

	const heroButtons = document.querySelector( '.reunion-hero .wp-block-buttons' );
	const hasLocationsButton = heroButtons?.querySelector( 'a[href="#reunion-locations"]' );

	if ( heroButtons && ! hasLocationsButton ) {
		const locationsButton = document.createElement( 'div' );
		locationsButton.className = 'wp-block-button is-style-outline';
		locationsButton.innerHTML = '<a class="wp-block-button__link wp-element-button" href="#reunion-locations">Locations</a>';
		heroButtons.append( locationsButton );
	}

	const links = menu.querySelectorAll( 'a' );
	const openButton = document.querySelector( '.reunion-mobile-menu-button' );
	const closeButton = menu.querySelector( '.reunion-mobile-menu__close' );

	const setOpen = ( isOpen ) => {
		document.body.classList.toggle( 'reunion-menu-open', isOpen );
		menu.setAttribute( 'aria-hidden', isOpen ? 'false' : 'true' );

		toggles.forEach( ( toggle ) => {
			toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		} );

		if ( isOpen ) {
			closeButton?.focus( { preventScroll: true } );
			return;
		}

		openButton?.focus( { preventScroll: true } );
	};

	toggles.forEach( ( toggle ) => {
		toggle.addEventListener( 'click', () => {
			setOpen( ! document.body.classList.contains( 'reunion-menu-open' ) );
		} );
	} );

	links.forEach( ( link ) => {
		link.addEventListener( 'click', () => setOpen( false ) );
	} );

	document.addEventListener( 'keydown', ( event ) => {
		if ( event.key === 'Escape' && document.body.classList.contains( 'reunion-menu-open' ) ) {
			setOpen( false );
		}
	} );
} )();
