@extends('layouts.app')

@section('content')
@php $c = $site['contact']; $tel = fn ($n) => preg_replace('/[^\d+]/', '', $n); @endphp
@include('partials.page-hero', [
    'eyebrow' => 'Contact us',
    'title' => 'Let’s talk about <span class="accent">your project</span>',
    'lead' => 'Book a free consultation, message us on WhatsApp or send the details below. We reply with a clear scope and price within 24 hours.',
])

<section class="section pt-0">
    <div class="container">
        <div class="row g-4 g-lg-5">
            <div class="col-lg-7" data-reveal="left">
                <div class="form-card">
                    <h2>Book a free consultation</h2>
                    <p class="muted">Share a few details and we'll continue the conversation on WhatsApp.</p>
                    @include('partials.booking-form', ['fid' => 'cf'])
                </div>
            </div>

            <div class="col-lg-5" data-reveal="right">
                <div class="contact-cards">
                    <a href="{{ $wa }}?text={{ rawurlencode('Hi Progix Digital, I would like to talk about a project.') }}" target="_blank" rel="noopener" class="contact-card contact-card--wa">
                        <span class="cc-ico"><x-icon name="whatsapp" :size="24" /></span>
                        <span><strong>Chat on WhatsApp</strong><small>Fastest way to reach us</small></span>
                        <x-icon name="arrow-up-right" :size="18" class="cc-go" />
                    </a>
                    <a href="tel:{{ $tel($c['phone_pk']) }}" class="contact-card">
                        <span class="cc-ico"><x-icon name="phone" :size="22" /></span>
                        <span><strong>{{ $c['phone_pk'] }}</strong><small>Pakistan{{ $c['phone_us'] ? '' : '' }}</small></span>
                        <x-icon name="arrow-up-right" :size="18" class="cc-go" />
                    </a>
                    @if ($c['phone_us'])
                        <a href="tel:{{ $tel($c['phone_us']) }}" class="contact-card">
                            <span class="cc-ico"><x-icon name="phone" :size="22" /></span>
                            <span><strong>{{ $c['phone_us'] }}</strong><small>United States</small></span>
                            <x-icon name="arrow-up-right" :size="18" class="cc-go" />
                        </a>
                    @endif
                    <a href="mailto:{{ $c['email'] }}" class="contact-card">
                        <span class="cc-ico"><x-icon name="mail" :size="22" /></span>
                        <span><strong>{{ $c['email'] }}</strong><small>We reply within 24 hours</small></span>
                        <x-icon name="arrow-up-right" :size="18" class="cc-go" />
                    </a>
                    <div class="contact-card contact-card--static">
                        <span class="cc-ico"><x-icon name="map-pin" :size="22" /></span>
                        <span><strong>{{ $c['address'] ?: 'Working hours' }}</strong><small>{{ $c['hours'] }}</small></span>
                    </div>
                    @if ($c['calendly'])
                        <a href="{{ $c['calendly'] }}" target="_blank" rel="noopener" class="contact-card">
                            <span class="cc-ico"><x-icon name="calendar" :size="22" /></span>
                            <span><strong>Pick a time on our calendar</strong><small>Schedule a free 30-minute call</small></span>
                            <x-icon name="arrow-up-right" :size="18" class="cc-go" />
                        </a>
                    @endif
                </div>

                <div class="expect-card">
                    <h3>What happens next?</h3>
                    <ol>
                        <li><span>1</span> We review your message the same day.</li>
                        <li><span>2</span> We reach out on WhatsApp to learn more.</li>
                        <li><span>3</span> You receive a scope and price within 24 hours.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section--tint">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                @include('partials.section-head', ['eyebrow' => 'FAQ', 'title' => 'Before you <span class="accent">reach out</span>', 'align' => 'left'])
            </div>
            <div class="col-lg-8">
                @include('partials.faq', ['items' => array_slice($site['faqs'], 0, 5), 'uid' => 'contactFaq'])
            </div>
        </div>
    </div>
</section>
@endsection
