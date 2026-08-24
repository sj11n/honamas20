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
				[ 'MEINI', 'Can’t Stop', 'Red Hot Chili Peppers', 'https://www.youtube.com/results?search_query=Red+Hot+Chili+Peppers+Cant+Stop+official' ],
				[ 'SCHARO', 'Welcome to the Jungle', 'Guns N’ Roses', 'https://www.youtube.com/watch?v=o1tj2zJ2Wvg' ],
				[ 'ULLN', 'Kryptonite', '3 Doors Down', 'https://www.youtube.com/results?search_query=3+Doors+Down+Kryptonite+official' ],
				[ 'SCHÜTI', 'Hier kommt Alex', 'Die Toten Hosen', 'https://www.youtube.com/results?search_query=Die+Toten+Hosen+Hier+kommt+Alex+official' ],
				[ 'ZELLO', 'Let’s Get Ready to Rumble', 'Jock Jams', 'https://www.youtube.com/results?search_query=Jock+Jams+Lets+Get+Ready+To+Rumble' ],
				[ 'WITTI', 'Maneater', 'Nelly Furtado', 'https://www.youtube.com/results?search_query=Nelly+Furtado+Maneater+official' ],
				[ 'MO', 'Love Sensation ’06', 'Loleatta Holloway', 'https://www.youtube.com/results?search_query=Loleatta+Holloway+Love+Sensation+06' ],
				[ 'CARLOS', 'Love Generation', 'Bob Sinclar', 'https://www.youtube.com/results?search_query=Bob+Sinclar+Love+Generation+official' ],
				[ 'EMMEL', 'Beautiful Day', 'U2', 'https://www.youtube.com/results?search_query=U2+Beautiful+Day+official' ],
				[ 'BUDDY', 'Tip Top', 'Tip Top*', 'https://www.youtube.com/results?search_query=Tip+Top+Tip+Top+song' ],
				[ 'ZELLS', 'Let’s Go', 'Samy Deluxe', 'https://www.youtube.com/results?search_query=Samy+Deluxe+Lets+Go' ],
				[ 'TIBS', 'Shake That', 'Eminem feat. Nate Dogg', 'https://www.youtube.com/watch?v=WrjwGPb0Hvw' ],
				[ 'BUBI', 'Fairytale Gone Bad', 'Sunrise Avenue', 'https://www.youtube.com/results?search_query=Sunrise+Avenue+Fairytale+Gone+Bad+official' ],
				[ 'GENERAL', 'The Final Countdown', 'Europe', 'https://www.youtube.com/results?search_query=Europe+The+Final+Countdown+official' ],
				[ 'JAMBO', 'Zeit, dass sich was dreht', 'Herbert Grönemeyer', 'https://www.youtube.com/results?search_query=Herbert+Groenemeyer+Zeit+dass+sich+was+dreht' ],
				[ 'DRAGON', 'Right Here, Right Now', 'Fatboy Slim', 'https://www.youtube.com/results?search_query=Fatboy+Slim+Right+Here+Right+Now+official' ],
				[ 'HUPE', 'Spit', 'Shaka Ponk', 'https://www.youtube.com/results?search_query=Shaka+Ponk+Spit' ],
			],
		},
		{
			label: 'CD 02',
			title: 'Cool Down',
			tone: 'cool',
			tracks: [
				[ 'ZELLO', 'Good Riddance (Time of Your Life)', 'Green Day', 'https://www.youtube.com/results?search_query=Green+Day+Good+Riddance+official' ],
				[ 'GENERAL', 'Sometimes You Can’t Make It on Your Own', 'U2', 'https://www.youtube.com/results?search_query=U2+Sometimes+You+Cant+Make+It+On+Your+Own+official' ],
				[ 'BUDDY', 'Patience', 'Guns N’ Roses', 'https://www.youtube.com/results?search_query=Guns+N+Roses+Patience+official' ],
				[ 'SCHÜTI', 'Hear You Me', 'Jimmy Eat World', 'https://www.youtube.com/results?search_query=Jimmy+Eat+World+Hear+You+Me' ],
				[ 'DRAGON', 'Brothers in Arms', 'Dire Straits', 'https://www.youtube.com/results?search_query=Dire+Straits+Brothers+In+Arms+official' ],
				[ 'JAMBO', 'Ain’t No Mountain High Enough', 'Marvin Gaye & Tammi Terrell', 'https://www.youtube.com/results?search_query=Marvin+Gaye+Tammi+Terrell+Aint+No+Mountain+High+Enough' ],
				[ 'CARLOS', 'Somewhere Over the Rainbow', 'Israel Kamakawiwoʻole', 'https://www.youtube.com/results?search_query=Israel+Kamakawiwoole+Somewhere+Over+The+Rainbow+official' ],
				[ 'SCHARO', 'Millionen Legionen', 'Die Fantastischen Vier', 'https://www.youtube.com/results?search_query=Fantastischen+Vier+Millionen+Legionen' ],
				[ 'EMMEL', 'Sommer unseres Lebens', 'Sebastian Hämer', 'https://www.youtube.com/results?search_query=Sebastian+Haemer+Sommer+unseres+Lebens' ],
				[ 'ULLN', 'Tarzan sucht Jane', 'Rappetoire*', 'https://www.youtube.com/results?search_query=Tarzan+sucht+Jane+Rappetoire' ],
				[ 'WESA', 'Feeling Blue', 'Silicone Soul', 'https://www.youtube.com/results?search_query=Silicone+Soul+Feeling+Blue' ],
				[ 'ZELLS', 'Never Know', 'Jack Johnson', 'https://www.youtube.com/results?search_query=Jack+Johnson+Never+Know' ],
				[ 'BUBI', 'Tell Me Baby', 'Red Hot Chili Peppers', 'https://www.youtube.com/results?search_query=Red+Hot+Chili+Peppers+Tell+Me+Baby+official' ],
				[ 'MEINI', 'Crazy', 'Gnarls Barkley', 'https://www.youtube.com/results?search_query=Gnarls+Barkley+Crazy+official' ],
				[ 'TIBS', 'Klar', 'Jan Delay', 'https://www.youtube.com/results?search_query=Jan+Delay+Klar+official' ],
				[ 'MO', 'Corazón Espinado', 'Santana feat. Maná', 'https://www.youtube.com/results?search_query=Santana+Mana+Corazon+Espinado+official' ],
				[ 'HUPE', 'Alpha Beta Gaga', 'Air', 'https://www.youtube.com/results?search_query=Air+Alpha+Beta+Gaga+official' ],
				[ 'WITTI', 'Lucky', 'Lucky Twice', 'https://www.youtube.com/results?search_query=Lucky+Twice+Lucky+official' ],
			],
		},
		{
			label: 'CD 03',
			title: 'Staff',
			tone: 'staff',
			tracks: [
				[ 'BERNI', 'Goodbye', 'Sasha', 'https://www.youtube.com/results?search_query=Sasha+Goodbye+song' ],
				[ 'TOTTE', 'Real World', 'Matchbox Twenty', 'https://www.youtube.com/results?search_query=Matchbox+Twenty+Real+World+official' ],
				[ 'ANDREW', 'This Is the World', 'The The', 'https://www.youtube.com/results?search_query=The+The+This+Is+The+World' ],
				[ 'BERND', 'Was wollen wir trinken', 'L.A.R.S.*', 'https://www.youtube.com/results?search_query=LARS+Was+wollen+wir+trinken' ],
				[ 'WERNER', 'Video Killed the Radio Star', 'The Buggles', 'https://www.youtube.com/results?search_query=The+Buggles+Video+Killed+The+Radio+Star+official' ],
				[ 'DIDI', 'Pomp and Circumstance', 'Edward Elgar', 'https://www.youtube.com/results?search_query=Edward+Elgar+Pomp+and+Circumstance+March+1' ],
				[ 'SUPERMARIO', 'Schwarz und Weiß', 'Oliver Pocher', 'https://www.youtube.com/results?search_query=Oliver+Pocher+Schwarz+und+Weiss' ],
				[ 'PAPE', 'The Passenger', 'Iggy Pop', 'https://www.youtube.com/results?search_query=Iggy+Pop+The+Passenger+official' ],
				[ 'HANS', 'Song 2', 'Blur', 'https://www.youtube.com/results?search_query=Blur+Song+2+official' ],
				[ 'GERD', 'Another Perfect Day', 'American Hi-Fi', 'https://www.youtube.com/results?search_query=American+HiFi+Another+Perfect+Day' ],
				[ 'KLAUS', 'Viva Colonia', 'Höhner', 'https://www.youtube.com/results?search_query=Hoehner+Viva+Colonia+official' ],
				[ 'MÜCKE', 'Die Eine 2005', 'Die Firma', 'https://www.youtube.com/results?search_query=Die+Firma+Die+Eine+2005+official' ],
				[ 'RAINER', 'Build Me Up Buttercup', 'The Foundations', 'https://www.youtube.com/results?search_query=The+Foundations+Build+Me+Up+Buttercup' ],
				[ 'MAUWU', 'Hungriges Herz', 'MIA.', 'https://www.youtube.com/results?search_query=MIA+Hungriges+Herz+official' ],
				[ 'ENTI', 'T.N.T.', 'AC/DC', 'https://www.youtube.com/results?search_query=ACDC+TNT+official' ],
				[ 'NICI', 'No Tomorrow', 'Orson', 'https://www.youtube.com/results?search_query=Orson+No+Tomorrow+official' ],
				[ 'WITTE', 'Is This the Way to Amarillo', 'Hermes House Band', 'https://www.youtube.com/results?search_query=Hermes+House+Band+Is+This+The+Way+To+Amarillo' ],
			],
		},
	];

	const trackTemplate = ( track, index ) => {
		const [ name, title, artist, url ] = track;

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
