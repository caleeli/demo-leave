import fs from 'fs';
import path from 'path';

/**
 * Vite plugin to convert manifest.json to mix-manifest.json format.
 */
export default function convertToMixManifest(config) {
  return {
    name: 'convert-to-mix-manifest',
    writeBundle() {
      const addManifestPath = config.addManifest
        ? path.resolve(config.outDir, config.addManifest)
        : null;
      const manifestPath = path.resolve(config.outDir, 'manifest.json');
      const mixManifestPath = path.resolve(config.outDir, 'mix-manifest.json');
      const readPath = config.addManifest ? addManifestPath : manifestPath;

      fs.readFile(readPath, (err, data) => {
        if (err) throw err;
        const manifest = JSON.parse(data);
        const mixManifest = {};
        Object.values(manifest).forEach((value) => {
          mixManifest[`/${value.file}`] = `/${value.file}`;
        });

        if (config.addManifest && fs.existsSync(mixManifestPath)) {
          const existing = JSON.parse(fs.readFileSync(mixManifestPath, 'utf8'));
          fs.writeFileSync(mixManifestPath, JSON.stringify({ ...existing, ...mixManifest }, null, 2));
          return;
        }
        fs.writeFileSync(mixManifestPath, JSON.stringify(mixManifest, null, 2));
      });
    },
  };
}
