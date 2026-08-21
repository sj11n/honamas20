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
					details: 'Eigene Autos + Uber',
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
			art: 'beach',
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

	const itemTemplate = ( item ) => `
		<li class="reunion-schedule__item reunion-schedule__item--${ item.tone }">
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
			<p class="reunion-schedule__mic">HONAMAS 20 · Mic Drop</p>
		</div>
	`;
}
