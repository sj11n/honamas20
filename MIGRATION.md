# Migrationsplan – HONAMAS.COM

**Stand:** 29. Juli 2026  
**Status:** Vorbereitete Bestandsaufnahme – noch keine Migration erfolgt

## 1. Ziel und Grenzen

Dieser Plan migriert die vorhandenen Inhalte von `honamas.com` in die neue öffentliche WordPress-Staging-Installation, ohne den bestehenden Kubio-Auftritt zu verändern. Grundlage ist `HONAMAS_CONTENT.md`; der tatsächliche Medienbestand wird erst mit WordPress-Zugang gegen diese Liste geprüft.

Der Plan enthält weder Zugangsdaten noch einen Produktions-Deploy. Er ersetzt keine fachliche Freigabe von Texten, Quellen oder Bildrechten.

## 2. Migrationsprinzipien

- Originaldateien, Originaldokumente und vorhandene Texte haben Vorrang.
- Jede Quelle wird vor dem Umzug einem Zielabschnitt und, wenn passend, einem Archivobjekt zugeordnet.
- Bilder werden nicht nur kopiert: Alt-Text, Caption, Jahr, Herkunft, Credit und Rechte werden ergänzt.
- Es werden keine Inhalte erfunden und keine unklaren Rechte stillschweigend als geklärt behandelt.
- Bestehende Slugs bleiben erhalten.
- Die öffentliche Seite enthält keine Reunion-Verweise.
- Der produktive Kubio-Auftritt wird bis zur ausdrücklichen Freigabe nicht verändert.

## 3. Ablauf

### Schritt 1: Zugriff und Export

1. Im bestehenden WordPress `Medien` und `Seiten` sichten.
2. Medienliste mit ID, URL, Dateiname, Datum, Größe und Alt-Text exportieren.
3. Alle aktuellen Seiten als Block-, HTML- oder redaktionellen Export sichern.
4. Film-, Social- und externe Links mit Ziel und Einbettungsart erfassen.
5. Vor Änderungen ein vollständiges Backup der bestehenden Installation bestätigen.

### Schritt 2: Inventarisierung

1. Jedes bekannte Asset aus Abschnitt 5 gegen eine WordPress-Medien-ID abgleichen.
2. Fehlende Credits, Rechte, Jahre und Bildbeschreibungen in `CONTENT-CHECKLIST.md` markieren.
3. Assets mit ungeklärten Rechten aus der Staging-Auswahl ausschließen, nicht durch Stockmaterial ersetzen.
4. Erste Archivobjekte mit vollständigen Metadaten auswählen.

### Schritt 3: Staging-Inhalte

1. Theme und Plugin auf Staging aktivieren.
2. Seiten mit vereinbarten Slugs anlegen.
3. Originalmedien in die Staging-Mediathek übertragen und dort sauber beschriften.
4. Kapitel, Team, Film, Erfolge und Archivobjekte einpflegen.
5. Navigation, Footer, interne Links, Metadaten und externe Einbindungen konfigurieren.

### Schritt 4: Prüfung und Freigabe

1. Inhaltlichen Abgleich gegen `HONAMAS_CONTENT.md` durchführen.
2. Quellen, Rechte, Captions, Alt-Texte und Credits je Asset prüfen.
3. Mobile und Desktop visuell prüfen; Video, Filter und Kapitelwechsel per Tastatur testen.
4. Linkcheck, Datenschutzcheck, Performancecheck und Redirect-Plan prüfen.
5. Nutzerin gibt Staging frei; erst danach wird ein Produktionsplan erstellt.

## 4. Seitenzuordnung

| Bestehender Inhalt | Zielroute | Zielstruktur | Status |
| --- | --- | --- | --- |
| Startseite | `/` | kompakter Hero, Definition, Meilensteine, Kapitel, Film, Team, Erfolge, Archivteaser | vorzubereiten |
| Die Idee | `/die-idee/` | Kapitel 1 mit drei Bildern, Text, Quellen und Weiterführung | vorzubereiten |
| 2006 – Von der Idee zur Umsetzung | `/2006-von-der-idee-zur-umsetzung/` | Kapitel 2 mit Logo, Team Identity und Kleidung | vorzubereiten |
| Die Jahre danach | `/die-jahre-danach/` | Kapitel 3 mit Kontext und 2015-Beleg | vorzubereiten |
| Wie aus dem Namen eine Marke wurde | `/wie-aus-dem-namen-eine-marke-wurde/` | Kapitel 4 mit Reece-, Medien- und Sporthilfe-Belegen | vorzubereiten |
| Markenschutz – eine späte Anerkennung | `/markenschutz-eine-spaete-anerkennung/` | Kapitel 5 mit Markenunterlagen | vorzubereiten |
| Die Ur-HONAMAS | `/die-ur-honamas/` | Mannschaftsfoto und Teamraster aus Teamdaten | vorzubereiten |
| Der Honama | `/der-honama/` | Definition, Team Identity und Originaldokument | neu anzulegen |
| Erfolge | `/erfolge/` | kuratierte Chronik mit Quellen | neu anzulegen |
| Archiv | `/archiv/` | CPT-Übersicht und Objektseiten | neu anzulegen |
| Der Film | `/der-film/` | Filmkontext und Zwei-Klick-Einbettung | neu anzulegen |
| Kontakt, Impressum, Datenschutz | feste Routen | Service- und Pflichtseiten | Inhalte fehlen teilweise |

## 5. Asset-Register: bekannte Bestandsgruppen

| ID | Assetgruppe | Vermutete Quelle | Ziel | Archivkategorie | Status |
| --- | --- | --- | --- | --- | --- |
| A-01 | HONAMAS-Logo und Varianten | bestehende WordPress-Mediathek | Hero, Header, Kapitel 2 | Dokumente | Medien-ID offen |
| A-02 | Hero-Bild oder Hero-Film | bestehende WordPress-Mediathek oder Filmquelle | Startseite | – | Datei und Rechte offen |
| A-03 | drei Bilder zur Namensidee | bestehende WordPress-Mediathek | Kapitel 1 | Fotos | Medien-IDs, Captions, Credits offen |
| A-04 | Team-Identity-Originaldokument | bestehende WordPress-Mediathek | Der Honama, Kapitel 2 | Dokumente | Quelldatei und Rechte prüfen |
| A-05 | Trainingskleidung und Ausrüstung | bestehende WordPress-Mediathek | Kapitel 2 | Kleidung | Einzelobjekte und Credits offen |
| A-06 | Unterwäsche mit HONAMAS-Logo | bestehende WordPress-Mediathek | Kapitel 2 | Kleidung | Rechte und Kontext prüfen |
| A-07 | Fan-Shirts | bestehende WordPress-Mediathek | Kapitel 2 | Kleidung | Datum, Menge, Credit prüfen |
| A-08 | Bild aus 2015 | bestehende WordPress-Mediathek | Kapitel 3 | Fotos | Caption, Credit und Kapitelbezug offen |
| A-09 | Reece-Entwürfe 2017 | bestehende WordPress-Mediathek | Kapitel 4 | Dokumente | Designrechte und Quellen prüfen |
| A-10 | Sporthilfe-Magazin | bestehende WordPress-Mediathek | Kapitel 4 | Presse | Ausgabe, Coverrechte und Quelle offen |
| A-11 | Instagram-/Medienbelege | bestehende WordPress-Mediathek oder externe Plattform | Kapitel 4 | Presse | Permalinks, Rechte, Consent offen |
| A-12 | Markenschutzunterlagen | bestehende WordPress-Mediathek | Kapitel 5 | Dokumente | Datenschutz und Vollständigkeit prüfen |
| A-13 | Film und Poster | YouTube und/oder WordPress-Mediathek | Der Film, Startseite | – | Video-ID, Poster, Rechte, Untertitel offen |
| A-14 | Mannschaftsfoto von 2006 | bestehende WordPress-Mediathek | Die Ur-HONAMAS | Fotos | Personen, Jahr, Credit prüfen |
| A-15 | Einzelporträts der 21 Ur-HONAMAS | bestehende WordPress-Mediathek | Die Ur-HONAMAS | Fotos | Bestand, Freigaben und Zuschnitt offen |

## 6. Teamdaten: bekannter Bestand

Die folgenden Namen und Spitznamen stammen aus `HONAMAS_CONTENT.md`. Sie werden erst nach dem Abgleich mit dem WordPress-Bestand und der fachlichen Freigabe als Teamprofile angelegt:

| Name | Spitzname | Porträt | Rückennummer/Position/Verein 2006 |
| --- | --- | --- | --- |
| Ulrich Bubolz | Bubi | offen | offen |
| Sebastian Biederlack | Buddy | offen | offen |
| Carlos Nevado | Carlito | offen | offen |
| Sebastian Draghun | Dragon | offen | offen |
| Björn Emmerling | Emmel | offen | offen |
| Tim Jessulat | Enti | offen | offen |
| Eike Duckwitz | General | offen | offen |
| Philipp Crone | Hupe | offen | offen |
| Jan-Marco Montag | Jambo | offen | offen |
| Niklas Meinert | Meini | offen | offen |
| Moritz Fürste | Mo | offen | offen |
| Nicolás Emmerling | Nici | offen | offen |
| Philipp Witte | Piwi | offen | offen |
| Justus Scharowski | Scharo | offen | offen |
| Christian Schulte | Schüti | offen | offen |
| Tibor Weißenborn | Tibs | offen | offen |
| Oliver Hentschel | Ulln | offen | offen |
| Timo Wess | Wesa | offen | offen |
| Matthias Witthaus | Witti | offen | offen |
| Philipp Zeller | Zello | offen | offen |
| Christopher Zeller | Zells | offen | offen |

## 7. Nicht migrieren

- Kubio-Layouts, -Blöcke, -Shortcodes oder Designabhängigkeiten.
- nicht bestätigte Tracking- oder Marketing-Skripte.
- Zugangsdaten, Konfigurationsdateien und Datenbankinhalte.
- unklare Medienrechte oder nicht freigegebene Porträts.
- Reunion-Inhalte, -Navigation oder -SEO-Einstellungen in die öffentliche Präsenz.

## 8. Abnahmekriterien

Eine Migrationswelle gilt nur als abgeschlossen, wenn:

- jeder Eintrag im Asset-Register eine Staging-Medien-ID und eine Zielzuordnung hat,
- alle sichtbaren Bilder Alt-Text, Caption und Credit beziehungsweise dokumentierten Grund für das Fehlen enthalten,
- alle Archivobjekte vollständige Kernmetadaten besitzen,
- die fünf Kapitel inhaltlich vollständig und nur mit freigegebenen Änderungen vorliegen,
- interne Links und die Kapitel-Navigation funktionieren,
- keine Reunion-Verweise und keine Kubio-Abhängigkeiten verbleiben,
- die Nutzerin die Staging-Ansicht fachlich freigegeben hat.

## 9. Aktueller Blocker

Die Planung ist vollständig vorbereitet. Die tatsächliche Inventarisierung und Migration benötigen Zugriff auf die WordPress-Mediathek und das Staging. Bis dahin bleiben alle Medien-IDs, Dateiformate, Credits, Rechte und externen Ziel-URLs bewusst als offen markiert.
