@extends('layouts.app')

@section('body_class', 'home3')

@push('head')
    <link rel="preload" as="image" href="{{ asset('assets/img/home2/meeting-m.webp') }}" imagesrcset="{{ asset('assets/img/home2/meeting-m.webp') }} 1080w, {{ asset('assets/img/home2/meeting.webp') }} 1880w" imagesizes="(min-width: 992px) 46vw, 100vw" fetchpriority="high">
    <link rel="stylesheet" href="{{ asset('assets/css/home3.css') }}?v={{ @filemtime(public_path('assets/css/home3.css')) }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/home3.js') }}?v={{ @filemtime(public_path('assets/js/home3.js')) }}" defer></script>
@endpush

@php
    $c = $site['contact']; $u = $site['upwork'];
    $tel = preg_replace('/[^\d+]/', '', $c['phone_pk']);
    $img = fn ($n, $m = false) => asset('assets/img/home2/'.$n.($m ? '-m' : '').'.webp');
    $svc = collect($site['services'])->keyBy('slug');
    $goals = [
        ['id' => 'customers', 'icon' => 'trending-up', 'label' => 'Get more customers', 'slug' => 'social-media-marketing', 'also' => 'paid-advertising', 'tab' => 'social'],
        ['id' => 'website', 'icon' => 'code', 'label' => 'Launch a website', 'slug' => 'web-development', 'also' => 'website-content-seo', 'tab' => 'web'],
        ['id' => 'automate', 'icon' => 'bot', 'label' => 'Automate support & sales', 'slug' => 'ai-automation', 'also' => null, 'tab' => 'ai'],
        ['id' => 'brand', 'icon' => 'palette', 'label' => 'Look more professional', 'slug' => 'creative-branding', 'also' => 'website-content-seo', 'tab' => 'social'],
    ];
    $rows = [
        ['cat' => 'marketing', 'g' => 'social', 'p' => 1, 'tag' => 'Most popular'],
        ['cat' => 'marketing', 'g' => 'ads', 'p' => 0, 'tag' => null],
        ['cat' => 'web', 'g' => 'web', 'p' => 0, 'tag' => 'Fast delivery'],
        ['cat' => 'web', 'g' => 'web', 'p' => 1, 'tag' => 'Best for small business'],
        ['cat' => 'ai', 'g' => 'ai', 'p' => 1, 'tag' => 'Great value'],
        ['cat' => 'marketing', 'g' => 'content', 'p' => 1, 'tag' => null],
    ];
    $faqs = array_slice($site['faqs'], 0, 6);
@endphp

@section('content')
{{-- ================================ HERO ================================ --}}
<section class="h3-hero" id="top">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 h3-hero-copy">
                <h1 class="h3-pill" data-hero-item><span class="h3-dot"></span> Digital marketing, web development &amp; AI automation agency</h1>
                <p class="h3-h1" data-hero-item>Grow your business online <span class="h3-mark">without the guesswork.</span></p>
                <p class="h3-lead" data-hero-item>One friendly expert team for social media, ads, websites and AI automation — with a clear plan and fixed price in 24 hours.</p>

                {{-- Quick request: fastest way to get in touch --}}
                <form class="h3-qf" data-booking-form data-hero-item novalidate aria-label="Quick quote request">
                    <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" class="h3-trap">
                    <input type="hidden" name="email" value=""><input type="hidden" name="package" value=""><input type="hidden" name="time" value="Anytime"><input type="hidden" name="message" value="Quick request from the homepage.">
                    <div class="h3-qf-fields">
                        <p class="h3-qf-title">Get a free quote in 24 hours</p>
                        <div class="h3-qf-grid">
                            <label class="h3-fld"><span>Your name</span><input class="in-h3" type="text" id="h3q-name" name="name" autocomplete="name" placeholder="Full name" required></label>
                            <label class="h3-fld"><span>WhatsApp / phone</span><input class="in-h3" type="tel" id="h3q-phone" name="phone" autocomplete="tel" placeholder="+1 555 000 0000" required></label>
                            <label class="h3-fld h3-fld--full"><span>What do you need?</span>
                                <select class="in-h3" name="service">
                                    <option value="">Not sure yet — help me choose</option>
                                    @foreach ($site['services'] as $s)<option value="{{ $s['title'] }}">{{ $s['title'] }}</option>@endforeach
                                </select></label>
                        </div>
                        <button type="submit" class="h3-btn h3-btn--primary h3-btn--block"><x-icon name="whatsapp" :size="20" /> Get my free quote</button>
                        <p class="h3-qf-note"><x-icon name="shield-check" :size="15" /> No spam, no obligation. We reply on WhatsApp.</p>
                    </div>
                    <div class="booking-success h3-qf-done" hidden>
                        <div class="success-ico"><x-icon name="check" :size="26" /></div>
                        <h3>Thanks — we’ve got it!</h3>
                        <p>WhatsApp should have opened with your details. Press <strong>Send</strong> there and we’ll reply within 24 hours.</p>
                        <div class="success-actions">
                            <a class="h3-btn h3-btn--wa" data-success-wa href="{{ $wa }}" target="_blank" rel="noopener"><x-icon name="whatsapp" :size="18" /> Open WhatsApp</a>
                            <a class="h3-btn h3-btn--ghost" data-success-mail href="mailto:{{ $c['email'] }}"><x-icon name="mail" :size="18" /> Email instead</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-6">
                <div class="h3-visual" data-hero-item>
                    <span class="h3-blob" aria-hidden="true"></span>
                    <div class="h3-arch">
                        <img src="{{ $img('meeting') }}" srcset="{{ $img('meeting', true) }} 1080w, {{ $img('meeting') }} 1880w" sizes="(min-width: 992px) 46vw, 100vw" width="1880" height="1253" alt="Progix team planning a project with a client" fetchpriority="high" decoding="async">
                    </div>
                    <div class="h3-badge h3-badge--rate">
                        <span class="stars" aria-hidden="true"><x-icon name="star" :size="15" /><x-icon name="star" :size="15" /><x-icon name="star" :size="15" /><x-icon name="star" :size="15" /><x-icon name="star" :size="15" /></span>
                        <strong>{{ $u['rating'] }} · {{ $u['badge'] }}</strong><small>on Upwork · {{ $u['success'] }} job success</small>
                    </div>
                    <div class="h3-badge h3-badge--fast"><x-icon name="clock" :size="18" /><span><strong>24h</strong> scope &amp; price</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================== TRUST ============================== --}}
<section class="h3-trust" aria-labelledby="trustTitle">
    <div class="container">
        <div class="h3-trust-panel" data-reveal>
            <div class="h3-trust-nums">
                <div><strong>10+</strong><span>years experience</span></div>
                <div><strong>1,200+</strong><span>projects delivered</span></div>
                <div><strong>37+</strong><span>industries served</span></div>
            </div>
            <div class="h3-trust-logos">
                <p id="trustTitle">Trusted by brands like</p>
                <ul>
                    @foreach ($site['clients'] as $cl)
                        <li><img src="{{ asset('assets/img/clients/'.$cl['file'].'.webp') }}" width="{{ $cl['w'] }}" height="{{ $cl['h'] }}" style="--ar:{{ round($cl['w'] / $cl['h'], 2) }}" alt="{{ $cl['name'] }}" loading="lazy" decoding="async"></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ============================== SERVICE FINDER ============================== --}}
<section class="h3-section" id="finder">
    <div class="container">
        <div class="h3-head" data-reveal>
            <span class="h3-label">Start here</span>
            <h2 class="h3-h2">What would you like to <span class="h3-mark">achieve?</span></h2>
            <p>Pick a goal and we’ll show you the simplest way to get there.</p>
        </div>

        <div class="h3-finder" data-finder data-reveal>
            <div class="h3-goals" role="tablist" aria-label="Choose your goal">
                @foreach ($goals as $i => $g)
                    <button type="button" role="tab" id="goal-{{ $g['id'] }}" class="h3-goal {{ $i === 0 ? 'is-on' : '' }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}" aria-controls="gp-{{ $g['id'] }}" tabindex="{{ $i === 0 ? 0 : -1 }}" data-goal="{{ $g['id'] }}">
                        <span class="h3-goal-ico"><x-icon :name="$g['icon']" :size="22" /></span>
                        <span>{{ $g['label'] }}</span>
                    </button>
                @endforeach
            </div>

            <div class="h3-goal-panels">
                @foreach ($goals as $i => $g)
                    @php $s = $svc[$g['slug']]; $also = $g['also'] ? $svc[$g['also']] : null; @endphp
                    <div class="h3-gp {{ $i === 0 ? 'is-on' : '' }}" role="tabpanel" id="gp-{{ $g['id'] }}" aria-labelledby="goal-{{ $g['id'] }}" @if($i) hidden @endif>
                        <div class="h3-gp-copy">
                            <span class="h3-label h3-label--sm">We recommend</span>
                            <h3>{{ $s['title'] }}</h3>
                            <p>{{ $s['lead'] }}</p>
                            <ul>@foreach (array_slice($s['includes'], 0, 4) as $inc)<li><x-icon name="check" :size="16" /> {{ $inc }}</li>@endforeach</ul>
                            <div class="h3-gp-cta">
                                <button type="button" class="h3-btn h3-btn--primary" data-book data-service="{{ $s['title'] }}">Book a free call <x-icon name="arrow-right" :size="16" /></button>
                                <a class="h3-btn h3-btn--ghost" href="{{ route('service', $s['slug']) }}">Learn more</a>
                            </div>
                        </div>
                        <div class="h3-gp-side">
                            <div class="h3-price-card">
                                <span>Starting from</span>
                                <strong><sup>$</sup>{{ $s['from'] }}</strong> <small class="from-unit">{{ $s['from_unit'] ?? '' }}</small>@if (! empty($s['from_alt'])) <small class="from-alt">{{ $s['from_alt'] }}</small>@endif
                                <small>Transparent pricing · no hidden fees</small>
                                <a href="{{ route('pricing') }}#{{ $g['tab'] }}" class="h3-link">See packages <x-icon name="arrow-right" :size="16" /></a>
                            </div>
                            @if ($also)<a class="h3-also" href="{{ route('service', $also['slug']) }}"><x-icon :name="$also['icon']" :size="18" /> <span>Pairs well with <strong>{{ $also['title'] }}</strong></span><x-icon name="chevron-right" :size="16" /></a>@endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ============================== SERVICES BENTO ============================== --}}
<section class="h3-section h3-section--sage" id="services">
    <div class="container">
        <div class="h3-head h3-head--row" data-reveal>
            <div><span class="h3-label">Our services</span><h2 class="h3-h2">Everything you need, <span class="h3-mark">under one roof.</span></h2></div>
            <a href="{{ route('services') }}" class="h3-link h3-link--lg">View all services <x-icon name="arrow-right" :size="18" /></a>
        </div>

        <div class="h3-bento" data-stagger>
            @foreach ($site['services'] as $i => $s)
                @php $big = in_array($i, [0, 3]); $photo = $i === 0 ? 'team' : ($i === 3 ? 'code' : null); @endphp
                <a href="{{ route('service', $s['slug']) }}" class="h3-tile h3-tile--{{ $i + 1 }} {{ $big ? 'h3-tile--img' : '' }}" data-reveal-item>
                    @if ($photo)<img class="h3-tile-img" src="{{ $img($photo, true) }}" srcset="{{ $img($photo, true) }} 1080w, {{ $img($photo) }} 1880w" sizes="(min-width: 992px) 40vw, 90vw" width="1880" height="1253" alt="" loading="lazy" decoding="async">@endif
                    <span class="h3-tile-body">
                        <span class="h3-tile-ico"><x-icon :name="$s['icon']" :size="24" /></span>
                        <span class="h3-tile-tag">{{ $s['pillar'] }}</span>
                        <strong>{{ $s['title'] }}</strong>
                        <span class="h3-tile-text">{{ $s['short'] }}</span>
                        <span class="h3-tile-foot"><span>from <b>${{ $s['from'] }}</b> <small class="from-unit">{{ $s['from_unit'] ?? '' }}</small>@if (! empty($s['from_alt'])) <small class="from-alt">{{ $s['from_alt'] }}</small>@endif</span><span class="h3-tile-go"><x-icon name="arrow-up-right" :size="18" /></span></span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== HOW IT WORKS ============================== --}}
<section class="h3-section" id="how">
    <div class="container">
        <div class="h3-head" data-reveal>
            <span class="h3-label">How it works</span>
            <h2 class="h3-h2">Three simple steps. <span class="h3-mark">Zero confusion.</span></h2>
        </div>
        <ol class="h3-steps" data-stagger>
            @foreach ([
                ['message-circle', 'Tell us your goal', 'Share what you need in a 1-minute form or a quick WhatsApp chat — no jargon, no pressure.'],
                ['file-text', 'Get a clear plan & price', 'Within 24 hours you receive a simple scope, timeline and fixed price for your project.'],
                ['rocket', 'We build, you grow', 'Our team delivers, keeps you updated, and reports results in plain English every month.'],
            ] as $k => [$ico, $t, $d])
                <li data-reveal-item><span class="h3-step-n">{{ $k + 1 }}</span><span class="h3-step-ico"><x-icon :name="$ico" :size="26" /></span><h3>{{ $t }}</h3><p>{{ $d }}</p></li>
            @endforeach
        </ol>
        <div class="h3-center" data-reveal><button type="button" class="h3-btn h3-btn--primary h3-btn--lg" data-book>Start with a free consultation <x-icon name="arrow-right" :size="18" /></button></div>
    </div>
</section>

{{-- ============================== PRICING (plan list) ============================== --}}
<section class="h3-section h3-section--sand" id="pricing">
    <div class="container">
        <div class="h3-head h3-head--row" data-reveal>
            <div><span class="h3-label">Transparent pricing</span><h2 class="h3-h2">Popular plans, <span class="h3-mark">clearly priced.</span></h2></div>
            <div class="h3-chips" role="group" aria-label="Filter plans">
                @foreach (['all' => 'All', 'marketing' => 'Marketing', 'web' => 'Websites', 'ai' => 'AI'] as $k => $l)
                    <button type="button" class="h3-chip {{ $k === 'all' ? 'is-on' : '' }}" data-filter="{{ $k }}" aria-pressed="{{ $k === 'all' ? 'true' : 'false' }}">{{ $l }}</button>
                @endforeach
            </div>
        </div>

        <div class="h3-plans" data-stagger>
            @foreach ($rows as $r)
                @php $g = $site['pricing'][$r['g']]; $p = $g['plans'][$r['p']]; $svcTitle = collect($site['services'])->firstWhere('pricing_tab', $r['g'])['title'] ?? ''; @endphp
                <article class="h3-plan" data-cat="{{ $r['cat'] }}" data-reveal-item>
                    <div class="h3-plan-main">
                        <div class="h3-plan-head"><span class="h3-plan-cat">{{ $g['label'] }}</span>@if ($r['tag'])<span class="h3-plan-tag">{{ $r['tag'] }}</span>@endif</div>
                        <h3>{{ $p['name'] }}</h3>
                        <p>{{ $p['for'] }}</p>
                    </div>
                    <ul class="h3-plan-feat">@foreach (array_slice($p['features'], 0, 3) as $f)<li><x-icon name="check" :size="15" /> {{ $f }}</li>@endforeach</ul>
                    <div class="h3-plan-buy">
                        <div class="h3-plan-price"><sup>$</sup>{{ number_format($p['price']) }}<small>{{ $p['per'] }}</small></div>
                        <button type="button" class="h3-btn h3-btn--ink h3-btn--sm" data-book data-package="{{ $p['name'] }} — {{ $g['label'] }}" data-service="{{ $svcTitle }}">Get started</button>
                    </div>
                </article>
            @endforeach
        </div>
        <p class="h3-fine" data-reveal>Ad spend, hosting and domains are billed separately. <a href="{{ route('pricing') }}" class="h3-link">See every package &amp; add-on <x-icon name="arrow-right" :size="15" /></a></p>
    </div>
</section>

{{-- ============================== RESULTS ============================== --}}
<section class="h3-section" id="results">
    <div class="container">
        <div class="h3-head h3-head--row" data-reveal>
            <div><span class="h3-label">Results</span><h2 class="h3-h2">Growth you can <span class="h3-mark">actually measure.</span></h2></div>
            <a href="{{ route('testimonials') }}#case-studies" class="h3-link h3-link--lg">All case studies <x-icon name="arrow-right" :size="18" /></a>
        </div>
        @php $cs = $site['projects']; @endphp
        <div class="h3-cases" data-stagger>
            <article class="h3-case h3-case--lead" data-reveal-item>
                <img src="{{ $img('team', true) }}" srcset="{{ $img('team', true) }} 1080w, {{ $img('team') }} 1880w" sizes="(min-width: 992px) 50vw, 90vw" width="1880" height="1253" alt="{{ $cs[0]['title'] }}" loading="lazy" decoding="async">
                <div class="h3-case-body">
                    <span class="h3-plan-cat">{{ $cs[0]['category'] }}</span>
                    <h3>{{ $cs[0]['title'] }}</h3>
                    <p>{{ $cs[0]['summary'] }}</p>
                    <dl>@foreach ($cs[0]['results'] as [$n, $l])<div><dt>{{ $n }}</dt><dd>{{ $l }}</dd></div>@endforeach</dl>
                </div>
            </article>
            @foreach (array_slice($cs, 1, 2) as $p)
                <article class="h3-case h3-case--sm" data-reveal-item>
                    <div class="h3-case-body">
                        <span class="h3-plan-cat">{{ $p['category'] }} @if ($site['draft_mode'] && $p['sample'])<em class="h3-sample">Sample</em>@endif</span>
                        <h3>{{ $p['title'] }}</h3>
                        <p>{{ $p['summary'] }}</p>
                        <dl>@foreach ($p['results'] as [$n, $l])<div><dt>{{ $n }}</dt><dd>{{ $l }}</dd></div>@endforeach</dl>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== REVIEWS ============================== --}}
<section class="h3-section h3-section--sage" id="reviews">
    <div class="container">
        <div class="h3-head" data-reveal>
            <span class="h3-label">Client reviews</span>
            <h2 class="h3-h2">Loved by clients, <span class="h3-mark">verified on Upwork.</span></h2>
        </div>
        <div class="h3-reviews" data-stagger>
            <aside class="h3-score" data-reveal-item>
                <strong>{{ $u['rating'] }}</strong>
                <span class="stars" role="img" aria-label="5 out of 5 stars"><x-icon name="star" :size="20" /><x-icon name="star" :size="20" /><x-icon name="star" :size="20" /><x-icon name="star" :size="20" /><x-icon name="star" :size="20" /></span>
                <p>{{ $u['badge'] }} · {{ $u['success'] }} job success</p>
                <ul><li><b>{{ $u['jobs'] }}</b> jobs</li><li><b>{{ $u['hours'] }}</b> hours</li><li><b>{{ $u['earnings'] }}</b> earned</li></ul>
                <a href="{{ route('testimonials') }}" class="h3-link">Read all reviews <x-icon name="arrow-right" :size="16" /></a>
            </aside>
            @foreach (array_slice($site['testimonials'], 0, 3) as $t)
                <figure class="h3-quote" data-reveal-item>
                    <x-icon name="quote" :size="26" class="h3-quote-ico" />
                    <blockquote><p>{{ \Illuminate\Support\Str::limit($t['quote'], 230) }}</p></blockquote>
                    <figcaption><span class="h3-av" aria-hidden="true"><x-icon name="users" :size="16" /></span><span><strong>Verified Upwork client</strong><small>{{ $t['project'] }}</small></span></figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== FOUNDER ============================== --}}
<section class="h3-section h3-section--tight">
    <div class="container">
        <div class="h3-founder" data-reveal>
            <img src="{{ asset('assets/img/brand/founder.webp') }}?v=3" width="1218" height="1288" alt="{{ $site['founder']['name'] }}, founder" loading="lazy" decoding="async">
            <div>
                <span class="h3-label h3-label--sm">A word from the founder</span>
                <p class="h3-founder-q">“{{ $site['founder']['bio'] }}”</p>
                <p class="h3-founder-n"><strong>{{ $site['founder']['name'] }}</strong> · {{ $site['founder']['role'] }}, {{ $site['name'] }}</p>
                <a href="{{ route('about') }}" class="h3-link">About Progix Digital <x-icon name="arrow-right" :size="16" /></a>
            </div>
        </div>
    </div>
</section>

{{-- ============================== FAQ + INSIGHTS ============================== --}}
<section class="h3-section" id="faq">
    <div class="container">
        <div class="h3-head" data-reveal>
            <span class="h3-label">FAQ</span>
            <h2 class="h3-h2">Quick answers to <span class="h3-mark">common questions.</span></h2>
        </div>
        <div class="h3-faq" data-stagger>
            @foreach ($faqs as $f)
                <details class="h3-qa" data-reveal-item @if($loop->first) open @endif>
                    <summary>{{ $f[0] }}<span class="h3-qa-i"><x-icon name="plus" :size="18" /></span></summary>
                    <p>{{ $f[1] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

<section class="h3-section h3-section--tight">
    <div class="container">
        <div class="h3-head h3-head--row" data-reveal>
            <div><span class="h3-label">Insights</span><h2 class="h3-h2">Fresh ideas for <span class="h3-mark">your business.</span></h2></div>
            <a href="{{ route('blog') }}" class="h3-link h3-link--lg">All articles <x-icon name="arrow-right" :size="18" /></a>
        </div>
        <div class="h3-posts" data-stagger>
            @foreach ($posts as $post)
                <a href="{{ route('post', $post->slug) }}" class="h3-post" data-reveal-item>
                    <img src="{{ $post->cover_url ?: asset('assets/img/brand/og-image.jpg') }}" width="940" height="627" alt="" loading="lazy" decoding="async">
                    <span><small>{{ $post->category }} · {{ $post->read_minutes }} min read</small><strong>{{ $post->title }}</strong></span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== CONTACT ============================== --}}
<section class="h3-section h3-section--contact" id="contact">
    <div class="container">
        <div class="h3-contact" data-reveal>
            <div class="h3-contact-copy">
                <span class="h3-label h3-label--light">Let’s talk</span>
                <h2 class="h3-h2 h3-h2--light">Ready to grow? <span class="h3-mark h3-mark--dark">Tell us about your project.</span></h2>
                <p>Choose whichever way is easiest — we reply fast and always with a clear plan.</p>
                <ul class="h3-channels">
                    <li><a href="{{ $wa }}?text={{ rawurlencode('Hi Progix Digital, I would like to talk about a project.') }}" target="_blank" rel="noopener"><span class="h3-ch-ico h3-ch-ico--wa"><x-icon name="whatsapp" :size="22" /></span><span><strong>WhatsApp</strong><small>Fastest — usually within the hour</small></span><x-icon name="arrow-up-right" :size="18" /></a></li>
                    <li><a href="tel:{{ $tel }}"><span class="h3-ch-ico"><x-icon name="phone" :size="22" /></span><span><strong>{{ $c['phone_pk'] }}</strong><small>{{ $c['hours'] }}</small></span><x-icon name="arrow-up-right" :size="18" /></a></li>
                    <li><a href="mailto:{{ $c['email'] }}"><span class="h3-ch-ico"><x-icon name="mail" :size="22" /></span><span><strong>{{ $c['email'] }}</strong><small>We reply within 24 hours</small></span><x-icon name="arrow-up-right" :size="18" /></a></li>
                </ul>
            </div>
            <div class="h3-contact-form">
                <h3>Book a free consultation</h3>
                @include('partials.booking-form', ['fid' => 'h3'])
            </div>
        </div>
    </div>
</section>

{{-- Mobile contact bar (appears after the hero) --}}
<nav class="h3-bar" aria-label="Quick contact">
    <a href="tel:{{ $tel }}" class="h3-bar-a"><x-icon name="phone" :size="20" /><span>Call</span></a>
    <a href="{{ $wa }}" target="_blank" rel="noopener" class="h3-bar-a h3-bar-a--wa"><x-icon name="whatsapp" :size="20" /><span>WhatsApp</span></a>
    <button type="button" class="h3-bar-a h3-bar-a--main" data-book><x-icon name="calendar" :size="20" /><span>Book free call</span></button>
</nav>
@endsection
