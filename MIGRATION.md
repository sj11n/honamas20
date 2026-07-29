# Migrationsplan – HONAMAS.COM

**Stand:** 29. Juli 2026  
**Status:** Technische Migrationswelle abgeschlossen – redaktionelle Zuordnung und Freigabe offen

## 1. Ziel und Grenzen

Dieser Plan migriert die vorhandenen Inhalte von `honamas.com` in die neue öffentliche WordPress-Staging-Installation, ohne den bestehenden Kubio-Auftritt zu verändern. Grundlage ist `HONAMAS_CONTENT.md`; die erste Sichtprüfung des Medienbestands erfolgte am 29. Juli 2026.

Der Plan enthält weder Zugangsdaten noch einen Produktions-Deploy. Er ersetzt keine fachliche Freigabe von Texten, Quellen oder Bildrechten.

## 2. Verifizierter Produktionsbestand

Die erste Sichtprüfung erfolgte ausschließlich lesend im bestehenden WordPress. Dabei wurden keine Seiten, Medien, Einstellungen oder Kommentare verändert.

| Bereich | Verifizierter Stand | Konsequenz |
| --- | --- | --- |
| WordPress | Version 6.8.3, Theme Vertice mit Kubio-Bestand | nicht verändern; nur als Inhalts- und Medienquelle behandeln |
| Seiten | neun veröffentlichte Seiten sichtbar | bestehende Slugs vor Staging-Migration einzeln abgleichen |
| Mediathek | 183 Dateien auf zehn Seiten, Datumsarchive Oktober und November 2025 | vollständige Listeninventur mit IDs, Credits und Rechten folgt |
| Mannschaftsfoto | Medien-ID 416, `Team_Honamas.jpg` | für Teamseite vormerken; Credit, Jahr und Freigabe ergänzen |
| Einzelporträts | zahlreiche benannte PNG-Dateien vorhanden, darunter Bubi, Buddy, Jambo, Meini, Mo, Nici, Piwi, Scharo, Schüti, Tibs, Ulln, Wesa, Witti, Zello und Zells | alle 21 Namen gegen Medien-IDs und einheitliche Darstellung abgleichen |
| Legacy-URLs | die Mediathek zeigt teilweise HTTP-Download-URLs | nicht übernehmen; Staging erzeugt neue HTTPS-Medien-URLs |

Die Staging-Installation ist separat. Am 29. Juli 2026 wurden das HONAMAS-Block-Theme und das Plugin `HONAMAS Core` installiert und aktiviert. Alle 183 Dateien aus der öffentlich erreichbaren Produktions-Mediathek wurden in die Staging-Mediathek übertragen. Die Übertragung ersetzt keine Rechte-, Credit- oder Freigabeprüfung.

Der bestehende Kubio-Auftritt auf `honamas.com` blieb während dieser Arbeiten unverändert.

## 3. Migrationsprinzipien

- Originaldateien, Originaldokumente und vorhandene Texte haben Vorrang.
- Jede Quelle wird vor dem Umzug einem Zielabschnitt und, wenn passend, einem Archivobjekt zugeordnet.
- Bilder werden nicht nur kopiert: Alt-Text, Caption, Jahr, Herkunft, Credit und Rechte werden ergänzt.
- Es werden keine Inhalte erfunden und keine unklaren Rechte stillschweigend als geklärt behandelt.
- Bestehende Slugs bleiben erhalten.
- Die öffentliche Seite enthält keine Reunion-Verweise.
- Der produktive Kubio-Auftritt wird bis zur ausdrücklichen Freigabe nicht verändert.

## 4. Ablauf

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

1. Theme und Plugin auf Staging aktivieren. **Erledigt.**
2. Seiten mit vereinbarten Slugs anlegen. **Die fünf Kapitel sind auf Staging veröffentlicht.**
3. Originalmedien in die Staging-Mediathek übertragen und dort sauber beschriften. **Übertragung erledigt; Beschriftung und Zuordnung offen.**
4. Kapitel, Team, Film, Erfolge und Archivobjekte einpflegen.
5. Navigation, Footer, interne Links, Metadaten und externe Einbindungen konfigurieren.

### Schritt 4: Prüfung und Freigabe

1. Inhaltlichen Abgleich gegen `HONAMAS_CONTENT.md` durchführen.
2. Quellen, Rechte, Captions, Alt-Texte und Credits je Asset prüfen.
3. Mobile und Desktop visuell prüfen; Video, Filter und Kapitelwechsel per Tastatur testen.
4. Linkcheck, Datenschutzcheck, Performancecheck und Redirect-Plan prüfen.
5. Nutzerin gibt Staging frei; erst danach wird ein Produktionsplan erstellt.

## 5. Seitenzuordnung

| Bestehender Inhalt | Zielroute | Zielstruktur | Status |
| --- | --- | --- | --- |
| Startseite | `/` | kompakter Hero, Definition, Meilensteine, Kapitel, Film, Team, Erfolge, Archivteaser | vorzubereiten |
| Die Idee | `/die-idee/` | Kapitel 1 mit Text, Quellenhinweis und Weiterführung | auf Staging veröffentlicht; Bilder und Credits offen |
| 2006 – Von der Idee zur Umsetzung | `/2006-von-der-idee-zur-umsetzung/` | Kapitel 2 mit Text, Quellenhinweis und Kapitelnavigation | auf Staging veröffentlicht; Logo, Bilder und Credits offen |
| Die Jahre danach | `/die-jahre-danach/` | Kapitel 3 mit Text, Quellenhinweis und Kapitelnavigation | auf Staging veröffentlicht; Bild und Credit offen |
| Wie aus dem Namen eine Marke wurde | `/wie-aus-dem-namen-eine-marke-wurde/` | Kapitel 4 mit Text, Quellenhinweis und Kapitelnavigation | auf Staging veröffentlicht; Reece-, Medien- und Sporthilfe-Belege offen |
| Markenschutz – eine späte Anerkennung | `/markenschutz-eine-spaete-anerkennung/` | Kapitel 5 mit Text, Quellenhinweis und Zurück-Navigation | auf Staging veröffentlicht; Markenunterlagen und Prüfung offen |
| Die Ur-HONAMAS | `/die-ur-honamas/` | Mannschaftsfoto und Teamraster aus Teamdaten | vorzubereiten |
| Der Honama | `/der-honama/` | Definition, Team Identity und Originaldokument | neu anzulegen |
| Erfolge | `/erfolge/` | kuratierte Chronik mit Quellen | neu anzulegen |
| Archiv | `/archiv/` | CPT-Übersicht und Objektseiten | neu anzulegen |
| Der Film | `/der-film/` | Filmkontext und Zwei-Klick-Einbettung | neu anzulegen |
| Kontakt, Impressum, Datenschutz | feste Routen | Service- und Pflichtseiten | Inhalte fehlen teilweise |

## 6. Asset-Register: bekannte Bestandsgruppen

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
| A-14 | Mannschaftsfoto von 2006 | bestehende WordPress-Mediathek, ID 416, `Team_Honamas.jpg` | Die Ur-HONAMAS | Fotos | Personen, Jahr, Credit und Freigabe prüfen |
| A-15 | Einzelporträts der 21 Ur-HONAMAS | bestehende WordPress-Mediathek, Bestand teilweise verifiziert | Die Ur-HONAMAS | Fotos | alle Medien-IDs, Freigaben und einheitlichen Zuschnitt erfassen |

## 7. Teamdaten: bekannter Bestand

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

## 8. Nicht migrieren

- Kubio-Layouts, -Blöcke, -Shortcodes oder Designabhängigkeiten.
- nicht bestätigte Tracking- oder Marketing-Skripte.
- Zugangsdaten, Konfigurationsdateien und Datenbankinhalte.
- unklare Medienrechte oder nicht freigegebene Porträts.
- Reunion-Inhalte, -Navigation oder -SEO-Einstellungen in die öffentliche Präsenz.

## 9. Abnahmekriterien

Eine Migrationswelle gilt nur als abgeschlossen, wenn:

- jeder Eintrag im Asset-Register eine Staging-Medien-ID und eine Zielzuordnung hat,
- alle sichtbaren Bilder Alt-Text, Caption und Credit beziehungsweise dokumentierten Grund für das Fehlen enthalten,
- alle Archivobjekte vollständige Kernmetadaten besitzen,
- die fünf Kapitel inhaltlich vollständig und nur mit freigegebenen Änderungen vorliegen,
- interne Links und die Kapitel-Navigation funktionieren,
- keine Reunion-Verweise und keine Kubio-Abhängigkeiten verbleiben,
- die Nutzerin die Staging-Ansicht fachlich freigegeben hat.

## 10. Aktueller Stand und offene Punkte

Die Zugänge zu WordPress und Staging sind vorhanden. Theme, Plugin und 183 Medien sind auf Staging aktiv beziehungsweise übertragen. Die fünf Story-Kapitel wurden mit den vorhandenen Texten, Originalzitaten, Quellenhinweisen und Kapitellinks veröffentlicht. Offen bleiben die vollständige Medieninventur, Credits, Rechte, externe Film- und Social-URLs sowie die Zuordnung der Medien zu den jeweiligen Abschnitten.

Staging ist derzeit über HTTP erreichbar. Vor einer externen Prüfung oder Veröffentlichung muss HTTPS verbindlich eingerichtet und erzwungen werden.
