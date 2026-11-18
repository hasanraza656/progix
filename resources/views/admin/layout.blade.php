@php
    $ver = fn ($p) => asset($p).'?v='.@filemtime(public_path($p));
    $me = auth()->user();
    try { $newLeads = \App\Models\Lead::where('status', 'new')->count(); } catch (\Throwable $e) { $newLeads = 0; }
    $nav = [
        ['admin.dashboard', 'layout-dashboard', 'Dashboard', 'admin.dashboard', null],
        ['admin.leads.index', 'inbox', 'Leads', 'admin.leads.*', $newLeads ?: null],
        ['admin.posts.index', 'file-text', 'Insights (Blog)', 'admin.posts.*', null],
    ];
    $nav2 = [
        ['admin.settings', 'globe', 'Site settings', 'admin.settings*'],
        ['admin.account', 'user', 'My account', 'admin.account*'],
        ['admin.system', 'settings', 'System & updates', 'admin.system*'],
    ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="robots" content="noindex,nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0e1411">
    <title>@yield('title', 'Admin') · Progix Admin</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="preload" href="{{ asset('assets/fonts/plus-jakarta-sans.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ $ver('assets/admin/admin.css') }}">
    @stack('head')
</head>
<body>
<div class="shell">
    <aside class="side" id="side" aria-label="Admin navigation">
        <div class="side-brand"><a href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/img/brand/logo-light.webp') }}" width="1033" height="309" alt="Progix Digital"></a></div>
        <nav class="side-nav">
            <div class="side-label">Manage</div>
            @foreach ($nav as [$route, $icon, $label, $pattern, $count])
                <a href="{{ route($route) }}" class="nav-a {{ request()->routeIs($pattern) ? 'is-on' : '' }}"><x-icon :name="$icon" :size="20" /> {{ $label }} @if ($count)<span class="count">{{ $count }}</span>@endif</a>
            @endforeach
            <div class="side-label">Settings</div>
            @foreach ($nav2 as [$route, $icon, $label, $pattern])
                <a href="{{ route($route) }}" class="nav-a {{ request()->routeIs($pattern) ? 'is-on' : '' }}"><x-icon :name="$icon" :size="20" /> {{ $label }} @if ($route === 'admin.settings' && ($comingSoon ?? false))<span class="state" title="Coming soon mode is ON"></span>@endif</a>
            @endforeach
        </nav>
        <div class="side-foot">
            <a href="{{ route('home') }}" target="_blank" class="nav-a"><x-icon name="globe" :size="20" /> View website <x-icon name="external" :size="14" /></a>
            <div class="side-user"><span class="avatar">{{ strtoupper(substr($me->name, 0, 1)) }}</span><span>{{ $me->name }}<small>{{ $me->email }}</small></span></div>
            <form method="post" action="{{ route('admin.logout') }}">@csrf<button class="nav-a" type="submit"><x-icon name="log-out" :size="20" /> Sign out</button></form>
        </div>
    </aside>

    <div class="main">
        <header class="top">
            <button class="burger" type="button" id="burger" aria-label="Open menu" aria-controls="side"><x-icon name="menu" :size="22" /></button>
            <h1>@yield('heading', View::getSection('title', 'Admin'))</h1>
            <div class="top-actions">@yield('actions')</div>
        </header>

        <main class="content">
            @if (session('success'))<div class="flash" role="status"><x-icon name="check" :size="20" /> {{ session('success') }}</div>@endif
            @if (session('error'))<div class="flash error" role="alert"><x-icon name="alert" :size="20" /> {{ session('error') }}</div>@endif
            @if ($errors->any() && ! View::hasSection('own-errors'))<div class="flash error" role="alert"><x-icon name="alert" :size="20" /> Please fix the highlighted fields and try again.</div>@endif
            @yield('content')
        </main>
    </div>
</div>

<div class="modal-bg" id="confirmBg" role="dialog" aria-modal="true" aria-labelledby="confirmTitle">
    <div class="modal-box">
        <h3 id="confirmTitle">Are you sure?</h3>
        <p class="muted" id="confirmText"></p>
        <div class="btns"><button type="button" class="btn btn--line" id="confirmNo">Cancel</button><button type="button" class="btn btn--danger" id="confirmYes">Yes, continue</button></div>
    </div>
</div>

<script>window.ADMIN = { csrf: document.querySelector('meta[name=csrf-token]').content, upload: @json(route('admin.media.upload')), site: @json(url('/')) };</script>
<script src="{{ $ver('assets/admin/admin.js') }}" defer></script>
@stack('scripts')
</body>
</html>
