# Progix Digital — static marketing website

Laravel 10 + Blade + Bootstrap 5 + GSAP/Lenis. **No database, no backend logic** — every
page is rendered from two config files, forms hand off to WhatsApp.

## Admin panel (`/admin`)

Dashboard (visitor stats, lead pipeline), **Leads** (from the booking form, with status/notes/CSV export),
**Insights** (blog CRUD with rich editor, cover upload and live SEO checker), **My account**
(change password — current password required) and **System & updates**.

- Default login: `admin@progixdigital.com` — change the password after first sign-in.
- **No terminal on the live server?** Upload the code, set the DB values in `.env`, then open `/system/setup`
  once (it only works while the database is empty). After that, use **Admin → System & updates → Run update now**
  after every deployment: it runs new migrations and clears/rebuilds the caches.
- Uploaded images are saved to `public/uploads/` (no `storage:link` needed) — keep that folder writable.
- Notification recipients: `MAIL_NOTIFY_TO=a@x.com,b@y.com` in `.env`.

## Run it

```bash
composer install            # first time only
cp .env.example .env && php artisan key:generate   # first time only
php artisan serve           # http://127.0.0.1:8000
```

## Where to edit things

| What | File |
|---|---|
| All copy, prices, packages, services, FAQs, reviews, clients, case studies, contact details | `config/progix.php` |
| Blog / Insights articles | `config/posts.php` |
| Page SEO titles & descriptions | `app/Http/Controllers/SiteController.php` |
| Page layouts | `resources/views/pages/*.blade.php` |
| Shared pieces (header, footer, pricing cards, forms…) | `resources/views/partials/` |
| Styling / design tokens (colours, radius, spacing) | `public/assets/css/app.css` (`:root` at the top) |
| Animations & interactions | `public/assets/js/app.js` |

## Waiting on the client (search `PLACEHOLDER` in `config/progix.php`)

- WhatsApp number, Pakistan phone (currently `+92 300 0000000`), US phone (hidden until added)
- Public email (`hello@progixdigital.com` is a guess), full address, working hours
- Social profile URLs and the Upwork profile URL (icons/links stay hidden while `null`)
- Calendly link (`contact.calendly`) — a "Pick a time" button appears automatically once set
- Stripe / PayPal checkout link (`checkout`) — not wired yet; "Get started" opens the booking form
- Case studies marked **Sample**, the industries list, and the blog articles are sample content
- Set `draft_mode` to `false` to hide the "Sample" chips
- Before launch: set `APP_URL`, `APP_ENV=production`, `APP_DEBUG=false`, update `public/robots.txt`

## Performance notes

- Fonts, Bootstrap, GSAP, ScrollTrigger and Lenis are all self-hosted (no third-party requests).
- Bootstrap CSS is purged to the classes in use (`node tools/purge-bootstrap.cjs`).
- Images are WebP; below-the-fold images are lazy-loaded. `public/.htaccess` enables gzip + 1-year asset caching on Apache.
- Run `php artisan config:cache route:cache view:cache` in production.

## SEO built in

Unique title/description per page, canonical URLs, Open Graph / Twitter cards, JSON-LD
(Organization, WebSite, BreadcrumbList, Service, FAQPage, Review, Article), `/sitemap.xml`,
`robots.txt`, web manifest, favicons, semantic headings and alt text.
