# Scripts

Project utility scripts can live here as the platform grows.

Do not place deployment credentials or environment-specific secrets in this directory.

## build-preview.mjs

Generates the chapter and detail pages of the static preview (`preview/*.html`, everything except `index.html`):

```bash
node scripts/build-preview.mjs
```

The start page `preview/index.html` is hand-written. Chapter text lives in the script and follows `HONAMAS_CONTENT.md`.
