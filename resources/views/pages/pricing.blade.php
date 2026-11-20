@extends('layouts.app')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => 'Pricing',
    'title' => 'Clear prices. <span class="accent">No surprises.</span>',
    'lead' => 'Pick a package, mix and match services, or ask for a custom quote. Every plan is flexible — and every price is what you see.',
])

<section class="section pt-0">
    <div class="container">
        <div class="tabs-bar" data-reveal>
            <div class="tabs" role="tablist" aria-label="Pricing categories" data-tabs>
                @foreach ($site['pricing'] as $key => $g)
                    <button type="button" class="tab {{ $loop->first ? 'is-active' : '' }}" role="tab" id="tab-{{ $key }}" aria-controls="panel-{{ $key }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}" data-tab="{{ $key }}">
                        <x-icon :name="$g['icon']" :size="18" /> {{ $g['label'] }}
                    </button>
                @endforeach
            </div>
        </div>

        @foreach ($site['pricing'] as $key => $g)
            <div class="tab-panel {{ $loop->first ? 'is-active' : '' }}" role="tabpanel" id="panel-{{ $key }}" aria-labelledby="tab-{{ $key }}" data-panel="{{ $key }}">
                <div class="panel-head">
                    <h2 class="h-section">{{ $g['title'] }}</h2>
                    <p class="lead-text">{{ $g['intro'] }}</p>
                </div>

                @include('partials.pricing-cards', ['group' => $key])

                @if (! empty($g['stack']))
                    <div class="stack-inline">
                        @foreach ($g['stack'] as $name => $items)
                            <div><h4>{{ $name }}</h4><ul class="tags">@foreach ($items as $it)<li>{{ $it }}</li>@endforeach</ul></div>
                        @endforeach
                    </div>
                @endif

                @if (! empty($g['addons']))
                    <div class="addons">
                        <h3>{{ $g['addons_title'] }}</h3>
                        <p>{{ $g['addons_intro'] }}</p>
                        <ul class="addon-list">
                            @foreach ($g['addons'] as [$name, $price])
                                <li><button type="button" class="addon" data-book data-package="{{ $name }}" data-service="{{ collect($site['services'])->firstWhere('pricing_tab', $key)['title'] ?? '' }}"><span>{{ $name }}</span><i></i><strong>{{ $price }}</strong></button></li>
                            @endforeach
                        </ul>
                    </div>
                @elseif (! empty($g['addons_intro']))
                    <p class="footnote">{{ $g['addons_intro'] }}</p>
                @endif

                @if ($key === 'ads')
                    <p class="footnote"><x-icon name="shield-check" :size="16" /> Ad spend is paid separately by you, directly to Meta or Google — you always own your ad accounts.</p>
                @endif
            </div>
        @endforeach
    </div>
</section>

@include('partials.pricing-table')

<section class="section section--tint">
    <div class="container">
        <div class="help-card" data-reveal="scale">
            <div>
                <span class="eyebrow">Not sure what you need?</span>
                <h2 class="h-section">Let's build your <span class="accent">perfect package</span></h2>
                <p>Tell us your goal and budget. We'll recommend the simplest plan to get you there — and it costs nothing to ask.</p>
            </div>
            <div class="help-actions">
                <button type="button" class="btn-p btn-p--ink btn-p--lg" data-book>Book a Free Consultation <span class="btn-arrow"><x-icon name="arrow-right" :size="18" /></span></button>
                <a href="{{ $wa }}" target="_blank" rel="noopener" class="btn-p btn-p--wa btn-p--lg"><x-icon name="whatsapp" :size="20" /> Ask on WhatsApp</a>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                @include('partials.section-head', ['eyebrow' => 'FAQ', 'title' => 'Pricing <span class="accent">questions</span>', 'align' => 'left'])
            </div>
            <div class="col-lg-8">
                @include('partials.faq', ['items' => array_slice($site['faqs'], 1, 5), 'uid' => 'priceFaq'])
            </div>
        </div>
    </div>
</section>
@endsection
