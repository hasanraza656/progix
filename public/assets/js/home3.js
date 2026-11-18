/* Home 3 — service finder tabs, plan filter, mobile contact bar. Pure, lightweight, no auto-motion. */
(() => {
  'use strict';
  const $ = (s, c = document) => c.querySelector(s);
  const $$ = (s, c = document) => Array.from(c.querySelectorAll(s));

  /* Service finder (accessible tabs) */
  const finder = $('[data-finder]');
  if (finder) {
    const tabs = $$('[data-goal]', finder), panels = $$('.h3-gp', finder);
    const show = (i, focus) => {
      tabs.forEach((t, k) => { const on = k === i; t.classList.toggle('is-on', on); t.setAttribute('aria-selected', on); t.tabIndex = on ? 0 : -1; });
      panels.forEach((p, k) => { p.hidden = k !== i; p.classList.toggle('is-on', k === i); });
      if (focus) tabs[i].focus();
    };
    tabs.forEach((t, i) => {
      t.addEventListener('click', () => show(i));
      t.addEventListener('keydown', (e) => {
        const n = tabs.length;
        if (e.key === 'ArrowRight' || e.key === 'ArrowDown') { e.preventDefault(); show((i + 1) % n, true); }
        else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') { e.preventDefault(); show((i + n - 1) % n, true); }
        else if (e.key === 'Home') { e.preventDefault(); show(0, true); }
        else if (e.key === 'End') { e.preventDefault(); show(n - 1, true); }
      });
    });
  }

  /* Plan filter */
  const chips = $$('[data-filter]'), plans = $$('.h3-plan');
  chips.forEach((c) => c.addEventListener('click', () => {
    const f = c.dataset.filter;
    chips.forEach((x) => { const on = x === c; x.classList.toggle('is-on', on); x.setAttribute('aria-pressed', on); });
    plans.forEach((p) => { p.hidden = !(f === 'all' || p.dataset.cat === f); });
  }));

  /* Mobile contact bar: show once the hero has scrolled away */
  const bar = $('.h3-bar'), hero = $('.h3-hero');
  if (bar && hero && 'IntersectionObserver' in window) {
    new IntersectionObserver((en) => bar.classList.toggle('is-show', !en[0].isIntersecting)).observe(hero);
  } else if (bar) bar.classList.add('is-show');

  /* Hide the bar while the contact section itself is in view */
  const contact = $('#contact');
  if (bar && contact && 'IntersectionObserver' in window) {
    new IntersectionObserver((en) => { bar.style.opacity = en[0].isIntersecting ? '0' : ''; bar.style.pointerEvents = en[0].isIntersecting ? 'none' : ''; }, { threshold: 0.35 }).observe(contact);
  }
})();
