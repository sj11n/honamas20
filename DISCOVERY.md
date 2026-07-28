# DISCOVERY — HONAMAS.COM

Stand: 28. Juli 2026  
Phase: 0 — Verstehen  
Status: Dokumentation, keine produktiven Änderungen

## 1. Kurzfassung

HONAMAS.COM soll kein allgemeines Teamportal und kein Ersatz für hockey.de
werden. Es ist das langfristig pflegbare, quellenbasierte digitale Archiv einer
Idee: Wie entstand der Name HONAMAS innerhalb der Mannschaft, wie wurde daraus
2006 eine sichtbare Team Identity, und wie wurde der Name später zur Marke der
deutschen Hockey-Nationalmannschaft?

Das Produkt verbindet Geschichte, Identität und Beleg. Seine Glaubwürdigkeit
entsteht nicht durch Heroik, sondern durch originale Fotos, Dokumente, Kleidung,
Pressebelege, nachvollziehbare Quellen und präzise Einordnung. Die Startseite
ist dabei eine kuratierte Einladung; die fünf Kapitel-Deep-Dives und das Archiv
sind die eigentlichen Träger der Geschichte.

## 2. Antworten auf die Leitfragen

### Was ist HONAMAS?

HONAMAS ist der innerhalb der Mannschaft entstandene Name und die daraus
entwickelte Team Identity der deutschen Herren-Hockeynationalmannschaft. Die
Website dokumentiert Ursprung, Umsetzung, Weiterentwicklung und formale
Absicherung dieser Identität.

### Warum existiert diese Website?

Sie schafft einen dauerhaften, offiziellen Ort für eine Geschichte, deren
Material bisher über Seiten, Erinnerungen, Dokumente und Medien verstreut ist.
Sie soll die Herkunft der Marke nachvollziehbar machen, die Ur-HONAMAS sichtbar
halten und dem DHB eine belastbare Grundlage für die zukünftige Nutzung geben.

### Was unterscheidet sie von hockey.de?

hockey.de ist das laufende Verbands- und Nachrichtenangebot. HONAMAS.COM ist
ein fokussiertes Marken- und Sportarchiv mit eigener Erzählung, kuratierten
Primärquellen, Objekten und historischen Deep Dives. Aktuelle Ergebnisse oder
allgemeine Verbandskommunikation sind nicht sein Kernauftrag.

### Warum sollte jemand länger als 30 Sekunden bleiben?

Die ersten Sekunden müssen den Namen, seine historische Relevanz und die
Spannung der Entstehung verständlich machen. Danach geben die fünf Kapitel,
Zeitzeugen, das Team von 2006, der Film und vor allem sichtbare Originalquellen
einen echten Grund, tiefer einzusteigen. Ohne diese Quellen wäre die Seite
austauschbar; mit ihnen ist sie ein eigenständiges Archiv.

### Welche Inhalte sind einzigartig?

- Originaldokumente zur Team Identity und Logoentwicklung von 2006.
- Die belegte Entstehung des Namens aus der Mannschaft.
- Historische Teamkleidung, Trikots und weitere physische Objekte.
- Die Ur-HONAMAS: Mannschaft, Personen, Rollen und Bildmaterial von 2006.
- Markenunterlagen, Pressebelege, Zeitzeugenstimmen und der Filmkontext.

## 3. Zielgruppen und Kernnutzen

| Zielgruppe | Erwartung | Nutzen der Website |
| --- | --- | --- |
| Ehemalige und aktuelle Nationalspieler | Herkunft und Haltung verstehen | Eine belegte, respektvolle Teamgeschichte |
| DHB | Markenkontext und belastbares Material | Langfristig nutzbares Markenarchiv |
| Hockey-Community und Fans | Hintergrund statt Ergebnisdienst | Zugang zu Menschen, Objekten und Quellen |
| Medien und Journalisten | überprüfbare Einordnung | Zitate, Daten, Bildrechte und Primärmaterial |
| Sport-, Marken- und Designinteressierte | Beispiel einer organischen Team Identity | Dokumentierte Entwicklung ohne Marketingmythos |

## 4. Vorgegebene Informationsarchitektur

### Primäre Navigation

- Die Geschichte
  - Die Idee
  - 2006 – Von der Idee zur Umsetzung
  - Die Jahre danach
  - Wie aus dem Namen eine Marke wurde
  - Markenschutz – eine späte Anerkennung
- Das Team
- Der Honama
- Archiv
- Der Film

### Vorgesehene Seiten und Slugs

- `/`
- `/die-idee/`
- `/2006-von-der-idee-zur-umsetzung/`
- `/die-jahre-danach/`
- `/wie-aus-dem-namen-eine-marke-wurde/`
- `/markenschutz-eine-spaete-anerkennung/`
- `/die-ur-honamas/`
- `/der-honama/`
- `/archiv/`
- `/erfolge/`
- `/der-film/`
- `/kontakt/`
- `/impressum/`
- `/datenschutz/`

Die Slugs gelten als zu erhaltende Bestandteile der späteren Migration. Die
Reunion-Seite bleibt vollständig aus Navigation, Footer, Teasern und Sitemaps
der Hauptseite heraus.

### Bewertung der IA

Die Grundstruktur ist überzeugend: Sie trennt Erzählung, Personenwissen,
Begriffs- und Identitätswissen, Objektarchiv und Film sinnvoll. Die fünf Kapitel
sind eine klare, chronologische Nutzerreise und sollten als zusammenhängende
Sequenz mit Zurück-/Weiter-Navigation umgesetzt werden.

Die Startseite darf nur orientieren und Neugier erzeugen. Ihr vorgegebener
Aufbau mit Definition, vier Meilenstein-Zahlen, fünf Kapitelkarten, Zitat, Film,
Team, kompakter Erfolgschronik und drei Archivobjekten ist für dieses Ziel
stimmig. Das Archiv ist kein nachrangiger Anhang, sondern der Glaubwürdigkeits-
und Wiederkehrgrund der Website.

Offen bleibt für Phase 1 die konkrete Navigation auf kleinen Bildschirmen, die
Beziehung zwischen "Der Honama" und "Die Geschichte", die Gewichtung von
Erfolgen im Footer gegenüber einer eigenen Seite sowie die Filter- und
Detailansicht des Archivs.

## 5. Vorhandener Repository-Bestand

### Dokumentation

Vorhanden sind `PROJECT.md`, `CREATIVE_BRIEF.md`, `AGENTS.md`,
`CODEX_MASTER_PROMPT.md`, `README.md` und eine kurze `scripts/README.md`.
Analyse-, Migrations-, Content-, Architektur-, Designsystem- und
Deployment-Dokumente fehlen derzeit.

### Theme und Demo

Ein WordPress-Block-Theme liegt unter `wp-content/themes/honamas/` vor. Es
enthält `theme.json`, Template Parts, Standardtemplates, ein `front-page`
Template, Pattern für Hero, Story, Zeitstrahl, Team, Film, Erfolge und
Reunion-Elemente sowie eine statische Demo unter `preview/`.

Die aktuelle Startseitenvorlage bündelt bereits Hero, Jubiläumsstatement,
Story, Timeline, Team Identity, Team, Film und Erfolge. Sie ist damit eher eine
lange Erzählseite als der im Projekt verlangte kompakte Einstieg in Deep Dives.

### Plugin und Deployment

Ein Verzeichnis oder Grundgerüst für `honamas-core` ist nicht vorhanden.
GitHub-Actions-Workflows, Deployment-Konfiguration, Umgebungsdokumentation,
Staging-Anleitung, Migration und Tests sind ebenfalls nicht vorhanden.

### Vorhandene Assets

- Fünf lokal abgelegte Montserrat-`woff2`-Dateien im Theme.
- Duplikate dieser Font-Dateien für die statische Demo.
- Keine Bilder, keine historischen Fotos, keine Dokumentscans, keine
  Logos, keine Videos, keine Teamprofile, keine Archivobjekte und keine
  zugehörigen Metadaten im Repository.

Die Herkunft und Lizenz der vorhandenen Font-Dateien sind im Repository nicht
dokumentiert.

## 6. Inhaltliche, technische und rechtliche Risiken

### Inhaltlich und redaktionell

- Für die fünf Kapitel liegen keine freigegebenen Langtexte, Quellenlisten,
  Bildunterschriften oder Zitatfreigaben im Repository vor.
- Es fehlen die Daten für die 21 Spieler, Trainer, Rückennummern, Positionen,
  Vereine von 2006 und optionale Zitate.
- Für die Erfolgschronik fehlen Austragungsort, Finalgegner, Ergebnisse und die
  eindeutige Kennzeichnung der Titel der Ur-HONAMAS.
- Die Entstehungs- und Markenstory ist besonders anfällig für verkürzte,
  ungenaue oder nachträglich ausgeschmückte Formulierungen. Jede zentrale
  Behauptung braucht eine überprüfbare Quelle.
- Der Film braucht freigegebenen Kontext, Vorschaubild, Kapitelmarken und eine
  bestätigte Einbettungs- bzw. Veröffentlichungsberechtigung.

### Technisch

- Das vorhandene Theme ist ein Ausgangspunkt, erfüllt aber die im Master Prompt
  verlangte Architektur noch nicht: Es fehlen beispielsweise `home.html`,
  `search.html`, ein post-meta-Template-Part, die geforderten Pattern und das
  eigene Plugin.
- Das Archiv besitzt noch kein Datenmodell, keine Taxonomien, keine Filterung
  und keine redaktionelle Eingabemaske. Die Entscheidung CPT versus Core-
  Blöcke muss in Phase 3 dokumentiert werden.
- Reunion-Patterns sind vorhanden, aber die geforderten zentralen Noindex-
  Regeln, Sitemap-Ausschlüsse und der Countdown sind nicht als unabhängige
  Plugin-Funktion verifiziert.
- Es gibt keine automatisierten Qualitäts-, Sicherheits-, Accessibility- oder
  Deployment-Checks.
- Die aktuelle Repository-Struktur nutzt `wp-content/themes/`; der Master
  Prompt skizziert dagegen eine Top-Level-Struktur `themes/` und `plugins/`.
  Diese Abweichung muss vor Phase 3 bewusst entschieden werden, statt Dateien
  vorschnell zu verschieben.

### Recht und Datenschutz

- Für Bilder, Dokumente, Trikots, Presseauszüge, Logos, Film und Zitate fehlen
  Rechte- und Herkunftsnachweise.
- Die lokalen Montserrat-Dateien haben keinen Lizenznachweis im Repository;
  nach den Projektregeln dürfen sie ohne klare Lizenz und Freigabe nicht als
  verbindliche Produktionsentscheidung gelten.
- Ein Consent-Konzept, eine Zwei-Klick-YouTube-Lösung, Kontaktformular-
  Datenschutz, Datenflüsse und Zuständigkeiten sind nicht dokumentiert.
- `noindex` für die Reunion-Seite ist kein Zugriffsschutz. Diese Einschränkung
  muss später technisch und redaktionell klar kommuniziert werden.

## 7. Erkannte Widersprüche und Entscheidungsbedarf

1. **Vorhandene Typografie vs. Creative Brief:** Das Theme und die Demo nutzen
   Montserrat als alleinige Schrift. Der Brief verlangt dagegen eine
   kondensierte Headline-Schrift, eine Serifenschrift für längere Texte und eine
   neutrale UI-Sans. Außerdem fehlt der Lizenznachweis der vorhandenen Fonts.
2. **Bestehende Startseite vs. Produktprinzip:** Die aktuelle Frontpage
   erzählt die Geschichte weitgehend selbst. Projekt und Master Prompt fordern
   ausdrücklich eine kompakte Startseite, die in Kapitel-Deep-Dives führt.
3. **Vorhandene visuelle Richtung vs. neuer Brief:** Die bestehende Demo hat
   eine helle, sportliche Einseiten-Ästhetik mit Video-Platzhalter. Der neue
   Brief setzt ein dunkleres, quellennahes Ausstellungs- und Archivsystem mit
   Off-White-Flächen, Serifentext und Objektpräsentation voraus.
4. **Master-Prompt-Lieferumfang vs. Phasengate:** Abschnitt 11 nennt einen
   ersten Pull Request mit mehreren späteren Phasen. Die klare Anweisung am
   Ende und der aktuelle Auftrag verlangen jedoch zuerst ausschließlich Phase
   0. Für diese Arbeit gilt deshalb das Phasengate; kein produktiver Code wird
   vor den Dokumentationsphasen angefasst.
5. **Reihenfolge:** Der Master Prompt priorisiert die Reunion-MVP vor der
   öffentlichen Hauptseite. Das Projekt beschreibt primär HONAMAS.COM. Das ist
   kein sachlicher Widerspruch, aber eine verbindlich zu bestätigende
   Lieferreihenfolge für Phase 4.

## 8. Fehlende Inhalte und Assets

### Für die öffentliche Website

- Freigegebene Texte und Quellen je Kapitel.
- Quellenverzeichnis mit Herkunft, Datum und Rechtekontext.
- Historische und aktuelle Fotos inklusive Alt-Text, Jahr, Fotograf/Herkunft
  und Nutzungsrecht.
- Originaldokumente von 2006, Markendokumente, Pressebelege und Scans in
  webtauglichen Formaten.
- Logo-Dateien und dokumentierte Logo-Versionen.
- Daten und Porträts für Ur-HONAMAS, Trainer und Rückennummern.
- Bestätigte Erfolge mit Turnierdaten und Ergebnissen.
- Film-URL, Rechtefreigabe, Posterbild, Beschreibung und Kapitelmarken.
- Freigegebene Zitate mit Person, Kontext und Einwilligung.
- Kontaktadresse, Verantwortlichkeit, Impressums- und Datenschutzinhalte.
- OG-Bilder, Meta-Descriptions und Social-Media-Material.

### Für die Reunion-Seite

- Freigegebene aktuelle Information, Ablauf, Orte, Team-/Teilnehmerstatus und
  Erinnerungsinhalte.
- Eventbilder oder ein freigegebenes Hero-Medium.
- Redaktioneller Text nach Ablauf des Countdowns.
- Zuständigkeit für Veröffentlichung und Datenschutz.

## 9. Offene Annahmen

- Die bestehende Kubio-Seite ist die maßgebliche Quelle für bestehende Slugs und
  zu migrierende Inhalte, darf aber vorerst nicht verändert werden.
- Staging ist vorhanden und für spätere Theme- und Plugin-Tests zugänglich;
  Zugangsdaten gehören nicht in dieses Repository.
- Der DHB bzw. die Rechteinhaber können Quellen, Bildrechte und Markenunterlagen
  zur Verfügung stellen oder freigeben.
- Das Repository soll dauerhaft WordPress-Inhalte nicht enthalten; WordPress
  bleibt die redaktionelle Quelle der Wahrheit.
- Die konkrete Hosting- und Deployment-Topologie ist noch offen.
- Die 2026-Reunion bleibt aus Sicht der öffentlichen Website vollständig
  getrennt, obwohl beide Projekte dieselbe Codebasis nutzen.

## 10. Phase-0-Fazit und Übergabekriterien

Die Produktidee, die grundlegende IA und die kreative Richtung sind klar genug,
um als Nächstes Phase 1 zu planen. Produktive Umsetzung wäre jetzt jedoch
verfrüht: Das Archivdatenmodell, die Quellen- und Rechtebasis, die finale
Typografie-Lizenzierung, die Inhaltsmigration und die technische
Repository-Struktur müssen zuerst dokumentiert und entschieden werden.

Für Phase 1 sollten als Erstes Navigation, Seitenhierarchie, Nutzerwege,
Kapitelreihenfolge, interne Verlinkung sowie die präzise Rolle von Archiv,
Film und Teamseite in `IA.md` festgelegt werden. Parallel sollten die fehlenden
Assets und Rechte in der späteren `CONTENT-CHECKLIST.md` geführt werden.
