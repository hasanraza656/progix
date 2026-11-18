@php $u = $site['upwork']; @endphp
<div class="reviews" data-slider>
    <div class="reviews-top">
        <div class="rating-box">
            <div class="rating-num">{{ $u['rating'] }}</div>
            <div>
                <div class="stars" role="img" aria-label="5 out of 5 stars">@for ($i = 0; $i < 5; $i++)<x-icon name="star" :size="18" />@endfor</div>
                <small>Verified client feedback on Upwork</small>
            </div>
        </div>
        <div class="slider-nav">
            <button type="button" class="icon-btn icon-btn--round" data-prev aria-label="Previous review"><x-icon name="chevron-left" :size="20" /></button>
            <button type="button" class="icon-btn icon-btn--round" data-next aria-label="Next review"><x-icon name="chevron-right" :size="20" /></button>
        </div>
    </div>

    <div class="slider-viewport" tabindex="0" aria-label="Client reviews">
        <div class="slider-track">
            @foreach ($site['testimonials'] as $t)
                <figure class="review {{ ! empty($t['featured']) ? 'review--lg' : '' }}">
                    <x-icon name="quote" :size="28" class="review-q" />
                    <div class="stars" aria-hidden="true">@for ($i = 0; $i < 5; $i++)<x-icon name="star" :size="16" />@endfor</div>
                    <blockquote>
                        <p>{{ $t['quote'] }}</p>
                    </blockquote>
                    <figcaption>
                        <span class="avatar" aria-hidden="true"><x-icon name="users" :size="18" /></span>
                        <span>
                            <strong>Verified Upwork client</strong>
                            <small>{{ $t['project'] }}</small>
                        </span>
                    </figcaption>
                    @if (! empty($t['tags']))
                        <ul class="tags">
                            @foreach ($t['tags'] as $tag)<li>{{ $tag }}</li>@endforeach
                        </ul>
                    @endif
                </figure>
            @endforeach
        </div>
    </div>
    <div class="slider-dots" data-dots-nav aria-hidden="true"></div>
</div>
