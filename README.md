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
