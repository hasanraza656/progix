@extends('layouts.app')

@section('body_class', 'hdr-dark home2')

@push('head')
    <link rel="preload" as="image" href="{{ asset('assets/img/home2/hero-marketing-m.webp') }}" imagesrcset="{{ asset('assets/img/home2/hero-marketing-m.webp') }} 1080w, {{ asset('assets/img/home2/hero-marketing.webp') }} 1880w" imagesizes="100vw" fetchpriority="high">
    <link rel="stylesheet" href="{{ asset('assets/css/home2.css') }}?v={{ @filemtime(public_path('assets/css/home2.css')) }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/home2.js') }}?v={{ @filemtime(public_path('assets/js/home2.js')) }}" defer></script>
@endpush

@php
    $img = fn ($n, $m = false) => asset('assets/img/home2/'.$n.($m ? '-m' : '').'.webp');
    $u = $site['upwork'];
    $slides = [
        ['key' => 'hero-marketing', 'tag' => 'Marketing', 'icon' => 'megaphone', 'title' => 'We grow brands <em>people remember.</em>', 'text' => 'Social media, paid ads and SEO content that turn attention into customers — planned, created and reported by one dedicated team.', 'link' => route('service', 'social-media-marketing'), 'cta' => 'Explore marketing', 'alt' => 'Marketing team celebrating around a table'],
        ['key' => 'hero-web', 'tag' => 'Technology', 'icon' => 'code', 'title' => 'Websites that load fast and <em>convert faster.</em>', 'text' => 'Custom, responsive websites and web apps built with clean code, beautiful design and SEO baked in from the first line.', 'link' => route('service', 'web-development'), 'cta' => 'Explore web development', 'alt' => 'Source code on a laptop screen in a dark room'],
        ['key' => 'hero-ai', 'tag' => 'Automation', 'icon' => 'bot', 'title' => 'Automate the busywork. <em>Keep the human touch.</em>', 'text' => 'AI chatbots and smart workflows that answer customers, qualify leads and follow up — around the clock.', 'link' => route('service', 'ai-automation'), 'cta' => 'Explore AI & automation', 'alt' => 'Robotic hand reaching into a digital network'],
        ['key' => 'hero-creative', 'tag' => 'Creative', 'icon' => 'palette', 'title' => 'Brands with a look <em>worth remembering.</em>', 'text' => 'Brand kits, content design and creative direction that make every post, page and ad unmistakably yours.', 'link' => route('service', 'creative-branding'), 'cta' => 'Explore branding', 'alt' => 'Creative designer workspace with computer and moodboard'],
    ];
    $stackImg = ['social-media-marketing' => 'team', 'paid-advertising' => 'meeting', 'website-content-seo' => 'studio', 'web-development' => 'code', 'ai-automation' => 'hero-ai', 'creative-branding' => 'hero-creative'];
    $tones = ['ink', 'green', 'gold', 'white', 'ink', 'green'];
    $picks = [
        ['group' => 'social', 'plan' => 1],
        ['group' => 'web', 'plan' => 1],
        ['group' => 'ai', 'plan' => 1],
    ];
@endphp

@section('content')
{{-- ============================== HERO SLIDER ============================== --}}
<section class="h2-hero" id="top" data-hero aria-roledescription="carousel" aria-label="Featured services">
    <div class="h2-slides">
        @foreach ($slides as $i => $s)
            <article class="h2-slide {{ $i === 0 ? 'is-active' : '' }}" data-slide aria-roledescription="slide" aria-label="{{ $i + 1 }} of {{ count($slides) }}" @if($i) aria-hidden="true" @endif>
                <img class="h2-bg" src="{{ $img($s['key']) }}" srcset="{{ $img($s['key'], true) }} 1080w, {{ $img($s['key']) }} 1880w" sizes="100vw" width="1880" height="1253" alt="{{ $s['alt'] }}" decoding="async" @if($i === 0) fetchpriority="high" @else fetchpriority="low" loading="lazy" @endif>
                <div class="h2-tint"></div>
                <div class="container h2-content">
                    <span class="h2-chip"><x-icon :name="$s['icon']" :size="16" /> {{ $s['tag'] }}</span>
                    @if ($i === 0)<h1 class="h2-title">{!! $s['title'] !!}</h1>@else<h2 class="h2-title">{!! $s['title'] !!}</h2>@endif
                    <p class="h2-sub">{{ $s['text'] }}</p>
                    <div class="h2-actions">
                        <button type="button" class="h2-btn h2-btn--green" data-book>Book a Free Consultation <span class="h2-btn-arrow"><x-icon name="arrow-right" :size="18" /></span></button>
                        <a href="{{ $s['link'] }}" class="h2-btn h2-btn--glass">{{ $s['cta'] }}</a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="container h2-ui">
        <div class="h2-nav" role="tablist" aria-label="Choose slide">
            @foreach ($slides as $i => $s)
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

{{-- ============================== TAGLINE MARQUEE ============================== --}}
<section class="h2-tag" aria-hidden="true">
    <div class="h2-tag-track">
        @for ($i = 0; $i < 6; $i++)
            <span>We Build</span><i></i><span class="o">We Grow</span><i></i><span>We Automate</span><i></i>
        @endfor
    </div>
</section>

{{-- ============================== CLIENTS ============================== --}}
<section class="h2-logos">
    <div class="container"><p class="h2-kicker" data-reveal>Trusted by brands across 37+ industries</p></div>
    @include('partials.clients-marquee')
</section>

{{-- ============================== SERVICES (stacked cards) ============================== --}}
<section class="h2-section" id="services">
    <div class="container">
        <div class="h2-head" data-reveal>
            <span class="h2-eyebrow">What we do</span>
            <h2>Six services. <em>One team.</em> Zero juggling.</h2>
            <p>Everything your business needs to grow online — scroll through to see how each piece fits together.</p>
        </div>

        <div class="h2-stack" data-stack>
            @foreach ($site['services'] as $i => $s)
                <article class="h2-card h2-card--{{ $tones[$i] }}" data-card style="--i: {{ $i }}">
                    <div class="h2-card-in">
                        <div class="h2-card-copy">
                            <span class="h2-num">0{{ $i + 1 }}</span>
                            <span class="h2-card-tag">{{ $s['pillar'] }}</span>
                            <h3>{{ $s['title'] }}</h3>
                            <p>{{ $s['lead'] }}</p>
                            <ul>
                                @foreach (array_slice($s['includes'], 0, 3) as $inc)<li><x-icon name="check" :size="16" /> {{ $inc }}</li>@endforeach
                            </ul>
                            <div class="h2-card-foot">
                                <a href="{{ route('service', $s['slug']) }}" class="h2-btn h2-btn--ink">Learn more <span class="h2-btn-arrow"><x-icon name="arrow-right" :size="16" /></span></a>
                                <span class="h2-from">from <strong>${{ $s['from'] }}</strong></span>
                            </div>
                        </div>
                        <div class="h2-card-media">
                            <img src="{{ $img($stackImg[$s['slug']]) }}" srcset="{{ $img($stackImg[$s['slug']], true) }} 1080w, {{ $img($stackImg[$s['slug']]) }} 1880w" sizes="(min-width: 992px) 48vw, 90vw" width="1880" height="1253" alt="{{ $s['title'] }}" loading="lazy" decoding="async" data-parallax>
                            <span class="h2-card-ico"><x-icon :name="$s['icon']" :size="26" /></span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== WHY (dark panel) ============================== --}}
<section class="h2-section h2-section--tight">
    <div class="container">
        <div class="h2-dark-panel" data-reveal="scale">
            <span class="h2-blob h2-blob--a" aria-hidden="true"></span><span class="h2-blob h2-blob--b" aria-hidden="true"></span>
            <div class="row g-5 align-items-center position-relative">
                <div class="col-lg-6">
                    <span class="h2-eyebrow h2-eyebrow--gold">Why Progix</span>
                    <h2 class="h2-h-light">Strategy, creativity &amp; technology — <em>working as one.</em></h2>
                    <p class="h2-p-light">Over a decade of turning ideas into measurable results for businesses of every size. No cookie-cutter templates — every plan is shaped around your goals.</p>
                    <div class="h2-stats">
                        @foreach ($site['stats'] as $st)
                            <div><strong><span data-count="{{ $st['value'] }}">{{ number_format($st['value']) }}</span>{{ $st['suffix'] }}</strong><span>{{ $st['label'] }}</span></div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="h2-blobimg">
                        <img src="{{ $img('hero-marketing') }}" srcset="{{ $img('hero-marketing', true) }} 1080w, {{ $img('hero-marketing') }} 1880w" sizes="(min-width: 992px) 45vw, 90vw" width="1880" height="1253" alt="Progix team collaborating" loading="lazy" decoding="async">
                        <div class="h2-float h2-float--a"><x-icon name="shield-check" :size="18" /> Transparent communication</div>
                        <div class="h2-float h2-float--b"><x-icon name="zap" :size="18" /> Scope &amp; price in 24h</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="h2-why" data-stagger>
            @foreach ($site['why'] as $w)
                <div class="h2-why-item" data-reveal-item><span><x-icon :name="$w['icon']" :size="22" /></span><div><h3>{{ $w['title'] }}</h3><p>{{ $w['text'] }}</p></div></div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== PROCESS ============================== --}}
<section class="h2-section h2-section--soft" id="process">
    <div class="h2-soft-wave h2-soft-wave--top" aria-hidden="true"><svg viewBox="0 0 1440 100" preserveAspectRatio="none"><path d="M0,0 L1440,0 L1440,46 C1250,96 1020,92 780,48 C540,6 260,2 0,58 Z"/></svg></div>
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="h2-sticky">
                    <span class="h2-eyebrow">How we work</span>
                    <h2 class="h2-h">From first hello to <em>measurable growth.</em></h2>
                    <p>A simple, transparent five-step process — you always know what happens next.</p>
                    <button type="button" class="h2-btn h2-btn--ink" data-book>Start with a free call <span class="h2-btn-arrow"><x-icon name="arrow-right" :size="16" /></span></button>
                </div>
            </div>
            <div class="col-lg-8">
                <ol class="h2-steps" data-stagger>
                    @foreach ($site['process'] as $i => $st)
                        <li data-reveal-item>
                            <span class="h2-step-n">0{{ $i + 1 }}</span>
                            <div><h3><x-icon :name="$st['icon']" :size="22" /> {{ $st['title'] }}</h3><p>{{ $st['text'] }}</p></div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
    <div class="h2-soft-wave h2-soft-wave--bottom" aria-hidden="true"><svg viewBox="0 0 1440 100" preserveAspectRatio="none"><path d="M0,100 L1440,100 L1440,52 C1200,2 960,8 720,48 C480,90 240,98 0,44 Z"/></svg></div>
</section>

{{-- ============================== SHOWREEL ============================== --}}
<section class="h2-section h2-section--tight">
    <div class="container">
        <div class="h2-reel" data-reveal="scale" data-reel>
            <video muted loop playsinline preload="none" poster="{{ $img('loop-poster') }}" aria-hidden="true" tabindex="-1" data-video>
                <source src="{{ asset('assets/video/office-loop.mp4') }}" type="video/mp4">
            </video>
            <div class="h2-reel-tint"></div>
            <div class="h2-reel-copy">
                <span class="h2-chip"><x-icon name="sparkles" :size="16" /> Behind the scenes</span>
                <h2>Real people. Real craft. <em>Real results.</em></h2>
                <p>Every project is handled by a dedicated team that cares about your outcome as much as you do.</p>
                <a href="{{ route('about') }}" class="h2-btn h2-btn--glass">Meet the team <span class="h2-btn-arrow"><x-icon name="arrow-right" :size="16" /></span></a>
            </div>
        </div>
    </div>
</section>

{{-- ============================== PACKAGES ============================== --}}
<section class="h2-section" id="packages">
    <div class="container">
        <div class="h2-head" data-reveal>
            <span class="h2-eyebrow">Popular packages</span>
            <h2>Simple pricing. <em>Serious results.</em></h2>
            <p>Our most-chosen plans — see every package and add-on on the pricing page.</p>
        </div>
        <div class="h2-packs" data-stagger>
            @foreach ($picks as $k => $pk)
                @php $g = $site['pricing'][$pk['group']]; $plan = $g['plans'][$pk['plan']]; @endphp
                <article class="h2-pack h2-pack--{{ $k }}" data-reveal-item>
                    <span class="h2-pack-tag">{{ $g['label'] }}</span>
                    <h3>{{ $plan['name'] }}</h3>
                    <p class="h2-pack-for">{{ $plan['for'] }}</p>
                    <div class="h2-pack-price"><span>$</span>{{ number_format($plan['price']) }}<small>{{ $plan['per'] }}</small></div>
                    <ul>@foreach (array_slice($plan['features'], 0, 5) as $f)<li><x-icon name="check" :size="16" /> {{ $f }}</li>@endforeach</ul>
                    <button type="button" class="h2-btn h2-btn--ink w-100" data-book data-package="{{ $plan['name'] }} — {{ $g['label'] }}" data-service="{{ collect($site['services'])->firstWhere('pricing_tab', $pk['group'])['title'] ?? '' }}">Get started <span class="h2-btn-arrow"><x-icon name="arrow-right" :size="16" /></span></button>
                </article>
            @endforeach
        </div>
        <div class="text-center" style="margin-top:36px" data-reveal><a href="{{ route('pricing') }}" class="h2-link">See all pricing &amp; add-ons <x-icon name="arrow-right" :size="18" /></a></div>
    </div>
</section>

{{-- ============================== REVIEWS (dark) ============================== --}}
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

{{-- ============================== FOUNDER ============================== --}}
<section class="h2-section">
    <div class="container">
        <div class="h2-founder" data-reveal="scale">
            <div class="h2-founder-photo">
                <span class="h2-blob h2-blob--c" aria-hidden="true"></span>
                <img src="{{ asset('assets/img/brand/founder.webp') }}?v=3" width="1218" height="1288" alt="{{ $site['founder']['name'] }}, founder of Progix Digital" loading="lazy" decoding="async">
            </div>
            <div class="h2-founder-copy">
                <span class="h2-eyebrow">Meet the founder</span>
                <h2 class="h2-h">{{ $site['founder']['name'] }}</h2>
                <p class="h2-quote">“{{ $site['founder']['bio'] }}”</p>
                <p>{{ $site['founder']['bio_long'] }}</p>
                <div class="h2-founder-stats">
                    <div><strong>{{ $u['success'] }}</strong><span>Job success</span></div>
                    <div><strong>{{ $u['earnings'] }}</strong><span>Earned</span></div>
                    <div><strong>{{ $u['jobs'] }}</strong><span>Jobs</span></div>
                    <div><strong>{{ $u['hours'] }}</strong><span>Hours</span></div>
                </div>
                <button type="button" class="h2-btn h2-btn--ink" data-book>Book a Free Consultation <span class="h2-btn-arrow"><x-icon name="arrow-right" :size="16" /></span></button>
            </div>
        </div>
    </div>
</section>

{{-- ============================== FAQ + INSIGHTS ============================== --}}
<section class="h2-section h2-section--soft" id="faq">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="h2-sticky">
                    <span class="h2-eyebrow">FAQ</span>
                    <h2 class="h2-h">Questions? <em>Answered.</em></h2>
                    <p>Can’t find what you’re looking for? Message us on WhatsApp — we reply fast.</p>
                    <a href="{{ $wa }}" target="_blank" rel="noopener" class="h2-btn h2-btn--wa"><x-icon name="whatsapp" :size="18" /> Ask on WhatsApp</a>
                </div>
            </div>
            <div class="col-lg-8">@include('partials.faq', ['items' => $site['faqs'], 'uid' => 'h2Faq'])</div>
        </div>
    </div>
</section>

<section class="h2-section">
    <div class="container">
        <div class="h2-head h2-head--row" data-reveal>
            <div><span class="h2-eyebrow">Insights</span><h2>Fresh ideas for <em>growing online.</em></h2></div>
            <a href="{{ route('blog') }}" class="h2-link">All articles <x-icon name="arrow-right" :size="18" /></a>
        </div>
        <div class="row g-4" data-stagger>
            @foreach ($posts as $post)<div class="col-md-6 col-lg-4">@include('partials.post-card', ['post' => $post])</div>@endforeach
        </div>
    </div>
</section>
@endsection
