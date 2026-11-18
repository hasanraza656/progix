@extends('layouts.app')

@section('content')
@php $u = $site['upwork']; @endphp
@include('partials.page-hero', [
    'eyebrow' => 'Reviews & case studies',
    'title' => 'Real clients. <span class="accent">Real results.</span>',
    'lead' => 'Verified feedback from our Upwork profile and a closer look at the growth we deliver.',
])

<section class="section pt-0">
    <div class="container">
        <div class="upwork-strip" data-reveal>
            <div class="uw-badge"><x-icon name="award" :size="22" /> <span><strong>{{ $u['badge'] }}</strong><small>on Upwork</small></span></div>
            <ul>
                <li><strong>{{ $u['rating'] }}</strong><span>Average rating</span></li>
                <li><strong>{{ $u['success'] }}</strong><span>Job success</span></li>
                <li><strong>{{ $u['earnings'] }}</strong><span>Total earned</span></li>
                <li><strong>{{ $u['jobs'] }}</strong><span>Jobs completed</span></li>
                <li><strong>{{ $u['hours'] }}</strong><span>Hours worked</span></li>
            </ul>
            @if ($u['url'])
                <a href="{{ $u['url'] }}" target="_blank" rel="noopener" class="btn-p btn-p--line btn-p--sm">View profile <x-icon name="external" :size="14" /></a>
            @endif
        </div>

        <div class="review-wall" data-stagger>
            @foreach ($site['testimonials'] as $t)
                <figure class="review" data-reveal-item>
                    <x-icon name="quote" :size="26" class="review-q" />
                    <div class="stars" role="img" aria-label="5 out of 5 stars">@for ($i = 0; $i < 5; $i++)<x-icon name="star" :size="16" />@endfor</div>
                    <blockquote><p>{{ $t['quote'] }}</p></blockquote>
                    <figcaption>
                        <span class="avatar" aria-hidden="true"><x-icon name="users" :size="18" /></span>
                        <span><strong>Verified Upwork client</strong><small>{{ $t['project'] }}</small></span>
                    </figcaption>
                    @if (! empty($t['tags']))
                        <ul class="tags">@foreach ($t['tags'] as $tag)<li>{{ $tag }}</li>@endforeach</ul>
                    @endif
                </figure>
            @endforeach
        </div>
    </div>
</section>

<section class="section section--tint" id="case-studies">
    <div class="container">
        @include('partials.section-head', [
            'eyebrow' => 'Case studies',
            'title' => 'Growth stories, <span class="accent">in numbers</span>',
            'lead' => 'A look at how strategy, creativity and technology come together.',
        ])
        <div class="row g-4" data-stagger>
            @foreach ($site['projects'] as $p)
                <div class="col-md-6 col-lg-4">@include('partials.project-card', ['p' => $p])</div>
            @endforeach
        </div>
        @if ($site['draft_mode'])
            <p class="draft-note">Cards marked “Sample” are placeholder case studies — replace with real client results.</p>
        @endif
    </div>
</section>
@endsection
