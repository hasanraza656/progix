{{-- Floating WhatsApp + back-to-top --}}
<div class="fab-wrap" id="fabWrap">
    <div class="fab-bubble" id="fabBubble" role="status" aria-live="polite" hidden>
        <button type="button" class="fab-close" aria-label="Dismiss" id="fabClose"><x-icon name="x" :size="14" /></button>
        <strong>Hi there 👋</strong>
        <span>Questions? Chat with us on WhatsApp — we reply fast.</span>
    </div>
    <button type="button" class="fab fab--top" id="toTop" aria-label="Back to top"><x-icon name="arrow-up" :size="20" /></button>
    <a href="{{ $wa }}?text={{ rawurlencode('Hi Progix Digital, I have a question about your services.') }}" class="fab fab--wa" target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp">
        <span class="fab-pulse" aria-hidden="true"></span>
        <x-icon name="whatsapp" :size="28" />
    </a>
</div>
