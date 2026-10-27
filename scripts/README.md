# Scripts

Project utility scripts can live here as the platform grows.

Do not place deployment credentials or environment-specific secrets in this directory.

## build-content.mjs

Writes the starting content of the redesigned pages as core block markup into
`wp-content/plugins/honamas-core/content/` (one file per page, `pages.json`, and the media they use):

```bash
node scripts/build-content.mjs
```

The content reaches WordPress through **Werkzeuge › HONAMAS-Inhalte › Inhalte übernehmen** in wp-admin.
After that import the pages live in WordPress and are edited there; the script is only the starting point.
Bump `version` in the generated `pages.json` only when a new starting content should be offered again.

## build-preview.mjs

Generates the static design preview in `preview/` (reference only; WordPress is the source of the content).
