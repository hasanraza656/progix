{{-- $p = case study --}}
<article class="project" data-reveal-item>
    <div class="project-media">
        <img src="{{ asset('assets/img/stock/'.$p['image'].'.webp') }}" width="940" height="627" alt="{{ $p['title'] }}" loading="lazy" decoding="async">
        <span class="chip">{{ $p['category'] }}</span>
        @if ($site['draft_mode'] && $p['sample'])
            <span class="chip chip--sample" title="Placeholder content — to be replaced with real client data">Sample</span>
        @endif
    </div>
    <div class="project-body">
        <h3>{{ $p['title'] }}</h3>
        <p>{{ $p['summary'] }}</p>
        <dl class="project-results">
            @foreach ($p['results'] as [$num, $label])
                <div><dt>{{ $num }}</dt><dd>{{ $label }}</dd></div>
            @endforeach
        </dl>
        <ul class="tags">
            @foreach ($p['services'] as $t)<li>{{ $t }}</li>@endforeach
        </ul>
    </div>
</article>
