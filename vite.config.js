import { defineConfig, loadEnv } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import fullReload from 'vite-plugin-full-reload';
import fs from 'node:fs';
import path from 'node:path';

const hotFile = path.resolve(import.meta.dirname, 'dist/hot');
const localCertsDir = path.join(
  process.env.HOME ?? '',
  'Library/Application Support/Local/run/router/nginx/certs'
);

/**
 * Writes dist/hot with the dev server's origin while `vite` is running,
 * removes it on exit — functions/vite.php reads this file's presence to
 * decide whether to point enqueued assets at the dev server or the
 * manifest-based production build.
 */
function hotFilePlugin(devServerHost) {
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

export default defineConfig(({ mode }) => {
  // .env keys match the BrowserSync setup used in other BB projects.
  const env = loadEnv(mode, process.cwd(), '');
  const siteUrl = env.BROWSERSYNC_PROXY_URL || 'https://gob.local';
  const openBrowser = String(env.BROWSERSYNC_OPEN_BROWSER || '').toLowerCase() === 'true';

  let siteHost = 'localhost';
  try {
    siteHost = new URL(siteUrl).hostname;
  } catch {
    // keep localhost
  }

  const localCert = path.join(localCertsDir, `${siteHost}.crt`);
  const localKey = path.join(localCertsDir, `${siteHost}.key`);
  const useLocalHttps = fs.existsSync(localCert) && fs.existsSync(localKey);

  // Local (localwp.com) serves the site over HTTPS; Safari refuses mixed
  // content, so the Vite dev server must also be HTTPS with Local's cert.
  const devServerHttps = useLocalHttps
    ? { cert: fs.readFileSync(localCert), key: fs.readFileSync(localKey) }
    : undefined;
  const devServerHost = useLocalHttps ? siteHost : 'localhost';

  return {
    root: '.',
    publicDir: 'public',
    // Production CSS/font URLs must resolve under the theme dist folder
    // (default `base: '/'` would request `/assets/...` from the site root).
    // Dev keeps `/` so the Vite server can serve modules/HMR normally.
    base: mode === 'production' ? '/wp-content/themes/gobsquad/dist/' : '/',
    plugins: [
      tailwindcss(),
      hotFilePlugin(devServerHost),
      // PHP / template changes are not Vite modules — trigger a full page
      // reload in the browser via the already-enqueued @vite/client.
      fullReload(['*.php', '**/*.php'], {
        delay: 150,
        root: import.meta.dirname,
      }),
    ],
    server: {
      // WordPress (e.g. https://gob.local) loads assets cross-origin from
      // the Vite server, so CORS must be allowed.
      cors: true,
      https: devServerHttps,
      host: devServerHost,
      port: 5173,
      strictPort: true,
      // Prefix absolute CSS urls (Font Awesome webfonts, etc.) with the Vite
      // origin. Without this, url(/node_modules/...) resolves against
      // gob.local and 404s while `npm run dev` is running.
      origin: useLocalHttps
        ? `https://${devServerHost}:5173`
        : 'http://localhost:5173',
      // Open the WordPress site (not the Vite origin) so @vite/client connects
      // from the real page and HMR / full-reload work.
      open: openBrowser ? siteUrl : false,
      // Requests arrive with Host: gob.local:5173.
      allowedHosts: useLocalHttps ? [siteHost] : true,
      hmr: useLocalHttps
        ? {
            host: siteHost,
            protocol: 'wss',
          }
        : undefined,
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
  };
});
