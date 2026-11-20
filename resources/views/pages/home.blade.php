@extends('layouts.app')

@section('body_class', 'hdr-dark')

@push('head')
    <link rel="preload" as="image" href="{{ asset('assets/img/home2/hero-web-m.webp') }}" imagesrcset="{{ asset('assets/img/home2/hero-web-m.webp') }} 1080w, {{ asset('assets/img/home2/hero-web.webp') }} 1880w" imagesizes="100vw" fetchpriority="high">
    <link rel="stylesheet" href="{{ asset('assets/css/home2.css') }}?v={{ @filemtime(public_path('assets/css/home2.css')) }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/home2.js') }}?v={{ @filemtime(public_path('assets/js/home2.js')) }}" defer></script>
    <script>
        document.querySelectorAll('.pillar-tab').forEach(function (tab) {
            tab.addEventListener('mouseenter', function () {
                if (window.innerWidth >= 992 && !tab.classList.contains('active')) tab.click();
            });
        });
    </script>
@endpush

@section('content')
@php
    $u = $site['upwork'];
    $img2 = fn ($n, $m = false) => asset('assets/img/home2/'.$n.($m ? '-m' : '').'.webp');
    $heroSlides = [
        ['key' => 'hero-web', 'tag' => 'Technology', 'icon' => 'code', 'title' => 'We <em>Build.</em>', 'text' => 'Modern, responsive and SEO-ready websites & apps — from a single landing page to a full custom platform.', 'link' => route('service', 'web-development'), 'cta' => 'Explore web development', 'alt' => 'Source code on a laptop screen in a dark room'],
        ['key' => 'hero-marketing', 'tag' => 'Marketing', 'icon' => 'megaphone', 'title' => 'We <em>Grow.</em>', 'text' => 'Social media, paid ads and SEO content that turn attention into customers — planned, created and reported by one team.', 'link' => route('service', 'social-media-marketing'), 'cta' => 'Explore marketing', 'alt' => 'Marketing team celebrating around a table'],
        ['key' => 'hero-ai', 'tag' => 'Automation', 'icon' => 'bot', 'title' => 'We <em>Automate.</em>', 'text' => 'AI chatbots and smart workflows that answer customers, qualify leads and follow up — around the clock.', 'link' => route('service', 'ai-automation'), 'cta' => 'Explore AI & automation', 'alt' => 'Robotic hand reaching into a digital network'],
    ];
    $pillars = [
        [
            'tag' => 'Marketing', 'icon' => 'megaphone',
            'title' => 'Grow your brand with content people actually enjoy',
            'text' => 'From strategy and daily content to paid campaigns and SEO copy, we build a steady stream of attention, enquiries and customers.',
            'points' => ['Social media management on up to 5 platforms', 'Meta and Google Ads with proper tracking', 'SEO-friendly website content &amp; keyword mapping'],
            'link' => route('service', 'social-media-marketing'), 'cta' => 'Explore marketing',
        ],
        [
            'tag' => 'Technology', 'icon' => 'code',
            'title' => 'Websites &amp; apps built to look sharp and perform',
            'text' => 'Modern, responsive and SEO-ready — from a single landing page to a full custom platform, with care plans to keep everything running.',
            'points' => ['Landing pages from $129, business sites from $349', 'Laravel, React, Next.js, WordPress, Shopify &amp; more', 'Backups, updates and security with monthly care plans'],
            'link' => route('service', 'web-development'), 'cta' => 'Explore web development',
        ],
        [
            'tag' => 'Automation', 'icon' => 'bot',
            'title' => 'Work smarter — let AI handle the repetitive parts',
            'text' => 'AI chatbots that answer customers around the clock and automated workflows that capture leads, update your CRM and follow up for you.',
            'points' => ['AI agents trained on your approved knowledge', 'OpenAI, Gemini, n8n, Make &amp; LangChain', 'Starting at just $99 for a website assistant'],
            'link' => route('service', 'ai-automation'), 'cta' => 'Explore AI &amp; automation',
        ],
    ];
@endphp

{{-- ============================== HERO (Home Two style, 3-slide carousel) ============================== --}}
<section class="h2-hero" id="top" data-hero aria-roledescription="carousel" aria-label="Featured services">
    <div class="h2-slides">
        @foreach ($heroSlides as $i => $s)
            <article class="h2-slide {{ $i === 0 ? 'is-active' : '' }}" data-slide aria-roledescription="slide" aria-label="{{ $i + 1 }} of {{ count($heroSlides) }}" @if($i) aria-hidden="true" @endif>
                <img class="h2-bg" src="{{ $img2($s['key']) }}" srcset="{{ $img2($s['key'], true) }} 1080w, {{ $img2($s['key']) }} 1880w" sizes="100vw" width="1880" height="1253" alt="{{ $s['alt'] }}" decoding="async" @if($i === 0) fetchpriority="high" @else fetchpriority="low" loading="lazy" @endif>
                <div class="h2-tint"></div>
                <div class="container h2-content">
                    <span class="h2-chip"><x-icon :name="$s['icon']" :size="16" /> {{ $s['tag'] }}</span>
                    <h2 class="h2-title">{!! $s['title'] !!}</h2>
                    <p class="h2-sub">{{ $s['text'] }}</p>
                    <div class="h2-actions">
                        <button type="button" class="h2-btn h2-btn--green" data-book>Book a Free Consultation <span class="h2-btn-arrow"><x-icon name="arrow-right" :size="18" /></span></button>
                        <a href="{{ $s['link'] }}" class="h2-btn h2-btn--glass">{{ $s['cta'] }}</a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="container h2-kicker-wrap">
        <div class="h2-kicker"><h1>Digital marketing, web development and AI automation agency</h1><span>Serving clients worldwide</span></div>
    </div>

    <div class="container h2-ui">
        <div class="h2-nav" role="tablist" aria-label="Choose slide">
            @foreach ($heroSlides as $i => $s)
                <button type="button" class="h2-pip {{ $i === 0 ? 'is-active' : '' }}" data-pip="{{ $i }}" role="tab" aria-selected="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Show slide {{ $i + 1 }}: {{ $s['tag'] }}">
                    <span class="h2-pip-n">0{{ $i + 1 }}</span><span class="h2-pip-l">{{ $s['tag'] }}</span><i></i>
                </button>
            @endforeach
        </div>
        <div class="h2-arrows">
            <button type="button" class="h2-arrow" data-prev aria-label="Previous slide"><x-icon name="chevron-left" :size="22" /></button>
            <button type="button" class="h2-arrow" data-next aria-label="Next slide"><x-icon name="chevron-right" :size="22" /></button>
        </div>
    </div>

    <div class="h2-glass" aria-hidden="true">
        <div><strong>10+</strong><span>years</span></div>
        <div><strong>1,200+</strong><span>projects</span></div>
        <div><strong>{{ $u['rating'] }} <x-icon name="star" :size="14" /></strong><span>Upwork</span></div>
    </div>

    <svg class="h2-wave" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true"><path d="M0,70 C180,118 360,118 560,72 C760,26 940,20 1140,62 C1280,92 1380,86 1440,66 L1440,120 L0,120 Z"/></svg>
</section>

{{-- ============================== CLIENTS ============================== --}}
<section class="logos" id="clients" aria-labelledby="logosTitle">
    <div class="container">
        <p class="logos-title" id="logosTitle" data-reveal>Trusted by brands &amp; businesses across 37+ industries</p>
    </div>
    @include('partials.clients-marquee')
</section>

{{-- ============================== SERVICES ============================== --}}
<section class="section" id="services">
    <div class="container">
        @include('partials.section-head', [
            'eyebrow' => 'Our services',
            'title' => 'Everything your business needs to <span class="accent">grow online</span>',
            'lead' => 'Strategy, creativity and technology working together — so you don’t have to manage five different agencies.',
        ])

        <div class="row g-4 services-grid" data-stagger>
            @foreach ($site['services'] as $i => $s)
                <div class="col-md-6 col-lg-4" data-reveal-item>
                    <a href="{{ route('service', $s['slug']) }}" class="svc-card">
                        <span class="svc-ico"><x-icon :name="$s['icon']" :size="26" /></span>
                        <span class="svc-tag">{{ $s['pillar'] }}</span>
                        <h3>{{ $s['title'] }}</h3>
                        <p>{{ $s['short'] }}</p>
                        <span class="svc-foot">
                            <span>From <strong>${{ $s['from'] }}</strong> <small class="from-unit">{{ $s['from_unit'] ?? '' }}</small>@if (! empty($s['from_alt'])) <small class="from-alt">{{ $s['from_alt'] }}</small>@endif</span>
                            <span class="svc-go"><x-icon name="arrow-up-right" :size="18" /></span>
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== STATS ============================== --}}
<section class="section section--tint stats-section" id="why">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                @include('partials.section-head', [
                    'eyebrow' => 'Why choose us',
                    'title' => 'Experience, strategy, creativity <span class="accent">&amp; technology</span>',
                    'lead' => 'Over a decade of turning ideas into measurable results for businesses of every size.',
                    'align' => 'left',
                ])
                <div data-reveal>
                    <a href="{{ route('about') }}" class="link-arrow link-arrow--lg">More about us <x-icon name="arrow-right" :size="18" /></a>
                </div>
            </div>
            <div class="col-lg-7">
                @include('partials.stats')
            </div>
        </div>

        <div class="row g-4 mt-4 why-grid" data-stagger>
            @foreach ($site['why'] as $w)
                <div class="col-md-6 col-lg-4" data-reveal-item>
                    <div class="why-card">
                        <span class="why-ico"><x-icon :name="$w['icon']" :size="22" /></span>
                        <div>
                            <h3>{{ $w['title'] }}</h3>
                            <p>{{ $w['text'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== PILLARS (click-to-switch tabs) ============================== --}}
<section class="section pillars">
    <div class="container">
        @include('partials.section-head', [
            'eyebrow' => 'What you get',
            'title' => 'Three ways we help you <span class="accent">move faster</span>',
            'lead' => 'Marketing to grow your brand. Technology to build digital products. Automation to work smarter.',
        ])

        <div class="row g-5 align-items-start pillar-tabs" data-reveal>
            <div class="col-lg-4">
                <div class="nav pillar-tablist" role="tablist" aria-orientation="vertical">
                    @foreach ($pillars as $i => $p)
                        <button class="pillar-tab {{ $i === 0 ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#pillarPane-{{ $i }}" type="button" role="tab" aria-selected="{{ $i === 0 ? 'true' : 'false' }}">
                            <span class="pillar-tab-n">0{{ $i + 1 }}</span>
                            <span class="pillar-tab-ico"><x-icon :name="$p['icon']" :size="20" /></span>
                            <span class="pillar-tab-label">{{ $p['tag'] }}</span>
                            <x-icon name="arrow-right" :size="18" class="pillar-tab-go" />
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-8">
                <div class="tab-content pillar-panels">
                    @foreach ($pillars as $i => $p)
                        <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" id="pillarPane-{{ $i }}" role="tabpanel">
                            <span class="pillar-tag {{ $i === 1 ? 'pillar-tag--gold' : '' }}"><x-icon :name="$p['icon']" :size="16" /> {{ $p['tag'] }}</span>
                            <h3>{!! $p['title'] !!}</h3>
                            <p>{{ $p['text'] }}</p>
                            <ul class="check-list">
                                @foreach ($p['points'] as $point)
                                    <li><x-icon name="check" :size="18" /> {!! $point !!}</li>
                                @endforeach
                            </ul>
                            <a href="{{ $p['link'] }}" class="btn-p btn-p--line">{!! $p['cta'] !!} <span class="btn-arrow"><x-icon name="arrow-right" :size="16" /></span></a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================== PROCESS ============================== --}}
<section class="section section--tint process" id="process">
    <div class="container">
        @include('partials.section-head', [
            'eyebrow' => 'How it works',
            'title' => 'From first hello to <span class="accent">measurable growth</span>',
            'lead' => 'A simple, transparent five-step process — you always know what happens next.',
        ])
        <div class="steps" data-steps>
            <div class="steps-line" aria-hidden="true"><span></span></div>
            @foreach ($site['process'] as $i => $st)
                <div class="step" data-step>
                    <span class="step-ico"><x-icon :name="$st['icon']" :size="22" /></span>
                    <span class="step-n">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ $st['title'] }}</h3>
                    <p>{{ $st['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== PRICING TEASER ============================== --}}
<section class="section" id="packages">
    <div class="container">
        @include('partials.section-head', [
            'eyebrow' => 'Pricing',
            'title' => 'Simple, transparent <span class="accent">packages</span>',
            'lead' => 'Social media management plans that scale with you. See every service on the pricing page.',
        ])
        @include('partials.pricing-cards', ['group' => 'social', 'limit' => 6])
        <div class="text-center mt-5" data-reveal>
            <a href="{{ route('pricing') }}" class="btn-p btn-p--line btn-p--lg">See all pricing <span class="btn-arrow"><x-icon name="arrow-right" :size="18" /></span></a>
        </div>
    </div>
</section>

{{-- ============================== FOUNDER ============================== --}}
<section class="section section--tint founder" id="founder">
    <div class="container">
        <div class="founder-card" data-reveal="scale">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <div class="founder-photo">
                        <div class="founder-shape" aria-hidden="true"></div>
                        <img src="{{ asset('assets/img/brand/founder.webp') }}?v=3" width="1218" height="1288" alt="{{ $site['founder']['name'] }}, founder of Progix Digital" loading="lazy" decoding="async">
                    </div>
                </div>
                <div class="col-lg-7">
                    <span class="eyebrow">Meet our founder</span>
                    <h2 class="h-section">{{ $site['founder']['name'] }}</h2>
                    <p class="founder-role">{{ $site['founder']['role'] }}, Progix Digital</p>
                    <p class="founder-quote">{{ $site['founder']['bio'] }}</p>
                    <p>{{ $site['founder']['bio_long'] }}</p>
                    @php
                        $parseStat = function ($str) {
                            preg_match('/^([^\d]*)([\d,]+)(.*)$/', $str, $m);
                            return ['prefix' => $m[1] ?? '', 'value' => (int) str_replace(',', '', $m[2] ?? '0'), 'suffix' => $m[3] ?? ''];
                        };
                        $success = $parseStat($u['success']);
                        $earnings = $parseStat($u['earnings']);
                        $jobs = $parseStat($u['jobs']);
                        $hours = $parseStat($u['hours']);
                    @endphp
                    <ul class="founder-stats">
                        <li><strong>{{ $success['prefix'] }}<b data-count="{{ $success['value'] }}">0</b>{{ $success['suffix'] }}</strong><span>Job success</span></li>
                        <li><strong>{{ $earnings['prefix'] }}<b data-count="{{ $earnings['value'] }}">0</b>{{ $earnings['suffix'] }}</strong><span>Earned on Upwork</span></li>
                        <li><strong>{{ $jobs['prefix'] }}<b data-count="{{ $jobs['value'] }}">0</b>{{ $jobs['suffix'] }}</strong><span>Jobs delivered</span></li>
                        <li><strong>{{ $hours['prefix'] }}<b data-count="{{ $hours['value'] }}">0</b>{{ $hours['suffix'] }}</strong><span>Hours worked</span></li>
                    </ul>
                    <button type="button" class="btn-p btn-p--ink btn-p--lg" data-book>Book a Free Consultation <span class="btn-arrow"><x-icon name="arrow-right" :size="18" /></span></button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================== REVIEWS (Home Two dark style) ============================== --}}
<section class="h2-section h2-reviews" id="reviews">
    <div class="container">
        <div class="h2-head h2-head--light" data-reveal>
            <span class="h2-eyebrow h2-eyebrow--gold">Client love</span>
            <h2>Don’t take our word for it — <em>listen to clients.</em></h2>
            <p>Verified 5-star feedback from our Upwork profile — {{ $u['badge'] }}, {{ $u['success'] }} job success.</p>
        </div>
        <div class="h2-reviews-slider" data-reveal>@include('partials.testimonial-slider')</div>
    </div>
</section>

{{-- ============================== CASE STUDIES ============================== --}}
<section class="section section--tint" id="work">
    <div class="container">
        @include('partials.section-head', [
            'eyebrow' => 'Selected work',
            'title' => 'Results that speak <span class="accent">for themselves</span>',
            'lead' => 'A glimpse at the kind of growth we deliver across marketing, web and AI.',
        ])
        <div class="row g-4" data-stagger>
            @foreach (array_slice($site['projects'], 0, 3) as $p)
                <div class="col-md-6 col-lg-4">@include('partials.project-card', ['p' => $p])</div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-reveal>
            <a href="{{ route('testimonials') }}" class="btn-p btn-p--line btn-p--lg">View all case studies <span class="btn-arrow"><x-icon name="arrow-right" :size="18" /></span></a>
        </div>
    </div>
</section>

{{-- ============================== FAQ ============================== --}}
<section class="section" id="faq">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4 faq-sticky-col">
                @include('partials.section-head', [
                    'eyebrow' => 'FAQ',
                    'title' => 'Questions? <span class="accent">Answered.</span>',
                    'lead' => 'Can’t find what you’re looking for? Message us on WhatsApp — we reply fast.',
                    'align' => 'left',
                ])
                <div data-reveal>
                    <a href="{{ $wa }}" target="_blank" rel="noopener" class="btn-p btn-p--wa"><x-icon name="whatsapp" :size="18" /> Ask on WhatsApp</a>
                </div>
            </div>
            <div class="col-lg-8">
                @include('partials.faq', ['items' => $site['faqs'], 'uid' => 'homeFaq'])
            </div>
        </div>
    </div>
</section>

{{-- ============================== INSIGHTS ============================== --}}
<section class="section section--tint" id="insights">
    <div class="container">
        <div class="head-row">
            @include('partials.section-head', [
                'eyebrow' => 'Insights',
                'title' => 'Fresh ideas for <span class="accent">growing online</span>',
                'align' => 'left',
            ])
            <a href="{{ route('blog') }}" class="link-arrow link-arrow--lg" data-reveal>All articles <x-icon name="arrow-right" :size="18" /></a>
        </div>
        <div class="row g-4" data-stagger>
            @foreach ($posts as $post)
                <div class="col-md-6 col-lg-4">@include('partials.post-card', ['post' => $post])</div>
            @endforeach
        </div>
    </div>
</section>
@endsection
