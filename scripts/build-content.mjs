#!/usr/bin/env node
// Writes the HONAMAS page content as core block markup for the importer in honamas-core
// (wp-admin › Werkzeuge › HONAMAS-Inhalte). After the import the pages live in WordPress and are
// edited there; this script is only the starting content.
//
// Media are referenced as {{id:file}} and {{url:file}}; the importer puts each file into the media
// library once and fills in its ID and URL.
import { writeFileSync, mkdirSync, cpSync, rmSync, existsSync } from "node:fs";
import { fileURLToPath } from "node:url";
import path from "node:path";

const root = path.join(path.dirname(fileURLToPath(import.meta.url)), "..");
const out = path.join(root, "wp-content", "plugins", "honamas-core", "content");
const previewAssets = path.join(root, "preview", "assets");

/* ---------- block helpers ---------- */
const attrs = (o) => (Object.keys(o).length ? " " + JSON.stringify(o) : "");
const cls = (...c) => c.filter(Boolean).join(" ");

const p = (html, className = "") =>
	`<!-- wp:paragraph${attrs(className ? { className } : {})} -->\n<p${className ? ` class="${className}"` : ""}>${html}</p>\n<!-- /wp:paragraph -->`;

const h = (level, html, className = "", anchor = "") => {
	const a = {};
	if (level !== 2) a.level = level;
	if (anchor) a.anchor = anchor;
	if (className) a.className = className;
	return `<!-- wp:heading${attrs(a)} -->\n<h${level}${anchor ? ` id="${anchor}"` : ""} class="${cls("wp-block-heading", className)}">${html}</h${level}>\n<!-- /wp:heading -->`;
};

const group = (inner, { tag = "div", className = "", anchor = "" } = {}) => {
	const a = {};
	if (tag !== "div") a.tagName = tag;
	if (anchor) a.anchor = anchor;
	if (className) a.className = className;
	a.layout = { type: "default" };
	return `<!-- wp:group${attrs(a)} -->\n<${tag}${anchor ? ` id="${anchor}"` : ""} class="${cls("wp-block-group", className)}">${[].concat(inner).join("\n")}</${tag}>\n<!-- /wp:group -->`;
};

const img = (file, alt, { className = "", caption = "" } = {}) =>
	`<!-- wp:image {"id":{{id:${file}}},"sizeSlug":"full","linkDestination":"none"${className ? `,"className":"${className}"` : ""}} -->\n<figure class="${cls("wp-block-image size-full", className)}"><img src="{{url:${file}}}" alt="${alt}" class="wp-image-{{id:${file}}}"/>${caption ? `<figcaption class="wp-element-caption">${caption}</figcaption>` : ""}</figure>\n<!-- /wp:image -->`;

const quote = (html, cite = "", className = "") =>
	`<!-- wp:quote${attrs(className ? { className } : {})} -->\n<blockquote class="${cls("wp-block-quote", className)}">${p(html)}${cite ? `<cite>${cite}</cite>` : ""}</blockquote>\n<!-- /wp:quote -->`;

const list = (items, className = "") =>
	`<!-- wp:list${attrs(className ? { className } : {})} -->\n<ul class="${cls("wp-block-list", className)}">${items.map((i) => `<!-- wp:list-item -->\n<li>${i}</li>\n<!-- /wp:list-item -->`).join("\n")}</ul>\n<!-- /wp:list -->`;

const button = (text, href, className = "") =>
	`<!-- wp:buttons -->\n<div class="wp-block-buttons"><!-- wp:button${attrs(className ? { className } : {})} -->\n<div class="${cls("wp-block-button", className)}"><a class="wp-block-button__link wp-element-button" href="${href}">${text}</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->`;

const video = (file, { poster, className = "", autoplay = true } = {}) => {
	const a = { id: `{{id:${file}}}`, className };
	const v = autoplay ? { autoplay: true, loop: true, muted: true, playsInline: true, controls: false, preload: "auto" } : {};
	const json = JSON.stringify({ ...v, ...a, poster: `{{url:${poster}}}` }).replace(`"{{id:${file}}}"`, `{{id:${file}}}`);
	const flags = autoplay ? " autoplay loop muted" : " controls";
	return `<!-- wp:video ${json} -->\n<figure class="${cls("wp-block-video", className)}"><video${flags} poster="{{url:${poster}}}"${autoplay ? ' preload="auto"' : ""} src="{{url:${file}}}"${autoplay ? " playsinline" : ""}></video></figure>\n<!-- /wp:video -->`;
};

const shortcode = (code) => `<!-- wp:shortcode -->\n${code}\n<!-- /wp:shortcode -->`;
const link = (text, href) => `<a class="textlink" href="${href}">${text}</a>`;

/* ---------- shared chapter frame ---------- */
const chapterHero = (title, quoteText, cite, lead) => group([
	group([
		h(1, title),
		group([
			group([quote(`„${quoteText}“`), p(cite, "cite")], { className: "chap-quote" }),
			lead,
		], { className: "grid chap-hero-grid" }),
	], { className: "wrap" }),
], { tag: "section", className: "chap-hero on-dark" });

const chapterBody = (nav, blocks) => group([
	group([nav, group(blocks, { className: "prose" })], { className: "wrap grid chap-body" }),
], { tag: "section", className: "section-tight" });

const chapterNav = shortcode("[honamas_kapitel_navigation]");
const chapterPager = shortcode("[honamas_kapitel_weiter]");
const moreNav = list([
	`<a href="/der-honama/">Der Honama</a>`,
	`<a href="/die-ur-honamas/">Die Ur-HONAMAS</a>`,
	`<a href="/erfolge/">Erfolge</a>`,
	`<a href="/der-film/">Der Film</a>`,
], "chap-nav");

const pages = [];
const page = (slug, title, template, menuOrder, blocks) => {
	const content = blocks.join("\n\n");
	const lead = content.match(/chap-lead"\} -->\n<figure[^>]*><img src="\{\{url:([^}]+)\}\}/);
	pages.push({ slug, title, template, menu_order: menuOrder, thumbnail: lead ? lead[1] : "", content });
};

/* ---------- Start ---------- */
const stage = (title, text, href, image) => group([
	h(3, title),
	p(text),
	p(link("Kapitel lesen", href), "stage-link"),
	image,
], { tag: "article", className: "stage" });

page("start", "Start", "gestaltet", 0, [
	group([
		video("honamas-hero.mp4", { poster: "hero-tribuene.jpg", className: "hero-video" }),
		group([
			p("Der Name der deutschen Hockey-Nationalmannschaft der Herren. 2006 im Whirlpool erfunden."),
			button("Die Geschichte lesen", "#geschichte"),
		], { className: "hero-copy" }),
		h(1, "HONAMAS", "hero-name mono-type"),
	], { tag: "section", className: "hero" }),

	group([group([
		group([
			h(2, "Eine Frage, ein Name."),
			group([
				p("Warum heißen die Australier Kookaburras, wir aber nur „die deutsche Herren-Nationalmannschaft“?", "statement"),
				group([
					p("Auf einer Länderspielreise nach Australien fällt Björn Emmerling auf, dass dort jeder sofort weiß, wer mit den Kookaburras, Wallabies und Hockeyroos gemeint ist. Der Name allein reicht."),
					p("Vor der Heim-WM 2006 stellt er die Idee im Trainingslager in Mönchengladbach vor, in der Runde im Whirlpool des Hotels Mercure. Wenn die Fußballer die „FuBaNaMa“ sind, dann sind wir die HONAMAS."),
					p(link("Die ganze Idee lesen", "/die-idee/")),
				], { className: "body" }),
			], { className: "idea-text" }),
			img("kookaburras-schild.jpg", "Fan mit einem selbst gemalten Schild „Let's go Kookaburras“", { className: "idea-photo", caption: "Kookaburras: Herrenhockey. Wallabies: Rugby. Hockeyroos: Frauenhockey." }),
		], { className: "grid idea-head" }),
		group([
			list([
				"<strong>HO</strong> steht für <strong>HO</strong>ckey.",
				"<strong>NA</strong> steht für <strong>NA</strong>tional.",
				"<strong>MA</strong> steht für <strong>MA</strong>nnschaft.",
				"<strong>S</strong> steht für die Mehrzahl: HONAMAS gibt es nie allein, nur als Team.",
			], "syl-list"),
			p("HOckeyNAtionalMAnnschaft, kurz HONAMA. Das S macht daraus das Team.", "small"),
		], { className: "syllables" }),
	], { className: "wrap" })], { tag: "section", className: "section idea", anchor: "idee" }),

	group([group([
		group([
			h(2, "Von der Idee zur Marke."),
			p("Fünf Kapitel, von Australien bis zur Markeneintragung. Wählen Sie ein Kapitel.", "body"),
		], { className: "grid story-head" }),
		group([
			stage("Die Idee", "Auf einer Länderspielreise fällt einem Spieler auf, dass in Australien jede Nationalmannschaft einen Namen trägt. Vor der Heim-WM 2006 wird daraus im Whirlpool HONAMAS.", "/die-idee/", img("kookaburras-schild.jpg", "Fan mit einem selbst gemalten Schild „Let's go Kookaburras“")),
			stage("2006: Von der Idee zur Umsetzung", "Logo, Team Identity, Teamoutfit und 1.500 Shirts: Die Mannschaft macht sich selbst sichtbar, ohne Auftrag und ohne Freigabe. Am 17. September wird sie Weltmeister.", "/2006-von-der-idee-zur-umsetzung/", img("buehne-2006.jpg", "Spieler mit Medaillen und Deutschlandtrikots auf einer Bühne nach dem WM-Titel")),
			stage("Die Jahre danach", "Olympiagold und Europameistertitel, doch der Name verschwindet fast. 2015 erzählt Björn der Mannschaft in Mannheim die Geschichte neu.", "/die-jahre-danach/", img("insta-2015.jpg", "Erster Instagram-Post von honamas_hockey vom 1. Juni 2015: Finally on Instagram")),
			stage("Wie aus dem Namen eine Marke wurde", "2017 erscheint das Logo erstmals offiziell auf den Trikots der Nationalmannschaft. 2023 macht das Sporthilfe-Magazin „Der Sonderweg der HONAMAS“ zum Titelthema.", "/wie-aus-dem-namen-eine-marke-wurde/", img("reece-home.jpg", "Entwurf des Heimtrikots mit HONAMAS-Logo von Reece Australia")),
			stage("Markenschutz: eine späte Anerkennung", "Björn meldet die Marke 2010 persönlich an, einfach weil es sonst niemand tat. 2021 übergibt er die Rechte geordnet an den DHB.", "/markenschutz-eine-spaete-anerkennung/", img("logo-honamas.png", "Das HONAMAS-Logo", { className: "is-logo" })),
		], { className: "acc" }),
	], { className: "wrap" })], { tag: "section", className: "section-tight", anchor: "geschichte" }),

	group([group([group([
		group([
			h(2, "Hockey mit Herz und Mut."),
			p("<strong>Honama</strong>, der: Raubvogel, gefräßig, angriffslustig, clever. Nur in der Gruppe erfolgreich.", "honama-def"),
			group([
				p("<strong>Tower of Power:</strong> in der Abwehr kompromisslos und verlässlich."),
				p("<strong>S.V.A.T.:</strong> im Angriff schnell, variabel, aggressiv, torgefährlich."),
				p("Jung, kreativ, mutig, zugleich diszipliniert und zielstrebig. Die Team Identity von 2006 ist bis heute das Fundament der Marke."),
				p(link("Der Honama und die Team Identity", "/der-honama/")),
			], { className: "body pillars" }),
		], { className: "identity-text" }),
		img("team-2006.jpg", "Mannschaftsfoto der HONAMAS 2006 vor der Tribüne, darunter das HONAMAS-Logo mit der Jahreszahl 2006", { className: "identity-media" }),
	], { className: "grid identity-grid" })], { className: "wrap" })], { tag: "section", className: "section identity" }),

	group([group([group([
		h(2, "Der zwölfte Mann."),
		group([
			p("Vier Tage vor Beginn der WM druckt das Team mit einem Kölner Hockeyshop 1.500 HONAMAS-Shirts. Bei der Autogrammstunde im Stadion sind sie nach wenigen Stunden ausverkauft.", "body"),
			quote("„Mit unserem goldenen Logo auf der Unterhose sind wir Weltmeister geworden.“"),
			p(link("Wie 2006 alles entstand", "/2006-von-der-idee-zur-umsetzung/")),
		], { className: "twelfth-text" }),
		group([
			img("trikot-logo.jpg", "Weißes Trikot mit goldenem HONAMAS-Adler", { className: "print p1" }),
			img("shirts-2006.jpg", "Drei HONAMAS-Shirts in Rot, Weiß und Grün von 2006", { className: "print p2" }),
			img("trikot-signiert.jpg", "Trikot mit HONAMAS-Logo und Unterschriften", { className: "print p3" }),
		], { className: "prints" }),
	], { className: "grid twelfth-grid" })], { className: "wrap" })], { tag: "section", className: "twelfth" }),

	group([group([group([
		group([
			h(2, "Ur-HONAMAS", "mono-type"),
			p("Das Team von 2006. Jeder von ihnen hat den Namen mit Leben gefüllt.", "statement"),
			img("team-2006.jpg", "Das WM-Team 2006 beim Mannschaftsfoto"),
		], { className: "team-side" }),
		group([
			shortcode('[honamas_team layout="bars"]'),
			p(`Trainer 2006: Bernhard Peters. ${link("Alle Porträts ansehen", "/die-ur-honamas/")}`, "small team-note"),
		], { className: "team-list" }),
	], { className: "grid team-grid" })], { className: "wrap" })], { tag: "section", className: "section", anchor: "team" }),

	group([group([group([
		group([
			h(2, "Titel seit 2006."),
			list([
				"<strong>2006</strong> Weltmeister in Mönchengladbach",
				"<strong>2008</strong> Olympiasieger in Peking",
				"<strong>2011</strong> Europameister",
				"<strong>2012</strong> Olympiasieger in London",
				"<strong>2013</strong> Europameister",
				"<strong>2023</strong> Weltmeister",
				"<strong>2025</strong> Europameister",
				"<strong>2026</strong> Weltmeister, zwanzig Jahre nach Mönchengladbach",
			], "wins-list"),
			p(link("Alle Titel ansehen", "/erfolge/")),
		], { className: "wins-main" }),
		group([
			img("gold-2012.jpg", "Die Mannschaft feiert Olympiagold 2012"),
			quote("„Die Marke gehörte nie mir. Ich habe sie nur aufbewahrt, bis sie wieder da war, wo sie hingehört – bei der Mannschaft.“", "Björn Emmerling"),
		], { className: "wins-side" }),
	], { className: "grid wins-grid" })], { className: "wrap" })], { tag: "section", className: "section-tight", anchor: "erfolge" }),

	group([group([group([
		h(2, "Der Weg zum Titel."),
		video("wm2006-loop.mp4", { poster: "hero-tribuene.jpg", className: "film-media" }),
		group([
			p("Eine Stunde über die Heim-WM 2006, das letzte Turnier unter Bernhard Peters, und darüber, wie auf diesem Weg die HONAMAS entstanden."),
			button("Film auf YouTube ansehen", "https://www.youtube.com/watch?v=2RjXuKBzjC0"),
			p(link("Zur Filmseite", "/der-film/")),
		], { className: "film-side" }),
	], { className: "grid film-top" })], { tag: "section", className: "film wrap", anchor: "film" })], { className: "close on-dark" }),
]);

/* ---------- Kapitel ---------- */
const lead = (file, alt, caption = "") => img(file, alt, { className: "chap-lead", caption });
const fig = (file, alt, caption = "") => img(file, alt, { caption });
const pull = (t) => quote(t, "", t.length > 110 ? "pull long" : "pull");
const row = (...imgs) => group(imgs, { className: "fig-row" });

page("die-idee", "Die Idee", "kapitel", 1, [
	chapterHero("Die Idee", "Wir wollten auch einfach so etwas haben.", "Björn Emmerling auf die Frage, was der Auslöser war", lead("kookaburras-schild.jpg", "Fan mit einem selbst gemalten Schild „Let's go Kookaburras“")),
	chapterBody(chapterNav, [
		row(img("menge-1807.jpg", "Spieler vor der vollen Tribüne"), img("anzeige-2-2.jpg", "Anzeigetafel mit dem Spielstand Deutschland gegen Niederlande, 2 zu 2"), img("tribuene-1809.jpg", "Fans in der Tribüne mit Deutschlandfahnen")),
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
		p("HONAMAS. Die Grundlage war gelegt.", "prose-end"),
	]),
	chapterPager,
]);

page("2006-von-der-idee-zur-umsetzung", "2006: Von der Idee zur Umsetzung", "kapitel", 2, [
	chapterHero("2006: Von der Idee zur Umsetzung", "Dann müssen wir es eben selber machen.", "Timo Wess, Jan-Marco Montag und Björn Emmerling, als sie vier Tage vor Beginn der WM 2006 erfuhren, dass seitens des DHB nicht mit Unterstützung zu rechnen war", lead("team-2006.jpg", "Mannschaftsfoto der HONAMAS 2006 mit dem Logo und der Jahreszahl 2006")),
	chapterBody(chapterNav, [
		p("Die Heim-WM in Mönchengladbach war der perfekte Zeitpunkt."),
		p("Nach dem Meeting im Whirlpool stellte Björn seine Idee und den Namen offiziell im Team vor. Als HONAMAS wollte man nun auftreten. Die Mannschaft reagierte begeistert. Damit hatte das Team etwas Eigenes, mit dem sich alle Mannschaftsmitglieder identifizieren konnten."),
		p("Auf einer Autofahrt zum nächsten Lehrgang von Mönchengladbach nach München nahm das Konzept Formen an. Im Smart von Mannschaftskollege Tibor Weißenborn, mit dem Laptop auf dem Beifahrersitz, wurden gemeinsam Werte und Eigenschaften definiert, für die diese Mannschaft und damit die HONAMAS stehen sollten."),
		p("Björn schrieb auf dieser Grundlage die Definition, konzipierte die Team Identity und designte das Logo."),
		fig("team-identity.jpg", "Folien der Team Identity von 2006", `Die Team Identity von 2006. <a href="{{url:honamas-team-identity-2006.pdf}}">Originaldokument als PDF öffnen</a>`),
		p("Diese Inhalte sind in den Originalunterlagen von 2006 dokumentiert und bis heute das Fundament der Marke HONAMAS."),
		h(2, "Zum Leben erweckt"),
		h(3, "Die ersten HONAMAS-Shirts"),
		p("Kurz vor der WM tauchte das HONAMAS-Logo erstmals auf Trainingskleidung auf: auf den Trainingstrikots von TK, groß auf der Brust. Seitdem wurde es in zahlreichen Trainingseinheiten gesichtet."),
		fig("trikot-logo.jpg", "Weißes Trikot mit goldenem HONAMAS-Adler"),
		h(3, "Das Teamoutfit"),
		p("Zur WM produzierten zwei weitere Mitglieder des WM-Teams, Timo Wess und Jan-Marco Montag, eine ganze Serie an Teamequipment:"),
		list(["Jogger", "Hoodie", "Cap", "Bag", "Gürtel", "die legendäre goldbedruckte Unterhose"]),
		p("Es war die inoffizielle Teamausstattung und sorgte damals für Diskussionen mit dem Verband, da die vorgeschriebene Ausrüstung der Sponsoren nicht durchgängig getragen wurde."),
		fig("trikot-signiert.jpg", "Trikot mit HONAMAS-Logo und Unterschriften"),
		h(3, "Der zwölfte Mann"),
		p("Zusammen mit einem Kölner Hockeyshop organisierte das Team vier Tage vor Beginn der WM den Druck von 1.500 HONAMAS-T-Shirts."),
		p("Die Shirts wurden bei einer Autogrammstunde im Stadion verkauft und waren innerhalb weniger Stunden ausverkauft. Damit hatten die HONAMAS 1.500-mal ihren zwölften Mann als Supporter im Stadion."),
		fig("shirts-2006.jpg", "Drei HONAMAS-Shirts in Rot, Weiß und Grün von 2006"),
		p("Was als Idee im Kopf begann, wurde zu einem sichtbaren Symbol für ein Team, das mehr wollte als nur Titel."),
		video("wm2006-loop.mp4", { poster: "hero-tribuene.jpg" }),
		pull("Am 17. September 2006 folgte dennoch die Krönung: Weltmeister im eigenen Land."),
		fig("buehne-2006.jpg", "Spieler mit Medaillen und Deutschlandtrikots auf einer Bühne nach dem WM-Titel", "Ein Sommer, in dem alles zusammenkam."),
	]),
	chapterPager,
]);

page("die-jahre-danach", "Die Jahre danach", "kapitel", 3, [
	chapterHero("Die Jahre danach", "Es war wichtig, den Spielern zu zeigen, dass der Name aus ihrer Mannschaft entstanden ist – und nicht von außen.", "Valentin Altenburg, damaliger Nationaltrainer", lead("insta-2015.jpg", "Erster Instagram-Post von honamas_hockey vom 1. Juni 2015: Finally on Instagram", "Der erste Post auf @honamas_hockey, 1. Juni 2015")),
	chapterBody(chapterNav, [
		p("Nach dem WM-Titel 2006 ging der sportliche Erfolg weiter."),
		p("Die Mannschaft gewann 2008 in Peking und 2012 in London erneut olympisches Gold. 2011 und 2013 wurde sie Europameister."),
		fig("gold-2012.jpg", "Die Mannschaft feiert Olympiagold 2012"),
		p("Doch der Name HONAMAS spielte in dieser Zeit kaum eine Rolle."),
		p("Der Deutsche Hockey-Bund hatte die Idee nie wirklich aufgenommen. Obwohl im Umfeld die Bezeichnung „DANAS“ für die Damen entstand, fand die Geschichte der HONAMAS keinen Platz im täglichen Umgang der Herren-Nationalmannschaft."),
		p("Für viele der jüngeren Spieler war der Ursprung des Namens längst nicht mehr präsent."),
		fig("logo-honamas.png", "Das HONAMAS-Logo, ein Adler mit schwarz-rot-goldenen Schwingen"),
		p("Das Logo wurde zwischenzeitlich sogar von Teampsychologen genutzt, um Begriffe und Werte in den Adler zu schreiben. Die Spieler nahmen dies eher als Methode wahr, nicht als Identität. Für viele fühlte es sich nicht nach „ihrem“ Symbol an."),
		pull("Erst 2015 änderte sich das."),
		fig("team-2006.jpg", "Das WM-Team 2006 beim Mannschaftsfoto", "Die HONAMAS von 2006"),
		p("Bundestrainer Valentin Altenburg bat Björn zu einem Lehrgang nach Mannheim, um der Mannschaft die ursprüngliche Geschichte der HONAMAS zu erzählen. Viele der Spieler hatten sie vorher nie gehört."),
		p("In diesem Moment wurde klar, dass hinter dem Namen mehr steckt als ein Logo: eine Idee, die aus der Mannschaft selbst entstanden war."),
		p("Dieser Lehrgang war ein Wendepunkt. Die Spieler verstanden wieder, woher der Name kam, warum er gewachsen war und was er bedeutete."),
		p(`Von da an wurde HONAMAS erneut Teil der Identität des Teams und fand sich schließlich auch auf Instagram wieder: <a href="https://www.instagram.com/honamas_hockey/">@honamas_hockey</a>.`),
	]),
	chapterPager,
]);

page("wie-aus-dem-namen-eine-marke-wurde", "Wie aus dem Namen eine Marke wurde", "kapitel", 4, [
	chapterHero("Wie aus dem Namen eine Marke wurde", "Jambo rief mich an und fragte, ob sie das HONAMAS-Logo aufs Trikot drucken dürfen.", "Björn Emmerling über den Anruf von Jan-Marco Montag, 2017 Vertriebsleiter beim DHB-Ausrüster Reece Australia, der daraufhin die Nutzungsrechte für das Logo erhielt", lead("reece-home.jpg", "Entwurf des Heimtrikots mit HONAMAS-Logo von Reece Australia")),
	chapterBody(chapterNav, [
		p("Was 2006 in der Mannschaft begann, war für einige Jahre fast verschwunden und fand erst langsam seinen Weg zurück."),
		p("Nach dem Lehrgang in Mannheim, bei dem den Spielern die Geschichte der HONAMAS erzählt wurde, wurde das Thema wieder lebendig. Der Name tauchte immer häufiger auf:"),
		list(["in Artikeln,", "in Interviews,", "auf Instagram,", "auf Trainingskleidung."]),
		p("Aus einer Spieleridee wurde Stück für Stück ein fester Begriff im deutschen Hockey. Mit der Zeit wurde „HONAMAS“ selbstverständlich. Reporter griffen den Namen auf, Fans nutzten ihn in sozialen Medien und auch Partner und Ausrüster begannen, ihn einzusetzen."),
		h(2, "2017: Das Logo auf dem Trikot"),
		p("2017 war ein besonderer Moment: Das HONAMAS-Logo erschien erstmals offiziell auf den Trikots der Nationalmannschaft, ein echtes Novum."),
		p("Björn überließ dem damaligen Ausrüster Reece Australia ein zeitlich begrenztes Nutzungsrecht für Spiel- und Replikatrikots, verbunden mit einer Beteiligung der Mannschaft an den Verkaufserlösen. Die Marke war damit nicht nur sichtbar, sondern auch ein Wert an sich, von dem das Team direkt profitierte."),
		h(2, "Das erste Trikot mit dem HONAMAS-Logo"),
		p("Als Vertriebsleiter des DHB-Ausrüsters Reece Australia gehörte Jan-Marco Montag, Weltmeister von 2006, zu den Designern des ersten „richtigen“ HONAMAS-Trikots."),
		row(img("reece-home.jpg", "Entwurf des Heimtrikots mit HONAMAS-Logo"), img("reece-away.jpg", "Entwurf des Auswärtstrikots mit HONAMAS-Logo"), img("trikot-logo2.jpg", "Trikot mit HONAMAS-Logo")),
		h(2, "2023: Der Sonderweg der HONAMAS"),
		p("Im Januar 2023, kurz vor der Weltmeisterschaft, erschien im Sporthilfe-Magazin ein Artikel mit dem Titel „Der Sonderweg der HONAMAS“. Für Magenta TV ist der Einsatz von HONAMAS selbstverständlich."),
		fig("sporthilfe.jpg", "Titelseite des Sporthilfe-Magazins: Der Sonderweg der Honamas"),
		p("Damit war klar: Der Name hatte nun wirklich seinen Platz in der Sportwelt gefunden, als Synonym für die deutsche Hockey-Nationalmannschaft der Herren."),
		pull("Aus der Idee war Realität geworden."),
	]),
	chapterPager,
]);

page("markenschutz-eine-spaete-anerkennung", "Markenschutz: eine späte Anerkennung", "kapitel", 5, [
	chapterHero("Markenschutz: eine späte Anerkennung", "Die Marke gehörte nie mir. Ich habe sie nur aufbewahrt, bis sie wieder da war, wo sie hingehört – bei der Mannschaft.", "Björn Emmerling zur Sicherung der Marke HONAMAS", lead("logo-honamas.png", "Das HONAMAS-Logo")),
	chapterBody(chapterNav, [
		p("Obwohl die Idee längst Teil des deutschen Hockeys war, hatte sich der Verband nie um die formale Absicherung des Namens gekümmert."),
		group([
			group([p("30. März 2010", "fact-date"), p("Björn Emmerling meldet die Marke HONAMAS persönlich an, einfach, weil es sonst niemand tat.")], { className: "fact" }),
			group([p("16. Juni 2021", "fact-date"), p("Der DHB trägt die Marke offiziell ein, 15 Jahre nach ihrer Entstehung.")], { className: "fact" }),
		], { className: "facts" }),
		p("Elf Jahre lang hielt Björn die Rechte, bevor er sie 2021 geordnet an den DHB übergab."),
		p("Ein spätes, aber wichtiges Zeichen dafür, dass die Idee, die 2006 aus einem Team heraus entstand, ihren festen Platz gefunden hatte."),
		h(2, "Die Marke im Einsatz"),
		row(img("reece-home.jpg", "Entwurf des Heimtrikots mit HONAMAS-Logo"), img("reece-away.jpg", "Entwurf des Auswärtstrikots mit HONAMAS-Logo"), img("trikot-logo2.jpg", "Trikot mit HONAMAS-Logo")),
		fig("sporthilfe.jpg", "Titelseite des Sporthilfe-Magazins: Der Sonderweg der Honamas"),
	]),
	chapterPager,
]);

/* ---------- weitere Seiten ---------- */
page("der-honama", "Der Honama", "gestaltet", 0, [
	chapterHero("Der Honama", "Mit unserem goldenen Logo auf der Unterhose sind wir Weltmeister geworden – das sagt eigentlich alles über diesen verrückten Sommer 2006.", "Aus der Geschichte der HONAMAS", lead("team-2006.jpg", "Mannschaftsfoto der HONAMAS 2006")),
	chapterBody(moreNav, [
		p("<strong>Honama</strong> [haunama:], der; aus dem Deutschen stammend, kurz für HOckeyNAtionalMAnnschaft. Das S steht für die Mehrzahl: Honamas gibt es nie allein, sondern immer nur als Team.", "prose-def"),
		fig("logo-honamas.png", "Das HONAMAS-Logo, ein Adler mit schwarz-rot-goldenen Schwingen"),
		p("Mitteleuropäischer Raubvogel, Gattung der Adler: gefräßig, angriffslustig, clever. <strong>Achtung: Torgefahr!</strong>"),
		p("Der Honama ist ein intelligenter Raubvogel mit besten körperlichen Voraussetzungen im Vergleich zu ähnlichen Lebewesen. Er verteidigt sein Nest hart und aggressiv. Er kann sein Ziel umkreisen, schlägt dann aber unausrechenbar, blitzschnell und erbarmungslos zu. Er fliegt mit höchster Geschwindigkeit, nimmt meist einfache Wege, kann aber seine Gegner durch Varianten überraschen."),
		pull("Er ist nur in der Gruppe erfolgreich und strebt zu höchsten Gipfeln."),
		h(2, "Team Identity"),
		p("Die HONAMAS sind mehr als nur eine Nationalmannschaft. Sie sind ein Team, das weiß, was es ist und wie es wirken will. Eine Mannschaft mit Charakter: jung, kreativ, mutig, aber diszipliniert und zielstrebig."),
		p("Ihr Ziel ist ein gemeinsamer Auftritt, der zeigt, wer sie sind: ein Team, das sich kennt, vertraut und füreinander spielt."),
		fig("team-identity.jpg", "Folien der Team Identity von 2006", `Die Team Identity von 2006. <a href="{{url:honamas-team-identity-2006.pdf}}">Originaldokument als PDF öffnen</a>`),
		p("Auf dem Platz kombinieren sie Struktur mit Freiheit:"),
		p("In der Abwehr kompromisslos und verlässlich: der <strong>Tower of Power</strong>."),
		p("Im Angriff schnell, variabel und gefährlich, nach dem Prinzip <strong>S.V.A.T.: Schnell. Variabel. Aggressiv. Tor.</strong>"),
		fig("trikot-logo.jpg", "Weißes Trikot mit goldenem HONAMAS-Adler"),
		pull("So entstand der typische HONAMAS-Stil, der von der Mannschaft gelebt wurde: Hockey mit Herz, Klarheit und Mut."),
		p(`Die ganze Entstehung lesen: <a href="/2006-von-der-idee-zur-umsetzung/">2006: Von der Idee zur Umsetzung</a>.`),
	]),
]);

page("die-ur-honamas", "Die Ur-HONAMAS", "gestaltet", 0, [
	group([group([
		h(1, "Die Ur-HONAMAS"),
		group([
			group([p("Das Team, mit dem alles begann. 2006 wurden die HONAMAS in Mönchengladbach Weltmeister und legten damit den Grundstein für das, was heute als HONAMAS bekannt ist. Jeder von ihnen hat diesen Namen mit Leben gefüllt.")], { className: "chap-quote" }),
			lead("team-2006.jpg", "Mannschaftsfoto des WM-Teams 2006", "Trainer 2006: Bernhard Peters"),
		], { className: "grid chap-hero-grid" }),
	], { className: "wrap" })], { tag: "section", className: "chap-hero on-dark" }),
	group([group([
		h(2, "Die Spieler", "roster-h"),
		shortcode('[honamas_team layout="roster"]'),
	], { className: "wrap" })], { tag: "section", className: "section-tight" }),
]);

const winsList = list([
	"<strong>2006</strong> Weltmeister in Mönchengladbach",
	"<strong>2008</strong> Olympiasieger in Peking",
	"<strong>2011</strong> Europameister",
	"<strong>2012</strong> Olympiasieger in London",
	"<strong>2013</strong> Europameister",
	"<strong>2023</strong> Weltmeister",
	"<strong>2025</strong> Europameister",
	"<strong>2026</strong> Weltmeister, zwanzig Jahre nach Mönchengladbach",
], "wins-list");

page("erfolge", "Erfolge", "gestaltet", 0, [
	group([group([
		h(1, "Titel seit 2006"),
		group([
			group([p("Weltmeister, Olympiasieger, Europameister: eine Geschichte, die weitergeht.")], { className: "chap-quote" }),
			lead("gold-2012.jpg", "Die Mannschaft feiert Olympiagold 2012"),
		], { className: "grid chap-hero-grid" }),
	], { className: "wrap" })], { tag: "section", className: "chap-hero on-dark" }),
	chapterBody(moreNav, [
		winsList,
		row(img("team-2006.jpg", "Das WM-Team 2006"), img("buehne-2006.jpg", "Spieler mit Medaillen nach dem WM-Titel 2006"), img("hero-tribuene.jpg", "Die Mannschaft vor der vollen Tribüne")),
		p(`Die Geschichte dahinter: <a href="/die-jahre-danach/">Die Jahre danach</a>.`),
	]),
]);

page("der-film", "Der Film", "gestaltet", 0, [
	group([group([
		h(1, "Der Weg zum Titel"),
		group([
			group([p("Der Film von Daniel Kuhn zeigt den besonderen Weg eines Teams, das im eigenen Land Geschichte schrieb.")], { className: "chap-quote" }),
			video("wm2006-loop.mp4", { poster: "hero-tribuene.jpg", className: "chap-lead" }),
		], { className: "grid chap-hero-grid" }),
	], { className: "wrap" })], { tag: "section", className: "chap-hero on-dark" }),
	chapterBody(moreNav, [
		p("Er begleitet die deutsche Mannschaft durch die Heim-WM 2006, das letzte Turnier unter Trainer Bernhard Peters, und erzählt, wie auf diesem Weg die HONAMAS entstanden."),
		p("Eine Stunde voller Emotionen, Einblicke und Erinnerungen an eine Zeit, in der ein Name geboren wurde, der bis heute für deutschen Hockeysport steht."),
		h(2, "Worum es geht"),
		list(["der Weg der deutschen Mannschaft durch die Heim-WM 2006", "das letzte Turnier unter Trainer Bernhard Peters", "wie auf diesem Weg die HONAMAS entstanden"]),
		row(img("team-2006.jpg", "Das WM-Team 2006"), img("buehne-2006.jpg", "Spieler mit Medaillen nach dem WM-Titel 2006"), img("shirts-2006.jpg", "Drei HONAMAS-Shirts von 2006")),
		button("HONAMAS 2006 – Der Weg zum Titel auf YouTube ansehen", "https://www.youtube.com/watch?v=2RjXuKBzjC0"),
	]),
]);

/* ---------- Impressum: only appended, the legal text stays as it is ---------- */
const source = (file, alt, text) => group([img(file, alt), p(text)], { className: "source" });
const impressumSources = group([
	h(2, "Quellen und Bildnachweise"),
	group([
		source("team-identity.jpg", "Folien der Team Identity von 2006", `Team Identity der HONAMAS, Originaldokument vom 13. Juli 2006 (<a href="{{url:honamas-team-identity-2006.pdf}}">PDF</a>)`),
		source("logo-honamas.png", "Das HONAMAS-Logo", "Markenanmeldung vom 30. März 2010 und Eintragung durch den DHB am 16. Juni 2021"),
		source("sporthilfe.jpg", "Titelseite des Sporthilfe-Magazins", "Sporthilfe-Magazin, Januar 2023: „Der Sonderweg der HONAMAS“"),
		source("hero-tribuene.jpg", "Die Mannschaft vor der vollen Tribüne 2006", "Film „HONAMAS 2006 – Der Weg zum Titel“ von Daniel Kuhn auf YouTube"),
		source("insta-2015.jpg", "Erster Instagram-Post von honamas_hockey", "Aussagen und Zitate von Björn Emmerling, Timo Wess, Jan-Marco Montag und Valentin Altenburg"),
	], { className: "sources-grid" }),
	p("[Fotografen und Rechteinhaber der Bilder und des Filmmaterials: vor dem Launch ergänzen]", "small"),
], { tag: "section", className: "impressum-sources", anchor: "quellen" });

/* ---------- write ---------- */
rmSync(out, { recursive: true, force: true });
mkdirSync(path.join(out, "media"), { recursive: true });
for (const pg of pages) writeFileSync(path.join(out, `${pg.slug}.html`), pg.content + "\n");
writeFileSync(path.join(out, "impressum-quellen.html"), impressumSources + "\n");
writeFileSync(path.join(out, "pages.json"), JSON.stringify({
	version: 1,
	pages: pages.map(({ slug, title, template, menu_order, thumbnail }) => ({ slug, title, template, menu_order, thumbnail })),
	append: [{ slug: "impressum", file: "impressum-quellen.html", marker: "impressum-sources" }],
	front_page: "start",
}, null, "\t") + "\n");

// Media: every file referenced in the content, copied from the preview assets.
const used = new Set();
for (const f of [...pages.map((pg) => pg.content), impressumSources]) for (const m of f.matchAll(/\{\{(?:id|url):([^}]+)\}\}/g)) used.add(m[1]);
for (const file of used) {
	const src = ["img", "video", "docs"].map((d) => path.join(previewAssets, d, file)).find((f) => existsSync(f));
	if (!src) throw new Error(`Media file not found: ${file}`);
	cpSync(src, path.join(out, "media", file));
}

console.log(`${pages.length} pages and ${used.size} media files written to ${out}`);
