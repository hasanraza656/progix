@php $current = Route::currentRouteName(); @endphp
<header class="site-header" id="siteHeader">
    <div class="container header-inner">
        <a class="brand" href="{{ route('home') }}" aria-label="{{ $site['name'] }} — home">
            <img src="{{ asset('assets/img/brand/logo.webp') }}" width="1033" height="309" alt="{{ $site['name'] }}" class="brand-logo brand-logo--dark"><img src="{{ asset('assets/img/brand/logo-light.webp') }}" width="1033" height="309" alt="" class="brand-logo brand-logo--light" aria-hidden="true">
        </a>

        <nav class="primary-nav" aria-label="Primary">
            <ul class="nav-list">
                @foreach ($site['nav'] as $item)
                    @php
                        $active = $current === $item['route']
                            || ($item['route'] === 'services' && $current === 'service')
                            || ($item['route'] === 'blog' && $current === 'post')
                            || (isset($item['children']) && collect($item['children'])->pluck('route')->contains($current));
                    @endphp
                    @if (! empty($item['mega']))
                        <li class="nav-item has-mega">
                            <a href="{{ route($item['route']) }}" class="nav-link {{ $active ? 'is-active' : '' }}" aria-haspopup="true">
                                {{ $item['label'] }} <x-icon name="chevron-down" :size="14" />
                            </a>
                            <div class="mega" role="menu">
                                <div class="mega-grid">
                                    @foreach ($site['services'] as $s)
                                        <a href="{{ route('service', $s['slug']) }}" class="mega-item" role="menuitem">
                                            <span class="mega-ico"><x-icon :name="$s['icon']" :size="20" /></span>
                                            <span>
                                                <strong>{{ $s['title'] }}</strong>
                                                <small>{{ $s['short'] }}</small>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                                <div class="mega-foot">
                                    <span>Not sure what you need? We'll help you choose — free.</span>
                                    <a href="{{ route('pricing') }}" class="link-arrow">View pricing <x-icon name="arrow-right" :size="16" /></a>
                                </div>
                            </div>
                        </li>
                    @elseif (! empty($item['children']))
                        <li class="nav-item has-mega has-drop">
                            <a href="{{ route($item['route']) }}" class="nav-link {{ $active ? 'is-active' : '' }}" aria-haspopup="true">
                                {{ $item['label'] }} <x-icon name="chevron-down" :size="14" />
                            </a>
                            <div class="mega mega--sm" role="menu">
                                @foreach ($item['children'] as $ch)
                                    <a href="{{ route($ch['route']) }}" class="mega-item" role="menuitem">
                                        <span>
                                            <strong>{{ $ch['label'] }}</strong>
                                            <small>{{ $ch['desc'] }}</small>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route($item['route']) }}" class="nav-link {{ $active ? 'is-active' : '' }}" @if($active) aria-current="page" @endif>{{ $item['label'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>

        <div class="header-cta">
            <a href="{{ $wa }}?text={{ rawurlencode('Hi Progix Digital, I would like to know more about your services.') }}" class="icon-btn icon-btn--wa" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
                <x-icon name="whatsapp" :size="20" />
            </a>
            <button type="button" class="btn-p btn-p--ink btn-p--sm d-none d-md-inline-flex" data-book>
                Book a Free Call <span class="btn-arrow"><x-icon name="arrow-right" :size="16" /></span>
            </button>
            <button class="icon-btn menu-toggle d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Open menu">
                <x-icon name="menu" :size="22" />
            </button>
        </div>
    </div>
</header>

{{-- Mobile menu --}}
<div class="offcanvas offcanvas-end mobile-menu" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
    <div class="offcanvas-header">
        <img src="{{ asset('assets/img/brand/logo.webp') }}" width="1033" height="309" alt="{{ $site['name'] }}" class="brand-logo" id="mobileMenuLabel">
        <button type="button" class="icon-btn" data-bs-dismiss="offcanvas" aria-label="Close menu"><x-icon name="x" :size="22" /></button>
    </div>
    <div class="offcanvas-body">
        <ul class="m-nav">
            @foreach ($site['nav'] as $item)
                @if (! empty($item['mega']))
                    <li>
                        <a href="{{ route($item['route']) }}" class="m-link">{{ $item['label'] }}</a>
                        <ul class="m-sub">
                            @foreach ($site['services'] as $s)
                                <li><a href="{{ route('service', $s['slug']) }}"><x-icon :name="$s['icon']" :size="18" /> {{ $s['title'] }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @elseif (! empty($item['children']))
                    <li>
                        <span class="m-link m-link--label">{{ $item['label'] }}</span>
                        <ul class="m-sub">
                            @foreach ($item['children'] as $ch)
                                <li><a href="{{ route($ch['route']) }}">{{ $ch['label'] }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li><a href="{{ route($item['route']) }}" class="m-link">{{ $item['label'] }}</a></li>
                @endif
            @endforeach
        </ul>
        <div class="m-cta">
            <button type="button" class="btn-p btn-p--ink btn-p--lg w-100" data-book data-bs-dismiss="offcanvas">Book a Free Consultation</button>
            <a href="{{ $wa }}" target="_blank" rel="noopener" class="btn-p btn-p--wa btn-p--lg w-100"><x-icon name="whatsapp" :size="20" /> Chat on WhatsApp</a>
            <a href="tel:{{ preg_replace('/\s+/', '', $site['contact']['phone_pk']) }}" class="m-phone"><x-icon name="phone" :size="18" /> {{ $site['contact']['phone_pk'] }}</a>
        </div>
    </div>
</div>
