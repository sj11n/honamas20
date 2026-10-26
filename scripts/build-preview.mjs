#!/usr/bin/env node
// Builds the chapter and detail pages of the static preview into preview/.
// The start page (preview/index.html) is hand-written; these pages share its CSS and JS.
import { writeFileSync } from "node:fs";
import { fileURLToPath } from "node:url";
import path from "node:path";

const out = path.join(path.dirname(fileURLToPath(import.meta.url)), "..", "preview");

const chapters = [
	{ slug: "die-idee", nav: "Die Idee", title: "Die Idee" },
	{ slug: "2006-von-der-idee-zur-umsetzung", nav: "2006: Von der Idee zur Umsetzung", title: "2006: Von der Idee zur Umsetzung" },
	{ slug: "die-jahre-danach", nav: "Die Jahre danach", title: "Die Jahre danach" },
	{ slug: "wie-aus-dem-namen-eine-marke-wurde", nav: "Wie aus dem Namen eine Marke wurde", title: "Wie aus dem Namen eine Marke wurde" },
	{ slug: "markenschutz-eine-spaete-anerkennung", nav: "Markenschutz: eine späte Anerkennung", title: "Markenschutz: eine späte Anerkennung" },
];

const header = () => `<a class="skip" href="#inhalt">Zum Inhalt</a>
<header class="site-header">
	<a class="brand" href="index.html" aria-label="HONAMAS, Startseite">HONAMAS</a>
	<nav class="nav" aria-label="Hauptnavigation">
		<a href="index.html#geschichte">Geschichte</a>
		<a href="honama.html">Der Honama</a>
		<a href="die-ur-honamas.html">Ur-HONAMAS</a>
		<a href="erfolge.html">Erfolge</a>
		<a class="button" href="film.html">Film ansehen</a>
	</nav>
	<details class="menu">
		<summary>Menü</summary>
		<div class="menu-panel">
			<a href="index.html#geschichte">Geschichte</a>
			<a href="honama.html">Der Honama</a>
			<a href="die-ur-honamas.html">Ur-HONAMAS</a>
			<a href="erfolge.html">Erfolge</a>
			<a class="button" href="film.html">Film ansehen</a>
		</div>
	</details>
</header>`;

const footer = () => `<div class="close on-dark">
<footer class="site-footer">
	<div class="foot-cols">
		<ul><li>HONAMAS</li><li>Champions since 2006</li><li>Der Name der deutschen Herren-Hockey-Nationalmannschaft</li></ul>
		<ul><li>Lesen</li>${chapters.map((c) => `<li><a href="${c.slug}.html">${c.nav}</a></li>`).join("")}</ul>
		<ul><li>Mehr</li><li><a href="honama.html">Der Honama</a></li><li><a href="die-ur-honamas.html">Die Ur-HONAMAS</a></li><li><a href="erfolge.html">Erfolge</a></li><li><a href="film.html">Der Film</a></li><li><a href="https://www.instagram.com/honamas_hockey/">@honamas_hockey</a></li></ul>
		<ul><li>Rechtliches</li><li><a href="#">Kontakt</a></li><li><a href="impressum.html">Impressum</a></li><li><a href="#">Datenschutz</a></li></ul>
	</div>
	<div></div>
	<div>
		<div class="foot-word" id="footWord" aria-hidden="true">
			<svg viewBox="0 0 1000 142" xmlns="http://www.w3.org/2000/svg" focusable="false"><text x="0" y="136" textLength="1000" lengthAdjust="spacingAndGlyphs" fill="currentColor" font-family="Montserrat, Arial, sans-serif" font-weight="800" font-size="190">HONAMAS</text></svg>
		</div>
		<p class="foot-legal">© 2026 HONAMAS</p>
	</div>
</footer>
</div>`;

const page = (slug, title, desc, body) => {
	writeFileSync(path.join(out, `${slug}.html`), `<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>${title} – HONAMAS</title>
<meta name="description" content="${desc}">
<link rel="preload" href="assets/fonts/montserrat-latin-800-normal.woff2" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="site.css">
<script>document.documentElement.classList.add('js')</script>
</head>
<body>
${header()}
<main id="inhalt">
${body}
</main>
${footer()}
<script src="site.js"></script>
</body>
</html>
`);
};

const img = (src, w, h, alt, extra = "") => `<img src="assets/img/${src}" width="${w}" height="${h}" loading="lazy" alt="${alt}" style="max-width:${w}px"${extra}>`;
const fig = (src, w, h, alt, cap) => `<figure class="prose-fig" data-r>${img(src, w, h, alt)}${cap ? `<figcaption class="small">${cap}</figcaption>` : ""}</figure>`;
const p = (t) => `<p data-r>${t}</p>`;
const h2 = (t) => `<h2 class="prose-h" data-r>${t}</h2>`;
const pull = (t) => `<blockquote class="pull${t.length > 110 ? " long" : ""}" data-r>${t}</blockquote>`;

const chapterPage = ({ slug, title, desc, quote, cite, lead, body }) => {
	const i = chapters.findIndex((c) => c.slug === slug);
	const prev = chapters[i - 1];
	const next = chapters[i + 1];
	const nav = chapters.map((c) => (c.slug === slug
		? `<li><a class="bar-link is-current" href="${c.slug}.html" aria-current="page">${c.nav}</a></li>`
		: `<li><a class="bar-link" href="${c.slug}.html">${c.nav}</a></li>`)).join("");
	page(slug, title, desc, `<section class="chap-hero on-dark">
	<div class="wrap">
		<h1 data-r>${title}</h1>
		<div class="grid chap-hero-grid">
			<div class="chap-quote" data-r style="--d:1"><blockquote>„${quote}“</blockquote><p class="cite">${cite}</p></div>
			<figure class="chap-lead" data-r style="--d:2">${img(lead.src, lead.w, lead.h, lead.alt, ' fetchpriority="high"').replace(' loading="lazy"', "")}${lead.cap ? `<figcaption class="small">${lead.cap}</figcaption>` : ""}</figure>
		</div>
	</div>
</section>
<section class="section-tight">
	<div class="wrap grid chap-body">
		<nav class="chap-nav" aria-label="Kapitel der Geschichte"><ul>${nav}</ul></nav>
		<article class="prose">
${body}
		</article>
	</div>
</section>
<section class="pager wrap" aria-label="Weiter lesen">
	${prev ? `<a class="pager-link" href="${prev.slug}.html" data-r><span class="pager-title">${prev.nav}</span><span class="small">Vorheriges Kapitel</span></a>` : `<a class="pager-link" href="index.html#geschichte" data-r><span class="pager-title">Die Geschichte</span><span class="small">Zur Übersicht</span></a>`}
	${next ? `<a class="pager-link pager-next" href="${next.slug}.html" data-r style="--d:1"><span class="pager-title">${next.nav}</span><span class="small">Nächstes Kapitel</span></a>` : `<a class="pager-link pager-next" href="die-ur-honamas.html" data-r style="--d:1"><span class="pager-title">Die Ur-HONAMAS</span><span class="small">Weiter</span></a>`}
</section>`);
};

/* ---------- Kapitel 1 ---------- */
chapterPage({
	slug: "die-idee",
	title: "Die Idee",
	desc: "Wie eine Beobachtung auf einer Australienreise zum Namen HONAMAS wurde.",
	quote: "Wir wollten auch einfach so etwas haben.",
	cite: "Björn Emmerling auf die Frage, was der Auslöser war",
	lead: { src: "kookaburras-schild.jpg", w: 347, h: 520, alt: "Fan mit einem selbst gemalten Schild „Let's go Kookaburras“" },
	body: [
		`<div class="fig-row" data-r>${img("menge-1807.jpg", 520, 347, "Spieler vor der vollen Tribüne")}${img("anzeige-2-2.jpg", 520, 347, "Anzeigetafel mit dem Spielstand Deutschland gegen Niederlande, 2 zu 2")}${img("tribuene-1809.jpg", 520, 347, "Fans in der Tribüne mit Deutschlandfahnen")}</div>`,
		p("Die deutsche Hockeynationalmannschaft der Herren ist die erfolgreichste Mannschaft im deutschen olympischen Sport. Zahlreiche Olympiasiege, Welt- und Europameistertitel und Siege bei der Champions Trophy stehen auf der langen Erfolgsliste des Deutschen Hockey-Bundes."),
		p("Aber einen Namen hatte dieses erfolgreiche Team nie. Die Mannschaft wurde im TV und in der Presse immer recht umständlich als „die deutsche Herrenhockey-Nationalmannschaft“ oder „die Nationalmannschaft der Herren im Feldhockey“ beschrieben."),
		p("Das war auch Anfang der 2000er-Jahre noch so, als auf einer Länderspielreise im Vorfeld der Olympischen Spiele in Australien einem der damaligen Spieler des Nationalteams, Björn Emmerling, etwas auffiel, was letztlich die Basis für das Folgende bilden sollte:"),
		p("Wenn man in Australien Sport verfolgt, ist dort überall von den Kookaburras, Wallabies und Hockeyroos zu hören oder zu lesen. Ohne Erklärung, ohne Zusatz: Jeder Zuschauer, Zuhörer oder Leser weiß anscheinend sofort, wer oder was damit gemeint ist."),
		p("Gemeint sind die Herrenhockey-, die Rugby- und die Frauenhockey-Nationalmannschaft. Der Name allein reichte aus."),
		p("Diese einfache Beobachtung ließ ihn nicht mehr los. Warum sollte das für seine Mannschaft im deutschen Hockey nicht auch funktionieren?"),
		pull("Eine Weile blieb die Idee liegen, doch im Vorfeld der Heim-WM 2006 kam sie wieder auf. Der Zeitpunkt war ideal: das größte Turnier im eigenen Land, ein neues Hockeystadion in Mönchengladbach, eine junge, ehrgeizige Mannschaft und ein Moment, in dem Hockey wieder ins Rampenlicht rückte."),
		p("Während eines Vorbereitungs-Trainingslagers in Mönchengladbach stellte Björn seine Idee dem Team vor, in dieser inzwischen legendären Runde im Whirlpool des Wellnessbereiches im Hotel Mercure."),
		p("Sogleich flogen mehrere Namensideen durch den Raum, darunter auch scherzhafte Anlehnungen an Begriffe, die Björn kurz zuvor im Radio gehört hatte. Dort war von der „FuBaNaMa“ die Rede, einer hypothetischen Abkürzung für die Fußball-Nationalmannschaft."),
		pull("Wenn die Fußballer die „FuBaNaMa“ sind, dann sind wir die „HONAMAS“."),
		p("Ein kurzer, prägnanter, sofort verständlicher Name: <strong>HO</strong>ckey<strong>NA</strong>tional<strong>MA</strong>nnschaft, kurz HONAMA."),
		p("Und das S? Es steht für die Mehrzahl: HONAMAS gibt es nie allein, sondern immer nur als Team."),
		`<p class="prose-end" data-r>HONAMAS. Die Grundlage war gelegt.</p>`,
	].join("\n"),
});

/* ---------- Kapitel 2 ---------- */
chapterPage({
	slug: "2006-von-der-idee-zur-umsetzung",
	title: "2006: Von der Idee zur Umsetzung",
	desc: "Wie 2006 aus Name, Logo und Team Identity ein sichtbarer Auftritt wurde, ohne Auftrag und ohne Freigabe.",
	quote: "Dann müssen wir es eben selber machen.",
	cite: "Timo Wess, Jan-Marco Montag und Björn Emmerling, als sie vier Tage vor Beginn der WM 2006 erfuhren, dass seitens des DHB nicht mit Unterstützung zu rechnen war",
	lead: { src: "team-2006.jpg", w: 1600, h: 1100, alt: "Mannschaftsfoto der HONAMAS 2006 mit dem Logo und der Jahreszahl 2006" },
	body: [
		p("Die Heim-WM in Mönchengladbach war der perfekte Zeitpunkt."),
		p("Nach dem Meeting im Whirlpool stellte Björn seine Idee und den Namen offiziell im Team vor. Als HONAMAS wollte man nun auftreten. Die Mannschaft reagierte begeistert. Damit hatte das Team etwas Eigenes, mit dem sich alle Mannschaftsmitglieder identifizieren konnten."),
		p("Auf einer Autofahrt zum nächsten Lehrgang von Mönchengladbach nach München nahm das Konzept Formen an. Im Smart von Mannschaftskollege Tibor Weißenborn, mit dem Laptop auf dem Beifahrersitz, wurden gemeinsam Werte und Eigenschaften definiert, für die diese Mannschaft und damit die HONAMAS stehen sollten."),
		p("Björn schrieb auf dieser Grundlage die Definition, konzipierte die Team Identity und designte das Logo."),
		fig("team-identity.jpg", 1600, 1131, "Folien der Team Identity von 2006", `Die Team Identity von 2006. <a href="assets/docs/honamas-team-identity-2006.pdf">Originaldokument als PDF öffnen</a>`),
		p("Diese Inhalte sind in den Originalunterlagen von 2006 dokumentiert und bis heute das Fundament der Marke HONAMAS."),
		h2("Zum Leben erweckt"),
		`<h3 class="prose-h3" data-r>Die ersten HONAMAS-Shirts</h3>`,
		p("Kurz vor der WM tauchte das HONAMAS-Logo erstmals auf Trainingskleidung auf: auf den Trainingstrikots von TK, groß auf der Brust. Seitdem wurde es in zahlreichen Trainingseinheiten gesichtet."),
		fig("trikot-logo.jpg", 389, 500, "Weißes Trikot mit goldenem HONAMAS-Adler"),
		`<h3 class="prose-h3" data-r>Das Teamoutfit</h3>`,
		p("Zur WM produzierten zwei weitere Mitglieder des WM-Teams, Timo Wess und Jan-Marco Montag, eine ganze Serie an Teamequipment:"),
		`<ul class="prose-list" data-r><li>Jogger</li><li>Hoodie</li><li>Cap</li><li>Bag</li><li>Gürtel</li><li>die legendäre goldbedruckte Unterhose</li></ul>`,
		p("Es war die inoffizielle Teamausstattung und sorgte damals für Diskussionen mit dem Verband, da die vorgeschriebene Ausrüstung der Sponsoren nicht durchgängig getragen wurde."),
		fig("trikot-signiert.jpg", 1060, 553, "Trikot mit HONAMAS-Logo und Unterschriften"),
		`<h3 class="prose-h3" data-r>Der zwölfte Mann</h3>`,
		p("Zusammen mit einem Kölner Hockeyshop organisierte das Team vier Tage vor Beginn der WM den Druck von 1.500 HONAMAS-T-Shirts."),
		p("Die Shirts wurden bei einer Autogrammstunde im Stadion verkauft und waren innerhalb weniger Stunden ausverkauft. Damit hatten die HONAMAS 1.500-mal ihren zwölften Mann als Supporter im Stadion."),
		fig("shirts-2006.jpg", 400, 300, "Drei HONAMAS-Shirts in Rot, Weiß und Grün von 2006"),
		p("Was als Idee im Kopf begann, wurde zu einem sichtbaren Symbol für ein Team, das mehr wollte als nur Titel."),
		`<figure class="prose-fig" data-r><video id="loop" muted loop playsinline preload="metadata" poster="assets/img/hero-tribuene.jpg" aria-label="Ausschnitt aus dem Film über die Heim-WM 2006: Spielszene"><source src="assets/video/wm2006-loop.mp4" type="video/mp4"></video><figcaption class="small">Ausschnitt aus dem Film „HONAMAS 2006 – Der Weg zum Titel“</figcaption></figure>`,
		pull("Am 17. September 2006 folgte dennoch die Krönung: Weltmeister im eigenen Land."),
		fig("buehne-2006.jpg", 1400, 1050, "Spieler mit Medaillen und Deutschlandtrikots auf einer Bühne nach dem WM-Titel", "Ein Sommer, in dem alles zusammenkam."),
	].join("\n"),
});

/* ---------- Kapitel 3 ---------- */
chapterPage({
	slug: "die-jahre-danach",
	title: "Die Jahre danach",
	desc: "Zwischen Vergessen und Wiederentdeckung: warum der Name nach 2006 fast verschwand und 2015 zurückkam.",
	quote: "Es war wichtig, den Spielern zu zeigen, dass der Name aus ihrer Mannschaft entstanden ist – und nicht von außen.",
	cite: "Valentin Altenburg, damaliger Nationaltrainer",
	lead: { src: "insta-2015.jpg", w: 1400, h: 839, alt: "Erster Instagram-Post von honamas_hockey vom 1. Juni 2015: Finally on Instagram", cap: "Der erste Post auf @honamas_hockey, 1. Juni 2015" },
	body: [
		p("Nach dem WM-Titel 2006 ging der sportliche Erfolg weiter."),
		p("Die Mannschaft gewann 2008 in Peking und 2012 in London erneut olympisches Gold. 2011 und 2013 wurde sie Europameister."),
		fig("gold-2012.jpg", 1920, 760, "Die Mannschaft feiert Olympiagold 2012"),
		p("Doch der Name HONAMAS spielte in dieser Zeit kaum eine Rolle."),
		p("Der Deutsche Hockey-Bund hatte die Idee nie wirklich aufgenommen. Obwohl im Umfeld die Bezeichnung „DANAS“ für die Damen entstand, fand die Geschichte der HONAMAS keinen Platz im täglichen Umgang der Herren-Nationalmannschaft."),
		p("Für viele der jüngeren Spieler war der Ursprung des Namens längst nicht mehr präsent."),
		fig("logo-honamas.png", 842, 596, "Das HONAMAS-Logo, ein Adler mit schwarz-rot-goldenen Schwingen"),
		p("Das Logo wurde zwischenzeitlich sogar von Teampsychologen genutzt, um Begriffe und Werte in den Adler zu schreiben. Die Spieler nahmen dies eher als Methode wahr, nicht als Identität. Für viele fühlte es sich nicht nach „ihrem“ Symbol an."),
		pull("Erst 2015 änderte sich das."),
		fig("team-2006.jpg", 1600, 1100, "Das WM-Team 2006 beim Mannschaftsfoto", "Die HONAMAS von 2006"),
		p("Bundestrainer Valentin Altenburg bat Björn zu einem Lehrgang nach Mannheim, um der Mannschaft die ursprüngliche Geschichte der HONAMAS zu erzählen. Viele der Spieler hatten sie vorher nie gehört."),
		p("In diesem Moment wurde klar, dass hinter dem Namen mehr steckt als ein Logo: eine Idee, die aus der Mannschaft selbst entstanden war."),
		p("Dieser Lehrgang war ein Wendepunkt. Die Spieler verstanden wieder, woher der Name kam, warum er gewachsen war und was er bedeutete."),
		p(`Von da an wurde HONAMAS erneut Teil der Identität des Teams und fand sich schließlich auch auf Instagram wieder: <a href="https://www.instagram.com/honamas_hockey/">@honamas_hockey</a>.`),
	].join("\n"),
});

/* ---------- Kapitel 4 ---------- */
chapterPage({
	slug: "wie-aus-dem-namen-eine-marke-wurde",
	title: "Wie aus dem Namen eine Marke wurde",
	desc: "Vom Lehrgang in Mannheim über das erste Trikot 2017 bis zum Sporthilfe-Magazin 2023.",
	quote: "Jambo rief mich an und fragte, ob sie das HONAMAS-Logo aufs Trikot drucken dürfen.",
	cite: "Björn Emmerling über den Anruf von Jan-Marco Montag, 2017 Vertriebsleiter beim DHB-Ausrüster Reece Australia, der daraufhin die Nutzungsrechte für das Logo erhielt",
	lead: { src: "reece-home.jpg", w: 672, h: 840, alt: "Entwurf des Heimtrikots mit HONAMAS-Logo von Reece Australia" },
	body: [
		p("Was 2006 in der Mannschaft begann, war für einige Jahre fast verschwunden und fand erst langsam seinen Weg zurück."),
		p("Nach dem Lehrgang in Mannheim, bei dem den Spielern die Geschichte der HONAMAS erzählt wurde, wurde das Thema wieder lebendig. Der Name tauchte immer häufiger auf:"),
		`<ul class="prose-list" data-r><li>in Artikeln,</li><li>in Interviews,</li><li>auf Instagram,</li><li>auf Trainingskleidung.</li></ul>`,
		p("Aus einer Spieleridee wurde Stück für Stück ein fester Begriff im deutschen Hockey. Mit der Zeit wurde „HONAMAS“ selbstverständlich. Reporter griffen den Namen auf, Fans nutzten ihn in sozialen Medien und auch Partner und Ausrüster begannen, ihn einzusetzen."),
		h2("2017: Das Logo auf dem Trikot"),
		p("2017 war ein besonderer Moment: Das HONAMAS-Logo erschien erstmals offiziell auf den Trikots der Nationalmannschaft, ein echtes Novum."),
		p("Björn überließ dem damaligen Ausrüster Reece Australia ein zeitlich begrenztes Nutzungsrecht für Spiel- und Replikatrikots, verbunden mit einer Beteiligung der Mannschaft an den Verkaufserlösen. Die Marke war damit nicht nur sichtbar, sondern auch ein Wert an sich, von dem das Team direkt profitierte."),
		h2("Das erste Trikot mit dem HONAMAS-Logo"),
		p("Als Vertriebsleiter des DHB-Ausrüsters Reece Australia gehörte Jan-Marco Montag, Weltmeister von 2006, zu den Designern des ersten „richtigen“ HONAMAS-Trikots."),
		`<div class="fig-row" data-r>${img("reece-home.jpg", 672, 840, "Entwurf des Heimtrikots mit HONAMAS-Logo")}${img("reece-away.jpg", 670, 842, "Entwurf des Auswärtstrikots mit HONAMAS-Logo")}${img("trikot-logo2.jpg", 623, 800, "Trikot mit HONAMAS-Logo")}</div>`,
		h2("2023: Der Sonderweg der HONAMAS"),
		p("Im Januar 2023, kurz vor der Weltmeisterschaft, erschien im Sporthilfe-Magazin ein Artikel mit dem Titel „Der Sonderweg der HONAMAS“. Für Magenta TV ist der Einsatz von HONAMAS selbstverständlich."),
		fig("sporthilfe.jpg", 1100, 1467, "Titelseite des Sporthilfe-Magazins: Der Sonderweg der Honamas"),
		p("Damit war klar: Der Name hatte nun wirklich seinen Platz in der Sportwelt gefunden, als Synonym für die deutsche Hockey-Nationalmannschaft der Herren."),
		pull("Aus der Idee war Realität geworden."),
	].join("\n"),
});

/* ---------- Kapitel 5 ---------- */
chapterPage({
	slug: "markenschutz-eine-spaete-anerkennung",
	title: "Markenschutz: eine späte Anerkennung",
	desc: "Wie Björn Emmerling die Marke HONAMAS 2010 anmeldete und 2021 an den DHB übergab.",
	quote: "Die Marke gehörte nie mir. Ich habe sie nur aufbewahrt, bis sie wieder da war, wo sie hingehört – bei der Mannschaft.",
	cite: "Björn Emmerling zur Sicherung der Marke HONAMAS",
	lead: { src: "logo-honamas.png", w: 842, h: 596, alt: "Das HONAMAS-Logo" },
	body: [
		p("Obwohl die Idee längst Teil des deutschen Hockeys war, hatte sich der Verband nie um die formale Absicherung des Namens gekümmert."),
		`<div class="facts" data-r><div class="fact"><span class="fact-date">30. März 2010</span><span>Björn Emmerling meldet die Marke HONAMAS persönlich an, einfach, weil es sonst niemand tat.</span></div><div class="fact"><span class="fact-date">16. Juni 2021</span><span>Der DHB trägt die Marke offiziell ein, 15 Jahre nach ihrer Entstehung.</span></div></div>`,
		p("Elf Jahre lang hielt Björn die Rechte, bevor er sie 2021 geordnet an den DHB übergab."),
		p("Ein spätes, aber wichtiges Zeichen dafür, dass die Idee, die 2006 aus einem Team heraus entstand, ihren festen Platz gefunden hatte."),
		h2("Die Marke im Einsatz"),
		`<div class="fig-row" data-r>${img("reece-home.jpg", 672, 840, "Entwurf des Heimtrikots mit HONAMAS-Logo")}${img("reece-away.jpg", 670, 842, "Entwurf des Auswärtstrikots mit HONAMAS-Logo")}${img("trikot-logo2.jpg", 623, 800, "Trikot mit HONAMAS-Logo")}</div>`,
		fig("sporthilfe.jpg", 1100, 1467, "Titelseite des Sporthilfe-Magazins: Der Sonderweg der Honamas"),
	].join("\n"),
});

/* ---------- Honama ---------- */
page("honama", "Der Honama", "Was ein Honama ist, und wofür die Team Identity der HONAMAS steht.", `<section class="chap-hero on-dark">
	<div class="wrap">
		<h1 data-r>Der Honama</h1>
		<div class="grid chap-hero-grid">
			<div class="chap-quote" data-r style="--d:1"><blockquote>„Mit unserem goldenen Logo auf der Unterhose sind wir Weltmeister geworden – das sagt eigentlich alles über diesen verrückten Sommer 2006.“</blockquote></div>
			<figure class="chap-lead" data-r style="--d:2">${img("team-2006.jpg", 1600, 1100, "Mannschaftsfoto der HONAMAS 2006", "").replace(' loading="lazy"', "")}</figure>
		</div>
	</div>
</section>
<section class="section-tight">
	<div class="wrap grid chap-body">
		<nav class="chap-nav" aria-label="Weitere Seiten"><ul><li><a class="bar-link is-current" href="honama.html" aria-current="page">Der Honama</a></li><li><a class="bar-link" href="die-ur-honamas.html">Die Ur-HONAMAS</a></li><li><a class="bar-link" href="erfolge.html">Erfolge</a></li><li><a class="bar-link" href="film.html">Der Film</a></li></ul></nav>
		<article class="prose">
			<p class="prose-def" data-r><strong>Honama</strong> [haunama:], der; aus dem Deutschen stammend, kurz für HOckeyNAtionalMAnnschaft. Das S steht für die Mehrzahl: Honamas gibt es nie allein, sondern immer nur als Team.</p>
			${fig("logo-honamas.png", 842, 596, "Das HONAMAS-Logo, ein Adler mit schwarz-rot-goldenen Schwingen")}
			${p("Mitteleuropäischer Raubvogel, Gattung der Adler: gefräßig, angriffslustig, clever. <strong>Achtung: Torgefahr!</strong>")}
			${p("Der Honama ist ein intelligenter Raubvogel mit besten körperlichen Voraussetzungen im Vergleich zu ähnlichen Lebewesen. Er verteidigt sein Nest hart und aggressiv. Er kann sein Ziel umkreisen, schlägt dann aber unausrechenbar, blitzschnell und erbarmungslos zu. Er fliegt mit höchster Geschwindigkeit, nimmt meist einfache Wege, kann aber seine Gegner durch Varianten überraschen.")}
			${pull("Er ist nur in der Gruppe erfolgreich und strebt zu höchsten Gipfeln.")}
			${h2("Team Identity")}
			${p("Die HONAMAS sind mehr als nur eine Nationalmannschaft. Sie sind ein Team, das weiß, was es ist und wie es wirken will. Eine Mannschaft mit Charakter: jung, kreativ, mutig, aber diszipliniert und zielstrebig.")}
			${p("Ihr Ziel ist ein gemeinsamer Auftritt, der zeigt, wer sie sind: ein Team, das sich kennt, vertraut und füreinander spielt.")}
			${fig("team-identity.jpg", 1600, 1131, "Folien der Team Identity von 2006", `Die Team Identity von 2006. <a href="assets/docs/honamas-team-identity-2006.pdf">Originaldokument als PDF öffnen</a>`)}
			${p("Auf dem Platz kombinieren sie Struktur mit Freiheit:")}
			${p("In der Abwehr kompromisslos und verlässlich: der <strong>Tower of Power</strong>.")}
			${p("Im Angriff schnell, variabel und gefährlich, nach dem Prinzip <strong>S.V.A.T.: Schnell. Variabel. Aggressiv. Tor.</strong>")}
			${fig("trikot-logo.jpg", 389, 500, "Weißes Trikot mit goldenem HONAMAS-Adler")}
			${pull("So entstand der typische HONAMAS-Stil, der von der Mannschaft gelebt wurde: Hockey mit Herz, Klarheit und Mut.")}
			${p(`Die ganze Entstehung lesen: <a href="2006-von-der-idee-zur-umsetzung.html">2006: Von der Idee zur Umsetzung</a>.`)}
		</article>
	</div>
</section>`);

/* ---------- Team ---------- */
const players = `Ulrich Bubolz|Bubi|bubi
Sebastian Biederlack|Buddy|buddy
Carlos Nevado|Carlito|carlos
Sebastian Draghun|Dragon|dragon
Björn Emmerling|Emmel|emmel
Tim Jessulat|Enti|enti
Eike Duckwitz|General|general
Philipp Crone|Hupe|hupe
Jan-Marco Montag|Jambo|jambo
Niklas Meinert|Meini|meini
Moritz Fürste|Mo|mo
Nicolás Emmerling|Nici|nici
Philipp Witte|Piwi|piwi
Justus Scharowski|Scharo|scharo
Christian Schulte|Schüti|schueti
Tibor Weißenborn|Tibs|tibs
Oliver Hentschel|Ulln|ulln
Timo Wess|Wesa|wesa
Matthias Witthaus|Witti|witti
Philipp Zeller|Zello|zello
Christopher Zeller|Zells|zells`.split("\n").map((l) => l.split("|"));

page("die-ur-honamas", "Die Ur-HONAMAS", "Die HONAMAS von 2006: das Team, mit dem alles begann.", `<section class="chap-hero on-dark">
	<div class="wrap">
		<h1 data-r>Die Ur-HONAMAS</h1>
		<div class="grid chap-hero-grid">
			<div class="chap-quote" data-r style="--d:1">Das Team, mit dem alles begann. 2006 wurden die HONAMAS in Mönchengladbach Weltmeister und legten damit den Grundstein für das, was heute als HONAMAS bekannt ist. Jeder von ihnen hat diesen Namen mit Leben gefüllt.</div>
			<figure class="chap-lead" data-r style="--d:2">${img("team-2006.jpg", 1600, 1100, "Mannschaftsfoto des WM-Teams 2006", "").replace(' loading="lazy"', "")}<figcaption class="small">Trainer 2006: Bernhard Peters</figcaption></figure>
		</div>
	</div>
</section>
<section class="section-tight">
	<div class="wrap">
		<h2 class="roster-h" data-r>Die Spieler</h2>
		<ul class="roster">
${players.map(([n, k, f], i) => `			<li class="roster-item" data-r style="--d:${i % 3}"><img src="assets/img/players/${f}.jpg" width="520" height="520" loading="lazy" alt="Porträt von ${n}, genannt ${k}"><span class="roster-name">${n}</span><span class="roster-nick small">genannt ${k}</span></li>`).join("\n")}
		</ul>
	</div>
</section>`);

/* ---------- Erfolge ---------- */
page("erfolge", "Erfolge", "Welt- und Europameistertitel und Olympiasiege der HONAMAS seit 2006.", `<section class="chap-hero on-dark">
	<div class="wrap">
		<h1 data-r>Titel seit 2006</h1>
		<div class="grid chap-hero-grid">
			<div class="chap-quote" data-r style="--d:1">Weltmeister, Olympiasieger, Europameister: eine Geschichte, die weitergeht.</div>
			<figure class="chap-lead" data-r style="--d:2">${img("gold-2012.jpg", 1920, 760, "Die Mannschaft feiert Olympiagold 2012", "").replace(' loading="lazy"', "")}</figure>
		</div>
	</div>
</section>
<section class="section-tight">
	<div class="wrap grid chap-body">
		<nav class="chap-nav" aria-label="Weitere Seiten"><ul><li><a class="bar-link" href="honama.html">Der Honama</a></li><li><a class="bar-link" href="die-ur-honamas.html">Die Ur-HONAMAS</a></li><li><a class="bar-link is-current" href="erfolge.html" aria-current="page">Erfolge</a></li><li><a class="bar-link" href="film.html">Der Film</a></li></ul></nav>
		<article class="prose">
			<dl class="wins" style="margin-bottom:56px">
				<div class="win" data-r><dt>2006</dt><dd><b>Weltmeister</b> in Mönchengladbach</dd></div>
				<div class="win" data-r><dt>2008</dt><dd><b>Olympiasieger</b> in Peking</dd></div>
				<div class="win" data-r><dt>2011</dt><dd><b>Europameister</b></dd></div>
				<div class="win" data-r><dt>2012</dt><dd><b>Olympiasieger</b> in London</dd></div>
				<div class="win" data-r><dt>2013</dt><dd><b>Europameister</b></dd></div>
				<div class="win" data-r><dt>2023</dt><dd><b>Weltmeister</b></dd></div>
				<div class="win" data-r><dt>2025</dt><dd><b>Europameister</b></dd></div>
				<div class="win" data-r><dt>2026</dt><dd><b>Weltmeister</b>, zwanzig Jahre nach Mönchengladbach</dd></div>
			</dl>
			<div class="fig-row" data-r>${img("team-2006.jpg", 1600, 1100, "Das WM-Team 2006")}${img("buehne-2006.jpg", 1400, 1050, "Spieler mit Medaillen nach dem WM-Titel 2006")}${img("hero-tribuene.jpg", 1800, 1199, "Die Mannschaft vor der vollen Tribüne")}</div>
			${p(`Die Geschichte dahinter: <a href="die-jahre-danach.html">Die Jahre danach</a>.`)}
		</article>
	</div>
</section>`);

/* ---------- Film ---------- */
page("film", "Der Film", "HONAMAS 2006: Der Weg zum Titel. Ein Film über die Heim-WM und die Geburt des Namens.", `<section class="chap-hero on-dark">
	<div class="wrap">
		<h1 data-r>Der Weg zum Titel</h1>
		<div class="grid chap-hero-grid">
			<div class="chap-quote" data-r style="--d:1">Der Film zeigt den besonderen Weg eines Teams, das im eigenen Land Geschichte schrieb.</div>
			<figure class="chap-lead" data-r style="--d:2"><video id="loop" muted loop playsinline preload="metadata" poster="assets/img/hero-tribuene.jpg" aria-label="Ausschnitt aus dem Film über die Heim-WM 2006: Spielszene"><source src="assets/video/wm2006-loop.mp4" type="video/mp4"></video></figure>
		</div>
	</div>
</section>
<section class="section-tight">
	<div class="wrap grid chap-body">
		<nav class="chap-nav" aria-label="Weitere Seiten"><ul><li><a class="bar-link" href="honama.html">Der Honama</a></li><li><a class="bar-link" href="die-ur-honamas.html">Die Ur-HONAMAS</a></li><li><a class="bar-link" href="erfolge.html">Erfolge</a></li><li><a class="bar-link is-current" href="film.html" aria-current="page">Der Film</a></li></ul></nav>
		<article class="prose">
			${p("Er begleitet die deutsche Mannschaft durch die Heim-WM 2006, das letzte Turnier unter Trainer Bernhard Peters, und erzählt, wie auf diesem Weg die HONAMAS entstanden.")}
			${p("Eine Stunde voller Emotionen, Einblicke und Erinnerungen an eine Zeit, in der ein Name geboren wurde, der bis heute für deutschen Hockeysport steht.")}
			${h2("Worum es geht")}
			<ul class="prose-list" data-r><li>der Weg der deutschen Mannschaft durch die Heim-WM 2006</li><li>das letzte Turnier unter Trainer Bernhard Peters</li><li>wie auf diesem Weg die HONAMAS entstanden</li></ul>
			<div class="fig-row">${img("team-2006.jpg", 1600, 1100, "Das WM-Team 2006", " data-r")}${img("buehne-2006.jpg", 1400, 1050, "Spieler mit Medaillen nach dem WM-Titel 2006", " data-r")}${img("shirts-2006.jpg", 400, 300, "Drei HONAMAS-Shirts von 2006", " data-r")}</div>
			<p data-r><a class="button" href="https://www.youtube.com/watch?v=2RjXuKBzjC0">HONAMAS 2006 – Der Weg zum Titel auf YouTube ansehen</a></p>
		</article>
	</div>
</section>`);


/* ---------- Impressum ---------- */
page("impressum", "Impressum", "Impressum sowie Quellen und Bildnachweise der HONAMAS-Website.", `<section class="chap-hero on-dark">
	<div class="wrap">
		<h1 data-r>Impressum</h1>
	</div>
</section>
<section class="section-tight">
	<div class="wrap grid chap-body">
		<article class="prose" style="grid-column: 1 / span 8">
			${h2("Verantwortlich für den Inhalt")}
			${p("[Name, Anschrift und Kontakt des Verantwortlichen: vor dem Launch ergänzen]")}
			${h2("Quellen")}
			<ul class="prose-list" data-r>
				<li>Team Identity der HONAMAS, Originaldokument vom 13. Juli 2006 (<a href="assets/docs/honamas-team-identity-2006.pdf">PDF</a>)</li>
				<li>Markenanmeldung vom 30. März 2010 und Eintragung durch den DHB am 16. Juni 2021</li>
				<li>Sporthilfe-Magazin, Januar 2023: „Der Sonderweg der HONAMAS“</li>
				<li>Film „HONAMAS 2006 – Der Weg zum Titel“ auf YouTube</li>
				<li>Aussagen und Zitate von Björn Emmerling, Timo Wess, Jan-Marco Montag und Valentin Altenburg, wie auf honamas.com dokumentiert (Stand 28. Juli 2026)</li>
			</ul>
			${h2("Bildnachweise")}
			${p("[Fotografen, Rechteinhaber und Quellen aller Bilder und des Filmmaterials: vor dem Launch ergänzen]")}
			${h2("Datenschutz")}
			${p("[Datenschutzerklärung: vor dem Launch ergänzen]")}
		</article>
		<figure class="chap-lead" style="grid-column: 10 / span 3" data-r>${img("logo-honamas.png", 842, 596, "Das HONAMAS-Logo")}</figure>
	</div>
</section>`);

console.log("pages written to", out);
