# AGENTS.md — HONAMAS Web

## 1. Verbindliche Projektregeln

Vor jeder Änderung müssen `PROJECT.md`, `CREATIVE_BRIEF.md` und diese Datei vollständig gelesen werden.

Das Repository ist die technische Quelle der Wahrheit für:

- Theme-Code
- Plugin-Code
- Styles
- JavaScript
- Templates
- Patterns
- Deployment
- technische Dokumentation

WordPress ist die redaktionelle Quelle der Wahrheit für:

- Seiteninhalte
- Beiträge
- Archivobjekte
- Bilder
- Metadaten
- Teamprofile

## 2. Installationen

- `honamas.com`: bestehende Live-Seite mit Kubio, vorerst nicht verändern
- `staging.honamas.com`: Entwicklungs- und Testumgebung
- `20years.honamas.com`: separate Reunion-Seite

Keine produktive Änderung ohne ausdrückliche Freigabe.

## 3. Technischer Ansatz

Verwende:

- WordPress Core
- natives Block-Theme
- Full Site Editing
- Gutenberg
- `theme.json`
- Core-Blöcke
- Block Patterns
- Template Parts
- eigenes kleines Plugin `honamas-core`

Nicht verwenden:

- Kubio im neuen System
- Elementor
- Divi
- WPBakery
- Bootstrap
- kostenpflichtige Plugins
- proprietäre Page-Builder-Abhängigkeiten
- unnötige Frameworks

## 4. Codequalität

- WordPress Coding Standards
- PHP 8.2+
- Eingaben validieren
- Ausgaben escapen
- Nonces bei Formularaktionen
- Capabilities prüfen
- keine Secrets im Repository
- keine Änderungen an WordPress Core
- keine unnötigen Datenbanktabellen
- keine hart codierten Domains
- keine hart codierten HTTP/HTTPS-URLs

## 5. Redaktionelle Bedienbarkeit

Alle wiederkehrenden Inhalte müssen im Backend pflegbar sein.

Bevorzugte Reihenfolge:

1. Core-Blöcke und Patterns
2. Custom Post Types und native Metafelder
3. kleine eigene Block-Erweiterungen
4. externe Plugins nur, wenn fachlich zwingend

## 6. Informationsarchitektur

Die Startseite bleibt kompakt. Unterseiten sind Deep Dives.

Die fünf Kapitel müssen jeweils enthalten:

- Kapitelnummer
- H1
- Leadbild
- Fließtext
- Bild oder Faktenkasten nach spätestens 3–4 Absätzen
- Quellenbereich
- Zurück-/Weiter-Navigation

Bestehende Slugs nicht ohne Grund ändern.

## 7. Archiv

Das Archiv ist kein Nebenbereich.

Es muss strukturiert, filterbar und langfristig erweiterbar sein.

Mindestfelder:

- Titel
- Datum
- Kategorie
- Herkunft
- Beschreibung
- Vorschaubild
- Datei oder Detailansicht
- Fotograf/Rechtehinweis

## 8. Medien

- keine fremden Bilder automatisch herunterladen
- keine Font-Dateien ohne klare Lizenz einbinden
- Alt-Texte vorsehen
- Bildunterschriften unterstützen
- WebP/AVIF nutzen, soweit WordPress unterstützt
- responsive Bildgrößen verwenden
- Hero nicht lazy-loaden
- sonstige Bilder lazy-loaden

## 9. Reunion-Seite

Die Reunion-Seite bleibt vollständig von der Hauptseite getrennt.

Umsetzen:

- noindex
- nofollow
- noarchive
- nosnippet
- Ausschluss aus Sitemaps, soweit zuverlässig möglich
- kein Link von der Hauptseite
- kein Link im Footer
- keine automatische Beziehung über Navigation oder Patterns

Noindex ist kein Zugriffsschutz. Dies in der Dokumentation klar benennen.

## 10. Accessibility

- semantische Überschriftenstruktur
- Skip Link
- Tastaturbedienbarkeit
- sichtbare Fokuszustände
- ausreichende Kontraste
- keine Information nur über Farbe
- `prefers-reduced-motion`
- sinnvolle Linktexte
- ausreichende Touch-Ziele

## 11. Performance

- möglichst wenig JavaScript
- kein jQuery für neue Funktionen
- keine externen Icon-Fonts
- SVG bevorzugen
- keine unnötigen Render-Blocking-Ressourcen
- Assets nur laden, wenn benötigt
- keine Performance-Werte behaupten, die nicht gemessen wurden

## 12. Recht und Datenschutz

Das System muss vorbereiten bzw. unterstützen:

- Impressum
- Datenschutz
- Consent-Management
- Zwei-Klick-YouTube-Einbettung
- lokale Fonts
- Kontaktformular mit Datenschutzbezug
- Rechte- und Quellenangaben bei Bildern und Archivobjekten

Keine Rechtsberatung behaupten.

## 13. Deployment

Deployt werden nur:

- eigenes Theme
- eigenes Plugin

Nicht deployen:

- WordPress Core
- Uploads
- Datenbank
- `wp-config.php`
- fremde Plugins

Production-Deployment nur manuell und nach ausdrücklicher Freigabe.

## 14. Arbeitsweise

Vor Code:

1. Bestand prüfen
2. Risiken benennen
3. Informationsarchitektur verifizieren
4. technische Entscheidung dokumentieren

Nach jeder Phase:

- Tests ausführen
- offene Punkte dokumentieren
- keine unerledigten Annahmen verstecken
- klaren Commit erstellen

Keine unnötigen Rückfragen. Bei fehlenden Inhalten mit sichtbaren Platzhaltern arbeiten und diese in `CONTENT-CHECKLIST.md` dokumentieren.
