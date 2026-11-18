@extends('layouts.app')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => 'Our services',
    'title' => 'One team for <span class="accent">marketing, web &amp; AI</span>',
    'lead' => 'Social media, paid ads, SEO content, custom websites, AI chatbots, automation and branding — everything your business needs to grow online, without juggling agencies.',
])

<section class="section pt-0">
    <div class="container">
        <div class="svc-list" data-stagger>
            @foreach ($site['services'] as $i => $s)
                <article class="svc-row" data-reveal-item id="{{ $s['slug'] }}">
                    <div class="svc-row-media">
                        <img src="{{ asset('assets/img/stock/'.$s['image'].'.webp') }}" width="940" height="627" alt="{{ $s['title'] }}" loading="lazy" decoding="async">
                        <span class="svc-ico svc-ico--float"><x-icon :name="$s['icon']" :size="26" /></span>
                    </div>
                    <div class="svc-row-body">
                        <span class="svc-tag">{{ $s['pillar'] }}</span>
                        <h2>{{ $s['title'] }}</h2>
                        <p>{{ $s['lead'] }}</p>
                        <ul class="check-list check-list--2">
                            @foreach (array_slice($s['includes'], 0, 4) as $inc)
                                <li><x-icon name="check" :size="18" /> {{ $inc }}</li>
                            @endforeach
                        </ul>
                        <div class="svc-row-foot">
                            <a href="{{ route('service', $s['slug']) }}" class="btn-p btn-p--ink">Learn more <span class="btn-arrow"><x-icon name="arrow-right" :size="16" /></span></a>
                            <span class="from">From <strong>${{ $s['from'] }}</strong></span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section section--tint">
    <div class="container">
        @include('partials.section-head', [
            'eyebrow' => 'Technology we use',
            'title' => 'Modern tools, <span class="accent">trusted by experts</span>',
            'lead' => 'We pick the right technology for your goals — not the other way round.',
        ])
        <div class="stack-grid" data-stagger>
            @foreach (array_merge($site['pricing']['web']['stack'], $site['pricing']['ai']['stack']) as $group => $items)
                <div class="stack-card" data-reveal-item>
                    <h3>{{ $group }}</h3>
                    <ul class="tags tags--lg">@foreach ($items as $it)<li>{{ $it }}</li>@endforeach</ul>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        @include('partials.section-head', [
            'eyebrow' => 'How it works',
            'title' => 'A simple process, <span class="accent">no surprises</span>',
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
@endsection
