# HONAMAS 20

Custom WordPress block theme foundation for the HONAMAS web platform.

The project follows the architecture and design rules in `AGENTS.md`.

## Structure

```text
wp-content/
  themes/
    honamas/
      assets/
      parts/
      patterns/
      styles/
      templates/
      functions.php
      style.css
      theme.json
.github/workflows/
scripts/
AGENTS.md
README.md
```

## Local WordPress Usage

1. Copy or mount this repository into a WordPress installation.
2. Activate the `HONAMAS` theme in the WordPress admin.
3. Build editorial pages with Core blocks and the provided HONAMAS patterns.

The public HONAMAS website must not link to or mention the reunion microsite.

## Static Theme Preview

A quick visual demo is available without WordPress:

```bash
python3 -m http.server 8080 --directory preview
```

Then open `http://localhost:8080`.

This preview mirrors the theme direction, not the final WordPress rendering.

## Deployment

Deployment must happen through staging first. Production releases require manual approval and a rollback path.

## Editing the redesigned site

- Pages (start page, five chapters, Der Honama, Die Ur-HONAMAS, Erfolge, Der Film) are normal WordPress pages built from core blocks.
  Their first content comes from **Werkzeuge › HONAMAS-Inhalte** (plugin `honamas-core`); existing pages keep their previous version as a revision.
- A page belongs to the chapter story when it uses the template **Kapitel der Geschichte**. The chapter navigation, the
  „weiter“ links and the chapter column on plain pages follow the **page order** (Reihenfolge) of those pages.
- The Ur-HONAMAS lists come from **Ur-HONAMAS** (Teammitglieder): name, Spitzname, Rückennummer, Position, Verein 2006,
  Zitat and portrait (Beitragsbild) appear automatically on the start page and on /die-ur-honamas/.
- The interactive parts are built in the browser from ordinary blocks: the syllables HO-NA-MA-S from the list with the
  class `syl-list`, the chapter accordion from the groups with the class `stage`.
- Impressum, Datenschutz and Kontakt use the standard page template; their legal text is never overwritten by the import.
