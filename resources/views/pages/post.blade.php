@extends('layouts.app')

@section('content')
<section class="page-hero page-hero--post">
    <div class="hero-dots" data-dots aria-hidden="true"></div>
    <div class="container">
        <nav aria-label="Breadcrumb" class="crumbs" data-hero-item>
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('blog') }}">Insights</a></li>
                <li><span aria-current="page">{{ \Illuminate\Support\Str::limit($post->title, 40) }}</span></li>
            </ol>
        </nav>
        <div class="post-head">
            <div class="post-meta" data-hero-item>
                <span class="chip chip--soft">{{ $post->category }}</span>
                <time datetime="{{ optional($post->published_at)->toDateString() }}">{{ optional($post->published_at)->format('F j, Y') }}</time>
                <span>· {{ $post->read_minutes }} min read</span>
                @if ($post->updated_at && $post->updated_at->gt($post->published_at ?? $post->created_at))<span>· Last updated <time datetime="{{ $post->updated_at->toDateString() }}">{{ $post->updated_at->format('F j, Y') }}</time></span>@endif
            </div>
            <h1 class="h-page" data-hero-item>{{ $post->title }}</h1>
            <p class="lead-text" data-hero-item>{{ $post->excerpt }}</p>
            <div class="byline" data-hero-item>
                <img src="{{ asset('assets/img/brand/founder.webp') }}?v=3" width="52" height="52" alt="" class="byline-av">
                <span><strong>{{ $post->author_name ?: $site['founder']['name'] }}</strong><small>{{ $site['founder']['role'] }}, {{ $site['name'] }}</small></span>
            </div>
        </div>
    </div>
</section>

<section class="section pt-0">
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-lg-8">
                <figure class="post-cover" data-reveal="scale">
                    <img src="{{ $post->cover_url ?: asset('assets/img/brand/og-image.jpg') }}" width="940" height="627" alt="{{ $post->cover_alt ?: $post->title }}" decoding="async" fetchpriority="high">
                </figure>

                <div class="article" data-reveal>{!! $post->content !!}</div>

                <div class="article-cta" data-reveal>
                    <h3>Want help putting this into practice?</h3>
                    <p>Book a free consultation and we'll map out the next steps for your business.</p>
                    <button type="button" class="btn-p btn-p--green" data-book>Book a Free Consultation <span class="btn-arrow"><x-icon name="arrow-right" :size="16" /></span></button>
                </div>
            </div>

            <aside class="col-lg-4">
                <div class="side-sticky">
                    <div class="side-card" data-reveal="right">
                        <h3>Share this article</h3>
                        <div class="share">
                            <a href="https://wa.me/?text={{ rawurlencode($post->title.' '.url()->current()) }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><x-icon name="whatsapp" :size="18" /></a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ rawurlencode(url()->current()) }}" target="_blank" rel="noopener" aria-label="Share on LinkedIn"><x-icon name="linkedin" :size="18" /></a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode(url()->current()) }}" target="_blank" rel="noopener" aria-label="Share on Facebook"><x-icon name="facebook" :size="18" /></a>
                        </div>
                    </div>
                    <div class="side-card side-card--dark" data-reveal="right">
                        <h3>Get a free quote</h3>
                        <p>Send your project and get a scope and price within 24 hours.</p>
                        <button type="button" class="btn-p btn-p--green w-100" data-book>Book a Free Call</button>
                        <a href="{{ $wa }}" target="_blank" rel="noopener" class="btn-p btn-p--white-line w-100 mt-2"><x-icon name="whatsapp" :size="18" /> WhatsApp us</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<section class="section section--tint">
    <div class="container">
        @include('partials.section-head', ['eyebrow' => 'Keep reading', 'title' => 'More <span class="accent">insights</span>'])
        <div class="row g-4" data-stagger>
            @foreach ($related as $post)
                <div class="col-md-6 col-lg-4">@include('partials.post-card', ['post' => $post])</div>
            @endforeach
        </div>
    </div>
</section>
@endsection
