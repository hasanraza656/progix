@extends('layouts.app')

@section('content')
@php $u = $site['upwork']; @endphp

{{-- ============================== HERO ============================== --}}
<section class="hero" id="top">
    <div class="hero-dots" data-dots aria-hidden="true"></div>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 hero-copy">
                <span class="pill" data-hero-item>
                    <span class="pill-dot"></span> Marketing · Technology · Automation
                </span>
                <h1 class="h-display">
                    <span class="line" data-hero-line><span class="line-in">We <em class="accent">Build.</em></span></span>
                    <span class="line" data-hero-line><span class="line-in">We <em class="accent">Grow.</em></span></span>
                    <span class="line" data-hero-line><span class="line-in">We <em class="accent accent--gold">Automate.</em></span></span>
                </h1>
                <p class="lead-text" data-hero-item>
                    Helping businesses build a powerful digital presence through strategic marketing, custom web development and intelligent automation — all from one trusted team.
                </p>
                <div class="hero-actions" data-hero-item>
                    <button type="button" class="btn-p btn-p--ink btn-p--lg" data-book>
                        Book a Free Consultation <span class="btn-arrow"><x-icon name="arrow-right" :size="18" /></span>
                    </button>
                    <a href="{{ route('pricing') }}" class="btn-p btn-p--line btn-p--lg">View packages</a>
                </div>
                <p class="hero-offer" data-hero-item>
                    <x-icon name="zap" :size="16" /> <span>Send a project and get a scope &amp; price within <strong>24 hours</strong>.</span>
                </p>

                <ul class="hero-trust" data-hero-item>
                    <li>
                        <span class="stars" aria-hidden="true"><x-icon name="star" :size="15" /><x-icon name="star" :size="15" /><x-icon name="star" :size="15" /><x-icon name="star" :size="15" /><x-icon name="star" :size="15" /></span>
                        <span><strong>{{ $u['rating'] }}</strong> on Upwork</span>
                    </li>
                    <li><strong>1,200+</strong> projects</li>
                    <li><strong>10+</strong> years</li>
                </ul>
            </div>

            {{-- Illustrative product-UI composition (pure HTML/CSS — no images to download) --}}
            <div class="col-lg-6">
                <div class="stage" aria-hidden="true" data-stage>
                    <div class="stage-ring"></div>

                    <div class="browser" data-float="6">
                        <div class="browser-bar"><i></i><i></i><i></i><span>yourbusiness.com</span></div>
                        <div class="browser-body">
                            <div class="b-nav"><img src="{{ asset('assets/img/brand/mark.png') }}" width="245" height="309" alt=""><b></b><b></b><b></b><s></s></div>
                            <div class="b-hero">
                                <div class="b-lines"><b class="w80"></b><b class="w60"></b><u></u><span class="b-btn">Get started</span></div>
                                <div class="b-art">
                                    <div class="mark-grid"><i></i><i></i><i></i><i></i><i class="off"></i><i class="off"></i><i></i><i></i><i></i><i></i><i class="off"></i><i class="off"></i><i></i><i class="off"></i><i class="off"></i><i class="g"></i></div>
                                </div>
                            </div>
                            <div class="b-cards"><b></b><b></b><b></b></div>
                        </div>
                    </div>

                    <div class="fc fc-social" data-float="9" data-depth="1.2">
                        <span class="fc-ico fc-ico--rose"><x-icon name="instagram" :size="18" /></span>
                        <div>
                            <strong>Post scheduled</strong>
                            <small>Instagram · Today, 6:00 PM</small>
                        </div>
                    </div>

                    <div class="fc fc-growth" data-float="7" data-depth="1.8">
                        <small>Audience growth</small>
                        <svg viewBox="0 0 120 44" width="120" height="44" fill="none">
                            <path class="spark" d="M2 38 C16 36 20 28 34 30 S52 18 64 20 S86 8 98 10 L118 3" stroke="#1AC27E" stroke-width="3" stroke-linecap="round"/>
                            <circle cx="118" cy="3" r="3.5" fill="#1AC27E"/>
                        </svg>
                        <span class="up"><x-icon name="trending-up" :size="14" /> Growing</span>
                    </div>

                    <div class="fc fc-chat" data-float="8" data-depth="2.2">
                        <div class="bubble bubble--bot"><x-icon name="bot" :size="14" /> Hi! Want a quote for your project?</div>
                        <div class="bubble bubble--me">Yes please 🙌</div>
                        <div class="typing"><i></i><i></i><i></i></div>
                    </div>

                    <div class="fc fc-lead" data-float="10" data-depth="1">
                        <span class="fc-ico fc-ico--green"><x-icon name="check" :size="16" /></span>
                        <div>
                            <strong>New lead</strong>
                            <small>Website enquiry · just now</small>
                        </div>
                    </div>

                    <div class="fc fc-rating" data-float="8" data-depth="1.5">
                        <span class="stars"><x-icon name="star" :size="13" /><x-icon name="star" :size="13" /><x-icon name="star" :size="13" /><x-icon name="star" :size="13" /><x-icon name="star" :size="13" /></span>
                        <strong>{{ $u['badge'] }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="#clients" class="scroll-cue" aria-label="Scroll to explore" data-hero-item><span></span></a>
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
                            <span>From <strong>${{ $s['from'] }}</strong></span>
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

{{-- ============================== PILLARS (alternating) ============================== --}}
<section class="section pillars">
    <div class="container">
        @include('partials.section-head', [
            'eyebrow' => 'What you get',
            'title' => 'Three ways we help you <span class="accent">move faster</span>',
            'lead' => 'Marketing to grow your brand. Technology to build digital products. Automation to work smarter.',
        ])

        {{-- Marketing --}}
        <div class="pillar row align-items-center g-5">
            <div class="col-lg-6 order-lg-1" data-reveal="left">
                <div class="pillar-media">
                    <img src="{{ asset('assets/img/stock/social.webp') }}" width="940" height="627" alt="Creator planning social media content on laptop and phone" loading="lazy" decoding="async">
                    <div class="float-chip float-chip--a"><x-icon name="calendar" :size="16" /> Content calendar ready</div>
                    <div class="float-chip float-chip--b"><x-icon name="bar-chart" :size="16" /> Monthly report</div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-2" data-reveal="right">
                <span class="pillar-tag"><x-icon name="megaphone" :size="16" /> Marketing</span>
                <h3>Grow your brand with content people actually enjoy</h3>
                <p>From strategy and daily content to paid campaigns and SEO copy, we build a steady stream of attention, enquiries and customers.</p>
                <ul class="check-list">
                    <li><x-icon name="check" :size="18" /> Social media management on up to 5 platforms</li>
                    <li><x-icon name="check" :size="18" /> Meta and Google Ads with proper tracking</li>
                    <li><x-icon name="check" :size="18" /> SEO-friendly website content &amp; keyword mapping</li>
                </ul>
                <a href="{{ route('service', 'social-media-marketing') }}" class="btn-p btn-p--line">Explore marketing <span class="btn-arrow"><x-icon name="arrow-right" :size="16" /></span></a>
            </div>
        </div>

        {{-- Technology --}}
        <div class="pillar row align-items-center g-5">
            <div class="col-lg-6 order-lg-2" data-reveal="right">
                <div class="pillar-media">
                    <img src="{{ asset('assets/img/stock/web.webp') }}" width="940" height="623" alt="Developer writing code for a custom website" loading="lazy" decoding="async">
                    <div class="float-chip float-chip--a"><x-icon name="zap" :size="16" /> Lightning fast</div>
                    <div class="float-chip float-chip--b"><x-icon name="globe" :size="16" /> Mobile-first design</div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-1" data-reveal="left">
                <span class="pillar-tag pillar-tag--gold"><x-icon name="code" :size="16" /> Technology</span>
                <h3>Websites &amp; apps built to look sharp and perform</h3>
                <p>Modern, responsive and SEO-ready — from a single landing page to a full custom platform, with care plans to keep everything running.</p>
                <ul class="check-list">
                    <li><x-icon name="check" :size="18" /> Landing pages from $129, business sites from $349</li>
                    <li><x-icon name="check" :size="18" /> Laravel, React, Next.js, WordPress, Shopify &amp; more</li>
                    <li><x-icon name="check" :size="18" /> Backups, updates and security with monthly care plans</li>
                </ul>
                <a href="{{ route('service', 'web-development') }}" class="btn-p btn-p--line">Explore web development <span class="btn-arrow"><x-icon name="arrow-right" :size="16" /></span></a>
            </div>
        </div>

        {{-- Automation --}}
        <div class="pillar row align-items-center g-5">
            <div class="col-lg-6 order-lg-1" data-reveal="left">
                <div class="pillar-media pillar-media--ui">
                    <div class="chat-mock">
                        <div class="chat-head"><span class="chat-av"><x-icon name="bot" :size="18" /></span><div><strong>Progix AI Assistant</strong><small><i></i> Online</small></div></div>
                        <div class="chat-body">
                            <div class="bubble bubble--bot">Hi! I can answer questions about pricing, timelines and services.</div>
                            <div class="bubble bubble--me">How fast can I get a website?</div>
                            <div class="bubble bubble--bot">Landing pages take 3–4 business days. Want me to book a free call? 📅</div>
                        </div>
                        <div class="chat-flow"><span><x-icon name="workflow" :size="14" /> Lead qualified</span><span>→</span><span>CRM updated</span><span>→</span><span>Follow-up sent</span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-2" data-reveal="right">
                <span class="pillar-tag"><x-icon name="bot" :size="16" /> Automation</span>
                <h3>Work smarter — let AI handle the repetitive parts</h3>
                <p>AI chatbots that answer customers around the clock and automated workflows that capture leads, update your CRM and follow up for you.</p>
                <ul class="check-list">
                    <li><x-icon name="check" :size="18" /> AI agents trained on your approved knowledge</li>
                    <li><x-icon name="check" :size="18" /> OpenAI, Gemini, n8n, Make &amp; LangChain</li>
                    <li><x-icon name="check" :size="18" /> Starting at just $99 for a website assistant</li>
                </ul>
                <a href="{{ route('service', 'ai-automation') }}" class="btn-p btn-p--line">Explore AI &amp; automation <span class="btn-arrow"><x-icon name="arrow-right" :size="16" /></span></a>
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
                        <div class="float-chip float-chip--a"><x-icon name="award" :size="16" /> {{ $u['badge'] }}</div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <span class="eyebrow">Meet our founder</span>
                    <h2 class="h-section">{{ $site['founder']['name'] }}</h2>
                    <p class="founder-role">{{ $site['founder']['role'] }}, Progix Digital</p>
                    <p class="lead-text">{{ $site['founder']['bio'] }}</p>
                    <p>{{ $site['founder']['bio_long'] }}</p>
                    <ul class="founder-stats">
                        <li><strong>{{ $u['success'] }}</strong><span>Job success</span></li>
                        <li><strong>{{ $u['earnings'] }}</strong><span>Earned on Upwork</span></li>
                        <li><strong>{{ $u['jobs'] }}</strong><span>Jobs delivered</span></li>
                        <li><strong>{{ $u['hours'] }}</strong><span>Hours worked</span></li>
                    </ul>
                    <button type="button" class="btn-p btn-p--ink btn-p--lg" data-book>Book a Free Consultation <span class="btn-arrow"><x-icon name="arrow-right" :size="18" /></span></button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================== REVIEWS ============================== --}}
<section class="section" id="reviews">
    <div class="container">
        @include('partials.section-head', [
            'eyebrow' => 'Client love',
            'title' => 'Don’t take our word for it — <span class="accent">listen to clients</span>',
            'lead' => 'Real feedback from real projects, straight from our Upwork profile.',
        ])
        <div data-reveal>@include('partials.testimonial-slider')</div>
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
            <div class="col-lg-4">
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
