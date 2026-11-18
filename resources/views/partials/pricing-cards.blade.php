{{--
  Pricing plan cards.
  $group   = key in config('progix.pricing')
  $limit   = optional: max features to show (home teaser)
--}}
@php
    $g = $site['pricing'][$group];
    $plans = $g['plans'];
    $cols = count($plans) === 2 ? 'row-cols-lg-2 plan-grid--2' : 'row-cols-lg-3';
@endphp
<div class="row g-4 {{ $cols }} row-cols-1 row-cols-md-2 plan-grid align-items-stretch" data-stagger>
    @foreach ($plans as $plan)
        @php
            $feat = $plan['features'];
            $shown = isset($limit) ? array_slice($feat, 0, $limit) : $feat;
            $more = count($feat) - count($shown);
            $cls = ! empty($plan['popular']) ? 'plan--popular' : (! empty($plan['premium']) ? 'plan--premium' : '');
            $pkgName = $plan['name'].(str_contains($plan['name'], 'Package') || $group !== 'social' ? '' : ' Package').' — '.$g['label'];
        @endphp
        <div class="col" data-reveal-item>
            <article class="plan {{ $cls }}">
                @if (! empty($plan['popular']))
                    <span class="plan-flag">{{ $plan['badge'] ?? 'Most popular' }}</span>
                @elseif (! empty($plan['premium']))
                    <span class="plan-flag plan-flag--gold">Premium</span>
                @endif
                <div class="plan-top">
                    <span class="plan-tier">{{ $plan['tier'] }}</span>
                    <h3>{{ $plan['name'] }}</h3>
                    <p class="plan-for">{{ $plan['for'] }}</p>
                </div>
                <div class="plan-price">
                    <span class="cur">$</span><span class="amt">{{ number_format($plan['price']) }}</span>
                    <span class="per">{{ $plan['per'] }}</span>
                </div>
                <p class="plan-note">{{ $plan['note'] }}</p>
                <ul class="plan-list">
                    @foreach ($shown as $f)
                        <li><x-icon name="check" :size="16" /> <span>{{ $f }}</span></li>
                    @endforeach
                </ul>
                @if ($more > 0)
                    <a href="{{ route('pricing') }}#{{ $group }}" class="plan-more">+ {{ $more }} more inclusions</a>
                @endif
                <div class="plan-cta">
                    <button type="button" class="btn-p {{ ! empty($plan['premium']) ? 'btn-p--gold' : (! empty($plan['popular']) ? 'btn-p--green' : 'btn-p--ink') }} w-100"
                            data-book data-package="{{ $pkgName }}" data-service="{{ collect($site['services'])->firstWhere('pricing_tab', $group)['title'] ?? ($group === 'care' ? 'Web Development' : '') }}">
                        Get started <span class="btn-arrow"><x-icon name="arrow-right" :size="16" /></span>
                    </button>
                </div>
            </article>
        </div>
    @endforeach
</div>
