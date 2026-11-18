/* ==========================================================================
   Progix Digital — front-end behaviour
   Lenis (smooth scroll) + GSAP/ScrollTrigger (reveals) + Bootstrap (modal, offcanvas, accordion)
   Everything degrades gracefully: without JS the content is simply visible.
   ========================================================================== */
(() => {
  'use strict';

  const doc = document, root = doc.documentElement;
  const $ = (s, c = doc) => c.querySelector(s);
  const $$ = (s, c = doc) => Array.from(c.querySelectorAll(s));
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  const hasGSAP = typeof window.gsap !== 'undefined';
  const CFG = window.PROGIX || {};
  let lenis = null;

  const safe = (fn) => { try { fn(); } catch (e) { /* never let one widget break the page */ if (window.console) console.warn(e); } };

  /* ---------- 0. Reveal everything immediately if we cannot animate ---------- */
  if (!hasGSAP || reduce) {
    root.classList.add('ready');
    $$('[data-reveal], [data-reveal-item], [data-hero-item], .fc, .browser').forEach((el) => el.classList.add('is-in'));
    $$('[data-hero-line] .line-in').forEach((el) => { el.style.transform = 'none'; });
  } else {
    gsap.registerPlugin(ScrollTrigger);
    root.classList.add('ready');
  }
  const animate = hasGSAP && !reduce;

  /* ---------- 1. Smooth scrolling ---------- */
  safe(() => {
    if (!animate || typeof window.Lenis === 'undefined') return;
    lenis = new Lenis({
      duration: 1.1,
      easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      smoothWheel: true,
      wheelMultiplier: 0.95,
    });
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => lenis.raf(time * 1000));
    gsap.ticker.lagSmoothing(0);

    // pause smooth scroll while overlays are open
    $$('.modal, .offcanvas').forEach((el) => {
      el.setAttribute('data-lenis-prevent', '');
      el.addEventListener('show.bs.modal', () => lenis.stop());
      el.addEventListener('hidden.bs.modal', () => lenis.start());
      el.addEventListener('show.bs.offcanvas', () => lenis.stop());
      el.addEventListener('hidden.bs.offcanvas', () => lenis.start());
    });
  });

  const scrollToTarget = (target, offset = -90) => {
    if (lenis) lenis.scrollTo(target, { offset, duration: 1.3 });
    else {
      const y = (typeof target === 'number' ? target : target.getBoundingClientRect().top + window.scrollY) + offset;
      window.scrollTo({ top: Math.max(0, y), behavior: reduce ? 'auto' : 'smooth' });
    }
  };

  /* ---------- 2. Header: solid on scroll, hide on scroll-down ---------- */
  safe(() => {
    const header = $('#siteHeader'), bar = $('.scroll-progress span'), top = $('#toTop');
    let lastY = window.scrollY, ticking = false;
    const onScroll = () => {
      const y = window.scrollY;
      header.classList.toggle('is-scrolled', y > 12);
      const goingDown = y > lastY + 4, goingUp = y < lastY - 4;
      if (y > 480 && goingDown && !header.matches(':focus-within') && !header.querySelector('.has-mega:hover')) header.classList.add('is-hidden');
      else if (goingUp || y <= 480) header.classList.remove('is-hidden');
      if (top) top.classList.toggle('is-show', y > 900);
      if (bar) {
        const max = doc.documentElement.scrollHeight - window.innerHeight;
        bar.style.transform = 'scaleX(' + (max > 0 ? Math.min(1, y / max) : 0) + ')';
      }
      if (Math.abs(y - lastY) > 4) lastY = y;
      ticking = false;
    };
    window.addEventListener('scroll', () => { if (!ticking) { ticking = true; requestAnimationFrame(onScroll); } }, { passive: true });
    onScroll();
    if (top) top.addEventListener('click', () => scrollToTarget(0, 0));
  });

  /* ---------- 3. In-page anchor links ---------- */
  doc.addEventListener('click', (e) => {
    const a = e.target.closest('a[href*="#"]');
    if (!a || e.defaultPrevented || e.metaKey || e.ctrlKey || e.shiftKey) return;
    const url = new URL(a.href, location.href);
    if (url.pathname !== location.pathname || url.origin !== location.origin || !url.hash || url.hash === '#') return;
    const target = doc.getElementById(decodeURIComponent(url.hash.slice(1)));
    if (!target) return;
    e.preventDefault();
    scrollToTarget(target);
    history.pushState(null, '', url.hash);
  });

  /* ---------- 4. Page transitions ---------- */
  safe(() => {
    if (reduce) return;
    doc.addEventListener('click', (e) => {
      const a = e.target.closest('a[href]');
      if (!a || e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
      if (a.target === '_blank' || a.hasAttribute('download') || a.getAttribute('href').startsWith('#')) return;
      const url = new URL(a.href, location.href);
      if (url.origin !== location.origin || (url.pathname === location.pathname && url.search === location.search)) return;
      if (/^(mailto|tel):/i.test(a.getAttribute('href'))) return;
      e.preventDefault();
      doc.body.classList.add('is-leaving');
      setTimeout(() => { location.href = url.href; }, 260);
    });
    window.addEventListener('pageshow', (e) => { if (e.persisted) doc.body.classList.remove('is-leaving'); });
  });

  /* ---------- 5. Text splitting helper (words rise in from a mask) ---------- */
  const splitWords = (el) => {
    const words = [];
    const walk = (node) => {
      Array.from(node.childNodes).forEach((child) => {
        if (child.nodeType === 3) {
          const frag = doc.createDocumentFragment();
          child.textContent.split(/(\s+)/).forEach((part) => {
            if (!part) return;
            if (/^\s+$/.test(part)) { frag.appendChild(doc.createTextNode(' ')); return; }
            const w = doc.createElement('span'); w.className = 'w';
            const i = doc.createElement('span'); i.className = 'wi'; i.textContent = part;
            w.appendChild(i); frag.appendChild(w); words.push(i);
          });
          node.replaceChild(frag, child);
        } else if (child.nodeType === 1) walk(child);
      });
    };
    walk(el);
    return words;
  };

  /* ---------- 6. Dot-grid decoration (brand motif: the rounded squares of the logo) ---------- */
  safe(() => {
    $$('[data-dots], .cta-dots').forEach((box) => {
      const small = window.innerWidth < 768;
      const cell = small ? 44 : 60;
      const w = box.clientWidth || box.parentElement.clientWidth, h = box.clientHeight || box.parentElement.clientHeight;
      const cols = Math.ceil(w / cell), rows = Math.ceil(h / cell);
      box.style.setProperty('--cols', cols); box.style.setProperty('--cell', cell + 'px');
      let seed = 7 + cols * 13 + rows;
      const rnd = () => { seed = (seed * 16807) % 2147483647; return seed / 2147483647; };
      const frag = doc.createDocumentFragment(), dots = [];
      for (let i = 0; i < cols * rows; i++) {
        const d = doc.createElement('i');
        const r = rnd();
        if (r < 0.34) d.className = 'on' + (rnd() < 0.18 ? ' gold' : '');
        frag.appendChild(d); dots.push(d);
      }
      box.appendChild(frag);
      if (!animate) return;
      const live = dots.filter((d) => d.classList.contains('on'));
      gsap.from(live, { scale: 0, duration: 0.9, ease: 'back.out(2.4)', stagger: { each: 0.008, from: 'random' }, delay: 0.25 });
      // gentle twinkle while visible
      let timer = null;
      const tick = () => {
        for (let k = 0; k < 3; k++) {
          const d = dots[Math.floor(Math.random() * dots.length)];
          d.classList.toggle('on');
          if (d.classList.contains('on') && Math.random() < 0.15) d.classList.add('gold');
        }
      };
      const io = new IntersectionObserver((entries) => {
        entries.forEach((en) => {
          if (en.isIntersecting && !timer) timer = setInterval(tick, 700);
          else if (!en.isIntersecting && timer) { clearInterval(timer); timer = null; }
        });
      });
      io.observe(box);
    });
  });

  if (animate) {
    /* ---------- 7. Hero stage: floating + pointer parallax ----------
       The entrance itself is CSS (so it paints instantly). GSAP only takes over once it has finished. */
    safe(() => {
      const stage = $('[data-stage]');
      if (!stage) return;
      gsap.delayedCall(1.9, () => {
        const browser = $('.browser', stage), cards = $$('.fc', stage);
        const floaters = [browser, ...cards].map((el, i) => gsap.to(el, {
          y: '+=' + (el === browser ? 8 : 12), duration: parseFloat(el.dataset.float || 7) / 1.6, yoyo: true, repeat: -1, ease: 'sine.inOut', delay: i * 0.25,
        }));
        // pause the idle motion while the hero is off-screen
        ScrollTrigger.create({ trigger: stage, start: 'top bottom', end: 'bottom top', onToggle: (self) => floaters.forEach((t) => (self.isActive ? t.resume() : t.pause())) });

        if (canHover && window.innerWidth >= 992) {
          const movers = cards.map((el) => ({
            x: gsap.quickTo(el, 'xPercent', { duration: 0.9, ease: 'power3.out' }),
            y: gsap.quickTo(el, 'yPercent', { duration: 0.9, ease: 'power3.out' }),
            d: parseFloat(el.dataset.depth || 1),
          }));
          const bx = gsap.quickTo(browser, 'xPercent', { duration: 1.1, ease: 'power3.out' });
          const by = gsap.quickTo(browser, 'yPercent', { duration: 1.1, ease: 'power3.out' });
          const hero = stage.closest('.hero');
          hero.addEventListener('pointermove', (e) => {
            const r = hero.getBoundingClientRect();
            const nx = (e.clientX - r.left) / r.width - 0.5, ny = (e.clientY - r.top) / r.height - 0.5;
            movers.forEach((m) => { m.x(nx * 9 * m.d); m.y(ny * 9 * m.d); });
            bx(nx * -2); by(ny * -2);
          });
        }
      });
    });
    /* ---------- 8. Scroll reveals ---------- */
    safe(() => {
      const markIn = (els) => { els.forEach((el) => el.classList.add('is-in')); gsap.set(els, { clearProps: 'transform,opacity' }); };
      const from = (el) => {
        const v = el.dataset.reveal;
        return { opacity: 0, x: v === 'left' ? -44 : v === 'right' ? 44 : 0, y: v === 'left' || v === 'right' || v === 'scale' ? 0 : 34, scale: v === 'scale' ? 0.96 : 1 };
      };

      // section heads: eyebrow, words of the heading, lead
      $$('.section-head[data-reveal]').forEach((head) => {
        head.classList.add('is-in');
        const eb = $('.eyebrow', head), h = $('h2', head), lead = $('.lead-text', head);
        const words = h ? splitWords(h) : [];
        gsap.set([eb, lead].filter(Boolean), { opacity: 0, y: 22 });
        gsap.set(words, { yPercent: 115 });
        const tl = gsap.timeline({ paused: true, defaults: { ease: 'power3.out' } });
        if (eb) tl.to(eb, { opacity: 1, y: 0, duration: 0.7 }, 0);
        if (words.length) tl.to(words, { yPercent: 0, duration: 0.95, stagger: 0.035, ease: 'power4.out' }, 0.08);
        if (lead) tl.to(lead, { opacity: 1, y: 0, duration: 0.8 }, 0.35);
        ScrollTrigger.create({ trigger: head, start: 'top 86%', once: true, onEnter: () => tl.play() });
      });

      // everything else: batched so siblings stagger naturally
      const targets = $$('[data-reveal], [data-reveal-item]').filter((el) => !el.matches('.section-head') && !el.classList.contains('is-in'));
      targets.forEach((el) => gsap.set(el, from(el)));
      ScrollTrigger.batch(targets, {
        start: 'top 90%', once: true,
        onEnter: (batch) => {
          const els = batch.filter((el) => !el.classList.contains('is-in'));
          gsap.to(els, { opacity: 1, x: 0, y: 0, scale: 1, duration: 0.95, ease: 'power3.out', stagger: 0.09, overwrite: true, onComplete: () => markIn(els) });
        },
      });

      // counters
      $$('[data-count]').forEach((el) => {
        const end = parseFloat(el.dataset.count), o = { v: 0 };
        el.textContent = '0';
        ScrollTrigger.create({
          trigger: el, start: 'top 92%', once: true,
          onEnter: () => gsap.to(o, { v: end, duration: 2.2, ease: 'power2.out', onUpdate: () => { el.textContent = Math.round(o.v).toLocaleString('en-US'); } }),
        });
      });

      // process steps: line fills with scroll, icons light up
      $$('[data-steps]').forEach((box) => {
        const steps = $$('[data-step]', box);
        ScrollTrigger.create({
          trigger: box, start: 'top 72%', end: 'bottom 62%', scrub: 0.4,
          onUpdate: (self) => {
            box.style.setProperty('--p', self.progress.toFixed(3));
            steps.forEach((s, i) => s.classList.toggle('is-on', self.progress >= i / (steps.length - 1) - 0.02));
          },
        });
      });

      window.addEventListener('load', () => ScrollTrigger.refresh());
    });
  }

  /* ---------- 9. Pricing tabs ---------- */
  safe(() => {
    const bar = $('[data-tabs]');
    if (!bar) return;
    const tabs = $$('[data-tab]', bar), panels = $$('[data-panel]');
    const show = (key, push = true) => {
      const next = panels.find((p) => p.dataset.panel === key);
      if (!next || next.classList.contains('is-active')) return;
      const cur = panels.find((p) => p.classList.contains('is-active'));
      tabs.forEach((t) => { const on = t.dataset.tab === key; t.classList.toggle('is-active', on); t.setAttribute('aria-selected', on); });
      const swap = () => {
        if (cur) cur.classList.remove('is-active');
        next.classList.add('is-active');
        const items = $$('[data-reveal-item]', next).filter((el) => !el.classList.contains('is-in'));
        if (animate) {
          const head = $('.panel-head', next);
          gsap.fromTo([head, ...items].filter(Boolean), { opacity: 0, y: 28 }, { opacity: 1, y: 0, duration: 0.7, stagger: 0.08, ease: 'power3.out', clearProps: 'transform,opacity', onComplete: () => items.forEach((el) => el.classList.add('is-in')) });
          ScrollTrigger.refresh();
        } else items.forEach((el) => el.classList.add('is-in'));
      };
      if (animate && cur) gsap.to(cur, { opacity: 0, y: 10, duration: 0.18, onComplete: () => { gsap.set(cur, { clearProps: 'all' }); swap(); } });
      else swap();
      if (push) history.replaceState(null, '', '#' + key);
    };
    tabs.forEach((t, i) => {
      t.addEventListener('click', () => show(t.dataset.tab));
      t.addEventListener('keydown', (e) => {
        if (e.key !== 'ArrowRight' && e.key !== 'ArrowLeft') return;
        const n = tabs[(i + (e.key === 'ArrowRight' ? 1 : tabs.length - 1)) % tabs.length];
        n.focus(); show(n.dataset.tab);
      });
    });
    const initial = decodeURIComponent(location.hash.slice(1));
    if (initial && panels.some((p) => p.dataset.panel === initial)) {
      // activate without animation
      panels.forEach((p) => p.classList.toggle('is-active', p.dataset.panel === initial));
      tabs.forEach((t) => { const on = t.dataset.tab === initial; t.classList.toggle('is-active', on); t.setAttribute('aria-selected', on); });
      $$('[data-reveal-item]', panels.find((p) => p.dataset.panel === initial)).forEach((el) => el.classList.add('is-in'));
    }
    window.addEventListener('hashchange', () => show(decodeURIComponent(location.hash.slice(1)), false));
  });

  /* ---------- 9b. Read more on long reviews ---------- */
  safe(() => {
    const cards = $$('.review');
    const setup = () => cards.forEach((card) => {
      const bq = $('blockquote', card), p = bq && $('p', bq);
      if (!p) return;
      let btn = $('.review-more', card);
      const open = bq.classList.contains('is-open');
      if (!open) p.style.maxHeight = '';
      const long = open || p.scrollHeight > p.clientHeight + 4;
      bq.classList.toggle('is-clamped', long);
      if (!long) { if (btn) btn.remove(); return; }
      if (btn) return;
      if (!p.id) p.id = 'rv' + Math.random().toString(36).slice(2, 8);
      btn = doc.createElement('button'); btn.type = 'button'; btn.className = 'review-more';
      btn.setAttribute('aria-expanded', 'false'); btn.setAttribute('aria-controls', p.id);
      btn.innerHTML = '<span>Read more</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>';
      bq.after(btn);
      btn.addEventListener('click', () => {
        const on = !bq.classList.contains('is-open');
        if (on) { p.style.maxHeight = p.clientHeight + 'px'; bq.classList.add('is-open'); p.style.maxHeight = p.scrollHeight + 'px'; }
        else { p.style.maxHeight = p.scrollHeight + 'px'; void p.offsetHeight; bq.classList.remove('is-open'); p.style.maxHeight = ''; }
        btn.setAttribute('aria-expanded', on); $('span', btn).textContent = on ? 'Show less' : 'Read more';
      });
    });
    const equalize = () => $$('.slider-track').forEach((tr) => {
      const rs = Array.from(tr.children);
      rs.forEach((c) => { c.style.minHeight = ''; });
      const open = rs.filter((c) => $('blockquote.is-open', c));
      if (open.length) return;
      const h = Math.max(...rs.map((c) => c.offsetHeight));
      rs.forEach((c) => { c.style.minHeight = h + 'px'; });
    });
    const run = () => { setup(); equalize(); };
    run();
    window.addEventListener('load', run);
    let t; window.addEventListener('resize', () => { clearTimeout(t); t = setTimeout(run, 200); });
    if (doc.fonts && doc.fonts.ready) doc.fonts.ready.then(run);
  });

  /* ---------- 10. Testimonial slider ---------- */
  safe(() => {
    $$('[data-slider]').forEach((box) => {
      const vp = $('.slider-viewport', box), track = $('.slider-track', box);
      const cards = Array.from(track.children), dotsBox = $('[data-dots-nav]', box);
      const prev = $('[data-prev]', box), next = $('[data-next]', box);
      const dots = cards.map((_, i) => {
        const b = doc.createElement('button'); b.type = 'button'; b.setAttribute('aria-label', 'Go to review ' + (i + 1));
        b.addEventListener('click', () => vp.scrollTo({ left: cards[i].offsetLeft - cards[0].offsetLeft, behavior: 'smooth' }));
        dotsBox.appendChild(b); return b;
      });
      dotsBox.removeAttribute('aria-hidden');
      const step = () => cards[0].getBoundingClientRect().width + 20;
      const current = () => {
        const x = vp.scrollLeft; let best = 0, d = Infinity;
        cards.forEach((c, i) => { const dist = Math.abs(c.offsetLeft - cards[0].offsetLeft - x); if (dist < d) { d = dist; best = i; } });
        return best;
      };
      const update = () => {
        const i = current();
        dots.forEach((b, k) => b.classList.toggle('is-on', k === i));
        prev.disabled = vp.scrollLeft < 4;
        next.disabled = vp.scrollLeft + vp.clientWidth >= vp.scrollWidth - 4;
        prev.style.opacity = prev.disabled ? 0.4 : 1; next.style.opacity = next.disabled ? 0.4 : 1;
      };
      let raf = 0;
      vp.addEventListener('scroll', () => { cancelAnimationFrame(raf); raf = requestAnimationFrame(update); }, { passive: true });
      prev.addEventListener('click', () => vp.scrollBy({ left: -step(), behavior: 'smooth' }));
      next.addEventListener('click', () => vp.scrollBy({ left: step(), behavior: 'smooth' }));
      update();

      // gentle autoplay (only while visible, not hovered/focused, never with reduced motion)
      if (reduce) return;
      let paused = false, visible = false;
      ['pointerenter', 'focusin', 'touchstart'].forEach((ev) => box.addEventListener(ev, () => { paused = true; }, { passive: true }));
      ['pointerleave', 'focusout'].forEach((ev) => box.addEventListener(ev, () => { paused = false; }));
      new IntersectionObserver((en) => { visible = en[0].isIntersecting; }).observe(box);
      setInterval(() => {
        if (paused || !visible || doc.hidden) return;
        if (vp.scrollLeft + vp.clientWidth >= vp.scrollWidth - 4) vp.scrollTo({ left: 0, behavior: 'smooth' });
        else vp.scrollBy({ left: step(), behavior: 'smooth' });
      }, 6500);
    });
  });

  /* ---------- 11. Booking modal + forms (static: hand-off to WhatsApp) ---------- */
  safe(() => {
    const modalEl = $('#bookingModal');
    const modal = modalEl && window.bootstrap ? bootstrap.Modal.getOrCreateInstance(modalEl) : null;

    const resetForm = (form) => {
      form.classList.remove('is-sent');
      $('.booking-success', form).hidden = true;
      $$('.is-invalid', form).forEach((el) => el.classList.remove('is-invalid'));
    };

    doc.addEventListener('click', (e) => {
      const btn = e.target.closest('[data-book]');
      if (!btn || !modal) return;
      e.preventDefault();
      const form = $('[data-booking-form]', modalEl);
      resetForm(form);
      const pkg = btn.dataset.package, svc = btn.dataset.service;
      form.elements.package.value = pkg || '';
      if (svc && form.elements.service) {
        const opt = Array.from(form.elements.service.options).find((o) => o.value && (o.value === svc || o.value.indexOf(svc) === 0));
        form.elements.service.value = opt ? opt.value : '';
      } else if (form.elements.service) form.elements.service.value = '';
      const open = () => modal.show();
      const oc = $('#mobileMenu.show');
      oc ? setTimeout(open, 320) : open();
    });
    if (modalEl) modalEl.addEventListener('shown.bs.modal', () => { const n = $('input[name="name"]', modalEl); if (n && !n.value) n.focus(); });

    $$('[data-booking-form]').forEach((form) => {
      const f = form.elements;
      const check = () => {
        let ok = true, first = null;
        const flag = (el, bad) => { el.classList.toggle('is-invalid', bad); if (bad) { ok = false; first = first || el; } };
        flag(f.name, f.name.value.trim().length < 2);
        flag(f.phone, f.phone.value.replace(/\D/g, '').length < 7);
        flag(f.email, !!f.email.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(f.email.value.trim()));
        if (first) first.focus();
        return ok;
      };
      form.addEventListener('input', (e) => e.target.classList.remove('is-invalid'));
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (!check()) return;
        const v = (n) => (f[n] && f[n].value.trim()) || '';
        const lines = ['Hello Progix Digital! 👋', "I'd like to book a free consultation.", '', 'Name: ' + v('name'), 'Phone: ' + v('phone')];
        if (v('email')) lines.push('Email: ' + v('email'));
        lines.push('Service: ' + (v('service') || 'Not sure yet'));
        if (v('package')) lines.push('Package: ' + v('package'));
        lines.push('Best time to reach me: ' + (v('time') || 'Anytime'));
        if (v('message')) lines.push('', 'Project details: ' + v('message'));
        const text = lines.join('\n');
        const waUrl = 'https://wa.me/' + CFG.whatsapp + '?text=' + encodeURIComponent(text);
        const mailUrl = 'mailto:' + CFG.email + '?subject=' + encodeURIComponent('Free consultation request — ' + v('name')) + '&body=' + encodeURIComponent(text);
        $('[data-success-wa]', form).href = waUrl;
        $('[data-success-mail]', form).href = mailUrl;
        form.classList.add('is-sent');
        const ok = $('.booking-success', form); ok.hidden = false;
        if (animate) gsap.from(ok.children, { opacity: 0, y: 18, duration: 0.6, stagger: 0.08, ease: 'power3.out' });
        // email the team too (fire-and-forget; WhatsApp remains the primary hand-off)
        try {
          const tok = doc.querySelector('meta[name=csrf-token]');
          fetch('/booking', { method: 'POST', keepalive: true, headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': tok ? tok.content : '' }, body: JSON.stringify(Object.fromEntries(new FormData(form))) }).catch(() => {});
        } catch (e) { /* ignore */ }
        window.open(waUrl, '_blank', 'noopener');
        if (window.dataLayer) window.dataLayer.push({ event: 'booking_submit', service: v('service'), package: v('package') });
      });
    });
  });

  /* ---------- 12. Floating WhatsApp bubble ---------- */
  safe(() => {
    const bubble = $('#fabBubble'), close = $('#fabClose');
    if (!bubble) return;
    let dismissed = false;
    try { dismissed = sessionStorage.getItem('pxBubble') === '1'; } catch (e) { /* storage unavailable */ }
    const hide = () => { bubble.hidden = true; try { sessionStorage.setItem('pxBubble', '1'); } catch (e) { /* ignore */ } };
    if (!dismissed) {
      setTimeout(() => { bubble.hidden = false; setTimeout(hide, 12000); }, 11000);
    }
    close.addEventListener('click', hide);
  });

  /* ---------- 13. Re-measure after fonts/images settle ---------- */
  if (animate && doc.fonts && doc.fonts.ready) doc.fonts.ready.then(() => ScrollTrigger.refresh());
})();
