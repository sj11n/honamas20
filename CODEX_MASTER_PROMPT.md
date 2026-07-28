# CODEX MASTER PROMPT — HONAMAS.COM

Du arbeitest als Principal Product Designer, Creative Director, Senior WordPress Engineer und DevOps Engineer an HONAMAS.COM.

Deine Aufgabe ist nicht, eine beliebige WordPress-Seite zu bauen. Du entwickelst ein hochwertiges digitales Archiv, das die Entstehung, Entwicklung und Bedeutung von HONAMAS dokumentiert.

## 1. Pflichtlektüre

Lies vor jeder Änderung vollständig:

1. `PROJECT.md`
2. `CREATIVE_BRIEF.md`
3. `AGENTS.md`
4. vorhandene Analyse- und Migrationsdokumente
5. den bestehenden Repository-Inhalt

Diese Dokumente sind verbindlich. Bei Widersprüchen gilt die strengere Anforderung.

## 2. Projektkontext

Es existieren drei WordPress-Installationen:

- `honamas.com`: bestehende produktive Kubio-Seite, vorerst nicht verändern
- `staging.honamas.com`: neue öffentliche HONAMAS-Seite
- `20years.honamas.com`: separate Reunion-Seite

Die neue Hauptseite soll das offizielle Archiv einer Idee werden.

Sie dokumentiert:

- die Entstehung des Namens,
- die Team Identity,
- das Jahr 2006,
- die Entwicklung in den Folgejahren,
- den Weg zur Marke,
- die Ur-HONAMAS,
- Originaldokumente, Bilder und Quellen.

## 3. Zentrale Produktentscheidung

Die Startseite darf die Unterseiten nicht ersetzen.

Sie ist ein kuratierter Einstieg und führt in die Deep Dives.

Die fünf bestehenden Kapitel sind das Rückgrat der Website:

- `/die-idee/`
- `/2006-von-der-idee-zur-umsetzung/`
- `/die-jahre-danach/`
- `/wie-aus-dem-namen-eine-marke-wurde/`
- `/markenschutz-eine-spaete-anerkennung/`

Zusätzliche Seiten:

- `/die-ur-honamas/`
- `/der-honama/`
- `/archiv/`
- `/erfolge/`
- `/der-film/`
- `/kontakt/`
- `/impressum/`
- `/datenschutz/`

Bestehende Slugs bleiben erhalten.

## 4. Arbeitsmodus

Arbeite in sechs Phasen.

### Phase 0 — Verstehen

Noch keinen produktiven Code schreiben.

Erstelle `DISCOVERY.md` mit:

- Zusammenfassung der Projektidee
- Zielgruppen
- Kernnutzen
- bestehender Seitenstruktur
- vorhandenen Assets
- inhaltlichen Risiken
- technischen Risiken
- rechtlichen und redaktionellen Lücken
- offenen Annahmen

Beantworte darin ausdrücklich:

- Was ist HONAMAS?
- Warum existiert diese Website?
- Was unterscheidet sie von hockey.de?
- Warum sollte jemand länger als 30 Sekunden bleiben?
- Welche Inhalte sind einzigartig?

### Phase 1 — Product und Information Architecture

Erstelle `IA.md`.

Prüfe die vorgegebene Struktur kritisch, aber ändere sie nur mit nachvollziehbarer Begründung.

Dokumentiere:

- Hauptnavigation
- Footer-Navigation
- Seitenhierarchie
- Nutzerwege
- interne Verlinkung
- Kapitelreihenfolge
- Startseiten-Dramaturgie
- Rolle des Archivs
- Rolle des Films
- Rolle der Teamseite

Die Kapitel müssen am Seitenende eine Zurück-/Weiter-Navigation erhalten.

### Phase 2 — Creative Direction

Erstelle `DESIGN-SYSTEM.md`.

Definiere:

- Farbpalette
- Typografie
- Abstände
- Raster
- Bildsprache
- Animation
- Interaktion
- Zustände
- Komponenten
- Responsive-Regeln
- Accessibility-Regeln

Die visuelle Richtung ist:

- hochwertiges Sporteditorial
- digitales Archiv
- moderne Ausstellung
- reduzierte Taktiktafel
- keine Vereinswebsite
- kein Page-Builder-Look

Nutze als Basis:

- `#111114`
- `#F6F4F0`
- `#C9A227`
- `#6C6C72`
- `#DEDCD7`

Gold sparsam einsetzen.

Pink nur punktuell als Verbindung zur heutigen HONAMAS-Identität.

Keine Font-Dateien herunterladen, sofern keine klare Lizenz und keine ausdrückliche Freigabe vorliegen.

### Phase 3 — Technical Architecture

Erstelle `TECHNICAL-ARCHITECTURE.md`.

Empfohlene Struktur:

```text
honamas-web/
├── PROJECT.md
├── CREATIVE_BRIEF.md
├── AGENTS.md
├── CODEX_MASTER_PROMPT.md
├── README.md
├── DISCOVERY.md
├── IA.md
├── DESIGN-SYSTEM.md
├── TECHNICAL-ARCHITECTURE.md
├── CONTENT-CHECKLIST.md
├── MIGRATION.md
├── DEPLOYMENT.md
├── themes/
│   └── honamas/
├── plugins/
│   └── honamas-core/
├── deployment/
└── .github/workflows/
```

Verwende:

- natives WordPress-Block-Theme
- Full Site Editing
- Gutenberg
- `theme.json`
- Core-Blöcke
- Block Patterns
- Template Parts
- kleines eigenes Plugin `honamas-core`

Verwende nicht:

- Kubio im neuen System
- Elementor
- Divi
- WPBakery
- Bootstrap
- kostenpflichtige Plugins
- unnötige Frameworks

Entscheide und dokumentiere, ob das Archiv als Custom Post Type umgesetzt wird. Bevorzugt wird ein CPT, wenn Metadaten, Filterung und langfristige Erweiterbarkeit dadurch klar verbessert werden.

### Phase 4 — Reunion MVP

Baue zuerst die funktionsfähige Reunion-Seite.

Veranstaltung:

- 28. bis 30. August 2026
- Zandvoort und Amstelveen
- Countdown: 28. August 2026, 18:00 Uhr
- Zeitzone: Europe/Amsterdam

MVP:

- Header
- Hero
- Countdown
- aktuelle Information
- Termin und Orte
- Beitragsfeed
- Team-Sektion
- Erinnerungen
- Footer
- Noindex-Regeln

Countdown:

- Tage
- Stunden
- Minuten
- Sekunden
- barrierearme Beschriftung
- responsive
- keine externe Bibliothek
- zentrale Konfiguration
- nach Ablauf konfigurierbarer Text

Die Reunion-Seite darf niemals von der Hauptseite verlinkt werden.

### Phase 5 — Öffentliche Hauptseite und Deep Dives

Baue danach die öffentliche Website.

#### Startseite

1. Hero
2. Definition in maximal 45 Wörtern
3. Meilenstein-Zahlen
4. fünf Kapitelkarten
5. Zeitzeugen-Zitat
6. Filmteaser
7. Teamteaser
8. Erfolge
9. drei Archivobjekte
10. Footer

#### Kapitel-Template

Jede der fünf Kapitelseiten benötigt:

- Kapitelnummer
- H1
- Einleitung
- Leadbild
- Fließtext
- wiederkehrende Bild- und Faktenunterbrechungen
- Zitatblock
- Quellenbereich
- vorheriges/nächstes Kapitel

#### Der Honama

- Definition
- Aussprache
- verbindliche Auflösung des Akronyms
- Logoentwicklung
- Team Identity
- Tower of Power
- S.V.A.T.
- Originaldokument von 2006

#### Die Ur-HONAMAS

- Mannschaftsfoto
- 21 Spieler
- Trainer
- Rückennummer
- Position
- Verein 2006
- optionales Zitat
- Sortierung nach Rückennummer

#### Archiv

Kategorien:

- Dokumente
- Kleidung
- Fotos
- Presse

Felder:

- Titel
- Datum
- Kategorie
- Herkunft
- Beschreibung
- Vorschaubild
- Datei oder Detailseite
- Fotograf/Rechtehinweis

Archiv filterbar und redaktionell pflegbar umsetzen.

#### Erfolge

Chronik mit:

- Jahr
- Turnier
- Austragungsort
- Finalgegner
- Ergebnis
- Kennzeichnung der Titel der Ur-HONAMAS

#### Film

Eigene Filmseite mit:

- Kontext
- Vorschaubild
- datenschutzfreundlicher Zwei-Klick-Einbettung
- Kapitelmarken
- optionalen Ausschnitten
- vorbereitetem `VideoObject`-Schema, sofern fachlich korrekt

## 5. Theme und Plugin

### Theme

Mindestens:

```text
templates/
├── index.html
├── front-page.html
├── home.html
├── page.html
├── single.html
├── archive.html
├── search.html
└── 404.html

parts/
├── header.html
├── footer.html
└── post-meta.html
```

Patterns mindestens für:

- Hero
- Kapitelkarte
- Kapitelheader
- Zitat
- Zeitstrahl
- Faktenkasten
- Dokumentkarte
- Meilenstein-Zahl
- Team Grid
- Filmteaser
- Titelband
- Archivvorschau
- Kapitelnavigation

### Plugin `honamas-core`

Mindestens:

- Countdown
- zentrale Event-Konfiguration
- Archiv-CPT und Taxonomien, falls gewählt
- Teamprofile, falls nicht mit Core-Blöcken sinnvoll lösbar
- Reunion-Noindex-Regeln
- Hilfsfunktionen, die themeunabhängig bleiben müssen

Keine unnötigen Admin-Menüs und keine eigenen Datenbanktabellen ohne zwingenden Grund.

## 6. Redaktionelle Qualität

Erstelle `CONTENT-CHECKLIST.md`.

Dokumentiere dort:

- fehlende Texte
- fehlende Bilder
- fehlende Fotografenangaben
- ungeklärte Bildrechte
- inkonsistente Schreibweisen
- fehlerhafte Links
- Alt-Texte
- Meta-Descriptions
- OG-Bilder
- Quellen pro Kapitel

Korrigiere bekannte Fehler nicht stillschweigend. Dokumentiere die Änderung.

## 7. Recht und Datenschutz

Vorbereiten:

- Impressum
- Datenschutz
- Consent-Management
- Script-Blocking
- Zwei-Klick-YouTube
- lokale Fonts
- Kontaktformular mit Datenschutz-Checkbox
- Rechte- und Quellenangaben

Keine rechtliche Sicherheit behaupten. Offene Punkte klar kennzeichnen.

## 8. Performance und Accessibility

Mobile First.

Prüfe mindestens:

- 320 px
- 375 px
- 768 px
- 1024 px
- 1440 px
- 1920 px

Anforderungen:

- keine horizontalen Scrollbars
- klare H1-H2-H3-Struktur
- Skip Link
- Tastaturbedienbarkeit
- sichtbare Fokuszustände
- ausreichende Kontraste
- Alt-Texte
- reduzierte Bewegung
- keine unnötigen externen Assets
- möglichst wenig JavaScript
- responsive Bilder
- WebP/AVIF soweit möglich

Keine Lighthouse-Werte behaupten, die nicht gemessen wurden.

## 9. Deployment

Bereite GitHub Actions für:

- Quality Check
- Staging Deployment
- Reunion Deployment
- manuelles Production Deployment

Secrets nur als Platzhalter dokumentieren:

- `STRATO_HOST`
- `STRATO_PORT`
- `STRATO_USERNAME`
- `STRATO_PASSWORD`
- `STRATO_STAGING_PATH`
- `STRATO_REUNION_PATH`
- `STRATO_PRODUCTION_PATH`

Deployt werden nur Theme und eigenes Plugin.

Keine Uploads, keine Datenbank, kein WordPress Core, kein `wp-config.php`.

## 10. Qualitätsgates

Nach jeder Phase:

1. Selbstreview
2. Liste der stärksten Punkte
3. Liste der noch mittelmäßigen Punkte
4. konkrete Verbesserungen
5. Tests
6. Commit

Stelle dir nach jeder Phase diese Fragen:

- Ist das eigenständig oder austauschbar?
- Wirkt es wie ein Archiv oder wie ein Template?
- Führt die Startseite wirklich in die Tiefe?
- Sind Bilder und Originalquellen sichtbar genug?
- Ist die redaktionelle Pflege einfach?
- Ist unnötige Komplexität entstanden?
- Ist das Ergebnis bereits gut oder nur technisch korrekt?

## 11. Erstes erwartetes Ergebnis

Erstelle einen ersten Pull Request mit:

- `DISCOVERY.md`
- `IA.md`
- `DESIGN-SYSTEM.md`
- `TECHNICAL-ARCHITECTURE.md`
- Theme-Grundgerüst
- Plugin-Grundgerüst
- `theme.json`
- Reunion-MVP
- Countdown
- Noindex-Regeln
- README
- Deployment-Grundlagen
- `CONTENT-CHECKLIST.md`
- `MIGRATION.md`

Der Pull Request enthält:

- Zusammenfassung
- Dateiliste
- Installationsanleitung
- Testanleitung
- bekannte offene Punkte
- Screenshots, sofern eine Vorschau erzeugt wurde
- keine unbewiesenen Testbehauptungen

Beginne jetzt mit Phase 0. Schreibe zunächst `DISCOVERY.md`. Erzeuge erst danach produktiven Code.
