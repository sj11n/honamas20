( () => {
	const player = document.querySelector( '[data-song-player]' );

	if ( ! player ) {
		return;
	}

	const audio = player.querySelector( '[data-song-audio]' );
	const playButton = player.querySelector( '[data-song-play]' );
	const playLabel = player.querySelector( '[data-song-play-label]' );

	if ( ! audio || ! playButton || ! playLabel ) {
		return;
	}

	const setPlaying = ( isPlaying ) => {
		player.classList.toggle( 'is-playing', isPlaying );
		playLabel.textContent = isPlaying ? 'Pause' : 'Play';
		playButton.setAttribute( 'aria-label', isPlaying ? 'Song pausieren' : 'Song abspielen' );
	};

	playButton.addEventListener( 'click', async () => {
		if ( audio.paused ) {
			try {
				await audio.play();
				setPlaying( true );
			} catch ( error ) {
				setPlaying( false );
			}
			return;
		}

		audio.pause();
		setPlaying( false );
	} );

	audio.addEventListener( 'play', () => setPlaying( true ) );
	audio.addEventListener( 'pause', () => setPlaying( false ) );
	audio.addEventListener( 'ended', () => setPlaying( false ) );
} )();
