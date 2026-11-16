import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import fs from 'node:fs';
import path from 'node:path';

const hotFile = path.resolve(import.meta.dirname, 'dist/hot');

/**
 * Local (localwp.com) site host. The WordPress site is served over HTTPS at
 * this host; Safari refuses mixed content even from http://localhost, so the
 * dev server must also be HTTPS. We reuse Local's already-trusted certificate
 * for the site, which makes the dev server reachable as https://gob.local:5173.
 * If the certificate isn't present (other machine / no Local), we fall back
 * to plain http://localhost, which Chrome and Firefox accept.
 */
const localSiteHost = 'gob.local';
const localCertsDir = path.join(
  process.env.HOME ?? '',
  'Library/Application Support/Local/run/router/nginx/certs'
);
const localCert = path.join(localCertsDir, `${localSiteHost}.crt`);
const localKey = path.join(localCertsDir, `${localSiteHost}.key`);
const useLocalHttps = fs.existsSync(localCert) && fs.existsSync(localKey);

const devServerHttps = useLocalHttps
  ? { cert: fs.readFileSync(localCert), key: fs.readFileSync(localKey) }
  : undefined;
const devServerHost = useLocalHttps ? localSiteHost : 'localhost';

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
        fs.writeFileSync(hotFile, `${protocol}://${devServerHost}:${address.port}`);
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
    https: devServerHttps,
    // Requests arrive with Host: gob.local:5173, which Vite rejects by
    // default (only localhost/IPs are allowed) unless listed here.
    allowedHosts: useLocalHttps ? [localSiteHost] : undefined,
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
