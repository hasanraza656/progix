{{-- $eyebrow, $title (HTML allowed), $lead, $align = center|left --}}
<div class="section-head {{ ($align ?? 'center') === 'left' ? 'section-head--left' : '' }}" data-reveal>
    @isset($eyebrow)<span class="eyebrow">{{ $eyebrow }}</span>@endisset
    <h2 class="h-section">{!! $title !!}</h2>
    @isset($lead)<p class="lead-text">{{ $lead }}</p>@endisset
</div>
