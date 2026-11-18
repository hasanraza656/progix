{{-- Final call-to-action band shown above the footer on most pages --}}
<section class="cta-band" aria-labelledby="ctaTitle">
    <div class="container">
        <div class="cta-card" data-reveal="scale">
            <div class="cta-dots" aria-hidden="true"></div>
            <div class="cta-copy">
                <span class="eyebrow eyebrow--gold">Free consultation</span>
                <h2 id="ctaTitle">Ready to <span class="accent">grow</span>? Send us your project.</h2>
                <p>Tell us what you need and get a clear scope and price within 24 hours. No pressure, no jargon — just honest advice.</p>
                <div class="cta-actions">
                    <button type="button" class="btn-p btn-p--green btn-p--lg" data-book>
                        Book a Free Consultation <span class="btn-arrow"><x-icon name="arrow-right" :size="18" /></span>
                    </button>
                    <a href="{{ $wa }}?text={{ rawurlencode('Hi Progix Digital, I would like a quote for my project.') }}" target="_blank" rel="noopener" class="btn-p btn-p--white-line btn-p--lg">
                        <x-icon name="whatsapp" :size="20" /> WhatsApp us
                    </a>
                </div>
            </div>
            <ul class="cta-points">
                <li><x-icon name="check" :size="18" /> Scope &amp; price in 24 hours</li>
                <li><x-icon name="check" :size="18" /> No long-term contracts</li>
                <li><x-icon name="check" :size="18" /> 5.0 rated on Upwork</li>
            </ul>
        </div>
    </div>
</section>
