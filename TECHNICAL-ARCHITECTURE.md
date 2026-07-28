# Technische Architektur – HONAMAS.COM

**Phase:** 3 – Technical Architecture  
**Stand:** 29. Juli 2026  
**Status:** Verbindliche Umsetzungsentscheidung vor produktivem Ausbau

## 1. Architekturentscheidung

HONAMAS.COM wird als natives WordPress-Block-Theme mit Full Site Editing umgesetzt. Das Theme verantwortet ausschließlich Darstellung, Templates, Patterns und kleine progressive Verbesserungen. Strukturierte, langfristig relevante Inhalte und Funktionen liegen in einem kleinen, vom Theme unabhängigen Plugin `honamas-core`.

Diese Aufteilung hält den Redaktionsalltag einfach: Die meisten Seiten entstehen aus Core-Blöcken und Patterns; Archivobjekte und Teamdaten bleiben trotzdem sauber filterbar, sortierbar und bei einem Themewechsel erhalten.

| Baustein | Verantwortung | Nicht enthalten |
| --- | --- | --- |
| Theme `honamas` | Design-System, Templates, Template Parts, Block Patterns, lokale Frontend-Assets | Geschäftslogik, Inhaltsdatenmodelle, Datenbanktabellen |
| Plugin `honamas-core` | Archiv- und Teamdaten, Metadaten, Filterlogik, Video-Consent, optionale Reunion-Konfiguration | Layout- und Markenentscheidungen |
| WordPress Core | Gutenberg, Menüs, Medien, Seiten, Beiträge, Benutzer, REST-API | Page Builder, externe Abhängigkeiten |

Es werden weder Kubio noch Elementor, Divi, WPBakery, Bootstrap oder kostenpflichtige Plugins eingesetzt.

## 2. Technische Leitplanken

- **Mindestumgebung:** WordPress 6.6 oder neuer, PHP 8.1 oder neuer, MySQL 8.0 oder MariaDB 10.6 oder neuer.
- **Rendering:** serverseitiges WordPress-HTML; JavaScript ergänzt nur Navigation, Filterzustände und datenschutzkonforme Medieninteraktionen.
- **Abhängigkeiten:** keine Frontend-Frameworks, keine jQuery-Pflicht, keine externen Font-CDNs.
- **Datenbank:** ausschließlich WordPress-Standardtabellen und registrierte Metadaten. Keine eigenen Tabellen.
- **Sprachen:** Deutsch als Inhaltssprache. Alle sichtbaren Umlaute werden korrekt geschrieben; technische Slugs bleiben wie vereinbart ASCII-kompatibel.
- **Konfiguration:** keine Domains, Tokens, Zugangsdaten oder produktspezifischen Geheimnisse im Theme oder Plugin.

## 3. Zielstruktur im Repository

Die bestehende WordPress-konforme Struktur bleibt erhalten. Sie vermeidet einen zweiten, künstlichen Theme-Pfad und lässt sich direkt in eine WordPress-Installation übernehmen.

```text
Honamas20/
├── PROJECT.md
├── CREATIVE_BRIEF.md
├── HONAMAS_CONTENT.md
├── AGENTS.md
├── CODEX_MASTER_PROMPT.md
├── DISCOVERY.md
├── IA.md
├── DESIGN-SYSTEM.md
├── TECHNICAL-ARCHITECTURE.md
├── CONTENT-CHECKLIST.md              # folgt vor der Inhaltsmigration
├── MIGRATION.md                      # folgt mit dem WordPress-Medienabgleich
├── DEPLOYMENT.md                     # folgt vor dem ersten Staging-Release
├── preview/                          # statische Vorschau, keine Produktquelle
├── scripts/                          # nur lokale Hilfen, keine Geheimnisse
└── wp-content/
    ├── themes/
    │   └── honamas/
    │       ├── assets/
    │       │   ├── css/
    │       │   ├── js/
    │       │   ├── fonts/
    │       │   └── images/
    │       ├── parts/
    │       ├── patterns/
    │       ├── styles/
    │       ├── templates/
    │       ├── functions.php
    │       ├── style.css
    │       └── theme.json
    └── plugins/
        └── honamas-core/
            ├── honamas-core.php
            ├── includes/
            ├── templates/
            ├── assets/
            └── languages/
```

`preview/` dient nur der frühen visuellen Abstimmung. Die WordPress-Patterns und Templates sind die spätere einzige Produktquelle.

## 4. Theme `honamas`

### 4.1 Aufgaben

Das Theme verwendet ausschließlich native WordPress-Block-Theme-Mechanismen:

- `theme.json` für Tokens, Typografie, Abstände, Layoutbreiten und Blockstandards.
- HTML-Templates für Seitenarten und Custom Post Types.
- Template Parts für Header, Footer sowie wiederverwendbare Meta- und Kapitelbereiche.
- PHP-Pattern-Dateien für redaktionell einsetzbare, vorkonfigurierte Core-Blöcke.
- eine kleine, gebündelte CSS-Datei für Komponenten, die sich nicht sinnvoll über `theme.json` ausdrücken lassen.
- JavaScript nur dort, wo HTML und CSS nicht genügen.

Die aktuelle Theme-Grundlage wird gezielt weiterentwickelt, nicht blind erweitert: die bestehende dunkle, CTA-lastige Frontpage und Reunion-Patterns werden vor der öffentlichen Umsetzung durch die helle Startseitenstruktur aus `DESIGN-SYSTEM.md` ersetzt oder aus dem öffentlichen Pattern-Katalog entfernt.

### 4.2 Templates

| Template | Aufgabe |
| --- | --- |
| `front-page.html` | kuratierte öffentliche Startseite |
| `page.html` | Standardseiten wie Kontakt und Rechtliches |
| `page-story.html` | optionale Kapitelvorlage mit Kapitelheader, Quellen und Vor/Zurück-Navigation |
| `archive-honamas_archive_item.html` | Archivübersicht unter `/archiv/` |
| `single-honamas_archive_item.html` | Objektansicht mit Metadaten und Kontextlinks |
| `single-honamas_team_member.html` | optionale öffentliche Profilseite |
| `single.html`, `archive.html`, `search.html`, `404.html` | konsistente Standardfälle |

Die fünf historischen Kapitel bleiben WordPress-Seiten mit ihren festgelegten Slugs. Sie verwenden ein gemeinsames Kapitel-Pattern beziehungsweise die Vorlage `page-story.html`; der Inhalt bleibt vollständig im Block-Editor pflegbar.

### 4.3 Pattern-Katalog

Patterns bilden nur wiederkehrende redaktionelle Bausteine ab:

- Video-Hero mit Poster-Fallback und einem Einstieg
- Kapitelheader
- Kapitelzeile und Kapitelübersicht
- Meilensteinleiste
- Bild mit Caption und Quellenangabe
- Zitatblock
- Faktenmodul
- Filmteaser
- Teamteaser und Teamraster
- Archivvorschau und Archivobjektkarte
- Kapitelnavigation
- Titelband und schlichter Servicebereich

Alle Patterns setzen auf Core-Blöcke. Sie enthalten keine erfundenen Fakten, keine fest verdrahteten Produktions-URLs und keine nicht editierbaren Platzhalterdaten.

### 4.4 Assets und Verhalten

- CSS wird über `wp_enqueue_style()` geladen und nach jeder Änderung minimiert beziehungsweise auf unnötige Regeln geprüft.
- JavaScript wird mit `defer` geladen, ohne globale Bibliothek und nur bei Seiten, die es benötigen.
- Lokale Montserrat-Dateien werden erst nach Lizenz- und Bestandsprüfung als `@font-face` eingebunden. Bis dahin bleibt der System-Fallback funktionsfähig.
- Hero-Poster, responsive Bilder und Vorschaubilder kommen aus der WordPress-Mediathek, nicht aus fest codierten Theme-Pfaden.
- Das Theme sendet keine Daten an Dritte und lädt keine externen Schrift-, Analyse- oder Kartenressourcen.

## 5. Plugin `honamas-core`

### 5.1 Grundsätze

Das Plugin erhält nur Funktionen, die auch bei einem Themewechsel erhalten bleiben müssen. Es registriert keine eigenen Datenbanktabellen, keine unnötigen Admin-Menüs und keine dekorativen Blöcke.

Die Codebasis wird objektorientiert oder mit klar getrennten, präfixierten Modulen strukturiert. Alle Funktionen, Hooks, Optionen, Post Types und Metafelder beginnen mit `honamas_`.

### 5.2 Archiv als Custom Post Type

**Entscheidung:** Das Archiv wird als Custom Post Type `honamas_archive_item` umgesetzt.

Das ist notwendig, weil jedes Objekt eigene Metadaten, eine eigenständige Detailseite, Kontextverweise und eine langfristig erweiterbare Filterung benötigt. Eine Sammlung aus normalen Seiten oder manuell gepflegten Bildgalerien wäre für Quellen, Rechte und Redaktion nicht robust genug.

| Element | Entscheidung |
| --- | --- |
| Post Type | `honamas_archive_item` |
| Öffentliche Übersicht | `/archiv/` |
| Detail-URL | `/archiv/%postname%/` |
| Kategorien | Taxonomie `honamas_archive_category` |
| Anfangskategorien | Dokumente, Kleidung, Fotos, Presse |
| Editor | Gutenberg und Beitragsbild |
| REST | aktiviert für Gutenberg und spätere Schnittstellen |
| Suche | aktiv, sofern die Inhaltssuche das Objekt sinnvoll einbezieht |

Registrierte Metadaten:

| Metaschlüssel | Inhalt | Redaktionelle Regel |
| --- | --- | --- |
| `honamas_asset_date` | Datum oder Zeitraum des Objekts | ISO-Datum, Jahr oder dokumentierter Zeitraum |
| `honamas_origin` | Herkunft | konkrete Quelle, Sammlung oder Besitzerin/Owner |
| `honamas_credit` | Fotografin, Fotograf oder Credit | sichtbar, soweit bekannt |
| `honamas_rights_note` | Rechtehinweis | keine Rechtebehauptung ohne Freigabe |
| `honamas_source_url` | externer Originalbeleg | nur geprüfte HTTPS-URL |
| `honamas_related_chapter` | zugehörige Kapitel-Seite | WordPress-Seiten-ID |
| `honamas_file_id` | optionale Primärdatei | WordPress-Medien-ID |

Das Plugin liefert eine schmale, zugängliche Filterlogik über URL-Parameter und Standard-WordPress-Abfragen. Die Filter funktionieren ohne JavaScript; JavaScript darf sie später nur beschleunigen.

### 5.3 Teamdaten

**Entscheidung:** Die 21 Ur-HONAMAS werden als Custom Post Type `honamas_team_member` geführt.

Die Daten sind mehr als ein einmaliger Textblock: Sie brauchen einheitliche Porträts, Sortierung nach Rückennummer und später gegebenenfalls ergänzte Herkunfts- oder Profilinformationen. Der Post Type hat keine eigene Archivseite, kann aber bei Bedarf öffentliche Einzelprofile erhalten.

| Metaschlüssel | Inhalt |
| --- | --- |
| `honamas_jersey_number` | Rückennummer und Sortierung |
| `honamas_nickname` | dokumentierter Spitzname |
| `honamas_position_2006` | Position, wenn belegt |
| `honamas_club_2006` | Verein, wenn belegt |
| `honamas_team_quote` | optionales, freigegebenes Zitat |

Das Mannschaftsfoto und das Teamraster bleiben reine Theme- beziehungsweise Core-Block-Präsentation. Die Datenquelle dafür ist der Post Type, nicht eine fest verdrahtete Liste im Template.

### 5.4 Film und Datenschutz

Für den Film wird eine kleine, themeunabhängige Zwei-Klick-Einbettung vorgesehen:

- Vor Zustimmung wird nur ein lokales Poster mit Kontext und Play-Button gezeigt.
- Erst nach aktiver Zustimmung wird der externe Player geladen.
- Plattform, Video-ID, Poster, Titel und Untertitelhinweis sind redaktionell konfigurierbar.
- Die konkrete Datenschutzerklärung und das Consent-Management werden vor Staging rechtlich abgestimmt.

Ob dies als dynamischer Block `honamas/video` oder als eng begrenzter Shortcode umgesetzt wird, wird bei der Umsetzung anhand der verfügbaren WordPress-Version entschieden. Ein dynamischer Block ist bevorzugt, weil er im Editor verständlich und wiederverwendbar bleibt.

### 5.5 Reunion-Trennung

Die öffentliche Seite hat Priorität. Eine spätere Reunion kann dasselbe Plugin für eine zentrale Event-Konfiguration und `noindex`-Regeln verwenden, erhält jedoch:

- eigene Template- und Pattern-Zuordnung,
- eigene Navigation und Footer,
- eigene Inhaltsabfragen,
- eigene Sichtbarkeits- und SEO-Regeln,
- keine automatische Verlinkung von HONAMAS.COM.

Die frühere Reihenfolge aus dem Master Prompt, zuerst ein Reunion-MVP zu bauen, ist durch die bestätigte Projektentscheidung ersetzt: zuerst die öffentliche Seite. Die gemeinsame technische Basis bleibt davon unberührt.

## 6. Redaktioneller Ablauf

| Inhalt | Pflegeort | Qualitätssicherung |
| --- | --- | --- |
| Startseite und Kapitel | Seiten und Core-Blöcke | Quellen, Links, Alt-Texte, Vor/Zurück-Navigation |
| Archivobjekte | `honamas_archive_item` | Metadaten, Credit, Rechte, Kapitelbezug |
| Teammitglieder | `honamas_team_member` | Rückennummer, Name, Spitzname, Porträt, Freigabe |
| Medien | WordPress-Mediathek | Alt-Text, Caption, Jahr, Herkunft, Rechte |
| Film | Video-Block/Plugin-Konfiguration | Poster, Plattform, Consent, Untertitel |
| Navigation | Website-Editor | alle verbindlichen Routen, keine Reunion-Verweise |

Vor der Migration entsteht `CONTENT-CHECKLIST.md`. Sie hält offene Texte, fehlende Bilder, Credits, Rechte, Alt-Texte, Meta-Descriptions, OG-Bilder, Quellen und defekte Links sichtbar fest.

## 7. Sicherheit, Datenschutz und Zugriffe

- Staging und Produktion verwenden getrennte WordPress-Administrationskonten und getrennte SFTP-Zugänge.
- Es werden keine Zugangsdaten in Git, WordPress-Optionen ohne Schutz oder Theme-Dateien gespeichert.
- Nur notwendige Benutzerrollen; Redaktion erhält keine FTP- oder Hostingrechte.
- Alle Eingaben und Metadaten werden mit WordPress-APIs validiert, bereinigt und beim Ausgeben escaped.
- Externe Videos laden erst nach Zustimmung. Weitere externe Dienste benötigen vor Aktivierung eine Datenschutzprüfung.
- Backups, Updates, HTTPS, Spam-/Kommentarstrategie und Consent-Lösung gehören in das Staging- und Betriebsprotokoll, nicht in das Theme.

## 8. Performance, SEO und Accessibility

### Performance

- Bildgrößen über die WordPress-Mediathek, WebP/AVIF nur wenn vom Hosting zuverlässig unterstützt.
- Hero-Video nur mit Poster-Fallback, klarer Dateigrößen-Grenze und ohne blockierendes Autoplay mit Ton.
- Keine externen Font-Requests, keine unnötigen Skripte, keine Page-Builder-Bundles.
- Lazy Loading für Medien unterhalb des sichtbaren Bereichs; Hero-Bild priorisiert laden.
- Zielwerte vor Go-live: LCP unter 2,5 Sekunden, INP unter 200 ms und CLS unter 0,1 unter realistischem Mobilfunkprofil.

### SEO

- Jede Seite hat einen eindeutigen Seitentitel, eine Meta-Description und ein geeignetes OG-Bild.
- Semantische Überschriften beginnen mit einer H1 pro Seite.
- Archivdetailseiten liefern klare Canonicals; Filterseiten erzeugen keine unnötigen Indexvarianten.
- `VideoObject`-Structured Data wird erst mit verifizierten Videoangaben ausgegeben.
- Die Produktionsumstellung erhält nach dem aktuellen URL-Abgleich einen Redirect-Plan.

### Accessibility

- Core-Blöcke, semantische Templates und sichtbare Fokuszustände sind die Ausgangsbasis.
- Navigation, Filter, Kapitelwechsel und Zwei-Klick-Video sind vollständig per Tastatur bedienbar.
- Farbkontrast erfüllt mindestens WCAG 2.2 AA.
- `prefers-reduced-motion` deaktiviert nicht notwendige Bewegung und den bewegten Hero-Hintergrund.
- Bilder, Captions und Credits werden im Migrationsprozess zugänglich beschrieben, nicht nachträglich versteckt.

## 9. Staging, Deployment und Rückbau

1. Der bestehende Kubio-Auftritt auf `honamas.com` bleibt unverändert.
2. Theme und Plugin werden ausschließlich nach `staging.honamas.com` übertragen und dort aktiviert.
3. Medien und Inhalte werden zuerst in einer überprüfbaren Testmigration angelegt.
4. Fachliche Freigabe, responsive Sichtprüfung, Linkcheck, Datenschutz- und Performanceprüfung erfolgen auf Staging.
5. Ein Produktionsrelease erfolgt nur mit ausdrücklicher Freigabe, dokumentiertem Backup und einem getesteten Rückbauplan.

Deployt werden ausschließlich das eigene Theme und das eigene Plugin. WordPress Core, Uploads, Datenbank, `wp-config.php` und fremde Plugins werden nicht aus diesem Repository veröffentlicht.

Die konkrete Serveradresse, SFTP-Zielpfade, Datenbanksicherung und Release-Kommandos werden erst nach Zugangserhalt in `DEPLOYMENT.md` dokumentiert. Geheimnisse gehören in einen sicheren Secret-Speicher, nie in diese Datei.

## 10. Qualitätsgates vor Code und Go-live

### Vor produktivem Ausbau

- `CONTENT-CHECKLIST.md` und `MIGRATION.md` anlegen.
- Aktuelle WordPress-Medien und Altseiten gegen die Quellenliste abgleichen.
- Lizenzstatus der lokalen Montserrat-Dateien dokumentieren.
- Herofilm, Poster, Untertitel und Rechte bestätigen.
- Staging-Zugriff und Backup-Prozess verifizieren.

### Vor Staging-Freigabe

- PHP-Lint für Theme und Plugin.
- `theme.json`-Validierung und Block-Editor-Smoke-Test.
- Sichtprüfung in aktuellem Safari, Chrome und Firefox sowie auf Mobilgeräten.
- Tastatur-, Fokus-, Kontrast- und Reduced-Motion-Test.
- Archivfilter ohne JavaScript testen.
- Linkcheck, Bild-Credit-Check, Datenschutz- und Performance-Check.

## 11. Offene Risiken und Entscheidungen

| Thema | Entscheidung | Risiko oder nächster Schritt |
| --- | --- | --- |
| Bestehendes Theme | nur als technisches Startmaterial | öffentliche Frontpage und Reunion-Patterns müssen gezielt überarbeitet werden |
| Medienbestand | aus bestehendem WordPress migrieren | Rechte, Credits und Originaldateien pro Asset erfassen |
| Montserrat | gewünschte Hauptschrift | Lizenz der vorhandenen lokalen Dateien vor Go-live prüfen |
| Video | Zwei-Klick, Poster-Fallback, kein Ton | Plattform, Rechte, Untertitel und Ladebudget offen |
| Archiv-CPT | umgesetzt im Plugin | endgültige Metadaten nach Medieninventar bestätigen |
| Team-CPT | umgesetzt im Plugin | Rückennummern, Positionen und Vereine nur nach Quellen eintragen |
| Staging | verpflichtend vor Produktion | Zugang und Hostingpfade fehlen noch |

## 12. Phasenabschluss

Die Architektur hält die öffentliche HONAMAS-Seite modern und einfach, ohne ihre Quellenbasis zu verlieren: Das Theme bleibt schlank, das Plugin verwaltet nur echte Struktur, und WordPress Core trägt den redaktionellen Alltag.

**Nächste Arbeit:** `CONTENT-CHECKLIST.md` und `MIGRATION.md` anlegen, den vorhandenen WordPress-Bestand erfassen und danach Theme und Plugin gegen das bestätigte Design-System umsetzen.
