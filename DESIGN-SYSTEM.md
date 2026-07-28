# Design-System – HONAMAS.COM

**Phase:** 2 – Creative Direction  
**Stand:** 29. Juli 2026  
**Status:** Verbindliche Design- und UX-Richtung für die öffentliche Seite

## 1. Die gestalterische Entscheidung

HONAMAS.COM fühlt sich beim ersten Besuch wie eine moderne Sportmarke an, nicht wie ein Archivportal. Die Geschichte und die Originalquellen geben der Seite Substanz; die Oberfläche bleibt jung, klar, flach und selbstverständlich bedienbar.

Die Referenz ist nicht das Aussehen einer bestehenden Apple- oder Nike-Seite, sondern deren Prinzip: wenige, präzise Entscheidungen pro Bildschirm, großzügige Ruhe, hochwertige Medien und eine Bedienung, die keine Erklärung braucht.

**Leitbild:** Eine helle, selbstbewusste Marke erzählt eine echte Geschichte. Das Archiv ist die Beweisebene im Hintergrund, nicht die visuelle Hauptrolle jeder Ansicht.

## 2. Visuelle Haltung

Die Seite wirkt:

- hell und offen statt dunkel und museal,
- sportlich und präzise statt laut oder fanhaft,
- editorial, aber nicht magazinig überladen,
- hochwertig durch Proportion, Bildauswahl und Materialität,
- unmittelbar verständlich statt erklärungsbedürftig.

Sie vermeidet:

- sichtbare „Archivportal“-Chromleisten,
- Kartensammlungen ohne klare Aufgabe,
- abgerundete Kachel-Landschaften,
- dekorative Farbverläufe, Muster und Pseudo-3D,
- mehrere gleich laute Handlungsaufforderungen,
- künstliche Nostalgie und überinszenierte Animation.

## 3. Farbe und Flächen

Die Hauptseite baut überwiegend auf Weiß und leicht warmem Off-White auf. Dunkel dient Text, Navigation und gezielten Kontrastmomenten. Gold bleibt ein seltener historischer Marker; Pink verbindet punktuell zur heutigen Identität.

| Token | Wert | Verwendung |
| --- | --- | --- |
| `--honamas-ink` | `#111114` | Text, Header, dunkle Medienüberlagerung |
| `--honamas-white` | `#FFFFFF` | Primäre Seitenfläche und ruhige Inhaltsbereiche |
| `--honamas-paper` | `#F6F4F0` | Abgesetzte Kapitel- und Archivflächen |
| `--honamas-gold` | `#C9A227` | Kapitelnummer, Jahreszahl, feine Fokusakzente |
| `--honamas-grey` | `#6C6C72` | Sekundärtext und Metadaten |
| `--honamas-line` | `#DEDCD7` | Teilungslinien, Felder, ruhige Grenzen |
| `--honamas-pink` | bestehender Markenwert nach Asset-Abgleich | einzelne aktuelle Hinweise, niemals Flächenfarbe |

Regeln:

- Weiß ist die dominierende Fläche.
- Off-White gliedert komplette Abschnitte, nicht einzelne dekorative Kästen.
- Schwarz wird für den Hero, Film- oder einzelne Abschlussmomente eingesetzt, nicht als dauerhaftes Seitenfundament.
- Gold markiert Orientierung und Herkunft, nie große Textflächen oder primäre Buttons.
- Rot erscheint ausschließlich, wenn es aus einem konkreten Foto, Dokument oder historischen Kontext stammt.

## 4. Typografie

Montserrat ist die bestätigte Hauptschrift. Sie gibt der Seite den jungen, klaren und modernen Charakter. Die Seite nutzt nicht mehrere auffällige Schriftfamilien gegeneinander; Hierarchie entsteht über Größe, Gewicht, Zeilenhöhe und Raum.

| Rolle | Schrift | Gewicht und Verhalten |
| --- | --- | --- |
| Marke, H1, Kapitelnummer | Montserrat | 600–700, klar, ohne Effekte |
| H2 und große Statements | Montserrat | 500–600, großzügige Zeilenhöhe |
| Fließtext | Montserrat | 400–500, maximal 68 Zeichen pro Zeile |
| Navigation, Buttons, Metadaten | Montserrat | 500–600, kompakt und gut lesbar |
| Fallback | `Arial`, `Helvetica`, sans-serif | systemnah und stabil |

Typografische Regeln:

- Das Wortzeichen `HONAMAS` ist die stärkste Textform und erhält im Hero deutlich mehr Raum als jeder Begleittext.
- H1 wird groß, aber nicht gequetscht oder mit negativer Laufweite gesetzt.
- Lange Texte bleiben bei mindestens 18 px auf Desktop und 16 px auf Mobilgeräten; Zeilenhöhe mindestens 1,55.
- Labels sind klein, in Versalien und mit positiver Laufweite. Sie dienen Orientierung, nicht Dekoration.
- Zitate erhalten Größe und Leerraum statt Anführungszeichen-Inszenierung.
- Montserrat-Dateien werden ausschließlich lokal und erst nach Lizenz- beziehungsweise Bestandsprüfung eingebunden. Bis dahin bleiben systemnahe Fallbacks zulässig.

## 5. Raster und Raum

| Bereich | Desktop | Mobil |
| --- | --- | --- |
| Seitenbreite | maximal 1.280 px | volle Breite |
| Seitlicher Rand | 32–48 px | 20 px |
| Lesespalte | maximal 720 px | volle Inhaltsbreite |
| Standardabschnitt | 112–160 px vertikal | 72–96 px vertikal |
| Kompakter Abschnitt | 48–72 px vertikal | 32–48 px vertikal |
| Eckenradius | 0–8 px | 0–8 px |

Das Layout verwendet wenige stabile Spalten: eine breite Bühne für Hero und Bilder, eine kontrollierte Lesespalte für Geschichte sowie ein zweispaltiges Raster für ausgewählte Teaser. Es gibt keine verschachtelten Karten und keine schwimmenden Container innerhalb von Containerflächen.

## 6. Startseite: moderne Erzählung statt Archiv-Einstieg

### Hero

Der Hero ist ein ruhiger, vollbreiter Moment mit Filmhintergrund oder einem starken Originalbild.

- Oberhalb: transparente, später beim Scrollen helle Navigation.
- Inhalt: `HONAMAS`, `Champions since 2006` und ein einziger Textlink oder Button: „Die Geschichte entdecken“.
- Das Video läuft stumm, ohne sichtbare Bedienelemente im Vordergrund und mit einem aussagekräftigen Standbild als Fallback.
- Ein klarer Kontrastlayer sichert die Lesbarkeit; keine Verläufe als dekoratives Stilmittel.
- Bei `prefers-reduced-motion`, Data Saver oder fehlendem Video wird das Posterbild statisch ausgeliefert.

### Story-Flow

Nach dem Hero folgt keine Archivwand. Die Abfolge ist leicht lesbar und wechselt gezielt zwischen großen Aussagen, historischem Bildmaterial und kurzen Interaktionen:

1. Ein Satz zur Bedeutung von HONAMAS.
2. Vier Meilensteine als horizontale Jahresleiste, auf Mobilgeräten als klare vertikale Liste.
3. Fünf Kapitel als großzügige, nummerierte Story-Zeilen. Jede Zeile führt direkt in ein Kapitel; sie ist kein dekoratives Kachelraster.
4. Ein echtes Zitat als Atemzug der Seite.
5. Filmteaser als dunkler, kinogleicher Kontrastmoment.
6. Teamteaser mit einem Bild und einem einzigen klaren Einstieg.
7. Erfolge als knappe Zeile, nicht als Trophäenwand.
8. Drei echte Archivobjekte als letzte Vertiefung mit sichtbarer Herkunft.

## 7. Navigation und Orientierung

### Header

- Desktop: links Wortmarke, mittig oder rechts fünf klare Hauptpunkte, rechts ein Menü-Icon nur bei enger Breite.
- Mobil: Wortmarke, Menü-Icon und ein fokussierbares Vollbild- beziehungsweise Vollbreitenmenü.
- `Die Geschichte` öffnet eine einfache Liste der fünf Kapitel. Kein Mega-Menü, keine Vorschaubilder im Menü.
- Der Header bleibt beim Scrollen schlank sichtbar und wechselt auf hellem Grund zu weißer Fläche mit feiner Trennlinie.

### Kapitelorientierung

- Kapitelnummer und Titel stehen immer sichtbar über der H1.
- Eine feine Fortschrittsanzeige darf die Position innerhalb der fünf Kapitel zeigen; sie ist kein Fortschrittsbalken zur Manipulation der Scrolltiefe.
- Am Ende gibt es zwei gleichwertige, klar beschriftete Navigationsziele: vorheriges und nächstes Kapitel.
- Breadcrumbs sind nicht nötig. Der Abschnitt `Die Geschichte` und die Kapitelnummer liefern genug Orientierung.

## 8. Komponenten

| Komponente | Aufgabe | Erscheinung |
| --- | --- | --- |
| Primärbutton | eine zentrale Aktion je Bereich | dunkle Fläche, weiße Schrift, maximal 8 px Radius |
| Textlink | sekundäre Navigation | Text mit feiner Pfeilbewegung beim Hover |
| Kapitelzeile | Einstieg in eine Story | große Zahl, Titel, kurze Einordnung, klare Trennlinie |
| Meilenstein | schnelle zeitliche Orientierung | Jahr groß, Erklärung klein, keine Kacheloptik |
| Bildmodul | Originalmaterial zeigen | vollflächig oder sauber gerahmt, Caption direkt darunter |
| Faktenmodul | eine belegte Information bündeln | Off-White-Fläche, klare Typografie, keine Schatten |
| Zitat | Zeitzeugenstimme hervorheben | große Schrift, viel Weißraum, Quelle sichtbar |
| Filmteaser | zum Film führen | dunkle Bühne mit Poster, Play-Icon und einem Ziel |
| Teamteaser | Einstieg zur Ur-HONAMAS-Seite | Mannschaftsfoto, kurze Zeile, Textlink |
| Archivobjekt | Beleg zugänglich machen | Vorschau, Kategorie, Datum, Herkunft, Detailansicht |
| Filter | Archiv gezielt durchsuchen | Text-Tabs oder Select auf Mobil, kein Tag-Chaos |

Buttons zeigen bekannte Symbole, wenn sie eine Werkzeugfunktion auslösen. Textbuttons bleiben für echte Befehle wie „Die Geschichte entdecken“ oder „Film ansehen“ reserviert. Alle interaktiven Elemente besitzen Hover-, Fokus-, Aktiv-, Deaktiviert- und Ladezustände.

## 9. Bild- und Video-Regeln

- Originalbilder haben Vorrang; ihre Zeitlichkeit wird nicht wegretuschiert.
- Historisches Material darf in Schwarzweiß oder warm zurückhaltend bearbeitet werden, wenn die Aussage erhalten bleibt.
- Jedes Bild enthält Alt-Text, Jahr und Herkunft beziehungsweise Credit, soweit bekannt.
- Bildunterschriften sind ruhig und klein, aber nie versteckt.
- Film und Bewegtbild starten nie mit Ton.
- Es gibt keine austauschbaren Stockbilder und keine KI-generierten Ersatzbilder für historische Inhalte.
- Porträts der Ur-HONAMAS folgen einem einheitlichen Zuschnitt; fehlende Porträts bleiben als klar markierte editorische Lücke sichtbar.

## 10. Bewegung und Rückmeldung

Bewegung hilft bei Orientierung und Materialität, nicht bei Selbstdarstellung.

- Einblendungen: maximal 180–280 ms, vor allem bei Bildern und Abschnittswechseln.
- Hover: leichte Verschiebung von Textlinks oder Bildzoom bis maximal 2 %.
- Navigation: Menü und Fokuszustände erscheinen unmittelbar.
- Keine Daueranimation, kein Scroll-Jacking, kein Parallax-Showcase.
- Bei `prefers-reduced-motion: reduce` werden alle nicht notwendigen Übergänge und der Video-Hintergrund deaktiviert.

## 11. Archiv: funktional, erst dann sichtbar

Die Archivseite darf dichter sein als die Storyseiten, bleibt aber einfach:

- Ein eindeutiger Seitentitel und ein Satz zur Sammlung.
- Vier Kategorien als leicht verständliche Filter.
- Ein Filterstatus ist in der URL abbildbar und per Tastatur bedienbar.
- Objekte erscheinen in einem stabilen Raster mit echten Metadaten, nicht als visuelle Tapete.
- Die Detailseite zeigt zuerst das Objekt, dann Kontext, Herkunft, Credit und passende Kapitelverweise.
- Leere Kategorien und fehlende Inhalte werden ehrlich benannt; sie erzeugen keine leeren Designflächen.

## 12. Responsive und Barrierefreiheit

- Die Seite wird mobil zuerst gedacht: eine Spalte, ausreichend große Touch-Ziele von mindestens 44 × 44 px und keine versteckten Kernfunktionen.
- Desktop nutzt Breite für Bildwirkung und ruhige Lesespalten, nicht für zusätzliche Bedienkomplexität.
- Kontrast erfüllt mindestens WCAG AA; Gold auf Weiß wird nie für Fließtext verwendet.
- Sichtbare Tastaturfokusse bleiben in allen Zuständen erhalten.
- Navigation, Untermenüs, Filter und Videoeinbettung funktionieren vollständig mit Tastatur und Screenreader.
- Dekorative Bilder erhalten leeren Alt-Text; inhaltliche Bilder erhalten beschreibende Texte.
- Video bekommt Untertitel und eine datenschutzfreundliche Zwei-Klick-Einbettung, falls eine externe Plattform verwendet wird.
- Inhalte reflowen bis 320 px Breite ohne horizontales Scrollen.

## 13. Umsetzungskonsequenzen

Diese Richtung ersetzt keine Inhalte und keine Quellenanforderungen. Sie verändert ihre Gewichtung in der Oberfläche:

- Die Startseite verkauft nicht das Archiv, sondern die Neugier auf die Geschichte.
- Die Kapitel lesen sich wie hochwertige, moderne Stories.
- Das Archiv folgt als belegbare Vertiefung.
- Die Wiederverwendbarkeit für die Reunion beschränkt sich auf Tokens, Typografie, Raster und Komponenten, nicht auf die öffentliche Navigation oder inhaltliche Dramaturgie.

Vor der produktiven Umsetzung werden die vorhandenen Theme-Dateien gegen dieses Design-System geprüft. Insbesondere ältere Reunion-Patterns und eine etwaige dunkle, kartenlastige Gestaltung dürfen nicht als Ausgangspunkt für die öffentliche Seite übernommen werden.

## 14. Offene Prüfungen

| Thema | Entscheidung | Noch zu klären |
| --- | --- | --- |
| Montserrat | Als Hauptschrift bestätigt | vorhandene lokale Dateien und Lizenz dokumentieren |
| Herofilm | Essenziell, leise und stumm | Quelldatei, Poster, Rechte, Untertitel, Ladebudget |
| Pink | nur punktueller Akzent | exakter Markenwert aus bestehenden Assets |
| Bilder | Originalmaterial hat Vorrang | Credits, Alt-Texte und Freigaben je Asset |
| Archiv | Belegebene, keine Startseitenoptik | finale Objektanzahl und Filterumfang |

## 15. Phasenabschluss

Die öffentliche HONAMAS-Seite wird als moderne, helle Sportmarke mit einer nachvollziehbaren Geschichte gestaltet. Ihre Eleganz kommt aus Reduktion, echten Bildern und klarer Führung – nicht aus Effektfülle.

**Nächste Phase:** `TECHNICAL-ARCHITECTURE.md` definiert, wie dieses System als pflegbares WordPress-Block-Theme und kleines Inhaltsplugin umgesetzt wird.
