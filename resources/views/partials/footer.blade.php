@php $c = $site['contact']; $tel = fn ($n) => preg_replace('/[^\d+]/', '', $n); @endphp

@unless (in_array(Route::currentRouteName(), ['contact', 'home3']))
    @include('partials.cta-band')
@endunless

<footer class="site-footer">
    <div class="container">
        <div class="row g-5 footer-top">
            <div class="col-lg-4">
                <a href="{{ route('home') }}" class="brand" aria-label="{{ $site['name'] }}">
                    <img src="{{ asset('assets/img/brand/logo-light.webp') }}" width="1033" height="309" alt="{{ $site['name'] }}" class="brand-logo brand-logo--lg" loading="lazy">
                </a>
                <p class="footer-blurb">{{ $site['tagline'] }} Marketing, technology and automation for businesses that want to grow — under one roof.</p>
                <div class="socials">
                    @foreach ($site['social'] as $s)
                        @if ($s['url'])
                            <a href="{{ $s['url'] }}" target="_blank" rel="noopener" aria-label="{{ $s['name'] }}"><x-icon :name="$s['icon']" :size="18" /></a>
                        @endif
                    @endforeach
                    <a href="{{ $wa }}" target="_blank" rel="noopener" aria-label="WhatsApp"><x-icon name="whatsapp" :size="18" /></a>
                </div>
            </div>

            <div class="col-6 col-lg-2 offset-lg-1">
                <h3 class="footer-h">Services</h3>
                <ul class="footer-links">
                    @foreach ($site['services'] as $s)
                        <li><a href="{{ route('service', $s['slug']) }}">{{ $s['title'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h3 class="footer-h">Company</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('about') }}">About us</a></li>
                    <li><a href="{{ route('pricing') }}">Pricing</a></li>
                    <li><a href="{{ route('clients') }}">Clients</a></li>
                    <li><a href="{{ route('testimonials') }}">Reviews &amp; case studies</a></li>
                    <li><a href="{{ route('blog') }}">Insights</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-3">
                <h3 class="footer-h">Get in touch</h3>
                <ul class="footer-contact">
                    <li><x-icon name="phone" :size="18" /> <a href="tel:{{ $tel($c['phone_pk']) }}">{{ $c['phone_pk'] }}</a></li>
                    @if ($c['phone_us'])
                        <li><x-icon name="phone" :size="18" /> <a href="tel:{{ $tel($c['phone_us']) }}">{{ $c['phone_us'] }}</a> <em>(US)</em></li>
                    @endif
                    <li><x-icon name="mail" :size="18" /> <a href="mailto:{{ $c['email'] }}">{{ $c['email'] }}</a></li>
                    @if ($c['address'])
                        <li><x-icon name="map-pin" :size="18" /> <span>{{ $c['address'] }}</span></li>
                    @endif
                    <li><x-icon name="globe" :size="18" /> <span>{{ $site['service_area'] }}@if (! empty($site['location']['city']) || ! empty($site['location']['country'])) · Based in {{ collect([$site['location']['city'], $site['location']['country']])->filter()->implode(', ') }}@endif</span></li>
                    <li><x-icon name="clock" :size="18" /> <span>{{ $c['hours'] }}</span></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ $site['name'] }}. All rights reserved.</p>
            <ul>
                <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                <li><a href="{{ route('terms') }}">Terms of Service</a></li>
                <li><a href="{{ route('sitemap') }}">Sitemap</a></li>
            </ul>
        </div>
    </div>
</footer>
