@extends('layouts.app')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => 'Our clients',
    'title' => 'Trusted by brands <span class="accent">around the world</span>',
    'lead' => 'From global names to fast-growing startups, over 1,200 projects have been delivered across more than 37 industries. Here are some of the companies we\'ve worked with.',
])

<section class="section pt-0">
    <div class="container">
        <div class="client-grid" data-stagger>
            @foreach ($site['clients'] as $cl)
                <div class="client-tile" data-reveal-item>
                    <img src="{{ asset('assets/img/clients/'.$cl['file'].'.webp') }}" width="{{ $cl['w'] }}" height="{{ $cl['h'] }}" alt="{{ $cl['name'] }} logo" loading="lazy" decoding="async">
                </div>
            @endforeach
            <div class="client-tile client-tile--more" data-reveal-item>
                <strong>1,200+</strong>
                <span>and counting</span>
            </div>
        </div>
    </div>
</section>

<section class="section section--tint">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                @include('partials.section-head', [
                    'eyebrow' => 'By the numbers',
                    'title' => 'A decade of <span class="accent">delivering</span>',
                    'lead' => 'Consistent quality, project after project.',
                    'align' => 'left',
                ])
            </div>
            <div class="col-lg-7">@include('partials.stats')</div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        @include('partials.section-head', [
            'eyebrow' => 'Industries',
            'title' => 'We speak <span class="accent">your market\'s language</span>',
            'lead' => 'Every industry has its own audience, rules and rhythm. Here are a few of the 37+ niches we\'ve worked in.',
        ])
        <ul class="niche-cloud" data-stagger>
            @foreach ($site['niches'] as $n)
                <li data-reveal-item>{{ $n }}</li>
            @endforeach
        </ul>
        @if ($site['draft_mode'])
            <p class="draft-note">Industry list is a sample — to be confirmed with the client.</p>
        @endif
    </div>
</section>

<section class="section section--tint">
    <div class="container">
        @include('partials.section-head', ['eyebrow' => 'What clients say', 'title' => 'Five stars, <span class="accent">again and again</span>'])
        <div data-reveal>@include('partials.testimonial-slider')</div>
    </div>
</section>
@endsection
