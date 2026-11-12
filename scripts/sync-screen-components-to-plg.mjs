#!/usr/bin/env node
/**
 * @deprecated demo-leave bundles screen components locally (`npm run build:screen-builder`).
 * Legacy helper: copies Vue + catalog into sibling package-plg for old monorepo workflows.
 */
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const root = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const plgRoot = process.env.PACKAGE_PLG_ROOT || path.resolve(root, '../package-plg');
const catalogPath = path.join(root, 'resources/js/designer/public-screen-components.json');
const plgCatalogPath = path.join(plgRoot, 'resources/js/designer/public-screen-components.json');
const srcVue = path.join(root, 'resources/js/projects/demoLeave');
const destVue = path.join(plgRoot, 'resources/js/projects/demoLeave');

function mergeCatalog() {
  if (!fs.existsSync(plgRoot)) {
    console.warn(`package-plg not found at ${plgRoot}; skip catalog merge`);
    return;
  }
  const add = JSON.parse(fs.readFileSync(catalogPath, 'utf8'));
  const base = fs.existsSync(plgCatalogPath)
    ? JSON.parse(fs.readFileSync(plgCatalogPath, 'utf8'))
    : [];
  const names = new Set(base.map((entry) => entry.name));
  let merged = 0;
  add.forEach((entry) => {
    if (!names.has(entry.name)) {
      base.push(entry);
      names.add(entry.name);
      merged += 1;
    }
  });
  fs.writeFileSync(plgCatalogPath, `${JSON.stringify(base, null, 2)}\n`);
  console.log(`Merged ${merged} catalog entries into package-plg`);
}

function copyTree(src, dest) {
  if (!fs.existsSync(src)) {
    throw new Error(`Missing source Vue tree: ${src}`);
  }
  fs.rmSync(dest, { recursive: true, force: true });
  fs.mkdirSync(path.dirname(dest), { recursive: true });
  fs.cpSync(src, dest, { recursive: true });
  console.log(`Copied Vue tree to ${dest}`);
}

mergeCatalog();
if (fs.existsSync(plgRoot)) {
  copyTree(srcVue, destVue);
} else {
  console.warn('Skipping Vue copy; set PACKAGE_PLG_ROOT if package-plg lives elsewhere.');
}
