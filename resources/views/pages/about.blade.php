@extends('layouts.app')

@section('content')
@php $u = $site['upwork']; @endphp
@include('partials.page-hero', [
    'eyebrow' => 'About Progix Digital',
    'title' => 'Where creativity meets <span class="accent">technology</span>',
    'lead' => 'We are a digital solutions company helping businesses navigate the evolving digital landscape — from strategic social media and performance marketing to custom websites and AI-powered automation.',
])

<section class="section pt-0">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-reveal="left">
                <div class="pillar-media">
                    <img src="{{ asset('assets/img/stock/team.webp') }}" width="940" height="609" alt="The Progix Digital team collaborating around a table" loading="lazy" decoding="async">
                    <div class="float-chip float-chip--a"><x-icon name="users" :size="16" /> One team, every service</div>
                    <div class="float-chip float-chip--b"><x-icon name="award" :size="16" /> 10+ years of experience</div>
                </div>
            </div>
            <div class="col-lg-6" data-reveal="right">
                <span class="eyebrow">Our story</span>
                <h2 class="h-section">We bring creativity and technology together</h2>
                <p class="prose">Progix Digital was built on a simple belief: businesses grow faster when strategy, creativity and technology work as one team instead of three separate vendors.</p>
                <p class="prose">We bring creativity and technology together to help businesses build, grow, and operate more efficiently. Today our team handles everything from content and campaigns to code and AI — for startups, local businesses and global brands alike.</p>
                <ul class="check-list">
                    <li><x-icon name="check" :size="18" /> Transparent communication, always</li>
                    <li><x-icon name="check" :size="18" /> Focused on measurable outcomes</li>
                    <li><x-icon name="check" :size="18" /> Tailored solutions — never cookie-cutter</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="section section--tint">
    <div class="container">
        <div class="row g-4 mv-grid" data-stagger>
            <div class="col-lg-6" data-reveal-item>
                <div class="mv-card">
                    <span class="mv-ico"><x-icon name="target" :size="26" /></span>
                    <h3>Our mission</h3>
                    <p>{{ $site['mission'] }}</p>
                </div>
            </div>
            <div class="col-lg-6" data-reveal-item>
                <div class="mv-card mv-card--gold">
                    <span class="mv-ico"><x-icon name="rocket" :size="26" /></span>
                    <h3>Our vision</h3>
                    <p>{{ $site['vision'] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        @include('partials.section-head', [
            'eyebrow' => 'Core values',
            'title' => 'What we <span class="accent">stand for</span>',
            'lead' => 'The principles behind every project, every message and every deliverable.',
        ])
        <div class="values" data-stagger>
            @foreach ($site['values'] as $v)
                <div class="value" data-reveal-item>
                    <span class="value-ico"><x-icon :name="$v['icon']" :size="24" /></span>
                    <h3>{{ $v['title'] }}</h3>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section section--tint founder">
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
                    <span class="eyebrow">Founder</span>
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
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                @include('partials.section-head', [
                    'eyebrow' => 'By the numbers',
                    'title' => 'Proof in <span class="accent">performance</span>',
                    'align' => 'left',
                ])
            </div>
            <div class="col-lg-7">@include('partials.stats')</div>
        </div>
    </div>
</section>

<section class="logos logos--bottom">
    <div class="container"><p class="logos-title" data-reveal>Companies we've worked with</p></div>
    @include('partials.clients-marquee')
</section>
@endsection
