/* Home 2 — hero slider, stacked cards, parallax, looping video. Loads after app.js (GSAP/ScrollTrigger). */
(() => {
  'use strict';
  const $ = (s, c = document) => c.querySelector(s);
  const $$ = (s, c = document) => Array.from(c.querySelectorAll(s));
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const safe = (fn) => { try { fn(); } catch (e) { if (window.console) console.warn(e); } };

  /* ---------- Hero slider ---------- */
  safe(() => {
    const hero = $('[data-hero]'); if (!hero) return;
    const slides = $$('[data-slide]', hero), pips = $$('[data-pip]', hero);
    const DURATION = 7500;
    let index = 0, elapsed = 0, last = performance.now(), hovering = false, visible = true, raf = 0, busy = false;

    const go = (n) => {
      n = (n + slides.length) % slides.length;
      if (n === index || busy) return;
      const prev = slides[index], next = slides[n];
      busy = true;
      prev.classList.remove('is-active'); prev.classList.add('is-leaving'); prev.setAttribute('aria-hidden', 'true');
      next.classList.remove('is-leaving'); next.classList.add('is-active'); next.removeAttribute('aria-hidden');
      if (next.dataset.loaded !== '1') { const im = $('img', next); if (im) { im.loading = 'eager'; } next.dataset.loaded = '1'; }
      pips.forEach((p, i) => { p.classList.toggle('is-active', i === n); p.setAttribute('aria-selected', i === n); if (i !== n) p.style.setProperty('--p', i < n ? 1 : 0); });
      setTimeout(() => { prev.classList.remove('is-leaving'); busy = false; }, 1400);
      index = n; elapsed = 0;
    };

    const tick = (now) => {
      const dt = now - last; last = now;
      if (!hovering && visible && !document.hidden && !reduce) {
        elapsed += dt;
        pips[index].style.setProperty('--p', Math.min(1, elapsed / DURATION).toFixed(4));
        if (elapsed >= DURATION) go(index + 1);
      }
      raf = requestAnimationFrame(tick);
    };

    $('[data-next]', hero).addEventListener('click', () => go(index + 1));
    $('[data-prev]', hero).addEventListener('click', () => go(index - 1));
    pips.forEach((p, i) => p.addEventListener('click', () => go(i)));
    hero.addEventListener('pointerenter', (e) => { if (e.pointerType === 'mouse') hovering = true; });
    hero.addEventListener('pointerleave', () => { hovering = false; });
    document.addEventListener('keydown', (e) => { if (!visible || /input|textarea|select/i.test(e.target.tagName)) return; if (e.key === 'ArrowRight') go(index + 1); if (e.key === 'ArrowLeft') go(index - 1); });
    new IntersectionObserver((en) => { visible = en[0].isIntersecting; }, { threshold: 0.25 }).observe(hero);

    // swipe
    let sx = 0, sy = 0;
    hero.addEventListener('touchstart', (e) => { sx = e.touches[0].clientX; sy = e.touches[0].clientY; }, { passive: true });
    hero.addEventListener('touchend', (e) => {
      const dx = e.changedTouches[0].clientX - sx, dy = e.changedTouches[0].clientY - sy;
      if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy) * 1.4) go(index + (dx < 0 ? 1 : -1));
    }, { passive: true });

    raf = requestAnimationFrame(tick);
  });

  if (typeof window.gsap === 'undefined' || reduce) {
    // static fallbacks
    safe(() => { const v = $('[data-video]'); if (v) v.removeAttribute('autoplay'); });
    return;
  }

  /* ---------- Stacked service cards: earlier cards recede as the next slides over ---------- */
  safe(() => {
    const cards = $$('[data-card]');
    if (window.innerWidth < 992) return;
    cards.forEach((card, i) => {
      const next = cards[i + 1]; if (!next) return;
      gsap.to($('.h2-card-in', card), {
        scale: 0.94, ease: 'none',
        scrollTrigger: { trigger: next, start: 'top 85%', end: 'top 22%', scrub: true },
      });
    });
  });

  /* ---------- Image parallax ---------- */
  safe(() => {
    $$('[data-parallax]').forEach((img) => {
      gsap.fromTo(img, { yPercent: -5 }, { yPercent: 5, ease: 'none', scrollTrigger: { trigger: img.parentElement, start: 'top bottom', end: 'bottom top', scrub: true } });
    });
  });

  /* ---------- Showreel video: play only while visible ---------- */
  safe(() => {
    const v = $('[data-video]'); if (!v) return;
    const io = new IntersectionObserver((en) => {
      en.forEach((e) => {
        if (e.isIntersecting) { if (v.preload !== 'auto') v.preload = 'auto'; const p = v.play(); if (p && p.catch) p.catch(() => {}); }
        else v.pause();
      });
    }, { threshold: 0.25 });
    io.observe(v);
  });

  window.addEventListener('load', () => window.ScrollTrigger && ScrollTrigger.refresh());
})();
