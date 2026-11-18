<div class="stats" data-stagger>
    @foreach ($site['stats'] as $s)
        <div class="stat" data-reveal-item>
            <div class="stat-num"><span data-count="{{ $s['value'] }}">{{ number_format($s['value']) }}</span>{{ $s['suffix'] }}</div>
            <div class="stat-label">{{ $s['label'] }}</div>
        </div>
    @endforeach
</div>
