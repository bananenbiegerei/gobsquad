import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import fs from 'node:fs';
import path from 'node:path';

const hotFile = path.resolve(import.meta.dirname, 'dist/hot');

/**
 * Writes dist/hot with the dev server's origin while `vite` is running,
 * removes it on exit — functions/vite.php reads this file's presence to
 * decide whether to point enqueued assets at the dev server or the
 * manifest-based production build.
 */
function hotFilePlugin() {
  return {
    name: 'gobsquad-hot-file',
    configureServer(server) {
      const writeHotFile = () => {
        const address = server.httpServer?.address();
        if (!address || typeof address === 'string') return;
        const protocol = server.config.server.https ? 'https' : 'http';
        fs.mkdirSync(path.dirname(hotFile), { recursive: true });
        fs.writeFileSync(hotFile, `${protocol}://localhost:${address.port}`);
      };
      server.httpServer?.once('listening', writeHotFile);
      const cleanup = () => {
        if (fs.existsSync(hotFile)) fs.rmSync(hotFile);
      };
      process.on('exit', cleanup);
      process.on('SIGINT', () => process.exit());
      process.on('SIGTERM', () => process.exit());
    },
  };
}

export default defineConfig({
  root: '.',
  publicDir: 'public',
  plugins: [tailwindcss(), hotFilePlugin()],
  server: {
    // The dev server is fetched cross-origin from the WordPress site
    // (e.g. https://gob.local) rather than being same-origin, so CORS
    // must be explicitly allowed or the browser blocks @vite/client and
    // the entry module.
    cors: true,
  },
  build: {
    outDir: 'dist',
    manifest: true,
    emptyOutDir: true,
    rollupOptions: {
      input: {
        app: 'src/assets/js/app.js',
      },
    },
  },
});
