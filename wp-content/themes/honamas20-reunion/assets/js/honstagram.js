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
	const lightbox = honstagram.querySelector( '[data-honstagram-lightbox]' );
	const lightboxImage = honstagram.querySelector( '[data-honstagram-lightbox-image]' );
	const closeLightbox = honstagram.querySelector( '[data-honstagram-close]' );

	if ( ! form || ! fileInput || ! submitButton || ! status || ! selection || ! progress || ! progressBar || ! feed || ! lightbox || ! lightboxImage || ! closeLightbox ) {
		return;
	}

	const updateSelection = () => {
		const selected = fileInput.files.length;
		submitButton.disabled = ! selected || ! form.querySelector( '[name="honstagram_rights"]' ).checked;
		selection.textContent = selected ? `${ selected } ${ selected === 1 ? 'Bild ausgewählt' : 'Bilder ausgewählt' }` : 'JPG, PNG oder WebP · maximal 10 Bilder · jeweils bis 12 MB';
	};

	const addImage = ( image ) => {
		const tile = document.createElement( 'button' );
		tile.type = 'button';
		tile.className = 'honstagram__tile is-new';
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
		feed.prepend( tile );
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

		if ( ! fileInput.files.length || fileInput.files.length > 10 ) {
			status.textContent = 'Bitte wähle zwischen einem und zehn Bildern aus.';
			return;
		}

		const tooLarge = Array.from( fileInput.files ).some( ( file ) => file.size > 12 * 1024 * 1024 );
		if ( tooLarge ) {
			status.textContent = 'Ein Bild ist größer als 12 MB. Bitte wähle kleinere Dateien aus.';
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
				response.images.forEach( addImage );
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

	closeLightbox.addEventListener( 'click', () => lightbox.close() );
	lightbox.addEventListener( 'click', ( event ) => {
		if ( event.target === lightbox ) {
			lightbox.close();
		}
	} );
} )();
