/* Progix Admin — shared behaviour */
(() => {
  'use strict';
  const $ = (s, c = document) => c.querySelector(s);
  const $$ = (s, c = document) => Array.from(c.querySelectorAll(s));
  const body = document.body;

  /* Mobile drawer */
  const burger = $('#burger');
  if (burger) {
    burger.addEventListener('click', () => body.classList.toggle('nav-open'));
    document.addEventListener('click', (e) => {
      if (body.classList.contains('nav-open') && !e.target.closest('#side') && !e.target.closest('#burger')) body.classList.remove('nav-open');
    });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') body.classList.remove('nav-open'); });
  }

  /* Confirm dialog for destructive actions */
  const bg = $('#confirmBg');
  let pending = null;
  const ask = (text, onYes) => {
    $('#confirmText').textContent = text;
    pending = onYes; bg.classList.add('on'); $('#confirmNo').focus();
  };
  const close = () => { bg.classList.remove('on'); pending = null; };
  if (bg) {
    $('#confirmNo').addEventListener('click', close);
    $('#confirmYes').addEventListener('click', () => { const fn = pending; close(); if (fn) fn(); });
    bg.addEventListener('click', (e) => { if (e.target === bg) close(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });
  }
  document.addEventListener('submit', (e) => {
    const f = e.target;
    if (f.matches('[data-confirm]') && !f.dataset.ok) {
      e.preventDefault();
      ask(f.dataset.confirm, () => { f.dataset.ok = '1'; f.submit(); });
    }
  });
  const del = $('[data-delete-post]');
  if (del) del.addEventListener('click', () => { const f = $('#deletePost'); ask(f.dataset.confirm, () => { f.dataset.ok = '1'; f.submit(); }); });

  /* Busy state on long actions */
  $$('form[data-busy]').forEach((f) => f.addEventListener('submit', () => {
    const b = f.querySelector('button[type=submit]');
    if (b) { b.disabled = true; b.dataset.label = b.innerHTML; b.innerHTML = '<svg class="ico spin" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.2-8.55"/></svg> ' + f.dataset.busy; }
  }));

  /* Flash messages fade */
  $$('.flash:not(.error)').forEach((el) => setTimeout(() => { el.style.transition = 'opacity .5s'; el.style.opacity = '0'; setTimeout(() => el.remove(), 500); }, 6000));

  /* Show/hide password */
  $$('[data-eye]').forEach((b) => b.addEventListener('click', () => { const i = b.parentElement.querySelector('input'); i.type = i.type === 'password' ? 'text' : 'password'; }));

  /* Password strength */
  const pw = $('[data-strength]'), bar = $('#strengthBar');
  if (pw && bar) pw.addEventListener('input', () => {
    const v = pw.value; let s = 0;
    if (v.length >= 8) s++; if (v.length >= 12) s++; if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++; if (/\d/.test(v)) s++; if (/[^A-Za-z0-9]/.test(v)) s++;
    bar.style.width = (s / 5 * 100) + '%'; bar.style.background = s <= 2 ? 'var(--red)' : s <= 3 ? 'var(--gold)' : 'var(--green)';
  });

  /* Character counters with colour feedback */
  $$('[data-count-for]').forEach((c) => {
    const input = document.getElementById(c.dataset.countFor); if (!input) return;
    const min = +c.dataset.min, max = +c.dataset.max;
    const upd = () => {
      const n = input.value.length;
      c.textContent = n + (max ? ' / ' + max : '');
      c.className = 'counter ' + (n === 0 ? '' : (n >= min && n <= max ? 'ok' : (n > max ? 'bad' : 'warn')));
    };
    input.addEventListener('input', upd); upd();
  });
})();
