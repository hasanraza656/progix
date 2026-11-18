@php
    $ver = fn ($p) => asset($p).'?v='.@filemtime(public_path($p));
    $pageTitle = ($seo['raw_title'] ?? false) ? $seo['title'] : $seo['title'].' | '.$site['name'];
    $canonical = $seo['canonical'] ?? url()->current();
    $ogImage = asset($seo['image']);
@endphp
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="theme-color" content="{{ $site['theme_color'] }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="{{ $site['name'] }}">
    @if ($seo['noindex'])
        <meta name="robots" content="noindex,follow">
    @else
        <meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
    @endif
    <link rel="canonical" href="{{ $canonical }}">

    {{-- Open Graph / Twitter --}}
    <meta property="og:site_name" content="{{ $site['name'] }}">
    <meta property="og:type" content="{{ $seo['type'] }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:locale" content="{{ $site['locale'] }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    {{-- Icons --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/brand/favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/brand/favicon-16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/brand/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    {{-- Performance: self-hosted font + CSS, no render-blocking third parties --}}
    <link rel="preload" href="{{ asset('assets/fonts/plus-jakarta-sans.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/fonts/instrument-serif-italic.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ $ver('assets/css/app.css') }}">
    <script>
        document.documentElement.className = 'js';
        /* failsafe: if animations never initialise, show all content */
        setTimeout(function () { if (!document.documentElement.classList.contains('ready')) document.documentElement.classList.add('no-anim'); }, 3500);
    </script>
    @stack('head')

    @include('partials.schema')
</head>
<body class="page-{{ Route::currentRouteName() }} @yield('body_class')">
    <a class="skip-link" href="#main">Skip to content</a>
    <div class="scroll-progress" aria-hidden="true"><span></span></div>

    @include('partials.header')

    <main id="main">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.floating')
    @include('partials.booking-modal')

    @if (($comingSoon ?? false) && auth()->check())
        <a href="{{ route('admin.settings') }}" style="position:fixed;left:50%;bottom:14px;transform:translateX(-50%);z-index:2000;background:#0e1411;color:#fff;padding:10px 18px;border-radius:999px;font:700 .85rem/1.2 'Plus Jakarta Sans',sans-serif;box-shadow:0 14px 30px -12px rgba(0,0,0,.5);white-space:nowrap">Coming soon mode is ON — only you can see this site <span style="color:#1ac27e;margin-left:6px;text-decoration:underline">Manage</span></a>
    @endif

    <noscript><style>.js-only{display:none!important}[data-reveal]{opacity:1!important;transform:none!important}</style></noscript>

    <script>
        window.PROGIX = {
            whatsapp: @json($site['contact']['whatsapp']),
            email: @json($site['contact']['email']),
            calendly: @json($site['contact']['calendly']),
            checkout: @json($site['checkout']),
            services: @json(collect($site['services'])->pluck('title')),
        };
    </script>
    <script src="{{ asset('assets/vendor/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendor/gsap.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendor/ScrollTrigger.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendor/lenis.min.js') }}" defer></script>
    <script src="{{ $ver('assets/js/app.js') }}" defer></script>
    @stack('scripts')
    {{-- Tidio live chat (public website only) --}}
    <script src="//code.tidio.co/as7mp5lr9iqgsluyiqitjslhvuurl7db.js" async></script>
</body>
</html>
