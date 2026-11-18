/* Progix Admin — blog post editor: rich text, slug, cover preview, live SEO analysis */
(() => {
  'use strict';
  const $ = (s, c = document) => c.querySelector(s);
  const form = $('#postForm');
  if (!form || typeof Quill === 'undefined') return;

  const el = (id) => document.getElementById(id);
  const title = el('title'), slug = el('slug'), excerpt = el('excerpt'), kw = el('focus_keyword');
  const mTitle = el('meta_title'), mDesc = el('meta_description'), content = el('content'), coverAlt = el('cover_alt');
  const SITE = form.dataset.site;

  /* ---------- Rich text editor ---------- */
  const quill = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Start writing… use Heading 2 for main sections.',
    modules: {
      toolbar: {
        container: [[{ header: [2, 3, false] }], ['bold', 'italic', 'underline'], [{ list: 'ordered' }, { list: 'bullet' }], ['blockquote', 'link', 'image'], ['clean']],
        handlers: {
          image() {
            const input = document.createElement('input');
            input.type = 'file'; input.accept = 'image/jpeg,image/png,image/webp,image/gif';
            input.onchange = async () => {
              const file = input.files[0]; if (!file) return;
              const alt = window.prompt('Alt text for this image (helps SEO & accessibility):', '') || '';
              const fd = new FormData(); fd.append('image', file);
              const range = quill.getSelection(true);
              try {
                const res = await fetch(window.ADMIN.upload, { method: 'POST', headers: { 'X-CSRF-TOKEN': window.ADMIN.csrf, Accept: 'application/json' }, body: fd });
                if (!res.ok) throw new Error('Upload failed');
                const { url } = await res.json();
                quill.insertEmbed(range.index, 'image', url, 'user');
                quill.setSelection(range.index + 1);
                if (alt) { const img = quill.root.querySelector('img[src="' + url + '"]'); if (img) img.setAttribute('alt', alt); }
                analyse();
              } catch (e) { alert('Image upload failed. Use a JPG, PNG, WebP or GIF under 5 MB.'); }
            };
            input.click();
          },
        },
      },
    },
  });

  const syncContent = () => { content.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML; };

  /* ---------- Slug ---------- */
  const slugify = (s) => s.toLowerCase().normalize('NFKD').replace(/[̀-ͯ]/g, '').replace(/&/g, ' and ').replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '').slice(0, 90);
  let slugTouched = slug.value.trim() !== '';
  slug.addEventListener('input', () => { slugTouched = true; });
  title.addEventListener('input', () => { if (!slugTouched) slug.value = slugify(title.value); });

  /* ---------- Cover preview ---------- */
  const cover = el('cover');
  cover.addEventListener('change', () => {
    const f = cover.files[0]; if (!f) return;
    const img = el('coverPreview'); img.src = URL.createObjectURL(f); img.hidden = false; el('coverHint').hidden = true;
    analyse();
  });

  /* ---------- SEO analysis ---------- */
  const words = (t) => (t.trim().match(/[\p{L}\p{N}'’-]+/gu) || []);
  const has = (hay, needle) => needle && hay.toLowerCase().includes(needle.toLowerCase());

  const analyse = () => {
    syncContent();
    const k = kw.value.trim().toLowerCase();
    const t = (mTitle.value || title.value).trim();
    const d = (mDesc.value || excerpt.value).trim();
    const s = slug.value.trim();
    const root = quill.root;
    const text = root.innerText || '';
    const wc = words(text).length;
    el('wordCount').textContent = wc + ' words · ' + Math.max(1, Math.ceil(wc / 200)) + ' min read';
    const firstP = ($('p', root) || {}).innerText || '';
    const first100 = words(text).slice(0, 100).join(' ');
    const heads = Array.from(root.querySelectorAll('h2,h3')).map((h) => h.innerText).join(' | ');
    const links = Array.from(root.querySelectorAll('a[href]'));
    const internal = links.filter((a) => /^\/|progixdigital\.com|localhost|127\.0\.0\.1/.test(a.getAttribute('href')));
    const imgs = Array.from(root.querySelectorAll('img'));
    const imgsNoAlt = imgs.filter((i) => !(i.getAttribute('alt') || '').trim());
    const density = k && wc ? ((text.toLowerCase().split(k).length - 1) * k.split(/\s+/).length / wc * 100) : 0;
    const kSlug = slugify(k);

    // [status, label] — status: ok | warn | bad
    const c = [];
    const add = (st, msg) => c.push([st, msg]);
    if (!k) add('bad', 'Set a focus keyword so keyword checks can run.');
    else {
      add(has(t, k) ? 'ok' : 'bad', has(t, k) ? 'Focus keyword appears in the SEO title.' : 'Add the focus keyword to the SEO title (ideally near the start).');
      add(has(d, k) ? 'ok' : 'warn', has(d, k) ? 'Focus keyword appears in the meta description.' : 'Mention the focus keyword in the meta description.');
      add(kSlug && s.includes(kSlug) ? 'ok' : 'warn', kSlug && s.includes(kSlug) ? 'Focus keyword is in the URL slug.' : 'Include the focus keyword in the URL slug.');
      add(has(first100, k) ? 'ok' : 'warn', has(first100, k) ? 'Keyword appears in the first 100 words.' : 'Use the focus keyword in the opening paragraph.');
      add(has(heads, k) ? 'ok' : 'warn', has(heads, k) ? 'Keyword appears in a subheading.' : 'Use the focus keyword in at least one H2/H3 subheading.');
      add(density >= 0.4 && density <= 2.5 ? 'ok' : (density === 0 ? 'bad' : 'warn'), 'Keyword density is ' + density.toFixed(1) + '% (aim for 0.5–2.5%).');
    }
    add(t.length >= 40 && t.length <= 60 ? 'ok' : (t.length >= 25 && t.length <= 70 ? 'warn' : 'bad'), 'SEO title is ' + t.length + ' characters (ideal 40–60).');
    add(d.length >= 120 && d.length <= 160 ? 'ok' : (d.length >= 70 && d.length <= 175 ? 'warn' : 'bad'), 'Meta description is ' + d.length + ' characters (ideal 120–160).');
    add(wc >= 600 ? 'ok' : (wc >= 300 ? 'warn' : 'bad'), 'Content is ' + wc + ' words (aim for 600+; minimum 300).');
    add(root.querySelectorAll('h2').length >= 2 ? 'ok' : 'warn', root.querySelectorAll('h2').length >= 2 ? 'Content is structured with H2 subheadings.' : 'Break the article up with at least two H2 subheadings.');
    add(internal.length ? 'ok' : 'warn', internal.length ? 'Contains ' + internal.length + ' internal link(s).' : 'Link to at least one other page on the site (service, pricing or another post).');
    const hasCover = !!(el('coverPreview') && !el('coverPreview').hidden);
    add(hasCover || imgs.length ? 'ok' : 'warn', hasCover || imgs.length ? 'Post has a cover/inline image.' : 'Add a cover image to improve sharing and engagement.');
    add(!imgs.length && !hasCover ? 'warn' : ((hasCover && !coverAlt.value.trim()) || imgsNoAlt.length ? 'bad' : 'ok'), (hasCover && !coverAlt.value.trim()) ? 'Add alt text to the cover image.' : (imgsNoAlt.length ? imgsNoAlt.length + ' inline image(s) are missing alt text.' : 'Images have alt text.'));
    add(excerpt.value.trim().length >= 80 ? 'ok' : 'warn', excerpt.value.trim().length >= 80 ? 'Excerpt is written.' : 'Write an excerpt (80+ characters) for blog cards.');

    const pts = c.reduce((n, [st]) => n + (st === 'ok' ? 1 : st === 'warn' ? 0.5 : 0), 0);
    const score = Math.round(pts / c.length * 100);
    const ring = el('ring');
    ring.style.setProperty('--p', score);
    ring.style.setProperty('--c', score >= 80 ? 'var(--green)' : score >= 50 ? 'var(--gold)' : 'var(--red)');
    el('ringNum').textContent = score;
    el('scoreLabel').textContent = score >= 80 ? 'Great — ready to rank' : score >= 50 ? 'Good start — a few fixes left' : 'Needs work';
    el('scoreHint').textContent = c.filter((x) => x[0] !== 'ok').length + ' suggestion(s) below';
    el('checks').innerHTML = c.map(([st, m]) => '<div class="chk ' + st + '"><i>' + (st === 'ok' ? '✓' : st === 'warn' ? '!' : '×') + '</i><span>' + m.replace(/</g, '&lt;') + '</span></div>').join('');

    // SERP preview
    const desktop = !$('[data-serp="mobile"].on');
    const short = (x, n) => (x.length > n ? x.slice(0, n - 1).trimEnd() + '…' : x);
    el('serpTitle').textContent = short(t || 'Your SEO title appears here', desktop ? 60 : 52);
    el('serpDesc').textContent = short(d || 'Your meta description appears here. Write 120–160 characters that make people want to click.', desktop ? 160 : 130);
    el('serpUrl').textContent = (SITE + '/' + (s || 'your-post-url')).replace(/^https?:\/\//, '').replace(/\//g, ' › ');
    el('serp').classList.toggle('mobile', !desktop);
  };

  document.querySelectorAll('[data-serp]').forEach((a) => a.addEventListener('click', (e) => {
    e.preventDefault();
    document.querySelectorAll('[data-serp]').forEach((x) => x.classList.toggle('on', x === a));
    analyse();
  }));

  let timer;
  const debounced = () => { clearTimeout(timer); timer = setTimeout(analyse, 200); dirty = true; };
  [title, slug, excerpt, kw, mTitle, mDesc, coverAlt].forEach((i) => i.addEventListener('input', debounced));
  quill.on('text-change', debounced);

  /* ---------- Safety ---------- */
  let dirty = false, submitting = false;
  form.addEventListener('submit', () => { syncContent(); submitting = true; });
  window.addEventListener('beforeunload', (e) => { if (dirty && !submitting) { e.preventDefault(); e.returnValue = ''; } });
  form.addEventListener('keydown', (e) => { if (e.key === 'Enter' && e.target.tagName === 'INPUT' && e.target.type !== 'submit') e.preventDefault(); });

  analyse();
  dirty = false;
})();
