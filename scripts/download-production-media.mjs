#!/usr/bin/env node

import { access, mkdir, writeFile } from "node:fs/promises";
import path from "node:path";

const source = "https://honamas.com/wp-json/wp/v2/media";
const outputDirectory = process.argv[2] ?? "/private/tmp/honamas-media";
const perPage = 100;
const media = [];

for (let page = 1; ; page += 1) {
  const response = await fetch(`${source}?per_page=${perPage}&page=${page}`);

  if (response.status === 400) {
    break;
  }

  if (!response.ok) {
    throw new Error(`Media list request failed with ${response.status}.`);
  }

  const batch = await response.json();
  media.push(...batch);

  if (batch.length < perPage) {
    break;
  }
}

await mkdir(outputDirectory, { recursive: true });

const manifest = [];

for (const item of media) {
  const rawUrl = item.source_url ?? item.guid?.rendered;
  const sourceUrl = rawUrl.replace(/^http:/, "https:");
  const sourceName = path.basename(new URL(sourceUrl).pathname);
  const filename = `${item.id}-${sourceName}`;
  const target = path.join(outputDirectory, filename);
  try {
    await access(target);
  } catch {
    const response = await fetch(sourceUrl);

    if (!response.ok) {
      throw new Error(`Download failed for ${item.id}: ${response.status}.`);
    }

    await writeFile(target, Buffer.from(await response.arrayBuffer()));
  }
  manifest.push({
    id: item.id,
    title: item.title?.rendered ?? "",
    sourceUrl,
    filename,
    altText: item.alt_text ?? "",
    caption: item.caption?.rendered ?? "",
  });
}

await writeFile(
  path.join(outputDirectory, "manifest.json"),
  `${JSON.stringify(manifest, null, 2)}\n`,
);

console.log(`Downloaded ${manifest.length} media files to ${outputDirectory}.`);
