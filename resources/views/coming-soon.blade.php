<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Coming soon | {{ $site['name'] }}</title>
    <meta name="description" content="{{ $site['name'] }} — our new website is launching soon. Marketing, web development and AI automation.">
    <meta name="robots" content="noindex,nofollow">
    <meta name="theme-color" content="#fbfbf8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="preload" href="{{ asset('assets/fonts/plus-jakarta-sans.woff2') }}" as="font" type="font/woff2" crossorigin>
    <style>
        @font-face { font-family: "Plus Jakarta Sans"; src: url("{{ asset('assets/fonts/plus-jakarta-sans.woff2') }}") format("woff2"); font-weight: 300 800; font-display: swap; }
        :root { --ink: #0e1411; --ink-2: #44504a; --muted: #5d6862; --line: #e4e9e4; --green: #1ac27e; --green-700: #0c7f50; --green-100: #dff5ea; --sage: #eaf4ee; --sage-2: #dcefe4; --gold: #c9a24a; --ease: cubic-bezier(.22, 1, .36, 1); }
        *, *::before, *::after { box-sizing: border-box; }
        html { -webkit-text-size-adjust: 100%; }
        body { margin: 0; min-height: 100svh; font: 400 17px/1.65 "Plus Jakarta Sans", system-ui, -apple-system, "Segoe UI", sans-serif; color: var(--ink-2); background: #fbfbf8; -webkit-font-smoothing: antialiased; overflow-x: hidden; }
        a { color: inherit; text-decoration: none; } img { display: block; max-width: 100%; height: auto; } h1, h2, p { margin: 0; }
        :focus-visible { outline: 2px solid var(--green-700); outline-offset: 3px; border-radius: 8px; }

        /* soft decorative shapes (static) */
        .bg { position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; }
        .bg i { position: absolute; border-radius: 58% 42% 52% 48% / 46% 56% 44% 54%; background: var(--sage-2); }
        .bg i:nth-child(1) { width: min(70vw, 760px); aspect-ratio: 1; right: -18vw; top: -22vw; }
        .bg i:nth-child(2) { width: min(46vw, 460px); aspect-ratio: 1; left: -14vw; bottom: -16vw; background: #f6edd5; border-radius: 40% 60% 55% 45% / 55% 45% 60% 40%; }
        .dots { position: absolute; left: clamp(16px, 5vw, 80px); top: 120px; display: grid; grid-template-columns: repeat(5, 18px); gap: 10px; opacity: .8; }
        .dots b { width: 18px; height: 18px; border-radius: 28%; background: var(--green-100); } .dots b:nth-child(3n) { background: #f1e4bb; } .dots b:nth-child(4n) { background: transparent; }
        @media (max-width: 767px) { .dots { display: none; } }

        .wrap { position: relative; z-index: 1; min-height: 100svh; display: flex; flex-direction: column; padding: clamp(18px, 3vw, 36px) clamp(18px, 4vw, 48px); }
        header { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        header img { height: 42px; width: auto; }
        .status { display: inline-flex; align-items: center; gap: 9px; padding: 9px 16px; border-radius: 999px; background: #fff; border: 1px solid var(--line); font-size: .84rem; font-weight: 700; color: var(--ink); }
        .status::before { content: ""; width: 9px; height: 9px; border-radius: 50%; background: var(--green); box-shadow: 0 0 0 0 rgba(26, 194, 126, .5); animation: pulse 2.4s ease-out infinite; }
        @keyframes pulse { 70% { box-shadow: 0 0 0 10px rgba(26, 194, 126, 0); } 100% { box-shadow: 0 0 0 0 rgba(26, 194, 126, 0); } }

        main { flex: 1; display: grid; place-items: center; padding: clamp(28px, 5vw, 56px) 0; }
        .card { width: 100%; max-width: 760px; text-align: center; animation: rise .9s var(--ease) both; }
        @keyframes rise { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: none; } }
        .tag { display: inline-block; margin-bottom: 18px; font-size: .78rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; color: var(--green-700); }
        h1 { font-size: clamp(2.3rem, 6vw, 4.6rem); font-weight: 700; letter-spacing: -.045em; line-height: 1.06; color: var(--ink); text-wrap: balance; }
        h1 span { box-shadow: inset 0 -.36em 0 var(--green-100); -webkit-box-decoration-break: clone; box-decoration-break: clone; padding: 0 .08em; }
        .msg { max-width: 56ch; margin: 22px auto 0; font-size: clamp(1.02rem, 1.6vw, 1.18rem); }

        .count { display: none; justify-content: center; gap: clamp(8px, 2vw, 16px); margin: 34px auto 0; }
        .count.on { display: flex; }
        .count div { min-width: clamp(70px, 14vw, 104px); padding: 16px 8px 12px; border-radius: 24px; background: #fff; border: 1px solid var(--line); box-shadow: 0 22px 40px -30px rgba(14, 20, 17, .35); }
        .count strong { display: block; font-size: clamp(1.7rem, 5vw, 2.8rem); font-weight: 800; letter-spacing: -.04em; color: var(--ink); line-height: 1; font-variant-numeric: tabular-nums; }
        .count span { font-size: .72rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); }
        .soon { display: none; margin-top: 30px; font-weight: 700; color: var(--green-700); } .soon.on { display: block; }

        form { margin: 34px auto 0; max-width: 560px; padding: 10px; border-radius: 999px; background: #fff; border: 1px solid var(--line); box-shadow: 0 26px 50px -34px rgba(14, 20, 17, .4); display: flex; gap: 8px; }
        form input[type=text] { flex: 1; min-width: 0; border: 0; background: transparent; padding: 14px 20px; font: inherit; color: var(--ink); border-radius: 999px; }
        form input:focus { outline: 0; } form:focus-within { border-color: var(--green); box-shadow: 0 0 0 4px var(--green-100), 0 26px 50px -34px rgba(14, 20, 17, .4); }
        form button { flex: none; border: 0; border-radius: 999px; padding: 14px 26px; background: var(--ink); color: #fff; font: inherit; font-weight: 700; cursor: pointer; transition: background-color .25s ease, color .25s ease, transform .3s var(--ease); }
        form button:hover { background: var(--green); color: var(--ink); } form button:active { transform: scale(.97); } form button:disabled { opacity: .6; cursor: default; }
        .trap { position: absolute; left: -9999px; width: 0; height: 0; opacity: 0; }
        .note { min-height: 1.6em; margin: 12px 0 0; font-size: .92rem; font-weight: 600; } .note.ok { color: var(--green-700); } .note.err { color: #c0392b; }
        @media (max-width: 520px) { form { flex-direction: column; border-radius: 28px; } form button { width: 100%; } }

        .or { margin: 26px 0 14px; font-size: .8rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--muted); }
        .chan { display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; }
        .chan a { display: inline-flex; align-items: center; gap: 10px; padding: 13px 22px; border-radius: 999px; border: 1.5px solid var(--line); background: #fff; font-weight: 700; color: var(--ink); transition: transform .35s var(--ease), border-color .25s, background-color .25s; }
        .chan a:hover { transform: translateY(-2px); border-color: var(--ink); } .chan a.wa { background: #25d366; border-color: #25d366; color: #062b14; } .chan a.wa:hover { background: #1fb858; }
        .chan svg { flex: none; }
        footer { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 8px 20px; font-size: .86rem; color: var(--muted); }
        .prev { position: fixed; z-index: 5; left: 50%; bottom: 14px; transform: translateX(-50%); background: var(--ink); color: #fff; padding: 10px 18px; border-radius: 999px; font-size: .86rem; font-weight: 700; box-shadow: 0 14px 30px -12px rgba(0, 0, 0, .5); white-space: nowrap; }
        .prev a { color: var(--green); margin-left: 8px; text-decoration: underline; }
        @media (prefers-reduced-motion: reduce) { .card, .status::before { animation: none; } }
    </style>
</head>
<body>
    <div class="bg" aria-hidden="true"><i></i><i></i><div class="dots"><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b></div></div>

    <div class="wrap">
        <header>
            <img src="{{ asset('assets/img/brand/logo.webp') }}" width="1033" height="309" alt="{{ $site['name'] }}">
            <span class="status">Launching soon</span>
        </header>

        <main>
            <section class="card" aria-labelledby="csTitle">
                <span class="tag">We Build. We Grow. We Automate.</span>
                <h1 id="csTitle">{{ $csTitle }}</h1>
                <p class="msg">{{ $csMessage }}</p>

                <div class="count" id="count" data-launch="{{ $csLaunch }}" role="timer" aria-label="Time until launch">
                    <div><strong id="cd-d">00</strong><span>Days</span></div>
                    <div><strong id="cd-h">00</strong><span>Hours</span></div>
                    <div><strong id="cd-m">00</strong><span>Minutes</span></div>
                    <div><strong id="cd-s">00</strong><span>Seconds</span></div>
                </div>
                <p class="soon" id="soon">We’re launching any moment now ✨</p>

                <form id="notify" novalidate>
                    <input type="text" name="website" class="trap" tabindex="-1" autocomplete="off" aria-hidden="true">
                    <input type="text" id="contact" name="contact" inputmode="email" autocomplete="email" placeholder="Your email or WhatsApp number" aria-label="Your email or WhatsApp number" required>
                    <button type="submit" id="btn">Notify me</button>
                </form>
                <p class="note" id="note" role="status" aria-live="polite"></p>

                <p class="or">Or talk to us now</p>
                <div class="chan">
                    <a class="wa" href="{{ $wa }}?text={{ rawurlencode('Hi Progix Digital, I saw your coming soon page and would like to talk.') }}" target="_blank" rel="noopener"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2-1.41.25-.69.25-1.29.17-1.41-.07-.12-.27-.2-.57-.35zM12.04 21.8h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.86 9.86 0 0 1-1.51-5.26c0-5.45 4.44-9.88 9.89-9.88 2.64 0 5.12 1.03 6.99 2.9a9.82 9.82 0 0 1 2.89 6.99c0 5.45-4.44 9.88-9.88 9.88zM20.52 3.45A11.8 11.8 0 0 0 12.05 0C5.5 0 .16 5.34.16 11.89c0 2.1.55 4.14 1.59 5.95L.06 24l6.3-1.65a11.88 11.88 0 0 0 5.68 1.45h.01c6.55 0 11.89-5.34 11.89-11.89 0-3.18-1.24-6.16-3.48-8.41z"/></svg> WhatsApp us</a>
                    <a href="mailto:{{ $site['contact']['email'] }}"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg> {{ $site['contact']['email'] }}</a>
                </div>
            </section>
        </main>

        <footer>
            <span>&copy; {{ date('Y') }} {{ $site['name'] }}</span>
            <span>{{ $site['contact']['phone_pk'] }}</span>
        </footer>
    </div>

    @if (! empty($preview))
        <div class="prev">Preview — visitors see this when Coming soon is ON <a href="{{ route('admin.settings') }}">Back to settings</a></div>
    @endif

    <script>
        (function () {
            // ---- countdown ----
            var box = document.getElementById('count'), soon = document.getElementById('soon');
            var target = box.dataset.launch ? new Date(box.dataset.launch).getTime() : NaN;
            function pad(n) { return (n < 10 ? '0' : '') + n; }
            function tick() {
                var d = target - Date.now();
                if (isNaN(target)) { return; }
                if (d <= 0) { box.classList.remove('on'); soon.classList.add('on'); return; }
                box.classList.add('on');
                document.getElementById('cd-d').textContent = pad(Math.floor(d / 864e5));
                document.getElementById('cd-h').textContent = pad(Math.floor(d / 36e5) % 24);
                document.getElementById('cd-m').textContent = pad(Math.floor(d / 6e4) % 60);
                document.getElementById('cd-s').textContent = pad(Math.floor(d / 1e3) % 60);
                setTimeout(tick, 1000);
            }
            tick();

            // ---- notify form (saved as a lead + emailed to the team) ----
            var form = document.getElementById('notify'), input = document.getElementById('contact'), note = document.getElementById('note'), btn = document.getElementById('btn');
            function say(t, c) { note.textContent = t; note.className = 'note ' + (c || ''); }
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                var v = input.value.trim(), isMail = v.indexOf('@') > -1;
                if (!v || (isMail && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) || (!isMail && v.replace(/\D/g, '').length < 7)) { say('Please enter a valid email or WhatsApp number.', 'err'); input.focus(); return; }
                btn.disabled = true; say('Sending…');
                fetch(@json(route('booking')), {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify({ website: form.website.value, name: 'Website visitor', phone: isMail ? 'Email only' : v, email: isMail ? v : '', service: 'Launch notification', message: 'Please notify me when the website launches.' })
                }).then(function (r) {
                    if (!r.ok) { throw new Error(); }
                    form.style.display = 'none'; say('Thank you! We’ll let you know the moment we launch. 🎉', 'ok');
                }).catch(function () { btn.disabled = false; say('Something went wrong — please try again or message us on WhatsApp.', 'err'); });
            });
        })();
    </script>
</body>
</html>
