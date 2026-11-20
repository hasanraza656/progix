@extends('layouts.app')

@section('content')
@php
    $tab = $service['pricing_tab'];
    $group = $site['pricing'][$tab];
    $isCreative = $service['slug'] === 'creative-branding';
    $addons = $isCreative
        ? array_values(array_filter($group['addons'], fn ($a) => in_array($a[0], ['Social media brand kit', 'Additional 4 static posts', 'Additional 4 carousel posts', 'Additional 4 reels (editing only)'])))
        : $group['addons'];
    $others = collect($site['services'])->where('slug', '!=', $service['slug'])->take(3);
@endphp

<section class="page-hero page-hero--service">
    <div class="hero-dots" data-dots aria-hidden="true"></div>
    <div class="container">
        <nav aria-label="Breadcrumb" class="crumbs" data-hero-item>
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('services') }}">Services</a></li>
                <li><span aria-current="page">{{ $service['title'] }}</span></li>
            </ol>
        </nav>
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="eyebrow" data-hero-item><x-icon :name="$service['icon']" :size="16" /> {{ $service['pillar'] }}</span>
                <h1 class="h-page" data-hero-item>{{ $service['headline'] }}</h1>
                <p class="lead-text" data-hero-item>{{ $service['lead'] }}</p>
                <div class="hero-actions" data-hero-item>
                    <button type="button" class="btn-p btn-p--ink btn-p--lg" data-book data-service="{{ $service['title'] }}">
                        Book a Free Consultation <span class="btn-arrow"><x-icon name="arrow-right" :size="18" /></span>
                    </button>
                    <a href="#pricing" class="btn-p btn-p--line btn-p--lg">See pricing</a>
                </div>
                <p class="hero-offer" data-hero-item><x-icon name="tag" :size="16" /> <span>Starting from <strong>${{ $service['from'] }}</strong> <small class="from-unit">{{ $service['from_unit'] ?? '' }}</small>@if (! empty($service['from_alt'])) <small class="from-alt">{{ $service['from_alt'] }}</small>@endif</span></p>
            </div>
            <div class="col-lg-5" data-hero-item>
                <div class="hero-photo">
                    <img src="{{ asset('assets/img/stock/'.$service['image'].'.webp') }}" width="940" height="627" alt="{{ $service['title'] }}" decoding="async" fetchpriority="high">
                    <span class="svc-ico svc-ico--float"><x-icon :name="$service['icon']" :size="26" /></span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section pt-0">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6" data-reveal="left">
                <span class="eyebrow">Overview</span>
                <h2 class="h-section">What is {{ $service['title'] }}?</h2>
                @foreach ($service['body'] as $para)
                    <p class="prose">{{ $para }}</p>
                @endforeach
            </div>
            <div class="col-lg-6" data-reveal="right">
                <div class="includes-card">
                    <h3>What's included</h3>
                    <ul class="check-list">
                        @foreach ($service['includes'] as $inc)
                            <li><x-icon name="check" :size="18" /> {{ $inc }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section--tint" id="pricing">
    <div class="container">
        @include('partials.section-head', [
            'eyebrow' => 'Pricing',
            'title' => $isCreative ? 'Creative work, <span class="accent">priced simply</span>' : $group['title'].' <span class="accent">packages</span>',
            'lead' => $isCreative ? 'Individual creative services you can order today — or ask for a custom quote for bigger branding projects.' : $group['intro'],
        ])

        @unless ($isCreative)
            @include('partials.pricing-cards', ['group' => $tab])
        @endunless

        @if (! empty($group['stack']) && ! $isCreative)
            <div class="stack-inline" data-reveal>
                @foreach ($group['stack'] as $name => $items)
                    <div><h4>{{ $name }}</h4><ul class="tags">@foreach ($items as $it)<li>{{ $it }}</li>@endforeach</ul></div>
                @endforeach
            </div>
        @endif

        @if (count($addons))
            <div class="addons" data-reveal>
                <h3>{{ $isCreative ? 'Creative add-ons' : $group['addons_title'] }}</h3>
                <ul class="addon-list">
                    @foreach ($addons as [$name, $price])
                        <li><button type="button" class="addon" data-book data-package="{{ $name }}" data-service="{{ $service['title'] }}"><span>{{ $name }}</span><i></i><strong>{{ $price }}</strong></button></li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($isCreative)
            <div class="custom-quote" data-reveal>
                <div>
                    <h3>Need a full brand or something bespoke?</h3>
                    <p>Tell us what you have in mind — we'll reply with a custom quote within 24 hours.</p>
                </div>
                <button type="button" class="btn-p btn-p--ink btn-p--lg" data-book data-service="Creative & Branding" data-package="Custom quote">Request a custom quote</button>
            </div>
        @endif
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                @include('partials.section-head', [
                    'eyebrow' => 'FAQ',
                    'title' => 'Good to <span class="accent">know</span>',
                    'lead' => 'Quick answers about '.strtolower($service['title']).'.',
                    'align' => 'left',
                ])
            </div>
            <div class="col-lg-8">
                @include('partials.faq', ['items' => $service['faqs'], 'uid' => 'svcFaq'])
            </div>
        </div>
    </div>
</section>

<section class="section section--tint">
    <div class="container">
        @include('partials.section-head', ['eyebrow' => 'Keep exploring', 'title' => 'More ways we <span class="accent">can help</span>'])
        <div class="row g-4" data-stagger>
            @foreach ($others as $s)
                <div class="col-md-4" data-reveal-item>
                    <a href="{{ route('service', $s['slug']) }}" class="svc-card">
                        <span class="svc-ico"><x-icon :name="$s['icon']" :size="26" /></span>
                        <span class="svc-tag">{{ $s['pillar'] }}</span>
                        <h3>{{ $s['title'] }}</h3>
                        <p>{{ $s['short'] }}</p>
                        <span class="svc-foot"><span>From <strong>${{ $s['from'] }}</strong> <small class="from-unit">{{ $s['from_unit'] ?? '' }}</small>@if (! empty($s['from_alt'])) <small class="from-alt">{{ $s['from_alt'] }}</small>@endif</span><span class="svc-go"><x-icon name="arrow-up-right" :size="18" /></span></span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
