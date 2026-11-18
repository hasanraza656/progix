@extends('layouts.app')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => 'Insights',
    'title' => 'Ideas to help you <span class="accent">grow online</span>',
    'lead' => 'Practical, jargon-free guides on social media, advertising, SEO, web development and AI from the Progix Digital team.',
])

<section class="section pt-0">
    <div class="container">
        @if ($posts->isEmpty())
            <p class="text-center muted">New articles are coming soon.</p>
        @else
            @php $first = $posts->currentPage() === 1 ? $posts->first() : null; $rest = $first ? $posts->slice(1) : $posts; @endphp
            @if ($first)
                <article class="post-feature" data-reveal="scale">
                    <a href="{{ route('post', $first->slug) }}" class="post-feature-media" tabindex="-1" aria-hidden="true">
                        <img src="{{ $first->cover_url ?: asset('assets/img/brand/og-image.jpg') }}" width="940" height="627" alt="" decoding="async" fetchpriority="high">
                    </a>
                    <div class="post-feature-body">
                        <div class="post-meta">
                            @if ($first->category)<span class="chip chip--soft">{{ $first->category }}</span>@endif
                            <time datetime="{{ optional($first->published_at)->toDateString() }}">{{ optional($first->published_at)->format('M j, Y') }}</time>
                            <span>· {{ $first->read_minutes }} min read</span>
                        </div>
                        <h2><a href="{{ route('post', $first->slug) }}">{{ $first->title }}</a></h2>
                        <p>{{ $first->excerpt }}</p>
                        <a href="{{ route('post', $first->slug) }}" class="btn-p btn-p--ink">Read article <span class="btn-arrow"><x-icon name="arrow-right" :size="16" /></span></a>
                    </div>
                </article>
            @endif

            <div class="row g-4 mt-2" data-stagger>
                @foreach ($rest as $post)
                    <div class="col-md-6 col-lg-4">@include('partials.post-card', ['post' => $post])</div>
                @endforeach
            </div>

            @if ($posts->hasPages())
                <nav class="pager" aria-label="Pagination">
                    @if ($posts->previousPageUrl())<a class="btn-p btn-p--line" href="{{ $posts->previousPageUrl() }}" rel="prev">&larr; Newer</a>@endif
                    <span>Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</span>
                    @if ($posts->nextPageUrl())<a class="btn-p btn-p--line" href="{{ $posts->nextPageUrl() }}" rel="next">Older &rarr;</a>@endif
                </nav>
            @endif
        @endif
    </div>
</section>
@endsection