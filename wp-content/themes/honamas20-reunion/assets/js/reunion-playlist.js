( () => {
	const mount = document.querySelector( '[data-playlist-youtube]' );

	if ( ! mount ) {
		return;
	}

	const groups = [
		{
			label: 'CD 01',
			title: 'Warm Up',
			tone: 'warm',
			tracks: [
				[ 'WESA', 'Let Me Entertain You', 'Robbie Williams', 'https://www.youtube.com/watch?v=ymPu2PdLW3I' ],
				[ 'MEINI', 'Can’t Stop', 'Red Hot Chili Peppers', 'https://www.youtube.com/watch?v=8DyziWtkfBw' ],
				[ 'SCHARO', 'Welcome to the Jungle', 'Guns N’ Roses', 'https://www.youtube.com/watch?v=o1tj2zJ2Wvg' ],
				[ 'ULLN', 'Kryptonite', '3 Doors Down', 'https://www.youtube.com/watch?v=xPU8OAjjS4k' ],
				[ 'SCHÜTI', 'Hier kommt Alex', 'Die Toten Hosen', 'https://www.youtube.com/watch?v=6z8o7qAIlIU' ],
				[ 'ZELLO', 'Let’s Get Ready to Rumble', 'Jock Jams', 'https://www.youtube.com/watch?v=9p-pDhTyVUs' ],
				[ 'WITTI', 'Maneater', 'Nelly Furtado', 'https://www.youtube.com/watch?v=PLolag3YSYU' ],
				[ 'MO', 'Love Sensation ’06', 'Loleatta Holloway', 'https://www.youtube.com/watch?v=bXitAFXaoic' ],
				[ 'CARLOS', 'Love Generation', 'Bob Sinclar', 'https://www.youtube.com/watch?v=v0NSeysrDYw' ],
				[ 'EMMEL', 'Beautiful Day', 'U2', 'https://www.youtube.com/watch?v=co6WMzDOh1o' ],
				[ 'BUDDY', 'Tip Top', 'Tip Top*', 'https://www.youtube.com/watch?v=VA9sliBH4Vk' ],
				[ 'ZELLS', 'Let’s Go', 'Samy Deluxe', 'https://www.youtube.com/watch?v=B3szPJD20bI' ],
				[ 'TIBS', 'Shake That', 'Eminem feat. Nate Dogg', 'https://www.youtube.com/watch?v=WrjwGPb0Hvw' ],
				[ 'BUBI', 'Fairytale Gone Bad', 'Sunrise Avenue', 'https://www.youtube.com/watch?v=OUyfQLd3bCs' ],
				[ 'GENERAL', 'The Final Countdown', 'Europe', 'https://www.youtube.com/watch?v=9jK-NcRmVcw' ],
				[ 'JAMBO', 'Zeit, dass sich was dreht', 'Herbert Grönemeyer', 'https://www.youtube.com/watch?v=LKi4BlO_ls8' ],
				[ 'DRAGON', 'Right Here, Right Now', 'Fatboy Slim', 'https://www.youtube.com/watch?v=ub747pprmJ8' ],
				[ 'HUPE', 'Spit', 'Shaka Ponk', 'https://www.youtube.com/watch?v=jLRFMLBQv2g' ],
			],
		},
		{
			label: 'CD 02',
			title: 'Cool Down',
			tone: 'cool',
			tracks: [
				[ 'ZELLO', 'Good Riddance (Time of Your Life)', 'Green Day', 'https://www.youtube.com/watch?v=CnQ8N1KacJc' ],
				[ 'GENERAL', 'Sometimes You Can’t Make It on Your Own', 'U2', 'https://www.youtube.com/watch?v=DQZoxlBXBXA' ],
				[ 'BUDDY', 'Patience', 'Guns N’ Roses', 'https://www.youtube.com/watch?v=ErvgV4P6Fzc' ],
				[ 'SCHÜTI', 'Hear You Me', 'Jimmy Eat World', 'https://www.youtube.com/watch?v=fcmFH5OvdtA' ],
				[ 'DRAGON', 'Brothers in Arms', 'Dire Straits', 'https://www.youtube.com/watch?v=jhdFe3evXpk' ],
				[ 'JAMBO', 'Ain’t No Mountain High Enough', 'Marvin Gaye & Tammi Terrell', 'https://www.youtube.com/watch?v=ABfQuZqq8wg' ],
				[ 'CARLOS', 'Somewhere Over the Rainbow', 'Israel Kamakawiwoʻole', 'https://www.youtube.com/watch?v=V1bFr2SWP1I' ],
				[ 'SCHARO', 'Millionen Legionen', 'Die Fantastischen Vier', 'https://www.youtube.com/watch?v=MkPmn6r6518' ],
				[ 'EMMEL', 'Sommer unseres Lebens', 'Sebastian Hämer', 'https://www.youtube.com/watch?v=uvVYghF7MaM' ],
				[ 'ULLN', 'Tarzan sucht Jane', 'Rappetoire*', '' ],
				[ 'WESA', 'Feeling Blue', 'Silicone Soul', 'https://www.youtube.com/watch?v=n-HDtdbyKk8' ],
				[ 'ZELLS', 'Never Know', 'Jack Johnson', 'https://www.youtube.com/watch?v=J25GVE7qV20' ],
				[ 'BUBI', 'Tell Me Baby', 'Red Hot Chili Peppers', 'https://www.youtube.com/watch?v=oDNcL1VP3rY' ],
				[ 'MEINI', 'Crazy', 'Gnarls Barkley', 'https://www.youtube.com/watch?v=-N4jf6rtyuw' ],
				[ 'TIBS', 'Klar', 'Jan Delay', 'https://www.youtube.com/watch?v=3JG6yipKXVA' ],
				[ 'MO', 'Corazón Espinado', 'Santana feat. Maná', 'https://www.youtube.com/watch?v=t6omUxqhG78' ],
				[ 'HUPE', 'Alpha Beta Gaga', 'Air', 'https://www.youtube.com/watch?v=oVMHX8imk_8' ],
				[ 'WITTI', 'Lucky', 'Lucky Twice', 'https://www.youtube.com/watch?v=2UuXld2s6g0' ],
			],
		},
		{
			label: 'CD 03',
			title: 'Staff',
			tone: 'staff',
			tracks: [
				[ 'BERNI', 'Goodbye', 'Sasha', 'https://www.youtube.com/watch?v=sG142MO9swU' ],
				[ 'TOTTE', 'Real World', 'Matchbox Twenty', 'https://www.youtube.com/watch?v=fwJazZIWNgg' ],
				[ 'ANDREW', 'This Is the Day', 'The The', 'https://www.youtube.com/watch?v=Nxazmzy0vAo' ],
				[ 'BERND', 'Was wollen wir trinken', 'L.A.R.S.*', 'https://www.youtube.com/watch?v=PqSR0A-ZZQ8' ],
				[ 'WERNER', 'Video Killed the Radio Star', 'The Buggles', 'https://www.youtube.com/watch?v=W8r-tXRLazs' ],
				[ 'DIDI', 'Pomp and Circumstance', 'Edward Elgar', 'https://www.youtube.com/watch?v=qGIM5HdnY4g' ],
				[ 'SUPERMARIO', 'Schwarz und Weiß', 'Oliver Pocher', 'https://www.youtube.com/watch?v=B9od0nCPwpo' ],
				[ 'PAPE', 'The Passenger', 'Iggy Pop', 'https://www.youtube.com/watch?v=-fWw7FE9tTo' ],
				[ 'HANS', 'Song 2', 'Blur', 'https://www.youtube.com/watch?v=SSbBvKaM6sk' ],
				[ 'GERD', 'Another Perfect Day', 'American Hi-Fi', 'https://www.youtube.com/watch?v=QIzP1nGcHoU' ],
				[ 'KLAUS', 'Viva Colonia', 'Höhner', 'https://www.youtube.com/watch?v=DD9oG1kIC2I' ],
				[ 'MÜCKE', 'Die Eine 2005', 'Die Firma', 'https://www.youtube.com/watch?v=HR00F3VnlcE' ],
				[ 'RAINER', 'Build Me Up Buttercup', 'The Foundations', 'https://www.youtube.com/watch?v=A19350JoiE8' ],
				[ 'MAUWU', 'Hungriges Herz', 'MIA.', 'https://www.youtube.com/watch?v=_FjRy2TiztE' ],
				[ 'ENTI', 'T.N.T.', 'AC/DC', 'https://www.youtube.com/watch?v=CiJeSSzu9Bo' ],
				[ 'NICI', 'No Tomorrow', 'Orson', 'https://www.youtube.com/watch?v=LLmLgJO0utw' ],
				[ 'WITTE', 'Is This the Way to Amarillo', 'Hermes House Band', 'https://www.youtube.com/watch?v=HXEHt5zLr_Q' ],
			],
		},
	];

	const trackTemplate = ( track, index ) => {
		const [ name, title, artist, url ] = track;

		if ( ! url ) {
			return `
				<div class="playlist-youtube-track playlist-youtube-track--missing">
					<span class="playlist-youtube-track__number">${ String( index + 1 ).padStart( 2, '0' ) }</span>
					<span class="playlist-youtube-track__main">
						<strong>${ title }</strong>
						<small>${ artist }</small>
					</span>
					<span class="playlist-youtube-track__name">${ name }</span>
					<span class="playlist-youtube-track__play" aria-hidden="true">Offen</span>
				</div>
			`;
		}

		return `
			<a class="playlist-youtube-track" href="${ url }" target="_blank" rel="noopener">
				<span class="playlist-youtube-track__number">${ String( index + 1 ).padStart( 2, '0' ) }</span>
				<span class="playlist-youtube-track__main">
					<strong>${ title }</strong>
					<small>${ artist }</small>
				</span>
				<span class="playlist-youtube-track__name">${ name }</span>
				<span class="playlist-youtube-track__play" aria-hidden="true">Play</span>
			</a>
		`;
	};

	const groupTemplate = ( group ) => `
		<section class="playlist-youtube-disc playlist-youtube-disc--${ group.tone }">
			<header class="playlist-youtube-disc__header">
				<p>${ group.label }</p>
				<h3>${ group.title }</h3>
			</header>
			<div class="playlist-youtube-disc__tracks">
				${ group.tracks.map( trackTemplate ).join( '' ) }
			</div>
		</section>
	`;

	mount.innerHTML = groups.map( groupTemplate ).join( '' );
} )();
