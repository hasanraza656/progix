/**
 * Rebuilds public/assets/vendor/bootstrap.min.css containing only the Bootstrap
 * classes the site actually uses (~65 KB instead of ~233 KB).
 *
 *   npm i -D bootstrap@5.3.3 purgecss
 *   node tools/purge-bootstrap.cjs
 *
 * Run it again whenever you add new Bootstrap utility classes to the Blade views.
 */
const fs = require('fs');
const path = require('path');
const { PurgeCSS } = require('purgecss');

const root = path.resolve(__dirname, '..').replace(/\\/g, '/');
const readViews = (dir) => fs.readdirSync(dir, { recursive: true })
  .filter((f) => f.endsWith('.php'))
  .map((f) => fs.readFileSync(path.join(dir, f), 'utf8')).join('\n');

(async () => {
  const [out] = await new PurgeCSS().purge({
    content: [
      { raw: readViews(root + '/resources/views'), extension: 'html' },
      { raw: fs.readFileSync(root + '/public/assets/js/app.js', 'utf8'), extension: 'js' },
    ],
    css: [root + '/node_modules/bootstrap/dist/css/bootstrap.min.css'],
    safelist: { standard: [/^modal/, /^offcanvas/, /^fade/, /^show/, /^collapse/, /^collapsing/, /^accordion/, /^btn-close/, /^is-invalid/, /^invalid-feedback/, /^form-/, /^lenis/] },
    variables: false,
    keyframes: true,
  });
  fs.writeFileSync(root + '/public/assets/vendor/bootstrap.min.css', out.css);
  console.log('bootstrap.min.css:', out.css.length, 'bytes');
})();
