( () => {
	const honstagram = document.querySelector( '[data-honstagram]' );

	if ( ! honstagram ) {
		return;
	}

	const form = honstagram.querySelector( '[data-honstagram-form]' );
	const fileInput = honstagram.querySelector( '#honstagram-images' );
	const submitButton = honstagram.querySelector( '[data-honstagram-submit]' );
	const status = honstagram.querySelector( '[data-honstagram-status]' );
	const selection = honstagram.querySelector( '[data-honstagram-selection]' );
	const progress = honstagram.querySelector( '[data-honstagram-progress]' );
	const progressBar = honstagram.querySelector( '[data-honstagram-progress-bar]' );
	const feed = honstagram.querySelector( '[data-honstagram-feed]' );
	const emptyState = honstagram.querySelector( '[data-honstagram-empty]' );
	const loadMoreWrap = honstagram.querySelector( '[data-honstagram-load-more-wrap]' );
	const loadMoreButton = honstagram.querySelector( '[data-honstagram-load-more]' );
	const sentinel = honstagram.querySelector( '[data-honstagram-sentinel]' );
	const lightbox = honstagram.querySelector( '[data-honstagram-lightbox]' );
	const lightboxImage = honstagram.querySelector( '[data-honstagram-lightbox-image]' );
	const closeLightbox = honstagram.querySelector( '[data-honstagram-close]' );
	const maxFiles = 25;
	const maxFileSize = 12 * 1024 * 1024;
	const maxTotalSize = 100 * 1024 * 1024;

	if ( ! form || ! fileInput || ! submitButton || ! status || ! selection || ! progress || ! progressBar || ! feed || ! loadMoreWrap || ! loadMoreButton || ! sentinel || ! lightbox || ! lightboxImage || ! closeLightbox ) {
		return;
	}

	let isLoadingMore = false;
	let hasMore = honstagram.dataset.hasMore === 'true';
	let nextPage = Number.parseInt( honstagram.dataset.nextPage, 10 ) || 2;

	const updateSelection = () => {
		const selected = fileInput.files.length;
		submitButton.disabled = ! selected || ! form.querySelector( '[name="honstagram_rights"]' ).checked;
		selection.textContent = selected ? `${ selected } ${ selected === 1 ? 'Bild ausgewählt' : 'Bilder ausgewählt' }` : 'JPG, PNG oder WebP · maximal 25 Bilder · jeweils bis 12 MB · zusammen bis 100 MB';
	};

	const addImage = ( image, prepend = false ) => {
		if ( feed.querySelector( `[data-honstagram-id="${ CSS.escape( String( image.id ) ) }"]` ) ) {
			return;
		}

		const tile = document.createElement( 'button' );
		tile.type = 'button';
		tile.className = 'honstagram__tile is-new';
		tile.dataset.honstagramId = image.id;
		tile.dataset.honstagramImage = '';
		tile.dataset.full = image.full;
		tile.dataset.alt = image.alt;
		tile.setAttribute( 'aria-label', 'Bild groß ansehen' );

		const picture = document.createElement( 'img' );
		picture.alt = image.alt;
		picture.loading = 'lazy';
		picture.decoding = 'async';
		picture.src = image.thumbnail;
		tile.append( picture );
		if ( prepend ) {
			feed.prepend( tile );
		} else {
			feed.append( tile );
		}
	};

	const updateLoadMore = () => {
		loadMoreWrap.hidden = ! hasMore;
		loadMoreButton.disabled = isLoadingMore;
		loadMoreButton.textContent = isLoadingMore ? 'Bilder werden geladen …' : 'Weitere Bilder laden';
	};

	const loadMore = async () => {
		if ( isLoadingMore || ! hasMore ) {
			return;
		}

		isLoadingMore = true;
		updateLoadMore();

		try {
			const endpoint = new URL( honstagram.dataset.galleryEndpoint, window.location.origin );
			endpoint.searchParams.set( 'page', String( nextPage ) );
			const response = await window.fetch( endpoint, { credentials: 'same-origin' } );
			const payload = await response.json();

			if ( ! response.ok || ! Array.isArray( payload.images ) ) {
				throw new Error( 'Gallery request failed' );
			}

			payload.images.forEach( ( image ) => addImage( image ) );
			hasMore = Boolean( payload.has_more );
			nextPage = payload.next_page || nextPage + 1;
		} catch ( error ) {
			status.textContent = 'Weitere Bilder konnten gerade nicht geladen werden. Bitte versuche es gleich noch einmal.';
		} finally {
			isLoadingMore = false;
			updateLoadMore();
		}
	};

	const openLightbox = ( tile ) => {
		lightboxImage.src = tile.dataset.full;
		lightboxImage.alt = tile.dataset.alt;
		lightbox.showModal();
		closeLightbox.focus();
	};

	fileInput.addEventListener( 'change', updateSelection );
	form.querySelector( '[name="honstagram_rights"]' ).addEventListener( 'change', updateSelection );

	form.addEventListener( 'submit', ( event ) => {
		event.preventDefault();

		if ( ! fileInput.files.length || fileInput.files.length > maxFiles ) {
			status.textContent = 'Bitte wähle zwischen einem und 25 Bildern aus.';
			return;
		}

		const selectedFiles = Array.from( fileInput.files );
		const tooLarge = selectedFiles.some( ( file ) => file.size > maxFileSize );
		if ( tooLarge ) {
			status.textContent = 'Ein Bild ist größer als 12 MB. Bitte wähle kleinere Dateien aus.';
			return;
		}

		const totalSize = selectedFiles.reduce( ( total, file ) => total + file.size, 0 );
		if ( totalSize > maxTotalSize ) {
			status.textContent = 'Die ausgewählten Bilder sind zusammen größer als 100 MB. Bitte teile sie auf zwei Uploads auf.';
			return;
		}

		const payload = new FormData( form );
		status.textContent = 'Bilder werden hochgeladen …';
		submitButton.disabled = true;
		progress.hidden = false;
		progressBar.style.width = '0%';

		const request = new XMLHttpRequest();
		request.open( 'POST', honstagram.dataset.uploadEndpoint, true );
		request.upload.addEventListener( 'progress', ( progressEvent ) => {
			if ( progressEvent.lengthComputable ) {
				progressBar.style.width = `${ Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ) }%`;
			}
		} );
		request.addEventListener( 'load', () => {
			let response = null;
			try {
				response = JSON.parse( request.responseText );
			} catch ( error ) {}

			if ( request.status >= 200 && request.status < 300 && response?.images ) {
				response.images.forEach( ( image ) => addImage( image, true ) );
				emptyState.hidden = true;
				status.textContent = response.message;
				form.reset();
				updateSelection();
				progressBar.style.width = '100%';
				window.setTimeout( () => { progress.hidden = true; }, 650 );
				return;
			}

			status.textContent = response?.message || 'Der Upload hat nicht funktioniert. Bitte versuche es noch einmal.';
			progress.hidden = true;
			updateSelection();
		} );
		request.addEventListener( 'error', () => {
			status.textContent = 'Der Upload konnte nicht abgeschlossen werden. Bitte prüfe deine Verbindung und versuche es erneut.';
			progress.hidden = true;
			updateSelection();
		} );
		request.send( payload );
	} );

	feed.addEventListener( 'click', ( event ) => {
		const tile = event.target.closest( '[data-honstagram-image]' );
		if ( tile ) {
			openLightbox( tile );
		}
	} );

	loadMoreButton.addEventListener( 'click', loadMore );
	if ( 'IntersectionObserver' in window ) {
		const observer = new IntersectionObserver(
			( entries ) => {
				if ( entries.some( ( entry ) => entry.isIntersecting ) ) {
					loadMore();
				}
			},
			{ rootMargin: '700px 0px' }
		);
		observer.observe( sentinel );
	}
	updateLoadMore();

	closeLightbox.addEventListener( 'click', () => lightbox.close() );
	lightbox.addEventListener( 'click', ( event ) => {
		if ( event.target === lightbox ) {
			lightbox.close();
		}
	} );
} )();
