{{-- Inner-page hero: $eyebrow, $title (HTML), $lead, breadcrumbs from $seo['crumbs'] --}}
<section class="page-hero">
    <div class="hero-dots" data-dots aria-hidden="true"></div>
    <div class="container">
        @if (! empty($seo['crumbs']))
            <nav aria-label="Breadcrumb" class="crumbs" data-hero-item>
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    @foreach ($seo['crumbs'] as [$label, $href])
                        <li>@if ($href)<a href="{{ $href }}">{{ $label }}</a>@else<span aria-current="page">{{ $label }}</span>@endif</li>
                    @endforeach
                </ol>
            </nav>
        @endif
        <div class="page-hero-copy">
            @isset($eyebrow)<span class="eyebrow" data-hero-item>{{ $eyebrow }}</span>@endisset
            <h1 class="h-page" data-hero-item>{!! $title !!}</h1>
            @isset($lead)<p class="lead-text" data-hero-item>{{ $lead }}</p>@endisset
            @isset($slot_actions)<div class="hero-actions" data-hero-item>{!! $slot_actions !!}</div>@endisset
        </div>
    </div>
</section>
