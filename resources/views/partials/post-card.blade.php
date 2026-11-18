{{-- $post (App\Models\Post) --}}
<article class="post-card" data-reveal-item>
    <a href="{{ route('post', $post->slug) }}" class="post-media" tabindex="-1" aria-hidden="true">
        <img src="{{ $post->cover_url ?: asset('assets/img/brand/og-image.jpg') }}" width="940" height="627" alt="" loading="lazy" decoding="async">
    </a>
    <div class="post-body">
        <div class="post-meta">
            @if ($post->category)<span class="chip chip--soft">{{ $post->category }}</span>@endif
            <time datetime="{{ optional($post->published_at)->toDateString() }}">{{ optional($post->published_at)->format('M j, Y') }}</time>
            <span>· {{ $post->read_minutes }} min read</span>
        </div>
        <h3><a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a></h3>
        <p>{{ $post->excerpt }}</p>
        <a href="{{ route('post', $post->slug) }}" class="link-arrow">Read article <x-icon name="arrow-right" :size="16" /></a>
    </div>
</article>