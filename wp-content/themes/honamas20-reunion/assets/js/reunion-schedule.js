const scheduleSection = document.querySelector( '.reunion-program' );

if ( scheduleSection ) {
	const days = [
		{
			date: 'FR · 28. August',
			items: [
				{
					tone: 'blue',
					time: 'Anreise',
					title: 'Individuelle Anreise',
					details: 'Flughafen · Auto · Hotel Zandvoort · direkt zum Stadion',
				},
				{
					tone: 'blue',
					time: '16:00',
					title: 'Abfahrt Zandvoort',
					details: 'Treffpunkt: NH Hotel Zandvoort · eigene Autos + Uber',
				},
				{
					tone: 'red',
					time: '17:30',
					title: 'Warm-up Halbfinale',
					details: 'Am Stadion · Treffpunkt folgt',
				},
				{
					tone: 'navy',
					time: '18:30',
					title: 'Halbfinale',
					details: 'Danach: Cooldown im Stadion',
				},
				{
					tone: 'gold',
					time: '22:30–23:00',
					title: 'Zandvoort',
					details: 'Late Dinner · Ankunft flexibel · Snacks & Drinks zum Ausklang in der Stadt',
				},
				{
					tone: 'navy',
					time: 'Hotel',
					title: 'Lights out',
					details: '',
				},
			],
		},
		{
			date: 'SA · 29. August',
			art: 'padel',
			items: [
				{
					tone: 'gold',
					time: 'ab 07:00',
					title: 'Frühstück',
					details: '',
				},
				{
					tone: 'blue',
					time: '08:45',
					title: 'Abfahrt',
					details: '',
				},
				{
					tone: 'green',
					time: '09:00–12:00',
					title: 'Padel-Turnier',
					details: 'Padel Bloemendaal · Tetterode Sportcomplex · Tetterodeweg 15 · 2051 EG Overveen',
				},
				{
					tone: 'blue',
					time: '12:00',
					title: 'Zurück nach Zandvoort',
					details: '',
				},
				{
					tone: 'gold',
					time: 'Mittag',
					title: 'ZWIMA · Freizeit · Videobesprechung',
					details: '',
				},
				{
					tone: 'red',
					feature: 'beach',
					time: '15:00',
					title: 'Beach-Party',
					details: 'Paal69 · Zandvoort Beach · Food · Get-together · Time for Talk · Party on · Bierchen · Schwimmen',
				},
				{
					tone: 'navy',
					time: 'Open end',
					title: 'Der Abend gehört uns.',
					details: '',
				},
			],
		},
		{
			date: 'SO · 30. August',
			items: [
				{
					tone: 'gold',
					time: 'Morgen',
					title: 'Frühstück',
					details: '',
				},
				{
					tone: 'blue',
					time: 'Danach',
					title: 'Individuelle Abreise',
					details: '',
				},
			],
		},
	];

	const locations = [
		{
			role: 'Halbfinale',
			name: 'Wagener Stadion Amstelveen',
			address: 'Nieuwe Kalfjeslaan 18, 1182 AA Amstelveen',
			url: 'https://www.google.com/maps/search/?api=1&query=Wagener%20Stadion%20Nieuwe%20Kalfjeslaan%2018%20Amstelveen',
		},
		{
			role: 'Hotel & Treffpunkt',
			name: 'NH Hotel Zandvoort',
			address: 'Burgemeester van Alphenstraat 63, 2041 KG Zandvoort',
			url: 'https://www.google.com/maps/search/?api=1&query=Burgemeester%20van%20Alphenstraat%2063%202041%20KG%20Zandvoort',
		},
		{
			role: 'Padel',
			name: 'Padel Bloemendaal',
			address: 'Tetterodeweg 15, 2051 EG Overveen',
			url: 'https://www.google.com/maps/search/?api=1&query=Padel%20Bloemendaal%20Tetterodeweg%2015%202051%20EG%20Overveen',
		},
		{
			role: 'Beach-Party',
			name: 'Paal69',
			address: 'Zuidstrand 3, 2042 AG Zandvoort',
			url: 'https://www.google.com/maps/search/?api=1&query=Paal69%20Zuidstrand%203%202042%20AG%20Zandvoort',
		},
	];

	const itemTemplate = ( item ) => `
		<li class="reunion-schedule__item reunion-schedule__item--${ item.tone }${ item.feature ? ` reunion-schedule__item--feature-${ item.feature }` : '' }">
			<span class="reunion-schedule__dot" aria-hidden="true"></span>
			<div class="reunion-schedule__time">${ item.time }</div>
			<div class="reunion-schedule__copy">
				<h3>${ item.title }</h3>
				${ item.details ? `<p>${ item.details }</p>` : '' }
			</div>
		</li>
	`;

	const dayTemplate = ( day ) => `
		<article class="reunion-schedule__day${ day.art ? ` reunion-schedule__day--${ day.art }` : '' }">
			<header class="reunion-schedule__day-header">
				<span aria-hidden="true">▣</span>
				<h3>${ day.date }</h3>
			</header>
			<ol class="reunion-schedule__list">
				${ day.items.map( itemTemplate ).join( '' ) }
			</ol>
		</article>
	`;

	const locationTemplate = ( location ) => `
		<a class="reunion-location" href="${ location.url }" target="_blank" rel="noopener">
			<span class="reunion-location__role">${ location.role }</span>
			<strong>${ location.name }</strong>
			<span>${ location.address }</span>
			<em>Route öffnen</em>
		</a>
	`;

	scheduleSection.classList.add( 'reunion-schedule' );
	scheduleSection.innerHTML = `
		<div class="reunion-schedule__inner">
			<div class="reunion-schedule__intro">
				<p class="reunion-kicker">Reunion Weekend</p>
				<h2>Der Wochenendplan.</h2>
				<p>28.–30. August 2026: Zandvoort, Amstelveen, Padel, Beach und genug Zeit für alles, was nach 20 Jahren nicht in eine WhatsApp-Nachricht passt.</p>
			</div>
			<div class="reunion-schedule__days">
				${ days.map( dayTemplate ).join( '' ) }
			</div>
			<section class="reunion-locations" id="reunion-locations" aria-labelledby="reunion-locations-title">
				<div class="reunion-locations__intro">
					<p class="reunion-kicker">Locations</p>
					<h3 id="reunion-locations-title">Alle Orte. Ein Tap.</h3>
				</div>
				<div class="reunion-locations__grid">
					${ locations.map( locationTemplate ).join( '' ) }
				</div>
			</section>
			<p class="reunion-schedule__mic">HONAMAS 20 · Mic Drop</p>
		</div>
	`;
}
