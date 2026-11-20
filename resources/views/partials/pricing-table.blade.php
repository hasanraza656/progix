{{-- Plain HTML comparison tables: easy for search engines and AI assistants to read --}}
<section class="section section--tint" id="compare" aria-labelledby="compareTitle">
    <div class="container">
        <div class="section-head" style="text-align:left;max-width:720px;margin-inline:0">
            <span class="eyebrow">At a glance</span>
            <h2 class="h-section" id="compareTitle">Compare <span class="accent">all packages</span></h2>
            <p class="lead-text">Every Progix Digital package with its price, billing type and what is included. Prices are in US dollars.</p>
        </div>

        @foreach ($site['pricing'] as $key => $g)
            <div class="cmp-block">
                <h3 class="cmp-title">{{ $g['title'] }}</h3>
                <div class="cmp-wrap" tabindex="0" role="region" aria-label="{{ $g['title'] }} price comparison">
                    <table class="cmp">
                        <caption class="visually-hidden">{{ $g['title'] }} packages and prices</caption>
                        <thead>
                            <tr><th scope="col">Package</th><th scope="col">Price (USD)</th><th scope="col">Billing</th><th scope="col">Best for</th><th scope="col">Main inclusions</th></tr>
                        </thead>
                        <tbody>
                        @foreach ($g['plans'] as $plan)
                            <tr>
                                <th scope="row">{{ $plan['name'] }}@if (! empty($plan['popular']))<span class="cmp-badge">Popular</span>@endif</th>
                                <td class="cmp-price">${{ number_format($plan['price']) }}</td>
                                <td>{{ ltrim($plan['per'], '/ ') === 'month' ? 'Monthly' : ucfirst(ltrim($plan['per'], '/ ')) }}</td>
                                <td>{{ $plan['for'] ?? ($plan['note'] ?? '') }}</td>
                                <td>{{ collect($plan['features'] ?? [])->take(3)->implode(' · ') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
        <p class="footnote" style="margin-top:8px">Need something custom? <a href="{{ route('contact') }}">Request a quote</a> — we reply within 24 hours.</p>
    </div>
</section>
