{{--
  Static booking form: no backend. On submit the details are formatted into a
  WhatsApp message (and a mailto fallback / Calendly link when configured).
  $fid = unique id prefix for the form fields.
--}}
@php $fid = $fid ?? 'bf'; @endphp
<form class="booking-form" data-booking-form novalidate>
    <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;height:0;width:0;opacity:0">
    <div class="row g-3">
        <div class="col-md-6">
            <label for="{{ $fid }}-name" class="form-label">Full name <span aria-hidden="true">*</span></label>
            <input type="text" class="form-control" id="{{ $fid }}-name" name="name" autocomplete="name" placeholder="Your name" required>
            <div class="invalid-feedback">Please tell us your name.</div>
        </div>
        <div class="col-md-6">
            <label for="{{ $fid }}-phone" class="form-label">WhatsApp / phone <span aria-hidden="true">*</span></label>
            <input type="tel" class="form-control" id="{{ $fid }}-phone" name="phone" autocomplete="tel" placeholder="+1 555 000 0000" required>
            <div class="invalid-feedback">Enter a number we can reach you on.</div>
        </div>
        <div class="col-md-6">
            <label for="{{ $fid }}-email" class="form-label">Email</label>
            <input type="email" class="form-control" id="{{ $fid }}-email" name="email" autocomplete="email" placeholder="you@company.com">
            <div class="invalid-feedback">That email doesn't look right.</div>
        </div>
        <div class="col-md-6">
            <label for="{{ $fid }}-service" class="form-label">I'm interested in</label>
            <select class="form-select" id="{{ $fid }}-service" name="service">
                <option value="">Not sure yet — help me choose</option>
                @foreach ($site['services'] as $s)
                    <option value="{{ $s['title'] }}">{{ $s['title'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="{{ $fid }}-package" class="form-label">Package <span class="optional">(optional)</span></label>
            <input type="text" class="form-control" id="{{ $fid }}-package" name="package" placeholder="e.g. Growth Package">
        </div>
        <div class="col-md-6">
            <label for="{{ $fid }}-time" class="form-label">Best time to reach you</label>
            <select class="form-select" id="{{ $fid }}-time" name="time">
                <option value="Anytime">Anytime</option>
                <option>Morning</option>
                <option>Afternoon</option>
                <option>Evening</option>
            </select>
        </div>
        <div class="col-12">
            <label for="{{ $fid }}-msg" class="form-label">Tell us about your project</label>
            <textarea class="form-control" id="{{ $fid }}-msg" name="message" rows="3" placeholder="Goals, timeline, links — anything that helps us prepare."></textarea>
        </div>
    </div>

    <div class="booking-actions">
        <button type="submit" class="btn-p btn-p--green btn-p--lg">
            <x-icon name="whatsapp" :size="20" /> Send via WhatsApp
        </button>
        <p class="form-note"><x-icon name="shield-check" :size="16" /> We reply within 24 hours. Your details are only used to contact you.</p>
    </div>

    <div class="booking-success" hidden>
        <div class="success-ico"><x-icon name="check" :size="28" /></div>
        <h3>Almost there — your message is ready!</h3>
        <p>WhatsApp should have opened with your details filled in. Just press <strong>Send</strong> there. If it didn't open, use the buttons below.</p>
        <div class="success-actions">
            <a class="btn-p btn-p--wa" data-success-wa href="{{ $wa }}" target="_blank" rel="noopener"><x-icon name="whatsapp" :size="18" /> Open WhatsApp</a>
            <a class="btn-p btn-p--line" data-success-mail href="mailto:{{ $site['contact']['email'] }}"><x-icon name="mail" :size="18" /> Email instead</a>
            @if ($site['contact']['calendly'])
                <a class="btn-p btn-p--ink" href="{{ $site['contact']['calendly'] }}" target="_blank" rel="noopener"><x-icon name="calendar" :size="18" /> Pick a time</a>
            @endif
        </div>
    </div>
</form>
